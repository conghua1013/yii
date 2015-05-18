<?php

class Coupon extends CActiveRecord
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
        return 'bg_coupon';
    }

    //BELONGS_TO  MANY_MANY  HAS_ONE  MANY_MANY
    public function relations()
    {
        return array(
            'type' => array(self::BELONGS_TO, 'CouponType', 'coupon_type_id','select'=>'coupon_name,coupon_type'),
        );
    }

    //获取菜单列表
    public function getCouponListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['coupon_sn'])){
            $criteria->compare('coupon_sn',$_REQUEST['coupon_sn'],true);
        }

        $count = self::model()->count($criteria);
        $list = self::model()->findAll($criteria);
        
        return array(
            'count'=>$count,
            'list'=>$list,
            'pageNum'=>$pageNum,
        );
    }

}
