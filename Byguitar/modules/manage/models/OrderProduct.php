<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class OrderProduct extends CActiveRecord
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
		return 'bg_order_product';
	}

	/**
	 * 获取订单的商品列表.
	 * @param $orderId
	 */
	public function getOrderProductByOrderId($orderId)
	{
		if(empty($orderId)){return '';}
		$list = OrderProduct::model()->findAllByAttributes(array('order_id'=>$orderId));
		if(empty($list)){return '';}

		// todo 图片待处理
		$newList = array();
		foreach($list as $row){
			$temp = $row->getAttributes();
			if($row->type == 1){
				$temp['images']['cover'] = '/images/public/tab.png';
			} elseif($row->type == 2) {
				$zineInfo = Zine::model()->findByPk($row['product_id']);
				if($zineInfo){
					$temp['images']['cover'] = '/images/zine/'.$zineInfo['mcover'];
				} else {
					$temp['images']['cover'] = '';
				}

			} else {
				$temp['images'] = Product::model()->getProductFaceImageByProductId($row->product_id);
			}
			$temp['total_price'] = $temp['sell_price'] * $temp['quantity'];

			$newList[$row->id] = $temp;
		}
		return $newList;
	}

}
