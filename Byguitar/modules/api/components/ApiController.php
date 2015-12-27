<?php

class ApiController extends CController {
    public $layout = 'manage';

    public function displayJson($data)
    {
        header("Content-type:json/application;charset=utf-8");
        echo json_encode($data);
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





