<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SMTP_FROM' , 'root@waste.email');

class mailer extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('mailer/index');
	}
	public function test()
	{
	    $this->load->model('loader');
		Loader::register();
		$this->load->view('mailer/test');
	}
	public function checkmail(){
		header('Content-Type: application/json');
		$this->load->model('loader');
		Loader::register();
        echo json_encode(\Mailer\Imap::i()->getMails($_GET['folder']));
        
        exit;
        
	}
	public function folders(){

		$this->load->model('loader');
		Loader::register();
		header('Content-Type: application/json');
		
		echo json_encode(\Mailer\Imap::i()->getTreeFolders());
	}
	public function sendmail(){
		
		$this->load->model('loader');
		Loader::register();
		$data               = file_get_contents("php://input");
		
		// on recupere la data envoyé par angularjs
		$postData           = (array)json_decode($data);

		

		$message = \Mailer\Smtp::i()->sendmail(\Mailer\Config::SMTP_FROM, $postData['to'], $postData['subject'], $postData['body']);
		
		\Mailer\Imap::i()->appendMessage($message->toString(), 'Sent');
	}
	public function readmail(){
		$data               = file_get_contents("php://input");
		
		// on recupere la data envoyé par angularjs
		$postData           = (array)json_decode($data);
		
		$this->load->model('loader');
		Loader::register();
		\Mailer\Imap::i()->selectFolder($postData['folder']);
		echo \Mailer\Imap::i()->getFormatedMessage($postData['id']);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
