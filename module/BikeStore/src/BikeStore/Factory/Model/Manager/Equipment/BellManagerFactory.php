<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\BellManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BellManagerFactory implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $em = $serviceLocator->get('doctrine.entitymanager.custom');
    return new BellManager($em->getRepository('\BikeStore\Model\Equipment\Bell'));
  }
}