<?php

namespace BikeStore\Model\Equipment;

use BikeStore\Model\Manager\Equipment\BrakeManager;
use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\BrakeRepository")
 * @ORM\Table(name="Brake")
 */
class Brake extends Equipment
{
    const BRAKE_TYPE_BLOCK = 1;
    const BRAKE_TYPE_DISC = 2;
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
    protected $brakeType;

    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
        $this->brakeType = self::BRAKE_TYPE_BLOCK;
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
    public function getBrakeType()
    {
        return $this->brakeType;
    }

    /**
     * @param int $brakeType
     */
    public function setBrakeType($brakeType)
    {
        $this->brakeType = $brakeType;
    }

    public function getViewInformationAsArray()
    {
        $array = parent::getViewInformationAsArray();
        $array["Bremsart"] = BrakeManager::resolveBrakeType($this->brakeType);
        return $array;
    }
}
