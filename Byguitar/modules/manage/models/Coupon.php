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
    public function getCouponListPage()
    {
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


    public function getCouponSn()
    {
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
     * 获取用户名下的优惠券(前端购物车用)
     * @param $userId
     */
    public function getUserUsingCouponList($userId)
    {
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
                $newList[$row->id] = $row->getAttributes();
            }
        }
        return $newList;
    }

    /**
     * 获取优惠券信息并检查有效信息（有效信息检查-购物车检查优惠券时用）
     * @param $request
     * @return bool
     * @throws exception
     */
    public function getAndCheckCouponInfo($userId,$coupon_sn)
    {
        if(empty($coupon_sn) || empty($userId)){return false;}

        #先检查时否是优惠券
        $map = array();
        $map['coupon_sn'] 	= $coupon_sn;
        $map['user_id'] 	= $userId;
        $couponInfo = Coupon::model()->findByAttributes($map);

        if(!empty($couponInfo)){
            $couponInfo = $couponInfo->getAttributes();
            if(!empty($couponInfo['order_id']) || !empty($couponInfo['use_time'])){
                throw new exception('该优惠券已经使用过！');
            }elseif($couponInfo['start_time'] > time()){
                throw new exception('优惠券还未到使用日期！');
            }elseif($couponInfo['end_time'] < time()){
                throw new exception('该优惠券已经过期！');
            }
            $couponInfo['type'] = 'B';
            return $couponInfo;
        }

        //如果A类券不存在就检查下B类券，就返回错误信息了
        $map = array();
        $map['coupon_sn'] 	= $coupon_sn;
        $couponInfo = CouponType::model()->findByAttributes($map);
        if(!empty($couponInfo)){
            $couponInfo = $couponInfo->getAttributes();
            if($couponInfo['start_time'] > time()){
                throw new exception('优惠券还未到使用日期！');
            }elseif($couponInfo['end_time'] < time()){
                throw new exception('该优惠券已经过期！');
            }
            $couponInfo['type'] = 'A';
        }else{
            throw new exception('该优惠券不存在！');
        }
        return $couponInfo;
    }


    /**
     * 用户中心获取优惠券分页
     * @param $userId
     * @return array
     */
    public function getUserCouponListPage($userId,$request)
    {
        $pageNum = empty($request['p']) ? 1 : intval($request['p']);
        $page_size = 10;
        $criteria = new CDbCriteria();
        $criteria->compare('user_id',$userId);
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1) * $page_size;
        $criteria->limit = $page_size;

        $count = self::model()->count($criteria);
        $list = self::model()->findAll($criteria);

        $newList = array();
        $coupon_type_ids = array();
        if(!empty($list)){
            foreach($list as $row){
                $temp = $row->getAttributes();

                if($temp['end_time'] < time()){
                    $coupon_status = '已过期';
                }elseif(!empty($temp['use_time'])){
                    $coupon_status = '已使用';
                }else{
                    $coupon_status = '未使用';
                }
                $temp['coupon_status'] = $coupon_status;

                if($row->coupon_type_id > 0 && !in_array($row->coupon_type_id,$coupon_type_ids)){
                    array_push($coupon_type_ids,$row->coupon_type_id);
                }
                $newList[$row->id] = $temp;
            }
        }

        return array(
            'count'=>$count,
            'list'=>$newList,
            'p'=>$pageNum,
            'page_size'=>$page_size,
            'coupon_type_ids' => $coupon_type_ids,
        );
    }


    /**
     * 【用户中心】优惠券绑定.
     * @param $userId
     * @param $coupon_sn
     */
    public function couponBand($userId,$coupon_sn)
    {
        $map = array();
        $map['coupon_sn'] 	= $coupon_sn;
        $couponInfo = Coupon::model()->findByAttributes($map);

        if(empty($couponInfo)){
            throw new exception('该优惠券不存在！');
        }
        if($couponInfo->user_id){
            if($userId != $couponInfo->user_id){
                throw new exception('该优惠券已经是别人的了！');
            } else {
                return true;
            }
        } elseif (!empty($couponInfo['order_id']) || !empty($couponInfo['use_time'])) {
            throw new exception('该优惠券已经使用过！');
        } elseif ($couponInfo['end_time'] < time()) {
            throw new exception('该优惠券已经过期！');
        }

        $couponInfo->user_id = $userId;
        $couponInfo->band_time = time();
        $flag = $couponInfo->save();
        if(empty($flag)){
            throw new exception('优惠券绑定失败！');
        }

        return true;
    }

}
