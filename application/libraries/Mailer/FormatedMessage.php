<?php
namespace Mailer;
class FormatedMessage{
    private $message = null;
    
    public function __construct(\Zend\Mail\Storage\Message $message){
        $this->message = $message;
    }
    public function getMessage(){
        return $this->message;
    }
    public function getContent(){
        $parts = $this->getAllParts();
        
        if(array_key_exists('html', $parts)){
			$part = $parts['html'];
			return $this->getUnencodedPart($part);
		}
		elseif(array_key_exists('plain', $parts)){
			$part = $parts['plain'];
			return nl2br($this->getUnencodedPart($part));
		}
		
		
    }
    
    private function getUnencodedPart($part){
        $content = $part->getContent();
        var_dump($this->getPartEncodage($part));
        switch($this->getPartEncodage($part)){
            case 'base64':
                $content = base64_decode($content);
                break;
            case 'quoted-printable':
                $content = quoted_printable_decode($content);
                break;
            case '7bit':
                $content = imap_qprint($content);
                break;
            default:
                $content = $content;
                break;
        }
        return $content;
    }
    private function getPartEncodage($part){
         if($part->getHeaders()->get('contenttransferencoding') ){
		    return $part->getHeaders()->get('contenttransferencoding')->getFieldValue();
         }
         else{
             return false;
         }
    }
    private function getPartType($part){
        $mode = 'file';
        if($part->getHeaders()->get('contenttype')){
				$content_type = $part->getHeaders()->get('contenttype')->getFieldValue();
				preg_match('/.*(html|plain).*/', $content_type, $charset);
				if(count($charset)){
		        	$mode = $charset[1];
		        }
        }
        return $mode;
    }
    private function getPartCharset($part){
        if($part->getHeaders()->get('contenttype')){
				$content_type = $part->getHeaders()->get('contenttype')->getFieldValue();
				preg_match('/.*charset.*"(.*)"/', $content_type, $charset);
        }
        else{
            
        }
    }
    public function getAllParts(){
        $contents   = array();
		
		if(!$this->getMessage()->countParts()){
		    $parts = array($this->getMessage());
		}
		else{
		    $parts = new \RecursiveIteratorIterator($this->getMessage());
		}
		
		// on parcours chacune des parti du mail
		foreach ($parts as $part) {
		    $mode = $this->getPartType($part);
	        $contents[$mode] = $part;
		}
        return $contents;
    }
}