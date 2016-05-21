<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 10.02.15
 * Time: 18:19
 */

namespace Application\Factory\View\Helper;


use Application\View\Helper\DatatablesHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DatatablesHelperFactory implements FactoryInterface
{

	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$phpRenderer = $serviceLocator->getRenderer();
		return new DatatablesHelper($phpRenderer);
	}
}