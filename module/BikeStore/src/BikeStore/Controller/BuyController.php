<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.06.16
 * Time: 14:48
 */

namespace BikeStore\Controller;


use Application\Model\Manager\UserManager;
use BikeStore\Form\AddressForm;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

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
		
		/** @var AddressForm $addressForm */
		$addressForm = new AddressForm();

		/** @var Container $sessionContainer */
		$sessionContainer = new Container("AddressContainer");

		$valide = false;
		if ($request->isPost())
		{
			$postData = $request->getPost();

			$addressForm->setData($postData);

			if($addressForm->isValid())
			{
				$valide = true;
			}
			else{

			}

		}
		return new ViewModel(
			array('valide' => $valide ,'form' => $addressForm)
		);


	}
}