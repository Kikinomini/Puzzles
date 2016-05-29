<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\GearShiftManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GearShiftManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new GearShiftManager($em->getRepository('\BikeStore\Model\Equipment\GearShift'));
	}
}