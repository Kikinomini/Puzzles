<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\PaymentInfoManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaymentInfoManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new PaymentInfoManager($em->getRepository('\BikeStore\Model\PaymentInfo'));
	}
}