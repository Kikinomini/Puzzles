<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24.03.2016
 * Time: 21:00
 */
namespace Application\Form\InputFilter\CustomValidator;

use Application\Model\Manager\UserManager;
use Application\Model\User;
use Zend\Validator\AbstractValidator;

class UsernameValidator extends AbstractValidator
{

    const INVALID_USERNAME = "invalidUsername";
    const EMPTY_USERNAME = "emptyUsername";
    const USERNAME_TAKEN = "usernameTaken";
    const USERNAME_TOO_LONG = "usernameTooLong";

    private $userManager;

    protected $messageTemplates = array(
        self::INVALID_USERNAME => "Der Username darf nur aus Buchstaben, Zahlen oder den folgenden Zeichen bestehen: -_.&;()#!?$+",
        self::EMPTY_USERNAME => "Der Benutzername darf nicht leer sein.",
        self::USERNAME_TAKEN => "Der Benutzername ist bereits vergeben.",
        self::USERNAME_TOO_LONG => "Der Benutzername ist zu lang",
    );

    public function __construct(UserManager $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws \Zend\Validator\Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $user = $this->userManager->getUserFromSession();
        $regexValidator = new \Zend\Validator\Regex("/^" . User::USERNAME_ALLOWED_REGEX . "/i");
        if (trim($value) == "") {
            $this->error(self::EMPTY_USERNAME);
            return false;
        }
        if (strlen($value) > 255)
        {
            $this->error(self::USERNAME_TOO_LONG);
            return false;
        }
        if (!$regexValidator->isValid($value))
        {
            $this->error(self::INVALID_USERNAME);
            return false;
        }
        if ($user->getUsername() != $value && !$this->userManager->usernameIsFree($value))
        {
            $this->error(self::USERNAME_TAKEN);
            return false;
        }
        return true;
    }


}