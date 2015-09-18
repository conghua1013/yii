<?php

class IndexController extends ManageController {

	public function actionIndex(){
        $manage_id = Yii::app()->session['manage_id'];
        if(empty($manage_id)){
            $model =new ManageLogin();
            if(!$model->checkManageLogin()){
                $this->redirect('/manage/index/login');
                return '';
            }
        }

        $model = Menu::model();
        $list = $model->getMenuListTree();
        $viewData = array();
        $viewData['list'] = $list;
        $this->render('index',$viewData);
	}

    public function actionLogin()
    {
        $model =new ManageLogin();
        if(!empty($_POST)){
            $verifyCode = $this->createAction('captcha')->getVerifyCode();
            if($verifyCode == $_POST['verifyCode'] && $model->checkLogin()){
                $this->redirect('/manage/index/index');
            }
        }

        $viewData = array();
        $viewData['model'] = $model;
        $this->render('login',$viewData);
    }

    //生成验证码
    public function actionLogout(){
        // Yii::app()->session['manage_id']    = 0;
        // Yii::app()->session['manage_email'] = '';
        // Yii::app()->session->sessionID
        Yii::app()->session->clear(); //移去所有session变量，然后，调用
        Yii::app()->session->destroy(); //移去存储在服务器端的数据
        $cookie = Yii::app()->request->getCookies();
        unset($cookie['manage_id']);
        unset($cookie['manage_email']);
        unset($cookie['manage_pwd']);
        $this->redirect('/manage/index/login');
    }

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
                'maxLength'=>'6',       // 最多生成几个字符
                'minLength'=>'5',       // 最少生成几个字符
                'height'=>'30',
                'width'=>'80',
            ),
        );
    }


}
