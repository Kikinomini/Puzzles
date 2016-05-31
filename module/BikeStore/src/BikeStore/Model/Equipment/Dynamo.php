<?php

namespace BikeStore\Model\Equipment;

use Doctrine\ORM\Mapping as ORM;
use BikeStore\Model\Equipment;

/**
 * @ORM\Entity(repositoryClass="\BikeStore\Model\Repository\Equipment\DynamoRepository")
 * @ORM\Table(name="Dynamo")
 */
class Dynamo extends Equipment
{
    const DYNAMO_TYPE_EXTERNAL = 1;
    const DYNAMO_TYPE_SPOKE = 2;
    const DYNAMO_TYPE_HUB = 3;

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

    public function __construct()
    {
    	parent::__construct();
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
}
 
