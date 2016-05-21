<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 13.04.2015
 * Time: 23:14
 */

namespace Cronjob\Model\Manager;

use Application\Model\Manager\StandardManager;
use Cronjob\Model\Cronjob;
use silas\Interfaces\CronjobModelInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CronjobManager extends StandardManager
{
    /** @var Cronjob[] */
    private $cronjobs;

    /** @var  ServiceLocatorInterface */
    private $serviceLocator;

    public function __construct($repository, ServiceLocatorInterface $serviceLocator, $entity = null)
    {
        $this->cronjobs = array();
        $this->serviceLocator = $serviceLocator;
        parent::__construct($repository, $entity);
    }

    public function addCronjob(Cronjob $cronjob)
    {
        $cronjob[] = $cronjob;
    }

    public function getAllEntities($asArray = false)
    {
        return $this->repository->findAll($asArray);
    }

    private function loadLastCronjobs()
    {
        /** @var Cronjob[] $lastTimes */
        $lastTimes = $this->getAllEntities();

        foreach ($lastTimes as $cronjob) {
            if (array_key_exists($cronjob->getClassName(), $this->cronjobs))
            {
                $this->cronjobs[$cronjob->getClassName()] = $cronjob;
            }
        }
    }

    public function getAllCronjobs()
    {
        $cronjobs = array();
        $config = $this->serviceLocator->get("applicationConfig");

        foreach ($config['modules'] as $moduleName) {
            $className = $moduleName . '\Module';
            $class = new $className;
            if ($class instanceof CronjobModelInterface) {
                $cronjobs = array_merge($cronjobs, $class->getCronjobs());
            }
        }
        $cronjobs = array_unique($cronjobs);

        foreach ($cronjobs as $cronjob) {
            $cronjobName = $cronjob;
            if (substr($cronjob,0,1) == "\\")
            {
                $cronjobName = substr($cronjob,1);
            }
            $this->cronjobs[$cronjobName] = new $cronjob;
        }
        $this->loadLastCronjobs();

        return $this->cronjobs;
    }

    public function saveAll()
    {
        foreach($this->cronjobs as $cronjob)
        {
            $this->save($cronjob);
        }
    }

    public function doCronjobs()
    {
        /** @var Cronjob $cronjob */
        foreach ($this->cronjobs as $cronjob) {
            if ($cronjob->shouldRun()) {
                $cronjob->run($this->serviceLocator);
                $this->save($cronjob);
            }
        }
    }
} 