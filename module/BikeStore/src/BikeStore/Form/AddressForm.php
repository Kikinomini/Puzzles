<?php

namespace BikeStore\Form;

use Application\Form\MyForm;
use BikeStore\Form\InputFilter\AddressInputFilter;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Number;
use Zend\Form\Element\Select;

class AddressForm extends MyForm
{	
	public function __construct($oneDataset)
	{
		parent::__construct();
		$this->addElements();
		$this->setAttribute("id", "AddressForm");

		$this->setInputFilter(new AddressInputFilter($oneDataset));
	}

	public function addElements()
	{
		$Street = new Text("street");
		$Street->setLabel('Straße');
		$Street->setAttribute('id', 'street');
		$Street->setAttribute('required', 'true');
		$Street->setAttribute('class', 'form-control');
		$this->add($Street);

		$PLZ = new Number("PLZ");
		$PLZ->setLabel('PLZ');
		$PLZ->setAttribute('id', 'PLZ');
		$PLZ->setAttribute('required', 'true');
		$PLZ->setAttribute('class', 'form-control');
		$this->add($PLZ);
		
		$HouseNumber = new Text("HouseNumber");
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

		$MrMrs = new Select("MrMrs");
		$MrMrs->setAttribute('id', 'MrMrs');
		$MrMrs->setLabel('Herr/Frau');
		$MrMrs->setValueOptions(array(
			'0' => 'Bitte Wählen',
			'Herr' => 'Herr',
			'Frau' => 'Frau',
		));
		$MrMrs->setAttribute('required', 'true');
		$MrMrs->setAttribute('class', 'form-control');
		$this->add($MrMrs);

		$FirstName = new Text("FirstName");
		$FirstName->setAttribute('id', 'FirstName');
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

		$SubmitButton = new Submit("SubmitButton");
		$SubmitButton->setLabel(" ");
		$SubmitButton->setValue("Weiter");
		$SubmitButton->setLabelOption('disable_html_escape', true);
		$this->add($SubmitButton);



		$checkbox = new Checkbox("IstGleich");
		$checkbox->setLabel("Lieferadresse ist die Rechnungsadresse");
		$checkbox->setValue("IstGleich");
		$checkbox->setCheckedValue("gleich");
		$checkbox->setUncheckedValue("verschieden");
		$checkbox->setAttribute('class', 'form-control');
		$checkbox->setAttribute('required', false);
		$this->add($checkbox);







		$rStreet = new Text("rstreet");
		$rStreet->setLabel('Straße');
		$rStreet->setAttribute('id', 'rstreet');
		$rStreet->setAttribute('required', false);
		$rStreet->setAttribute('class', 'form-control');
		$this->add($rStreet);

		$rPLZ = new Number("rPLZ");
		$rPLZ->setLabel('PLZ');
		$rPLZ->setAttribute('id', 'rPLZ');
		$rPLZ->setAttribute('required', false);
		$rPLZ->setAttribute('class', 'form-control');
		$this->add($rPLZ);

		$rHouseNumber = new Text("rHouseNumber");
		$rHouseNumber->setAttribute('id', 'rHouseNumber');
		$rHouseNumber->setLabel('Hausnummer');
		$rHouseNumber->setAttribute('required', false);
		$rHouseNumber->setAttribute('class', 'form-control');
		$this->add($rHouseNumber);

		$rCity = new Text("rCity");
		$rCity->setAttribute('id', 'rcity');
		$rCity->setLabel('Ort');
		$rCity->setAttribute('required', false);
		$rCity->setAttribute('class', 'form-control');
		$this->add($rCity);

		$rCountry = new Text("rCountry");
		$rCountry->setAttribute('id', 'rcountry');
		$rCountry->setLabel('Land');
		$rCountry->setAttribute('required', false);
		$rCountry->setAttribute('class', 'form-control');
		$this->add($rCountry);

		$rMrMrs = new Select("rMrMrs");
		$rMrMrs->setAttribute('id', 'rMrMrs');
		$rMrMrs->setLabel('Herr/Frau');
		$rMrMrs->setValueOptions(array(
			'0' => 'Bitte Wählen',
			'Herr' => 'Herr',
			'Frau' => 'Frau',
		));
		$rMrMrs->setAttribute('required', false);
		$rMrMrs->setAttribute('class', 'form-control');
		$this->add($rMrMrs);

		$rFirstName = new Text("rFirstName");
		$rFirstName->setAttribute('id', 'rFirstName');
		$rFirstName->setLabel('Vorname');
		$rFirstName->setAttribute('required', false);
		$rFirstName->setAttribute('class', 'form-control');
		$this->add($rFirstName);

		$rLastName = new Text("rLastName");
		$rLastName->setAttribute('id', 'rLastName');
		$rLastName->setLabel('Nachname');
		$rLastName->setAttribute('required', false);
		$rLastName->setAttribute('class', 'form-control');
		$this->add($rLastName);


	}
	
	public function addEssentials()
	{
		
		
	}
}