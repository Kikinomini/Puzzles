<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 15:56
 */

namespace Application\Model;


use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;

class MyAcl extends Acl
{
	private $userRole = 'Gast';

	/**
	 * @param string $userRole
	 */
	public function setUserRole($userRole)
	{
		$this->userRole = $userRole;
	}

	/**
	 * @return string
	 */
	public function getUserRole()
	{
		return $this->userRole;
	}

	public function isAllowed($role = null, $resource = null, $privilege = null)
	{
		if ($this->hasRole($role) && $this->hasResource($resource))
		{
			return parent::isAllowed($role, $resource, $privilege);
		}
		return false;
	}


	public function allowed($resource = null, $privilege = null)
	{
		return $this->isAllowed($this->userRole, $resource, $privilege);
	}

	public static function authorisation(MvcEvent $e, Acl $acl)
	{
		$resource = $e->getRouteMatch()->getParam('resource', '');
		if (!$acl->hasResource($resource) || !$acl->isAllowed($acl->userRole, $resource))
		{
			$response = $e->getResponse();
            if ($response instanceof Response) {
                $response->setStatusCode(403);
            }
            else
            {
                echo "403-Error";
                /** @var \Zend\Console\Response $response */
                $response = $response;
                $response->setErrorLevel(403);
            }
            $e->getApplication()->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, 'Module', $e);
		}
	}

	public function addRole($role, $parents = null)
	{
		$parentNames = null;

		if (is_array($parents))
		{
			/** @var Role $parent */
			foreach ($parents as $parent)
			{
				if (!$this->hasRole($parent->getName()))
				{
					$this->addRole($parent->getName(), $parent->getParents()->toArray());
					$resources = $parent->getResources();
					/** @var Resource $resource */
					foreach ($resources as $resource)
					{
						$this->addResource($resource->getName());
						$this->allow($parent->getName(), $resource->getName());
					}
				}
				$parentNames[] = $parent->getName();
			}
		}
        if (!$this->hasRole($role)) {
            return parent::addRole($role, $parentNames);
        }
	}

	public function addResource($resource, $parent = null)
	{
		if (!$this->hasResource($resource))
		{
			return parent::addResource($resource, $parent);
		}
	}
}
