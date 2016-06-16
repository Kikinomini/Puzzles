<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.06.16
 * Time: 14:48
 */

namespace BikeStore\Controller;


use Application\Model\Manager\UserManager;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class BuyController extends AbstractActionController
{
	public function checkConfirmedUserAction()
	{
		/** @var UserManager $userManager */
		$userManager = $this->getServiceLocator()->get("userManager");
		$user = $userManager->getUserFromSession();
		if ($user->getAktiviert())
		{
			return $this->forward()->dispatch("BikeStore\\Controller\\Buy", array("action" => "insertAddress"));
		}
	}
	public function insertAddressAction(){
		/** @var Request $request */
		$request = $this->getRequest();

	}
}