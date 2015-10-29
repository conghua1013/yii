<?php

//网站做的基础类 可以做一些公共的操作
class ShopBaseController extends CController 
{
    public $params; //模板向叶面赋值通过此参数
    public $user_id = '';
    public $webUrl = 'www.byguitar.com';
    public $webConfig;
    
    public function __construct(){
        //parent::__construct("Shop");
        $this->getHeadMenuList();
        if(isset(Yii::app()->session->user_id)){
            Yii::app()->session->user_id = '';
        }

        $cateList = Category::model()->getCategoryListForShopNavigation();
        $this->params['cateList'] = $cateList;
        $this->user_id = Yii::app()->session['authId'];

        $config = Yii::app()->params;
        $this->webConfig    = $config;
        $this->webUrl       = $config['url']['web_url'];
    }
    
    public function getHeadMenuList(){

        $fileds = 'name,link,type,title,target';
        $where = 'status=1 and level=1';
        $order = 'sort asc';
        $list = Yii::app()->byguitar->createCommand() 
        ->select($fileds) 
        ->from('bg_menu') 
        ->where($where) 
        ->order($order)
        ->queryAll();
        $this->params['menu'] = $list;
        //echo "<pre>";
        //print_r($list);exit;
    }

}

