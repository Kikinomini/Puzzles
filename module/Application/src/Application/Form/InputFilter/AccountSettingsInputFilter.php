<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24.03.2016
 * Time: 20:42
 */

namespace Application\Form\InputFilter;

use Application\Form\InputFilter\CustomValidator\EmailValidator;
use Application\Form\InputFilter\CustomValidator\UsernameValidator;
use Application\Model\Manager\UserManager;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class AccountSettingsInputFilter extends InputFilter{

    /** @var  UserManager */
    private $userManager;

    public function __construct($userManager)
    {
        $this->userManager = $userManager;

        $this->addUsernameInputFilter();
        $this->addNewEmailInputFilter();
        $this->addFirstNameInputFilter();
        $this->addLastNameInputFilter();
    }

    private function addUsernameInputFilter()
    {
        $inputFilter = new Input("username");
        $inputFilter->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new UsernameValidator($this->userManager));
        $this->add($inputFilter);
    }

    private function addNewEmailInputFilter()
    {
        $inputFilter = new Input("newEmailAddress");
        $inputFilter->setRequired(false);
        $inputFilter->setAllowEmpty(true);
        $inputFilter->getValidatorChain()
            ->attach(new EmailValidator($this->userManager));
        $this->add($inputFilter);
    }

    private function addFirstNameInputFilter()
    {
        $inputFilter = new Input("firstName");
        $inputFilter->getValidatorChain()
            ->attach(new StringLength(
                array(
                    'min' => 2,
                    'max' => 255,
                    'message' => "Der Vorname muss mindestens zwei Zeichen lang und darf maximal 255 Zeichen lang sein.",
                )
            ));
        $this->add($inputFilter);
    }

    private function addLastNameInputFilter()
    {
        $inputFilter = new Input("lastName");
        $inputFilter->getValidatorChain()
            ->attach(new StringLength(
                array(
                    'min' => 2,
                    'max' => 255,
                    'message' => "Der Nachname muss mindestens zwei Zeichen lang und darf maximal 255 Zeichen lang sein.",
                )
            ));
        $this->add($inputFilter);
    }
} 