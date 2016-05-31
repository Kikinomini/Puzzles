<?php

namespace BikeStore\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\EquipmentRepository")
 * @ORM\Table(name="Equipment")
 */
class Equipment extends Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $colour;

    public function __construct()
    {
        parent::__construct();
        $this->id = null;
		$this->colour = "schwarz";
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
	 * @return string
	 */
	public function getColour()
	{
		return $this->colour;
	}

	/**
	 * @param string $colour
	 */
	public function setColour($colour)
	{
		$this->colour = $colour;
	}
}
