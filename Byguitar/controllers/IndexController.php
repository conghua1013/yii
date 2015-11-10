<?php

class IndexController extends ShopBaseController
{
     

    public function actionIndex() {
//        echo "<pre>";
//        echo $this->user_id."<br>";
//        echo Yii::app()->request->userHostAddress."<br>";
//        print_r($_SESSION);
//        exit;


        $lunbo = $this->getLunboBanner();
        $banner = $this->getBanner();
        $module = $this->getIndexModule();

        // echo "<pre>";
        // print_r($lunbo);
        // exit;

        $viewData = array();
        $viewData['lunbo'] = $lunbo;
        $viewData['banner'] = $banner;
        $viewData['module'] = $module;
        $this->render('index/index',$viewData);
    }

    //获取轮播的图片
    public function getLunboBanner(){
        $criteria = new CDbCriteria(); 
        $criteria->compare('station',1);
        $criteria->compare('is_show',1);
        $criteria->compare('start_time','<='.time());
        $criteria->compare('end_time', '>=' .time());
        $criteria->limit = 5;
        $criteria->order = 'sort desc ,id desc';

        $list = Banner::model()->findAll($criteria);
        if(empty($list)){return false;}
        $newList = array();
        $i = 1;//用于页面展示序号
        $imageConfig = Yii::app()->params['image']['banner'];
        foreach ($list as $row) {
            $newList[$i] = $row->getAttributes();
            $newList[$i]['img'] = str_replace(ROOT_PATH, '', $imageConfig['path']).$row->img;
            $i++;
        }
        return $newList;
    }

    //获取轮播下面的两个banner
    public function getBanner(){
        $criteria = new CDbCriteria(); 
        $criteria->compare('station',2);
        $criteria->compare('is_show',1);
        $criteria->compare('start_time','<='.time());
        $criteria->compare('end_time', '>=' .time());
        $criteria->limit = 2;
        $criteria->order = 'sort desc ,id desc';

        $list = Banner::model()->findAll($criteria);
        if(empty($list)){return false;}
        $newList = array();
        $i = 1;//用于页面展示序号
        $imageConfig = Yii::app()->params['image']['banner'];
        foreach ($list as $row) {
            $newList[$i] = $row->getAttributes();
            $newList[$i]['img'] = str_replace(ROOT_PATH, '', $imageConfig['path']).$row->img;
            $i++;
        }
        return $newList;
    }


    //获取首页的显示模块
    public function getIndexModule(){
        $criteria = new CDbCriteria();
        $criteria->compare('is_show',1);
        $criteria->compare('start_time','<='.time());
        $criteria->compare('end_time', '>=' .time());
        $criteria->limit = 5;
        $criteria->order = 'sort desc ,id desc';

        $order = 'sort desc ,id desc';
        $list = IndexModule::model()->findAll($criteria);
        if(empty($list)){return false;}

        $imageConfig = Yii::app()->params['image']['module_banner'];

        $moduleList = array();
        foreach ($list as $row) {
            $moduleInfo = $row->getAttributes();
            $moduleInfo['start_time']   = date('Y-m-d H:i:s',$row['start_time']);
            $moduleInfo['end_time']     = date('Y-m-d H:i:s',$row['end_time']);
            $moduleInfo['title']        = $row['title'];
            $moduleInfo['link']         = $row['link'];
            if($moduleInfo['img']){
                $moduleInfo['img'] = str_replace(ROOT_PATH, '', $imageConfig['path']).$moduleInfo['img'];
            }

            $moduleInfo['list'] = $this->getModuleProduct($row);
            array_push($moduleList, $moduleInfo);
        }
        return $moduleList;
    } 

    

    //获取模块下面的商品
    protected function getModuleProduct($info){
        $list = array();
        if(empty($info['type'])){
            $pids = $info['product_ids'];
            if(empty($pids)){return false;}
            $pidArr = explode(',', $pids);
            $list = Product::model()->getProductInfoByIds($pidArr);
        }else{
            $list = $this->getModuleProductAuto($info);
        }
        return $list;
    }


    //通过自动策略获取商品
    protected function getModuleProductAuto($info){
        $list = array();
        //热销商品
        if($info['type'] == 1){
            $list = $this->getNewProducts();
        }elseif($info['type'] == 2){
            $list = $this->getHotProducts();
        }elseif($info['type'] == 3){
            $list = $this->getBestProducts();
        }elseif($info['type'] == 4){
            $list = $this->getPromoteProducts();
        }
        return $list;
    }

    

    /**
     +
     *自动策略抓取商品1（新品）
     +
     */
    protected function getNewProducts(){
        $criteria = new CDbCriteria();
        $criteria->compare('status',2);
        $criteria->compare('is_show',1);
        $criteria->limit = 5;
        $criteria->order = 'add_time desc,id desc';
        $list = Product::model()->findAll($criteria);
        if(empty($list)){return false;}

        $idsArr = array();
        foreach ($list as $value) {
            array_push($idsArr, $value->id);
        }

        $list = Product::model()->getProductFaceImageByProductIds($idsArr);
        return $list;
    }



    /**
     +
     *自动策略抓取商品1（热卖）销量最高的5个商品
     +
     */
    protected function getHotProducts(){
        $criteria = new CDbCriteria();
        $criteria->compare('status',2);
        $criteria->compare('is_show',1);
        $criteria->limit = 5;
        $criteria->order = 'sold_num desc,id desc';
        $list = Product::model()->findAll($criteria);
        if(empty($list)){return false;}

        $idsArr = array();
        foreach ($list as $value) {
            array_push($idsArr, $value->id);
        }

        $list = Product::model()->getProductFaceImageByProductIds($idsArr);
        return $list;
    }



    /**
     +
     *自动策略抓取商品2（特卖）折扣最高的5个
     +
     */
    protected function getPromoteProducts(){
        $criteria = new CDbCriteria();
        $criteria->compare('status',2);
        $criteria->compare('is_show',1);
        $criteria->compare('promote_start_time','<='.time());
        $criteria->compare('promote_end_time', '>=' .time());
        $criteria->limit = 5;
        $criteria->order = 'discount asc,id desc';
        $list = Product::model()->findAll($criteria);
        if(empty($list)){return false;}

        $idsArr = array();
        foreach ($list as $value) {
            array_push($idsArr, $value->id);
        }

        $list = Product::model()->getProductFaceImageByProductIds($idsArr);
        return $list;
    }



    /**
     +
     *自动策略抓取商品3（精选）售出个数最高按照品牌取出5个
     +
     */
    protected function getBestProducts(){
        $criteria = new CDbCriteria();
        $criteria->compare('status',2);
        $criteria->compare('is_show',1);
        $criteria->compare('promote_start_time','<='.time());
        $criteria->compare('promote_end_time', '>=' .time());
        $criteria->group = 'brand_id';
        $criteria->limit = 5;
        $criteria->order = 'sold_num desc,id desc';
        $list = Product::model()->findAll($criteria);
        if(empty($list)){return false;}

        $idsArr = array();
        foreach ($list as $value) {
            array_push($idsArr, $value->id);
        }

        $list = Product::model()->getProductFaceImageByProductIds($idsArr);
        return $list;
    }



    
}
