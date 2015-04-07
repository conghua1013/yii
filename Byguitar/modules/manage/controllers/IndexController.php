<?php

class IndexController extends ManageController {

	public function actionIndex(){
         $viewData = array();
        $this->render('index',$viewData);
	}

	public function actionTop(){
        $viewData = array();
        $this->render('top', $viewData);
	}
        
    public function actionLeft(){
        $model = Menu::model();
        $list = $model->getMenuList();
        $viewData = array();
        $viewData['list'] = $list;
        $this->render('left', $viewData);	
    }

    public function actionRight() {
        $viewData = array();
        $this->render('right', $viewData);
    }


}
