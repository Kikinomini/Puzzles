<?php

namespace BikeStore\Factory\Model\Manager\Equipment;

use BikeStore\Model\Manager\Equipment\DynamoManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DynamoRepository implements FactoryInterface
{
  public function createService(ServiceLocatorInterface $serviceLocator)
  {
    $em = $serviceLocator->get('doctrine.entitymanager.custom');
    return new DynamoManager($em->getRepository('\BikeStore\Model\Equipment\Dynamo'));
  }
}