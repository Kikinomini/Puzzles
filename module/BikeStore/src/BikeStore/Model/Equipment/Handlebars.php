<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\HandlebarsRepository")
 * @ORM\Table(name="Handlebars")
 */
class Handlebars extends Equipment
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
    protected $diameter;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $length;

    public function __construct()
    {
    	parent::__construct();
        $this->id = null;
        $this->diameter = -1;
		$this->length = -1;
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
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * @param float $diameter
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }
}
