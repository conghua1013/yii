<?php

class CategoryController extends ManageController {

    //列表页面
    public function actionIndex(){
        $list = Category::model()->getCategoryListPage();
        $nameList = Category::model()->getCategoryListForShowName();
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
            $select = Category::model()->getSelectCategoryForEdit();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('add', $viewData); exit;
        }

        $message = '添加成功！';
        $status = 200;
        try {
            if(!empty($_REQUEST['parent_id'])){
                $info = Category::model()->findByPk($_REQUEST['parent_id']);
                if(empty($info)){
                    throw new exception('父级不存在！');
                }
                $level = $info['level']+1;
            }else{
                $level = 1;
            }

            $m = new Category();
            $m->cat_name 		= $_REQUEST['cat_name'];
            $m->url 			= $_REQUEST['url'];
            $m->is_show 		= $_REQUEST['is_show'];
            $m->select_able 	= $_REQUEST['select_able'];
            $m->sort 			= $_REQUEST['sort'];
            $m->title 			= $_REQUEST['title'];
            $m->keywords 		= $_REQUEST['keywords'];
            $m->describtion 	= $_REQUEST['describtion'];
            $m->parent_id 		= $_REQUEST['parent_id'];
            $m->level 			= $level;
            $m->add_time 		= time();
            $flag = $m->save();
            if(!$flag){
                throw new exception('添加失败!');
            }

        } catch(Exception $e){
            $message = $e->getMessage();
            $status = 500;
        }

        $res = array();
        $res['statusCode'] 		= $status;
        $res['message'] 		= $message;
        $this->ajaxDwzReturn($res);
    }

    //编辑页面
    public function actionEdit(){
        if(empty($_POST)){
                $select = Category::model()->getSelectCategoryForEdit();
                $info = Category::model()->findByPk($_REQUEST['id']);
                $viewData = array();
                $viewData['select'] = $select;
                $viewData['info'] = $info;
                $this->render('edit', $viewData);
                exit;
        }

        $message = '';
        $status = 200;
        try {
            if(!empty($_REQUEST['parent_id'])){
                $info = Category::model()->findByPk($_REQUEST['parent_id']);
                if(empty($info)){
                    throw new exception('父级不存在！');
                }
                $level = $info['level']+1;
            }else{
                $level = 1;
            }

            $m =  Category::model()->findByPk($_REQUEST['id']);
            $m->cat_name 		= $_REQUEST['cat_name'];
            $m->url 			= $_REQUEST['url'];
            $m->is_show 		= $_REQUEST['is_show'];
            $m->select_able 	= $_REQUEST['select_able'];
            $m->sort 			= $_REQUEST['sort'];
            $m->title 			= $_REQUEST['title'];
            $m->keywords 		= $_REQUEST['keywords'];
            $m->describtion 	= $_REQUEST['describtion'];
            $m->parent_id 		= $_REQUEST['parent_id'];
            $m->level 			= $level;
            $m->add_time 		= time();
            $flag = $m->save();
            if(!$flag){
                    throw new exception('修改失败!');
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
            $flag = Category::model()->deleteByPk($_REQUEST['id']);
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
        $info = Category::model()->findByPk($_REQUEST['id']);
        try{
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->is_show = $_REQUEST['is_show'];
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

    //修改状态
    public function actionChangeSelect(){
        $info = Category::model()->findByPk($_REQUEST['id']);
        try{
            if(empty($info)){
                throw new exception('记录不存在了！');
            }
            $info->select_able = $_REQUEST['select_able'];
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
        $tree = Category::model()->getCategoryListTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('tree', $viewData);
    }

}