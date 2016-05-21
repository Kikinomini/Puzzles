<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25.03.2016
 * Time: 10:09
 */

namespace Application\Form\InputFilter\CustomValidator;


use Application\Model\Manager\UserManager;
use Zend\Validator\AbstractValidator;
use Zend\Validator\EmailAddress;
use Zend\Validator\Exception;

class EmailValidator extends AbstractValidator{

    const NOT_A_VALID_EMAIL = "emailNotValid";
    const EMAIL_TAKEN = "emailTaken";
    const EMAIL_TOO_LONG = "emailTooLong";

    /** @var  UserManager */
    private $userManager;

    protected $messageTemplates = array(
        EmailValidator::NOT_A_VALID_EMAIL => "Die Emailadresse ist keine gültige Emailadresse.",
        EmailValidator::EMAIL_TAKEN => "Die Email ist bereits vergeben.",
        self::EMAIL_TOO_LONG => "Die Emailadresse darf maximal 255 Zeichen lang sein."
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
     * @param  mixed $email
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($email)
    {
        $emailValidator = new EmailAddress();
        $emailValidator->setOptions(array(
            'useDomainCheck' => false,
        ));

        if (strlen($email) > 255)
        {
            $this->error(self::EMAIL_TOO_LONG);
            return false;
        }

        if (!$emailValidator->isValid($email))
        {
            $this->error(EmailValidator::NOT_A_VALID_EMAIL);
            return false;
        }
        if (!$this->userManager->emailIsFree($email))
        {
            $this->error(EmailValidator::EMAIL_TAKEN);
            return false;
        }
        return true;
    }


} 