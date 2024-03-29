<?php

class CouponController extends ManageController {

    //列表页面
    public function actionTypeIndex(){
        $list = CouponType::model()->getCouponTypeListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $this->render('typeindex', $viewData);
    }

    //添加页面
    public function actionTypeAdd()
    {
        if(empty($_POST)){
            $viewData = array();
            $this->render('typeadd', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        try {
            $m = new CouponType();
            $m->coupon_name         = $_REQUEST['coupon_name'];
            $m->coupon_type         = $_REQUEST['coupon_type'];
            $m->coupon_sn           = $_REQUEST['coupon_sn'];
            $m->coupon_amount       = $_REQUEST['coupon_amount'];
            $m->satisfied_amount 	= $_REQUEST['satisfied_amount'];
            $m->detail              = $_REQUEST['detail'];
            $m->start_time 	        = strtotime( $_REQUEST['start_time']);
            $m->end_time 		    = strtotime($_REQUEST['end_time']);
            $m->add_time            = time();
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'couponTypeList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/coupon/typeIndex';
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionTypeEdit()
    {
        if(empty($_POST)){
            $info = CouponType::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('typeedit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try {
            $m =  CouponType::model()->findByPk($_REQUEST['id']);
            $m->coupon_name         = $_REQUEST['coupon_name'];
            $m->coupon_type         = $_REQUEST['coupon_type'];
            $m->coupon_sn           = $_REQUEST['coupon_sn'];
            $m->coupon_amount       = $_REQUEST['coupon_amount'];
            $m->satisfied_amount 	= $_REQUEST['satisfied_amount'];
            $m->detail 		        = $_REQUEST['detail'];
            $m->start_time 	        = strtotime( $_REQUEST['start_time']);
            $m->end_time 		    = strtotime($_REQUEST['end_time']);
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'couponTypeList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/coupon/typeIndex';
        $this->ajaxDwzReturn($res);
    }

    /**
     * 生成优惠券
     */
    public function actionMakeCoupon()
    {
        if(empty($_POST)){
            $info = CouponType::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('makecoupon', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '生成成功！');
        try {
            $typeInfo = CouponType::model()->findByPk($_REQUEST['id']);
            if(empty($typeInfo)){
                throw new exception('该优惠券类型不存在！');
            }
            $model = Coupon::model();
            $couponSns = array();
            $okNumber = 0;
            
            for($i=0;$i<$_REQUEST['send_num'];$i++){
                $sn = $model->getCouponSn();
                if(in_array($sn,$couponSns)){continue;}
                $m = new Coupon();
                $m->coupon_sn           = $sn;
                $m->coupon_type_id      = $_REQUEST['id'];
                $m->coupon_amount       = $typeInfo['coupon_amount'];
                $m->satisfied_amount    = $typeInfo['satisfied_amount'];
                $m->start_time          = $typeInfo['start_time'];
                $m->end_time            = $typeInfo['end_time'];
                $m->add_time            = time();
                $flag = $m->save();
                $okNumber += empty($flag) ? 0 : 1;
                array_push($couponSns,$sn);
            }

        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'couponTypeList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/coupon/typeIndex';
        $this->ajaxDwzReturn($res);

    }

    //删除页面
    public function actionTypeDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = CouponType::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/coupon/typeIndex';
        $this->ajaxDwzReturn($res);
    }

    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            $info = Coupon::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->is_show = $_REQUEST['is_show'];
            $flag = $info->save();
            if(empty($flag)){
                throw new exception('修改状态失败！');
            }
        } catch (Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/coupon/typeIndex';
        $this->ajaxDwzReturn($res);
    }

    public function actionIndex()
    {
        $list = Coupon::model()->getCouponListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $viewData['request'] = $_REQUEST;
        $this->render('index', $viewData);
    }


    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Coupon::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData); exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try {
            $m =  Coupon::model()->findByPk($_REQUEST['id']);
            $m->coupon_amount       = $_REQUEST['coupon_amount'];
            $m->satisfied_amount    = $_REQUEST['satisfied_amount'];
            $m->start_time          = strtotime( $_REQUEST['start_time']);
            $m->end_time            = strtotime($_REQUEST['end_time']);
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'couponList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/coupon/index';
        $this->ajaxDwzReturn($res);
    }

}