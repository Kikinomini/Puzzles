<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 05.07.2015
 * Time: 17:41
 */

namespace Portal\Form;


use Portal\Form\Hydrator\ChangePasswordHydrator;
use Portal\Form\InputFilter\ChangePasswordInputFilter;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class ChangePasswordForm extends Form{
    public function __construct()
    {
        parent::__construct();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new ChangePasswordHydrator());

        $this->setHydrator($hydrator);
        $this->setInputFilter(new ChangePasswordInputFilter());
        $this->addElements();

        $this->setAttribute('class', 'myForm');
    }

    private function addElements()
    {
        $password = new Password('password1');
        $password->setLabel('Passwort');
        $password->setAttribute('id', 'passwort1');
        $password->setAttribute('required', 'true');
        $password->setAttribute('class', 'form-control');
        $this->add($password);

        $password = new Password('password2');
        $password->setLabel('Passwort wiederholen');
        $password->setAttribute('id', 'passwort2');
        $password->setAttribute('required', 'true');
        $password->setAttribute('class', 'form-control');
        $this->add($password);

        $submitButton = new Submit('submitButton');
        $submitButton->setAttribute('id', 'submitButton');
        $submitButton->setValue('Absenden');
        $submitButton->setAttribute('class', 'form-control');
        $this->add($submitButton);
    }
} 