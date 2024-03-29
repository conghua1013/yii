<?php

/**
 * 商品model
 * @auther mwq2020@163.com
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


    /**********  已上部分用于后台管理，以下部分用户前端页面展示  **********/


    /**
     * 获取商品的详情(用于详情页展示).
     * @param $id
     * @return array|bool
     */
    public function getProductInfoById($id,$info_type='simple')
    {
        if(empty($id)){return false;}
        $info = Product::model()->findByPk($id);
        if(empty($info)){return false;}
        $data = $info->getAttributes();
        $data['images'] = $this->getProductImagesByProductId($id);
        if($info_type != 'simple'){
            $extendInfo = $this->getProductExtendInfo($id);
            if(!empty($extendInfo)){
                $data['extend_attr_list'] = $extendInfo;
            }

            $stocks = $this->getProductStock($id,$data['is_multiple']);
            if(empty($data['is_multiple'])){
                $data['quantity'] = $stocks;
            } else {
                $data['sizes'] = $stocks;
            }
        }

        //商品的关键字
        //if($info['tags']){
        //    $info['tags'] = explode(',',$info['tags']);
        //}

        return $data;
    }

    /**
     * 获取商品详情（用于列表类型的展示）
     * @param $product_ids
     * @param string $info_type
     * @return array|string
     */
    public function getProductInfoByIds($product_ids,$info_type='simple')
    {
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
        }
        if($info_type != 'simple') {
            $images_list = $this->getProductImagesByProductIds($product_ids);
            if($images_list){
                foreach ($images_list as $key => $row) {
                    $data[$key]['images'] = isset($data[$key]) ? $row['images'] : '';
                }
            }
        }
        return $data;
    }

    /**
     * 获取商品封面图片（用于列表展示--单个）
     * @param $product_id
     * @return array|string
     */
    public function getProductFaceImageByProductId($product_id)
    {
        if(empty($product_id)){return '';}
        $info = ProductImage::model()->findByAttributes(array('product_id'=>$product_id));
        if(empty($info)){return '';}
        return $this->getImageSizesByImageName($info->img);
    }

    /**
     * 获取商品封面图片（用于列表展示--批量）
     * @param $product_ids
     * @return array|string
     */
    public function getProductFaceImageByProductIds($product_ids)
    {
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

    /**
     * 获取单个商品的图片（不同图片尺寸合集）
     * @param $product_id
     * @return array|string
     */
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

    /**
     * 获取多个商品的所有图片的（带不同尺寸路径的图片的合集）
     * @param $product_ids
     * @return array|string
     */
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

    /**
     * 生成不同尺寸的商品图片
     * @param $source_image
     * @return array
     */
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

    /**
     * 获取商品的扩展属性.
     * @param $id
     * @return array|bool|mixed
     */
    public function getProductExtendInfo($id)
    {
        if(empty($id)){return false;}
        $extendInfo = ProductExtend::model()->findByAttributes(array('product_id'=>$id));

        $data = array();
        if($extendInfo){
            $data = unserialize($extendInfo->other_info);
        }
        return $data;
    }



    /**
     * 获取商品的库存属性
     * @param $product_id
     * @return array|mixed|null
     */
    public function getProductStock($product_id,$stock_type)
    {
        if(empty($product_id)){ return ''; }
        if(empty($stock_type)){
            $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$product_id));
            return empty($stockInfo) ? 0 : $stockInfo->quantity;
        }

        $list = ProductStock::model()->findAllByAttributes(array('product_id'=>$product_id));
        $newList = array();
        if(!empty($list)){
            foreach($list as $row){
                $newList[$row->attr_id] = $row->getAttributes();
            }
        }
        return $newList;
    }

    /**
     * 获取商品的库存属性【暂时还未启用】
     * @param $product_id
     * @param bool|false $stock_type
     * @return array|string
     */
    public function getProductStockInfo($product_id,$stock_type = false)
    {
        if(empty($product_id)){ return ''; }
        if($stock_type === false){
            $pInfo = Product::model()->findByPk($product_id);
            if(empty($pInfo)){
                return '';
            }
            $stock_type = $pInfo->is_multiple;
        }

        $data = array();
        $data['stock_type'] = $stock_type;
        $quantity = 0;
        if($stock_type){
            $list = ProductStock::model()->findAllByAttributes(array('product_id'=>$product_id));
            $temp = array();

            if($list){
                foreach($list as $row){
                    $temp[$row->attr_id] = $row->getAttributes();
                    $quantity += $row->quantity;
                }
            }
            $data['list'] = $temp;
        } else {
            $stockInfo = ProductStock::model()->findByAttributes(array('product_id'=>$product_id));
            $quantity = $stockInfo->quantity;
            //$quantity = $pInfo['quantity'];
        }

        $data['quantity'] = $quantity;
        return $data;
    }


}
