<?php

namespace BikeStore\Model;

use Application\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\OrderRepository")
 * @ORM\Table(name="Order")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
	 * @var int
     */
    protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="\BikeStore\Model\OrderItem", mappedBy="order", cascade="all")
	 * @var ArrayCollection|OrderItem[]
	 */
    protected $orderItems;

	/**
	 * @ORM\Column(type="date")
	 * @var \DateTime
	 */
    protected $orderDate;

	/**
	 * @ORM\ManyToOne(targetEntity="\Application\Model\User", inversedBy="orders", cascade={"persist","refresh"})
	 * @ORM\JoinColumn(name="customerId", referencedColumnName="id")
	 * @var User
	 */
    protected $customer;

	/**
	 * @ORM\OneToOne(targetEntity="\BikeStore\Model\PaymentInfo", inversedBy="order")
	 * @ORM\JoinColumn(name="paymentInfoId", referencedColumnName="id")
	 * @var PaymentInfo
	 */
	protected $paymentInfo;

    public function __construct()
    {
        $this->id = null;
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
}
