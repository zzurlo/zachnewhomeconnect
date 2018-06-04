<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed_model extends CI_Model{
    
 
   
    function __constrcut(){
        
        parent::__constrcut();
        $this->load->database();
    }
    
    public function getPostsAndComments($datetime){
        return array("posts"=>$this->getPostsByDateTime($datetime), "comments"=>$this->getCommentsByDateTime($datetime));    
        
    }
    
    public function getPostsByUser($userID){
        $this->db->select('USER_POST_ID, EMAIL, POST, LIKES, USER_ID');
        
        $this->db->from('User_Post');
        
        $this->db->where('USER_ID', $userID);
        
        $this->db->order_by('POST_DATE', 'desc');
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $posts = array();
            foreach($query->result_array() as $post) {
                $post_id = $post['USER_POST_ID'];
                //get post likes from database
                $post['IS_LIKED'] = $this->isLiked($_SESSION['USER_ID'], $post_id);
                $post['COMMENTS'] = $this->getComments($post_id);
                $posts[] = $post;
            }
            return $posts;
        }
        else{
            return 0;
        }
    }
    
    public function getPostsByDateTime($datetime){
        $this->db->select('USER_POST_ID, EMAIL, POST, LIKES, USER_ID');
        
        $this->db->from('User_Post');
        
        $this->db->where('POST_DATE >=', $datetime);
        
        $this->db->order_by('POST_DATE', 'desc');
        
        $query = $this->db->get();

        if($query->num_rows()>0){
            $posts = array();
            foreach($query->result_array() as $post) {
                $post_id = $post['USER_POST_ID'];
                //get post likes from database
                $post['IS_LIKED'] = $this->isLiked($_SESSION['USER_ID'], $post_id);
                $post['COMMENTS'] = $this->getComments($post_id);
                // $post['COMMENTS'] = $this->getCommentsByDateTime($datetime);
                $posts[] = $post;
            }
            return $posts;
        }
        else{
            return 0;
        }
    }
    
    public function getAllPosts(){
        $this->db->select('USER_POST_ID, EMAIL, POST, LIKES, USER_ID');
        
        $this->db->from('User_Post');
        
        $this->db->order_by('POST_DATE', 'desc');
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $posts = array();
            foreach($query->result_array() as $post) {
                $post_id = $post['USER_POST_ID'];
                //get post likes from database
                $post['IS_LIKED'] = $this->isLiked($_SESSION['USER_ID'], $post_id);
                $post['COMMENTS'] = $this->getComments($post_id);
                $posts[] = $post;
            }
            return $posts;
            // return $query->result_array();
        }
        else{
            return 0;
        }
    }
    
    public function setLikesInUserPosts($postID){
        $count = 0;
        $this->db->where('USER_POST_ID', $postID);
        $this->db->from('Posts_Liked');
        $count = $this->db->count_all_results();
        $data = array('LIKES'=>$count);
        
        $this->db->where('USER_POST_ID', $postID);
        if($this->db->update('User_Post', $data)){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public function createPost($data){
        if($this->db->insert('User_Post', $data)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function updatePost($id, $data){
        $this->db->where('USER_POST_ID', $id);
        
        if($this->db->update('User_Post', $data)){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public function deletePost($id){
        $this->db->where('USER_POST_ID', $id);
        
        if($this->db->delete('User_Post')){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function likePost($data){
        if($this->db->insert('Posts_Liked', $data)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function unlikePost($postID, $userID){
        $this->db->where('USER_POST_ID', $postID);
        $this->db->where('USER_ID', $userID);
        
        if($this->db->delete('Posts_Liked')){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function isLiked($userID, $postID){
        //select * from Posts_Liked where USER_ID = $userID and USER_POST_ID = $postID
        $this->db->select('USER_POST_ID, USER_ID');
        
        $this->db->from('Posts_Liked');
        
        $this->db->where('USER_ID', $userID);
        
        $this->db->where('USER_POST_ID', $postID);
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function commentOnPost($data){
        if($this->db->insert('Posts_Commented', $data)){
            return $this->db->insert_id();
        }
        else{
            return false;
        }
    }
    
    public function getComments($postID){
        $this->db->select('USER_COMMENT, USER_FIRST_NAME, USER_LAST_NAME, COMMENT_ID, LIKES');
        
        $this->db->from('Posts_Commented');
        
        $this->db->where('USER_POST_ID', $postID);
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $comments = array();
            foreach($query->result_array() as $comment) {
                $comment_id = $comment['COMMENT_ID'];
                //get comment likes from database
                $comment['IS_COMMENT_LIKED'] = $this->isCommentLiked($_SESSION['USER_ID'], $comment_id);
                $comments[] = $comment;
            }
            return $comments;

        }
        else{
            return 0;
        }
    }
    
    public function getCommentsByDateTime($datetime){
        $this->db->select('USER_COMMENT, USER_FIRST_NAME, USER_LAST_NAME, COMMENT_ID, LIKES, USER_POST_ID');
        
        $this->db->from('Posts_Commented');
        
        $this->db->where('COMMENT_DATE >=', $datetime);
        
        $query = $this->db->get();

        if($query->num_rows()>0){
            $comments = array();
            foreach($query->result_array() as $comment) {
                $comment_id = $comment['COMMENT_ID'];
                //get comment likes from database
                $comment['IS_COMMENT_LIKED'] = $this->isCommentLiked($_SESSION['USER_ID'], $comment_id);
                $comments[] = $comment;
            }
            return $comments;

        }
        else{
            return 0;
        }
        
    }
    
    public function likeComment($data){
        if($this->db->insert('Comment_Likes', $data)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function unlikeComment($commentID, $userID){
        $this->db->where('COMMENT_ID', $commentID);
        $this->db->where('USER_ID', $userID);
        
        if($this->db->delete('Comment_Likes')){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function isCommentLiked($userID, $commentID){
        $this->db->select('COMMENT_ID, USER_ID');
        
        $this->db->from('Comment_Likes');
        
        $this->db->where('USER_ID', $userID);
        
        $this->db->where('COMMENT_ID', $commentID);
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function setLikesInPostsCommented($commentID){
        $count = 0;
        $this->db->where('COMMENT_ID', $commentID);
        $this->db->from('Comment_Likes');
        $count = $this->db->count_all_results();
        $data = array('LIKES'=>$count);
        
        $this->db->where('COMMENT_ID', $commentID);
        if($this->db->update('Posts_Commented', $data)){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public function getProfileFeedByUserAndDateTime($userID, $datetime){
        $this->db->select('USER_POST_ID, EMAIL, POST, LIKES, USER_ID');
        
        $this->db->from('User_Post');
        
        $this->db->where('USER_ID', $userID);
        
        $this->db->where('POST_DATE >=', $datetime);
        
        $this->db->order_by('POST_DATE', 'desc');
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $posts = array();
            foreach($query->result_array() as $post) {
                $post_id = $post['USER_POST_ID'];
                //get post likes from database
                $post['IS_LIKED'] = $this->isLiked($_SESSION['USER_ID'], $post_id);
                $post['COMMENTS'] = $this->getComments($post_id);
                $posts[] = $post;
            }
            return $posts;
        }
        else{
            return 0;
        }
    }
    

    
    
    
}