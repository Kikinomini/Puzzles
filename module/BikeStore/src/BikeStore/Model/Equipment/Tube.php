<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\TubeRepository")
 * @ORM\Table(name="Tube")
 */
class Tube extends Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @return float
     */


    /** @var  float
     * @ORM\Column(type="float")*/
    protected $wheelSize;

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

    public function getWheelSize()
    {
        return $this->wheelSize;
    }

    /**
     * @param float $wheelSize
     */
    public function setWheelSize($wheelSize)
    {
        $this->wheelSize = $wheelSize;
    }
}
