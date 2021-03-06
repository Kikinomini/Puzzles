<?php

namespace BikeStore\Model;

use BikeStore\Model\Equipment\Bell;
use BikeStore\Model\Equipment\Brake;
use BikeStore\Model\Equipment\Coat;
use BikeStore\Model\Equipment\Dynamo;
use BikeStore\Model\Equipment\Frame;
use BikeStore\Model\Equipment\FrontWheel;
use BikeStore\Model\Equipment\GearShift;
use BikeStore\Model\Equipment\Handlebars;
use BikeStore\Model\Equipment\Light;
use BikeStore\Model\Equipment\MudGuard;
use BikeStore\Model\Equipment\PannierRack;
use BikeStore\Model\Equipment\Pedal;
use BikeStore\Model\Equipment\RearWheel;
use BikeStore\Model\Equipment\Saddle;
use BikeStore\Model\Equipment\SaddleBar;
use BikeStore\Model\Equipment\Tube;
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
	

	/** @var Saddle
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Saddle")
	 * @ORM\JoinColumn(name="SaddleId", referencedColumnName="id")
	 */
	protected $saddle;

	/** @var  SaddleBar
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\SaddleBar")
	 * @ORM\JoinColumn(name="SaddleBarId", referencedColumnName="id")
	 */
	protected $saddleBar;

	/** @var  Handlebars
	 * @ORM\ManyToOne(targetEntity="\BikeStore\Model\Equipment\Handlebars")
	 * @ORM\JoinColumn(name="HandlebarsId", referencedColumnName="id")
	 */
	protected $handlebars;

	/** @var  Bell
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Bell")
	 * @ORM\JoinColumn(name="BellId", referencedColumnName="id",nullable=true)
	 */
	protected $bell;

	/** @var  Brake
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Brake")
	 * @ORM\JoinColumn(name="FrontBrakeId", referencedColumnName="id")
	 */
	protected $frontBrake;

	/** @var  Brake
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Brake")
	 * @ORM\JoinColumn(name="RearBrakeId", referencedColumnName="id")
	 */
	protected $rearBrake;

	/** @var  Coat
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Coat")
	 * @ORM\JoinColumn(name="FrontCoat", referencedColumnName="id")
	 */
	protected $frontCoat;

	/** @var  Coat
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Coat")
	 * @ORM\JoinColumn(name="RearCoat", referencedColumnName="id")
	 */
	protected $rearCoat;

	/** @var  Dynamo
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Dynamo")
	 * @ORM\JoinColumn(name="DynamoId", referencedColumnName="id",nullable=true)
	 */
	protected $dynamo;

	/** @var  FrontWheel
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\FrontWheel")
	 * @ORM\JoinColumn(name="FrontWheelId", referencedColumnName="id")
	 */
	protected $frontWheel;

	/** @var  GearShift
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\GearShift")
	 * @ORM\JoinColumn(name="GearShiftId", referencedColumnName="id")
	 */
	protected $gearShift;

	/** @var  Light
	@ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Light")
	 * @ORM\JoinColumn(name="LightId", referencedColumnName="id",nullable=true)
	 */
	protected $light;

	/** @var  MudGuard
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\MudGuard")
	 * @ORM\JoinColumn(name="MudGuardId", referencedColumnName="id",nullable=true)
	 */
	protected $mudGuard;

	/** @var  PannierRack
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\PannierRack")
	 * @ORM\JoinColumn(name="PannierRackId", referencedColumnName="id",nullable=true)
	 */
	protected $pannierRack;

	/** @var  Pedal
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Pedal")
	 * @ORM\JoinColumn(name="PedalId", referencedColumnName="id")
	 */
	protected $pedal;

	/** @var  RearWheel
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\RearWheel")
	 * @ORM\JoinColumn(name="RearWheelId", referencedColumnName="id")
	 */
	protected $rearWheel;

	/** @var  Tube
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Tube")
	 * @ORM\JoinColumn(name="FrontTubeId", referencedColumnName="id")
	 */
	protected $frontTube;

	/** @var  Tube
	 * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Tube")
	 * @ORM\JoinColumn(name="RearTubeId", referencedColumnName="id")
	 */
	protected $rearTube;

	/**
	 * @var  Frame
	 * @ORM\ManyToOne(targetEntity="\BikeStore\Model\Equipment\Frame")
	 * @ORM\JoinColumn(name="FrameId", referencedColumnName="id")
	 */
	protected $frame;


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

	/**
	 * @return Saddle
	 */
	public function getSaddle()
	{
		return $this->saddle;
	}

	/**
	 * @param Saddle $saddle
	 */
	public function setSaddle($saddle)
	{
		$this->saddle = $saddle;
	}

	/**
	 * @return SaddleBar
	 */
	public function getSaddleBar()
	{
		return $this->saddleBar;
	}

	/**
	 * @param SaddleBar $saddleBar
	 */
	public function setSaddleBar($saddleBar)
	{
		$this->saddleBar = $saddleBar;
	}

	/**
	 * @return Handlebars
	 */
	public function getHandlebars()
	{
		return $this->handlebars;
	}

	/**
	 * @param Handlebars $handlebars
	 */
	public function setHandlebars($handlebars)
	{
		$this->handlebars = $handlebars;
	}

	/**
	 * @return Bell
	 */
	public function getBell()
	{
		return $this->bell;
	}

	/**
	 * @param Bell $bell
	 */
	public function setBell($bell)
	{
		$this->bell = $bell;
	}

	/**
	 * @return Dynamo
	 */
	public function getDynamo()
	{
		return $this->dynamo;
	}

	/**
	 * @param Dynamo $dynamo
	 */
	public function setDynamo($dynamo)
	{
		$this->dynamo = $dynamo;
	}

	/**
	 * @return FrontWheel
	 */
	public function getFrontWheel()
	{
		return $this->frontWheel;
	}

	/**
	 * @param FrontWheel $frontWheel
	 */
	public function setFrontWheel($frontWheel)
	{
		$this->frontWheel = $frontWheel;
	}

	/**
	 * @return GearShift
	 */
	public function getGearShift()
	{
		return $this->gearShift;
	}

	/**
	 * @param GearShift $gearShift
	 */
	public function setGearShift($gearShift)
	{
		$this->gearShift = $gearShift;
	}

	/**
	 * @return Light
	 */
	public function getLight()
	{
		return $this->light;
	}

	/**
	 * @param Light $light
	 */
	public function setLight($light)
	{
		$this->light = $light;
	}

	/**
	 * @return MudGuard
	 */
	public function getMudGuard()
	{
		return $this->mudGuard;
	}

	/**
	 * @param MudGuard $mudGuard
	 */
	public function setMudGuard($mudGuard)
	{
		$this->mudGuard = $mudGuard;
	}

	/**
	 * @return PannierRack
	 */
	public function getPannierRack()
	{
		return $this->pannierRack;
	}

	/**
	 * @param PannierRack $pannierRack
	 */
	public function setPannierRack($pannierRack)
	{
		$this->pannierRack = $pannierRack;
	}

	/**
	 * @return Pedal
	 */
	public function getPedal()
	{
		return $this->pedal;
	}

	/**
	 * @param Pedal $pedal
	 */
	public function setPedal($pedal)
	{
		$this->pedal = $pedal;
	}

	/**
	 * @return RearWheel
	 */
	public function getRearWheel()
	{
		return $this->rearWheel;
	}

	/**
	 * @param RearWheel $rearWheel
	 */
	public function setRearWheel($rearWheel)
	{
		$this->rearWheel = $rearWheel;
	}
	
	/**
	 * @return Frame
	 */
	public function getFrame()
	{
		return $this->frame;
	}

	/**
	 * @param Frame $frame
	 */
	public function setFrame($frame)
	{
		$this->frame = $frame;
	}

    public function getDetailViewPath()
    {
        return "/bike-store/bicycle/bike-product-info";
    }

	/**
	 * @return Brake
	 */
	public function getFrontBrake()
	{
		return $this->frontBrake;
	}

	/**
	 * @param Brake $frontBrake
	 */
	public function setFrontBrake($frontBrake)
	{
		$this->frontBrake = $frontBrake;
	}

	/**
	 * @return Brake
	 */
	public function getRearBrake()
	{
		return $this->rearBrake;
	}

	/**
	 * @param Brake $rearBrake
	 */
	public function setRearBrake($rearBrake)
	{
		$this->rearBrake = $rearBrake;
	}

	/**
	 * @return Coat
	 */
	public function getFrontCoat()
	{
		return $this->frontCoat;
	}

	/**
	 * @param Coat $frontCoat
	 */
	public function setFrontCoat($frontCoat)
	{
		$this->frontCoat = $frontCoat;
	}

	/**
	 * @return Coat
	 */
	public function getRearCoat()
	{
		return $this->rearCoat;
	}

	/**
	 * @param Coat $rearCoat
	 */
	public function setRearCoat($rearCoat)
	{
		$this->rearCoat = $rearCoat;
	}

	/**
	 * @return Tube
	 */
	public function getFrontTube()
	{
		return $this->frontTube;
	}

	/**
	 * @param Tube $frontTube
	 */
	public function setFrontTube($frontTube)
	{
		$this->frontTube = $frontTube;
	}

	/**
	 * @return Tube
	 */
	public function getRearTube()
	{
		return $this->rearTube;
	}

	/**
	 * @param Tube $rearTube
	 */
	public function setRearTube($rearTube)
	{
		$this->rearTube = $rearTube;
	}
}
