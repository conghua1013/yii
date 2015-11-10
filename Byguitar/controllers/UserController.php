<?php

class UserController extends ShopBaseController
{

	/**
	 * 用户登录
	 */
	public function actionLogin()
	{
		//已登录跳转到首页
		$user_id = Yii::app()->session['authId'];
		if($user_id){
			$this->redirect('/');exit;
		}

		// 未登录的显示登录页面
		if(empty($_POST)){
			$this->render('user/login',array());exit;
		}

		// 发送登录信息的进行登录验证
		try {
			// 支持使用绑定帐号登录
			$map = array();
			if (preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', trim($_POST['account']))) {
				$map['email'] = trim($_POST['account']);
			} else {
				$map['username'] = trim($_POST['account']);
			}
			$authInfo = $User = User::model()->findByAttributes($map);
			if (empty($authInfo)) {
				throw new exception('帐号不存在或已禁用!');
			}

			//大于限制时间解除锁定-目前定为半时
			if (time() - $authInfo->logfailtime > (60 * 30)) {
				$authInfo->logfail = 0;
				$authInfo->logfailtime = 0;
			}

			if($authInfo > 2){
				//失败次数超过三
				//检查时间，如果上次登录失败在半个小时前，则解锁，给用户一次重新登录机会。只有一次机会
				$datetime = time() - (60 * 30);
				if ($authInfo->logfailtime < $datetime)  //半个小时以前
				{
					$authInfo->logfail = 0;
					$authInfo->save();
					throw new exception('你可以再重新登录一次！');
				} else {
					//半个小时内，则锁定帐户，返回到登录页面，半个小时后解锁
					$authInfo->logfailtime = time();
					$authInfo->save();
					throw new exception('您的账号目前被锁定，半个小时后自动解锁。请解锁后登录！');
				}
			}

			if ($authInfo->salt == '0') {
				$turePassword = substr(md5($_POST['password']), 8, 16);
			} else {
				$turePassword = md5(md5($_POST['password']) . $authInfo->salt);
			}

			//密码错误，登录失败
			if ($authInfo->password != $turePassword) {
				//检查上次登录失败时间是否在10秒之内，如果不是，则登录失败次数增加1
				$datetime = time() - (10);//获取10秒以前的时间
				$timenow = time();//获取现在的时间
				//不在5min之内
				if ($authInfo->logfailtime < $datetime) {
					//登录失败次数加1时间更新
					$authInfo->logfail += 1;
					$authInfo->logfailtime = $timenow;
					$authInfo->save();
				} else  //在5min之内，只修改登录失败时间
				{
					$authInfo->logfailtime = $timenow;
					$authInfo->save();
				}
				//返回到登录页面
				throw new exception('密码或账号错误，请重新输入!');
			}
			$where = 'msgtoid = '.$authInfo->id.' and new = 1 and related = 1';
			$msgCount = Yii::app()->byguitar->createCommand()->select('count(1)')->from('bg_pms')->where($where)->queryScalar();

			Yii::app()->session['authId'] 			= $authInfo->id;
			Yii::app()->session['email'] 			= $authInfo->email;
			Yii::app()->session['loginUserName'] 	= $authInfo->username;
			Yii::app()->session['face'] 			= $authInfo->avatar;
			Yii::app()->session['isadmin'] 			= $authInfo->adminid;
			Yii::app()->session['msg'] 				= $msgCount;
			Yii::app()->session['isoldman'] 		= time() - $authInfo->regtime > (3600 * 24 * 7) ? true : false;


			if (!empty($_POST['remember']) && ($_POST['remember'] == "1")) {
				//写入Cookie
				$user_id = new CHttpCookie('identifier',$authInfo->id);
				$user_id -> expire = time()+(3600*24*7);//保存一周
				Yii::app()->request->cookies['identifier'] = $user_id;

				$token = new CHttpCookie('token',$authInfo->password);
				$token -> expire = time()+(3600*24*7);//保存一周
				Yii::app()->request->cookies['token'] = $token;
			}

			$authInfo->lastlogin 	= time();
			$authInfo->logins 		= array('exp', 'logins+1');
			$authInfo->lastip 		= Yii::app()->request->userHostAddress;
			$authInfo->logfail 		= 0;
			$authInfo->logfailtime 	= 0;
			$flag = $authInfo->save();
			if (empty($flag)) {
				throw new exception('登录失败！');
			}

		}catch (exception $e){
			$viewData = array();
			$viewData['msg'] = $e->getMessage();
			$this->render('/user/login',$viewData);
		}

		$this->redirect('/');
	}

	//用户登录
	public function actionRegister()
	{
		//已登录跳转到首页
		$user_id = Yii::app()->session['authId'];
		if($user_id){
			$this->redirect('/');exit;
		}

		// 未登录的显示登录页面
		if(empty($_POST)){
			$viewData = array();
			$this->render('user/register',$viewData);exit;
		}

		try{
			//同一ip注册限制
			$user = new User();

			$userip			= Yii::app()->request->userHostAddress;
			$salt			= substr(uniqid(rand()), -6);
			$password		= md5(md5($_POST['password']).$salt);

			$registerInfo = User::model()->findByAttributes(array('regip'=>$userip));
			if($registerInfo && (time()-$registerInfo->regtime) < 3600*24){
				throw new exception('同一ip每天只能注册一个账号！');
			}
			//验证码
			//$this->checkverify();
			$user->username = $_POST['email'];
			$user->password = $password;
			$user->salt 	= $salt;
			$user->regip = $userip;

			//写入注册所在ip
			$user->regip 	=$userip;
			$user->lastip 	=$userip;
			$user->password =$password;
			$user->salt 	=$salt;
			$regok = $user->save();
			if(empty($regok)){
				header("Content-Type:text/html; charset=utf-8");
				throw new exception('注册失败！');
			}

			Yii::app()->session['authId'] 			= $user->id;
			Yii::app()->session['email'] 			= $user->email;
			Yii::app()->session['loginUserName'] 	= $user->username;
			Yii::app()->session['face'] 			= $user->avatar;
			Yii::app()->session['isadmin'] 			= $user->adminid;
			Yii::app()->session['msg'] 				= $user;
			Yii::app()->session['isoldman'] 		= time() - $user->regtime > (3600 * 24 * 7) ? true : false;

		}catch (exception $e){
			$viewData = array();
			$this->render('user/register',$viewData);exit;
		}
		$this->redirect('/');
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
		$productList = Product::model()->getProductInfoByIds($product_ids);

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

	// todo 未完待续

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
			$this->redirect('/?from=order_error');
		}

		$viewData = array();
		$viewData['info'] 		= $oInfo;
		$viewData['status'] 	= $status;
		$viewData['logs'] 		= $logs;
		$viewData['orderProduct'] 	= $orderProduct;
		$this->render('/user/order',$viewData);
	}

}