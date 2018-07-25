<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");

	if(!$session->is_logged_in())
	{
		redirect_to("index.php");
	}
	$file="../../logs/log.txt";
	if(isset($_GET["clear"]))
	{
		unlink($file);
	}
	if(!file_exists($file)){
			$handle=fopen($file,'w');
			fclose($handle);
	}
	// if(!file_exists($file))
	// {
	// 	die("file does not exists");
	// }
	if(!is_readable($file))
	{
		die("File does not have read permissions! ");
	}
	log_action("Login:","logged in");
	$contents=file_get_contents($file);
	
	// if(!file_exists($file)){
	// 		$handle=fopen($file,'w+');
	// 		fclose($handle);
	// 	}
?>
<?php include("../layouts/admin_headers.php"); ?>
		<h2>Menu</h2>
		<?php echo nl2br($contents); ?>
		<br/>
		<br/>
		<b>
		<a href="logfile.php?clear=1">Clear Logfile</a>
	    </b>
	    <br/>
	    <b>
	    <a href="index.php" >&laquo;back</a>
	    </b>
		</div>
		
<?php include("../layouts/admin_footers.php"); ?>