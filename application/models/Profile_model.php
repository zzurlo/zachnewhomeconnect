<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
    
    function __constrcut(){
        
        parent::__constrcut();
        $this->load->database();
    }
    
    public function getProfileByUser($userID){
        $this->db->select('USER_ID, FIRST_NAME, LAST_NAME, EMAIL, DATE_JOINED');
        
        $this->db->from('Login');
        
        $this->db->where('USER_ID', $userID);
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
    
    
}