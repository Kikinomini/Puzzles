<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 25.05.16
 * Time: 18:04
 */

namespace Portal\Factory\Navigation\Service;


use Zend\Navigation\Service\DefaultNavigationFactory;

class MainNavigationServiceFactory extends DefaultNavigationFactory
{
	protected function getName()
	{
		return 'mainNavigation';
	}
}