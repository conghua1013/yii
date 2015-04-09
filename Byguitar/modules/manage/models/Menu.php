<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Menu extends CActiveRecord
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
		return 'bg_manage_menu';
	}

	//获取菜单列表
	public function getMenuList(){
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC'; 
  
        $count = Menu::model()->count($criteria); 
        $pages = new CPagination($count);
        $pages->pageVar = 'pageNum'; 
        $pages->pageSize = 10;
        $pages->applyLimit($criteria); 
        $list = Menu::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	);
	}

	public function getMenuListTree(){
		$m = self::model();
		$fields = 'id,name,title,url,level,parent_id';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_manage_menu')
		->order('level,sort')
		->queryAll();

		$newList = array();
		foreach ( $list as $row ) {
				$newList[$row['id']] = $row;
		}

		foreach ( $newList as &$row ) {
				if($row['level'] == 3){
					$newList[$row['parent_id']]['child'][$row['id']] = $row;
					unset($newList[$row['id']]);
				}
		}

		foreach ( $newList as &$row ) {
				if($row['level'] == 2){
					$newList[$row['parent_id']]['child'][$row['id']] = $row;
					unset($newList[$row['id']]);
				}
		}

		return $newList;
	}
}
