<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 24.06.2016
 * Time: 16:48
 */

namespace BikeStore\Form\InputFilter;


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
		$HousNumber = new Input("HousNumber");
		$HousNumber->setRequired(true);
		$HousNumber->getValidatorChain()
			->attach(new Regex('[1-9][0-9]*[a-z]?'));
		$this->add($HousNumber);
	}
	public function addStreet(){
		$Street = new Input("HousNumber");
		$Street->setRequired(true);
		$Street->getValidatorChain()
			->attach(new Regex('[A-Z,a-z,0-9,ß,ä,Ä,ü,Ü,ö,Ö,\-\ ]+'));
		$this->add($Street);
	}
	public function addCity(){
		$City = new Input("City");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex('[A-Z,a-z,0-9,ß,ä,Ä,ü,Ü,ö,Ö,\-\ ]+'));
		$this->add($City);
	}
	public function addCountry(){
		$Country = new Input("Country");
		$Country->setRequired(true);
		$Country->getValidatorChain()
			->attach(new Regex('[A-Z,a-z]+'));
		$this->add($Country);
	}
	public function addMrMrs(){
		$MrMrs = new Input("MrMrs");
		$MrMrs->setRequired(true);
		$MrMrs->getValidatorChain()
			->attach(new Regex('Herr|Frau'));
		$this->add($MrMrs);
	}
	public function addFirstName(){
		$City = new Input("City");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex('[A-Z,a-z,ß,ä,Ä,ü,Ü,ö,Ö,\-\ ]+'));
		$this->add($City);
	}
	public function addLastName(){
		$City = new Input("City");
		$City->setRequired(true);
		$City->getValidatorChain()
			->attach(new Regex('[A-Z,a-z,ß,ä,Ä,ü,Ü,ö,Ö,\-\ ]+'));
		$this->add($City);
	}
}