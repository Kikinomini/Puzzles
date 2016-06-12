<?php

namespace BikeStore\Model;

use BikeStore\Model\Equipment\Battery;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\EBikeRepository")
 * @ORM\Table(name="EBike")
 */
class EBike extends Bicycle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Battery
     * @ORM\ManyToOne(targetEntity="\BikeStore\Model\Equipment\Battery")
     * @ORM\JoinColumn(name="BatteryId", referencedColumnName="id")
     */
    protected $battery;

    public function __construct()
    {
        parent::__construct();
        $this->id = null;
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
     * @return Battery
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * @param Battery $battery
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;
    }
}
