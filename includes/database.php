<?php 
require_once("config.php");
	class MySQLDatabase{
		private $connection;
		public $last_query;
		function __construct(){
			$this->open_connection();
		}
		public function open_connection(){
			$this->connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
			if(!$this->connection)
			{
				die("Database Connection Failed:".mysqli_error($this->connection));
			}
			else
			{
				$db_select=mysqli_select_db($this->connection,DB_NAME);
				if(!$db_select)
				{
					die("Database Selection Failed :". mysqli_error($this->connection));
				}
			}
		}
		public function close_connection(){
			if(isset($this->connection))
			{
				mysqli_close($this->connection);
				unset($this->connection);
			}
		}
		public function query($sql){
			$this->last_query=$sql;
			$result=mysqli_query($this->connection,$sql);
			$this->confirm_query($result);
			return $result;
		}
		private function confirm_query($result){
			if(!$result)
			{
				$output="Database Query failed". mysqli_error($this->connection)."<br/>";
				$output.=$this->last_query;
				die($output);
			}
		}
		public function mysqli_prep($value){
			if($value)
			{
				$value=mysqli_real_escape_string($this->connection,$value);
				return $value;
			}
			return $value;
		}
		public function fetch_array($result1){
			$result1=mysqli_fetch_array($result1);
			return $result1;
		}
		public function num_rows($result2){
			return mysqli_num_rows($result2);
		}
		public function insert_id(){
			//get last id inserted into current connection
			return mysqli_insert_id($this->connection);
		}
		public function affected_rows(){
			return mysqli_affected_rows($this->connection);
		}
	}
	$database=new MySQLDatabase();
?>