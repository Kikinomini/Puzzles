<?php

namespace Portal\Controller;

use Application\Model\Code;
use Application\Model\Manager\CodeManager;
use Application\Model\Manager\UserManager;
use Application\Model\User;
use Portal\Form\ChangePasswordForm;
use Portal\Form\LoginForm;
use Portal\Form\NewPasswordForm;
use Portal\Form\RegistrationForm;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function loginAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $loginForm = new LoginForm();
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');

        $sessionContainer = new Container("loginTarget");
        $url = ($sessionContainer->offsetExists("loginTarget"))?$sessionContainer->offsetGet("loginTarget"):false;
        $followTarget = $this->params("followTarget");

        if ($request->isPost()) {
            $postData = $request->getPost();
            $loginForm->setData($postData);
            if ($loginForm->isValid()) {
                /** @var User $user */
                $user = $userManager->getUserByEmail($postData["email"]);
                if ($user != null && $userManager->login($postData["passwort"], $postData["autologin"], $user)) {
                    $this->flashMessenger()->addSuccessMessage("Erfolgreich eingeloggt.");
                    if ($followTarget == true && $url != false)
                    {
                        return $this->redirect()->toUrl($url);
                    }
                    return $this->redirect()->toRoute('home');
                } else {
                    $this->flashMessenger()->addErrorMessage("Entweder stimmt das Passwort oder die Email nicht.");
                }
            }
        }

        $viewModel = new ViewModel(array('form' => $loginForm, "followTarget" => $followTarget));
        return $viewModel;
    }

    public function resendRegistrationCodeAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get("userManager");
        $user = $userManager->getUserFromSession();
        
        $codes = CodeManager::filterByAction($user->getCodes(), CodeManager::ACTION_REGISTRATION);
        if ($codes->count() >= 1)
        {
            /** @var CodeManager $codeManager */
            $codeManager = $this->getServiceLocator()->get("codeManager");
            $codeManager->sendEmail($user, $codes->get(0));
			$returnValue = array(
				'emailSend' => true,
			);
        }
        else
        {
			$returnValue = array(
				'emailSend' => true,
				'failReason' => 'Ihnen konnte nicht erneut eine Email zugesendet werden. Bitte versuchen Sie es später erneut',
			);
			if ($user->getAktiviert())
			{
				$returnValue["failReason"] = "Ihr User ist bereits aktiviert";
			}

		}
		$viewModel = new ViewModel(array("json" => $returnValue));
		$viewModel->setTemplate("ajax/json");
		return $viewModel;
    }

    public function logoutAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');
        $user = $userManager->getUserFromSession();
        if ($userManager->logout()) {
            if ($user instanceof User) {
                $this->flashMessenger()->addSuccessMessage("Sie wurden erfolgreich ausgeloggt.");
            }
        } else {
            $this->flashMessenger()->addErrorMessage("Es gab ein Problem. Sie konnten nicht ausgeloggt werden.");
        }
        return $this->redirect()->toRoute('home');
    }

    public function registrationAction()
    {
        /** @var UserManager $userManager */
        $userManager = $this->serviceLocator->get('userManager');
        $registrationForm = new RegistrationForm(
            $userManager,
            $this->getServiceLocator()->get('viewHelperManager')->get('url')->__invoke("showAgb")
        );
        $user = new User();

        $sessionContainer = new Container("loginTarget");
        $url = ($sessionContainer->offsetExists("loginTarget"))?$sessionContainer->offsetGet("loginTarget"):false;
        $followTarget = $this->params("followTarget");

        $registrationForm->bind($user);
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();
            $registrationForm->setData($postData);
            if ($registrationForm->isValid()) {
                $userManager->registrateUser($postData["passwort1"], $user);
                $userManager->login($postData["passwort1"], false, $user);
                $this->flashMessenger()->addSuccessMessage("Ihr User wurde erfolgreich angelegt. Bitte bestätigen Sie die Registrierung durch einen Klick auf dem Link, den wir Ihnen an deine Emailadresse gesendet haben.");
                if ($followTarget == true && $url != false)
                {
                    return $this->redirect()->toUrl($url);
                }
                return $this->redirect()->toRoute('home');
            } else {
                $data["passwort1"] = "";
                $data["passwort2"] = "";
                $data["agb"] = "";
                $registrationForm->setData($data);

                $invalidInput = $registrationForm->getInputFilter()->getInvalidInput();
                foreach ($invalidInput as $invalid) {
                    $messages = $invalid->getMessages();
                    foreach ($messages as $message) {
                        $this->flashMessenger()->addErrorMessage($message);
                    }
                }
            }
        }
        return new ViewModel(
            array('form' => $registrationForm)
        );
    }

    public function newPasswordAction()
    {
        $form = new NewPasswordForm();
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost();
            $form->setData($postData);
            if ($form->isValid()) {
                $user = $userManager->getUserByEmail($postData["email"]);
                if ($user instanceof User) {
                    $userManager->userForgotPassword($user);
                    $this->flashMessenger()->addSuccessMessage("Eine Email mit einem Link wurde an Sie verschickt. Mit dem Link können Sie Ihr Passwort zurücksetzen.");
                } else {
                    $this->flashMessenger()->addErrorMessage("Einen User mit der Emailadresse gibt es nicht.");
                }
            } else {
                $this->flashMessenger()->addErrorMessage("Das ist keine gültige Email");
            }
        }
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function changePasswordFromMailAction()
    {
        $code = $this->params("code");
        /** @var CodeManager $codeManager */
        $codeManager = $this->getServiceLocator()->get("codeManager");

        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get('userManager');

        $code = $codeManager->getCodeByCode($code);

        if (!($code instanceof Code) || $code->getAction() != "changePassword") {
            $this->getResponse()->setStatusCode(404);
            return $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        }

        /** @var User $user */
        $user = $code->getUser();

        $form = new ChangePasswordForm();
        $form->bind($user);

        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $form->setData($postData);
            if ($form->isValid())
            {
                $userManager->updatePassword($user->getPassword(), $user);
                $userManager->save($user);
                $codeManager->remove($code);

                $this->flashMessenger()->addSuccessMessage("Dein Passwort wurde erfolgreich geändert");
                return $this->redirect()->toRoute("home");
            }
            else
            {
                $data["password1"] = "";
                $data["password2"] = "";
                $form->setData($data);

                $invalidInput = $form->getInputFilter()->getInvalidInput();
                foreach ($invalidInput as $invalid) {
                    $messages = $invalid->getMessages();
                    foreach ($messages as $message) {
                        $this->flashMessenger()->addErrorMessage($message);
                    }
                }
            }
        }
        return new ViewModel(array(
            'form' => $form,
            'code' => $code,
        ));
    }
}