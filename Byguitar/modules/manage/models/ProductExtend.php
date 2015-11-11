<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class ProductExtend extends CActiveRecord
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
		return 'bg_Product_extend';
	}

	/**
	 * 商品扩展属性列表.
	 * @return array
	 */
	public function getProductExtendAttrList()
	{
		$attrList = array(
			'product_material'=>'商品物料',
			'warranty'=>'质保',
			'product_service'=>'服务',
			'product_size'=>'尺寸',
			'weight'=>'重量',
			'make_date'=>'生产日期',
			'use_life'=>'保质期',
			'product_return'=>'退换货政策',
			'product_maintain'=>'保养说明',
			'use_notice'=>'使用说明',
			'product_notice'=>'温馨提示',);
		return $attrList;
	}

	/**
	 * 获取商品的扩展属性
	 * @param $product_id
	 * @return array|bool
	 */
	public function getProductExtendAttrs($product_id)
	{
		if(empty($product_id)){return false;}
		$extendInfo = ProductExtend::model()->findByAttributes(array('product_id'=>$product_id));
		if($extendInfo){
			$extendInfo = unserialize($extendInfo->other_info);
		}

		$productAttrNameList = $this->getProductExtendAttrList();

		$attrArr = array();
		if(!empty($extendInfo)){
			foreach($productAttrNameList as $k => $v){
				if(empty($extendInfo[$k])){ continue; }
				$temp = array();
				$temp['attr']           = $k;
				$temp['attr_name']      = $productAttrNameList[$k];
				$temp['attr_content']   = $extendInfo[$k];
				array_push($attrArr, $temp);
			}
		}
		return $attrArr;
	}

}
