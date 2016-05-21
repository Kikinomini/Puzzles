<?php

namespace Cronjob\Factory\Model\Manager;

use Cronjob\Model\Manager\CronjobManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CronjobManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.Cronjob');
        return new CronjobManager($em->getRepository('\Cronjob\Model\Cronjob'), $serviceLocator);
    }
} 