<?php
	require_once('database.php');
	require_once('database_object.php');
	class User extends DatabaseObject{
		protected static $table_name="users";
		protected static $db_fields=array('id','username','password','first_name','last_name');
		public $username;
		public $password;
		public $id;
		public $first_name;
		public $last_name;

		public static function count_all(){
			global $database;
			$sql="select count(*) from ".self::$table_name;
			$result=$database->query($sql);
			$row=$database->fetch_array($result);
			return array_shift($row);
		}

		public static function find_all(){
			global $database;
			$result=self::find_by_sql("select * from users");
			return $result;
		}	
		public static function find_by_id($id=0){
			global $database;
			$result=self::find_by_sql("select * from users where id={$id}");
			//return $result;
			return !empty($result)?array_shift($result):false;
		}
		public static function find_by_sql($sql=" "){
			global $database;
			$result=$database->query($sql);
			$obj_array=array();
			while($row=$database->fetch_array($result)){
				$obj_array[]=self::instantiate($row);
			}
			return $obj_array;
		}
		private static function instantiate($record){
			$object=new self;
			foreach ($record as $attribute => $value) {
				if($object->has_att($attribute)){
				$object->$attribute=$value; 
			}
			}
			return $object;
		}
		private function has_att($att){
			$object_vars=$this->attributes();
			return array_key_exists($att, $object_vars);
		}
		protected function attributes(){
			global $database;
			$attributes=array();
			foreach(self::$db_fields as $field){
				if(property_exists($this, $field))
				{
					$attributes[$field]=$this->$field;
				}
			}
			return $attributes;
		}
		public  function full_name(){
			if(isset($this->first_name) && isset($this->last_name)){
				return $this->first_name . " " . $this->last_name;
			}
		}
		public static function authenticate($username,$password){
			global $database;
			$username=$database->mysqli_prep($username);
			$password=$database->mysqli_prep($password);

			$sql="select * from users where username='{$username}' and password='{$password}'";
			$result=self::find_by_sql($sql);
			return (!empty($result))?array_shift($result) : false;
		}
		public function save(){
			return isset($this->id)?$this->update() : $this->create();
		}
		public function create(){
			global $database;
			$attributes=$this->attributes();
			$sql="insert into ". self::$table_name;
			$sql.="(" . join(",",array_keys($attributes));
			$sql.=") values('";
			$sql.=join("','",array_values($attributes));
			$sql.="')";
			if($database->query($sql))
			{
				echo "SUCCESSFULLY INSERTED!";
				$this->id=$database->insert_id();
				return true;
			}
			else
			{
				echo "NOT INSERTED!";
				return false;
			}
		}
		public function update(){
			global $database;
			$attributes=$this->attributes();
			$att_array=array();
			foreach($attributes as $key=>$value){
				$att_array[]="{$key}='{$value}'";
			}
			$sql="update ".self::$table_name;
			$sql.="  set ".join("," , $att_array);
			$sql.=" where id={$this->id}";
			if($database->affected_rows($database->query($sql))==1)
			{
				echo "SUCCESSFULLY UPDATED!";
				return true;
			}
			else
			{
				echo "UPDATION FAILED!";
				return false;
			}
		}
		public function delete(){
			global $database;
			$uname=$database->mysqli_prep($this->username);
			$pass=$database->mysqli_prep($this->password);
			$fname=$database->mysqli_prep($this->first_name);
			$lname=$database->mysqli_prep($this->last_name);
			$iid=$database->mysqli_prep($this->id);
			$sql="delete from ".self::$table_name;
			$sql.=" where id={$iid}";
			if($database->affected_rows($database->query($sql))==1)
			{
				echo "SUCCESSFULLY DELETED!";
				return true;
			}
			else
			{
				echo "DELETION FAILED!";
				return false;
			}
		} 
	}
?>