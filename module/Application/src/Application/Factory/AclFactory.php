<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 12.09.14
 * Time: 14:52
 */

namespace Application\Factory;

use Application\Model\Manager\RoleManager;
use Application\Model\Manager\UserManager;
use Application\Model\MyAcl;
use Application\Model\Role;
use Application\Model\User;
use Zend\ServiceManager\FactoryInterface as FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocatorInterface;
use Zend\View\Helper\Navigation\AbstractHelper;


class AclFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $sm)
    {
		$acl = new MyAcl();
        /** @var UserManager $userManager */
        $userManager = $sm->get('userManager');
        /** @var RoleManager $roleManager */
        $roleManager = $sm->get('roleManager');

        $user = $userManager->getUserFromSession();
        if ($user instanceof User)
        {
            $roleName = "standardRoleFuerUser";
            $roles = $user->getRoles()->toArray();
            /** @var Role $role */
            foreach ($roles as $role)
            {
                $parents = $role->getParents()->toArray();
                $acl->addRole($role->getName(), $parents);
                $resources = $role->getResources();
                /** @var Resource $resource */
                foreach ($resources as $resource)
                {
                    $acl->addResource($resource->getName());
                    $acl->allow($role->getName(), $resource->getName());
                }
            }
            $acl->addRole($roleName, $roles);
        }
        else
        {
            $roleName = "gast";
            $role = $roleManager->getByName($roleName);

            $parents = $role->getParents()->toArray();
            $acl->addRole($role->getName(), $parents);
            $resources = $role->getResources();
            /** @var Resource $resource */
            foreach ($resources as $resource)
            {
                $acl->addResource($resource->getName());
                $acl->allow($role->getName(), $resource->getName());
            }
        }

//        $acl->isAllowed($roleName, "default");
//        $acl->isAllowed($roleName, "offline");
//        $acl->isAllowed($roleName, "online");

        AbstractHelper::setDefaultAcl($acl);
        AbstractHelper::setDefaultRole($roleName);
		$acl->setUserRole($roleName);

        return $acl;
    }

} 