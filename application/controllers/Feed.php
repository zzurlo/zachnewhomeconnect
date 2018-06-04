<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {

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
	 
	 
	public function __construct(){
	    parent::__construct();
	    
	    $this->load->model('Feed_model');
	}
	
	public function postsAndComments_get(){
		$datetime = $_POST['datetime'];
		echo json_encode($this->Feed_model->getPostsAndComments($datetime));
	}
	//get posts by user
	public function postByUser_get(){
		$userID = $_POST['listpostuserid'];
	    echo json_encode($this->Feed_model->getPostsByUser($userID));
	}
	
	//get all posts
	public function posts_get(){
	    echo json_encode($this->Feed_model->getAllPosts());
	}
	
	// public function postByDatetime_get(){
	// 	$datetime = $_POST['datetime'];
	// 	echo json_encode($this->Feed_model->getPostsByDateTime($datetime));
	// }
	
	public function profileFeedByDateTime_get(){
		$datetime = $_POST['datetime'];
	    $userID;
	    if(isset($_POST['profileid'])){
	        $userID = $_POST['profileid'];
	    }
	    else{
	        $userID = $_SESSION['USER_ID'];
	    }
	    
	    echo json_encode($this->Feed_model->getProfileFeedByUserAndDateTime($userID, $datetime));
	}
	
	
	public function createPost(){
		$email = $_SESSION['EMAIL'];
		$userID = $_SESSION['USER_ID'];
		$post = $this->input->post('createpost');

		if(!$email || !$post){
		    echo "Enter complete post information";
		}
		else{
		    $data = array('EMAIL'=>$email, 'POST'=>$post, 'USER_ID'=>$userID);
		    
		    if($this->Feed_model->createPost($data)){
		        $this->load->view("Authenticated");
		    }
		    else{
		        echo 'not successful';
		        
		    }
		}
	
	}
	
	public function deleteUserPost(){
		$postID = $this->input->post('deletepostid');
		echo $postID;
		if(!$postID){
			echo 'no post id';
		}
		
		if($this->Feed_model->deletePost($postID)){
			echo 'Success';
			
		}
		
		else{
			
			echo 'Failed';
		}
		
		
	}
	
	public function updateUserPost(){
		$postID = $_POST['updatepostid'];
		$postContent = $_POST['updatepostcontent'];
		$email= $_SESSION['EMAIL'];
		
		if(!$postID || !$postContent){
			
			echo 'Enter complete information';
		}
		else{
			
			if($this->Feed_model->updatePost($postID, array('EMAIL'=>$email, 'POST'=>$postContent))){
				echo 'Success';
				
			}
			
			else{
				echo 'Failed';
			}
		}
		
	}
	
	public function likeUserPost(){
		$postID = $_POST['likepostid'];
		$userID = $_POST['likeuserid'];
		
			
		if($this->Feed_model->likePost(array('USER_POST_ID'=>$postID, 'USER_ID'=>$userID))){
			echo 'Success';
			$this->setLikes($postID);
				
		}
			
		else{
			echo 'Failed';
		}
		
		
	}
	
	public function unlikeUserPost(){
		$postID = $_POST['unlikepostid'];
		$userID = $_POST['unlikeuserid'];
		
		if($this->Feed_model->unlikePost($postID, $userID)){
			echo 'Success';
			$this->setLikes($postID);
		}
			
		else{
			echo 'Failed';
		}
		
		
	}
	
	public function setLikes($postID){
		$postID = $postID;
		
		if($this->Feed_model->setLikesInUserPosts($postID)){
			echo 'Success';
				
		}
			
		else{
			echo 'Failed';
		}
			
	}
	
	public function setCommentLikes($commentID){
		$commentID = $commentID;
		
		if($this->Feed_model->setLikesInPostsCommented($commentID)){
			echo 'Success';
				
		}
			
		else{
			echo 'Failed';
		}
			
	}
	
	public function isLiked(){
		$postID = $_POST['islikedpostid'];
		$userID = $_SESSION['USER_ID'];
		
		if($this->Feed_model->isLiked($userID, $postID)){
			echo 'Is Liked';
				
		}
			
		else{
			echo 'Is not liked';
		}
			
	}
	
	public function addComment(){
		$postID = $_POST['commentpostid'];
		$userID = $_POST['commentuserid'];
		$comment = $_POST['comment'];
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		
		echo $this->Feed_model->commentOnPost(array('USER_POST_ID'=>$postID, 'USER_ID'=>$userID, 'USER_COMMENT'=>$comment, 'USER_FIRST_NAME'=>$fname, 'USER_LAST_NAME' => $lname));

	}
	
	public function getComments(){
		$postID = $_POST['commentpostid'];
		echo json_encode($this->Feed_model->getComments($postID));
	}
	
	// public function getCommentsByDateTime() {
	// 	$datetime = $_POST['datetime'];
	// 	echo json_encode($this->Feed_model->getCommentsByDateTime($datetime));
	// }
	
	public function likeComment(){
		$commentID = $_POST['likecommentid'];
		$userID = $_POST['likecommentuserid'];
		
		if($this->Feed_model->likeComment(array('COMMENT_ID'=>$commentID, 'USER_ID'=>$userID))){
			echo 'Success';
			$this->setCommentLikes($commentID);	
		}
			
		else{
			echo 'Failed';
		}
		
	}
	
	
	public function unlikeComment(){
		$commentID = $_POST['unlikecommentid'];
		$userID = $_POST['unlikecommentuserid'];
		
		if($this->Feed_model->unlikeComment($commentID, $userID)){
			echo 'Success';
			$this->setCommentLikes($commentID);	
				
		}
			
		else{
			echo 'Failed';
		}
	}
}
	