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

}

