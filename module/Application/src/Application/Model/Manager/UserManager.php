<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 16:51
 */

namespace Application\Model\Manager;


use Application\Model\Code;
use Application\Model\Repository\UserRepository;
use Application\Model\Resource;
use Application\Model\Role;
use Application\Model\User;
use Zend\Http\Header\Cookie;
use Zend\Http\Header\SetCookie;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Session\Container;

class UserManager extends StandardManager
{
	/** @var string  */
	private $passwordHash;

	/** @var CodeManager */
	private $codeManager;

	/** @var  RoleManager */
	private $roleManager;

    private $basePath;

	/** @var  Container */
	private $sessionContainer;

	/** @var Response Response */
	private $response;

	/** @var  Request */
	private $request;

	public function __construct($passwordHash, $basePath, Request $request, Response $response, CodeManager $codeManager, RoleManager $roleManager, UserRepository $repository, User $userEntity = null)
	{
		parent::__construct($repository, $userEntity);
		$this->roleManager = $roleManager;
		$this->codeManager = $codeManager;
		$this->passwordHash = $passwordHash;
		$this->basePath = $basePath;
		$this->response = $response;
		$this->request = $request;
		$this->sessionContainer = new Container("userManager");
	}

    public function updatePassword($password, User $user = NULL)
    {
        /** @var User $user */
        $user = $this->selectCorrectEntity($user);
        $user->setPassword($this->__codePassword($password));
    }

	private function __codePassword($password)
	{
		return hash('sha512', $password. $this->passwordHash);
	}

	public function save(User $user = null)
	{
		parent::save($user);
	}

	public function usernameIsFree($username)
	{
		$result = $this->repository->findBy(array(
			'username' => $username,
		));

		return empty($result);
	}

	public function emailIsFree($email)
	{
		$result = $this->repository->findBy(array(
			'email' => strtolower($email),
		));

		return empty($result);
	}

	public function addCode(Code $code, User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
		$user->getCodes()->add($code);
	}

	public function addRole(Role $role, User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
		$user->getRoles()->add($role);
	}

	public function addResource(Resource $resource, User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
		$user->getResources()->add($resource);
	}

	public function registrateUser($passwort, User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
		$user->setBlockiert(false);
		$user->setAktiviert(false);

		$code = new Code();
		$code->setAction('registration');
		$code->setUser($user);
		$code->setWert('');
		$this->codeManager->generateCode($code);

		$this->addCode($code, $user);

		$userRole = $this->roleManager->getByName("user");
		$this->addRole($userRole, $user);
		$this->roleManager->addUser($user, $userRole);

		$user->setPassword($this->__codePassword($passwort));
		$this->save($user);

		$this->codeManager->sendEmail($user, $code);
	}

    public function userForgotPassword($user = NULL)
    {
        $user = $this->selectCorrectEntity($user);

        $code = new Code();
        $code->setAction('changePassword');
        $code->setUser($user);
        $code->setWert('');
        $this->codeManager->generateCode($code);

        $this->addCode($code, $user);

        $this->save($user);

        $this->codeManager->sendEmail($user, $code);
    }

	public function getUserFromSession()
	{
		$this->entity = null;

		if ($this->sessionContainer->offsetExists("online") && $this->sessionContainer->offsetGet("online") == true && $this->sessionContainer->offsetExists("id"))
		{
			/** @var User entity */
			$this->entity = $this->repository->findOneBy(array(
				'id' => $this->sessionContainer->offsetGet("id"),
//				'aktiviert' => true,
				'blockiert' => false
			));
		}

		$cookie = $this->request->getCookie();
		if ( !($this->entity instanceof User) && $cookie && $cookie->offsetExists("email") && $cookie->offsetExists("password"))
		{
			$this->entity = $this->repository->findOneBy(array
			(
				'email' => $cookie->offsetGet("email"),
				'password' => $cookie->offsetGet("password"),
//				'aktiviert' => true,
				'blockiert' => false
			));
		}

		if ($this->entity instanceof User)
		{
			$this->entity->setOnline(true);
			return $this->entity;
		}
		return null;
	}

    public function checkPassword($password, User $user = null)
    {
        /** @var User $user */
        $user = $this->selectCorrectEntity($user);
        return  ($user->getPassword() == $this->__codePassword($password));
    }

	public function login($passwort, $autoLogin, User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
		if (
//			$user->getAktiviert() &&
			!$user->getBlockiert() &&
			$user->getPassword() == $this->__codePassword($passwort)
		)
		{
			$user->setOnline(true);
			$this->sessionContainer->offsetSet("id", $user->getId());
			$this->sessionContainer->offsetSet("online", true);

			if ($autoLogin)
			{
				$emailCookie = new SetCookie(
					"email",
					$user->getEmail(),
					time() + 60 * 60 * 24 * 30,
					null,
					null,
					false,
					true
				);
				$passwordCookie = new SetCookie(
					"password",
					$user->getPassword(),
					time() + 60 * 60 * 24 * 30,
					null,
					null,
					false,
					true
				);
				$this->response->getHeaders()->addHeader($emailCookie);
				$this->response->getHeaders()->addHeader($passwordCookie);
			}
			else
			{
				$emailCookie = new SetCookie(
					"email",
					"",
					0,
					null,
					null,
					false,
					true
				);
				$passwordCookie = new SetCookie(
					"password",
					"",
					0,
					null,
					null,
					false,
					true
				);
				$this->response->getHeaders()->addHeader($emailCookie);
				$this->response->getHeaders()->addHeader($passwordCookie);
			}
			return true;
		}

		$this->logout($user);
		return false;
	}
	public function logout(User $user = null)
	{
		/** @var User $user */
		$user = $this->selectCorrectEntity($user);
        if ($user instanceof User) {
            $user->setOnline(false);
        }
		$this->sessionContainer->offsetUnset("id");
		$this->sessionContainer->offsetSet("online", false);

		$emailCookie = new SetCookie(
			"email",
			"",
			0,
			null,
			null,
			false,
			true
		);
		$passwordCookie = new SetCookie(
			"password",
			"",
			0,
			null,
			null,
			false,
			true
		);
		$this->response->getHeaders()->addHeader($emailCookie);
		$this->response->getHeaders()->addHeader($passwordCookie);
		return true;
	}
	public function getUserByEmail($email)
	{
		$this->entity = $this->repository->findOneBy(array('email' => $email));
		return $this->entity;
	}

    /**
     * @param Role|string $role
     * @return array
     */
    public function getUsersByRole($role)
    {
        if (is_string($role))
        {
            $role = $this->roleManager->getByName($role);
        }
        if ($role instanceof Role)
        {
            $users = $role->getUsers()->toArray();
            $children = $role->getChildren();

            /** @var Role $child */
            foreach ($children as $child)
            {
                $users = array_merge($users, $this->getUsersByRole($child));
            }

            return $users;
        }
        return array();
    }

    public function hasResource(Resource $resource, User $user = NULL)
    {
        /** @var User $user */
        $user = $this->selectCorrectEntity($user);

        if ($user->getResources()->contains($resource))
        {
            return 1;
        }

        $roles = $user->getRoles();
        /** @var Role $role */
        foreach ($roles as $role)
        {
            if ($this->roleManager->hasResource($resource, $role) == true)
            {
                return 2;
            }
        }
        return 0;
    }
}