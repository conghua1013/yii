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

        // todo 研究是否需要再次获取商品基本信息 刷新购物车中商品的价格
        $plist = Cart::model()->getCartList($userId);

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
        $request['type'] 	= isset($request['type']) && in_array($request['type'],array('product','zine','tab')) ? $request['type'] :'product';

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
            Cart::model()->addToCart($userId,$request);
            $transcation->commit();
        }catch(exception $e){
            $transcation->rollBack();
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
     * 从购物车删除商品数据
     */
    public function actionDelCart()
    {
        $res = array('status' => 1,'msg' => ''); //返回的数据结构

        $request = $_REQUEST;
        $userId = $this->user_id;
        try{
            $request['cid']	= intval($_REQUEST['id']);
            if(empty($userId)){ //当前用户(登陆)的id
                throw new exception('用户还没有登陆',2);
            }
            Cart::model()->deleteProductFromCart($userId,$request);
        } catch (exception $e){
            $res['status']  = $e->getCode();
            $res['msg']     = $e->getMessage();
            if(!in_array($res['status'],array(2,500))){
                $res['status'] = 0;
                $res['msg'] = '删除失败，请重试！';
            }
        }

        exit(json_encode($res));
    }

    /**
     * 更新购物车的商品的数量
     */
    public function actionUpCartNum()
    {
        $res = array('status' => 1,'msg'=>'修改成功！');

        $request = $_REQUEST;
        $request['id'] 	= intval($_REQUEST['id']);
        $request['number'] = intval($_REQUEST['num']);
        //edit(直接修改) reduse(减) plus(加)
        $request['action'] = !empty($_REQUEST['action']) && in_array($_REQUEST['action'],array('edit','reduse','plus')) ? $_REQUEST['action'] : 'plus';

        $userId = $this->user_id;
        try{
            if(empty($userId)){ //当前用户(登陆)的id
                throw new exception('用户还没有登陆',2);
            }
            Cart::model()->updateCartNum($userId,$request);
        } catch (exception $e) {
            $res['status'] = $e->getCode();
            $res['msg'] = $e->getMessage();
            if(!in_array($res['status'],array(2,500))){
                $res['status'] = 0;
                $res['msg'] = '更新数量失败，请重试！';
            }
        }

        $res['id'] = $request['id'];
        exit(json_encode($res));
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
        $tran1 = Yii::app()->shop->beginTransaction();
        $tran2 = Yii::app()->byguitar->beginTransaction();
        try{
            if(empty($userId)){
                throw new exception('用户未登录',2);
            }

            $oInfo 	= Cart::model()->createOrder($userId,$request);				//购物车物品的详细情况
            $res['ordersn'] = $oInfo['ordersn'];//返回动态显示订单成功页面信息
            $tran1->commit();
            $tran2->commit();
        }catch(exception $e){
            $tran1->rollback();
            $tran2->rollback();
            $res['status'] = 0;
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }


    /**
     * 使用优惠券时 （绑定优惠券、计算优惠券金额）
     */
    public function actionCheckCoupon()
    {
        $res = array('status' => 1, 'msg' => '');
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
            $couponlist = Coupon::model()->getUserUsingCouponList($userId);
            $res['couponlist'] = $couponlist;
        }catch(exception $e){
            $res['status'] = $e->getCode();
            $res['msg'] = $e->getMessage();
        }
        exit(json_encode($res));
    }

}