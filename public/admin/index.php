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
		<?php echo message_check(); ?>
		<h2>Menu</h2>
		<ul>
			<li>
		        <b> <a href="logfile.php">Go to Logfile</a></b>
	        </li>
	        <br/>
	        <li>
		        <b> <a href="list_photos.php">List All Photos</a></b>
	        </li>
	        <br/>
	        <li>
	        	<b><a href="logout.php">Logout</a></b>
	        </li>
        </ul>
		</div>
		
<?php include("../layouts/admin_footers.php"); ?>