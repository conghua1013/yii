<?php

class IndexModule extends CActiveRecord
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
        return 'bg_index_module';
    }

    //获取菜单列表
    public function getIndexModuleListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        // if(!empty($_REQUEST['coupon_name'])){
        //     $criteria->compare('coupon_name',$_REQUEST['coupon_name'],true);
        // }

        $count = self::model()->count($criteria);
        $list = self::model()->findAll($criteria);
        return array(
            'count'=>$count,
            'list'=>$list,
            'pageNum'=>$pageNum,
        );
    }

    public function getType($id,$type="txt"){
        $a = array(1=>'新品',2=>'热卖商品',3=>'精品商品',4=>'特卖商品');
        if ($type == "txt") {
            return isset($a[$id]) ? $a[$id] : '';
        }
        return $a;
    }

}
