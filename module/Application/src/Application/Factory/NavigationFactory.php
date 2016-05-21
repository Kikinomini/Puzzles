<?php

namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface as FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocatorInterface;
use Zend\View\Helper\HelperInterface;
use Zend\View\HelperPluginManager;

class NavigationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = $serviceLocator->get('Zend\View\Helper\Navigation');
        return $navigation;
    }
}