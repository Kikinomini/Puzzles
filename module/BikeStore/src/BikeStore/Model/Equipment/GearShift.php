<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\GearShiftRepository")
 * @ORM\Table(name="GearShift")
 */
class GearShift extends Equipment
{
    const GEAR_SHIFT_TYPE_HUB = 1;
    const GEAR_SHIFT_TYPE_CHAIN = 2;

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
    protected $numberFrontGears;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $numberBackGears;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $hasBackpedalBrake;


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
}
