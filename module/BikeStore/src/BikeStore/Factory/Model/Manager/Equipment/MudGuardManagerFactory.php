<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\MudGuardManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MudGuardManagerFactory implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $em = $serviceLocator->get('doctrine.entitymanager.custom');
    return new MudGuardManager($em->getRepository('\BikeStore\Model\Equipment\MudGuard'));
  }
}