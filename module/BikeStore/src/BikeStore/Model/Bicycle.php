<?php

namespace BikeStore\Model;

use BikeStore\Model\Equipment\Bell;
use BikeStore\Model\Equipment\Brake;
use BikeStore\Model\Equipment\Coat;
use BikeStore\Model\Equipment\Dynamo;
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

	/** @var  string */
	protected $colour;

    /** @var   Saddle
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
     * @ORM\JoinColumn(name="HandlebarsId", referencedColumnName="id") */
    protected $handlebars;

    /** @var  Bell
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Bell")
     * @ORM\JoinColumn(name="BellId", referencedColumnName="id")*/
    protected $bell;

    /** @var  Brake
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Brake")
     * @ORM\JoinColumn(name="BrakeId", referencedColumnName="id")*/
    protected $brake;

    /** @var  Coat
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Coat")
     * @ORM\JoinColumn(name="CoatId", referencedColumnName="id")*/
    protected $coat;

    /** @var  Dynamo
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Dynamo")
     * @ORM\JoinColumn(name="DynamoId", referencedColumnName="id")*/
    protected $dynamo;

    /** @var  FrontWheel
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\FrontWheel")
     * @ORM\JoinColumn(name="FrontWheelId", referencedColumnName="id")*/
    protected $frontWheel;

    /** @var  GearShift
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\GearShift")
     * @ORM\JoinColumn(name="GearShiftId", referencedColumnName="id")*/
    protected $gearShift;

    /** @var  Light
    @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Light")
     * @ORM\JoinColumn(name="LightId", referencedColumnName="id")*/
    protected $light;

    /** @var  MudGuard
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\MudGuard")
     * @ORM\JoinColumn(name="MudGuardId", referencedColumnName="id",nullable=true)*/
    protected $mudGuard;

    /** @var  PannierRack
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\PannierRack")
     * @ORM\JoinColumn(name="PannierRackId", referencedColumnName="id")*/
    protected $pannierRack; //Boolean

    /** @var  Pedal
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Pedal")
     * @ORM\JoinColumn(name="PedalId", referencedColumnName="id")*/
    protected $pedal;

    /** @var  RearWheel
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\RearWheel")
     * @ORM\JoinColumn(name="RearWheelId", referencedColumnName="id")*/
    protected $rearWheel;

    /** @var  Tube
     * @ORM\ManyToOne(targetEntity="BikeStore\Model\Equipment\Tube")
     * @ORM\JoinColumn(name="TubeId", referencedColumnName="id")*/
    protected $tube;



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
