<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\DeliveryAddressManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeliveryAddressManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new DeliveryAddressManager($em->getRepository('\BikeStore\Model\DeliveryAddress'));
	}
}