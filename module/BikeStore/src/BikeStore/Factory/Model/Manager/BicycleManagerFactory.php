<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\BicycleManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BicycleManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new BicycleManager($em->getRepository('\BikeStore\Model\Bicycle'));
	}
}