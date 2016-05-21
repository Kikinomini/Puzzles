<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 23:29
 */

namespace Application\Factory\Model\Manager;

use Application\Model\Manager\UserManager;
use Doctrine\ORM\EntityManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Exception\RuntimeException;
use Zend\View\Helper\BasePath;

class UserManagerFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get("config");
		/** @var EntityManager $em */
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		$codeManager = $serviceLocator->get("codeManager");
		$roleManager = $serviceLocator->get('roleManager');
		/** @var Request $request */
		$request = $serviceLocator->get("Request");
		/** @var Response $response */
		$response = $serviceLocator->get("Response");

		/** @var BasePath $basePath */
		$basePath = $serviceLocator->get('ViewHelperManager')->get('basePath');
		try
		{
			$basePath = $basePath->__invoke();
		}
		catch(RuntimeException $e) //No Basepath was set vermutlich Console, daher egal
		{
			$basePath = "";
		}
		return new UserManager($config["systemvariablen"]["passwordHash"], $basePath, $request, $response, $codeManager, $roleManager, $em->getRepository('\Application\Model\User'));
	}
}
