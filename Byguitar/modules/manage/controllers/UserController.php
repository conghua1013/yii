<?php

class UserController extends ManageController {

    //列表页面
    public function actionIndex(){
        $list = User::model()->getUserListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['request'] = $_REQUEST;
        $this->render('index', $viewData);
    }


}