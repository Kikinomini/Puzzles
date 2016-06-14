<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 29.01.15
 * Time: 20:51
 */

namespace Portal\Form\InputFilter;


use Application\Model\Manager\UserManager;
use Application\Model\User;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

class RegistrationInputFilter extends InputFilter
{
	/** @var  UserManager */
	private $userManager;

	public function __construct(UserManager $userManager)
	{
		$this->userManager = $userManager;

		$this->addVorname();
		$this->addNachname();
		$this->addEmail();
		$this->addGeburtsdatum();
		$this->addUsername();
		$this->addPasswort1();
		$this->addAgb();
		$this->addPasswort2();
	}

	public function addUsername()
	{
		$this->add(array(
			'name' => 'username',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'not_empty',
					'options' => array(
						'message' => "Der Username darf nicht leer sein.",
					)
				),
				array(
					'name' => 'Regex',
					'options' => array(
						'pattern' => "/^" . User::USERNAME_ALLOWED_REGEX . "/i",
						'message' => "Der Username darf nur aus Buchstaben, Zahlen oder den folgenden Zeichen bestehen: -_.&;()#!?$+",
					)
				),
				array(
					'name' => 'callback',
					'options' => array(
						'callback' => function ($username)
						{
							return $this->userManager->usernameIsFree($username);
						},
						'message' => "Der Username ist schon vergeben. Bitte wähle einen anderen.",
					),
				),
			),
		));
	}

	public function addAgb()
	{
		$this->add(array(
			'name' => 'agb',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'digits',
					'breack_chain_on_failure' => true,
					'options' => array(
						'message' => 'Die AGB müssen akzeptiert werden.',
					)
				),
			),
		));
	}

	public function addVorname()
	{
		$this->add(array(
			'name' => 'vorname',
			'required' => true,
			'validators' => array(
//				array(
//					'name' => 'not_empty',
//					'options' => array(
//						'message' => 'Der Vorname darf nicht leer sein.',
//					)
//				),
				array(
					'name' => 'string_length',
					'options' => array(
						'min' => 2,
						'max' => 255,
						'message' => "Der Vorname muss mindestens zwei Zeichen lang und darf maximal 255 Zeichen lang sein.",
//						'messages' => array(
//							StringLength::TOO_SHORT => 'Der Vorname muss mindestens 2 Zeichen lang sein.',
//							StringLength::TOO_LONG => 'Der Vorname ist zu lang.',
//						)
					)
				)
			),
		));
	}

	public function addNachname()
	{
		$this->add(array(
			'name' => 'nachname',
			'required' => true,
			'validators' => array(
//				array(
//					'name' => 'not_empty',
//					'options' => array(
//						'message' => 'Der Nachname darf nicht leer sein.',
//					)
//				),
				array(
					'name' => 'string_length',
					'options' => array(
						'min' => 2,
						'max' => 255,
						'message' => "Der Nachname muss mindestens zwei Zeichen lang und darf maximal 255 Zeichen lang sein.",
//						'messages' => array(
//							StringLength::TOO_SHORT => 'Der Nachname muss mindestens zwei Zeichen lang sein.',
//							StringLength::TOO_LONG => 'Der Nachname ist zu lang.',
//						)
					)
				)
			),
		));
	}

	public function addPasswort1()
	{
		$this->add(array(
			'name' => 'passwort1',
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

	public function addPasswort2()
	{
		$this->add(array(
			'name' => 'passwort2',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'callback',
					'options' => array(
						'callback' => function ($passwort2, $fields = array())
						{
							if (is_array($fields) && array_key_exists("passwort1", $fields))
							{
								return ($passwort2 == $fields["passwort1"]);
							}
							return false;
						},
						'message' => 'Die beiden Passwörter sind nicht gleich!',
					),
				),
			),
		));
	}

	public function addGeburtsdatum()
	{
		$this->add(array(
			'name' => 'geburtsdatum',
			'required' => true,
			'validators' => array(
//				array(
//					'name' => 'not_empty',
//					'options' => array(
//						'message' => 'Das Geburtsdatum darf nicht leer sein.',
//					)
//				),
				array(
					'name' => 'date',
					'options' => array(
						'format' => "d.m.Y",
						'message' => "Das Geburtsdatum scheint kein Datum zu sein. (dd.mm.yyyy)",
//						'messages' => array(
//							Date::FALSEFORMAT => "Das Format des Geburtsdatum ist falsch. (dd.mm.yyyy)",
//						)
					)
				)
			),
		));
	}

	public function addEmail()
	{
		$this->add(array(
			'name' => 'email',
			'required' => true,
			'validators' => array(
//				array(
//					'name' => 'not_empty',
//					'options' => array(
//						'message' => 'Die Email darf nicht leer sein.',
//					)
//				),
				array(
					'name' => 'emailAddress',
					'options' => array(
						'useDomainCheck' => false,
						'message' => "Das ist keine gültige Emailadresse.",
					)
				),
				array(
					'name' => 'callback',
					'options' => array(
						'callback' => function ($email)
						{
							return $this->userManager->emailIsFree($email);
						},
						'message' => "Es gibt schon einen Account mit der Emailadresse.",
					),
				),
			),
		));
	}
}