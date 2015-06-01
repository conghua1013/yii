<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Order extends CActiveRecord
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
		return 'bg_order';
	}

	//获取菜单列表
	public function getOrderListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['order_sn'])){
            $criteria->compare('order_sn',$_REQUEST['order_sn'],true);
        }
        if(!empty($_REQUEST['consignee'])){
            $criteria->compare('consignee',$_REQUEST['consignee'],true);
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	'pageNum'=>$pageNum,
        	);
	}

	//获取订单详情
	public function getOrderInfo($oId){
		$info = self::model()->findByPk($oId);
		return $info;
	}

}
