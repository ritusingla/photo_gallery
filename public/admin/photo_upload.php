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
	$max_file_size=1048576;

	if(isset($_POST['submit'])){
		$photo=new Photograph();
		$photo->caption=htmlentities($_POST['caption']);
		$photo->attach_file($_FILES['file_upload']);
		if($photo->save()){
			//success
			$_SESSION["message"]="Uploaded Successfully!";
			redirect_to("list_photos.php");
		}
		else{
			//Failure
			$_SESSION['message']=join("<br/>",$photo->errors);
			redirect_to("list_photos.php");
		}
	}	  
?>
<?php include("../layouts/admin_headers.php"); ?>
		<b>
	    <a href="list_photos.php" >&laquo;Back</a>
	    <br>
	    <br>
	    </b>
<?php
	  echo message_check();
?>
	<form action="photo_upload.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value=<?php echo $max_file_size ?> />
		<input type="file" name="file_upload">
		<p>Caption:
		<br/><input type="text" name="caption" value=""></p>
		<br/>
		<input type="submit" name="submit" value="upload"/>
	</form>
</div>
<?php include("../layouts/admin_footers.php"); ?>