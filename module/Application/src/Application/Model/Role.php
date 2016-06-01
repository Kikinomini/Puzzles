<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 27.01.15
 * Time: 20:06
 */

namespace Application\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/** @ORM\Entity(repositoryClass="\Application\Model\Repository\RoleRepository")
 * @ORM\Table(name="Role")
 */
class Role {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
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
     * @ORM\ManyToMany(targetEntity="\Application\Model\User", cascade="all", inversedBy="roles")
     * @ORM\JoinTable(name="RoleUser",
     *      joinColumns={@ORM\JoinColumn(name="RoleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="UserId", referencedColumnName="id")})
     */
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Model\Resource", cascade="all")
     * @ORM\JoinTable(name="RoleResource",
     *      joinColumns={@ORM\JoinColumn(name="RoleId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ResourceId", referencedColumnName="id")})
     */
    protected $resources;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Model\Role", cascade="all", mappedBy="children")
     */
    protected $parents;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Model\Role", cascade="all", inversedBy="parents", indexBy="id")
     * @ORM\JoinTable(name="RoleChildren",
     *      joinColumns={@ORM\JoinColumn(name="ParentId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ChildId", referencedColumnName="id")})
     */
    protected $children;

    public function __construct()
    {
        $this->id = NULL;
        $this->users = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->name = "";
        $this->beschreibung = "";
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

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
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
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param mixed $parents
     */
    public function setParents($parents)
    {
        $this->parents = $parents;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

}