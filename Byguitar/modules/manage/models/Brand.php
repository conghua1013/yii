<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Brand extends CActiveRecord
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
        return 'bg_brand';
    }

    //获取菜单列表
    public function getBrandListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['brand_name'])){
                $criteria->compare('brand_name',$_REQUEST['brand_name'],true);  
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
                'count'=>$count,
                'list'=>$list,
                'pageNum'=>$pageNum,
                );
    }

    //商品页面 选择品牌列表
    public function getSelectBrandForProductEdit(){
        $fields = 'id,brand_name';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_brand')
        ->order('sort')
        ->where('is_show = 1')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

    public function getBrandList(){
        $fields = 'id,brand_name';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_brand')
        //->order('sort')
        //->where('is_show = 1')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }
}
