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
		$numPerPage = empty($_REQUEST['numPerPage']) ? 20 : $_REQUEST['numPerPage'];
		$criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(isset($_REQUEST['product_name']) && !empty($_REQUEST['product_name'])){
        	$criteria->compare('product_name',$_REQUEST['product_name'],true);//支持模糊查找
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
        	'count'=>$count,
        	'list'=>$list,
        	'pageNum'=>$pageNum,
        	'numPerPage'=>$numPerPage,
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

	public function getProductStatus($status,$type = ""){
		$a = array(0=>'新添加',1=>'初审',2=>'上架',3=>'下架');
		if(empty($type)){
			return isset($a[$status]) ? $a[$status] : '';
		}
		return $a;
	}


    public function getProductInfoById($id){
        if(empty($id)){return false;}
        $info = Product::model()->findByPk($id);
        if(empty($info)){return false;}
        $data = $info->getAttributes();
        $data['images'] = $this->getProductImagesByProductId($id);
        return $data;
    }


    public function getProductInfoByIds($product_ids,$info_type='simple'){
        if(empty($product_ids)){return '';}
        $criteria = new CDbCriteria;
        if(empty($info_type) || $info_type == 'simple'){
            $criteria->select = 'id,product_name,sell_price,market_price,discount';
        } else {
            $criteria->select = '*';
        }
        
        $criteria->addInCondition('id',$product_ids);
        $list = Product::model()->findAll($criteria);

        //$list = Product::model()->findAllByPk($product_ids);
        //$list = Product::model()->findAllByAttributes(array('id'=>$product_ids)); //同理可用
        $data = array();
        if(!empty($list)){
            foreach ($list as $row) {
                $data[$row->id] = $row->getAttributes();
            }

            $images_list = $this->getProductImagesByProductIds($product_ids);
            if($images_list){
                foreach ($images_list as $key => $row) {
                    $data[$key]['images'] = isset($data[$key]) ? $row['images'] : '';
                }
            }
        }
        return $data;
    }

    //获取商品封面图片（用于列表展示--单个）
    public function getProductFaceImageByProductId($product_id) {
        if(empty($product_id)){return '';}
        $info = ProductImage::model()->findByAttributes(array('product_id'=>$product_id));
        if(empty($info)){return '';}
        return $this->getImageSizesByImageName($info->img);
    }

    //获取商品封面图片（用于列表展示--批量）
    public function getProductFaceImageByProductIds($product_ids) {
        if(empty($product_ids)){return '';}
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->addInCondition('product_id',$product_ids);
        $criteria->group = 'product_id';
        $list = ProductImage::model()->findAll($criteria);
        if(empty($list)){return '';}
        $data = array();
        foreach ($list as $row) {
            $data[$row->product_id] = $row->getAttributes();
            $data[$row->product_id]['images'] = $this->getImageSizesByImageName($row->img);
        }
        return $data;
    }

    //获取商品的图册
    public function getProductImagesByProductId($product_id) {
        if(empty($product_id)){return '';}
        $list = ProductImage::model()->findAllByAttributes(array('product_id'=>$product_id));
        if(empty($list)){return '';}
        $data = array();
        foreach ($list as $row) {
            $data[$row->id] = $row->getAttributes();
            $data[$row->id]['images'] = $this->getImageSizesByImageName($row->img);
        }
        return $data;
    }


    public function getProductImagesByProductIds($product_ids){
        if(empty($product_ids)){return '';}
        // $criteria = new CDbCriteria;
        // $criteria->select = '*';
        // $criteria->addInCondition('product_id',$product_ids);
        // $list = ProductImage::model()->findAll($criteria);
        // 已上构造方法也可用

        $list = ProductImage::model()->findAllByAttributes(array('product_id'=>$product_ids));
        $data = array();
        if(!empty($list)){
            foreach ($list as $row) {
                if(isset($data[$row->product_id])){continue;}
                $data[$row->product_id]['images'] = $this->getImageSizesByImageName($row->img);
            }
        }
        return $data;
    }

    
    public function getImageSizesByImageName($source_image){
        $imageConfig = Yii::app()->params['image']['product'];
        $data = array();
        foreach($imageConfig['sizes'] as $row){
            $path = pathinfo($source_image);
            $temp = explode('.',$path['basename']);
            $tempPath = $path['dirname'].'/'.$temp[0].'-'.$row.'.'.$temp[1];
            $data['image_'.$row] = $tempPath;
        }
        return $data;
    }

}
