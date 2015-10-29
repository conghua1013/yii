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


    public function getCouponSn(){
        $a = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','2','3','4','5','6','7','8','9');

        srand((float) microtime() * 10000000);
        $numKeys = array_rand($a,12);
        $newNumber = array();
        foreach ($numKeys as $value) {
            array_push($newNumber, $a[$value]);
        }
        
        return implode('', $newNumber);
    }

    /**
     * 获取用户名下的优惠券
     * @param $userId
     */
    public function getCouponList($userId){
        if(empty($userId)){return '';}
        //todo 优惠券条件限制
        $criteria = new CDbCriteria();
        $criteria->compare('user_id',$userId);
        $criteria->compare('order_id',0);
        $criteria->compare('use_time',0);
        $criteria->compare('start_time','<='.time());
        $criteria->compare('end_time', '>=' .time());
        $criteria->order = 'end_time asc';
        $list = Coupon::model()->findAll($criteria);
        $newList = array();
        if(!empty($list)){
            foreach($list as $row){
                $newList[$row->id] = $row->getAttribute();
            }
        }
        return $newList;
    }
}
