<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Order extends CActiveRecord
{  

	//选择数据库
	public function getDbConnection() {       
        return Yii::app()->shop;  
    }   
	
	//单例模式
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//表名、全名
	public function tableName()
	{
		return 'bg_order';
	}

	//获取菜单列表
	public function getOrderListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['order_sn'])){
            $criteria->compare('order_sn',$_REQUEST['order_sn'],true);
        }
        if(!empty($_REQUEST['consignee'])){
            $criteria->compare('consignee',$_REQUEST['consignee'],true);
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	'pageNum'=>$pageNum,
        	);
	}

	//获取订单详情
	public function getOrderInfo($oId){
		$info = self::model()->findByPk($oId);
		return $info;
	}

	/**
	 * 生成订单好
	 * @return string
	 */
	public function getOrderSn()
	{
		$sn = array();
		$rand = rand(0,99999);
		$rand = str_pad($rand,5,"0",STR_PAD_LEFT);
		$sn[] = date('Ymd');
		$sn[] = $rand;
		$sn = implode('',$sn);
		return 'BG'.$sn;
	}



	public function getOrderStatus($id=0,$is_array=false)
	{
		$status = array(0=>'新订单',1=>'已支付',2=>'待审核',3=>'待备货',4=>'待发货',5=>'已发货',6=>'已确认收货',7=>'已关闭',8=>'已退货',9=>'已取消',10=>'无效订单');
		if($is_array){
			return $status;
		}

		return isset($status[$id]) ? $status[$id] : '';
	}

	//支付状态
	public function getPayStatus($id=0,$is_array=false)
	{
		$status = array(0=>'未支付',1=>'已支付',2=>'已退款',3=>'部分退款');
		if($is_array){
			return $status;
		}

		return isset($status[$id]) ? $status[$id] : '';
	}

	//发货状态
	public function getShippingStatus($id=0,$is_array=false)
	{
		$status = array(0=>'未发货',1=>'已发货',2=>'已退回',3=>'部分发货',4=>'部分退回');
		if($is_array){
			return $status;
		}

		return isset($status[$id]) ? $status[$id] : '';
	}




	/**
	 * 设置订单为支付状态(支付宝会掉或者跳转通知)
	 * @param $ordersn
	 * @param $paid_money
	 * @param $tradeNo
	 * @return bool
	 */
	public function saveOrderPaid($ordersn,$paid_money,$tradeNo)
	{
		if(empty($ordersn)){return false;}
		$map = array();
		$map['order_sn'] = addslashes(trim($ordersn));
		$oInfo = Order::model()->findByAttributes($map);
		if(empty($oInfo)){
			throw new exception('订单不存在!');
		}

		$needPaidMoney = $oInfo->order_amount -$oInfo->pay_amount -$oInfo->coupon_amount;
		if(in_array($oInfo->order_status, array(1,3,4,5,6,7) ) && $needPaidMoney == 0){
			return true;
		}elseif($paid_money != $needPaidMoney){
			throw new exception('订单待支付金额和已支付金额不匹配!');
		}

		//设置订单的状态
		$oInfo->order_status 	= 1;
		$oInfo->pay_status 	= 1;
		$oInfo->pay_time 		= time();
		$oInfo->pay_amount 	= $paid_money;
		$oInfo->update_time 	= time();
		$oInfo->trade_no 		= $tradeNo;
		$flag = $oInfo->save();
		if(empty($flag)){
			throw new exception('订单状态保存失败!');
		}

		//保存订单的支付日志
		$m = new OrderPayLog();
		$m->user_id 	= $oInfo->user_id;
		$m->order_id 	= $oInfo->id;
		$m->pay_id 		= $oInfo->pay_id;
		$m->pay_amount 	= $paid_money;
		$m->pay_time 	= time();
		$m->add_time 	= time();
		$flag = $m->save();
		if(empty($flag)){
			throw new exception('订单支付日志保存失败!');
		}

		//保存订单的支付日志
		$m = new OrderLog();
		$m->order_id 	= $oInfo->id;
		$m->admin_id 	= 0;
		$m->admin_name 	= '管理员';
		$m->phone 		= '';
		$m->type 		= 'alipayPaid';
		$m->msg 		= '您的订单已支付成功!';
		$m->is_show 	= 1;
		$m->add_time 	= time();
		$flag = $m->save();
		if(empty($flag)){
			throw new exception('订单日志保存失败!');
		}

		return true;
	}


	/**
	 *【用户中心】用户订单数据分页
	 * @param $userId
	 * @return array
	 */
	public function getUserOrderListPage($userId,$request)
	{
		$pageNum = empty($request['p']) ? 1 : intval($request['p']);
		$page_size = 10;
		$criteria = new CDbCriteria();
		$criteria->compare('user_id',$userId);
		$criteria->order = 'id DESC';
		$criteria->offset = ($pageNum-1) * $page_size;
		$criteria->limit = $page_size;

		$count = self::model()->count($criteria);
		$list = self::model()->findAll($criteria);

		$newList = array();
		$product_ids = array();
		if(!empty($list)){
			foreach($list as $row){
				$temp = $row->getAttributes();
				//if($row->product_id > 0 && !in_array($row->product_id,$product_ids)){
				//	array_push($product_ids,$row->product_id);
				//}
				$newList[$row->id] = $temp;
			}
		}

		return array(
			'count'=>$count,
			'list'=>$newList,
			'p'=>$pageNum,
			'page_size'=>$page_size,
			'product_ids' => $product_ids,
		);
	}

	/**
	 *【用户中心】获取订单详情【用户中心订单展示】.
	 * @param $userId
	 * @param $order_sn
	 */
	public function getUserOrderInfoBySn($userId,$order_sn)
	{
		if(empty($order_sn)){
			throw new exception('订单号不能为空',302);
		}
		$oInfo = Order::model()->findByAttributes(array('order_sn'=>$order_sn));
		if(empty($oInfo)){
			throw new exception('订单不存在',302);
		}
		if($userId != $oInfo->user_id){
			throw new exception('订单和数据部匹配',302);
		}
		$oInfo = $oInfo->getAttributes();
		$oInfo['order_status_txt'] = $this->getOrderStatus($oInfo['order_status']);

		$addressData = array($oInfo['province'],$oInfo['city'],$oInfo['district']);
		$addData = Address::model()->getAddressInfoByIds($addressData);
		if(!empty($addData)){
			$oInfo['province_name'] = isset($addData[$oInfo['province']]) ? $addData[$oInfo['province']]['region_name'] : '';
			$oInfo['city_name'] = isset($addData[$oInfo['city']]) ? $addData[$oInfo['city']]['region_name'] : '';
			$oInfo['district_name'] = isset($addData[$oInfo['district']]) ? $addData[$oInfo['district']]['region_name'] : '';
		} else {
			$oInfo['province_name'] = '';
			$oInfo['city_name'] = '';
			$oInfo['district_name'] = '';
		}

		if($oInfo['shipping_id']){
			$shippingInfo = Shipping::model()->findByPk($oInfo['shipping_id']);
			$oInfo['shipping_name'] = empty($shippingInfo) ? '暂无快递信息' : $shippingInfo->shipping_name;
		}

		if($oInfo['pay_id']){
			$payInfo = Payment::model()->findByPk($oInfo['pay_id']);
			$oInfo['payment_name'] = empty($payInfo) ? '暂无快递信息' : $payInfo->pay_name;
		}

		$oInfo['need_pay_amount'] = $oInfo['product_amount'] + $oInfo['shipping_fee'] - $oInfo['coupon_amount'] - $oInfo['discount'] - $oInfo['pay_amount'];
		return $oInfo;
	}

	/**
	 * 【用户中心】订单详情页面展示进度条数据
	 * @param $oInfo
	 * @return array|bool
	 */
	public function getOrderStatusForUserPage($oInfo)
	{
		if(empty($oInfo)){return false;}

		$res = array();
		//下单时间
		$res['create']['name'] 	= '提交订单成功';
		$res['create']['time'] 	= empty($oInfo['add_time']) ? '' : date('Y-m-d H:i:s',$oInfo['add_time']);
		$res['create']['status'] = true;

		//付款时间
		$res['pay']['name'] 	= '已付款';
		$res['pay']['time'] 	= empty($oInfo['pay_time']) ? '' : date('Y-m-d H:i:s',$oInfo['pay_time']);
		if(empty($oInfo['pay_time'])){
			$res['pay']['status']  	=  false;
		}else{
			$res['create']['status'] 	=  true;
			$res['pay']['status'] 		=  true;
		}


		//配货时间
		$res['prepare']['name'] 	= '开始配货';
		$res['prepare']['time'] 	= empty($oInfo['prepare_time']) ? '' : date('Y-m-d H:i:s',$oInfo['prepare_time']);
		if(empty($oInfo['prepare_time'])){
			$res['prepare']['status']  	=  false;
		}else{
			$res['pay']['status'] 		=  true;
			$res['create']['status'] 	=  true;
			$res['prepare']['status'] 	=  true;
		}

		//发货时间
		$res['send']['name'] 	= '已发货';
		$res['send']['time'] 	= empty($oInfo['shipping_time']) ? '' : date('Y-m-d H:i:s',$oInfo['shipping_time']);
		if(empty($oInfo['shipping_time'])){
			$res['send']['status']  	=  false;
		}else{
			$res['pay']['status'] 		=  true;
			$res['create']['status'] 	=  true;
			$res['prepare']['status'] 	=  true;
			$res['send']['status'] 		=  true;
		}


		//收货时间
		$res['receive']['name'] 	= '订单送达';
		$res['receive']['time'] 	= empty($oInfo['receive_time']) ? '' : date('Y-m-d H:i:s',$oInfo['receive_time']);
		if(empty($oInfo['receive_time'])){
			$res['receive']['status']  	=  false;
		}else{
			$res['pay']['status'] 		=  true;
			$res['create']['status'] 	=  true;
			$res['prepare']['status'] 	=  true;
			$res['send']['status'] 		=  true;
			$res['receive']['status'] 	=  true;
		}
		return $res;
	}

	/**
	 * 订单确认收货
	 */
	public function receivedOrder($userId,$order_sn)
	{
		if(empty($userId)){
			throw new exception('用户未登陆！', 2);
		}
		if(empty($order_sn)){
			throw new exception('参数错误！');
		}
		$oInfo = Order::model()->findByAttributes(array('order_sn'=>$order_sn));
		if(empty($oInfo)){
			throw new exception('订单错误！');
		} elseif($oInfo['user_id'] != $userId) {
			throw new exception('订单错误！');
		} elseif(!in_array($oInfo['order_status'], array(5))) {
			throw new exception('订单状态错误！');
		}

		//更新订单状态
		$oInfo->order_status 	= 6;
		$oInfo->receive_time 	= time();
		$oInfo->update_time 	= time();
		$flag = $oInfo->save();
		if(empty($flag)){
			throw new exception('订单保存错误！', 500);
		}

		//添加订单日志
		$m = new OrderLog();
		$m->order_id 	= $oInfo->id;
		$m->admin_id 	= '管理员';
		$m->admin_name 	= '管理员';
		$m->phone 		= '';
		$m->type 		= 'UserReceived';
		$m->msg 		= '您的订单已经确认签收！';
		$m->is_show 	= 1;
		$m->add_time 	= time();
		$flag = $m->save();
		if(empty($flag)){
			throw new exception('确认收货失败！', 6);
		}
		return true;
	}


	/**
	 * 取消订单接口
	 */
	public function cancelOrder($userId,$order_sn)
	{
		if(empty($userId)){
			throw new exception('用户未登陆！', 2);
		}
		if(empty($order_sn)){
			throw new exception('参数错误！');
		}
		$oInfo = Order::model()->findByAttributes(array('order_sn'=>$order_sn));
		if(empty($oInfo)){
			throw new exception('订单不存在！');
		} elseif($oInfo['user_id'] != $userId) {
			throw new exception('订单错误！');
		} elseif(!in_array($oInfo['order_status'], array(0,1))) {
			throw new exception('订单状态错误！');
		}

		//更新订单状态
		$oInfo->order_status 	= 9;
		$oInfo->update_time 	= time();
		$flag = $oInfo->save();
		if(empty($flag)){
			throw new exception('订单保存错误！', 500);
		}

		//添加订单日志
		$m = new OrderLog();
		$m->order_id 	= $oInfo->id;
		$m->admin_id 	= '管理员';
		$m->admin_name 	= '管理员';
		$m->phone 		= '';
		$m->type 		= 'UserCanced';
		$m->msg 		= '您的订单已取消！';
		$m->is_show 	= 1;
		$m->add_time 	= time();
		$flag = $m->save();
		if(empty($flag)){
			throw new exception('订单取消失败！',500);
		}
		return false;
	}

}
