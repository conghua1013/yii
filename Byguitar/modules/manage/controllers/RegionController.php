<?php

class RegionController extends ManageController {

    /**
     * 列表页面
     */
    public function actionIndex()
    {
        $list = Region::model()->getRegionListPage();
        $viewData = array();
        $viewData['list'] = $list['list'];
        $viewData['count'] = $list['count'];
        $viewData['pageNum'] = $list['pageNum'];
        $this->render('index', $viewData);
    }

    /**
     * 添加页面及操作
     */
    public function actionAdd()
    {
        if(empty($_POST)){
            $viewData = array();
            $this->render('add', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        try{
            $level = 1;
            if($_POST['parent_id']){
                $info = Region::model()->findByPk($_POST['parent_id']);
                if(empty($info)){
                    throw new exception('父级id不存在！');
                }
                $level = $info['level']+1;
            }
            $m = new Region();
            $m->region_name = $_POST['region_name'];
            $m->area_code 	= $_POST['area_code'];
            $m->is_show 	= $_POST['is_show'];
            $m->level 		= $level;
            $m->parent_id 	= $_POST['parent_id'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'regionList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/region/index';
        $this->ajaxDwzReturn($res);
    }

    /**
     * 修改及操作
     */
    public function actionEdit()
    {
        if(empty($_POST)){
            $info = Region::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['info'] = $info;
            $this->render('edit', $viewData);exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            $m =  Region::model()->findByPk($_REQUEST['id']);

            $level = 1;
            if($_POST['parent_id']){
                $info = Region::model()->findByPk($_POST['parent_id']);
                if(empty($info)){
                    throw new exception('父级id不存在！');
                }
                $level = $info['level']+1;
            }
            $m->region_name = $_POST['region_name'];
            $m->area_code 	= $_POST['area_code'];
            $m->is_show 	= $_POST['is_show'];
            $m->level 		= $level;
            $m->parent_id 	= $_POST['parent_id'];
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'regionList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/region/index';
        $this->ajaxDwzReturn($res);
    }

    /**
     * 删除操作
     */
    public function actionDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = Region::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/region/index';
        $this->ajaxDwzReturn($res);
    }

    /**
     * 修改状态.
     */
    public function actionChangeStatus()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $info = Region::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new Exception('该支付记录不存在');
            }
            if($info->is_valid != $_REQUEST['is_show']){
                $info->is_valid = $_REQUEST['is_show'];
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
        $res['forwardUrl'] = '/manage/region/index';
        $this->ajaxDwzReturn($res);
    }

}