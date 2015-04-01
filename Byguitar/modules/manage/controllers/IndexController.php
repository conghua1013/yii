<?php

class IndexController extends ManageController {

	public function actionIndex(){
                $this->render('index',array());
	}

	public function actionTop(){
                $this->render('top',array());
	}
        
        public function actionLeft(){
	       $this->render('left',array());	
        }

        public function actionRight() {
               $this->render('right',array());
        }


}
