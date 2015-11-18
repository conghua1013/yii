<?php
/**
 * 快递管理后台 
 */

class ShippingController extends ManageController {

    //列表页面
    public function actionIndex(){
        $list = Shipping::model()->getShippingListPage();
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
            $m = new Shipping();
            $m->shipping_name   = $_POST['shipping_name'];
            $m->shipping_fee 	= $_POST['shipping_fee'];
            $m->shipping_code   = $_POST['shipping_code'];
            $m->is_show 	= $_POST['is_show'];
            $m->detail 		= $_POST['detail'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'shippingList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/shipping/index';
        $this->ajaxDwzReturn($res);
    }

    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Shipping::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            $m =  Shipping::model()->findByPk($_REQUEST['id']);
            $m->shipping_name   = $_POST['shipping_name'];
            $m->shipping_fee    = $_POST['shipping_fee'];
            $m->shipping_code   = $_POST['shipping_code'];
            $m->is_show         = $_POST['is_show'];
            $m->detail          = $_POST['detail'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'shippingList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/shipping/index';
        $this->ajaxDwzReturn($res);
    }

    public function actionDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = Shipping::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/shipping/index';
        $this->ajaxDwzReturn($res);
    }
	
}