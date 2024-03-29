<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class ShopConfig extends CActiveRecord
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
		return 'bg_shop_config';
	}

	//获取菜单列表
	public function getConfigListPage(){
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
	 * 获取商店配置（免运费金额等配置）
	 * @return array|bool
	 */
	public function getShopConfig(){
		$list = Yii::app()->shop->createCommand()
			->select('*')
			->from('bg_shop_config')
			->queryAll();
		if(empty($list)){return false;}
		$newList = array();
		foreach($list as $row){
			$newList['attribute'] = $row['value'];
		}
		return $newList;
	}

}
