<?php

/**
 * 用户登录相关的hr.
 * @author mwq2020 <mwq2020@163.com>
 */
class User extends CActiveRecord
{  

	//选择数据库
	public function getDbConnection() {       
		return Yii::app()->byguitar;
    }   
	
	//单例模式
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//表名、全名
	public function tableName()
	{
		return 'bg_user';
	} 


}
