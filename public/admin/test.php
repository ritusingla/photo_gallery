<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");

	if(!$session->is_logged_in())
	{
		redirect_to("login.php");
	}
?>

<?php include("../layouts/admin_headers.php"); ?>
<?php
	  $user=new User();
	  // $user->username="ritusinglaa088";
	  // $user->password="ritusingla15";
	  // $user->first_name="rituu";
	  // $user->last_name="singlaaa";
	  // $user->create();
	    $result=User::find_by_id(4);
	    $result->username="ritusingla08";
	    $result->password="ritusingla14";
	    $result->update();
	//$result->delete();
?>

<?php include("../layouts/admin_footers.php"); ?>