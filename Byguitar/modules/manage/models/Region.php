<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Region extends CActiveRecord
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
		return 'bg_region';
	}

	//获取菜单列表
	public function getRegionListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1) * 20;
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
	 * 根据id获取地区名详细数组.
	 * @param $ids
	 * @return bool|string
	 */
	public function getRegionInfoByIds($ids)
	{
		if(empty($ids) || !is_array($ids)){return false;}

		$list = Region::model()->findAllByAttributes(array('id'=>$ids));
		if(empty($list)){return false;}

		$data = array();
		foreach ($list as $row) {
			$data[$row->id] = $row->getAttributes();
		}

		return $data;
	}

}
