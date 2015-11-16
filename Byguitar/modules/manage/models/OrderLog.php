<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class OrderLog extends CActiveRecord
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
		return 'bg_order_log';
	}

	/**
	 * 添加订单日志
	 * @param $data
	 */
	public function addOrderLog($data)
	{
		if(empty($data)){
			throw new exception('数据不能为空！');
		} elseif(!$data['order_id']){
			throw new exception('订单号不能为空！');
		} elseif(!$data['type']){
			throw new exception('日志类型不能为空！');
		}
		$m = new OrderLog();
		$m->order_id 	= $data['order_id'];
		$m->admin_id 	= isset($data['admin_id']) ? $data['admin_id'] : 0;
		$m->admin_name 	= isset($data['admin_name']) ? $data['admin_name'] : '管理员';
		$m->phone 		= isset($data['phone']) ? $data['phone'] : '';
		$m->type 		= $data['type'];
		$m->msg 		= isset($data['msg']) ? $data['msg'] : '';
		$m->is_show 	= isset($data['is_show']) ? $data['is_show'] : 1;
		$m->add_time 	= time();
		$flag = $m->save();
		if(empty($flag)){
			throw new exception('添加订单日志失败！',500);
		}
		return true;
	}

}
