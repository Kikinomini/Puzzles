<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\RearWheelManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RearWheelManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new RearWheelManager($em->getRepository('\BikeStore\Model\Equipment\RearWheel'));
	}
}