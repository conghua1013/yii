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
}
