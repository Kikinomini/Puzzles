<?php

namespace Application\Model;

use BikeStore\Model\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity(repositoryClass="\Application\Model\Repository\UserRepository")
 * @ORM\Table(name="User")
 */
class User
{
	const USERNAME_ALLOWED_REGEX = "[a-zA-Z0-9\-_.&;()#!?$^~+]{1,255}$";

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/** @ORM\Column(type="string", unique=true) */
	protected $username;

	/** @ORM\Column(type="string", length = 128) */
	protected $password;

	/** @ORM\Column(type="string", unique=true) */
	protected $email;

	/** @ORM\Column(type="string") */
	protected $vorname;

	/** @ORM\Column(type="string") */
	protected $nachname;

	/** @ORM\Column(type="date") */
	protected $geburtsdatum;

	/** @ORM\Column(type="boolean") */
	protected $aktiviert;

	/** @ORM\Column(type="boolean") */
	protected $blockiert;

	/** @ORM\OneToMany(targetEntity="\Application\Model\Code", mappedBy="user", cascade="all") */
	protected $codes;

	/**
	 * @ORM\OneToMany(targetEntity="\BikeStore\Model\Order", mappedBy="customer", cascade="all")
	 * @var ArrayCollection|Order[]
	 */
	protected $orders;

	/**
	 * @ORM\ManyToMany(targetEntity="\Application\Model\Resource", cascade="all")
	 * @ORM\JoinTable(name="UserResource",
	 *      joinColumns={@ORM\JoinColumn(name="UserId", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="ResourceId", referencedColumnName="id")})
	 */
	protected $resources;

	/**
	 * @ORM\ManyToMany(targetEntity="\Application\Model\Role", cascade="all", mappedBy="users")
	 * @ORM\JoinTable(name="RoleUser",
	 *      joinColumns={@ORM\JoinColumn(name="UserId", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="RoleId", referencedColumnName="id")})
	 */
	protected $roles;

	protected $online;



	function __construct()
	{
		$this->codes = new ArrayCollection();
		$this->resources = new ArrayCollection();
		$this->roles = new ArrayCollection();
		$this->online = false;
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
	 * @return mixed
	 */
	public function getVorname()
	{
		return $this->vorname;
	}

	/**
	 * @param mixed $vorname
	 */
	public function setVorname($vorname)
	{
		$this->vorname = $vorname;
	}

	/**
	 * @return mixed
	 */
	public function getNachname()
	{
		return $this->nachname;
	}

	/**
	 * @param mixed $nachname
	 */
	public function setNachname($nachname)
	{
		$this->nachname = $nachname;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = strtolower($email);
	}

	/**
	 * @return mixed
	 */
	public function getGeburtsdatum()
	{
		return $this->geburtsdatum;
	}

	/**
	 * @param mixed $geburtsdatum
	 */
	public function setGeburtsdatum($geburtsdatum)
	{
		$this->geburtsdatum = $geburtsdatum;
	}

	/**
	 * @return mixed
	 */
	public function getOnline()
	{
		return $this->online;
	}

	/**
	 * @param mixed $online
	 */
	public function setOnline($online)
	{
		$this->online = $online;
	}

	/**
	 * @return mixed
	 */
	public function getAktiviert()
	{
		return $this->aktiviert;
	}

	/**
	 * @param mixed $aktiviert
	 */
	public function setAktiviert($aktiviert)
	{
		$this->aktiviert = $aktiviert;
	}

	/**
	 * @return mixed
	 */
	public function getBlockiert()
	{
		return $this->blockiert;
	}

	/**
	 * @param mixed $blockiert
	 */
	public function setBlockiert($blockiert)
	{
		$this->blockiert = $blockiert;
	}

	/**
	 * @return mixed
	 */
	public function getCodes()
	{
		return $this->codes;
	}

	/**
	 * @param mixed $codes
	 */
	public function setCodes($codes)
	{
		$this->codes = $codes;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getResources()
	{
		return $this->resources;
	}

	/**
	 * @param mixed $resources
	 */
	public function setResources($resources)
	{
		$this->resources = $resources;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getRoles()
	{
		return $this->roles;
	}

	/**
	 * @param mixed $roles
	 */
	public function setRoles($roles)
	{
		$this->roles = $roles;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return \BikeStore\Model\Order[]|ArrayCollection
	 */
	public function getOrders()
	{
		return $this->orders;
	}

	/**
	 * @param \BikeStore\Model\Order[]|ArrayCollection $orders
	 */
	public function setOrders($orders)
	{
		$this->orders = $orders;
	}
}
