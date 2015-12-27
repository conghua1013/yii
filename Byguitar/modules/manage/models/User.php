<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class User extends CActiveRecord
{  

	//选择数据库
	public function getDbConnection() {       
          return Yii::app()->byguitar;  
    }   
	
	//单例模式
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//表名、全名
	public function tableName()
	{
		return 'bg_user';
	}

	//获取菜单列表
	public function getUserListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $numPerPage = empty($_REQUEST['numPerPage']) ? 20 : $_REQUEST['numPerPage'];
        $sortField = isset($_REQUEST['orderField']) ? $_REQUEST['orderField'] : 'id';
        $sortFlag = isset($_REQUEST['orderDirection']) ? $_REQUEST['orderDirection'] : 'desc';
		$criteria = new CDbCriteria();
        $criteria->order = $sortField.' '.$sortFlag;
        $criteria->offset = ($pageNum-1) * $numPerPage;
        $criteria->limit = $numPerPage;
        if(isset($_REQUEST['username']) && !empty($_REQUEST['username'])){
        	$criteria->compare('username',$_REQUEST['username'],true);//支持模糊查找
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	);
	}

	/**
	 * 用户的账号验证.
	 * @param $request
	 * @return array|mixed|null|static
	 * @throws exception
	 */
	public function userAuthCheck($request)
	{
		if(empty($request['account'])){
			throw new exception('用户名不能为空!');
		}elseif(empty($request['password'])){
			throw new exception('密码不能为空!');
		}
		// 支持使用绑定帐号登录
		$map = array();
		if (preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', trim($request['account']))) {
			$map['email'] = trim($request['account']);
		} else {
			$map['username'] = trim($request['account']);
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
			$turePassword = substr(md5($request['password']), 8, 16);
		} else {
			$turePassword = md5(md5($request['password']) . $authInfo->salt);
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
			} else {
				//在5min之内，只修改登录失败时间
				$authInfo->logfailtime = $timenow;

			}
			//返回到登录页面
			throw new exception('密码或账号错误，请重新输入!');
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

		return $authInfo;
	}

	/**
	 * 根据用户信息数组生成用户的token
	 * @author mwq2020
	 */
	public function getUserToken($userInfo)
	{
		if(empty($userInfo) || empty($userInfo['id']) ){
			return false;
		}
		$token = md5(md5($userInfo['id'].$userInfo['password']));
		return $token;
	}

	/**
	 * 用户的注册过程
	 * @param $request
	 */
	public function userRegister($request)
	{
		if(empty($request['email'])){
			throw new exception('邮箱不能为空！');
		} elseif(empty($request['password'])){
			throw new exception('密码不能为空！');
		}

		$is_exist = User::model()->findByAttributes(array('email'=>$request['email']));
		if(!empty($is_exist)){
			throw new exception('邮箱已经存在！');
		}
		if(!empty($request['username'])){
			$is_exist = User::model()->findByAttributes(array('username'=>$request['username']));
			if(!empty($is_exist)){
				throw new exception('用户名已经存在！');
			}
		}

		$user = new User();
		$userip			= Yii::app()->request->userHostAddress;
		$salt			= substr(uniqid(rand()), -6);
		$password		= md5(md5($request['password']).$salt);

		//同一ip注册限制
		$registerInfo = User::model()->findByAttributes(array('regip'=>$userip));
		if($registerInfo && (time()-$registerInfo->regtime) < 3600*24){
			throw new exception('同一ip每天只能注册一个账号！');
		}
		//验证码
		//$this->checkverify();
		$user->username = $request['username'];
		$user->email 	= $request['email'];
		$user->password = $password;
		$user->salt 	= $salt;
		$user->regip 	= $userip;
		$user->lastip 	=$userip;
		$user->md5email = '';
		$user->expired = '';
		$regok = $user->save();
		if(empty($regok) && $user->id) {
			header("Content-Type:text/html; charset=utf-8");
			throw new exception('注册失败！');
		}

		return $user;
	}

	/**
	 * 获取用户推送的消息个数
	 * @param $user_id
	 * @return int
	 */
	public function getUserNoticeMessageNum($user_id)
	{
		if(empty($user_id)){
			return 0;
		}
		$where = 'msgtoid = '.$user_id.' and new = 1 and related = 1';
		$msgCount = Yii::app()->byguitar->createCommand()->select('count(1)')->from('bg_pms')->where($where)->queryScalar();
		return $msgCount;
	}

}
