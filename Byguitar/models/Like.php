<?php

class Like extends CActiveRecord
{

    public function getDbConnection() {
        return Yii::app()->shop;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'bg_like';
    }

    /**
     * 用户喜欢数据分页
     * @param $userId
     * @return array
     */
    public function getUserLikeListPage($userId,$request)
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
        $product_ids = array();
        if(!empty($list)){
            foreach($list as $row){
                $temp = $row->getAttributes();
                if($row->product_id > 0 && !in_array($row->product_id,$product_ids)){
                    array_push($product_ids,$row->product_id);
                }
                $newList[$row->id] = $temp;
            }
        }

        return array(
            'count'=>$count,
            'list'=>$newList,
            'p'=>$pageNum,
            'page_size'=>$page_size,
            'product_ids' => $product_ids,
        );
    }

    /**
     * 【用户中心】删除喜欢
     * @param $userId
     * @param $product_id
     */
    public function delLike($userId,$product_id)
    {
        if(empty($product_id)){
            throw new exception('商品id不能为空!');
        }

        $flag = Like::model()->deleteAllByAttributes(array('user_id'=>$userId,'product_id'=>$product_id));
        if(!$flag){
            throw new exception('取消喜欢失败!');
        }
        $pInfo = Product::model()->findByPk($product_id);
        if($pInfo && $pInfo->like_num >= 1){
            $pInfo->like_num -= 1;
            $pInfo->save();
        }
        return true;
    }

    /**
     * 【用户中心】添加喜欢
     * @param $userId
     * @param $product_id
     * @return bool
     * @throws exception
     */
    public function addLike($userId,$product_id)
    {
        if(empty($product_id)){
            throw new exception('商品id不能为空!');
        }

        $is_exist = Like::model()->findByAttributes(array('user_id'=>$userId,'product_id'=>$product_id));
        if($is_exist){
            return true;
        }

        $m = new Like();
        $m->product_id 	= $product_id;
        $m->user_id 	= $userId;
        $m->add_time 	= time();
        $flag = $m->save();

        $pInfo = Product::model()->findByPk($product_id);
        if($pInfo){
            $pInfo->like_num += 1;
            $pInfo->save();
        }
        if(!$flag){
            throw new exception('添加喜欢失败!');
        }
        return true;
    }


    //获取商品的喜欢状态
    public function getLikeStatus($user_id,$product_id)
    {
        if(empty($product_id) || empty($user_id)){return false;}

        $likeInfo = Like::model()->findByAttributes(array('user_id'=>$user_id,'product_id'=>$product_id));
        if(empty($likeInfo)){
            return false;
        }
        return true;
    }

}

