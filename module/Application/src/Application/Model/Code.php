<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 31.01.15
 * Time: 12:12
 */

namespace Application\Model;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Application\Model\Repository\CodeRepository")
 * @ORM\Table(name="Code")
 */
class Code
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/** @ORM\Column(type="string", unique=true) */
	protected $code;

	/** @ORM\Column(type="string") */
	protected $action;

	/** @ORM\Column(type="string") */
	protected $wert;

	/** @ORM\Column(type="datetime") */
	protected $erstelldatum;

	/**
	 * @ORM\ManyToOne(targetEntity="\Application\Model\User", inversedBy="codes")
	 * @ORM\JoinColumn(name="userId", referencedColumnName="id")
	 */
	protected $user;

	function __construct()
	{
		$this->erstelldatum = new \DateTime();
        $this->wert = '';
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
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param mixed $code
	 */
	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * @return mixed
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @param mixed $action
	 */
	public function setAction($action)
	{
		$this->action = $action;
	}

	/**
	 * @return mixed
	 */
	public function getWert()
	{
		return $this->wert;
	}

	/**
	 * @param mixed $wert
	 */
	public function setWert($wert)
	{
		$this->wert = $wert;
	}

	/**
	 * @return mixed
	 */
	public function getErstelldatum()
	{
		return $this->erstelldatum;
	}

	/**
	 * @param mixed $erstelldatum
	 */
	public function setErstelldatum($erstelldatum)
	{
		$this->erstelldatum = $erstelldatum;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}
}
