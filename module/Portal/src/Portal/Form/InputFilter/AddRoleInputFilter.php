<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24.09.2015
 * Time: 19:42
 */

namespace Portal\Form\InputFilter;

use Zend\InputFilter\InputFilter;

class AddRoleInputFilter extends InputFilter{
    public function __construct()
    {
        $this->addName();
    }

    public function addName()
    {
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
//				array(
//					'name' => 'not_empty',
//					'options' => array(
//						'message' => 'Das Passwort darf nicht leer sein.',
//					)
//				),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'max' => 30,
                        'message' => 'Der Name darf maximal 30 Zeichen lang sein.',
                    )
                )
            ),
        ));
    }
} 