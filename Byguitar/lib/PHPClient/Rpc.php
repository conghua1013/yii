<?php
/**
 * PHPClient Rpc客户端
 * \PHPClient\Rpc::config($serverConfig['RpcServer']);
 */

namespace PHPClient;
class Rpc extends \PHPClient\RpcClient
{
    protected static $instances = array();
    protected $rpcClass;
    protected $configName;

    /**
     * @param string|array $config 服务的配置名称或配置内容
     *
     * @return  static
     */
    public static function inst($configName)
    {
        if(!isset(static::$instances[$configName]) || PHP_SAPI === 'cli')
        {
            static::$instances[$configName] = new static($configName);
        }
        return static::$instances[$configName];
    }

    protected function __construct($configName)
    {
        $this->configName = $configName;
        $this->serviceName = $configName;
    }

    /**
     * @param string $name Service classname to use.
     * @return $this
     */
    public function setClassName($className)
    {
        //$config = parent::config();
        $this->rpcClass = $className;
        $this->className = $className;
        return $this;
    }

}

/*
    //项目入口初始化
    $config = Yii::app()->params['Rpc_Service'];
    \PHPClient\Rpc::config($config);

    //项目里面的使用
    $obj =  \PHPClient\Rpc::inst('shop')->setClassName('User');
    $data = $obj->getInfoByUid(567);
    print_r($obj);
    print_r($data);
 */