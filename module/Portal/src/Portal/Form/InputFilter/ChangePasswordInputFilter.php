<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 06.07.2015
 * Time: 22:21
 */

namespace Portal\Form\InputFilter;


use Zend\InputFilter\InputFilter;

class ChangePasswordInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->addPassword1();
        $this->addPassword2();
    }

    public function addPassword1()
    {
        $this->add(array(
            'name' => 'password1',
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
                        'min' => 8,
                        'message' => 'Das Passwort muss mindestens 8 Zeichen lang sein.',
                    )
                )
            ),
        ));
    }

    public function addPassword2()
    {
        $this->add(array(
            'name' => 'password2',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'callback',
                    'options' => array(
                        'callback' => function ($passwort2, $fields = array())
                        {
                            if (is_array($fields) && array_key_exists("password1", $fields))
                            {
                                return ($passwort2 == $fields["password1"]);
                            }
                            return false;
                        },
                        'message' => 'Die beiden Passwörter sind nicht gleich!',
                    ),
                ),
            ),
        ));
    }
} 