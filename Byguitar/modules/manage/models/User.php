<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
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

	//获取菜单列表
	public function getUserListPage(){
		$pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $numPerPage = empty($_REQUEST['numPerPage']) ? 20 : $_REQUEST['numPerPage'];
        $sortField = isset($_REQUEST['orderField']) ? $_REQUEST['orderField'] : 'id';
        $sortFlag = isset($_REQUEST['orderDirection']) ? $_REQUEST['orderDirection'] : 'desc';
		$criteria = new CDbCriteria();
        $criteria->order = $sortField.' '.$sortFlag;
        $criteria->offset = ($pageNum-1) * $numPerPage;
        $criteria->limit = $numPerPage;
        if(isset($_REQUEST['username']) && !empty($_REQUEST['username'])){
        	$criteria->compare('username',$_REQUEST['username'],true);//支持模糊查找
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	);
	}

}
