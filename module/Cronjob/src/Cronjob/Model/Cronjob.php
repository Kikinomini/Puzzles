<?php

namespace Cronjob\Model;

use Doctrine\ORM\Mapping as ORM;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @ORM\Entity(repositoryClass="\Cronjob\Model\Repository\CronjobRepository")
 * @ORM\MappedSuperclass
 * @ORM\Table(name="Cronjob")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
abstract class Cronjob
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $intervalInMinutes;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $lastRun;

    /**
     * @ORM\Column(type="text")
     */
    protected $className;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     * @var \DateTime
     */
    protected  $lastSuccess;

    /**
     * @ORM\Column(type="text")
     */
    protected $errorMessage;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;


    public function __construct()
    {
        $this->lastRun = \DateTime::createFromFormat("Y-m-d", "0000-00-00");
        $this->lastSuccess = \DateTime::createFromFormat("Y-m-d", "0000-00-00");
        $this->intervalInMinutes = 5;
        $this->errorMessage = "";
        $this->active = true;
    }

    public function getSuccess()
    {
        return ($this->lastSuccess == $this->lastRun );
    }

    public function run(ServiceLocatorInterface $serviceLocator)
    {
        $this->lastRun = new \DateTime(); //damit doctrine ein anderes Datetime objekt erhält und speichert

        $result = $this->doCronjob($serviceLocator);
        $result = ($result === null || $result == true);

        if ($result)
        {
            $this->lastSuccess = new \DateTime(); //damit doctrine ein anderes Datetime objekt erhält und speichert
            $this->lastSuccess->setTimestamp($this->lastRun->getTimestamp());
        }
        return $result;
    }


    /**
     * @param ServiceLocatorInterface $serviceLocatorInterface
     * @return boolean
     */
    abstract protected function doCronjob(ServiceLocatorInterface $serviceLocatorInterface);

    public function shouldRun()
    {
        $now = new \DateTime();
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($this->lastRun->getTimestamp());
        $dateTime->add(new \DateInterval("PT".$this->intervalInMinutes."M"));

        return ($now >= $dateTime);
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIntervalInMinutes()
    {
        return $this->intervalInMinutes;
    }

    /**
     * @param mixed $interval
     */
    public function setIntervalInMinutes($interval)
    {
        $this->intervalInMinutes = $interval;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return \DateTime
     */
    public function getLastRun()
    {
        return $this->lastRun;
    }

    /**
     * @param mixed $lastRun
     */
    public function setLastRun($lastRun)
    {
        $this->lastRun = $lastRun;
    }

    /**
     * @return \DateTime
     */
    public function getLastSuccess()
    {
        return $this->lastSuccess;
    }

    /**
     * @param mixed $lastSuccess
     */
    public function setLastSuccess($lastSuccess)
    {
        $this->lastSuccess = $lastSuccess;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
} 