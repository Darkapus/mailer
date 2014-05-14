<?php
namespace Mailer;

class Imap extends \Zend\Mail\Storage\Imap{
    public static $instance = null;
    public static function i(){
        if(is_null(self::$instance)){
            self::$instance = new Imap();
        }
        return self::$instance;
    }
    
    public function __construct(){
        $this->imap = parent::__construct(array('user'=>Config::IMAP_LOGIN, 'password'=>Config::IMAP_PWD, 'ssl'=>Config::IMAP_SSL, 'port'=>Config::IMAP_PORT, 'host'=>Config::IMAP_HOST));
    }
    /**
     * get mails into folder
     */
    public function getMails($folder){
        $this->selectFolder($folder);
		$array = array();
		foreach($this as $id=>$mail){
			$flags      = $mail->getFlags();
			$o          = new \stdClass();
   		    $o->id      = $id;
			$o->from    = ( $mail->getHeaders()->get('from')->getFieldValue());
			$o->subject = ( $mail->getHeaders()->get('subject')->getFieldValue());
			$o->date    = new \DateTime( $mail->getHeaders()->get('date')->getFieldValue());
			$o->date    = $o->date->format('Y-m-d H:i:s');
			$o->seen    = $mail->hasFlag('\Seen')?'read':'unread';
			$o->file    = false;
			$o->folder  = $folder;
			$array[] = $o;
		}
		return $array;
	}
	/**
	 * get recursive folders
	 */
	public function getTreeFolders(){
        $folders = array();
		foreach($this->getFolders() as $folder){
		  $folders[$folder->getGlobalName()] = $folder->getLocalName();
		}
		return $folders;
	}
	/**
	 * save into sent directory
	 */
	public function save($content){
		// on sauvegarde le mail
		$this->appendMessage($content, Config::IMAP_SENT_DIR);
	}
	/**
	 * @return html or plain
	 */
	public function getFormatedMessage($id){
		
		$message    = new FormatedMessage($this->getMessage($id));
		echo $message->getContent();
		exit;
	}
}