<?php

class ProductController extends ManageController {

    public function actionIndex(){
        $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
        $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
		$list = Product::model()->getProductList();

        $viewData = array();
		$viewData['list']         = $list['list'];
		$viewData['count']        = $list['count'];
		$viewData['pageNum']      = $list['pageNum'];
        $viewData['categorys']    = $categorys;
        $viewData['brands']       = $brands;
		$this->render('index', $viewData);
    }
    
    //商品添加页面 
    public function actionAdd(){
        $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
        $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
        $viewData = array();
        $viewData['categorys'] = $categorys;
        $viewData['brands'] = $brands;
        $this->render('add',$viewData);
    }

    public function actionEdit(){
        $viewData = array();
        $this->render('edit',$viewData);
    }







    //商品属性树状图
    public function actionProductAttrTree(){
        $tree = ProductAttr::model()->getProductAttrTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('/productAttr/tree',$viewData);
    }

    //商品属性添加
    public function actionProductAttrAdd(){
        if(empty($_POST)){
            $select = ProductAttr::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/add',$viewData);
            exit;
        }

        $model = new ProductAttr();
        $model->parent_id = $_REQUEST['parent_id'];
        $model->attr_name = $_REQUEST['attr_name'];
        $model->add_time = time();
        $flag = $model->save();

        if($flag){
            $status = 200;
            $message = '添加成功!';
        } else {
            $status = 200;
            $message = '添加失败!';
        }

        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }

    //商品属性添加
    public function actionProductAttrEdit(){
        if(empty($_POST)){
            $select = ProductAttr::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/edit',$viewData);
        }

        $model =  ProductAttr::model()->findByPk($_REQUEST['id']);
        $model->parent_id = $_REQUEST['parent_id'];
        $model->attr_name = $_REQUEST['attr_name'];
        $model->add_time = time();
        $flag = $model->save();

        if($flag){
            $status = 200;
            $message = '修改成功!';
        } else {
            $status = 200;
            $message = '修改失败!';
        }

        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);        
    }
}
