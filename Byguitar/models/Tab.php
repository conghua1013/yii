<?php

class Tab extends CActiveRecord
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
        return 'bg_tab';
    }

    /**
     * 根据id获取谱子的信息
     * @param $tab_ids
     * @return array|bool|string
     */
    public function getTabsInfoByIds($tab_ids)
    {
        if(empty($tab_ids)) {return '';}
        $list = Yii::app()->byguitar->createCommand()
            ->select('*')
            ->from('bg_tab')
            ->where('id in ('.implode(',',$tab_ids).')')
            ->queryAll();
        if(empty($list)){return false;}
        $newList = array();
        foreach($list as $row){
            $row['images']['cover'] = '/images/public/tab.png';
            $newList[$row['id']] = $row;
        }
        return $newList;
    }
}