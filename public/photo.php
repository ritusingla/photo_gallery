<?php
	require_once("../includes/database.php");
	require_once("../includes/user.php");
	require_once("../includes/photograph.php");
	require_once("../includes/comments.php");
	require_once("../includes/session.php");
	require_once("../includes/functions.php");

	// if(!$session->is_logged_in())
	// {
	// 	redirect_to("login.php");
	// }
?>
<?php
	
	// if(empty($_GET['id'])){
	// 	$_SESSION["message"]="Please select some id !";
	// 	redirect_to("index.php");	
	// }
	
	$photo=Photograph::find_by_id($_GET['id']);
	if(!$photo)
	{
		$_SESSION["message"]="This photo couldn't be located!";
		redirect_to("index.php");
	}

	if(isset($_POST["submit"]))
	{
		$author=trim($_POST["author"]);
		$body=trim($_POST["body"]);
		$comment=Comment::make($photo->id,$author,$body);
		if($comment && $comment->save())
		{
			redirect_to("photo.php?id={$photo->id}");
		}
		else
		{
			$_SESSION["message"]="Comment is not saved!";
		}
	}
	else
	{
		//$_SESSION["message"]="Get submission";
		$author="";
		$body="";
	}
	$comments=$photo->comments();
?>
<?php include("layouts/headers.php"); ?>
	&nbsp; &nbsp;<a href="index.php" ><b style="font-size: 15px;">&laquo;BACK</b></a>
	<br/>
	<br/>
	<div style="margin-left: 20px;">
		<img src="<?php echo "images/{$photo->path()}"; ?>"/>
		<br/>
		<h3 style=" font-size: 20px;">Caption:</h3>
		&nbsp;
		<div id="box">
		<h4><p style=" font-size: 15px;"><?php echo $photo->caption; ?></p></h4>
	    </div>
		<div id="comments">
			<?php foreach($comments as $comment){ ; ?>
			<div class="comment" style="margin-bottom: 2em;">
				<div class="author">
				<h5 style=" font-size: 15px;">	<?php echo htmlentities($comment->author); ?> wrote: </h5>
				</div>
				<div class="body">
					<p style=" font-size: 15px;"><?php echo strip_tags($comment->body,'<strong><em><p>'); ?></p>
				</div>
				<div class="meta-info" style="font-size: 0.8em;">
					<p style=" font-size: 15px;"><?php echo datetime_to_text($comment->created); ?>
					</p>
				</div>
			</div>
			<?php } ?>
			<?php if(empty($comments)){ echo "No comments.";} ?>
		</div>
		<!-- comments form -->
		<div id="comment-form">
			<h3>New Comment</h3>
			<?php echo message_check(); ?>
			<form action="photo.php?id=<?php echo $photo->id ; ?>" method="post" >
				<table>
					<tr>
						<td><p style=" font-size: 15px;">Your Name:</p></td>
						<td><p style=" font-size: 15px;"><input type="text" name="author" value="<?php echo $author; ?>" /></p></td>
					</tr>
					<tr>
						<td><p style=" font-size: 15px;">Your Comment:</p></td>
						<td><p style=" font-size: 15px;"><textarea  name="body" cols="40" rows="8"><?php echo $body; ?></textarea></p></td>
					</tr>
					<tr>
						<!-- <td>&nbsp;</td> -->
						<td><input type="submit" value="Submit comment" name="submit"/></td>
					</tr>
				</table>
		</div>
	</div>

</div>
<?php include("layouts/footers.php"); ?>
