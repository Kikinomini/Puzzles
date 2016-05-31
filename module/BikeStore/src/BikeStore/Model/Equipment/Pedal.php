<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\PedalRepository")
 * @ORM\Table(name="Pedal")
 */
class Pedal extends Equipment
{
    const PEDAL_TYPE_FLAT = 1;
    const PEDAL_TYPE_SPIKED = 2;
    const PEDAL_TYPE_CLICK = 3;
    const PEDAL_TYPE_SPIKED_CLICK = 4;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /** @var  integer 
     * @ORM\Column(type="integer")*/
    protected $pedalType;

    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
        $this->pedalType = self::PEDAL_TYPE_SPIKED;
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
    public function getPedalType()
    {
        return $this->pedalType;
    }

    /**
     * @param int $pedalType
     */
    public function setPedalType($pedalType)
    {
        $this->pedalType = $pedalType;

    }
    
}
 
