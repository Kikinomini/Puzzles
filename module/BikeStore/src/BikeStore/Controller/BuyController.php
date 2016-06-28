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
		$addressForm = new AddressForm(true);

		/** @var Container $sessionContainer */
		$sessionContainer = new Container("AddressContainer");

		if ($request->isPost())
		{
			$postData = $request->getPost();

			if($postData->get('IstGleich')=='verschieden'){
				$addressForm = new AddressForm(false);
			}
			else{

			}

			$addressForm->setData($postData);

			if($addressForm->isValid()){
				$deliveryAddress = array(	"street"=> $postData->get("street"),
									"PLZ"=>$postData->get("PLZ"),
								  	"HouseNumber"=>$postData->get("HouseNumber"),
									"City"=>$postData->get("City"),
								   	"Country"=>$postData->get("Country"),
								 	"MrMrs"=>$postData->get("MrMrs"),
								 	"FirstName"=>$postData->get("FirstName"),
								 	"LastName"=>$postData->get("LastName"));

				if($postData->get('IstGleich')=='verschieden')
					$billingAddress = array("street"=> $postData->get("rstreet"),
						"PLZ"=>$postData->get("rPLZ"),
						"HouseNumber"=>$postData->get("rHouseNumber"),
						"City"=>$postData->get("rCity"),
						"Country"=>$postData->get("rCountry"),
						"MrMrs"=>$postData->get("rMrMrs"),
						"FirstName"=>$postData->get("rFirstName"),
						"LastName"=>$postData->get("rLastName"));
				else{
					$billingAddress = $deliveryAddress;
				}

				$sessionContainer->offsetSet('deliveryAddress',$deliveryAddress);
				$sessionContainer->offsetSet('billingAddress',$billingAddress);
			}

		}
		return new ViewModel(
			array('valide' => $valide ,'form' => $addressForm)
		);


	}
}