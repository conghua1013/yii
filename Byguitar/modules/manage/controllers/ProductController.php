<?php

class ProductController extends ManageController {

    public function actionIndex(){
        $viewData = array();
        $this->render('index',$viewData);
    }
    
    public function actionAdd(){
        $viewData = array();
        $this->render('add',$viewData);
    } 
}
