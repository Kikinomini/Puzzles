<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\LightRepository")
 * @ORM\Table(name="Light")
 */
class Light extends Equipment
{
    const LIGHT_TYPE_LED = 1;
    const LIGHT_TYPE_HALOGEN = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isBatteriePowered;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return boolean
     */
    public function isIsBatteriePowered()
    {
        return $this->isBatteriePowered;
    }

    /**
     * @param boolean $isBatteriePowered
     */
    public function setIsBatteriePowered($isBatteriePowered)
    {
        $this->isBatteriePowered = $isBatteriePowered;
    }
    
    
}
 
