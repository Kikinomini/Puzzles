<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\SaddleBarManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SaddleBarManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new SaddleBarManager($em->getRepository('\BikeStore\Model\Equipment\SaddleBar'));
	}
}