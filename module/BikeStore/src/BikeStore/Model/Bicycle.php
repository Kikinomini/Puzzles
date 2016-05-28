<?php

namespace BikeStore\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\BicycleRepository")
 * @ORM\Table(name="Bicycle")
 */
class Bicycle extends Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @var  string */
    protected $colour;

    /** @var   */
    protected $wheeleSize;
    protected $bikeSize;
    protected $saddleId;
    protected $pannierRack; //Boolean
    protected $frontShock; //Boolean
    protected $rearShock; //Boolean
    protected $genderType; //int
    protected $gearType;
    protected $gears; //int
    protected $bikeType;


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
}
