<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 */
class Brand extends CActiveRecord
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
        return 'bg_brand';
    }

    //获取菜单列表
    public function getBrandListPage(){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $criteria = new CDbCriteria(); 
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;
        if(!empty($_REQUEST['brand_name'])){
            $criteria->compare('brand_name',$_REQUEST['brand_name'],true);
        }

        $count = self::model()->count($criteria); 
        $list = self::model()->findAll($criteria); 
        return array(
                'count'=>$count,
                'list'=>$list,
                'pageNum'=>$pageNum,
                );
    }

    //商品页面 选择品牌列表
    public function getSelectBrandForProductEdit(){
        $fields = 'id,brand_name';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_brand')
        ->order('sort')
        ->where('is_show = 1')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

    public function getBrandList(){
        $fields = 'id,brand_name';
        $list = Yii::app()->shop->createCommand()
        ->select($fields)
        ->from('bg_brand')
        //->order('sort')
        //->where('is_show = 1')
        ->queryAll();
        $newList = array();
        foreach ( $list as $row ) {
            $newList[$row['id']] = $row;
        }
        return $newList;
    }

    /**
     * 获取品牌列表.
     * @param $request
     * @return array
     */
    public function getBrandListByPageForWeb($request)
    {
        $pageNum = empty($request['p']) ? 1 : $request['p'];
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;

        $count = self::model()->count($criteria);
        $list = self::model()->findAll($criteria);
        $newList = array();
        if(!empty($list)){
            foreach($list as $row){
                $newList[] = $row->getAttributes();
            }
        }

        $filter = array();
        $filter['p'] = $pageNum;
        $filter['page_size'] = 20;
        return array(
            'count'     => $count,
            'list'      => $newList,
            'filter'    => $filter,
        );
    }

    /**
     * 获取品牌的详情
     * @param $brand_id
     * @return array|null|string|static
     */
    public function getBrandInfoForWeb($brand_id)
    {
        $brandInfo = Brand::model()->findByPk($brand_id);
        if(empty($brandInfo)){
            return '';
        }
        $brandInfo = $brandInfo->getAttributes();
        $brandInfo['brand_logo'] = $brandInfo['brand_logo'] ? 'images/brand/'.$brandInfo['brand_logo'] : '';
        return $brandInfo;
    }

    /**
     * 前端展示品牌商品页面数据
     */
    public function getBrandProductByPageForWeb($request)
    {
        $pageNum = empty($request['p']) ? 1 : $request['p'];
        $criteria = new CDbCriteria();
        $criteria->select = 'id,product_name,sell_price,market_price,discount';
        $criteria->compare('brand_id',$request['id'],true);
        $criteria->compare('is_show',1);
        $criteria->compare('status',2);
        $criteria->order = 'id DESC';
        $criteria->offset = ($pageNum-1)*20;
        $criteria->limit = 20;

        $count = Product::model()->count($criteria);
        $list = Product::model()->findAll($criteria);
        $newList = array();
        if(!empty($list)){
            foreach($list as $row){
                $temp = $row->getAttributes();
                $temp['images'] = Product::model()->getProductFaceImageByProductId($row->id);
                $newList[] = $temp;
            }
        }

        $filter = array();
        $filter['p'] = $pageNum;
        $filter['page_size'] = 20;
        return array('count' => $count, 'list' => $newList, 'filter' => $filter);
    }

}
