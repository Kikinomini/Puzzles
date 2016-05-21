<?php

namespace Application\Factory\Model\Manager;

use Application\Model\Manager\CodeManager;
use Application\Model\SmtpMail;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\Url;

class CodeManagerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var SmtpMail $mail */
        $mail = $serviceLocator->get('mail');
        $config = $serviceLocator->get('config');
        /** @var EntityManager $em */
        $em = $serviceLocator->get('doctrine.entitymanager.custom');

//        /** @var BookManager $bookManager */
//        $bookManager = $serviceLocator->get("Bookbinder.bookManager");
        /** @var Url $urlHelper */
        $urlHelper = $serviceLocator->get('ViewHelperManager')->get('url');

        return new CodeManager($urlHelper, $mail, $config["systemvariablen"], $em->getRepository('\Application\Model\Code'));
    }
} 