<?php

class CartController extends ShopBaseController 
{

    public function actionIndex(){
        $this->render('cart/index',array());
    }
}