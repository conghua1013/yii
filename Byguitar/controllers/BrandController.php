<?php

/***********品牌页面*************/

class BrandController extends ShopBaseController
{

    /**
     * 分类页面默认控制器（品牌列表页面）
     */
    public function actionIndex()
    {
        $result = Brand::model()->getBrandListByPageForWeb($_REQUEST);
        if(empty($result) || $result['count'] <= 0 ){
            $this->redirect('/?from=brand_empty');
        }

        $pages = '';//正常分页信息
        $pageShort = '';//短分页信息

        $filter =$result['filter'];
        $urlStr = '/brands';
        if ($result['count'] > 0) {
            $pages = Common::instance()->get_page_list($result['count'], $filter['p'], $filter['page_size'], $urlStr);
            $pageShort = Common::instance()->get_page_short($result['count'], $filter['p'], $filter['page_size'], $urlStr);
        }

        $viewData = array();
        $viewData['list'] = $result['list'];
        $viewData['count'] = $result['count'];
        $viewData['filter'] = $result['filter'];
        $viewData['pages'] = $pages;
        $viewData['pageShort'] = $pageShort;
        $this->render('brand/index', $viewData);
    }

    /**
     * 品牌详情页面(带商品列表)
     */
    public function actionDetail()
    {
        $_REQUEST['id'] = intval($_REQUEST['id']);
        if(empty($_REQUEST['id'])){
            $this->redirect('/?from=brand_empty');
        }

        $brandInfo = Brand::model()->getBrandInfoForWeb($_REQUEST['id']);
        if(empty($brandInfo)){
            $this->redirect('/?from=brand_empty');
        }

        $result = Brand::model()->getBrandProductByPageForWeb($_REQUEST);
        if(empty($result) || $result['count'] <= 0 ){
            $this->redirect('/?from=brand_product_empty');
        }

        $filter =$result['filter'];
        $urlStr = '/brand/'.$_REQUEST['id'];
        $pages = '';
        $pageShort = '';
        if($result['count'] >0 ){
            $pages      = Common::instance()->get_page_list($result['count'], $filter['p'], $filter['page_size'], $urlStr);
            $pageShort  = Common::instance()->get_page_short($result['count'], $filter['p'], $filter['page_size'], $urlStr);
        }

        $viewData = array();
        $viewData['brandInfo'] = $brandInfo;
        $viewData['list'] = $result['list'];
        $viewData['count'] = $result['count'];
        $viewData['filter'] = $result['filter'];
        $viewData['pages'] = $pages;
        $viewData['pageShort'] = $pageShort;
        $this->render('brand/detail', $viewData);
    }
}