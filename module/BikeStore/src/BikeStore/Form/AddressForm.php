<?php


namespace BikeStore\Form;


/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 16.06.2016
 * Time: 19:12
 */
use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Number;
use Zend\Form\Element\Select;



class AddressForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		$this->addElements();
	}

	private function addElements()
	{
		$Street = new Text("street");
		$Street->setLabel('Straße');
		$Street->setAttribute('id', 'street');
		$Street->setAttribute('required', 'true');
		$Street->setAttribute('class', 'form-control');
		$this->add($Street);

		$PLZ = new Text("PLZ");
		$PLZ->setLabel('PLZ');
		$PLZ->setAttribute('id', 'PLZ');
		$PLZ->setAttribute('required', 'true');
		$PLZ->setAttribute('class', 'form-control');
		$this->add($PLZ);
		
		$HouseNumber = new Number("HouseNumber");
		$HouseNumber->setAttribute('id', 'HouseNumber');
		$HouseNumber->setLabel('Hausnummer');
		$HouseNumber->setAttribute('required', 'true');
		$HouseNumber->setAttribute('class', 'form-control');
		$this->add($HouseNumber);
	
		$City = new Text("City");
		$City->setAttribute('id', 'city');
		$City->setLabel('Ort');
		$City->setAttribute('required', 'true');
		$City->setAttribute('class', 'form-control');
		$this->add($City);

		$Country = new Text("Country");
		$Country->setAttribute('id', 'country');
		$Country->setLabel('Land');
		$Country->setAttribute('required', 'true');
		$Country->setAttribute('class', 'form-control');
		$this->add($Country);

		$MrMrs = new Text("MrMrs");
		$MrMrs->setAttribute('id', 'MrMrs');
		$MrMrs->setLabel('Herr/Frau');
		$MrMrs->setAttribute('required', 'true');
		$MrMrs->setAttribute('class', 'form-control');
		$this->add($MrMrs);

		$FirstName = new Text("FirstName");
		$FirstName->setAttribute('id', 'PLZ');
		$FirstName->setLabel('Vorname');
		$FirstName->setAttribute('required', 'true');
		$FirstName->setAttribute('class', 'form-control');
		$this->add($FirstName);

		$LastName = new Text("LastName");
		$LastName->setAttribute('id', 'LastName');
		$LastName->setLabel('Nachname');
		$LastName->setAttribute('required', 'true');
		$LastName->setAttribute('class', 'form-control');
		$this->add($LastName);


	}
}