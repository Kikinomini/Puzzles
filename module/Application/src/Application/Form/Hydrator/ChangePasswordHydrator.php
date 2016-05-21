<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25.03.2016
 * Time: 16:12
 */

namespace Application\Form\Hydrator;


use Application\Model\Manager\UserManager;
use Application\Model\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ChangePasswordHydrator implements HydratorInterface
{
    /** @var  UserManager */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * Extract values from an object
     *
     * @param  User $object
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
     * @param  User $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $this->userManager->updatePassword($data["newPassword1"], $object);
        return $object;
    }

} 