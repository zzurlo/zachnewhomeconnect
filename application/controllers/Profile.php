<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct(){
	    parent::__construct();
	    
	    $this->load->model('Profile_model');
	}
	
	//get user profile by user id
	public function profileByUser_get(){
	    $userID;
	    if(isset($_POST['profileid'])){
	        $userID = $_POST['profileid'];
	    }
	    else{
	        $userID = $_SESSION['USER_ID'];
	    }
	    
	    echo json_encode($this->Profile_model->getProfileByUser($userID));
	}
	
	
	
	
}