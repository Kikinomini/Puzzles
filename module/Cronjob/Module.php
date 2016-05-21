<?php

namespace Cronjob;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{

	}

	public function getConfig()
	{
		$config = array();
		foreach (glob(__DIR__ . '/config/*.config.php') as $filename)
		{
            $config = array_merge_recursive($config, include($filename));
		}
		return $config;
	}

	public function getAutoloaderConfig()
	{
		return array (
			'Zend\Loader\StandardAutoloader' => array (
				'namespaces' => array (
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					'' => __DIR__ . '/src/' . __NAMESPACE__,
				)
			)
		);

	}
}

