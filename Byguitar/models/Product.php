<?php

class Product extends CActiveRecord
{

	public function getDbConnection() {       
          return Yii::app()->shop;  
    }   

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'bg_product';
	}
	
}

