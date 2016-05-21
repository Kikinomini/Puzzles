<?php


namespace Application\Factory\Model\Manager;

use Application\Model\Manager\RoleManager;
use DoctrineORMModule\Options\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleManagerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $em */
        $em = $serviceLocator->get('doctrine.entitymanager.custom');
        return new RoleManager($em->getRepository('\Application\Model\Role'));
    }
} 