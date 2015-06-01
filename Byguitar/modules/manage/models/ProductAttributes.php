<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class ProductAttributes extends CActiveRecord
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
		return 'bg_product_attributes';
	}

    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'ProductAttributes', 'parent_id','select'=>'attr_name'),
        );
    }

    public function getAttrListPage(){
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


    public function getSelectAttributes(){
        $criteria = new CDbCriteria(); 
        $criteria->compare('parent_id',0,true);
        $list = self::model()->findAll($criteria);
        return $list;
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
