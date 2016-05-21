<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24.09.2015
 * Time: 19:12
 */

namespace Portal\Form\Hydrator;

use Application\Model\Role;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AddRoleHydrator implements HydratorInterface{
    /**
     * Extract values from an object
     *
     * @param  Role $role
     * @return array
     */
    public function extract($role)
    {
        return array(
            'name' => $role->getName(),
            'description' => $role->getBeschreibung(),
        );
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  Role $role
     * @return Role
     */
    public function hydrate(array $data, $role)
    {
        $role->setName($data["name"]);
        $role->setBeschreibung($data["description"]);
    }

} 