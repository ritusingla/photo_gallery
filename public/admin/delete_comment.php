<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/photograph.php");
	require_once("../../includes/session.php");
	require_once("../../includes/comments.php");
	require_once("../../includes/functions.php");

	if(!$session->is_logged_in())
	{
		redirect_to("login.php");
	}
?>
<?php
	
	if(empty($_GET['id'])){
		$_SESSION["message"]="Please select some id !";
		redirect_to("comments.php");		
	}
	
	$comment=Comment::find_by_id($_GET['id']);
	if($comment && $comment->delete()){
		$_SESSION["message"]="Successfully Deleted!";
		redirect_to("comments.php?id= {$comment->photograph_id} ");
	}	  
	else{
		$_SESSION["message"]=" Deletion failed!";
		redirect_to("comments.php");
	}

?>
