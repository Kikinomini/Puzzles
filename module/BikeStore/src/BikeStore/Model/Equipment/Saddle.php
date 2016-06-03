<?php

namespace BikeStore\Model\Equipment;

use BikeStore\Model\Equipment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\SaddleRepository")
 * @ORM\Table(name="Saddle")
 */
class Saddle extends Equipment
{
    const SADDLE_TYPE_SPORTS = 1;
    const SADDLE_TYPE_CLASSIC = 2;

	const SADDLE_MATERIAL_CARBON = 1;
	const SADDLE_MATERIAL_LEATHER = 2;
	const SADDLE_MATERIAL_LEATHERRETTE = 3;

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
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $material;

    public function __construct()
    {
		parent::__construct();
        $this->id = null;
		$this->type = self::SADDLE_TYPE_CLASSIC;
		$this->material = self::SADDLE_MATERIAL_LEATHERRETTE;
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
	 * @return int
	 */
	public function getMaterial()
	{
		return $this->material;
	}

	/**
	 * @param int $material
	 */
	public function setMaterial($material)
	{
		$this->material = $material;
	}
}
