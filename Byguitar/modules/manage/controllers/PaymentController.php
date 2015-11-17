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

    public function actionAdd()
    {
        if(empty($_POST)){
            $viewData = array();
            $this->render('add', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
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
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'paymentList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/payment/index';
        $this->ajaxDwzReturn($res);
    }

    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Payment::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
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
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'paymentList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/payment/index';
        $this->ajaxDwzReturn($res);
    }

    public function actionDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
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
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/payment/index';
        $this->ajaxDwzReturn($res);
    }

    public function actionChangeStatus()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $info = Payment::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new Exception('该支付记录不存在');
            }
            if($info->is_valid != $_REQUEST['is_valid']){
                $info->is_valid = $_REQUEST['is_valid'];
                $flag = $info->save();
                if(!$flag){
                    throw new exception('修改失败');
                }
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/payment/index';
        $this->ajaxDwzReturn($res);
    }

}