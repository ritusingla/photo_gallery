<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/photograph.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/pagination.php");

	if(!$session->is_logged_in())
	{
		redirect_to("login.php");
	}
?>
<?php
	//PAGINATION
	//1.the current page number
	$page=!empty($_GET["page"])? (int)$_GET["page"] : 1;
	//2.records per page
	$per_page=3;
	//3.total record count
	$total_count=Photograph::count_all();
	$pagination=new Pagination($page,$per_page,$total_count);
	$sql="select * from photographs ";
	$sql.="LIMIT {$per_page} ";
	$sql.="OFFSET {$pagination->offset()}";
	$photos=Photograph::find_by_sql($sql);
	//$photos=Photograph::find_all();
?>
<?php include("../layouts/admin_headers.php"); ?>
		<b>
	    <a href="index.php" >&laquo;Back</a>
	    </b>
		<h2>PHOTOGRAPHS</h2>
		<div class="message">
		<?php echo message_check(); ?>
	    </div>
		<table cellpadding="15em">
			<th><h3>Image</h3></th>
			<th>&nbsp;</th>
			<th><h3>Filename</h3></th>
			<th>&nbsp;</th>
			<th><h3>Caption</h3></th>
			<th>&nbsp;</th>
			<th><h3>Size</h3></th>
			<th>&nbsp;</th>
			<th><h3>Type</h3></th>
			<th>&nbsp;</th>
			<th><h3>Comments</h3></th>
			<th>&nbsp;</th>
			<?php
			foreach($photos as $photo) {
			?>
			<tr>
			<td><img src="<?php echo $photo->path() ; ?>" width="150" height="100"/></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><?php echo $photo->filename ; ?></p></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><?php echo $photo->caption ; ?></p></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><?php echo $photo->size ; ?></p></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><?php echo $photo->type ; ?></p></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><a href="comments.php?id=<?php echo $photo->id; ?>" ><?php echo count($photo->comments()); ?></a></p></td>
			<td>&nbsp;</td>
			<td><p style=" font-size: 15px;"><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></p></td>
		</tr>
			<?php } ?>
		</table>
		<br/>
		<br/>
		<div id="pagination" style="clear: both;" >
		<b>
	    <?php
		if($pagination->total_pages()>1)
		{
			if($pagination->has_previous_page())
			{
				echo "<a href=\"list_photos.php?page=";
				echo $pagination->previous_page();
				echo " \"> Previous &laquo;  </a>";
				echo "&nbsp;";
			}

			for($i=1;$i<=$pagination->total_pages();$i++)
			{
				echo "&nbsp;";
				if($i==$page)
				{
					echo "  <span class=\"selected\">{$i}</span>";
				}
				else{
				    echo "  <a href=\"list_photos.php?page={$i}\">{$i}</a>";
			    }
			}

			if($pagination->has_next_page())
			{
				echo "  <a href=\"list_photos.php?page=";
				echo $pagination->next_page();
				echo " \"> Next &raquo; </a>";
			}
	    }

	?>
</b>
</div>
<br/>
<br/>
		<h3><a href="photo_upload.php" >Upload New Photo </a></h3>
	</div>
		
<?php include("../layouts/admin_footers.php"); ?>