<?php

class PaymentController extends ManageController {

    //列表页面
    public function actionIndex(){
        $list = Payment::model()->getPaymentListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $this->render('index', $viewData);
    }

    public function actionAdd(){
        if(empty($_POST)){
            $viewData = array();
            $this->render('add', $viewData);exit;
        }

        try{
            $imageConfig = Yii::app()->params['image']['bank'];
            if(empty($imageConfig)){
                throw new exception('缺少商品图片配置');
            }
            $image = CUploadedFile::getInstanceByName('payment_logo');
            $imageNamePath = '';
            if($image){
               $imageName = date('YmdHis').rand(1,1000);
                $imageNamePath = $imageConfig['path'].$imageName.'.'.$image->getExtensionName();
                $image->saveAs($imageNamePath,true); 
            }
            
            $payment = new Payment();
            $payment->pay_code 		= $_POST['pay_code'];
            $payment->pay_name 		= $_POST['pay_name'];
            $payment->payment_logo 	= str_replace(ROOT_PATH,'',$imageNamePath);
            $payment->keya 		= $_POST['keya'];
            $payment->keyb 		= $_POST['keyb'];
            $payment->is_valid 		= $_POST['is_valid'];
            $payment->is_plat 		= $_POST['is_plat'];
            $payment->sort 		= $_POST['sort'];
            $flag = $payment->save();
            if($flag){
                $message = '添加成功!';
                $status = 200;
            }else{
                $message = '添加失败!';
                $status = 300;
            }
        } catch(Exception $e){
            $message = $e->getMessage();
            $status = 300;
        }

        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    public function actionEdit(){
        if(empty($_POST)){
            $info = Payment::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData);exit;
        }

        try{
            $imageConfig = Yii::app()->params['image']['bank'];
            if(empty($imageConfig)){
                throw new exception('缺少商品图片配置');
            }
            $image = CUploadedFile::getInstanceByName('payment_logo');
            $imageNamePath = '';
            if($image){
               $imageName = date('YmdHis').rand(1,1000);
                $imageNamePath = $imageConfig['path'].$imageName.'.'.$image->getExtensionName();
                $flag = $image->saveAs($imageNamePath,true); 
                if(empty($flag)){
                    throw new Exception('图片保存失败');
                }
            }
            
            $payment =  Payment::model()->findByPk($_REQUEST['id']);
            $payment->pay_code 		= $_POST['pay_code'];
            $payment->pay_name 		= $_POST['pay_name'];
            $payment->payment_logo      = str_replace(ROOT_PATH,'',$imageNamePath);
            $payment->keya 		= $_POST['keya'];
            $payment->keyb 		= $_POST['keyb'];
            $payment->is_valid 		= $_POST['is_valid'];
            $payment->is_plat 		= $_POST['is_plat'];
            $payment->sort 		= $_POST['sort'];
            $flag = $payment->save();
            if($flag){
                $message = '修改成功!';
                $status = 200;
            }else{
                $message = '修改失败!';
                $status = 300;
            }
        } catch(Exception $e){
            $message = $e->getMessage();
            $status = 300;
        }

        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    public function actionDel(){
        try{
            if(empty($_REQUEST['id'])){
                    throw new Exception("数据错误，id不能为空！", 1);
            }
            $info = Payment::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new Exception('该支付记录不存在');
            }
            
            if($info['payment_logo']){
                $imageConfig = Yii::app()->params['image']['bank'];
                if(empty($imageConfig)){
                    throw new exception('缺少商品图片配置');
                }
                @unlink(ROOT_PATH.$info['payment_logo']);
            }
            
            $flag = Payment::model()->deleteByPk($_REQUEST['id']);
            if($flag){
                    $message = '删除成功!';
                    $status = 200;
            }else{
                    $message = '删除失败!';
                    $status = 300;
            }
        }catch(Exception $e){
                $message = $e->getMessage();
                $status = 300;
        }

        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

}