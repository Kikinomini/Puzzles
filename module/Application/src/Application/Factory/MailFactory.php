<?php

namespace Application\Factory;

use Application\Model\SmtpMail;
use Zend\Http\Request;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\BasePath;
use Zend\View\Helper\Url;

class MailFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $request = $sm->get("Request");
        /** @var BasePath $basePath */
        $basePath = $sm->get("viewHelperManager")->get("basePath");
        if ($request instanceof Request) {
            $uri = $request->getUri();
            $url = $uri->getScheme() . "://" . $uri->getHost() . $basePath->__invoke();
        }
        else {
            $url = "";
        }
        $config = $sm->get('config');
        /** @var BasePath $basePath */
        $mail = new SmtpMail($config['mailEinstellungen']['options'], $config['mailEinstellungen']['sender'], $config["systemvariablen"], $url);
        return $mail;
    }
}