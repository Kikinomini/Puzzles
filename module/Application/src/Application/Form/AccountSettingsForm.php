<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 19.03.2016
 * Time: 14:07
 */

namespace Application\Form;

use Application\Form\Hydrator\AccountSettingsHydrator;
use Application\Form\InputFilter\AccountSettingsInputFilter;
use Application\Model\Manager\UserManager;
use Zend\Form\Element\Email;
use Zend\Form\Element\Text;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class AccountSettingsForm extends MyForm{
    /** @var  UserManager */
    private $userManager;

    public function __construct(UserManager $userManager, FlashMessenger $flashMessenger = null, $name = null, $options = array())
    {
        $this->userManager = $userManager;
        parent::__construct($flashMessenger, $name, $options);
    }


    public function addElements()
    {
        $firstName = new Text("firstName");
        $firstName->setLabel("Vorname");
        $this->add($firstName);

        $actualEmailAddress = new Email("actualEmailAddress");
        $actualEmailAddress->setLabel("Aktuelle Emailadresse");
        $actualEmailAddress->setAttribute("readonly", "true");
        $this->add($actualEmailAddress);

        $lastName = new Text("lastName");
        $lastName->setLabel("Nachname");
        $this->add($lastName);

        $newEmailAddress = new Email("newEmailAddress");
        $newEmailAddress->setLabel("Neue Emailadresse");
        $newEmailAddress->setAttribute("required", false);
        $this->add($newEmailAddress);

        $username = new Text("username");
        $username->setLabel("Username");
        $this->add($username);

        $this->addSubmitButton("Speichern");
    }

    public function addEssentials()
    {
        $this->setHydrator(new AccountSettingsHydrator());
        $this->setInputFilter(new AccountSettingsInputFilter($this->userManager));
    }
} 