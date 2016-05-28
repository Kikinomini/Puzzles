<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\ArticleManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArticleManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new ArticleManager($em->getRepository('\BikeStore\Model\Article'));
	}
}