<?php

class IndexController extends CController
{

	public function actionIndex(){
		$this->render('index');
	}

	public function actionTest()
	{
		$model = User::model();
		$_GET['id'] = 1;
		$info = $model->findbyPk($_GET['id'])->getAttributes();
		echo "<pre>";
		print_r($info);
		echo "<hr>";

		$product = Yii::app()->shop->createCommand()
		->select('*')
		->from('bg_product')
		->where('id = 1')
		->queryRow();
		print_r($product);
	}

	public function actionTestShiwu(){
		//创建db链接
		$db_byguitar = Yii::app()->byguitar;
		$db_shop = Yii::app()->shop;

		//创建事务
		$db_byguitar_trans = $db_byguitar->beginTransaction();
		$db_shop_trans = $db_byguitar->beginTransaction();

		try{

			# 数据库操作、、、

			throw new exception('aaaa',1);//数据库操作失败，抛出异常，跳转到执行回滚程序。

			#成功提交事务
			$db_byguitar_trans->commit();
			$db_shop_trans->commit();
		} catch (exception $e){
			#失败、事务回滚。
			$db_byguitar_trans->rollback();
			$db_shop_trans->rollback();
		}
		return true;		
	}

	public function actionTestInsert(){
		$model = new User;        
		$model->username='aaa'; 
		$model->password='bbb'; 
		if($model->save()>0){

		}
	}

	//测试更新
	public function actionTestUpdate(){
		$count = User::model()->updateAll(array('username'=>'11111','password'=>'11111'),'password=:pass',array(':pass'=>'1111a1')); 
		if($count>0){  

		}
	}

	//测试删除
	public function actionTestDelete(){
		User::model()->deleteByPk($pk,$condition,$params); 
	}

	//测试查询
	public function actionTestSelect(){
		//直接执行查询
		$sql = "select * from bg_user where id = 1";
		$res = yii::app()->byguitar->createCommand($sql);

		//直接model实例化查询
		$model = User::model();
		$res = $model->findbyPk(1); //对象格式
		$res = $model->findbyPk(1)->getAttributes();//数组格式

		//构造方法获取数据
		$criteria=new CDbCriteria; 
		$criteria->select='product_name';  // 只选择 'title' 列 
		$criteria->condition='id=1'; 
		$product = Product::model()->find($criteria);


		//联合查询
		$user = Yii::app()->shop->createCommand() 
	    ->select('p.id, p.product_name, p.cat_id, b.brand_name') 
	    ->from('bg_product p') 
	    ->join('bg_branch b', 'p.brand_id=b.id') 
	    ->where('id=:id', array(':id'=>1)) 
	    ->queryRow();

	    //Yii::app()->shop->createCommand()->text() //查看sql

	    //in的用法
	    //where(array('in', 'id', array(1,2,3)))

	    //and的用法
	    // where(array('and', 'id=:id', 'username=:username'), array(':id'=>$id, ':username'=>$username);
		// 在where()中使用 OR 与 AND用法相同，如下：  ##看起来比直接写更加繁琐##
		// where( array('and', 'type=1', array('or', 'id=:id','username=:username') ),array(':id'=>$id, ':username'=>$username ));

		// LIKE 用法
		//where( array('like', 'name', '%tester%') );

		// ->select(): SELECT子句
		// ->selectDistinct(): SELECT子句，并保持了记录的唯一性
		// ->from():         构建FROM子句
		// ->where():        构建WHERE子句
		// ->join():         在FROM子句中构建INNER JOIN 子句
		// ->leftJoin():     在FROM子句中构建左连接子句
		// ->rightJoin():    在FROM子句中构建右连接子句
		// ->crossJoin():    添加交叉查询片段(没用过)
		// ->naturalJoin():  添加一个自然连接子片段
		// ->group():        GROUP BY子句
		// ->having():       类似于WHERE的子句，但要与GROUP BY连用
		// ->order():        ORDER BY子句
		// ->limit():        LIMIT子句的第一部分
		// ->offset():       LIMIT子句的第二部分
		// ->union():        appends a UNION query fragment

	}


	// public $layout='column1';

	// /**
	//  * Declares class-based actions.
	//  */
	// public function actions()
	// {
	// 	return array(
	// 		// captcha action renders the CAPTCHA image displayed on the contact page
	// 		'captcha'=>array(
	// 			'class'=>'CCaptchaAction',
	// 			'backColor'=>0xFFFFFF,
	// 		),
	// 		// page action renders "static" pages stored under 'protected/views/site/pages'
	// 		// They can be accessed via: index.php?r=site/page&view=FileName
	// 		'page'=>array(
	// 			'class'=>'CViewAction',
	// 		),
	// 	);
	// }

	// /**
	//  * This is the action to handle external exceptions.
	//  */
	// public function actionError()
	// {
	//     if($error=Yii::app()->errorHandler->error)
	//     {
	//     	if(Yii::app()->request->isAjaxRequest)
	//     		echo $error['message'];
	//     	else
	//         	$this->render('error', $error);
	//     }
	// }

	// /**
	//  * Displays the contact page
	//  */
	// public function actionContact()
	// {
	// 	$model=new ContactForm;
	// 	if(isset($_POST['ContactForm']))
	// 	{
	// 		$model->attributes=$_POST['ContactForm'];
	// 		if($model->validate())
	// 		{
	// 			$headers="From: {$model->email}\r\nReply-To: {$model->email}";
	// 			mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
	// 			Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
	// 			$this->refresh();
	// 		}
	// 	}
	// 	$this->render('contact',array('model'=>$model));
	// }

	// /**
	//  * Displays the login page
	//  */
	// public function actionLogin()
	// {
	// 	if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
	// 		throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

	// 	$model=new LoginForm;

	// 	// if it is ajax validation request
	// 	if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
	// 	{
	// 		echo CActiveForm::validate($model);
	// 		Yii::app()->end();
	// 	}

	// 	// collect user input data
	// 	if(isset($_POST['LoginForm']))
	// 	{
	// 		$model->attributes=$_POST['LoginForm'];
	// 		// validate user input and redirect to the previous page if valid
	// 		if($model->validate() && $model->login())
	// 			$this->redirect(Yii::app()->user->returnUrl);
	// 	}
	// 	// display the login form
	// 	$this->render('login',array('model'=>$model));
	// }

	// /**
	//  * Logs out the current user and redirect to homepage.
	//  */
	// public function actionLogout()
	// {
	// 	Yii::app()->user->logout();
	// 	$this->redirect(Yii::app()->homeUrl);
	// }
}
