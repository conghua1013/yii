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
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

}