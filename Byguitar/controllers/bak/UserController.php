<?php

class UserController extends CController {

	//用户登录
	public function actionLogin(){
		$this->render('login',array());
	}

	//用户登录
	public function actionRegister(){
		$this->render('register',array());
	}

	//用户登录退出
	public function actionLogout(){
		$this->render('index',array());
	}
}