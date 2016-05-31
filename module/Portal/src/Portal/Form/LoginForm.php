<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 28.01.15
 * Time: 18:31
 */

namespace Portal\Form;


use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct()
	{
		parent::__construct();
		$this->addElements();
	}

	private function addElements()
	{
		$email = new Email('email');
		$email->setLabel('Email');
		$email->setAttribute('id', 'email');
		$email->setAttribute('required', 'true');
		$email->setAttribute('class', 'form-control');
		$this->add($email);

		$password = new Password('passwort');
		$password->setLabel('Passwort');
		$password->setAttribute('id', 'passwort');
		$password->setAttribute('required', 'true');
		$password->setAttribute('class', 'form-control');
		$this->add($password);

		$password = new Checkbox('autologin');
		$password->setLabel('Automatischer Login');
		$password->setAttribute('id', 'autologin');
		$password->setAttribute('title', 'Sie werden automatisch eingeloggt, wenn Sie diese Seite erneut besuchen.');
		$password->setAttribute('class', 'form-control');
		$this->add($password);

		$submitButton = new Submit('submitButton');
		$submitButton->setAttribute('id', 'submitButton');
		$submitButton->setValue('Login');
		$submitButton->setAttribute('class', 'form-control');
		$this->add($submitButton);
	}
}