<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25.03.2016
 * Time: 16:59
 */

namespace Application\Form\InputFilter\ChangePasswordValidator;


use Zend\Validator\AbstractValidator;
use Zend\Validator\Callback;
use Zend\Validator\Exception;

class NewPasswordValidator extends AbstractValidator {

    const PASSWORD_TOO_SHORT = "passwordTooShort";
    const PASSWORDS_NOT_IDENTICALLY = "passwordsNotIdentically";

    protected $messageTemplates = array(
        self::PASSWORD_TOO_SHORT => "Das Passwort muss mindestens 8 Zeichen lang sein.",
        self::PASSWORDS_NOT_IDENTICALLY => "Die beiden Passwörter stimmen nicht überein.",
    );

    public function isValid($value, $context = null)
    {
        if (strlen($value) < 8)
        {
            $this->error(self::PASSWORD_TOO_SHORT);
            return false;
        }

        if ($value != $context["newPassword2"])
        {
            $this->error(self::PASSWORDS_NOT_IDENTICALLY);
            return false;
        }
        return true;

        return true;
    }


}