<?php

//网站做的基础类 可以做一些公共的操作
class ShopBaseController extends CController 
{
    public $params; //模板向叶面赋值通过此参数
    public $user_id = '';
    public $webUrl = 'www.byguitar.com';
    public $webConfig;
    
    public function __construct(){
        //parent::__construct("Shop");
        $this->getHeadMenuList();
        if(isset(Yii::app()->session->user_id)){
            Yii::app()->session->user_id = '';
        }

        $cateList = Category::model()->getCategoryListForShopNavigation();
        $this->params['cateList'] = $cateList;
        $this->user_id = Yii::app()->session['authId'];

        $config = Yii::app()->params;
        $this->webConfig    = $config;
        $this->webUrl       = $config['url']['web_url'];
    }
    
    public function getHeadMenuList(){

        $fileds = 'name,link,type,title,target';
        $where = 'status=1 and level=1';
        $order = 'sort asc';
        $list = Yii::app()->byguitar->createCommand() 
        ->select($fileds) 
        ->from('bg_menu') 
        ->where($where) 
        ->order($order)
        ->queryAll();
        $this->params['menu'] = $list;
        //echo "<pre>";
        //print_r($list);exit;
    }

    /**
     * api返回数据统一封装.
     * @param $data
     * @param string $tipInfo
     * @param int $status
     * @param int $code
     * @param bool|false $is_cache
     * @param string $type
     */
    public function ApiAjaxReturn($data,$tipInfo='',$status=1,$code=200,$is_cache=false,$type='json')
    {
        $result  =  array();
        $result['status']   =  $status;
        $result['tipinfo']  =  $tipInfo;
        $result['data']     = $data;
        $type = empty($type) ? 'json' : $type;
        if(strtoupper($type) == 'json')
        {
            //统一处理
            $code = $status!=1 && $code!=200 ? 404 : $code;

            if(!empty($code)){
                header("Content-Type:application/json; charset=utf-8",true, $code);
            }else{
                header("Content-Type:application/json; charset=utf-8");
            }

            if(!$is_cache){
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Pragma: no-cache");
            }else{
                header("Cache-Control: max-age=3600");
                header("Pragma:");
            }
        }elseif(strtoupper($type)=='XML'){
            // 返回xml格式数据
            header("Content-Type:text/xml; charset=utf-8");
            //exit(xml_encode($result));
        }elseif(strtoupper($type)=='EVAL'){
            // 返回可执行的js脚本
            header("Content-Type:text/html; charset=utf-8");
            exit(print_r($data));
        }
        echo json_encode($result);
    }

}

