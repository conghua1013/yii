<?php

class Zine extends CActiveRecord
{

    public function getDbConnection()
    {
        return Yii::app()->byguitar;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'bg_zine';
    }

    //获取杂志列表
    public function getZineListPage(){
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

    /**
     * 根据杂志id列表获取杂志信息.
     * @param $zine_ids
     * @return array|bool|string
     */
    public function getZineInfoByIds($zine_ids)
    {
        if(empty($zine_ids)) {return '';}
        $list = Yii::app()->byguitar->createCommand()
            ->select('*')
            ->from('bg_zine')
            ->where('id in ('.implode(',',$zine_ids).')')
            ->queryAll();
        if(empty($list)){return false;}
        $newList = array();
        foreach($list as $row){
            $row['images']['cover'] = '/images/zine/'.$row['mcover'];
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

}