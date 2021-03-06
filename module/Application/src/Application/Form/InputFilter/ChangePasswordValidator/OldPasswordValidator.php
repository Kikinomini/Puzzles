<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25.03.2016
 * Time: 16:49
 */

namespace Application\Form\InputFilter\ChangePasswordValidator;


use Application\Model\Manager\UserManager;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class OldPasswordValidator extends AbstractValidator
{
    const OLD_PASSWORD_FALSE = "oldPasswordFalse";

    protected $messageTemplates = array(
        self::OLD_PASSWORD_FALSE => "Das alte Passwort stimmt nicht.",
    );

    /** @var  UserManager */
    private $userManager;

    public function __construct(UserManager $userManager, $options = null)
    {
        parent::__construct($options); // TODO: Change the autogenerated stub
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
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $user = $this->userManager->getUserFromSession();
        if (!$this->userManager->checkPassword($value, $user))
        {
            $this->error(self::OLD_PASSWORD_FALSE);
            return false;
        }
        return true;
    }

} 