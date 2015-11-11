<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Category extends CActiveRecord
{  

    //选择数据库
    public function getDbConnection() {       
        return Yii::app()->shop;  
    }   
	
    //单例模式
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    //表名、全名
    public function tableName()
    {
        return 'bg_category';
    }

    //获取菜单列表
    public function getCategoryListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
                'count'=>$count,
                'list'=>$list,
                'pageNum'=>$pageNum,
                );
    }

    //webyemian
    public function getCategoryListForShopNavigation() {
        $fields = 'id,cat_name,level,parent_id,url';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }

            foreach ($data as &$row ) {
                if($row['level'] == 2){
                    $data[$row['parent_id']]['child'][$row['id']] = $row;
                    unset($data[$row['id']]);
                }
            }
        }
        return $data;
    }

    //获取分类信息用于显示分类名称
    public function getCategoryListForShowName() {
        $fields = 'id,cat_name,url';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }
        }
        return $data;
    }

    //分类的添加和编辑页面使用
    public function getSelectCategoryForEdit(){
        $fields = 'id,cat_name,level,parent_id';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->where('level<2')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

    //商品的分类和添加时使用
    public function getSelectCategoryForProductEdit(){
        $fields = 'id,cat_name,level,parent_id';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->where('select_able = 1') //可选
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }

        foreach ($newList as &$row ) {
            if($row['level'] == 2){
                $newList[$row['parent_id']]['child'][$row['id']] = $row;
                unset($newList[$row['id']]);
            }
        }
        return $newList;
    }
    
    /**
     * 获取所有的分类信息列表
     * @return type
     */
    public function getCategoryList() {
        $fields = '*';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }
        }
        return $data;
    }
    
    /**
     * 获取加个的分类区间
     * @param type $price
     */
    public function getPriceRange($id,$type='info'){
		
        $a = array();
        $a[1] = array('min'=>0,'max'=>99);
        $a[2] = array('min'=>100,'max'=>299);
        $a[3] = array('min'=>300,'max'=>499);
        $a[4] = array('min'=>500,'max'=>799);
        $a[5] = array('min'=>800,'max'=>1499);
        $a[6] = array('min'=>1500,'max'=>2999);
        $a[7] = array('min'=>3000,'max'=>4999);
        $a[8] = array('min'=>5000,'max'=>9999);
        $a[9] = array('min'=>10000,'max'=>false);
        if ($type=="info" && isset($a[$id])) {//获取价格区间
                return $a[$id];
        }elseif($type=="info"){//默认返回价格区间1
                return $a[1];
        }
        return $a;
    }


    /**
     * 面包屑
     * @param int $catId
     * @return array|bool
     */
    public function getCakeLine($catId=0)
    {
        if(empty($catId)){return false;}

        $catList = Category::model()->getCategoryList();

        $lineArr = array();
        $catTwoInfo = $catList[$catId];
        $lineArr['cattwo'] = array('id'=>$catId,'cat_name'=>$catTwoInfo['cat_name']);

        $catOneInfo = $catList[$catTwoInfo['parent_id']];
        $lineArr['catone'] = array('id'=>$catOneInfo['id'],'cat_name'=>$catOneInfo['cat_name']);
        return $lineArr;
    }

}
