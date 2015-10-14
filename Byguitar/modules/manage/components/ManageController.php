<?php

class ManageController extends CController {
    public $layout = 'manage';

    public function ajaxDwzReturn($data){
    	$res = array();
		$res['statusCode'] 		= isset($data['statusCode']) ? $data['statusCode'] : '200';
		$res['message'] 		= isset($data['message']) ? $data['message'] : 'success';
		$res['navTabId'] 		= isset($data['navTabId']) ? $data['navTabId'] : '';
		$res['rel'] 			= isset($data['rel']) ? $data['rel'] : '';
		$res['callbackType'] 	= isset($data['callbackType']) ? $data['callbackType'] : '';
		$res['forwardUrl'] 		= isset($data['forwardUrl']) ? $data['forwardUrl'] : '';
		$res['confirmMsg'] 		= isset($data['confirmMsg']) ? $data['confirmMsg'] : '';
		echo json_encode($res);
		return;
    }

	public function displayJson($data)
	{
		header("Content-type:json/application;charset=utf-8");
		echo json_encode($data);
	}

}





