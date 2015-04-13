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
	public function getMenuListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;

        $count = Menu::model()->count($criteria); 
        $list = Menu::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	'pageNum'=>$pageNum,
        	);
	}


	//为了显示取出menulist的名字等字段
	public function getMenuListForShowName(){
		$fields = 'id,title';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_manage_menu')
		->order('level,sort')
		->queryAll();


		$data = array();
		if($list){
			foreach($list as $row){
				$data[$row['id']] = $row;
			}
		}
		return $data;
	}

	//获取菜单的树状数据
	public function getMenuListTree(){
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


	//获取一二级分类用于添加或者编辑页面的选项。
	public function getSelectMenuForEdit(){
		$fields = 'id,name,title,url,level,parent_id';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_manage_menu')
		->order('level,sort')
		->where('level<3')
		->queryAll();
		$newList = array();
		foreach ( $list as $row ) {
			$newList[$row['id']] = $row;
		}

		foreach ($newList as &$row ) {
			if($row['level'] == 2){
				$newList[$row['parent_id']]['child'][$row['id']] = $row;
				unset($newList[$row['id']]);
			}
		}
		return $newList;
	}
}
