<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\PedalManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PedalManagerFactory implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $em = $serviceLocator->get('doctrine.entitymanager.custom');
    return new PedalManager($em->getRepository('\BikeStore\Model\Equipment\Pedal'));
  }
}