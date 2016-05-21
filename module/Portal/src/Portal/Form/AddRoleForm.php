<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24.09.2015
 * Time: 18:58
 */

namespace Portal\Form;

use Portal\Form\Hydrator\AddRoleHydrator;
use Portal\Form\InputFilter\AddRoleInputFilter;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class AddRoleForm extends Form{
    public function __construct()
    {
        parent::__construct();

        $this->setHydrator(new AddRoleHydrator());
        $this->setInputFilter(new AddRoleInputFilter());

        $this->addElements();

        $this->setAttribute('class', 'myForm');
    }

    private function addElements()
    {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->setAttribute('id', 'name');
        $name->setAttribute('required', 'true');
        $name->setAttribute('class', 'form-control');
        $name->setAttribute('maxlength', '30');
        $this->add($name);

        $description = new Text('description');
        $description->setLabel('Beschreibung');
        $description->setAttribute('id', 'description');
        $description->setAttribute('required', 'true');
        $description->setAttribute('class', 'form-control');
        $description->setAttribute('maxlength', '255');
        $this->add($description);

        $submitButton = new Submit('submitButton');
        $submitButton->setAttribute('id', 'submitButton');
        $submitButton->setValue('Speichern');
        $submitButton->setAttribute('class', 'form-control');
        $this->add($submitButton);
    }
} 