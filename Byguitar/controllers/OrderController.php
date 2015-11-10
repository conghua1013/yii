<?php

class OrderController extends ShopBaseController
{
    /**
     * 下单成功页面.
     */
    public function actionIndex()
    {
        $viewData = array();
        $request = $_REQUEST;
        $ordersn = $request['ordersn'];
        $userId = $this->user_id;

        if(empty($userId)){
            $this->redirect('/user/login?from=finish');
        }
        if(empty($ordersn)){
            $this->redirect('/?from=finish');
        }

        $map = array();
        $map['order_sn'] = $ordersn;
        $oInfo = Order::model()->findByAttributes($map);
        if(empty($oInfo)){
            $this->redirect('/shop?from=no_order');
        }elseif($oInfo['user_id'] != $userId){
            $this->redirect('/?from=user_order_not_match');
        }
        $oInfo = $oInfo->getAttributes();
        $oInfo['need_pay_amount'] = $oInfo['order_amount']-$oInfo['coupon_amount'] -$oInfo['pay_amount'];

        $viewData['oInfo'] = $oInfo;
        $this->render('order/index',$viewData);
    }

    /**
     * 支付的入口（默认跳入支付宝）
     */
    public function actionPay()
    {
        $orderSn = $_REQUEST['ordersn'];
        $map = array();
        $map['order_sn'] = $orderSn;
        $oInfo = Order::model()->findByAttributes($map);
        if(empty($oInfo)){
            $this->redirect('/?from=no_order');//跳转到首页;
        }

        $data = array();
        $data['order_sn'] 		= $oInfo['order_sn'];
        $data['pay_amount'] 	= $oInfo['order_amount']-$oInfo['pay_amount'] -$oInfo['coupon_amount'];
        //$data['limit_time'] 	= 7200;
        $data['receive_name'] 	= $oInfo['consignee'];
        $data['receive_address']= $oInfo['address'];
        $data['receive_mobile'] = $oInfo['mobile'];

        $alipay_url = Yii::app()->alipay->get_code($data);
        echo $alipay_url ."<hr>";exit;

        header("Content-type:text/html;charset=utf-8");
        header('Location:'.$alipay_url); //跳转到支付宝网关
        exit;
    }
}