<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 19.09.2015
 * Time: 00:36
 */

namespace Portal\Controller;

use Application\Model\Datatable\Column\Column;
use Application\Model\Datatable\Column\DialogRouteColumn;
use Application\Model\Datatable\Column\HiddenColumn;
use Application\Model\Datatable\Column\JavaScriptFunctionColumn;
use Application\Model\Datatable\Column\PictureEnumColumn;
use Application\Model\Datatable\Column\RouteColumn;
use Application\Model\Datatable\Datatable;
use Application\Model\Manager\ResourceManager;
use Application\Model\Manager\RoleManager;
use Application\Model\Manager\UserManager;
use Application\Model\Role;
use Application\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Portal\Form\AddRoleForm;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleResourceController extends AbstractActionController
{
    public function roleListAction()
    {
        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");
        $roles = $roleManager->getAllEntities();

        /** @var ResourceManager $resourceManager */
        $resourceManager = $this->getServiceLocator()->get("resourceManager");
        $resources = $resourceManager->getAllEntities();

        $roleResourceList = new Datatable("roleResourceList");

        $roleId = new HiddenColumn("roleId");
        $roleResourceList->addColumn($roleId);

        $roleName = new Column("roleName");
        $roleName->setLabel("Rolle");
        $roleResourceList->addColumn($roleName);

        $roleDescription = new Column("roleDescription");
        $roleDescription->setLabel("Beschreibung");
        $roleResourceList->addColumn($roleDescription);

        $roleOverview = new RouteColumn("roleOverview");
        $roleOverview->setRouteName("userList/roleList/roleOverview");
        $roleOverview->setRouteLabel("Vererbung");
        $roleOverview->setRouteDynamicParams(array("roleId" => "roleId"));
        $roleResourceList->addColumn($roleOverview);

        $modifyRole = new DialogRouteColumn("modifyRole");
        $modifyRole->setRouteName("userList/roleList/modifyRole");
        $modifyRole->setRouteLabel("Bearbeiten");
        $modifyRole->setRouteDynamicParams(array('roleId' => 'roleId'));
        $modifyRole->setTitle("Rolle bearbeiten");
        $modifyRole->setButtonText("Schließen");
        $roleResourceList->addColumn($modifyRole);

        /** @var \Application\Model\Resource $resource */
        foreach ($resources as $resource) {
            $resourceName = $resource->getName();
            $column = new JavaScriptFunctionColumn("resource_" . $resource->getId());
            $column->setJavaScriptFunctionName("userManager.changeRoleResource");
            if (strlen($resourceName) > 10) {
                $column->setLabel(substr($resourceName, 0, 7) . "...");
            } else {
                $column->setLabel($resourceName);
            }
            $column->setAttribute("title", $resourceName);
            $column->setEnumeration(array(
                "0" => "kreuz.png",
                "1" => "hacken.png",
                "2" => "hacken_grau.png",
            ));
            $roleResourceList->addColumn($column);
        }

        $content = array();
        /** @var Role $role */
        foreach ($roles as $role) {
            $index = count($content);
            $content[$index] = array(
                "roleId" => $role->getId(),
                "roleName" => $role->getName(),
                "roleDescription" => $role->getBeschreibung(),
            );
            /** @var \Application\Model\Resource $resource */
            foreach ($resources as $resource) {
                $content[$index]["resource_" . $resource->getId()] = $roleManager->hasResource($resource, $role);
            }
        }
        $roleResourceList->setContent($content);

        return new ViewModel(array(
                "roleResourceList" => $roleResourceList)
        );
    }

    public function changeRoleResourceAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");

        /** @var ResourceManager $resourceManager */
        $resourceManager = $this->getServiceLocator()->get("resourceManager");

        if ($request->isPost()) {
            $resourceId = $request->getPost("resourceId");
            $roleId = $request->getPost("roleId");

            /** @var Resource $resource */
            $resource = $resourceManager->getEntityById($resourceId);
            /** @var Role $role */
            $role = $roleManager->getEntityById($roleId);

            if ($request->getPost("isAllowed") == "1") {
                if (!$role->getResources()->contains($resource)) {
                    $role->getResources()->add($resource);
                    $roleManager->save($role);
                }
            } else {
                if ($role->getResources()->contains($resource)) {
                    $role->getResources()->removeElement($resource);
                    $roleManager->save($role);
                }
            }

            $roleArray = $roleManager->getChildResourceAllowed($resource, $role);
            $jsonRespond = array(
                'resourceId' => $resource->getId(),
                'roles' => $roleArray,
            );

            $this->layout('layout/ajaxData');
            return new ViewModel(
                array(
                    "jsonArray" => $jsonRespond,
                )
            );
        }

        $this->getResponse()->setStatusCode(404);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }

    public function userListAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get("userManager");
        $users = $userManager->getAllEntities();

        /** @var ResourceManager $resourceManager */
        $resourceManager = $this->getServiceLocator()->get("resourceManager");
        $resources = $resourceManager->getAllEntities();

        $userResourceList = new Datatable("userResourceList");

        $userId = new HiddenColumn("userId");
        $userResourceList->addColumn($userId);

        $username = new Column("username");
        $username->setLabel("Username");
        $userResourceList->addColumn($username);

        $roles = new RouteColumn("roles");
        $roles->setLabel("");
        $roles->setRouteLabel("Rollen");
        $roles->setRouteName("userList/userOverview");
        $roles->setRouteDynamicParams(array('userId' => 'userId'));
        $userResourceList->addColumn($roles);

        /** @var \Application\Model\Resource $resource */
        foreach ($resources as $resource) {
            $resourceName = $resource->getName();
            $column = new PictureEnumColumn("resource_" . $resourceName);
            if (strlen($resourceName) > 10) {
                $column->setLabel(substr($resourceName, 0, 7) . "...");
            } else {
                $column->setLabel($resourceName);
            }
            $column->setAttribute("title", $resourceName);
            $column->setEnumeration(array(
                "0" => "kreuz.png",
                "1" => "hacken.png",
                "2" => "hacken_grau.png",
            ));
            $userResourceList->addColumn($column);
        }

        $content = array();
        /** @var User $user */
        foreach ($users as $user) {
            $index = count($content);
            $content[$index] = array(
                "userId" => $user->getId(),
                "username" => $user->getUsername(),
            );
            /** @var \Application\Model\Resource $resource */
            foreach ($resources as $resource) {
                $content[$index]["resource_" . $resource->getName()] = $userManager->hasResource($resource, $user);
            }
        }
        $userResourceList->setContent($content);

        return new ViewModel(array(
                "userResourceList" => $userResourceList)
        );
    }
    public function userOverviewAction()
    {
        $userId = $this->params("userId");

        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get("userManager");
        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");

        $user = $userManager->getEntityById($userId);
        if ($user instanceof User) {
            /** @var ArrayCollection $roles */
            $roles = new ArrayCollection($roleManager->getAllEntities());

            $userRoleList = new Datatable("userRoleList");
            $content = array();
            $userRoles = $user->getRoles();
            /** @var Role $role */
            foreach($userRoles as $role)
            {
                $roles->removeElement($role);
                $content[] = array(
                    'userRoleId' => $role->getId(),
                    'name' => $role->getName(),
                    'description' => $role->getBeschreibung(),
                    'minus' => "1",
                );
            }
            $userRoleList->setContent($content);

            $roleId = new HiddenColumn("userRoleId");
            $userRoleList->addColumn($roleId);

            $name = new Column("name");
            $name->setLabel("Name");
            $userRoleList->addColumn($name);

            $description = new Column("description");
            $description->setLabel("Beschreibung");
            $userRoleList->addColumn($description);

            $minus = new JavaScriptFunctionColumn("minus");
            $minus->setLabel("");
            $minus->setJavaScriptFunctionName("userManager.removeRole");
            $minus->setEnumeration(array(
                "1" => 'minus.png',
            ));
            $userRoleList->addColumn($minus);

            $content = array();
            /** @var Role $role */
            foreach ($roles as $role) {
                $content[] = array(
                    'roleId' => $role->getId(),
                    'name' => $role->getName(),
                    'description' => $role->getBeschreibung(),
                    'plus' => 1
                );
            }
            $roleList = new Datatable("roleList");
            $roleList->setContent($content);

            $roleId = new HiddenColumn("roleId");
            $roleList->addColumn($roleId);

            $roleList->addColumn($name);
            $roleList->addColumn($description);

            $plus = new JavaScriptFunctionColumn("plus");
            $plus->setEnumeration(array(1 => "plus.png"));
            $plus->setLabel("");
            $plus->setJavaScriptFunctionName("userManager.addRole");
            $roleList->addColumn($plus);

            return new ViewModel(array(
                'user' => $user,
                'userRoleList' => $userRoleList,
                'roleList' => $roleList,
            ));
        }
        $this->getResponse()->setStatusCode(404);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }
    public function changeUserRoleAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get("userManager");
        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");

        $user = $userManager->getEntityById($this->params("userId"));

        if ($request->isPost() && $user instanceof User)
        {
            $roleId = $request->getPost("roleId");
            $addRole = $request->getPost("addRole");

            /** @var Role $role */
            $role = $roleManager->getEntityById($roleId);

            if ($addRole == true)
            {
                if (!$user->getRoles()->contains($role)) {

                    $user->getRoles()->add($role);
                    $role->getUsers()->add($user);
                    $userManager->save($user);
                }
            }
            else
            {
                if ($user->getRoles()->contains($role))
                {
                    $user->getRoles()->removeElement($role);
                    $role->getUsers()->removeElement($user);
                    $userManager->save($user);
                    $roleManager->save($role);
                }
            }
            if ($user->getRoles()->contains($role))
            {
                $returnValue = array("hasRole" => true);
            }
            else
            {
                $returnValue = array("hasRole" => false);
            }
            $this->layout("layout/ajaxData");
            return new ViewModel(array(
                "returnValue" => $returnValue,
            ));
        }
        $this->getResponse()->setStatusCode(404);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }
    public function changeRoleParentAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");
        /** @var Role $role */
        $role = $roleManager->getEntityById($this->params("roleId"));

        if ($request->isPost() && $role instanceof Role)
        {
            $parentId = $request->getPost("parentId");
            $addParent = $request->getPost("addParent");

            /** @var Role $parent */
            $parent = $roleManager->getEntityById($parentId);

            if ($parent->getId() !== $role->getId()) {
                if ($addParent == true) {
                    if (!$role->getParents()->contains($parent)) {
                        $role->getParents()->add($parent);
//                    $parent->getChildren()->add($role);
                        $roleManager->save($role);
                    }
                } else {
                    if ($role->getParents()->contains($parent)) {
                        $role->getParents()->removeElement($parent);
                        $parent->getChildren()->removeElement($role);
                        $roleManager->save($parent);
                        $roleManager->save($role);
                    }
                }
            }
            if ($role->getParents()->contains($parent))
            {
                $returnValue = array("hasParent" => true);
            }
            else
            {
                $returnValue = array("hasParent" => false);
            }
            $this->layout("layout/ajaxData");
            return new ViewModel(array(
                "returnValue" => $returnValue,
            ));
        }
        $this->getResponse()->setStatusCode(404);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }
    public function roleOverviewAction()
    {
        $roleId = $this->params("roleId");

        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");

        $role = $roleManager->getEntityById($roleId);
        if ($role instanceof Role) {
            /** @var ArrayCollection $roles */
            $roles = new ArrayCollection($roleManager->getAllEntities());
            $roles->removeElement($role);

            $parentList = new Datatable("parentList");
            $content = array();
            $parents = $role->getParents();
            /** @var Role $parent */
            foreach($parents as $parent)
            {
                $roles->removeElement($parent);
                $content[] = array(
                    'parentId' => $parent->getId(),
                    'name' => $parent->getName(),
                    'description' => $parent->getBeschreibung(),
                    'minus' => "1",
                );
            }
            $parentList->setContent($content);

            $roleId = new HiddenColumn("parentId");
            $parentList->addColumn($roleId);

            $name = new Column("name");
            $name->setLabel("Name");
            $parentList->addColumn($name);

            $description = new Column("description");
            $description->setLabel("Beschreibung");
            $parentList->addColumn($description);

            $minus = new JavaScriptFunctionColumn("minus");
            $minus->setLabel("");
            $minus->setJavaScriptFunctionName("userManager.removeParent");
            $minus->setEnumeration(array(
                "1" => 'minus.png',
            ));
            $parentList->addColumn($minus);

            $content = array();
            /** @var Role $parent */
            foreach ($roles as $parent) {
                $content[] = array(
                    'roleId' => $parent->getId(),
                    'name' => $parent->getName(),
                    'description' => $parent->getBeschreibung(),
                    'plus' => 1
                );
            }
            $roleList = new Datatable("roleList");
            $roleList->setContent($content);

            $roleId = new HiddenColumn("roleId");
            $roleList->addColumn($roleId);

            $roleList->addColumn($name);
            $roleList->addColumn($description);

            $plus = new JavaScriptFunctionColumn("plus");
            $plus->setEnumeration(array(1 => "plus.png"));
            $plus->setLabel("");
            $plus->setJavaScriptFunctionName("userManager.addParent");
            $roleList->addColumn($plus);

            return new ViewModel(array(
                'role' => $role,
                'parentList' => $parentList,
                'roleList' => $roleList,
            ));
        }
        $this->getResponse()->setStatusCode(404);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }
    public function modifyRoleAction()
    {
        $roleId = $this->params("roleId");

        /** @var RoleManager $roleManager */
        $roleManager = $this->getServiceLocator()->get("roleManager");
        /** @var Request $request */
        $request = $this->getRequest();
        $form = new AddRoleForm();

        if ($roleId > 0)
        {
            $role = $roleManager->getEntityById($roleId);
        }
        else
        {
            $role = new Role();
        }
        $form->bind($role);

        if ($role instanceof Role && $request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                $roleManager->save($role);
                $this->flashMessenger()->addSuccessMessage("Die Rolle wurde erfolgreich gespeichert.");
            }
            else
            {
                $invalidInput = $form->getInputFilter()->getInvalidInput();
                foreach ($invalidInput as $invalid) {
                    $messages = $invalid->getMessages();
                    foreach ($messages as $message) {
                        $this->flashMessenger()->addErrorMessage($message);
                    }
                }
            }
            return $this->redirect()->toRoute("userList/roleList");
        }
        $this->layout('layout/ajax');
        return new ViewModel(array('form' => $form, 'role' => $role));
    }
}