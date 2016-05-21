<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 27.01.15
 * Time: 20:16
 */

namespace Application\Model;


use Doctrine\ORM\Mapping as ORM;


/** @ORM\Entity(repositoryClass="\Application\Model\Repository\ResourceRepository")
 * @ORM\Table(name="Resource")
 */
class Resource {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=75, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $beschreibung;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * @param mixed $beschreibung
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }


}