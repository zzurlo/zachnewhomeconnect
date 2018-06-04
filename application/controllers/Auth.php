<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	
	
	public function index()
	{
		
		
		if(isset($_SESSION['USER_ID'])) {
			//user is logged in
			$this->authenticate();
		} else {
			$this->login();
		}
	}
	
	public function login(){
	    $this->load->view("Login");
	}
	
	public function loginUser(){
	    $email = $this->input->post('email'); //email entered on login form
	    $password = $this->input->post('password'); //password entered on login form
	    
	    $this->load->model('Auth_model'); //loads authentication model
	    
	    
	    if($this->Auth_model->canLogin($email, $this->hashString($password))){
	       $this->authenticate();
	    }
	    
	    else{
	        $this->login();
	    }
	    
	    
	    
	}
	
	public function register(){
	    $this->load->view("Register");
	}
	
	public function registerUser(){
	    
	    $firstname = $this->input->post('firstname');
	    $lastname = $this->input->post('lastname');
	    $email = $this->input->post('email');
	    $password = $this->input->post('password');
	    
	    
	    $data = array('FIRST_NAME'=>$firstname, 'LAST_NAME'=>$lastname, 'EMAIL'=>$email, 'PASSWORD'=> $this->hashString($password));

	    $this->load->model('Auth_model'); //loads authentication model
	    
	    if($this->Auth_model->registerUser($data)){
	        
	        $this->login();
	    }
	    
	    else{
	        echo "Data not inserted";
	    }
	    
	    
	}
	
	public function authenticate(){
		$this->load->model("Feed_model");
		$data = array();
		$data['posts'] = $this->Feed_model->getAllPosts();
	    $this->load->view("Authenticated", $data);
	}
	
	public function hashString($str){
	    $hashedString = md5($str);
	    return $hashedString;
	    
	}
	
	public function logout(){
		session_destroy();
		$this->login();
		
	}
	
	
	
	

	
}