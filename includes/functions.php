<?php
	require_once("session.php");
	function redirect_to($new_location){
		header("Location: " . $new_location);
		exit;
	} 
	function message_check(){
	   if(isset($_SESSION["message"])) {
             $output=" <div id=\"message\">";
             $output.= htmlentities($_SESSION["message"]); 
             $output.= "</div>";
             $_SESSION["message"]=null;
             return $output;
        }
	}
	function log_action($action,$message=""){
		$file="../../logs/log.txt";
		if(!file_exists($file)){
			$handle=fopen($file,'w');
			fclose($handle);
		}
		if(!is_writable($file))
		{
			die("File does not have write permissions! ");
		}
		$handle=fopen($file,'w+');
		$content=strftime("%y-%m-%d %H:%M:%S",time());
		$content.="|";
		$content.=$action;
		$content.=$_SESSION["username"];
		$content.=" ".$message;
		fwrite($handle,$content);
		fclose($handle);
	}

	function datetime_to_text($datetime="")
	{
		$unixdatetime=strtotime($datetime);
		return strftime("%B %d %Y at %I:%M %p",$unixdatetime);
	}
?>