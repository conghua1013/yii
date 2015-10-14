<?php

class ManageLogin extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'verifyCode'=>Yii::t('user','Verification Code'),
        );
    }

    /**
     * 用户登录的判断及设置。
     * @return bool
     */
    public function checkLogin(){
        if(empty($_POST['email']) || empty($_POST['password'])){
            return false;
        }

        $info = Admin::model()->findByAttributes(array('email'=>$_POST['email']));
        if(empty($info) || empty($info->password)){
            return false;
        }

        if(md5($_POST['password']) === $info->password){
            Yii::app()->session['manage_id']    = $info['id'];
            Yii::app()->session['manage_email'] = $info['email'];
            if(isset($_POST['is_remember']) && $_POST['is_remember'] == 1){
                //设置cookie
                $manage_id = new CHttpCookie('manage_id',md5($info['id']).$info['id']);
                $manage_id -> expire = time()+(3600*24*7);//保存一周
                Yii::app()->request->cookies['manage_id'] = $manage_id;

                //cookie中保存邮箱
                $manage_email = new CHttpCookie('manage_email',$info['email']);
                $manage_email -> expire = time()+(3600*24*7);//保存一周
                Yii::app()->request->cookies['manage_email'] = $manage_email;

                //cookie中保存邮箱
                $manage_pwd = new CHttpCookie('manage_pwd',md5($info['password'].$info['id']));
                $manage_pwd -> expire = time()+(3600*24*7);//保存一周
                Yii::app()->request->cookies['manage_pwd'] = $manage_pwd;

                //使用cookie
                //echo Yii::app()->request->cookies['hobby'],"

                //删除cookie
                //unset(Yii::app()->request->cookies['sex']);
            }
            return true;
        }

        return false;
    }

    /**
     * 验证以保存密码的用户信息
     */
    public function checkManageLogin(){
        if(empty(Yii::app()->request->cookies['manage_id']) || empty(Yii::app()->request->cookies['manage_email']) || empty(Yii::app()->request->cookies['manage_pwd'])){
            return false;
        }

        $info = Admin::model()->findByAttributes(array('email'=>Yii::app()->request->cookies['manage_email']));
        if(empty($info) || empty($info->password)){
            return false;
        }

        $id = substr(Yii::app()->request->cookies['manage_id'],32);
        $mcrypt_pwd = md5($info['password'].$info['id']);
        if($id == $info['id'] && $mcrypt_pwd == Yii::app()->request->cookies['manage_pwd']){
            Yii::app()->session['manage_id']    = $info['id'];
            Yii::app()->session['manage_email'] = $info['email'];
            return true;
        }
        return false;
    }
}