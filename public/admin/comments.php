<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/photograph.php");
	require_once("../../includes/comments.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");

	if(!$session->is_logged_in())
	{
		redirect_to("login.php");
	}
?>
<?php
	$photo=Photograph::find_by_id($_GET['id']);
	$comments=Comment::find_all();
?>
<?php include("../layouts/admin_headers.php"); ?>
		<b>
	    <a href="list_photos.php" >&laquo;Back</a>
	    </b>
	<h2>COMMENTS on <?php echo $photo->filename; ?>:</h2>
	<div id="comments">
			<?php foreach($comments as $comment){ ; ?>
			<div class="comment" style="margin-bottom: 2em;">
				<div class="author">
				<b>	<?php echo htmlentities($comment->author); ?> wrote: </b>
				</div>
				<div class="body">
					<?php echo strip_tags($comment->body,'<strong><em><p>'); ?>
				</div>
				<div class="meta-info" style="font-size: 0.8em;">
					<?php echo datetime_to_text($comment->created); ?>
				</div>
				<div class="actions" style="font-size: 0.8em;">
					<a href="delete_comment.php?id=<?php echo $comment->id; ?>" >Delete Comment</a>
				</div>
			</div>
			<?php } ?>
			<?php if(empty($comments)){ echo "No comments.";} ?>
		</div>
	</div>
		
<?php include("../layouts/admin_footers.php"); ?>