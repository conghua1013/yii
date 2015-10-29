<?php

class CartController extends ShopBaseController 
{

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
        $couponlist = Coupon::model()->getCouponList($userId);
//        echo "<pre>";
//        print_r($plist);
//        print_r($couponlist);
//        exit;
        $viewData['list']       = $plist['list'];
        $viewData['total']      = $plist['total'];
        $viewData['couponlist'] = $couponlist;
        $this->render('cart/index',$viewData);
    }


    /**
     * 订单确认页面
     */
    public function actionCheckout()
    {
        $viewData = array();
        $userId = $this->userid;
        if(empty($userId)){
            $this->redirect('home-public/login');
        }

        $addList = $this->getUserAddressList();
        $payList = $this->getPayList();
        $plist = $this->getCartList();
        $couponlist = $this->getCouponList();

        if(empty($plist['list'])){
            $this->redirect('/');
        }

        $this->assign('addList',$addList);
        $this->assign('list',$plist['list']);
        $this->assign('total',$plist['total']);
        $this->assign('couponlist',$couponlist);
        $this->assign('payList',$payList);
        $this->render('cart/checkout',$viewData);
    }

    /**
     * 生成最后的订单 (订单展示页面)
     */
    public function finish()
    {
        $viewData = array();
        $request = $_REQUEST;
        $ordersn = $request['ordersn'];

        if(empty($ordersn)){
            $this->redirect('/shop');
        }

        $map = array();
        $map['order_sn'] = $ordersn;
        $oInfo = $this->order->where($map)->find();
        if(empty($oInfo)){
            $this->redirect('/shop');
        }
        $oInfo['need_pay_amount'] = $oInfo['order_amount']-$oInfo['coupon_amount'] -$oInfo['pay_amount'];
        $this->assign('oInfo',$oInfo);
        $this->render('cart/checkout',$viewData);
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

        $userId = $this->userid;
        //添加到购车前的检查
        try{
            if(empty($userId)){ //当前用户(登陆)的id
                throw new exception('用户还没有登陆！',2);
            }

            if($request['type'] == 'product'){
                $pInfo = $this->product->getProductInfo($request['id']);//商品详情
            } elseif($request['type'] == 'tab') {
                $pInfo = M('Tab')->db('1',C('BYGUITAR'))->find($request['id']);
            } elseif($request['type'] == 'zine') {
                $pInfo = M('Zine')->db('1',C('BYGUITAR'))->find($request['id']);
            }
            $this->checkAddToCartBefore($request,$pInfo);
        }catch(exception $e){
            $res['status'] = $e->getCode();
            $res['msg'] = $e->getMessage();
            exit(json_encode($res));
        }

        //插入购物车表
        $m = $this->cart;
        $map = array();
        $map['user_id'] 	= $userId;
        $map['product_id'] 	= $request['id'];
        $map['size_id'] 	= $request['size'];
        $map['type'] 		= $this->product_type[$request['type']];
        $cartInfo = $m->where($map)->find();
        $this->cart->startTrans();
        if(empty($cartInfo)){
            $m->user_id 		= $this->userid ;
            $m->product_id 		= $request['id'];
            $m->type 			= $this->product_type[$request['type']];
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

        if ($result !== false){
            $m->commit();// 提交事务
        }else{
            $res['status'] = 0;
            $res['msg'] = '添加购物车失败，请重试！';
            $m->rollback();// 事务回滚
        }
        exit(json_encode($res));
    }



    //检查商品是否有误
    protected function checkAddToCartBefore($request,$pInfo){
        if(empty($pInfo)){ throw new exception('商品出现错误！'); }
        if ($request['type'] == 'tab' || $request['type'] == 'zine') {
            $productName = $request['type'] == 'tab' ? '谱子' : '杂志';
            if($pInfo['sell_price'] <= 0){
                throw new exception('该'.$productName.'不用付费');
            } elseif(empty($pInfo['quantity'])) {
                throw new exception('该'.$productName.'已经没有库存了');
            }
        }  else {
            $size_id = $request['size'];
            if(!empty($pInfo['sizes'])){
                if(empty($size_id)){  //没有选择商品尺寸
                    throw new exception('请选择商品尺寸！');
                }elseif(!isset($pInfo['sizes'][$size_id])){ //选择的商品尺寸错误
                    throw new exception('商品出现错误！');
                }
            }

            if($pInfo['is_multiple'] == 0){
                if($request['num'] > $pInfo['quantity']){
                    throw new exception('商品库存不足了！');
                }
            }else {
                if($pInfo['sizes'][$size_id]['quantity'] < $request['num']){
                    throw new exception('商品库存不足了！');
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

        $userId = $this->userid;
        $cid	= intval($_REQUEST['id']);
        if(empty($userId)){ //当前用户(登陆)的id
            $res['status'] = '2';
            $res['msg'] = '用户还没有登陆！';
            exit(json_encode($res));
        }elseif (empty($cid)) {
            $res['status'] = '0';
            $res['msg'] = '数据错误刷新页面重试';
            exit(json_encode($res));
        }

        $flag = $this->cart->where('id='.$cid)->delete();
        if(empty($flag)){
            $res['status'] = 0;
            $res['msg'] = '删除失败，请重试！';
        }
        exit(json_encode($res));
    }



    //商品是否存在购物车中
    protected function isExistCart($pid){
        if(empty($pid)){return false;}

        $map= array();
        $map['product_id'] 	= intval($pid);
        $map['user_id'] 	=  $this->userid;
        $info = $this->cart->where($map)->find();
        return $info;
    }



    /**
     * 获取购物车里面的商品
     */
    protected function getCartList(){
        $userId = $this->userid;
        if(empty($userId)){
            $this->redirect('/public/login');
        }

        $m = $this->cart;
        $map = array();
        $map['user_id'] = $this->userid ;
        $map['is_pay']  = !empty($ispay) ? $ispay : array('lt', 2);		//未结算
        $list = $m->where($map)->select();
        if(empty($list)){return false;}

        $productAttrs = $this->product->getProductAttrList();

        $tabIds = array();
        $zineIds = array();
        $productIds = array();
        foreach($list as $row){
            if($row['type'] == 1){
                array_push($tabIds, $row['product_id']);
            } elseif($row['type'] == 2){
                array_push($zineIds, $row['product_id']);
            } else {
                array_push($productIds, $row['product_id']);
            }
        }

        //谱子列表
        if($tabIds){
            $tabList = $this->cart->getTabsByIds($tabIds);
        }
        //杂志列表
        if($zineIds){
            $zineList = $this->cart->getZineByIds($zineIds);
        }
        //商品列表
        if($productIds){
            $productList = $this->cart->getProductByIds($productIds);
        }

        $total = array();
        foreach($list as &$val){
            //查询商品信息
            if($val['type'] == 1){
                $product = isset($tabList[$val['product_id']]) ? $tabList[$val['product_id']] : '' ;
            } elseif($val['type'] ==2) {
                $product = isset($zineList[$val['product_id']]) ? $zineList[$val['product_id']] : '' ;
            } else {
                $product = isset($productList[$val['product_id']]) ? $productList[$val['product_id']] : '' ;
            }
            if(empty($product)){ continue; }
            //$product = $this->product->getProductInfo($val['product_id']);
            $val['product_name'] = $product['product_name'];
            if(!empty($val['size_id']) && !empty($productAttrs[$val['size_id']]) ){
                $val['product_name'] .=  '-'.$productAttrs[$val['size_id']]['attr_name'];
            }

            $val['pInfo']            = $product;
            $val['sell_price']      = $product['sell_price'];
            $val['product_sn'] 	  = $product['product_sn'];
            $val['brand_id'] 	      = $product['brandid'];
            $val['img'] 		      = $product['img'];
            $val['weight'] 		  = $product['weight'];
            $val['size'] 		      = $product['size'];
            //$val['shipping'] 	= $product['shipping'];
            //$val['cost'] 		= $product['currentcost'];//当前成本
            //$val['storage'] 	= $product['quantity'];
            //$val['status'] 		= $product['status'];
            //$val['iscoupon'] 	= $product['iscoupon'];
            //$val['isfree'] 		= $product['isfree'];
            $val['total_price']   = $val['quantity'] * $val['sell_price'];  //小计
            $val['total_cost'] 	= $val['quantity'] * $val['cost_price'];  //小计
            $val['quantity'] 	    = $val['quantity'];   //商品个数

            $total['quantity'] 			+= $val['quantity'];//总件数
            $total['product_amount'] 	+= $val['total_price'];//总计
            //$total['total_cost'] 		+= $val['total_cost'];//成本总计
        }

        $total['shipping_fee'] 	= $this->getShippingFee($total['product_amount']);
        $total['coupon_id']		= 0;
        $total['coupon_amount']	= 0;
        $total['reduce_amount']	= 0;
        $total['final_amount'] 	= $total['product_amount']+$total['shipping_fee'];
        return array('list'=> $list, 'total' => $total);
    }


    //计算商品的运费信息 (有待继续完善功能)
    protected function getShippingFee($productAmount){
        if (empty($productAmount)) {
            return 0;
        }
        $config = $this->cart->getShopConfig();
        $freeAmount = isset($config['FREE_SHIPPING_AMOUNT']) ? $config['FREE_SHIPPING_AMOUNT']: 69;
        $shippingFee = isset($config['SHIPPING_FEE']) ? $config['SHIPPING_FEE']: 6;

        $finalShippingFee = 0;	//最终计算后的运费
        if($productAmount < $freeAmount){ //免运费金额和购物车中商品金额比较
            $finalShippingFee = $shippingFee;
        }

        return $finalShippingFee;
    }


    //获取当前用户的优惠券列表
    protected function getCouponList($typeInfo = array()){
        $userId =  $this->userid;
        if(empty($userId)){return false;}

        $m = M('Coupon a');
        $map = array();
        $map['a.user_id'] = $userId;
        $map['a.start_time'] = array('lt',time());
        $map['a.end_time'] = array('gt',time());
        $map['a.order_id'] = 0;
        $map['a.use_time'] = 0;
        $list 	= $m->join('bg_coupon_type b ON a.coupon_type_id=b.id')->where($map)->field('a.*,b.coupon_name,b.coupon_type')->select();
        if($typeInfo && $typeInfo['coupon_type'] == 2){
            $list[] = $typeInfo;
        }
        return $list;
    }

    /**
    +
     * 绑定优惠券到用户的账户中
    +
     */
    public function actionCouponBand(){
        $res = array();
        $res['status'] = 1;
        $userId = $this->userid;
        $sn = trim($_REQUEST['sn']);
        if(empty($userId)){
            $res['status'] = 2;
            $res['msg'] = '当前用户未登陆！';
            exit(json_encode($res));
        }elseif(empty($sn)){
            $res['status'] = 0;
            $res['msg'] = '优惠券编码不能为空！';
            exit(json_encode($res));
        }


        $m = M('Coupon');
        $map = array();
        $map['coupon_sn'] = $sn;
        $info = $m->where($map)->find();

        if(empty($info)){
            $res['status'] = 0;
            $res['msg'] = '优惠券不存在！';
        }elseif(!empty($info['user_id']) || !empty($info['band_time'])){
            $res['status'] = 0;
            $res['msg'] = '优惠券已经绑定了！';
        }elseif (!empty($info['use_time']) || !empty($info['order_id'])) {
            $res['status'] = 0;
            $res['msg'] = '优惠券已经使用了！';
        }else{
            $data = array();
            $data['id'] = $info['id'];
            $data['band_time'] = time();
            $data['user_id'] = $userId;
            $result = $m->save($data);
            if(empty($result)){
                $res['status'] = 0;
                $res['msg'] = '优惠券绑定失败！';
            }
        }
        exit(json_encode($res));
    }


    /**
    +
     * 更新购物车的商品的数量
    +
     */
    public function actionUpCartNum(){
        $res = array();
        $res['status'] = 1;

        $id 	= intval($_REQUEST['id']);
        $number = intval($_REQUEST['num']);
        $action = $_REQUEST['action']; //edit(直接修改) reduse(减) plus(加)
        $action = empty($action) ? 'plus' :$action;

        try{
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

            $pInfo = $this->cart->getCartProductInfoByProductId($info['product_id'],$info['type']);
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
            $res['status'] = 0 ;
            $res['msg'] = $e->getMessage();
            exit(json_encode($res));
        }

        $res['id'] = $id;
        $res['msg'] ='修改成功！';
        exit(json_encode($res));
    }

    //更新购物车数量时的校验
    protected function checkProductQuantity($cartInfo,$pInfo,$num){
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


    //用户动态获取用户的地址列表
    public function actionGetAddressListHtml(){
        $addList = $this->getUserAddressList();

        $this->assign('addList',$addList);
        $html = $this->fetch('Cart:addresslist');
        return $html;
    }


    /**
    +
     * 生成订单
     * @time 2014-05-25 mwq2020
    +
     */
    public function actionCreateOrder(){
        $request = $_REQUEST;
        $res = array();
        $res['status'] 	= 1;
        $res['msg'] 	= '';
        $res['ordersn'] = '';

        try{
            $this->order->startTrans();
            $this->orderProduct->startTrans();
            $this->productStock->startTrans();
            $this->coupon->startTrans();
            $this->product->startTrans();

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

            $this->order->commit();
            $this->orderProduct->commit();
            $this->productStock->commit();
            $this->coupon->commit();
            $this->product->commit();
        }catch(exception $e){
            $this->order->rollback();
            $this->orderProduct->rollback();
            $this->productStock->rollback();
            $this->coupon->rollback();
            $this->product->rollback();
            $res['status'] = 0;
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }


    //删除购物车剩余的数据 （已经生成订单的数据）
    protected function deleteBoughtProductData($cartList){
        if(empty($cartList)){ throw new exception('购物车商品不能为空！'); }
        $cardids = array();
        foreach ($cartList as $row){
            array_push($cardids, $row['id']);
        }

        //一次删除所有的商品
        $map = array();
        $map['id'] = array('in',  implode(',', $cardids));

        $this->cart->where($map)->delete();
        return true;
    }


    //计算订单的金额（计算免运费和优惠券）
    protected function countOrderAmount($cartinfo,$couponInfo){
        $freeAmount = $this->getFreeShippingAmount();//免运费的限额

        //如果有优惠券信息
        if(!empty($couponInfo)){
            if($cartinfo['total']['product_amount'] > $couponInfo['satisfied_amount']){ //如果满足使用条件
                //优惠券的金额大于商品金额 取商品金额、反之取优惠券金额
                if($cartinfo['total']['product_amount']>$couponInfo['coupon_amount']){
                    $cartinfo['total']['coupon_amount'] = $couponInfo['coupon_amount'];
                }else{
                    $cartinfo['total']['coupon_amount'] = $couponInfo['product_amount'];
                }
                $cartinfo['total']['coupon_id'] = isset($couponInfo['coupon_id']) ? $couponInfo['coupon_id'] :$couponInfo['id'];
                $cartinfo['total']['coupon_type'] = isset($couponInfo['coupon_type']) ? $couponInfo['coupon_type'] : 1 ;
            }
        }

        //运费的计算
        if($cartinfo['total']['final_amount'] > $freeAmount ){
            if($cartinfo['total']['final_amount'] < $cartinfo['shipping_fee']){
                $cartinfo['total']['final_amount'] = 0;
            }else{
                $cartinfo['total']['final_amount'] -= $cartinfo['total']['shipping_fee'];
            }
            $cartinfo['total']['shipping_fee'] = 0;
        }

        return $cartinfo;
    }



    //获取提交订单时的优惠券信息
    protected function getCouponInfo($request){
        if(empty($request['couponsn'])){return false;}

        #先检查时否是优惠券
        $map = array();
        $map['coupon_sn'] 	= $request['couponsn'];
        $map['user_id'] 	= $this->userid;
        $couponInfo = M('Coupon')->where($map)->find();

        if(!empty($couponInfo)){
            if(!empty($couponInfo['order_id']) || !empty($couponInfo['use_time'])){
                throw new exception('该优惠券已经使用过！');
            }elseif($couponInfo['start_time'] > time()){
                throw new exception('优惠券还未到使用日期！');
            }elseif($couponInfo['end_time'] < time()){
                throw new exception('该优惠券已经过期！');
            }
            $couponInfo['type'] = 'A';
            return $couponInfo;
        }

        $map = array();
        $map['coupon_sn'] 	= $request['couponsn'];
        $couponInfo = M('CouponType')->where($map)->find();
        if(!empty($couponInfo)){
            if($couponInfo['start_time'] > time()){
                throw new exception('优惠券还未到使用日期！');
            }elseif($couponInfo['end_time'] < time()){
                throw new exception('该优惠券已经过期！');
            }
            $couponInfo['type'] = 'B';
            return $couponInfo;
        }else{
            throw new exception('该优惠券不存在！');
        }
    }


    /**
    +
     * 保存订单信息
    +
     */
    protected function saveOrderInfo($cartInfo){
        $addid = $_REQUEST['addrid'];
        $addInfo = M('Address')->find($addid);
        $userid = $this->userid;
        if(empty($userid)){
            throw new exception('请登录后再提交订单！');
        }if(empty($addInfo)){
            throw new exception('地址不存在，请添加后再提交订单！');
        }elseif($addInfo['user_id'] != $userid){
            throw new exception('地址异常修改地址后再提交订单！');
        }elseif($addInfo['is_default'] != 1){
            $this->saveUserLastAddressDefault($addInfo['id']);
        }

        $m = $this->order;
        $m->order_sn 		= $this->getOrderSn();
        $m->user_id			= $userid;
        $m->order_status	= 0;
        $m->pay_id 			= $_REQUEST['payid'];
        $m->shipping_fee 	= $cartInfo['total']['shipping_fee'];
        $m->order_amount 	= $cartInfo['total']['final_amount'];
        $m->product_amount 	= $cartInfo['total']['product_amount'];
        $m->quantity 		= $cartInfo['total']['quantity'];
        $m->coupon_id 		= $cartInfo['total']['coupon_id'];
        $m->coupon_type 	= $cartInfo['total']['coupon_type'];
        $m->coupon_amount = $cartInfo['total']['coupon_amount'];
        $m->consignee 		= $addInfo['consignee'];
        $m->mobile 		= $addInfo['mobile'];
        $m->province 		= $addInfo['province'];
        $m->city 			= $addInfo['city'];
        $m->district 		= $addInfo['district'];
        $m->address 		= $addInfo['address'];
        $m->email 			= '';
        $m->remark 		= $_REQUEST['remark'];//备注
        $m->cps_msg 		= '';
        $m->source 			= 1;
        $m->add_time 		= time();
        $id = $m->add();

        if(empty($id)){
            throw new exception('订单生成失败！');
        }
        $oInfo = array();
        $oInfo['id'] 		= $id;
        $oInfo['order_sn'] 	= $m->order_sn;
        return $oInfo;
    }

    /**
    +
     * 保存订单商品信息
    +
     */
    protected function saveOrderProduct($oid,$cartinfo){

        $list = $cartinfo['list'];
        foreach ($list as  $row) {
            if($row['type'] == 1){
                $pInfo = M('Tab')->db(1,C('BYGUITAR'))->find($row['product_id']);
                if(empty($pInfo)){ throw new Exception("谱子不存在！", 1);}
            }elseif($row['type'] == 2){
                $pInfo = M('Zine')->db(1,C('BYGUITAR'))->find($row['product_id']);
                if(empty($pInfo)){ throw new Exception("杂志商品不存在！", 1);}
            }else{
                $pInfo = M('Product')->find($row['product_id']);
                if(empty($pInfo)){ throw new Exception("订单商品不存在！", 1);}
            }

            $m = $this->orderProduct;
            $m->order_id 	= $oid;
            $m->user_id 	= $this->userid;
            $m->product_id 	= $row['product_id'];
            $m->type 	        = $row['type'];
            $m->product_sn 	 = empty($row['type']) ? $pInfo['product_sn'] : '';
            $m->product_name   = empty($row['type']) ? $pInfo['product_name'] : ($row['type'] == 1 ? $pInfo['tabname'] : $pInfo['name']);
            $m->size_id 	     = $row['size_id'];
            $m->brand_id 	     = $pInfo['brand_id'];
            $m->sell_price 	 = $row['sell_price'];
            $m->quantity 	     = $row['quantity'];
            $m->shipping_id 	= 0;
            $m->shipping_code 	= '';
            $m->shipping_time 	= 0;
            $opid = $m->add();
            if(empty($opid)){
                throw new Exception("订单商品生成失败！".$m->getDbError(), 1);
            }

            $this->updateProductStock($row,$pInfo);//更新商品的库存
        }
        return true;
    }

    //更新商品的库存
    //ALTER TABLE `byguitar_shop`.`bg_order_product`     ADD COLUMN `size_id` INT(10) DEFAULT '0' NULL COMMENT '商品尺寸' AFTER `product_name`;
    protected function updateProductStock($cartInfo,$pInfo){
        if(empty($cartInfo)){ throw new Exception("购物车商品为空！", 1); }
        if(empty($pInfo)){ throw new Exception("商品信息不能为空！", 1); }

        $dbConnect = C('BYGUITAR');
        //谱子的库存检查及操作
        if($cartInfo['type'] == 1){
            if($cartInfo['quantity'] > $pInfo['quantity']){
                throw new Exception("谱子【{$pInfo['tabname']}】库存不足！", 1);
            }
            $m = M('Tab','AdvModel');
            $m->addConnect($dbConnect,1);
            $m->switchConnect(1);
            $data = array();
            $data['quantity'] = $pInfo['quantity'] - $cartInfo['quantity'];
            $flag = $m->where('id = '. $pInfo['id'])->data($data)->save();
            if(empty($flag)){
                throw new exception('谱子库存更新失败！');
            }
            return true;
        } elseif($cartInfo['type'] == 2){
            if($cartInfo['quantity'] > $pInfo['quantity']){
                throw new Exception("杂志【{$pInfo['name']}】库存不足！", 1);
            }
            $m = M('Zine','AdvModel');
            $m->addConnect($dbConnect,1);
            $m->switchConnect(1);
            $data = array();
            $data['quantity'] = $pInfo['quantity'] - $cartInfo['quantity'];
            $flag = $m->where('id = '. $pInfo['id'])->data($data)->save();
            if(empty($flag)){
                throw new exception('杂志库存更新失败！');
            }
            return true;
        }

        if(empty($cartInfo['size_id'])){
            if($cartInfo['quantity'] > $pInfo['quantity']){
                throw new Exception("商品【{$pInfo['product_name']}】库存不足！", 1);
            }
            $data = array();
            $data['id']			= $pInfo['id'];
            $data['quantity']	= $pInfo['quantity']-$cartInfo['quantity'];
            $flag = $this->product->save($data);
            if(empty($flag)){
                throw new exception('商品库存更新失败！');
            }
        }else{
            $map = array('product_id' => $cartInfo['product_id'], 'size_id' =>  $cartInfo['size_id']);
            $stock_m = M('ProductStock');
            $stockInfo = $stock_m->where($map)->find();
            if(empty($stockInfo)){
                throw new Exception("商品【{$pInfo['product_name']}】库存错误！", 1);
            }elseif($stockInfo['quantity'] < $cartInfo['quantity']){
                throw new Exception("商品【{$pInfo['product_name']}】库存不足！", 1);
            }

            $data = array();
            $data['id'] = $stockInfo['id'];
            $data['quantity'] = $stockInfo['quantity'] - $cartInfo['quantity'];
            $flag = $stock_m->save($data);
            if(empty($flag)){
                throw new exception('商品库存更新失败！');
            }
        }
        return true;
    }



    /**
    +
     * 保存优惠券信息
    +
     */
    protected function saveOrderCoupon($oid,$couponInfo){
        if(empty($couponInfo)){return false;}
        if($couponInfo['type'] == 'B'){return false;} //A（固定券码 暂不保存数据）

        $m = $this->coupon;
        $data = array();
        $data['id'] 		= $couponInfo['id'];
        $data['order_id'] 	= $oid;
        $data['use_time'] 	= time();
        $res = $m->save($data);
        if(empty($res)){
            throw new Exception("优惠券保存失败！", 1);
        }
        return true;
    }




    //生成订单编号
    public function getOrderSn() {
        import('ORG.Util.Date');// 导入日期类
        $Date = new Date();
        $sn = array();
        $rand = rand(0,99999);
        $rand = str_pad($rand,5,"0",STR_PAD_LEFT);
        $sn[] = $Date->YMD;
        $sn[] = $rand;
        $sn = implode('',$sn);
        return 'BG'.$sn;
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



    protected function getUserAddressList(){
        $userid = $this->userid;
        if(empty($userid)){
            $this->redirect('Home-public/login');
        }

        $map = array();
        $map['user_id'] = $userid;
        $m = M('Address');
        $list = $m->where($map)->select();
        if(empty($list)){return false;}
        $mRegion = M('Region');
        foreach ($list as &$val) {
            $ids = array();
            $ids[] = intval($val['province']);
            $ids[] = intval($val['city']);
            $ids[] = intval($val['district']);

            $map = array();
            $map['id'] = array('in',$ids);
            $addList = $mRegion->where($map)->select();

            if(empty($addList)){ continue;}
            $regionList = array();
            foreach($addList as $row){
                $regionList[$row['id']] = $row;
            }

            $val['province_name'] = isset($regionList[$val['province']]) ? $regionList[$val['province']]['region_name'] : '';
            $val['city_name'] = isset($regionList[$val['city']]) ? $regionList[$val['city']]['region_name'] : '';
            $val['district_name'] = isset($regionList[$val['district']]) ? $regionList[$val['district']]['region_name'] : '';
        }
        return $list;
    }


    //保存或者新加收货地址
    public function actionSaveAddress(){
        $res = array();
        $res['status'] = 1;
        $res['msg'] = '';

        $id = $_REQUEST['id'];
        $m = M('Address');
        if(!empty($id)){
            $info = $m->find($id);
        }else{
            $m->user_id 	= $this->userid;
        }
        $m->consignee 	= $_REQUEST['usname'];
        $m->province 	= $_REQUEST['usprovince'];
        $m->city 		= $_REQUEST['uscity'];
        $m->district 	= $_REQUEST['usdistrict'];
        $m->address 	= $_REQUEST['usaddr'];
        $m->mobile 	= $_REQUEST['usmob'];
        $m->is_default 	= 1;

        if(empty($id)){
            $m->add_time 	= time();
            $addid = $m->add();
            $this->saveUserLastAddressDefault($addid);
        }else{
            $m->update_time = $_REQUEST['update_time'];
            $addid = $m->save();
        }

        $addressHtml = $this->getAddressListHtml();
        $res['html'] = $addressHtml;
        $res['status'] = empty($addid) ? 0 : 1;
        $res['addrid'] = $addid;

        exit(json_encode($res));
    }


    /**
    +
     *顶部购物车下拉菜单
    +
     */
    public function actionMiniCart(){
        $res = array();
        $res['status'] = 1;
        $res['msg'] = '';

        $userid = $this->userid;
        if(empty($userid)){
            $res['status'] = 0;
            exit(json_encode($res));
        }

        $plist = $this->getCartList();
        $this->assign('list',$plist['list']);
        $this->assign('total',$plist['total']);

        $html = $this->fetch('minicart');
        $res['html'] 	= $html;
        $res['total'] 	= empty($plist['total']) ? 0 : $plist['total'];
        exit(json_encode($res));
    }


    /**
    +
     *使用优惠券时 （绑定优惠券、计算优惠券金额）
    +
     */
    public function actionCheckCoupon(){
        $res = array();
        $res['status'] = 1;
        $res['msg'] = '';

        $sn = addslashes(trim($_REQUEST['sn']));
        $userid = $this->userid;
        try{
            if(empty($userid)){
                throw new Exception("用户还没有登陆，请登录！",2);
            }
            $m = M('Coupon');
            $map = array();
            $map['coupon_sn'] = $sn;
            $info = $m->where($map)->find();
            if(empty($info)){
                $typeM = M('CouponType');
                $map = array();
                $map['coupon_sn'] = $sn;
                $info = $typeM->where($map)->find();
                if(empty($info)){
                    throw new Exception("优惠券错误，该券号不存在！", 0);
                }
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
            $couponlist = $this->getCouponList($info);
            $this->assign('couponlist',$couponlist);
            $this->assign('coupon_sn',$sn);
            $couponHtml = $this->fetch('Cart:couponlist');
            $res['couponHtml'] = $couponHtml;
        }catch(exception $e){
            $res['status'] = $e->getCode();
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }


    //获取商品的免运费限额
    protected function getFreeShippingAmount(){
        $m = M('ShopConfig');
        $map = array();
        $map['attribute'] = 'FREE_SHIP_AMOUNT';
        $info = $m->where($map)->find();
        if(empty($info)){
            return 200;
        }
        return $info['value'];
    }


    //获取可用支付的列表
    protected function getPayList(){
        $m = M('Payment');
        $order = 'is_plat desc,sort asc';
        $map = array('is_valid' => 1);
        $list = $m->where($map)->order($order)->select();
        if(empty($list)){
            return false;
        }

        $newList = array();
        foreach ($list as $row) {
            if($row['is_plat'] == 1){
                $newList['plat'][] = $row;
            }else{
                $newList['bank'][] = $row;
            }
        }
        return $newList;
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