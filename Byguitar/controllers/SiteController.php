<?php

class SiteController extends CController {

	public function actionError(){
		if($error=Yii::app()->errorHandler->error)
	    {
	    	echo "<pre>";
	    	print_r($error['message']);
	    	echo "<hr>";
	    	print_r($error['trace']);
	    	// if(Yii::app()->request->isAjaxRequest)
	    	// 	echo $error['message'];
	    	// else
	     //    	$this->render('error', $error);
	    }
	}
}