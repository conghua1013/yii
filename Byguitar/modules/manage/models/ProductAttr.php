<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class ProductAttr extends CActiveRecord
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
		return 'bg_Product_attributes';
	}

	//商品属性树状结构数据
    public function getProductAttrTree(){
        $list = Yii::app()->shop->createCommand()
            ->select('*')
            ->from('bg_product_attributes')
            ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }

            foreach ($data as &$row ) {
                if($row['parent_id'] > 0){
                    $data[$row['parent_id']]['child'][$row['id']] = $row;
                    unset($data[$row['id']]);
                }
            }
        }
        return $data;
    }

}
