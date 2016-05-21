<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 29.01.15
 * Time: 20:29
 */

namespace Portal\Form\Hydrator;


use Application\Model\User;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserHydrator implements HydratorInterface
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
		$geburtsdatum = \DateTime::createFromFormat("d.m.Y", $data["geburtsdatum"]);

		$user->setEmail($data["email"]);
		$user->setGeburtsdatum($geburtsdatum);
		$user->setVorname($data["vorname"]);
		$user->setNachname($data["nachname"]);
		$user->setUsername($data["username"]);

		return $user;
	}

}