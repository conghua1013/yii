<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Category extends CActiveRecord
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
        return 'bg_category';
    }

    //获取菜单列表
    public function getCategoryListPage(){
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

    //webyemian
    public function getCategoryListForShopNavigation() {
        $fields = 'id,cat_name,level,parent_id,url';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }

            foreach ($data as &$row ) {
                if($row['level'] == 2){
                    $data[$row['parent_id']]['child'][$row['id']] = $row;
                    unset($data[$row['id']]);
                }
            }
        }
        return $data;
    }

    //获取分类信息用于显示分类名称
    public function getCategoryListForShowName() {
        $fields = 'id,cat_name,url';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->queryAll();

        $data = array();
        if($list){
            foreach($list as $row){
                $data[$row['id']] = $row;
            }
        }
        return $data;
    }

    //分类的添加和编辑页面使用
    public function getSelectCategoryForEdit(){
        $fields = 'id,cat_name,level,parent_id';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->where('level<2')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

    //商品的分类和添加时使用
    public function getSelectCategoryForProductEdit(){
        $fields = 'id,cat_name,level,parent_id';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_category')
        ->order('level,sort')
        ->where('select_able = 1') //可选
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }

        foreach ($newList as &$row ) {
            if($row['level'] == 2){
                $newList[$row['parent_id']]['child'][$row['id']] = $row;
                unset($newList[$row['id']]);
            }
        }
        return $newList;
    }
    
    /**
     * 获取所有的分类信息列表
     * @return type
     */
    public function getCategoryList() {
        $fields = '*';
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
    
    /**
     * 获取加个的分类区间
     * @param type $price
     */
    public function getPriceRange($id,$type='info'){
		
        $a = array();
        $a[1] = array('min'=>0,'max'=>99);
        $a[2] = array('min'=>100,'max'=>299);
        $a[3] = array('min'=>300,'max'=>499);
        $a[4] = array('min'=>500,'max'=>799);
        $a[5] = array('min'=>800,'max'=>1499);
        $a[6] = array('min'=>1500,'max'=>2999);
        $a[7] = array('min'=>3000,'max'=>4999);
        $a[8] = array('min'=>5000,'max'=>9999);
        $a[9] = array('min'=>10000,'max'=>false);
        if ($type=="info" && isset($a[$id])) {//获取价格区间
                return $a[$id];
        }elseif($type=="info"){//默认返回价格区间1
                return $a[1];
        }
        return $a;
    }


    /**
     * 面包屑
     * @param int $catId
     * @return array|bool
     */
    public function getCakeLine($catId=0)
    {
        if(empty($catId)){return false;}

        $catList = Category::model()->getCategoryList();

        $lineArr = array();
        $catTwoInfo = $catList[$catId];
        $lineArr['cattwo'] = array('id'=>$catId,'cat_name'=>$catTwoInfo['cat_name']);

        $catOneInfo = $catList[$catTwoInfo['parent_id']];
        $lineArr['catone'] = array('id'=>$catOneInfo['id'],'cat_name'=>$catOneInfo['cat_name']);
        return $lineArr;
    }


    /**
     * 根据条件查询相关的分类商品
     * @param $filter
     */
    public function getCategoryProducts($filter)
    {
        if(empty($filter)){ return ''; }

        $count = Yii::app()->shop->createCommand()
            ->select('count(1)')
            ->from('bg_product as p')
            ->leftJoin('bg_category as c','p.cat_id = c.id')
            ->where($filter['where'])
            ->queryScalar();

        $fields = 'p.id,p.product_name,p.sell_price,p.market_price,p.discount,p.quantity,p.like_num';
        $list = Yii::app()->shop->createCommand()
            ->select($fields)
            ->from('bg_product as p')
            ->leftJoin('bg_category as c','p.cat_id = c.id')
            ->where($filter['where'])
            ->order($filter['order'])
            ->limit($filter['limit'])
            ->offset($filter['offset'])
            ->queryAll();

        //批量处理图片
        $product_ids = array();
        $newList = array();
        if($list){
            foreach($list as $row){
                array_push($product_ids,$row['id']);
                $newList[$row['id']] = $row;
            }

            $image_list = Product::model()->getProductFaceImageByProductIds($product_ids);
            if(!empty($image_list)){
                foreach($image_list as $row){
                    $newList[$row['product_id']]['images'] = $row['images'];
                }
            }
        }
        return array('list'=>$newList,'count'=>$count);
    }

    /**
     * 处理页面的输入参数
     * @return array
     */
    public function parseFilter($request)
    {
        $filter = array();
        $filter['id'] 		= intval($request['id']);     //分类
        $filter['brand'] 	= intval($request['brand']);	//品牌
        $filter['price'] 	= intval($request['price']);	//价格区间(数字类型的)
        $filter['size'] 	= intval($request['size']);	//尺寸
        $filter['origin'] 	= intval($request['origin']);	//原产地
        $filter['color'] 	= intval($request['color']);	//颜色
        $filter['sort'] 	= intval($request['sort']);	//排序
        $filter['p'] 		= intval($request['p']);		//分页
        $filter['p'] 		= empty($filter['p']) ? 1 : intval($filter['p']);
        $filter['limit'] =  20;
        $filter['offset'] = ($filter['p'] - 1) * $filter['limit'];
        $filter['where'] = ' p.status = 2 and p.is_show = 1 ';
        $filter['option_where'] = ' p.status = 2 and p.is_show = 1 ';

        if(!empty($filter['id'])){ //分类筛选
            $catelist = Category::model()->getCategoryList();
            $catinfo = $catelist[$filter['id']];
            if(!empty($catinfo)){
                if($catinfo['level'] == 1){
                    $filter['where'] .= ' and c.parent_id = '.intval($filter['id']);
                    $filter['option_where'] .= ' and c.parent_id = '.intval($filter['id']);
                }elseif($catinfo['level'] == 2){
                    $filter['where'] .= ' and p.cat_id = '.intval($filter['id']);
                    $filter['option_where'] .= ' and p.cat_id = '.intval($filter['id']);
                }
            }
        }

        if(!empty($filter['brand'])){ //品牌筛选
            $filter['where'] .= ' and p.brand_id = '.intval($filter['brand']);
        }
        if(!empty($_REQUEST['price'])){//价格筛选
            $priceRange = Category::model()->getPriceRange($_REQUEST['price']);
            $min = intval($priceRange['min']);
            $max = $priceRange['max'] == false ? false : intval($priceRange['max']) + 1;
            $filter['where'] .= ' and p.sell_price >= '.$min;
            if($max > 0){
                $filter['where'] .= ' and p.sell_price <= '.$max;
            }
        }
        if(!empty($filter['size'])){//尺寸筛选
            $filter['where'] .= ' and p.attr_id = '.intval($filter['size']);
        }

        $filter['order'] = 'p.id desc';
        if(!empty($filter['sort'])){
            if($filter['sort'] == 1){
                $filter['order'] = 'p.sold_num desc';
            }elseif($filter['sort'] == 2){
                $filter['order'] = 'p.add_time desc';
            }elseif($filter['sort'] == 3){
                $filter['order'] = 'p.sell_price desc';
            }
        }
        return $filter;
    }

    /**
     * 获取分类的筛选条件.
     * @param $filter
     */
    public function getCategoryOptions($filter)
    {
        $options = array();
        $options['brands'] = $this->getOptionBrands($filter);
        $options['prices'] = $this->getOptionPrices();
        return $options;
    }

    /**
     * 获取分类的品牌选项
     * @param $filter
     * @return string
     */
    public function getOptionBrands($filter)
    {
        $field = 'p.brand_id as id';
        $group = 'p.brand_id';
        $list = Yii::app()->shop->createCommand()
            ->select($field)
            ->from('bg_product p')
            ->leftJoin('bg_category c','p.cat_id = c.id')
            ->where($filter['option_where'])
            ->group($group)
            ->queryAll();
        if(empty($list)){return '';}

        $brandList = Brand::model()->getBrandList();
        foreach ($list as &$value) {
            $value['brand_name'] = isset($brandList[$value['id']]) ? $brandList[$value['id']]['brand_name'] : '';
        }
        return $list;
    }

    /**
     * 获取加个选项
     * @param $filter
     * @param $optionWhere
     * @return array|bool
     */
    protected function getOptionPrices()
    {
        $priceRange = Category::model()->getPriceRange('','array');//获取价格区间数组
        if(empty($priceRange)){return false;}

        $list = array();
        foreach ($priceRange as $key => $value) {
            $priceName = empty($value['min']) ? '' : $value['min'];
            $priceName .= empty($value['min']) || empty($value['max']) ? '' :'-';
            $priceName .= empty($value['max']) ? '以上' : $value['max'];
            $list[$key] = $priceName;
        }
        return $list;
    }

    /**
     * 获取选项的列表
     * @param $filter
     */
    protected function getOptionAttr($filter)
    {

    }

    /**
     * 处理分类商品的喜欢状态.
     * @param $userId
     * @param $list
     * @return string
     */
    public function getCategoryProductLikeStatus($userId,$list)
    {
        if(empty($userId) || empty($list)){return '';}
        $product_ids = array();
        foreach($list as $row){
            array_push($product_ids,$row['id']);
        }
        $likeList = Like::model()->findAllByAttributes(array('user_id'=>$userId,'product_id'=>$product_ids));
        if(empty($likeList)){ return $list; }

        foreach($likeList as $row) {
            if(isset($list[$row->product_id])){
                $list[$row->product_id]['is_like'] = 1;
            }
        }
        return $list;
    }

}
