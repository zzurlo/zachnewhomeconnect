<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
    
 
   
    function __constrcut(){
        
        parent::__constrcut();
    }
    
        
    public function registerUser($data){
        
        $this->load->database();
        
        $count = $this->db->insert('Login', $data);
        
        if($count>0){
            return true;
        }
        else{
            return false;
        }
       
        
    }
    
    public function canLogin($email, $password){
        //session_start();
        $this->db->where('EMAIL', $email);
        $this->db->where('PASSWORD', $password);
        
        $query = $this->db->get('Login');
        
        //select * from Login where EMAIL = $email AND PASSWORD = $password
        
        if($query->num_rows()>0){
              
            // create session
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
            $row = $query->row_array();
            $user_id = $row['USER_ID'];
            $_SESSION['USER_ID'] = $user_id;
            $email = $row['EMAIL'];
            $_SESSION['EMAIL'] = $email;
            $first_name = $row['FIRST_NAME'];
            $_SESSION['FIRST_NAME'] = $first_name;
            $last_name = $row['LAST_NAME'];
            $_SESSION['LAST_NAME'] = $last_name;
            
            return true;
              
        }
        else{
            return false;
        }
    }
    
    
    
        
        
    
}