<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\MountainBikeManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MountainBikeManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new MountainBikeManager($em->getRepository('\BikeStore\Model\MountainBike'));
	}
}