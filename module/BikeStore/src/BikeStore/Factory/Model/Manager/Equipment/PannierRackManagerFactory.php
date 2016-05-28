<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\PannierRackManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PannierRackManagerFactory implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $em = $serviceLocator->get('doctrine.entitymanager.custom');
    return new PannierRackManager($em->getRepository('\BikeStore\Model\Equipment\PannierRack'));
  }
}