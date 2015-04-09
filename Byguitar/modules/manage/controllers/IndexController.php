<?php

class IndexController extends ManageController {

	public function actionIndex(){
        $model = Menu::model();
        $list = $model->getMenuListTree();
        $viewData = array();
        $viewData['list'] = $list;
        $this->render('index',$viewData);
	}

}
