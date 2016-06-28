<?php

namespace BikeStore\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BikeStore\Model\Repository\ArticleRepository")
 * @ORM\Table(name="Article")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({})
 */

class Article
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
	protected $name;

	/**
	 * @ORM\Column(type="float")
	 * @var float
	 */
    protected $price;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $quickDescription;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    protected $description;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
    protected $imageName;

	/**
	 * @ORM\Column(type="boolean")
	 * @var boolean
	 */
    protected $listed;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	protected $colour;


	public function __construct()
    {
        $this->id = null;
		$this->setListed(true);
		$this->setImageName("article.png");
		$this->setDescription("this is undefined");
		$this->setPrice(0.00);
		$this->setName("undefined");
		$this->setQuickDescription("undef");
		$this->setColour("undefined");
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
    
    public function getDetailViewPath()
    {
        return "/bike-store/bicycle/detail-list";
    }

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}
	
	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getImageName()
	{
		return $this->imageName;
	}

	/**
	 * @param string $imageName
	 */
	public function setImageName($imageName)
	{
		$this->imageName = $imageName;
	}

	/**
	 * @return mixed
	 */
	public function getListed()
	{
		return $this->listed;
	}

	/**
	 * @param mixed $listed
	 */
	public function setListed($listed)
	{
		$this->listed = $listed;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getQuickDescription()
	{
		return $this->quickDescription;
	}

	/**
	 * @param string $quickDescription
	 */
	public function setQuickDescription($quickDescription)
	{
		$this->quickDescription = $quickDescription;
	}

	public function getViewInformationAsArray()
	{
		return array(
			"Name" => $this->name,
			"Farbe" => $this->colour,
		);
	}
}
