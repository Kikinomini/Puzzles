<?php

namespace BikeStore\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\OrderItemRepository")
 * @ORM\Table(name="OrderItem")
 */
class OrderItem
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="\BikeStore\Model\Order", inversedBy="orderItems", cascade={"persist","refresh"})
	 * @ORM\JoinColumn(name="orderId", referencedColumnName="id")
	 */
	protected $order;

	/**
	 * @ORM\ManyToOne(targetEntity="\BikeStore\Model\Article", inversedBy="orderItems", cascade={"persist","refresh"})
	 * @ORM\JoinColumn(name="articleId", referencedColumnName="id")
	 */
	protected $article;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $numberArticles;

	/**
	 * @ORM\Column(type="float")
	 * @var float
	 */
	protected $singlePrice;

	public function __construct()
	{
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
