<?php

class MenuController extends ManageController
{

    //列表页面
    public function actionIndex()
    {
            $list = Menu::model()->getMenuListPage();
            $nameList = Menu::model()->getMenuListForShowName();
            $viewData = array();
            $viewData['list'] = $list['list'];
            $viewData['count'] = $list['count'];
            $viewData['pageNum'] = $list['pageNum'];
            $viewData['names'] = $nameList;
            $this->render('index', $viewData);
    }

    //添加页面
    public function actionAdd()
    {
        if(empty($_POST)){
            $select = Menu::model()->getSelectMenuForEdit();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('add', $viewData);
            exit;
        }

        $res = array('statusCode' => 200,'message' => '添加成功！');
        try {
            if(!empty($_REQUEST['parent_id'])){
                $info = Menu::model()->findByPk($_REQUEST['parent_id']);
                if(empty($info)){
                    throw new exception('父级不存在！');
                }
                $level = $info['level']+1;
            }else{
                $level = 1;
            }

            $m = new Menu();
            $m->title 		= $_REQUEST['title'];
            $m->url 		= $_REQUEST['url'];
            $m->page_sign 	= $_REQUEST['page_sign'];
            $m->status 		= $_REQUEST['status'];
            $m->sort 		= $_REQUEST['sort'];
            $m->remark 		= $_REQUEST['remark'];
            $m->parent_id 	= $_REQUEST['parent_id'];
            $m->level 		= $level;
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'menuList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/menu/index';
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit()
    {
        if(empty($_POST)){
            $select = Menu::model()->getSelectMenuForEdit();
            $info = Menu::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['select'] = $select;
            $viewData['info'] = $info;
            $this->render('edit', $viewData);
            exit;
        }

        $res = array('statusCode' => 200,'message' => '修改成功！');
        try {
            if(!empty($_REQUEST['parent_id'])){
                $info = Menu::model()->findByPk($_REQUEST['parent_id']);
                if(empty($info)){
                    throw new exception('父级不存在！');
                }
                $level = $info['level']+1;
            }else{
                $level = 1;
            }

            $m =  Menu::model()->findByPk($_REQUEST['id']);
            $m->title 		= $_REQUEST['title'];
            $m->url 		= $_REQUEST['url'];
            $m->page_sign 	= $_REQUEST['page_sign'];
            $m->status 		= $_REQUEST['status'];
            $m->sort 		= $_REQUEST['sort'];
            $m->remark 		= $_REQUEST['remark'];
            $m->parent_id 	= $_REQUEST['parent_id'];
            $m->level 		= $level;
            $flag = $m->save();
            if(!$flag){
                throw new exception('修改失败');
            }
        } catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '失败【'.$e->getMessage().'】';
        }
        $res['navTabId'] = 'menuList';
        $res['callbackType'] = 'closeCurrent';
        $res['forwardUrl'] = '/manage/menu/index';
        $this->ajaxDwzReturn($res);
    }

    //删除页面
    public function actionDel()
    {
        $res = array('statusCode' => 200,'message' => '删除成功！');
        try{
            if(empty($_REQUEST['id'])){
                throw new Exception("数据错误，id不能为空！", 1);
            }
            $flag = Menu::model()->deleteByPk($_REQUEST['id']);
            if(!$flag){
                throw new exception('删除失败');
            }
        }catch(Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '删除失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/menu/index';
        $this->ajaxDwzReturn($res);
    }

    //修改状态
    public function actionChange()
    {
        $res = array('statusCode' => 200,'message' => '修改成功！');
        try{
            $info = Menu::model()->findByPk($_REQUEST['id']);
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->status = $_REQUEST['status'];
            $flag = $info->save();
            if(empty($flag)){
                throw new exception('修改状态失败！');
            }
        } catch (Exception $e){
            $res['statusCode'] = 300;
            $res['message'] = '修改失败【'.$e->getMessage().'】';
        }
        $res['callbackType'] = 'reloadTab';
        $res['forwardUrl'] = '/manage/menu/index';
        $this->ajaxDwzReturn($res);
    }

    //树状图
    public function actionTree()
    {
        $tree = Menu::model()->getMenuListTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('tree', $viewData);
    }

}