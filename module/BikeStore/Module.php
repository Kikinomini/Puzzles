<?php

namespace BikeStore;

use Zend\EventManager\Event;
use Zend\Http\Request;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		$e->getApplication()->getEventManager()->getSharedManager()->attach("*",MvcEvent::EVENT_RENDER, function(MvcEvent $e){
			$sessionContainer = new Container("shoppingCart");
			if ($sessionContainer->offsetExists("articles"))
			{
				$numberArticles = 0;
				$articles = $sessionContainer->offsetGet("articles");
				foreach($articles as $article)
				{
					$numberArticles += $article["count"];
				}
				/** @var ViewModel $viewModel */
				$viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
				$viewModel->setVariable("numberArticlesInShoppingCart", $numberArticles);
			}
		});
		/** @var Request $request */
		$request = $e->getRequest();
		if ($request->isGet());
		{
			/** @var ViewModel $viewModel */
			$viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
			$viewModel->setVariable("searchString", $request->getQuery("search", ""));
		}
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
				)
			)
		);
	}
}

