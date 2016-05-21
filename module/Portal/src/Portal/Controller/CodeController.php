<?php

namespace Portal\Controller;


use Application\Model\Code;
use Application\Model\Manager\CodeManager;
use Application\Model\Manager\UserManager;
use Application\Model\User;
use Bookbinder\Model\ExternalReader;
use Bookbinder\Model\Manager\ExternalReaderManager;
use Bookbinder\Model\Reader;
use TelegramBot\Model\Manager\BotManager;
use TelegramBot\Model\Manager\UserChatManager;
use TelegramBot\Model\UserChat;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CodeController extends AbstractActionController
{
    public function codeAction()
    {
        $code = $this->params('code');
        /** @var CodeManager $codeManager */
        $codeManager = $this->getServiceLocator()->get('codeManager');
        $code = $codeManager->getCodeByCode($code);

        if ($code instanceof Code) {
            switch ($code->getAction()) {
                case "bookbinderExternalReader": {
                    return $this->externalReaderCode($code);
                }
                case "telegramBotConnectUser":
                {
                    return $this->telegramBotConnectUser($code);
                }
            }
        }

        $message = $codeManager->activateCode();
        if ($message != false) {
            $codeManager->remove();
            $this->flashMessenger()->addSuccessMessage($message);
            return $this->redirect()->toRoute('home');
        } else {
            $errors = $codeManager->getErrors();
            foreach ($errors as $error) {
                $this->flashMessenger()->addErrorMessage($error);
            }
        }
        return;
    }

    public function externalReaderCode(Code $code)
    {
        /** @var ExternalReaderManager $readerManager */
        $readerManager = $this->getServiceLocator()->get("Bookbinder.externalReaderManager");

        if ($code->getAction() == "bookbinderExternalReader") {
            /** @var ExternalReader $reader */
            $reader = $readerManager->getExternalReaderByCode($code);
            if ($reader->getActivatedDevices() < $reader->getNumberDevices()) {
                $cookieValue = array();
                if (isset($_COOKIE) && isset($_COOKIE["bookbinderReader"])) {
                    $cookieValue = json_decode($_COOKIE["bookbinderReader"], true);
                }
                if (!isset($cookieValue[$reader->getBook()->getId()]) || $cookieValue[$reader->getBook()->getId()] != $code->getCode()) {
                    $reader->setActivatedDevices($reader->getActivatedDevices() + 1);
                    $readerManager->save($reader);

                    $cookieValue[$reader->getBook()->getId()] = $code->getCode();
                    setcookie("bookbinderReader", json_encode($cookieValue), time() + 60 * 60 * 24 * 365 * 2, '/', NULL, NULL, true);
                }
            }


            return $this->redirect()->toRoute("Bookbinder/bookOverview/externalReader", array('bookId' => $reader->getBook()->getId()));
        }
        return $this->redirect()->toRoute("home");
    }

    public function telegramBotConnectUser(Code $code)
    {
        /** @var UserManager $userManager */
        $userManager = $this->getServiceLocator()->get("userManager");
        $user = $userManager->getUserFromSession();

        /** @var UserChatManager $userChatManager */
        $userChatManager = $this->getServiceLocator()->get("TelegramBot.userChatManager");

        /** @var CodeManager $codeManager */
        $codeManager = $this->getServiceLocator()->get('codeManager');

        /** @var BotManager $botManager */
        $botManager = $this->getServiceLocator()->get('TelegramBot.botManager');

        if ($user instanceof User) {
            $userChatId = $code->getWert();
            $userChat = $userChatManager->getEntityById($userChatId);
            if ($userChat instanceof UserChat)
            {
                $userChat->setUser($user);
                $userChatManager->save($userChat);

                $botManager->getAllBots();
                $bot = $botManager->getBotByUsername($userChat->getBotName());
                $bot->sendMessage($userChat->getUserChatId(), "Dein Account wurde erfolgreich verbunden. Dein Username ist '".$user->getUsername()."'. Wenn das nicht stimmt, wende dich bitte an einen Admin.");

                $this->flashMessenger()->addSuccessMessage("Dein Account wurde erfolgreich verbunden.");
            }
            else
            {
                $this->flashMessenger()->addErrorMessage("Dein Account konnte nicht verknüpft werden. Bitte versuche es erneut.");
            }
            $codeManager->removeEntity($code);

            return $this->redirect()->toRoute("home");
        }

        $this->getResponse()->setStatusCode(403);
        $this->getEventManager()->trigger('dispatchError', 'Module', $this->getEvent());
        return;
    }
}