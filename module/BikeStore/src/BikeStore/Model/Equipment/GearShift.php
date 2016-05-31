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

    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
        $this->numberFrontGears = -1;
        $this->numberBackGears = -1;
        $this->type = self::GEAR_SHIFT_TYPE_CHAIN;
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
    public function getNumberFrontGears()
    {
        return $this->numberFrontGears;
    }

    /**
     * @param int $numberFrontGears
     */
    public function setNumberFrontGears($numberFrontGears)
    {
        $this->numberFrontGears = $numberFrontGears;
    }

    /**
     * @return int
     */
    public function getNumberBackGears()
    {
        return $this->numberBackGears;
    }

    /**
     * @param int $numberBackGears
     */
    public function setNumberBackGears($numberBackGears)
    {
        $this->numberBackGears = $numberBackGears;
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
}
