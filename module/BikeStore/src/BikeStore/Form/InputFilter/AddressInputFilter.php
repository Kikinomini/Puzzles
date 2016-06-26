<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 24.06.2016
 * Time: 16:48
 */

namespace BikeStore\Form\InputFilter;


use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\Regex;

class AddressInputFilter extends InputFilter
{
	public function __construct()
	{
		$this->addPLZ();
		$this->addHousNumber();
		$this->addStreet();
		$this->addCity();
		$this->addCountry();
		$this->addMrMrs();
		$this->addFirstName();
		$this->addLastName();
	}
	public function addPLZ(){
		$PLZInput = new Input("PLZ");
		$PLZInput->setRequired(true);
		$PLZInput->getValidatorChain()
			->attach( new Between(array('min' => 0, 'max' => 100000 , 'inclusive' => false)));
				
		$this->add($PLZInput);
	}
	public function addHousNumber(){
		$HousNumber = new Input("HouseNumber");
		$HousNumber->setRequired(true);
		$HousNumber->getValidatorChain()
			->attach(new Regex(array('pattern' =>"/^[1-9][0-9]*[a-z]?$/i")));
		$this->add($HousNumber);
	}
	public function addStreet(){
		$Street = new Input("street");
		$Street->setRequired(true);
		$Street->getValidatorChain()
			->attach(new Regex(array('pattern' =>'/^[a-zA-Z0-9ßÄäÜüÖö -]*$/i')));
		$this->add($Street);
	}
	public function addCity(){
		$City = new Input("City");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex(array('pattern' =>'/^[a-zA-Z0-9ßÄäÜüÖö -]*$/i')));
		$this->add($City);
	}
	public function addCountry(){
		$Country = new Input("Country");
		$Country->setRequired(true);
		$Country->getValidatorChain()
			->attach(new Regex(array('pattern' =>'/^[a-zA-Z]*$/i')));
		$this->add($Country);
	}
	public function addMrMrs(){
		$MrMrs = new Input("MrMrs");
		$MrMrs->setRequired(true);
		$MrMrs->getValidatorChain()
			->attach(new Regex(array('pattern' =>"/Herr|Frau/")));
		$this->add($MrMrs);
	}
	public function addFirstName(){
		$City = new Input("FirstName");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex(array('pattern' =>'/^[a-zA-Z -ßÜüÄäÖö]*$/i')));
		$this->add($City);
	}
	public function addLastName(){
		$City = new Input("LastName");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex(array('pattern' =>'/^[a-zA-Z ßÄäÜüÖö]*$/i')));
		$this->add($City);
	}
}