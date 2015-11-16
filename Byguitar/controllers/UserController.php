<?php

class UserController extends ShopBaseController
{

	/**
	 * 用户登录【登录页面、弹出层登录】
	 */
	public function actionLogin()
	{
		//已登录跳转到首页
		$user_id = Yii::app()->session['authId'];
		if($user_id){
			$this->redirect('/?from=is_login');exit;
		}

		// 未登录的显示登录页面
		if(empty($_POST)){
			$this->render('user/login',array());exit;
		}

		//登录操作的验证
		try {
			$request = $_REQUEST;
			$authInfo = User::model()->userAuthCheck($request);

			Yii::app()->session['authId'] 			= $authInfo->id;
			Yii::app()->session['email'] 			= $authInfo->email;
			Yii::app()->session['loginUserName'] 	= $authInfo->username;
			Yii::app()->session['face'] 			= $authInfo->avatar;
			Yii::app()->session['isadmin'] 			= $authInfo->adminid;
			Yii::app()->session['msg'] 				= User::model()->getUserNoticeMessageNum($authInfo->id);
			Yii::app()->session['isoldman'] 		= time() - $authInfo->regtime > (3600 * 24 * 7) ? true : false;

			if (!empty($request['remember']) && ($request['remember'] == "1")) {
				//写入Cookie
				$user_id = new CHttpCookie('identifier',$authInfo->id);
				$user_id -> expire = time()+(3600*24*7);//保存一周
				Yii::app()->request->cookies['identifier'] = $user_id;

				$token = new CHttpCookie('token',$authInfo->password);
				$token -> expire = time()+(3600*24*7);//保存一周
				Yii::app()->request->cookies['token'] = $token;
			}
		}catch (exception $e){
			$viewData = array();
			$viewData['msg'] = $e->getMessage();
			$this->render('/user/login',$viewData);
		}

		$this->redirect('/?from=login');
	}

	/*
	 * 用户的注册【注册页面、弹出层注册】
	 */
	public function actionRegister()
	{
		//已登录跳转到首页
		$user_id = Yii::app()->session['authId'];
		if($user_id){
			$this->redirect('/?from=is_login');exit;
		}

		// 未登录的显示登录页面
		if(empty($_POST)){
			$viewData = array();
			$this->render('user/register',$viewData);exit;
		}

		try{
			$request = $_REQUEST;
			$user = User::model()->userRegister($request);

			Yii::app()->session['authId'] 			= $user->id;
			Yii::app()->session['email'] 			= $user->email;
			Yii::app()->session['loginUserName'] 	= $user->username;
			Yii::app()->session['face'] 			= $user->avatar;
			Yii::app()->session['isadmin'] 			= $user->adminid;
			Yii::app()->session['msg'] 				= $user;
			Yii::app()->session['isoldman'] 		= time() - $user->regtime > (3600 * 24 * 7) ? true : false;

			$user_id = new CHttpCookie('identifier',$user->id);
			$user_id -> expire = time()+(3600*24*7);//保存一周
			Yii::app()->request->cookies['identifier'] = $user_id;

			$token = new CHttpCookie('token',$user->password);
			$token -> expire = time()+(3600*24*7);//保存一周
			Yii::app()->request->cookies['token'] = $token;

		}catch (exception $e){
			$viewData = array();
			$this->render('user/register',$viewData);exit;
		}
		$this->redirect('/?from=register');
	}

	/**
	 * 用户登录退出
	 */
	public function actionLogout()
	{
		Yii::app()->session->destroy(); //移去存储在服务器端的数据
		$cookie = Yii::app()->request->getCookies();
		unset($cookie['identifier']);
		unset($cookie['token']);
		$this->redirect('/user/login');
	}

	/**
	 * 保存用户的收货信息
	 */
	public function actionSaveAddress()
	{
		$res = array('status'=>1,'msg'=>'','list'=>'');

		$userId = $this->user_id;
		$request = $_REQUEST;
		try{
			if(empty($userId)){
				throw new exception('未登录！',2);
			}
			Address::model()->saveAddressInfo($userId,$request);
			$addressList = Address::model()->getUserAddressList($userId);
			$res['status'] 	= empty($addid) ? 0 : 1;
			$res['list'] 	= $addressList;
			$res['addrid'] 	= $addid;
		} catch(exception $e){
			$res['status'] = 0;
			$res['msg'] = $e->getMessage();
		}
		exit(json_encode($res));
	}

	/**
	 * 删除收货地址.
	 */
	public function actionDelAddress()
	{
		$res = array('status'=>1,'msg'=>'');

		$id = $_REQUEST['id'];
		$userId = $this->user_id;
		try{
			Address::model()->delAddress($userId,$id);
		} catch(exception $e){
			$res['status'] = 0;
		}
		exit(json_encode($res));
	}

	/**
	 * 设置默认收货地址.
	 */
	public function actionSetDefaultAddress()
	{
		$res = array('status'=>1,'msg'=>'');

		$id = $_REQUEST['id'];
		$userId = $this->user_id;
		try{
			Address::model()->setDefaultAddress($userId,$id);
		} catch(exception $e){
			$res['status'] = 0;
		}
		exit(json_encode($res));
	}

	/**
	 * 用户的地址列表展示.
	 */
	public function actionAddress()
	{
		$userId = $this->user_id;
		if(empty($userId)){
			$this->redirect('/user/login');
		}
		$list = Address::model()->getUserAddressList($userId);
		$viewData = array();
		$viewData['list'] = $list;
		$this->render('/user/address',$viewData);
	}

	/**
	 * 优惠券列表.
	 */
	public function actionCoupon()
	{
		$userId = $this->user_id;
		if(empty($userId)){
			$this->redirect('/user/login');
		}
		$request = $_REQUEST;
		$result = Coupon::model()->getUserCouponListPage($userId,$request);
		$count = $result['count'];
		$list = $result['list'];
		$coupon_type_ids = $result['coupon_type_ids'];
		$couponTypeList = CouponType::model()->getCouponTypeInfoByIds($coupon_type_ids);

		$pages = '';
		if($count >0 ){
			$pages = Common::instance()->get_page_list($count, $result['p'], $result['page_size'], '','coupon');
		}

		$viewData = array();
		$viewData['pages'] 	= $pages;
		$viewData['list'] 	= $list;
		$viewData['count'] 	= $count;
		$viewData['couponTypeList'] = $couponTypeList;
		$this->render('/user/coupon',$viewData);
	}

	/**
	 * 【用户中心】优惠券绑定
	 */
	public function actionCouponBand()
	{
		$res = array('status'=>1,'msg'=>'');
		$userId = $this->user_id;
		$coupon_sn = trim($_REQUEST['sn']);
		try{
			if(empty($userId)){
				throw new exception('用户未登录',2);
			}
			if(empty($coupon_sn)){
				throw new exception('券号不能为空');
			}
			Coupon::model()->couponBand($userId,$coupon_sn);
		} catch(exception $e){
			$res['status'] = $e->getCode();
			$res['msg'] = $e->getMessage();
		}
		exit(json_encode($res));
	}

	/**
	 * 用户喜欢页面
	 */
	public function actionLike()
	{
		$userId = $this->user_id;
		if(empty($userId)){
			$this->redirect('/user/login');
		}
		$request = $_REQUEST;
		$result = Like::model()->getUserLikeListPage($userId,$request);
		$count = $result['count'];
		$list = $result['list'];
		$product_ids = $result['product_ids'];
		$productList = Product::model()->getProductInfoByIds($product_ids,'all');
//		echo "<pre>";
//		print_r($productList);
//		exit;

		$baseUrl = '/user/like?';
		$pages = '';
		if($count > 0){
			$pages = Common::instance()->get_page_list($count, $result['p'], $result['page_size'], $baseUrl);
		}

		$viewData = array();
		$viewData['pages'] 	= $pages;
		$viewData['list'] 	= $list;
		$viewData['count'] 	= $count;
		$viewData['productList'] = $productList;
		$this->render('/user/like',$viewData);
	}

	/**
	 * 订单列表
	 */
	public function actionOrderlist()
	{
		$userId = $this->user_id;
		if(empty($userId)){
			$this->redirect('/user/login');
		}

		$request = $_REQUEST;
		$result = Order::model()->getUserOrderListPage($userId,$request);
		$count = $result['count'];
		$list = $result['list'];

		$baseUrl = '/user/orderlist?';
		$pages = '';
		if($count > 0){
			$pages = Common::instance()->get_page_list($count, $result['p'], $result['page_size'], $baseUrl);
		}

		$viewData = array();
		$viewData['pages'] 	= $pages;
		$viewData['list'] 	= $list;
		$viewData['count'] 	= $count;
		$this->render('/user/orderlist',$viewData);
	}

	/**
	 * 订单详情
	 */
	public function actionOrder()
	{
		$userId = $this->user_id;
		if(empty($userId)){
			$this->redirect('/user/login');
		}
		$orderSn = addslashes(trim($_REQUEST['ordersn']));
		try {
			$oInfo 		= Order::model()->getUserOrderInfoBySn($userId,$orderSn);
			if(empty($oInfo) || !$oInfo['id']){
				$this->redirect('/?from=no_order');
			}
			$orderProduct 	= OrderProduct::model()->getOrderProductByOrderId($oInfo['id']);

			$status = Order::model()->getOrderStatusForUserPage($oInfo);
			$logs = OrderLog::model()->findAllByAttributes(array('order_id'=>$oInfo['id']));
		} catch (exception $e){
			//echo ''.$e;exit;
			$this->redirect('/?from=order_error');
		}

		$viewData = array();
		$viewData['info'] 		= $oInfo;
		$viewData['status'] 	= $status;
		$viewData['logs'] 		= $logs;
		$viewData['orderProduct'] 	= $orderProduct;
		$this->render('/user/order',$viewData);
	}


	/**
	 * 订单确认收货
	 */
	public function actionReceivedOrder()
	{
		$result = array('status'=>1,'msg'=>'订单确认收货成功!');
		$request = $_REQUEST;
		$order_sn = trim($request['orderSn']);
		try{
			$userId = $this->user_id;
			if(empty($userId)){
				throw new exception('用户未登陆！', 2);
			}
			Order::model()->receivedOrder($userId,$order_sn);
		} catch(exception $e) {
			$result['status'] = 0;
			$result['msg']    = '订单确认收货失败!';
			exit(json_encode($result));
		}
		exit(json_encode($result));
	}


	/**
	 * 取消订单接口
	 */
	public function actionCancelOrder()
	{
		$result = array('status'=>1,'msg'=>'取消成功!');
		$request = $_REQUEST;
		$order_sn = trim($request['orderSn']);

		$tran1 = Yii::app()->shop->beginTransaction();
		$tran2 = Yii::app()->byguitar->beginTransaction();
		try {
			$userId = $this->user_id;
			if(empty($userId)){
				throw new exception('用户未登陆！', 2);
			}
			Order::model()->cancelOrder($userId,$order_sn);
			$tran1->commit();
			$tran2->commit();
		} catch(exception $e){
			$tran1->rollback();
			$tran2->rollback();
			$result['status'] = 0;
			$result['msg'] = '取消失败!';
		}
		exit(json_encode($result));
	}

	/**
	 * 删除喜欢
	 */
	public function actionDelLike()
	{
		$result = array('status'=>1,'msg'=>'取消喜欢成功!');
		$request = $_REQUEST;
		$product_id = trim($request['id']);

		try {
			$userId = $this->user_id;
			if(empty($userId)){
				throw new exception('用户未登陆！', 2);
			}
			Like::model()->delLike($userId,$product_id);
		} catch(exception $e){
			$result['status'] = $e->getMessage();
			$result['msg'] = '取消失败!';
		}
		exit(json_encode($result));
	}

	/**
	 * 添加喜欢.
	 */
	public function actionAddLike()
	{
		$result = array('status'=>1,'msg'=>'添加喜欢成功!');
		$request = $_REQUEST;
		$product_id = trim($request['id']);

		try {
			$userId = $this->user_id;
			if(empty($userId)){
				throw new exception('用户未登陆！', 2);
			}
			Like::model()->addLike($userId,$product_id);
		} catch(exception $e){
			$result['status'] = $e->getCode();
			$result['msg'] = '添加喜欢失败!';
		}
		exit(json_encode($result));
	}



}