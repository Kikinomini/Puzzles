<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\CityBikeManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CityBikeManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new CityBikeManager($em->getRepository('\BikeStore\Model\CityBike'));
	}
}