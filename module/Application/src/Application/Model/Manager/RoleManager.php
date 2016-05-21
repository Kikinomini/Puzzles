<?php

namespace Application\Model\Manager;

use Application\Model\Manager\StandardManager;
use Application\Model\Repository\RoleRepository;
use Application\Model\Resource;
use Application\Model\Role;
use Application\Model\User;

class RoleManager extends StandardManager
{
    public function __construct(RoleRepository $repository, Role $entity = null)
    {
        parent::__construct($repository, $entity);
    }

    public function getByName($name)
    {
        $this->entity = $this->repository->findOneBy(array(
            'name' => $name
        ));
        return $this->entity;
    }
    public function addUser(User $user, Role $role = null)
    {
        $role = $this->selectCorrectEntity($role);
        $role->getUsers()->add($user);
    }
    public function hasResource(Resource $resource, Role $role = NULL)
    {
        /** @var Role $role */
        $role = $this->selectCorrectEntity($role);
        if ($role->getResources()->contains($resource))
        {
            return 1;
        }

        $parents = $role->getParents();
        /** @var Role $parent */
        foreach ($parents as $parent)
        {
            if ($this->hasResource($resource, $parent) == true)
            {
                return 2;
            }
        }
        return 0;
    }
    public function getChildResourceAllowed(Resource $resource, Role $role = NULL)
    {
        /** @var Role $role */
        $role = $this->selectCorrectEntity($role);

        $roleArray = array($role->getId() => $this->hasResource($resource, $role));

        $children = $role->getChildren();
        /** @var Role $child */
        foreach ($children as $child)
        {
            $roleArray = $roleArray + $this->getChildResourceAllowed($resource, $child);
        }
         return $roleArray;
    }
}