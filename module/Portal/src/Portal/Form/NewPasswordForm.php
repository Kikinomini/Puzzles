<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 05.07.2015
 * Time: 15:34
 */

namespace Portal\Form;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class NewPasswordForm extends Form{
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

        $submitButton = new Submit('submitButton');
        $submitButton->setAttribute('id', 'submitButton');
        $submitButton->setValue('Absenden');
        $submitButton->setAttribute('class', 'form-control');
        $this->add($submitButton);
    }
} 