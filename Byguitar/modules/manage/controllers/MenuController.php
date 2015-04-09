<?php

class MenuController extends ManageController {

	//列表页面
	public function actionIndex(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];

		$viewData = array();
		$list = Menu::model()->getMenuList();
		$viewData['list'] = $list['list'];
		$viewData['count'] = $list['count'];
		$viewData['pageNum'] = $pageNum;
		$this->render('index', $viewData);
	}

	//添加页面
	public function actionAdd(){
		$viewData = array();
		$this->render('add', $viewData);
	}

	//编辑页面
	public function actionEdit(){
		$viewData = array();
		$this->render('edit', $viewData);
	}

	//删除页面
	public function actionDel(){

	}

	//树状图
	public function actionTree(){
		$viewData = array();
		$this->render('tree', $viewData);
	}

}