<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 21.05.16
 * Time: 21:39
 */

namespace Application\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class SessionManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = $serviceLocator->get('config');
		if(isset($config['session']))
		{
			$session = $config['session'];

			$sessionConfig = null;
			if(isset($session['config']))
			{
				$class = isset($session['config']['class']) ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
				$options = isset($session['config']['options']) ? $session['config']['options'] : array();
				$sessionConfig = new $class();
				$sessionConfig->setOptions($options);
			}

			$sessionStorage = null;
			if(isset($session['storage']))
			{
				$class = $session['storage'];
				$sessionStorage = new $class();
			}

			$sessionSaveHandler = null;
			if(isset($session['save_handler']))
			{
				// class should be fetched from service manager since it will require constructor arguments
				$sessionSaveHandler = $sm->get($session['save_handler']);
			}

			$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
		}
		else
		{
			$sessionManager = new SessionManager();
		}
		Container::setDefaultManager($sessionManager);
		return $sessionManager;
	}

}