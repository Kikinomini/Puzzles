<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\BatteryRepository")
 * @ORM\Table(name="Battery")
 */
class Battery extends Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $chargingTime;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $batteryTime;

    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
		$this->chargingTime = -1;
		$this->batteryTime = -1;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
	 * @return float
	 */
	public function getChargingTime()
	{
		return $this->chargingTime;
	}

	/**
	 * @param float $chargingTime
	 */
	public function setChargingTime($chargingTime)
	{
		$this->chargingTime = $chargingTime;
	}

	/**
	 * @return float
	 */
	public function getBatteryTime()
	{
		return $this->batteryTime;
	}

	/**
	 * @param float $batteryTime
	 */
	public function setBatteryTime($batteryTime)
	{
		$this->batteryTime = $batteryTime;
	}

	public function getViewInformationAsArray()
	{
		$array = parent::getViewInformationAsArray();
		$array["Nutzzeit"] = str_replace(".",",",round($this->batteryTime, 2)). " Stunden";
		$array["Ladezeit"] = str_replace(".",",",round($this->chargingTime, 2)). " Stunden";
		return $array;
	}
}
