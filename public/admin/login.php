<?php
	require_once("../../includes/database.php");
	require_once("../../includes/user.php");
	require_once("../../includes/session.php");
	require_once("../../includes/functions.php");

	if($session->is_logged_in())
	{
		redirect_to("index.php");
	}
	if(isset($_POST["submit"]))
	{
		$username=trim($_POST["username"]);
		$password=trim($_POST["password"]);
		//validations
		$found_user=User::authenticate($username,$password);

		if($found_user)
		{
			$session->login($found_user);
			$_SESSION["message"]="Successfuly Logged in!";
			log_action("Login:","logged in");
			redirect_to("index.php");			
		}
		else
		{
			$_SESSION["message"]="username / password incorrect!";
		}
	}
	else{
		$username="";
		$password="";
		if(isset($_GET["logout"]) && $_GET["logout"]==1)
		{
			$_SESSION["message"]="You are now Logged out!";
		}
	}
?>

<html>
  <head>
    <title>Photo Gallery</title>
    <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="header">
      <h1>Photo Gallery</h1>
    </div>
    <div id="main">
		<h2>Staff Login</h2>
		<?php echo message_check(); ?>
		<form action="login.php" method="post">
		  <table>
		    <tr>
		      <td><p style=" font-size: 15px;">Username:</p></td>
		      <td>
		      	<p style=" font-size: 15px;">
		        <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
		        </p>
		      </td>
		    </tr>
		    <tr>
		      <td><p style=" font-size: 15px;">Password:</p></td>
		      <td>
		      	<p style=" font-size: 15px;">
		        <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
		        </p>
		      </td>
		    </tr>
		    <tr>
		      <td colspan="2">
		        <input type="submit" name="submit" value="Login" />
		      </td>
		    </tr>
		  </table>
		</form> 
	</div>
	<div id="footer" > Copyright <?php echo date("Y",time()) . "," . "Ritu Singla" ; ?> </div>
</body>
</html>
<?php
	if(isset($database))
	{
		$database->close_connection();
	}
?>
