<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Category extends CActiveRecord
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
		return 'bg_category';
	}

	//获取菜单列表
	public function getCategoryListPage(){
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

	//获取分类信息用于显示分类名称
	public function getCategoryListForShowName() {
		$fields = 'id,cat_name,url';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_category')
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

	//分类的添加和编辑页面使用
	public function getSelectCategoryForEdit(){
		$fields = 'id,cat_name,level,parent_id';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_category')
		->order('level,sort')
		->where('level<2')
		->queryAll();
		$newList = array();
		foreach ( $list as $row ) {
			$newList[$row['id']] = $row;
		}
		return $newList;
	}

	//商品的分类和添加时使用
	public function getSelectCategoryForProductEdit(){
		$fields = 'id,cat_name,level,parent_id';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_category')
		->order('level,sort')
		->where('select_able = 1') //可选
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
