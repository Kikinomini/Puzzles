<?php

namespace BikeStore\Model\Equipment;

use BikeStore\Model\Manager\Equipment\FrameManager;
use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;


/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\FrameRepository")
 * @ORM\Table(name="Frame")
 */
class Frame extends Equipment
{
	const RIDER_TYPE_FEMALE = 1;
	const RIDER_TYPE_MALE = 2;
	const RIDER_TYPE_CHILD = 3;

	const BIKE_TYPE_CITY = 1;
	const BIKE_TYPE_MOUNTAIN = 2;
	const BIKE_TYPE_RACER = 3;
	const BIKE_TYPE_TOURING = 4;
	const BIKE_TYPE_EBIKE = 5;

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
	protected $frameSize;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $riderType;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $bikeType;

	/**
	 * @ORM\Column(type="boolean")
	 * @var boolean
	 */
	protected $frontShocker;

	/**
	 * @ORM\Column(type="boolean")
	 * @var boolean
	 */
	protected $backShocker;

	public function __construct()
	{
		parent::__construct();
		$this->id = null;
		$this->setBikeType(self::BIKE_TYPE_CITY);
		$this->setRiderType(self::RIDER_TYPE_MALE);
		$this->setFrameSize(-37);
		$this->setBackShocker(true);
		$this->setFrontShocker(true);
		$this->setListed(false);
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
	public function getFrameSize()
	{
		return $this->frameSize;
	}

	/**
	 * @param float $frameSize
	 */
	public function setFrameSize($frameSize)
	{
		$this->frameSize = $frameSize;
	}

	/**
	 * @return int
	 */
	public function getRiderType()
	{
		return $this->riderType;
	}

	/**
	 * @param int $riderType
	 */
	public function setRiderType($riderType)
	{
		$this->riderType = $riderType;
	}

	/**
	 * @return int
	 */
	public function getBikeType()
	{
		return $this->bikeType;
	}

	/**
	 * @param int $bikeType
	 */
	public function setBikeType($bikeType)
	{
		$this->bikeType = $bikeType;
	}

	/**
	 * @return boolean
	 */
	public function isFrontShocker()
	{
		return $this->frontShocker;
	}

	/**
	 * @param boolean $frontShocker
	 */
	public function setFrontShocker($frontShocker)
	{
		$this->frontShocker = $frontShocker;
	}

	/**
	 * @return boolean
	 */
	public function isBackShocker()
	{
		return $this->backShocker;
	}

	/**
	 * @param boolean $backShocker
	 */
	public function setBackShocker($backShocker)
	{
		$this->backShocker = $backShocker;
	}

	public function getViewInformationAsArray()
	{
		$array = parent::getViewInformationAsArray();
		$array["Rahmengröße"] = $this->frameSize . "\"";
		$array["Typ"] = FrameManager::resolveBikeType($this->bikeType);
		$array["Kategorie"] = FrameManager::resolveRiderType($this->riderType);
		$array["Stoßdämpfer"] = ($this->frontShocker &&
								 $this->backShocker) ? "Vorne und hinten" : ($this->frontShocker) ? "Vorne" : ($this->backShocker) ? "Hinten" : "Keine";
		return $array;
	}
}
