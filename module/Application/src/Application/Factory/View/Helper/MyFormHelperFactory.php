<?php

namespace Application\Factory\View\Helper;

use Application\View\Helper\MyFormHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyFormHelperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $phpRenderer = $serviceLocator->getRenderer();
        return new MyFormHelper($phpRenderer);
    }
} 