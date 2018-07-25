<?php
	class Session{
		public $user_id;
		private $logged_in;
		function __construct(){
			session_start();
			$this->check_login();
		}
		public function check_login(){
			if(isset($_SESSION["user_id"]))
			{
				$this->user_id=$_SESSION["user_id"];
				$this->logged_in=true;
			}
			else
			{
				unset($this->user_id);
				$this->logged_in=false;
			}
		}
		public function is_logged_in(){
			if($this->logged_in)
			return $this->logged_in;
		}
		//when someone logged in
		public function login($user){
			if($user){
				$this->user_id=$_SESSION["user_id"]=$user->id;
				$_SESSION["username"]=$user->username;
				$this->logged_in=true;
			}
		}
		//when someone logged out
		public function logout(){
			unset($_SESSION["user_id"]);
			unset($this->user_id);
			$this->logged_in=false;
		}
	}
	$session=new Session();
?>
