<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */


namespace Application;

use Application\Connections\MyConnection;
use Detection\MobileDetect;
use silas\Interfaces\CronjobModelInterface;
use silas\Interfaces\MySettingsInterface;
use Application\Model\MyAcl;

use Application\Model\User;
use Zend\EventManager\Event;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Log\Formatter\Simple;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class Module implements CronjobModelInterface, MySettingsInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		$serviceLocator = $e->getApplication()->getServiceManager();
		$dbConfig = $serviceLocator->get('config');
		$dbConfig = $dbConfig["dbDefault"];
		MyConnection::setDefaults($dbConfig);

		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

//		/** @var ViewModel $viewModel */
//		$viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
//		$viewModel->setVariable("numberArticlesInShoppingCart", 0);

		$logger = new Logger();
		$writer = new Stream(dirname(dirname(__DIR__)) . "/Log/log.log");
		$formatter = new Simple("[%timestamp%] <%priorityName% (%priority%)>: %message%");
		$writer->setFormatter($formatter);
		$logger->addWriter($writer);

		$eventManager->getSharedManager()->attach('*', 'log', function(Event $e) use ($logger)
		{
			$params = $e->getParams();

			if(isset($params["message"]))
			{
				if(isset($params["level"]) && ($params["level"] == Logger::ALERT || $params["level"] == Logger::CRIT ||
											   $params["level"] == Logger::DEBUG || $params["level"] == Logger::EMERG ||
											   $params["level"] == Logger::ERR || $params["level"] == Logger::INFO ||
											   $params["level"] == Logger::NOTICE)
				)
				{
					$logLevel = $params["level"];
				}
				else
				{
					$logLevel = Logger::INFO;
				}
				$logger->log($logLevel, $params["message"]);
			}
		});

		$serviceManager = $e->getApplication()->getServiceManager();
		if($e->getRequest() instanceof Request)
		{
			$this->bootstrapSession($e);
			/** @var MyAcl $acl */
			$acl = $serviceManager->get('Acl');
			$eventManager->getSharedManager()->attach('Zend\Mvc\Application', 'dispatch', function($e) use ($acl)
			{
				MyAcl::authorisation($e, $acl);
			}, 100000);
		}

		$eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH, function(MvcEvent $e)
		{
			$routeMatch = $e->getRouteMatch();
			if($routeMatch->getParam("mobile", false))
			{
				$model = $e->getResult();
				if(!$model instanceof ViewModel)
				{
					return;
				}
				$mobileDetect = new MobileDetect();
				if($mobileDetect->isMobile())
				{
					$model->setTemplate($model->getTemplate() . "_mobile");
				}
			}
		}, -95);

		$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'dispatchError'), -100);
		$eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatchError', array($this, 'dispatchError'));
		if($e->getRequest() instanceof Request)
		{
			$this->bootstrapSession($e);
		}
	}

	public function dispatchError(MvcEvent $e)
	{
		$logger = new Logger();
		$writer = new Stream(dirname(dirname(__DIR__)) . "/Log/dispatchError.log");
		$writer2 = new Stream(dirname(dirname(__DIR__)) . "/Log/log.log");
		$formatter = new Simple("[%timestamp%] <%priorityName% (%priority%)>: %message%");
		$writer->setFormatter($formatter);
		$writer2->setFormatter($formatter);
		$logger->addWriter($writer);
		$logger->addWriter($writer2);

		$sm = $e->getApplication()->getServiceManager();

		/** @var Request $request */
		$request = $e->getRequest();
		$response = $e->getApplication()->getResponse();
		/** @var ViewModel $viewModel */
		$viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
		$viewModel->isOnline = true;

		$error = $e->getError();
		$exception = $e->getParam("exception");
		if($exception instanceof \Exception)
		{
			$logger->err($exception->getMessage() . " - ErrorCode: " . $exception->getCode() . " File: " .
						 $exception->getFile() . " Line: " . $exception->getLine());
		}
		else
		{
			$logger->err($error);
		}

		if($response instanceof Response)
		{
			if($response->isOk())
			{
				$errorTemplate = "error/index";
			}
			else
			{
				switch($response->getStatusCode())
				{
					case 401:
					case 403:
					{
						$user = $sm->get("userManager")->getUserFromSession();
						if(!($user instanceof User))
						{
							$sessionContainer = new Container("loginTarget");
							$sessionContainer->offsetSet("loginTarget", $request->getUriString());
							$viewModel->isOnline = false;
						}
						$errorTemplate = 'error/403';
						break;
					}
					case 404:
					{
						$errorTemplate = 'error/404';
						break;
					}
					default:
					{
						$errorTemplate = 'error/statusCode';
						$viewModel->statusCode = $response->getStatusCode();
						$viewModel->reasonPhrase = $response->getReasonPhrase();

						break;
					}
				}
			}
			$child = new ViewModel();
			$child->setTemplate($errorTemplate);
			$viewModel->addChild($child);

			$e->setViewModel($viewModel);
			$e->stopPropagation(true);
		}
		elseif($response instanceof \Zend\Console\Response)
		{
			//TODO error für Console
			echo "ErrorLevel: " . $response->getErrorLevel() . PHP_EOL;
//            die("DispatchError! ".__FILE__." LINE:".__LINE__);
		}
		else
		{
			die("Unbekannter Response! in " . __FILE__ . " LINE:" . __LINE__);
		}
	}

	public function getConfig()
	{
		$config = array();
		foreach(glob(__DIR__ . '/config/*.config.php') as $filename)
		{
			$config = array_merge_recursive($config, include($filename));
		}
		return $config;
	}

	public function getAutoloaderConfig()
	{
		return array('Zend\Loader\StandardAutoloader' => array(
			'namespaces' => array(
				__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				'fpdf' => dirname(dirname(__DIR__)) . "/myVendor/fpdf",
				'fpdi' => dirname(dirname(__DIR__)) . "/myVendor/fpdi",
				'MyTelegramBot' => dirname(dirname(__DIR__)) . "/myVendor/MyTelegramBot",
				'SetCookie' => dirname(dirname(__DIR__)) . "/myVendor/SetCookie",
				'SimpleHtmlDom' => dirname(dirname(__DIR__)) . "/myVendor/SimpleHtmlDom",
			),
		),
		);
	}

	/**
	 * @return array
	 */
	public function getCronjobs()
	{
		return array(
			'\Application\Model\DeleteCodeCronjob'
		);
	}

	public function bootstrapSession(MvcEvent $e)
	{
		$session = $e->getApplication()
			->getServiceManager()
			->get('Zend\Session\SessionManager');
		$session->start();

		$container = new Container('initialized');
		if(!isset($container->init))
		{
			$serviceManager = $e->getApplication()->getServiceManager();
			$request = $serviceManager->get('Request');

			$session->regenerateId(true);
			$container->init = 1;
			$container->remoteAddr = $request->getServer()->get('REMOTE_ADDR');
			$container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');

			$config = $serviceManager->get('Config');
			if(!isset($config['session']))
			{
				return;
			}

			$sessionConfig = $config['session'];
			if(isset($sessionConfig['validators']))
			{
				$chain = $session->getValidatorChain();

				foreach($sessionConfig['validators'] as $validator)
				{
					switch($validator)
					{
						case 'Zend\Session\Validator\HttpUserAgent':
							$validator = new $validator($container->httpUserAgent);
							break;
						case 'Zend\Session\Validator\RemoteAddr':
							$validator = new $validator($container->remoteAddr);
							break;
						default:
							$validator = new $validator();
					}

					$chain->attach('session.validate', array($validator, 'isValid'));
				}
			}
		}
	}

	public function getSettings()
	{
		return array(
			array(
				'label' => 'Allgemein',
				'route' => 'settings',
				'resource' => 'online'
			),
			array(
				'label' => 'Passwort ändern',
				'route' => 'settings/changePassword',
				'resource' => 'online',
				'order' => 10,
			)
		);
	}


}
