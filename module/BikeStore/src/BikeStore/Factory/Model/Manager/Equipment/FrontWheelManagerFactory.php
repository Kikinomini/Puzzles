<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\FrontWheelManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FrontWheelManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new FrontWheelManager($em->getRepository('\BikeStore\Model\Equipment\FrontWheel'));
	}
}