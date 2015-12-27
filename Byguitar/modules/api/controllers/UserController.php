<?php

class UserController extends ApiController
{
    /**
     * 用户的登录行为
     */
    public function actionLogin()
    {
        $data = array();
        $message = '';
        $status = 1;
        try {
            $request = $_REQUEST;
            $authInfo = User::model()->userAuthCheck($request);
            $token = User::model()->getUserToken($authInfo);
            $data = array('uid' => $authInfo['id'], 'token' => $token);
        }catch (exception $e){
            $message = '【登录失败】'.$e->getMessage();
            $status = 0;
        }
        $this->ApiAjaxReturn($data,$message,$status);
    }

    /**
     * 用户的注册行为
     */
    public function actionRegister()
    {
        $data = array();
        $message = '';
        $status = 1;
        try{
            $request = $_REQUEST;
            $authInfo = User::model()->userRegister($request);
            $token = User::model()->getUserToken($authInfo);
            $data = array('uid' => $authInfo['id'], 'token' => $token);
        }catch (exception $e){
            $message = '【注册失败】'.$e->getMessage();
            $status = 0;
        }
        $this->ApiAjaxReturn($data,$message,$status);
    }

    /**
     * 用户的个人信息.
     */
    public function actionInfo()
    {
        $data = array();
        $message = '';
        $status = 1;
        try{
            $request = $_REQUEST;
            if(empty($request['id']) || empty($request['token'])){
                throw new exception('用户id或者token不能为空！');
            }
            $userInfo = User::model()->findByPk($request['id']);
            if(empty($userInfo)){
                throw new exception('用户不存在！');
            }else{
                $token = User::model()->getUserToken($userInfo);
                if($request['token'] != $token){
                    throw new exception('token错误！');
                }
            }
            $data = $userInfo->getAttributes();
            $data['avatar'] = '/Public/Images/avatar/big/'.$data['avatar'];
        }catch (exception $e){
            $message = '【获取用户信息失败】'.$e->getMessage();
            $status = 0;
        }
        $this->ApiAjaxReturn($data,$message,$status);
    }

    /**
     * 用户的个人信息.
     */
    public function actionEdit()
    {

    }
}