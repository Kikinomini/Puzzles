<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 20.03.2016
 * Time: 18:28
 */

namespace Application\Form\Hydrator;

use Application\Model\Code;
use Application\Model\Manager\CodeManager;
use Application\Model\Manager\UserManager;
use Application\Model\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AccountSettingsHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  User $user
     * @return array
     */
    public function extract($user)
    {
        $newEmailAddress = "";
        $codes = $user->getCodes();
        /** @var Code $code */
        foreach ($codes as $code)
        {
            if ($code->getAction() == CodeManager::ACTION_VERIFY_NEW_EMAIL)
            {
                $newEmailAddress = $code->getWert();
                break;
            }
        }
        return array(
            "username" => $user->getUsername(),
            'firstName' => $user->getVorname(),
            'lastName' => $user->getNachname(),
            'actualEmailAddress' => $user->getEmail(),
            'newEmailAddress' => $newEmailAddress,
        );
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
        $user->setUsername($data["username"]);
        $user->setVorname($data["firstName"]);
        $user->setNachname($data["lastName"]);

        return $user;
    }
} 