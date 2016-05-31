<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\RearWheelRepository")
 * @ORM\Table(name="RearWheel")
 */
class RearWheel extends Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /** @var  integer 
     * @ORM\Column(type="integer")*/
    protected $wheelSize;

    /** @var  boolean
     * @ORM\Column(type="boolean")*/
    protected $backPedalBrake;

    /** @var  integer
     * @ORM\Column(type="integer")*/
    protected $gears;
    


    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
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
     * @return int
     */
    public function getWheelSize()
    {
        return $this->wheelSize;
    }

    /**
     * @param int $wheelSize
     */
    public function setWheelSize($wheelSize)
    {
        $this->wheelSize = $wheelSize;
    }

    /**
     * @return boolean
     */
    public function isBackPedalBrake()
    {
        return $this->backPedalBrake;
    }

    /**
     * @param boolean $backPedalBrake
     */
    public function setBackPedalBrake($backPedalBrake)
    {
        $this->backPedalBrake = $backPedalBrake;
    }

    /**
     * @return int
     */
    public function getGears()
    {
        return $this->gears;
    }

    /**
     * @param int $gears
     */
    public function setGears($gears)
    {
        $this->gears = $gears;
    }
    
    
}
