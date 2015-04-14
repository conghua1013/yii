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
        if(empty($_POST)){
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $viewData = array();
            $viewData['categorys'] = $categorys;
            $viewData['brands'] = $brands;
            $this->render('add',$viewData);
        }

        try{
            $status = 200;
            $message = '添加成功!';
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }

    //商品编辑页面
    public function actionEdit(){
        if(empty($_POST)){
            $pInfo = Product::model()->findByPk($_REQUEST['id']);
            $categorys = Category::model()->getSelectCategoryForProductEdit(); //可选分类列表
            $brands = Brand::model()->getSelectBrandForProductEdit(); //可选品牌列表
            $viewData = array();
            $viewData['categorys'] = $categorys;
            $viewData['brands'] = $brands;
            $viewData['pInfo'] = $pInfo;
            $this->render('edit',$viewData);
        }

        try{
            $status = 200;
            $message = '添加成功!';
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }


    //保存商品的图片信息
    public function actionProductImage(){

        try{
            $status = 200;
            $message = '添加成功!';
        } catch(exception $e){
            $status = 200;
            $message = '添加失败!';
        }
        $res = array();
        $res['statusCode']      = $status;
        $res['message']         = $message;
        $this->ajaxDwzReturn($res);
    }





    //保存商品的基本数据
    protected function saveProduct(){

    }

    //保存商品的分类信息
    protected function saveProductCategory(){
        
    }

    //保存商品的属性信息
    protected function saveProductAttr(){

    }

    //保存商品的库存信息
    protected function saveProductStock(){
        
    }

    //保存商品的扩展信息
    protected function saveProductExtend(){
        
    }

    //保存商品的图片信息
    protected function saveProductImage(){
        
    }

    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 start <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
    
    //商品属性树状图
    public function actionProductAttrTree(){
        $tree = ProductAttributes::model()->getProductAttrTree();
        $viewData = array();
        $viewData['tree'] = $tree;
        $this->render('/productAttr/tree',$viewData);
    }

    //商品属性添加
    public function actionProductAttrAdd(){
        if(empty($_POST)){
            $select = ProductAttributes::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/add',$viewData);
            exit;
        }

        $model = new ProductAttributes();
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
            $select = ProductAttributes::model()->getProductAttrTree();
            $viewData = array();
            $viewData['select'] = $select;
            $this->render('/productAttr/edit',$viewData);
        }

        $model =  ProductAttributes::model()->findByPk($_REQUEST['id']);
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
    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 商品属性页面 end <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<//
}
