<?php

class CategoryController extends ShopBaseController {
    
    /**
     * 分类页面默认控制器
     */
    public function actionIndex(){
//        echo "<pre>";
        
        $condition = $this->parseInput();
//        print_r($condition);
//        exit;
        $filter     = $condition['filter'];
        $where 	    = $condition['where'];
        $order      = $condition['order'];
        $pagenum    = $condition['pagenum'];
        $limit      = $condition['limit'];
        $offset      = $condition['offset'];
        $optionWhere = $condition['optionWhere'];

        //$listKey = 'category_'.$pagenum.implode('-',$filter);
        //$result = $this->MemcacheSmartGet($listKey,300,array($this,'getCateResult'),array($filter,$where,$sort,$limit));
        $result = $this->getCateResult($filter,$where,$order,$offset,$limit,$optionWhere);
//        echo "<pre>";
//        print_r($result);
//        exit;
        $list 		= $result['list']; //商品列表信息
        $count 		= $result['count'];//商品条数
        $options 	= $result['options'];//商品可选项
        
        $pages 		= '';//正常分页信息
        $pageShort 	= '';//短分页信息
        //$urlStr = C('WEB').'/shop/category/'.getFormatUrl('category',$filter);
//        if($count >0 ){
//                $pages		= get_page_list($count, $filter['p'], $pagenum, $urlStr,'category');
//                $pageShort	= get_page_short($count, $filter['p'], $pagenum, $urlStr,'category');
//        };

        //$cakeInfo 	= $this->getCakeInfo($filter);

        //$list = $this->getLikeStatusByList($list);
        //$likeKey = 'like_'.md5(serialize($list));
        //$list = $this->MemcacheSmartGet($likeKey,300,array($this,'getLikeStatusByList'),array($list));
        
        $viewData = array();
        $viewData['list'] = $list;
        $viewData['count'] = $count;
        $viewData['options'] = $options;
        $viewData['filter'] = $filter;
        $viewData['pages'] = $pages;
        $viewData['pageShort'] = $pageShort;
        $viewData['cakeInfo'] = $cakeInfo;
        $this->render('category/index',$viewData);
    }
    
    /**
     * 初始化和预处理输入参数
     */
    private function parseInput(){
        $filter = array();
        $where 	= '';
        $pagenum = 20;//每页的个数

        $where .= 'p.status = 2';
        $where 	.= ' and p.is_show = 1';

        $filter['id'] 		= intval($_REQUEST['id']);     //分类
        $filter['brand'] 	= intval($_REQUEST['brand']);	//品牌
        $filter['price'] 	= intval($_REQUEST['price']);	//价格区间(数字类型的)
        $filter['size'] 	= intval($_REQUEST['size']);	//尺寸
        $filter['origin'] 	= intval($_REQUEST['origin']);	//原产地
        $filter['color'] 	= intval($_REQUEST['color']);	//颜色
        $filter['sort'] 	= intval($_REQUEST['sort']);	//排序
        $filter['p'] 		= intval($_REQUEST['p']);		//分页
        $filter['p'] 		= empty($filter['p']) ? 1 : intval($filter['p']);
        $limit =  $pagenum;
        $offset = ($filter['p'] - 1) * $pagenum;

        if(!empty($filter['id'])){ //分类筛选
            $catelist = Category::model()->getCategoryList();
            $catinfo = $catelist[$filter['id']];
            if(!empty($catinfo)){
                if($catinfo['level'] == 1){
                    $where .= ' and pc.one_id = '.intval($filter['id']);
                }elseif($catinfo['level'] == 2){
                    $where .= ' and pc.two_id = '.intval($filter['id']);
                }
            }
        }
        $optionWhere = $where;
        
        if(!empty($filter['brand'])){ //品牌筛选
            $where .= ' and p.brand_id = '.intval($filter['brand']);
        }
        if(!empty($_REQUEST['price'])){//价格筛选
            $priceRange = Category::model()->getPriceRange($_REQUEST['price']);
            $min = intval($priceRange['min']); 
            $max = $priceRange['max'] == false ? false : intval($priceRange['max']) + 1;
            $where .= ' and p.sell_price >= '.$min;
            if($max > 0){
                $where .= ' and p.sell_price <= '.$max;
            }
        }
        if(!empty($filter['size'])){//尺寸筛选
            $where .= ' and p.attr_id = '.intval($filter['size']);
        }
        if(!empty($filter['origin'])){//产地筛选
            $where .= ' and p.origin_id = '.intval($filter['origin']);
        }
        if(!empty($filter['color'])){//颜色筛选
            $where .= ' and p.color_id = '.intval($filter['color']);
        }
        $order = 'p.id desc';
        if(!empty($filter['sort'])){
            if($filter['sort'] == 1){
                    $order = 'p.sold_num desc';
            }elseif($filter['sort'] == 2){
                    $order = 'p.add_time desc';
            }elseif($filter['sort'] == 3){
                    $order = 'p.sell_price desc';
            }
        }
        return array('filter'=>$filter,'where'=>$where,'order'=>$order, 'limit' => $limit,'offset'=>$offset, 'pagenum'=>$pagenum,'optionWhere'=>$optionWhere);
    }
    
    /**
     * 获取分类数据
     */
    private function getCateResult($filter,$where,$order,$offset,$limit,$optionWhere){
        $pageNum = empty($_REQUEST['pageNum']) ? 1 : $_REQUEST['pageNum'];
        $numPerPage = empty($_REQUEST['numPerPage']) ? 20 : $_REQUEST['numPerPage'];
        
        $count = Yii::app()->shop->createCommand()
                ->select('count(1)')
                ->from('bg_product p')
                ->leftJoin('bg_product_category pc','p.cat_id = pc.id')
                ->where($where)
                ->queryScalar();
  
        $list = Yii::app()->shop->createCommand()
                ->select('p.*')
                ->from('bg_product p')
                ->leftJoin('bg_product_category pc','p.cat_id = pc.id')
                ->where($where)
                ->order($order)
                ->limit($limit)
                ->offset($offset)
                ->queryAll();
        
        $options = array();
        $options['brand'] 	= $this->getOptionBrands($filter,$optionWhere);	//品牌
        $options['price'] 	= $this->getOptionPrices($filter,$optionWhere);  	//价格
//        $options['size'] 	= $this->getOptionSizes($filter,$where);	//尺寸
//        $options['origin'] 	= $this->getOptionOrigins($filter,$where);	//原产地
//        $options['color'] 	= $this->getOptionColors($filter,$where);	//原产地
//        $newList = array();
//        if(!empty($list)){
//            foreach ($list as $row) {
//                $pInfo = $this->product->getProductInfo($row['id']);
//                unset($pInfo['detail']);
//                array_push($newList, $pInfo);
//            }
//        }
//
        return array('list'=>$list,'count'=>$count,'options'=>$options); 
    }
    
    public function getOptionBrands($filter,$optionWhere){
        $list = array();
        $group = 'p.brand_id';
        $field = 'p.brand_id as id';
        $list = Yii::app()->shop->createCommand()
                ->select($field)
                ->from('bg_product p')
                ->leftJoin('bg_product_category pc','p.cat_id = pc.id')
                ->where($optionWhere)
                ->group($group)
                ->queryAll();
        if(empty($list)){return '';}
        
        $brandList = Brand::model()->getBrandList();
        foreach ($list as &$value) {
            $value['brand_name'] = isset($brandList[$value['id']]) ? $brandList[$value['id']]['brand_name'] : '';
        }
        return $list;
    }
    
    protected function getOptionPrices($filter,$optionWhere){
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
    
}