<?php require_once("../../includes/functions.php"); ?>

<?php
//way 1
	 $_SESSION=array();
	 if(isset($_COOKIE[session_name()]))
	 {
	 	setcookie(session_name(),'',time()-42000,'/');
	 } 
	 session_destroy();
	 redirect_to("login.php?logout=1");
?>

<?php 
//way 2
	// $_SESSION["admin_id"]=null;
	// $_SESSION["username"]=null;
	// redirect_to("login.php?logout=1");
?>