<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25.03.2016
 * Time: 16:47
 */

namespace Application\Form\InputFilter;


use Application\Form\InputFilter\ChangePasswordValidator\NewPasswordValidator;
use Application\Form\InputFilter\ChangePasswordValidator\OldPasswordValidator;
use Application\Model\Manager\UserManager;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class ChangePasswordInputFilter extends InputFilter
{
    /** @var  UserManager */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;

        $this->addOldPasswordInputFilter();
        $this->addNewPasswordInputFilter();
    }


    private function addOldPasswordInputFilter()
    {
        $inputFilter = new Input("oldPassword");
        $inputFilter->getValidatorChain()
            ->attach(new OldPasswordValidator($this->userManager));
        $this->add($inputFilter);
    }

    private function addNewPasswordInputFilter()
    {
        $inputFilter = new Input("newPassword1");
        $inputFilter->getValidatorChain()
            ->attach(new NewPasswordValidator());
        $this->add($inputFilter);
    }
} 