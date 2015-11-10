<?php

class CartController extends ShopBaseController 
{

    public $product_type =  array('product' => 0,'tab' => 1, 'zine' => 2);

    /**
     * 购物车页面
     */
    public function actionIndex()
    {
        $viewData = array();
        $userId = $this->user_id;
        if(empty($userId)){
            $this->redirect('/public/login');
        }

        $plist = Cart::model()->getCartList($userId);
//        echo "<pre>";
//        print_r($plist);
//        print_r($couponlist);
//        exit;
        $viewData['list']       = $plist['list'];
        $viewData['total']      = $plist['total'];
        $this->render('cart/index',$viewData);
    }


    /**
     * 订单确认页面
     */
    public function actionCheckout()
    {
        $userId = $this->user_id;
        if(empty($userId)){
            $this->redirect('/user/login');
        }

        $addList = Address::model()->getUserAddressList($userId);
        $payList = Payment::model()->getPaymentList();
        $plist  = Cart::model()->getCartList($userId);
        $couponlist = Coupon::model()->getUserUsingCouponList($userId);

        if(empty($plist['list'])){
            $this->redirect('/?from=no_deal');
        }
        $viewData = array();
        $viewData['addList']    = $addList;
        $viewData['list']       = $plist['list'];
        $viewData['total']      = $plist['total'];
        $viewData['couponlist'] = $couponlist;
        $viewData['payList']    = $payList;
        $this->render('cart/checkout',$viewData);
    }

    /**
     * 生成最后的订单 (订单展示页面)
     */


    public function actionMiniCart()
    {
        $result = array('flag' => '1','data'=>array());
        try{
            $userId = $this->user_id;
            if(empty($userId)){
                throw new exception('用户未登录',2);
            }
            $data = Cart::model()->getCartList($userId);
            $result['data'] = $data;
        }catch(exception $e){
            $result['flag'] = 0;
            $result['data'] = $e->getMessage();
        }
        exit(json_encode($result));
    }

    /**
     * 添加到购物车
     */
    public function  actionAddCart()
    {
        $request = $_REQUEST;
        $request['num'] 	= intval($request['num']);
        $request['num'] 	= empty($request['num']) ? 1 : $request['num'];
        $request['id']		= intval($request['id']);
        $request['size'] 	= intval($request['size']);
        $request['buynow'] 	= intval($request['buynow']);
        $request['type'] 	= isset($request['type']) ? $request['type'] :'product';
        $time = time();

        $res = array(); //返回的数据结构
        $res['status'] 	= '1';
        $res['msg'] 	= '';
        $res['buynow'] 	= $request['buynow'];

        $userId = $this->user_id;
        $transcation = Yii::app()->shop->beginTransaction();
        //添加到购车前的检查
        try{
            if(empty($userId)){ //当前用户(登陆)的id
                throw new exception('用户还没有登陆！',2);
            }

            if($request['type'] == 'product'){
                $pInfo = Product::model()->getProductInfoById($request['id'],'all');//商品详情
            } elseif($request['type'] == 'tab') {
                $pInfo = Tab::model()->findByPk($request['id']);
            } elseif($request['type'] == 'zine') {
                $pInfo = Zine::model()->findByPk($request['id']);
            }
            //print_r($pInfo);exit;

            $this->checkAddToCartBefore($request,$pInfo);

            //插入或更细购物车表
            $map = array();
            $map['user_id'] 	= $userId;
            $map['product_id'] 	= $request['id'];
            $map['size_id'] 	= $request['size'];
            $map['type'] 		= $this->product_type[$request['type']];
            $cartInfo = Cart::model()->findByAttributes($map);

            if(empty($cartInfo)){
                $m = new Cart();
                $m->user_id 		= $userId ;
                $m->product_id 		= $request['id'];
                $m->type 			= $this->product_type[$request['type']];
                $m->size_id 		= $request['size'];
                $m->shop_price 		= $pInfo['sell_price'];
                $m->sell_price 		= $pInfo['sell_price'];
                $m->quantity 		= $request['num'];
                $m->add_time 		= $time;
                $m->update_time 	= $time;
                $m->is_pay 			= isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
                $m->save();
            }else{
                //若立即购买的P在购物车中已经存在
                $cartInfo->quantity 	+= $request['num'];
                $cartInfo->is_pay       = isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
                $cartInfo->update_time  = $time;
                $cartInfo->save();
            }
            $transcation->commit();
        }catch(exception $e){
            $transcation->rollBack();
            $res['status']  = $e->getCode();
            $res['msg']     = $e->getMessage();
//            if(!in_array($res['status'],array(2,500))){
//                $res['status'] = 0;
//                $res['msg'] = '添加购物车失败，请重试！';
//            }
        }
        exit(json_encode($res));
    }

    /**
     * 检查商品是否有误
     * @param $request
     * @param $pInfo
     * @return bool
     * @throws exception
     */
    protected function checkAddToCartBefore($request,$pInfo)
    {
        if(empty($pInfo)){ throw new exception('商品出现错误！'); }
        if ($request['type'] == 'tab' || $request['type'] == 'zine') {
            $productName = $request['type'] == 'tab' ? '谱子' : '杂志';
            if($pInfo['sell_price'] <= 0){
                throw new exception('该'.$productName.'不用付费',500);
            } elseif(empty($pInfo['quantity'])) {
                throw new exception('该'.$productName.'已经没有库存了',500);
            }
        }  else {
            $size_id = $request['size'];
            if(!empty($pInfo['sizes'])){
                if(empty($size_id)){  //没有选择商品尺寸
                    throw new exception('请选择商品尺寸！',500);
                }elseif(!isset($pInfo['sizes'][$size_id])){ //选择的商品尺寸错误
                    throw new exception('商品出现错误！',500);
                }
            }

            if($pInfo['is_multiple'] == 0){
                if($request['num'] > $pInfo['quantity']){
                    throw new exception('商品库存不足了！',500);
                }
            }else {
                if($pInfo['sizes'][$size_id]['quantity'] < $request['num']){
                    throw new exception('商品库存不足了！',500);
                }
            }
        }
        return true;
    }

    /**
    +
     * 从购物车删除商品数据
    +
     */
    public function actionDelCart(){
        $res = array(); //返回的数据结构
        $res['status'] = '1';
        $res['msg'] = '';

        $userId = $this->user_id;
        try{
            $cid	= intval($_REQUEST['id']);
            if(empty($userId)){ //当前用户(登陆)的id
                throw new exception('用户还没有登陆',2);
            }elseif (empty($cid)) {
                throw new exception('数据错误刷新页面重试',500);
            }

            $info = Cart::model()->findByPk($cid);
            if(!empty($info) && $info->user_id !== $userId){
                throw new exception('数据错误刷新页面重试',500);
            }
            if(!empty($info)){
                $flag = Cart::model()->deleteByPk($cid);
                if(empty($flag)){
                    throw new exception('数据错误刷新页面重试',500);
                }
            }
        } catch (exception $e){
            $res['status']  = $e->getCode();
            $res['msg']     = $e->getMessage();
            if(!in_array($res['status'],array(2,500))){
                $res['status'] = 0;
                $res['msg'] = '添加购物车失败，请重试！';
            }
        }

        exit(json_encode($res));
    }


    /**
     * 更新购物车的商品的数量
     */
    public function actionUpCartNum(){
        $res = array();
        $res['status'] = 1;

        $id 	= intval($_REQUEST['id']);
        $number = intval($_REQUEST['num']);
        $action = $_REQUEST['action']; //edit(直接修改) reduse(减) plus(加)
        $action = empty($action) ? 'plus' :$action;

        try{
            $info = Cart::model()->findByPk($id);
            if(empty($id)) {
                throw new exception('id不能为空！');
            }elseif ($action == 'edit' && empty($number)) {
                throw new exception('商品个数不能为0！');
            } elseif($action == 'reduse' && $info['quantity'] <=1) {
                throw new exception('已经不能再少了！');
            }elseif(empty($info)){
                throw new exception('修改失败！');
            }

            $pInfo = Cart::model()->getCartProductInfoByProductId($info['product_id'],$info['type']);
            //print_r($pInfo);exit;
            if($action == 'edit'){
                $info->quantity = $number;
                $this->checkProductQuantity($info,$pInfo,$number);
            }elseif($action == 'reduse'){
                $info->quantity -= 1;
            }else{
                $info->quantity += 1;
                $this->checkProductQuantity($info,$pInfo,$info->quantity);
            }
            $flag = $info->save();

        } catch (exception $e) {
            $res['status'] = 0 ;
            $res['msg'] = $e->getMessage();
            exit(json_encode($res));
        }

        $res['id'] = $id;
        $res['msg'] ='修改成功！';
        exit(json_encode($res));
    }

    /**
     * 绑定优惠券到用户的账户中
     */
    public function actionCouponBand()
    {
        $res = array();
        $res['status'] = 1;
        $userId = $this->user_id;
        try{
            $sn = trim($_REQUEST['sn']);
            if(empty($userId)){
                throw new Exception("当前用户未登陆！", 2);
            }elseif(empty($sn)){
                throw new Exception("优惠券编码不能为空！",500);
            }
            $map = array();
            $map['coupon_sn'] = $sn;
            $info = Coupon::model()->findByAttributes($map);

            if(empty($info)){
                throw new Exception("优惠券不存在！",500);
            }elseif(!empty($info['user_id']) || !empty($info['band_time'])){
                throw new Exception("优惠券已经绑定了！",500);
            }elseif (!empty($info['use_time']) || !empty($info['order_id'])) {
                throw new Exception("优惠券已经使用了！",500);
            } elseif ($info['end_time'] < time()){
                throw new Exception("优惠券已经过期了！",500);
            }
            $info->user_id = $userId;
            $info->band_time = time();
            $flag = $info->save();
            if(empty($flag)){
                throw new Exception("优惠券绑定失败，请重试！",500);
            }   
        } catch (exception $e){
            $res['status']  = $e->getCode();
            $res['msg']     = $e->getMessage();
            if(!in_array($res['status'],array(2,500))){
                $res['status'] = 0;
                $res['msg'] = '优惠券绑定失败，请重试！';
            }
        }
        exit(json_encode($res));
    }


    //更新购物车数量时的校验
    protected function checkProductQuantity($cartInfo,$pInfo,$num)
    {
        if($cartInfo['type'] == 1 || $cartInfo['type'] == 2){
            if($num > $pInfo['quantity']){
                throw new exception('库存不足了！');
            }
        } else {
            if($pInfo['is_multiple'] == 0){
                if($num > $pInfo['quantity']){
                    throw new exception('库存不足了！');
                }
            }else {
                $size_id = $cartInfo['size_id'];
                if(empty($size_id) || !isset($pInfo['sizes'][$size_id]['quantity'])){
                    throw new exception('商品尺寸错误，请将商品从购物车删除，再重新添加！');
                }
                if($pInfo['sizes'][$size_id]['quantity'] < $num){
                    throw new exception('库存不足了！');
                }
            }
        }
        return false;
    }


    /**
     * 生成订单
     * @time 2014-05-25 mwq2020
     */
    public function actionCreateOrder()
    {
        $request = $_REQUEST;
        $res = array();
        $res['status'] 	= 1;
        $res['msg'] 	= '';
        $res['ordersn'] = '';

        $userId = $this->user_id;
        $transaction = Yii::app()->shop->beginTransaction();
        try{
            if(empty($userId)){
                throw new exception('用户未登录',2);
            }

            $oInfo 	= Cart::model()->createOrder($userId,$request);				//购物车物品的详细情况
            $res['ordersn'] = $oInfo['ordersn'];//返回动态显示订单成功页面信息
            $transaction->commit();
        }catch(exception $e){
            $transaction->rollback();
            $res['status'] = 0;
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }


    //订单付款跳转
    public function actionPayreDirect(){
        if(empty($this->userid)){ exit; }

        $id = intval($_GET['id']);
        if($id <= 0){ return false; }

        //查询订单信息
        $list = $this->selectOrder($id);
        if(empty($list) || $list['paystatus'] != 0){
            $this->redirect('./');
        }
        $time = time();
        if(($time - $list['createat']) >= self::MAX_TIME_ORDER){
            $this->overOrder($id);//更新订单为已过期
            $this->redirect('./');
        }

        $list['limittime'] = floor(($list['createat']+ self::MAX_TIME_ORDER - $time)/60);
        $list['payamount'] = $list['orderamount'] + $list['freight'];
        if($list['paycode'] == 'tenpay')
        {
            Vendor('tenpay.tenpay#class' );
            $payObj = new tenpay();
            $payonline = $payObj->get_code($list,'btns com-btn');

        }elseif($list['paycode'] == 'alipay'){
            //生成支付代码
            $paycode = 'alipay';
            import('@.Util.Payment.'.$paycode);
            $payobj    = new $paycode;
            $payonline = $payobj->get_code($list, 'btns com-btn');
        }elseif($list['paycode'] == 'kuaiqian'){
            Vendor('kuaiqian.kuaiqian#class' );
            $payObj = new kuaiqian();
            $payonline = $payObj->get_code($list,'btns com-btn');
            //echo $payonline;exit;
        }else{
            Vendor('kuaiqian.kuaiqian#class' );
            $payObj = new kuaiqian();
            $payonline = $payObj->get_code($list,'btns com-btn',10,$list['paycode']);
        }
        header("Location:".$payonline);
    }


    //保存或者新加收货地址 -- 迁移至User下
    public function actionSaveAddress(){
    }





    /**
     *使用优惠券时 （绑定优惠券、计算优惠券金额）
     */
    public function actionCheckCoupon(){
        $res = array();
        $res['status'] = 1;
        $res['msg'] = '';

        $sn = addslashes(trim($_REQUEST['sn']));
        $userId = $this->user_id;
        try{
            if(empty($userId)){
                throw new Exception("用户还没有登陆，请登录！",2);
            }
            $map = array();
            $map['coupon_sn'] = $sn;
            $info = Coupon::model()->findByAttributes($map);
            if(empty($info)){
                $map = array();
                $map['coupon_sn'] = $sn;
                $info = CouponType::model()->findByAttributes($map);
                if(empty($info)){
                    throw new Exception("优惠券错误，该券号不存在！", 0);
                }
            }else{
                if($info['end_time'] < time()) {
                    throw new Exception("优惠券已过期！", 0);
                } elseif (empty($info['user_id']) && empty($info['order_id'])){
                    $info->user_id 	    = $userId;
                    $info->band_time 	= time();
                    $flag = $info->save();
                    if(empty($flag)){
                        throw new Exception("优惠券绑定失败,请重试！", 0);
                    }
                } elseif ($info['user_id'] != $userId || !empty($info['order_id']) ) {
                    throw new Exception("优惠券已使用或者异常！", 0);
                } elseif ($info['start_time'] > time()){
                    throw new Exception("优惠券还未到使用日期！", 0);
                }
            }

            $list = Cart::model()->getCartList($userId);
            if(empty($list['list'])){
                throw new Exception("购物车不能为空！", 0);
            }
            $productAmount = $list['total']['product_amount'];
            if((!empty($productAmount) && $productAmount >= $info['satisfied_amount']) || empty($info['satisfied_amount'])){
                $finialAmount = $list['total']['product_amount'] + $list['total']['shipping_fee'] - $info['coupon_amount'];
                $res['couponsn'] 		= $info['coupon_sn'];
                $res['couponAmount'] 	= $info['coupon_amount'];
                $res['shipingFee'] 		= $list['total']['shipping_fee'];
                $res['finalAmount'] 	= $finialAmount < 0 ? 0 : $finialAmount ;
            }elseif($productAmount < $info['satisfied_amount']){
                throw new Exception("优惠券不满足使用条件！", 0);
            }

            //html列表
            $couponlist = Coupon::model()->getUserUsingCouponList($userId);
            $res['couponlist'] = $couponlist;
            $res['userId'] = $userId;
        }catch(exception $e){
            $res['status'] = $e->getCode();
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }

    //获取商品的免运费限额
    protected function getFreeShippingAmount()
    {
        $m = M('ShopConfig');
        $map = array();
        $map['attribute'] = 'FREE_SHIP_AMOUNT';
        $info = $m->where($map)->find();
        if(empty($info)){
            return 200;
        }
        return $info['value'];
    }


    


    //保存用户的最后地址信息为默认信息
    protected function saveUserLastAddressDefault($addid){
        $userid = $this->userid;
        if(empty($addid) || empty($userid)){return false;}

        $m = M('Address');
        $m->where('id='.$addid)->setField('is_default','1');

        $data = array();
        $data['is_default'] = 0;
        $m->where('user_id = '.$userid .' and id != '.$addid)->save($data);
        return true;
    }

    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>以下是手机用的接口<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
    //获取购物车列表
    public function mobile_get_cart_list(){
        $this->mobile_check_token();
        $userId = $this->userid;
        try{
            if(empty($userId)){
                throw new Exception('您还没有登陆！');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->ajaxReturn('',$error,2);
        }
        $plist = $this->getCartList();
        if($plist['list']){
            foreach($plist['list'] as &$row){
                unset($row['pInfo']['detail']);
            }
        }
        $this->ajaxReturn($plist,'',1);
    }

    //添加到购物车
    public function mobile_add_cart(){
        $this->mobile_check_token();
        $userId = $this->userid;
        try{
            if(empty($userId)){
                throw new Exception('您还没有登陆！');
            }
            $request = $_REQUEST;
            $request['num'] 	= intval($request['num']);
            $request['num'] 	= empty($request['num']) ? 1 : $request['num'];
            $request['id']		= intval($request['id']);
            $request['size'] 	= intval($request['size']);
            $request['buynow'] 	= intval($request['buynow']);
            $time = time();
            $res['buynow'] 	= $request['buynow'];

            $m = $this->cart;
            $pInfo = $this->product->getProductInfo($request['id']);//商品详情
            //添加到购车前的检查
            $this->checkAddToCartBefore($request,$pInfo);

            //插入购物车表
            $map = array();
            $map['user_id'] 	= $userId;
            $map['product_id'] 	= $request['id'];
            $map['size_id'] 	= $request['size'];
            $cartInfo = $m->where($map)->find();
            $this->cart->startTrans();
            if(empty($cartInfo)){
                $m->user_id 		= $this->userid ;
                $m->product_id 		= $request['id'];
                $m->size_id 		= $request['size'];
                $m->shop_price 		= $pInfo['sell_price'];
                $m->sell_price 		= $pInfo['sell_price'];
                $m->quantity 		= $request['num'];
                $m->add_time 		= $time;
                $m->update_time 	= $time;
                $m->is_pay 			= isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
                $result = $m->add();
            }else{
                //若立即购买的P在购物车中已经存在
                $cartInfo['quantity'] 	+= $request['num'];
                $cartInfo['is_pay'] = isset($request['buynow'])&&(!empty($request['buynow'])) ? 1 : 0;
                $cartInfo['update_time']  = $time;
                $m->save($cartInfo);
            }

            if (empty($result)){
                throw new Exception('添加购物车失败，请重试！');
            }
            $m->commit();// 提交事务
        } catch (Exception $e) {
            $m->rollback();// 事务回滚
            $error = $e->getMessage();
            $this->ajaxReturn('',$error,2);
        }
        $message = '添加成功！';
        $this->ajaxReturn($message,'',1);
    }

    public function mobile_edit_cart(){
        $this->mobile_check_token();
        try{
            $userId = $this->userid;
            if(empty($userId)){
                throw new Exception('您还没有登陆！');
            }

            $id 	= intval($_REQUEST['id']);
            $number = intval($_REQUEST['num']);
            $action = $_REQUEST['action']; //edit(直接修改) reduse(减) plus(加)
            $action = empty($action) ? 'plus' :$action;

            $info = $this->cart->find($id);
            if(empty($id)) {
                throw new exception('id不能为空！');
            }elseif ($action == 'edit' && empty($number)) {
                throw new exception('商品个数不能为0！');
            } elseif($action == 'reduse' && $info['quantity'] <=1) {
                throw new exception('已经不能再少了！');
            }elseif(empty($info)){
                throw new exception('修改失败！');
            }

            $pInfo = $this->product->getProductInfo($info['product_id']);
            if($action == 'edit'){
                $editNum =  $number;
                $this->checkProductQuantity($info,$pInfo,$editNum);
            }elseif($action == 'reduse'){
                $editNum =  $this->cart->quantity-1;
            }else{
                $editNum =  $this->cart->quantity+1;
                $this->checkProductQuantity($info,$pInfo,$editNum);
            }

            $this->cart->quantity = $editNum;
            $flag = $this->cart->save();
        } catch (exception $e) {
            $message = '修改失败【'.$e->getMessage().'】！';
            $this->ajaxReturn($message,'',2);
        }
        $message = '修改数量成功！';
        $this->ajaxReturn($message,'',1);
    }

    public function mobile_del_cart(){;
        $this->mobile_check_token();
        $userId = $this->userid;
        $cid	= intval($_REQUEST['id']);
        if(empty($userId)){ //当前用户(登陆)的id
            $message = '用户还没有登陆！';
            $this->ajaxReturn($message,'',2);
        }elseif (empty($cid)) {
            $message = '数据错误刷新页面重试！';
            $this->ajaxReturn($message,'',2);
        }

        $flag = $this->cart->where('id='.$cid)->delete();
        if(empty($flag)){
            $message = '删除失败！';
            $this->ajaxReturn($message,'',2);
        }
        $message = '删除成功！';
        $this->ajaxReturn($message,'',1);
    }

    public function mobile_get_coupon_list(){
        $this->mobile_check_token();
        $userId =  $this->userid;
        if(empty($userId)){return false;}

        $m = M('Coupon a');
        $map = array();
        $map['a.user_id'] = $userId;
        $map['a.start_time'] = array('lt',time());
        $map['a.end_time'] = array('gt',time());
        $map['a.order_id'] = 0;
        $map['a.use_time'] = 0;
        $list 	= $m->join('bg_coupon_type b ON a.coupon_type_id=b.id')->where($map)->field('a.*,b.coupon_name')->select();
        $this->ajaxReturn($list,'',1);
    }

    public function mobile_coupon_band() {
        $this->mobile_check_token();
        $userId = $this->userid;
        $sn = trim($_REQUEST['sn']);
        try{
            if(empty($userId)){
                throw new Exception('当前用户未登陆');
            }elseif(empty($sn)){
                throw new Exception('优惠券编码不能为空');
            }

            $m = M('Coupon');
            $map = array();
            $map['coupon_sn'] = $sn;
            $info = $m->where($map)->find();

            if(empty($info)){
                throw new Exception('优惠券不存在');
            }elseif(!empty($info['user_id']) || !empty($info['band_time'])){
                throw new Exception('优惠券已经绑定了');
            }elseif (!empty($info['use_time']) || !empty($info['order_id'])) {
                throw new Exception('优惠券已经使用了！');
            }else{
                $data = array();
                $data['id'] = $info['id'];
                $data['band_time'] = time();
                $data['user_id'] = $userId;
                $result = $m->save($data);
                if(empty($result)){
                    throw new Exception('优惠券绑定失败！');
                }
            }
        }catch (Exception $e){
            $error = $e->getMessage();
            $this->ajaxReturn($error,'',2);
        }
        $message = "绑定成功";
        $this->ajaxReturn($message,'',1);
    }

    //选择优惠券时用的接口
    public function mobile_check_used_coupon(){
        $this->mobile_check_token();
        try{
            $userid = $this->userid;
            if(empty($userid)){
                throw new Exception("用户还没有登陆，请登录！",2);
            }

            $sn = addslashes(trim($_REQUEST['sn']));
            $m = M('Coupon');
            $map = array();
            $map['coupon_sn'] = $sn;
            $info = $m->where($map)->find();
            if(empty($info)){
                throw new Exception("优惠券错误，该券号不存在！", 0);
            }elseif(empty($info['user_id'])){
                $data = array();
                $data['id'] 		= $info['id'];
                $data['user_id'] 	= $userid;
                $data['band_time'] 	= time();
                $m->save($data);
            }elseif ($info['user_id'] != $userid || !empty($info['order_id']) ) {
                throw new Exception("优惠券已使用或者异常！", 0);
            }

            $list = $this->getCartList();
            if(empty($list['list'])){
                throw new Exception("购物车不能为空！", 0);
            }
            $productAmount = $list['total']['product_amount'];
            if((!empty($productAmount) && $productAmount >= $info['satisfied_amount']) || empty($info['satisfied_amount'])){
                $finialAmount = $list['total']['product_amount'] + $list['total']['shipping_fee'] - $info['coupon_amount'];
                $res['couponsn'] 		= $info['coupon_sn'];
                $res['couponAmount'] 	= $info['coupon_amount'];
                $res['shipingFee'] 		= $list['total']['shipping_fee'];
                $res['finalAmount'] 	= $finialAmount < 0 ? 0 : $finialAmount ;
            }elseif($productAmount < $info['satisfied_amount']){
                throw new Exception("优惠券不满足使用条件！", 0);
            }

            //html列表
            //$couponlist = $this->getCouponList();
            //$this->assign('couponlist',$couponlist);
            //$this->assign('coupon_sn',$sn);
            //$couponHtml = $this->fetch('Cart:couponlist');
            //$res['couponHtml'] = $couponHtml;
        }catch(exception $e){
            $error = $e->getMessage();
            $this->ajaxReturn($error,'',2);
        }
        $this->ajaxReturn($res,'',1);
    }

    public function mobile_create_order(){
        $this->mobile_check_token();
        $request = $_REQUEST;
        try{
            $userid = $this->userid;
            if(empty($userid)){
                throw new Exception("用户还没有登陆，请登录！",2);
            }

            $cartinfo 	= $this->getCartList();				//购物车物品的详细情况
            if(empty($cartinfo) || empty($cartinfo['list'])){
                throw new exception('购物车商品为空，请刷新页面后提交！');
            }
            $cartList = $cartinfo['list'];//购物有车的商品列表

            $couponInfo = $this->getCouponInfo($request);	//没有使用优惠券为空 否则为券的详情
            $cartinfo 	= $this->countOrderAmount($cartinfo,$couponInfo);	//计算优惠券和免运费

            $oInfo = $this->saveOrderInfo($cartinfo);			//保存订单数据
            $this->saveOrderProduct($oInfo['id'],$cartinfo);	//保存订单商品数据
            $this->saveOrderCoupon($oInfo['id'],$couponInfo);	//保存优惠券信息

            $this->deleteBoughtProductData($cartList);	//删除已经生成订单的商品

            $res['ordersn'] = $oInfo['order_sn'];//返回动态显示订单成功页面信息
        }catch(exception $e){
            $error = $e->getMessage();
            $this->ajaxReturn($error,'',2);
        }
        $this->ajaxReturn($res,'',1);
    }
}