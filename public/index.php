<?php
	require_once("../includes/database.php");
	require_once("../includes/user.php");
	require_once("../includes/photograph.php");
	require_once("../includes/session.php");
	require_once("../includes/pagination.php");
	require_once("../includes/functions.php");

	// if(!$session->is_logged_in())
	// {
	// 	redirect_to("login.php");
	// }
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
?>
<?php include("layouts/headers.php"); ?>
<h2>ALL PHOTOGRAPHS</h2>
<?php foreach ($photos as $photo) { ; ?>
<div style="float: left; margin-left: 20px;">
	<a href="photo.php?id=<?php echo $photo->id ; ?>" >
	<img src="<?php echo "images/{$photo->path()}"; ?>" style=" padding: 2em;" width="200" height="150"/>
</a>
	<h3 style=" font-size: 20px;">&nbsp; &nbsp;Caption:</h3>
	 &nbsp;
	<div id="box">
	<h4><p style="font-family: Comic Sans MS; font-size: 15px;"><?php echo $photo->caption; ?></p></h4>
	</div>
</div>
<?php } ; ?>
<div id="pagination" style="clear: both;" >
<br/>
<br/>
<br/>
	<b>
	<?php
		if($pagination->total_pages()>1)
		{
			if($pagination->has_previous_page())
			{
				echo "<a href=\"index.php?page=";
				echo $pagination->previous_page();
				echo " \">  &laquo Previous </a>";
				echo "&nbsp;";
			}

			for($i=1;$i<=$pagination->total_pages();$i++)
			{
				if($i==$page)
				{
					echo "  <span class=\"selected\">{$i}</span>";
				}
				else{
				echo "  <a href=\" index.php?page={$i}\">{$i}</a>";
			    }
			}

			if($pagination->has_next_page())
			{
				echo "  <a href=\"index.php?page=";
				echo $pagination->next_page();
				echo " \"> Next &raquo; </a>";
			}
	    }

	?>
</b>
</div>
</div>
	
<?php include("layouts/footers.php"); ?>