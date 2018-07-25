<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/photograph.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");

	if(!$session->is_logged_in())
	{
		redirect_to("login.php");
	}
?>
<?php
	
	if(empty($_GET['id'])){
		$_SESSION["message"]="Please select some id !";
		redirect_to("list_photos.php");		
	}
	
	$photo=Photograph::find_by_id($_GET['id']);
	if($photo && $photo->destroy()){
		$_SESSION["message"]="Successfully Deleted!";
		redirect_to("list_photos.php");
	}	  
	else{
		$_SESSION["message"]=" Deletion failed!";
		redirect_to("list_photos.php");
	}

?>
