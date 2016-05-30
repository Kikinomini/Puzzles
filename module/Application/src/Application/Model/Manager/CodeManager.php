<?php


namespace Application\Model\Manager;


use Application\Model\Code;
use Application\Model\Repository\CodeRepository;
use Application\Model\SmtpMail;
use Application\Model\User;
use Zend\View\Helper\Url;

class CodeManager extends StandardManager
{
    const ACTION_VERIFY_NEW_EMAIL = "1";
    const CODE_DEFAULT_LENGTH = 255;

    private static $seedIsGenerated = false;

    /** @var  SmtpMail */
    private $mail;

    /** @var  Url */
    private $urlHelper;

    private $errors;

    private $systemConfig;

    public function __construct(Url $urlHelper, SmtpMail $smtpMail, $systemConfig, CodeRepository $repository, Code $entity = null)
    {
        parent::__construct($repository, $entity);
        $this->urlHelper = $urlHelper;
        $this->mail = $smtpMail;
        $this->errors = array();
        $this->systemConfig = $systemConfig;
    }

    public function generateCode(Code $code = null, $laenge = CodeManager::CODE_DEFAULT_LENGTH)
    {
        /** @var Code $code */
        $code = $this->selectCorrectEntity($code);

        if (!self::$seedIsGenerated)
        {
            mt_srand();
            self::$seedIsGenerated = true;
        }

        $codeString = "";
        for ($n = 0; $n < $laenge; $n++)
        {
            $rand = rand(0, 61);
            if ($rand < 26)
            {
                $codeString .= chr(rand(ord('a'), ord('z')));
            } elseif ($rand < 52)
            {
                $codeString .= chr(rand(ord('A'), ord('Z')));
            } elseif ($rand < 62)
            {
                $codeString .= rand(0, 9);
            }
        }

        $code->setCode($codeString);
    }

    public function sendEmail(User $user, Code $code = null)
    {
        /** @var Code $code */
        $code = $this->selectCorrectEntity($code);

        switch ($code->getAction())
        {
            case 'registration':
            {
                $mail = $this->mail;
                $mail->setAllowReply(false);
                $mail->setBetreff("Registration - ".$this->systemConfig["websiteName"]);
                $mail->setTitle("Registration");
                $mail->setEmpfaengerEmail($user->getEmail());
                $mail->setEmpfaengerName($user->getVorname());

                $message = "Hallo ".$user->getVorname()." ".$user->getNachname().", <br/><br/><p>Sie haben sich auf ".$this->systemConfig["websiteName"]." registriert. Um die Registrierung abzuschliesen, drücken Sie bitte auf <a href = '".$this->urlHelper->__invoke("code", array('code' => $code->getCode()), array('force_canonical' => true))."'>diesen Link</a></p>";
                $mail->setNachricht($message);
                $mail->send();
                break;
            }
            case 'changePassword':
            {
                $mail = $this->mail;
                $mail->setAllowReply(false);
                $mail->setBetreff("Passwort vergessen - ".$this->systemConfig["websiteName"]);
                $mail->setTitle("Passwort vergessen");
                $mail->setEmpfaengerEmail($user->getEmail());
                $mail->setEmpfaengerName($user->getVorname());

                $message = "Hallo ".$user->getVorname()." ".$user->getNachname().", <br/><br/><p>Sie haben auf ".$this->systemConfig["websiteName"]." ein neues Passwort angefordert. Um das Passwort zu ändern, drücken Sie bitte auf <a href = '".$this->urlHelper->__invoke("changePasswordFromMail", array('code' => $code->getCode()), array('force_canonical' => true))."'>diesen Link</a></p>";
                $mail->setNachricht($message);
                $mail->send();
                break;
            }
            case CodeManager::ACTION_VERIFY_NEW_EMAIL:
            {
                $mail = $this->mail;
                $mail->setAllowReply(false);
                $mail->setBetreff("Email ändern - ".$this->systemConfig["websiteName"]);
                $mail->setTitle("Email ändern");
                $mail->setEmpfaengerEmail($code->getWert());
                $mail->setEmpfaengerName($user->getVorname());

                $message = "Hallo ".$user->getVorname()." ".$user->getNachname().", <br/><br/><p>Sie haben auf ".$this->systemConfig["websiteName"]." Ihre Emailadresse geändert. Um Ihre neue Emailadresse zu bestätigen, drücken Sie bitte auf <a href = '".$this->urlHelper->__invoke("code", array('code' => $code->getCode()), array('force_canonical' => true))."'>diesen Link</a></p>";
                $mail->setNachricht($message);
                $mail->send();
                break;
            }
        }
    }

    private function getChangeEmailCode(User $user)
    {
        $oldCodes = $user->getCodes();
        /** @var Code $oldCode */
        foreach ($oldCodes as $oldCode)
        {
            if ($oldCode->getAction() == CodeManager::ACTION_VERIFY_NEW_EMAIL)
            {
                return $oldCode;
                break;
            }
        }
        return null;
    }

    public function newChangeEmailCode(User $user, $length = CodeManager::CODE_DEFAULT_LENGTH)
    {
        $code = $this->getChangeEmailCode($user);
        if ($code == null)
        {
            $code = new Code();
            $code->setAction(CodeManager::ACTION_VERIFY_NEW_EMAIL);
            $code->setUser($user);
            $user->getCodes()->add($code);
        }
        $this->generateCode($code, $length);

        return $code;
    }

    public function remove(Code $code = null)
    {
        $code = $this->selectCorrectEntity($code);
        $this->repository->remove($code);
    }

    public function getCodeByCode($code)
    {
        $this->entity = $this->repository->findOneBy(array('code' => $code));
        return $this->entity;
    }


    public function newEmailCodeHasEmailChanged(User $user, $newEmail)
    {
        $code = $this->getChangeEmailCode($user);
        if ($code != null)
        {
            return (trim($code->getWert()) != trim($newEmail));
        }
        return (trim($newEmail) != "");
    }

    public function activateCode(Code $code = null)
    {
        /** @var Code $code */
        $code = $this->selectCorrectEntity($code);

        if ($code == null)
        {
            $message = false;
            $this->errors[] = "ERROR: Code not valid";
            return $message;
        }
        if($code->getAction() == "registration") {

            /** @var User $user */
            $user = $code->getUser();
            $user->setAktiviert(true);
            $this->save($code);
            $this->remove($code);

            $message = "Sie wurden erfolgreich aktiviert.";
        }
        elseif ($code->getAction() == CodeManager::ACTION_VERIFY_NEW_EMAIL)
        {
            $code->getUser()->setEmail($code->getWert());
            $this->save($code);
            $this->remove($code);

            $message = "Die Email wurde erfolgreich geändert";
        }
//        elseif ($code->getAction() == "changePassword")
//        {
//            /** @var User $user */
//            $user = $code->getUser();
//            $user->setAktiviert(true);
//            $this->save($code);
//            $this->remove($code);
//        }
        else
        {
            $message = false;
            $this->errors[] = "ERROR: Code not valid";
        }
        return $message;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
}