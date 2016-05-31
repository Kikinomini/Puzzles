<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 22.10.14
 * Time: 15:48
 */

namespace Application\Model;

use Zend\Mime\Message;
use Zend\Mime\Mime;
use Zend\Mime\Part;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;

class SmtpMail
{
    private $smtpOptions;
    private $empfaengerEmail;
    private $senderEmail;
    private $empfaengerName;
    private $senderName;
    private $title;
    private $ueberschrift;
    private $allowReply;
    private $nachricht;

    private $systemvariablen;

    private $filesFromStrings;

    private $serverUrl;


    public function __construct($smtpOptions, $sender, $systemvariablen, $serverUrl)
    {
        $this->smtpOptions = $smtpOptions;
        $this->serverUrl = $serverUrl;
        $this->systemvariablen = $systemvariablen;

        $this->empfaengerEmail = "";
        $this->senderEmail = $sender;
        $this->nachricht = "";
        $this->betreff = "Ju-Feg-Le Mail";
        $this->empfaengerName = "";
        $this->senderName = "";
        $this->title = "Ju-FeG-Le-Mail";
        $this->ueberschrift = "";
        $this->allowReply = false;

        $this->filesFromStrings = array();
    }
    /**
     * @return boolean
     */
    public function isAllowReply()
    {
        return $this->allowReply;
    }

    /**
     * @param boolean $allowReply
     */
    public function setAllowReply($allowReply)
    {
        $this->allowReply = $allowReply;
    }

    /**
     * @return string
     */
    public function getUeberschrift()
    {
        return $this->ueberschrift;
    }

    /**
     * @param string $ueberschrift
     */
    public function setUeberschrift($ueberschrift)
    {
        $this->ueberschrift = $ueberschrift;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getEmpfaengerName()
    {
        return $this->empfaengerName;
    }

    /**
     * @param mixed $empfaengerName
     */
    public function setEmpfaengerName($empfaengerName)
    {
        $this->empfaengerName = $empfaengerName;
    }

    /**
     * @return mixed
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param mixed $senderName
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    private $betreff;

    /**
     * @return mixed
     */
    public function getBetreff()
    {
        return $this->betreff;
    }

    /**
     * @param mixed $betreff
     */
    public function setBetreff($betreff)
    {
        $this->betreff = $betreff;
    }

    /**
     * @return string
     */
    public function getEmpfaengerEmail()
    {
        return $this->empfaengerEmail;
    }

    /**
     * @param string $empfaenger
     */
    public function setEmpfaengerEmail($empfaenger)
    {
        $this->empfaengerEmail = $empfaenger;
    }

    /**
     * @return string
     */
    public function getNachricht()
    {
        return $this->nachricht;
    }

    /**
     * @param string $nachricht
     */
    public function setNachricht($nachricht)
    {
        $this->nachricht = $nachricht;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param mixed $sender
     */
    public function setSenderEmail($sender)
    {
        $this->senderEmail = $sender;
    }

    /**
     * @return array
     */
    public function getFilesFromStrings()
    {
        return $this->filesFromStrings;
    }

    /**
     * @param array $fileFromString
     */
    public function addFileFromString($fileFromString)
    {
        if (is_array($fileFromString) && isset($fileFromString["content"]) && isset($fileFromString["name"])) {
            $this->filesFromStrings[] = $fileFromString;
        }
    }
    public function send()
    {
        $emailValidator = new EmailAddress(Hostname::ALLOW_DNS | Hostname::ALLOW_LOCAL); //TODO ALLOW_LOCAL entfernen

        if ($emailValidator->isValid($this->senderEmail) && $emailValidator->isValid($this->empfaengerEmail)) {
            $message = "
	<!DOCTYPE html>
    <html>
        <head>
            <title>$this->title</title>
            	<meta http-equiv='CONTENT-TYPE' content='text/html' charset='UTF-8'>
        </head>
        <body>
            <span style = 'font-family: Calibri, Arial;'>
                <h1>$this->ueberschrift</h1>
                <br/>
                <br/>
                <p>$this->nachricht</p>
    ";
            if (!$this->allowReply) {
                $message .= "
                <br/>
                <br/>
                <hr/>
                <p><i>De Nachricht wurde automatisch von <a href = '" . $this->serverUrl . "'>".$this->systemvariablen["websiteName"]."</a> erzeugt. Bitte antworten Sie nicht auf diese Email</i></p>
                    ";
            }
            $message .= "
            </span>
        </body>
    </html>";
            $html = new Part($message);
            $html->type = 'text/html; charset=utf-8';
            $mimeMessage = new Message();
            $mimeMessage->addPart($html);

            $contentType = "text/html; charset=utf-8";

            if (count($this->filesFromStrings) > 0) {

                $htmlPart = new Part($mimeMessage->generateMessage());
                $htmlPart->type = "text/html; charset=utf-8";

                $mimeMessage = new Message();
                $mimeMessage->addPart($htmlPart);
                $contentType = "multipart/related";

                foreach ($this->filesFromStrings as $tmpFile) {
                    $attachment = new Part($tmpFile["content"]);
                    $attachment->filename = $tmpFile["name"];
                    $attachment->type = Mime::TYPE_OCTETSTREAM;
                    $attachment->encoding = Mime::ENCODING_BASE64;
                    $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;

                    $mimeMessage->addPart($attachment);
                }
            }

            $empfaengerName = (strlen($this->empfaengerName) > 0) ? $this->empfaengerName : $this->empfaengerEmail;
            $senderName = (strlen($this->senderName) > 0) ? $this->senderName : $this->senderEmail;

            $mail = new \Zend\Mail\Message();
            $mail->setBody($mimeMessage);
            $mail->setFrom($this->senderEmail, $senderName);
            $mail->addTo($this->empfaengerEmail, $empfaengerName);
            $mail->setSubject($this->betreff);
            $mail->setEncoding('UTF-8');
            if (count($this->filesFromStrings) > 0) {
                $mail->getHeaders()->get("content-type")->setType($contentType);
            } else {
                $mail->getHeaders()->removeHeader("Content-type");
                $mail->getHeaders()->addHeaderLine("Content-type: " . $contentType);
            }
            $transport = new \Zend\Mail\Transport\Smtp();
            $options = new \Zend\Mail\Transport\SmtpOptions($this->smtpOptions);
            $transport->setOptions($options);
            $transport->send($mail);
        } else {
            //todo Var_dump entfernen
//            var_dump($this->empfaengerEmail, $this->senderEmail);
        }
    }
}