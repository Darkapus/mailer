<?php
namespace Mailer;

class Smtp extends \Zend\Mail\Transport\Smtp{
    public static $instance = null;
    
    public static function i(){
        if(is_null(self::$instance)){
            self::$instance = new Smtp();
        }
        return self::$instance;
    }
    
    public function __construct(){
        $options = new \Zend\Mail\Transport\SmtpOptions();
		$options->setHost(Config::SMTP_HOST);
		$options->setPort(Config::SMTP_PORT);
		
		parent::__construct($options);
		
		$auth = new \Zend\Mail\Protocol\Smtp\Auth\Login();
		$auth->setUsername(Config::SMTP_LOGIN);
		$auth->setPassword(Config::SMTP_PWD);
		$auth->connect();
		$this->setConnection($auth);
    }
    
    public function sendmail($from, $to, $subject, $content){
		$body = new \Zend\Mime\Message();

		$part = new \Zend\Mime\Part($content);
		$part->type = 'text/html';

		$body->addPart($part);

		$message = new \Zend\Mail\Message();
		$message->setFrom($from);
		$message->setBody($body);
		$message->setTo($to);
		$message->setSubject($subject);

        $this->send($message);
	}
}