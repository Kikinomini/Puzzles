<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 03.06.16
 * Time: 14:48
 */

namespace BikeStore\Controller;

use Application\Model\Manager\UserManager;
use Application\Model\SmtpMail;
use BikeStore\Form\AddressForm;
use BikeStore\Model\Manager\ArticleManager;
use Zend\Http\Request;
use Zend\Http\Response;
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
	
	public function insertAddressAction() {
		/** @var Request $request */
		$request = $this->getRequest();
		
		/** @var AddressForm $addressForm */
		$addressForm = new AddressForm(true);

		/** @var Container $sessionContainer */
		$sessionContainer = new Container("AddressContainer");

		$valide = false;
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
				$valide = true;
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
				return $this->redirect()->toRoute("selectPaymentMethod");
			}
		}
		return new ViewModel(
			array('valide' => $valide ,'form' => $addressForm)
		);
	}

    /**
     * @return \Zend\Http\Response
     */
    public function selectPaymentMethodAction()
	{
		//TODO: Check if last steps fulfilled
		/** @var UserManager $userManager */
		$userManager = $this->getServiceLocator()->get("userManager");
		$user = $userManager->getUserFromSession();
		if (!$user->getAktiviert()) {
			return $this->redirect()->toRoute("insertDeliveryAddress");
		}

		/** @var Container $sessionAddressContainer */
		$sessionAddressContainer = new Container("AddressContainer");

		if(!$sessionAddressContainer->offsetExists("deliveryAddress") ||
			!$sessionAddressContainer->offsetExists("billingAddress")) {
			return $this->redirect()->toRoute("insertDeliveryAddress");
		}

                /** @var Container $sessionCartContainer */
                $sessionCartContainer = new Container("shoppingCart");

                if(!$sessionCartContainer->offsetExists("articles") || !count($sessionCartContainer->offsetGet("articles"))) {
                    return $this->redirect()->toRoute("shoppingCart");
                }

                /** @var ArticleManager $articleManager */
                $articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
                $articles = $sessionCartContainer->offsetGet("articles");

                $sum = 0;

                foreach($articles as $id => &$article)
                {
                    $art = $articleManager->getEntityById($id);
                    $article["name"] = $art->getName();
                    $article["price"] = $art->getPrice();
                    $article["image"] = "/image/" . $art->getImageName();
                    $article["info"] = $art->getViewInformationAsArray();
                    $sum += $article["price"] * $article["count"];
                }

                /** @var Container $sessionAddressContainer */
                $sessionPaymentContainer = new Container("PaymentContainer");

                $sessionPaymentContainer->offsetSet('sum', $sum);

                $orderID = date("Ymd") . '_' . rand(10000, 99999);
                $sessionPaymentContainer->offsetSet('orderID', $orderID);

                $sessionPaymentContainer->offsetSet('articles', $articles);

                $paymentMethods = array(
                    "transfer" => array(
                        "name" => "Überweisung",
                        "directTo" => "/paymentTransfer"
                    ),
                    "bill" =>  array(
                        "name" => "Rechnung",
                        "directTo" => "/paymentBill"
                    ),
                    "paypal" =>  array(
                        "name" => "Paypal",
                        "directTo" => "/paymentPaypal"
                    ),
                );

                return new ViewModel(
                    array(
                        'dAddr' => $sessionAddressContainer->offsetGet("deliveryAddress"),
                        'bAddr' => $sessionAddressContainer->offsetGet("billingAddress"),
                        'articles' => $articles,
                        'paymentMethods' => $paymentMethods,
                        'sum' => $sum,
                        'orderID' => $orderID
                    )
                );
	}

    public function paymentTransferAction()
    {
        /** @var Container $sessionAddressContainer */
        $sessionPaymentContainer = new Container("PaymentContainer");

        $sum = $sessionPaymentContainer->offsetGet('sum');
        $orderID = $sessionPaymentContainer->offsetGet('orderID');

        $response = $this->_paymentDone();
		if ($response instanceof Response)
		{
			return $response;
		}
        return new ViewModel(
            array(
                'sum' => $sum,
                'orderID' => $orderID
            )
        );
    }

    public function paymentBillAction()
    {
        return $this->_paymentDone();
    }

    public function paymentPaypalAction()
    {
        return $this->_paymentDone();
    }

    protected function _paymentDone()
    {
        //TODO: Just save this somewhere
        /** @var Container $sessionCartContainer */
        $sessionCartContainer = new Container("shoppingCart");
        /** @var Container $sessionAddressContainer */
        $sessionPaymentContainer = new Container("PaymentContainer");
        /** @var Container $sessionAddressContainer */
        $sessionAddressContainer = new Container("AddressContainer");

		$orderId = $sessionPaymentContainer->offsetGet('orderID');
		if ($orderId == null)
		{
			return $this->redirect()->toRoute("home");
		}
		/** @var SmtpMail $mail */
        $mail = $this->getServiceLocator()->get('mail');
        $mail->setAllowReply(false);
        $mail->setBetreff("Bestellung " . $orderId);
        $mail->setTitle("Bestellung");
        $mail->setEmpfaengerEmail("puzzles@puzzles.silas.link");
        $mail->setEmpfaengerName("Puzzle Payments");

		$articles = $sessionPaymentContainer->offsetGet('articles');
        $message = json_encode([
            $articles,
            $sessionAddressContainer->offsetGet("deliveryAddress"),
            $sessionAddressContainer->offsetGet("billingAddress")
        ]);
        $mail->setNachricht($message);
        $mail->send();

		//Ab hier an den Kunden
		/** @var UserManager $userManager */
		$userManager = $this->getServiceLocator()->get("userManager");

		$user = $userManager->getUserFromSession();
		$mail->setAllowReply(false);
		$mail->setBetreff("Bestellbestätigung BST_" . $sessionPaymentContainer->offsetGet('orderID'));
		$mail->setTitle("Bestellung vom ".date("d.m.Y"));
		$mail->setEmpfaengerEmail($user->getEmail());
		$mail->setEmpfaengerName($user->getVorname()." ".$user->getNachname());

		$message = "Hallo Herr/Frau ".$user->getNachname().", <br/>".
				   "anbei schicken wir Ihnen eine Bestellübersicht Ihrer Bestellung. <br/><br/><table border = '1' width = '100%' style='border-collapse:0px'>";

		$price = 0;
		foreach ($articles as $articleArray)
		{
			$singlePrice = $articleArray["price"];
			$count = $articleArray["count"];
			$price += $singlePrice*$count;
			$message .= "<tr><td>".$articleArray["name"]."</td><td>Anzahl: ".$count."</td><td>".$singlePrice*$count." €</td></tr>";
		}
		$message .= "</table><br/>";
		$message .= "Gesamtpreis: <b>".$price." €</b><br/><br><i>Diese Email ist keine Rechnung! Eine Rechnung wird Ihnen an den von Ihnen angegebene Rechnungsadresse.</i>";
		$mail->setNachricht($message);
		$mail->send();

        $sessionCartContainer->offsetUnset('articles');
        //$sessionAddressContainer->offsetUnset("deliveryAddress");
        //$sessionAddressContainer->offsetUnset("billingAddress");
        $sessionPaymentContainer->offsetUnset('sum');
        $sessionPaymentContainer->offsetUnset('orderID');
		return null;
    }
}