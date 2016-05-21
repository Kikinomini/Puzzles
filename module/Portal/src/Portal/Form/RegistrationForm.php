<?php

namespace Portal\Form;

use Application\Model\Manager\UserManager;
use DoctrineORMModule\Proxy\__CG__\Application\Model\User;
use Portal\Form\Hydrator\UserHydrator;
use Portal\Form\InputFilter\RegistrationInputFilter;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class RegistrationForm extends Form
{
	public function __construct(UserManager $userManager, $name = null, $options = array())
	{
		parent::__construct($name, $options);

		$this->setHydrator(new UserHydrator());
		$this->setInputFilter(new RegistrationInputFilter($userManager));
		$this->addElements();
		$this->setAttribute('class', 'myForm');
	}
	private function addElements()
	{
		$vorname = new Text('vorname');
		$vorname->setLabel('Vorname');
		$vorname->setAttribute('id', 'vorname');
		$vorname->setAttribute('required', 'true');
		$vorname->setAttribute('class', 'form-control');
		$this->add($vorname);

		$nachname = new Text('nachname');
		$nachname->setLabel('Nachname');
		$nachname->setAttribute('id', 'nachname');
		$nachname->setAttribute('required', 'true');
		$nachname->setAttribute('class', 'form-control');
		$this->add($nachname);

		$email = new Email('email');
		$email->setLabel('Email');
		$email->setAttribute('id', 'email');
		$email->setAttribute('required', 'true');
		$email->setAttribute('class', 'form-control');
		$this->add($email);

		$geburtdatum = new Text('geburtsdatum');
		$geburtdatum->setLabel('Geburtsdatum');
		$geburtdatum->setAttribute('id', 'geburtsdatum');
		$geburtdatum->setAttribute('required', 'true');
		$geburtdatum->setAttribute('class', 'form-control datepicker-gebYear');
//		$geburtdatum->setFormat("d.m.Y");
		$this->add($geburtdatum);

		$username = new Text('username');
		$username->setLabel('Username');
		$username->setAttribute('id', 'username');
		$username->setAttribute('required', 'true');
		$username->setAttribute('class', 'form-control');
		$this->add($username);

		$password = new Password('passwort1');
		$password->setLabel('Passwort');
		$password->setAttribute('id', 'passwort1');
		$password->setAttribute('required', 'true');
		$password->setAttribute('class', 'form-control');
		$this->add($password);

//		$agb = new Checkbox('agb');
//		$agb->setLabel('AGB gelesen und einverstanden');
//		$agb->setAttribute('id', 'agb');
//		$agb->setAttribute('required', 'true');
//		$agb->setAttribute('class', 'form-control');
//		$agb->setUncheckedValue('no');
//		$this->add($agb);

		$password = new Password('passwort2');
		$password->setLabel('Passwort wiederholen');
		$password->setAttribute('id', 'passwort2');
		$password->setAttribute('required', 'true');
		$password->setAttribute('class', 'form-control');
		$password->setAttribute('testenWir', 'form-control');
		$this->add($password);

		$submitButton = new Submit('submitButton');
		$submitButton->setAttribute('id', 'submitButton');
		$submitButton->setAttribute('class', 'form-control');
		$submitButton->setValue('Registrieren');
		$this->add($submitButton);
	}

}