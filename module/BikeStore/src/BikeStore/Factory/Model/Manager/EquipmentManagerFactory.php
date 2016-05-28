<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\EquipmentManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EquipmentManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new EquipmentManager($em->getRepository('\BikeStore\Model\Equipment'));
	}
}