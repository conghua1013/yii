<?php


class PHPClient
{
    protected static $instances = array();
    protected $config;


    //
    // protected function __construct($rpcName){

    // }

    public static function instance($rpcName)
    {
        if(empty($rpcName)){
            throw new exception('rpcName 不能为空！');
        }

        if(!isset(static::$instances[$rpcName]) || PHP_SAPI === 'cli')
        {
            self::config($rpcName);
            static::$instances[$rpcName] = new self();
        }
        return static::$instances[$rpcName];
    }


    public static function config($rpcName)
    {
        $config = Yii::app()->params['Rpc_Service'];
        require_once ROOT_PATH."/Lib/PHPClient/RpcClient.php";

        if(empty($config) || !isset($config[$rpcName]) || empty($config[$rpcName]['uri'])){
            throw new exception('missing【'.$rpcName.'】config');
        }

        // 配置服务端列表
        RpcClient::config($config[$rpcName]['uri']);
    }

    public function setClassName($className)
    {
        return RpcClient::instance($className);
    }


}