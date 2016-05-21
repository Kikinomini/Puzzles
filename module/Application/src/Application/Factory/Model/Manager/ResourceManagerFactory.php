<?php

namespace Application\Factory\Model\Manager;

use Application\Model\Manager\ResourceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ResourceManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.custom');
        return new ResourceManager( $em->getRepository('\Application\Model\Resource'));
    }
} 