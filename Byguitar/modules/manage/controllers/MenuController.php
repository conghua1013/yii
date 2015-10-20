<?php

class MenuController extends ManageController {

    //列表页面
    public function actionIndex(){
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
    public function actionAdd(){
        if(empty($_POST)){
            $select = Menu::model()->getSelectMenuForEdit();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('add', $viewData);
            exit;
        }

        try {
            $message = '';
            $status = 200;

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

    //编辑页面
    public function actionEdit(){
        if(empty($_POST)){
            $select = Menu::model()->getSelectMenuForEdit();
            $info = Menu::model()->findByPk($_REQUEST['id']);
            $viewData = array();
            $viewData['select'] = $select;
            $viewData['info'] = $info;
            $this->render('edit', $viewData);
            exit;
        }

        try {
            $message = '';
            $status = 200;

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

    //删除页面
    public function actionDel(){
        $flag = Menu::model()->deleteByPk($_REQUEST['id']);
        if($flag){
            $message = '删除成功!';
            $status = 200;
        }else{
            $message = '删除失败!';
            $status = 300;
        }
        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    //修改状态
    public function actionChange(){
        $info = Menu::model()->findByPk($_REQUEST['id']);
        try{
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->status = $_REQUEST['status'];
            $flag = $info->save();
            if(empty($flag)){
                throw new exception('修改状态失败！');
            }

            $message = '修改状态成功!';
            $status = 200;
        } catch (Exception $e){
            $message = $e->getMessage();
            $status = 300;
        }
        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    //树状图
    public function actionTree(){
        $tree = Menu::model()->getMenuListTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('tree', $viewData);
    }

}