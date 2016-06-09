<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 09.06.16
 * Time: 12:19
 */

namespace BikeStore\Factory\View;

use BikeStore\View\PriceHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PriceHelperFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new PriceHelper();
	}
}