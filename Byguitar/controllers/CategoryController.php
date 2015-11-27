<?php

class CategoryController extends ShopBaseController {
    
    /**
     * 分类页面默认控制器
     */
    public function actionIndex()
    {
        $filter = Category::model()->parseFilter($_REQUEST);
        $result = Category::model()->getCategoryProducts($filter);
        if(empty($result) || empty($result['list']) || $result['count'] <= 0){
            $this->redirect('/?from=no_list');//跳转到首页
        }
        $options = Category::model()->getCategoryOptions($filter);

        $pages 		= '';//正常分页信息
        $pageShort 	= '';//短分页信息
        $urlStr = '/category/'.Common::instance()->getFormatUrl('category',$filter);
        if($result['count'] >0 ){
           $pages		= Common::instance()->get_page_list($result['count'], $filter['p'], $filter['limit'], $urlStr,'category');
           $pageShort	= Common::instance()->get_page_short($result['count'], $filter['p'], $filter['limit'], $urlStr,'category');
        };

        $cakeInfo 	= Category::model()->getCakeLine($filter['id']);
        $userId = $this->user_id;
        if($userId){
            $result['list'] = Category::model()->getCategoryProductLikeStatus($userId,$result['list']);
        }

        $viewData = array();
        $viewData['list'] = $result['list'];
        $viewData['count'] = $result['count'];
        $viewData['options'] = $options;
        $viewData['filter'] = $filter;
        $viewData['pages'] = $pages;
        $viewData['pageShort'] = $pageShort;
        $viewData['cakeInfo'] = $cakeInfo;
        $this->render('category/index',$viewData);
    }
    
}