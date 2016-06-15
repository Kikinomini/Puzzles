<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.06.16
 * Time: 14:48
 */

namespace BikeStore\Controller;


use Application\Model\Manager\UserManager;
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
			$this->forward()->dispatch("BikeStore\\Controller\\Buy", array("action" => "insertAdress"));
		}
	}
	public function insertAddressAction(){
		$request = $this->getRequest();
	}
}