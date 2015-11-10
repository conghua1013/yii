<?php

class PaymentController extends ShopBaseController
{
    public function actionIndex()
    {


    }

    /**
     * 支付宝支付完毕跳转通知.
     */
    public function actionAlipay()
    {
        $ordersn = $_GET['out_trade_no'];
        $ordersn = trim($ordersn);

        $viewData = array();
        $viewData['orderSn'] = $ordersn;
        $viewData['pay_status'] = 'success';
        try{
            $respond = Yii::app()->alipay->respond();
            if($respond === true) {
                Order::model()->saveOrderPaid($ordersn, $_GET['total_fee'], $_GET['trade_no']);
            }

        } catch (exception $e){
            $viewData['title'] = '彼岸吉他 | 支付失败';
            $viewData['pay_status'] = 'fail';
            $this->render('/payment/wrong',$viewData);
        }

        $viewData['title'] = '彼岸吉他 | 支付成功';
        $this->render('/payment/success',$viewData);
    }

    /**
     * 支付宝异步通知（用户关闭了跳转页面、支付宝异步通知的接口）
     */
    public function actionAlipayNotify()
    {
        $ordersn = $_REQUEST['out_trade_no'];
        $ordersn = trim($ordersn);
        try{
            $respond = Yii::app()->alipay->notifyRespond();
            if($respond === true) {
                Order::model()->saveOrderPaid($ordersn,$_REQUEST['total_fee'],$_REQUEST['trade_no']);
            }

        } catch (exception $e){
            echo "fail";exit;
        }
        echo "success";exit;
    }


}