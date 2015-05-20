<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Product extends CActiveRecord
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
		return 'bg_product';
	}

	public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'cat_id','select'=>'cat_name'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id','select'=>'brand_name'),
        );
    }

	//商品页面的分页列表数据整理
	public function getProductList() {
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

	//整理商品页面的品牌选择
	public function getBrandSelectList(){
		$fields = 'id,brand_name';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_brand')
		->queryAll();

		$data = array();
		if($list){
			foreach($list as $row){
				$data[$row['id']] = $row;
			}
		}
		return $data;
	}

	//整理商品页面的分类选择
	public function getCategorySelectList(){
		$fields = 'id,cat_name,parent_id,level';
		$list = Yii::app()->shop->createCommand()
		->select($fields)
		->from('bg_category')
		->queryAll();

		$data = array();
		if($list){
			foreach($list as $row){
				$data[$row['id']] = $row;
			}
		}
		return $data;
	}

}
