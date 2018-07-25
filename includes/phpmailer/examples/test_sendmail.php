<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);


date_default_timezone_set('America/Toronto');
//date_default_timezone_set(date_default_timezone_get());

include_once('../class.phpmailer.php');

$mail             = new PHPMailer();
$body             = $mail->getFile('contents.html');
//$body             = eregi_replace("[\]",'',$body);

$mail->IsSendmail(); // telling the class to use SendMail transport

$mail->From       = "ritusingla222@gmail.com";
$mail->FromName   = "RItu";

$mail->Subject    = "PHPMailer Test Subject via smtp";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress("ritusingla1998@gmail.com", "Ritu Singla");

//$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>
