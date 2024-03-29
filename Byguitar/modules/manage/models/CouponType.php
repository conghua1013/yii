<?php

class CouponType extends CActiveRecord
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
        return 'bg_coupon_type';
    }

    //获取菜单列表
    public function getCouponTypeListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['coupon_name'])){
            $criteria->compare('coupon_name',$_REQUEST['coupon_name'],true);
        }

        $count = self::model()->count($criteria);
        $list = self::model()->findAll($criteria);
        return array(
            'count'=>$count,
            'list'=>$list,
            'pageNum'=>$pageNum,
        );
    }

    /**
     * 获取优惠券类型
     * @param $coupon_type_ids
     */
    public function getCouponTypeInfoByIds($coupon_type_ids)
    {
        if(empty($coupon_type_ids)){return false;}
        $list = CouponType::model()->findAllByAttributes(array('id'=>$coupon_type_ids));
        $newList = array();
        if(!empty($list)){
            foreach($list as $row){
                $newList[$row->id] = $row->getAttributes();
            }
        }
        return $newList;
    }

}
