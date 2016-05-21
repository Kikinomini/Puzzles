<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 06.07.2015
 * Time: 22:24
 */

namespace Portal\Form\Hydrator;

use Application\Model\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ChangePasswordHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        return array();
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  User $user
     * @return User
     */
    public function hydrate(array $data, $user)
    {
        $user->setPassword($data["password1"]);

        return $user;
    }
} 