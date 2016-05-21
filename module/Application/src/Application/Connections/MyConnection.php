<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 23:23
 */

namespace Application\Connections;


use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class MyConnection extends Connection
{
	static private $defaults = array();

	static public function setDefaults(array $defaults){
		self::$defaults = $defaults;
	}
	public function __construct(array $params, Driver $driver, Configuration $config = null, EventManager $eventManager = null)
	{
		$params = array_merge(self::$defaults, $params);
		parent::__construct($params, $driver, $config, $eventManager);
	}

}