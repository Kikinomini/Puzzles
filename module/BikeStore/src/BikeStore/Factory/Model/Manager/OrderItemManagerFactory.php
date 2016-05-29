<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\OrderItemManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrderItemManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new OrderItemManager($em->getRepository('\BikeStore\Model\OrderItem'));
	}
}