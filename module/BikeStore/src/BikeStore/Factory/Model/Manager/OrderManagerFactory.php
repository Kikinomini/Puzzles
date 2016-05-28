<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\OrderManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrderManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new OrderManager($em->getRepository('\BikeStore\Model\Order'));
	}
}