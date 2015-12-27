<?php
class ApiModule extends CWebModule
{
    public $defaultController = 'public';
    public function init()
    {
        parent::init();
        // $this->setImport(array(
        // 	'application.models.*',
        // 	'auth.models.*',
        // 	'auth.components.*',
        // ));
    }
}