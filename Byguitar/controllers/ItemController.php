<?php

class ItemController extends ShopBaseController 
{

	public function actionIndex(){
		$this->render('item/index',array());
	}
}