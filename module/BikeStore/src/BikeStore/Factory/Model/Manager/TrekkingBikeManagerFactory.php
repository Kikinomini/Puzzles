<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\TrekkingBikeManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TrekkingBikeManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new TrekkingBikeManager($em->getRepository('\BikeStore\Model\TrekkingBike'));
	}
}