<?php
class ManageModule extends CWebModule
{
	public $defaultController = 'index';
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