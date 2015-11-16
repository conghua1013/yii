<?php

class OrderController extends ManageController
{

	/**
	 * 列表页面
	 */
	public function actionIndex()
	{
		$list = Order::model()->getOrderListPage();
		$viewData = array();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $list['pageNum'];
		$this->render('index', $viewData);
	}

	/**
	 * 订单详情页面
	 */
	public function actionInfo()
	{
		$oInfo = Order::model()->getOrderInfo($_REQUEST['id']);
		$opList = OrderProduct::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$oLog = OrderLog::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$oShipping = OrderShipping::model()->findAllByAttributes(array('order_id'=>$_REQUEST['id']));
		$shippingList = Shipping::model()->getShippingList();
		$viewData = array();
		$viewData['oInfo'] = $oInfo;
		$viewData['opList'] = $opList;
		$viewData['oLog'] = $oLog;
		$viewData['oShipping'] = $oShipping;
		$viewData['shippingList'] = $shippingList;
		$this->render('info', $viewData);
	}

	/**
	 * 通知淘宝发货页面及处理【通知支付宝发货，并修改订单的发货状态】【支付宝担保交易用到】
	 */
	public function actionShippingAndNotifyAlipay()
	{
		if(empty($_POST)){
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			$viewData = array();
			$viewData['oInfo'] = $oInfo;
			$this->render('shippingAndNotifyAlipay', $viewData);exit;
		}

		// 处理淘宝的发货过程
		$res = array('statusCode' => 200,'message' => '通知淘宝发货成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(1,2,4))) {
				throw new exception('订单状态错误！');
			}

			$parameter = array(
				"trade_no"			=> $_REQUEST['trade_no'],
				"logistics_name"	=> $_REQUEST['shipping_name'],
				"invoice_no"		=> $_REQUEST['shipping_number'],
				"transport_type"	=> 'EXPRESS',
			);

			$html_text = $this->sendNotifyToAlipay($parameter);
			$obj = simplexml_load_string($html_text);
			if(isset($obj) && !empty($obj)){
				if($obj->is_success == 'F'){
					throw new exception($obj->error);
				}
			} else {
				throw new exception('支付宝返回结果异常！');
			}

			//保存发货信息到订单中
			$oInfo->shipping_id 	= 0;
			$oInfo->shipping_sn 	= intval($_REQUEST['shipping_number']);
			$oInfo->shipping_time 	= time();
			$oInfo->order_status 	= 5;//已发货
			$oInfo->shipping_status = 1;//已发货
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('保存运单信息到订单错误！',500);
			}

			//保存订单的发货信息
			$m = new OrderShipping();
			$m->order_id 		= $oInfo->id;
			$m->shipping_id 	= 0;
			$m->shipping_sn 	= $_REQUEST['shipping_number'];
			$m->shipping_fee 	= 0;
			$m->weight 			= 0;
			$m->remark 			= '支付宝发货成功';
			$m->add_time 		= time();
			$flag = $m->save();
			if(empty($flag)){
				throw new exception('保存发货信息错误！',500);
			}

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminSend';
			$logData['msg'] 	 = '您的订单已发货!';
			OrderLog::model()->addOrderLog($logData);

		}catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '发货失败!【'.$e->getMessage().'】';
		}
		$res['navTabId'] = 'orderList';
		$res['callbackType'] = 'closeCurrent';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 通知支付宝接口
	 * @param $data
	 * @return 支付宝处理结果
	 * @throws exception
	 */
	private function sendNotifyToAlipay($data)
	{

		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" 			=> "send_goods_confirm_by_platform",
			"trade_no"			=> trim($data['trade_no']),
			"logistics_name"	=> trim($data['logistics_name']),
			"invoice_no"		=> trim($data['invoice_no']),
			"transport_type"	=> trim($data['transport_type']),
			"_input_charset"	=> 'utf-8'
		);

		try{
			//建立请求
			Yii::import("application.extensions.payment.alipayNotify");
			$alipaySubmit = new alipayNotify();
			$html_text = $alipaySubmit->buildRequestHttp($parameter);
		} catch (exception $e) {
			throw new exception('发货接口失败！【'.$e->getMessage().'】');
		}

		return $html_text;
	}
	/**
	 * 订单【取消】
	 */
	public function actionCancelOrder()
	{
		$res = array('statusCode' => 200,'message' => '取消成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(0,1))) {
				throw new exception('订单状态错误！');
			}

			//更新订单状态
			$oInfo->order_status 	= 9;
			$oInfo->update_time 	= time();
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('订单保存错误！', 500);
			}
			Order::model()->dealWithCancelOrderProductStock($oInfo['id']);//库存恢复
			//添加订单日志

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminCanced';
			$logData['msg'] 	 = '您的订单已取消！';
			OrderLog::model()->addOrderLog($logData);

		}catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '取消失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单【已支付】todo（待完成）
	 */
	public function actionPayOrder()
	{
		$res = array('statusCode' => 200,'message' => '支付订单成功！');
		try{

		} catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '支付订单失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单【审核】
	 */
	public function actionCheckOrder()
	{
		$res = array('statusCode' => 200,'message' => '审核订单成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(1,2))) {
				throw new exception('订单状态错误！');
			}

			$oInfo->order_status 	= 3;
			$oInfo->update_time 	= time();
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('订单审核失败！',500);
			}

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminChecked';
			$logData['msg'] 	 = '您的订单已审核通过！';
			OrderLog::model()->addOrderLog($logData);

		} catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '审核订单失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单发货【普通的订单发货】
	 */
	public function actionSendOrder()
	{
		if(empty($_POST)){
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			$shippingList = Shipping::model()->getShippingList();
			$viewData = array();
			$viewData['oInfo'] = $oInfo;
			$viewData['shippingList'] = $shippingList;
			$this->render('sendOrder', $viewData);exit;
		}

		$res = array('statusCode' => 200,'message' => '发货成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(1,2,4))) {
				throw new exception('订单状态错误！');
			}
			//保存发货信息到订单中
			$oInfo->shipping_id 	= intval($_REQUEST['shipping_id']);
			$oInfo->shipping_sn 	= intval($_REQUEST['shipping_sn']);
			$oInfo->shipping_time 	= time();
			$oInfo->order_status 	= 5;//已发货
			$oInfo->shipping_status = 1;//已发货
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('保存运单信息到订单错误！',500);
			}

			//保存订单的发货信息
			$m = new OrderShipping();
			$m->order_id 		= $_REQUEST['order_id'];
			$m->shipping_id 	= $_REQUEST['shipping_id'];
			$m->shipping_sn 	= $_REQUEST['shipping_sn'];
			$m->shipping_fee 	= $_REQUEST['shipping_fee'];
			$m->weight 			= $_REQUEST['weight'];
			$m->remark 			= $_REQUEST['remark'];
			$m->add_time 		= time();
			$flag = $m->save();
			if(empty($flag)){
				throw new exception('保存运单信息错误！',500);
			}

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminSend';
			$logData['msg'] 	 = $_REQUEST['remark'];
			OrderLog::model()->addOrderLog($logData);

		} catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '发货失败!【'.$e->getMessage().'】';
		}
		$res['navTabId'] = 'orderList';
		$res['callbackType'] = 'closeCurrent';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单【待备货】
	 */
	public function actionPrepareOrder()
	{
		$res = array('statusCode' => 200,'message' => '待备货成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(1,2,3))) {
				throw new exception('订单状态错误！');
			}

			//更新订单状态
			$oInfo->order_status 	= 4;
			$oInfo->prepare_time 	= time();
			$oInfo->update_time 	= time();
			$flag = $oInfo->save();
			if(empty($flag)){ throw new exception('订单状态修改失败！'); }

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminPrepared';
			$logData['msg'] 	 = '您的订单已经进入仓库!';
			OrderLog::model()->addOrderLog($logData);

		} catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '发货失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单【确认收货】
	 */
	public function actionReceiveOrder()
	{
		$res = array('statusCode' => 200,'message' => '确认收货成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(5))) {
				throw new exception('订单状态错误！');
			}

			//更新订单状态
			$oInfo->order_status 	= 6;
			$oInfo->receive_time 	= time();
			$oInfo->update_time 	= time();
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('订单状态修改失败！');
			}

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminReceived';
			$logData['msg'] 	 = '您的订单已经确认签收!';
			OrderLog::model()->addOrderLog($logData);

		}catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '确认收货失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}

	/**
	 * 订单【关闭】
	 */
	public function actionCloseOrder()
	{
		$res = array('statusCode' => 200,'message' => '关闭成功！');
		try{
			$oInfo = Order::model()->findByPk($_REQUEST['id']);
			if(empty($oInfo)){
				throw new exception('订单不存在！');
			}elseif(!in_array($oInfo['order_status'], array(6))) {
				throw new exception('订单状态错误！');
			}

			$oInfo->order_status 	= 7;
			$oInfo->update_time 	= time();
			$flag = $oInfo->save();
			if(empty($flag)){
				throw new exception('订单关闭失败！',500);
			}

			$logData = array();
			$logData['order_id'] = $oInfo->id;
			$logData['type'] 	 = 'AdminClosed';
			$logData['msg'] 	 = '您的订单已经超过退换货时间，已关闭该交易!';
			OrderLog::model()->addOrderLog($logData);

		} catch(exception $e){
			$res['statusCode'] = 500;
			$res['message'] = '关闭失败!【'.$e->getMessage().'】';
		}
		$res['callbackType'] = 'reloadTab';
		$res['forwardUrl'] = '/manage/order/index';
		$this->ajaxDwzReturn($res);
	}


}