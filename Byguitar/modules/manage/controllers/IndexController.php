<?php

class IndexController extends ManageController {

	public function actionIndex(){
                $this->render('index',array());
	}

	public function actionEcho(){
		echo "echo here";
	}



}
