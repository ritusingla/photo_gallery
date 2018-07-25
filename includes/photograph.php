<?php
	require_once('database.php');
	require_once('database_object.php');
	require_once('comments.php');
	class Photograph extends DatabaseObject{
		protected static $table_name="photographs";
		protected static $db_fields=array('id','filename','type','size','caption');
		public $id;
		public $filename;
		public $type;
		public $size;
		public $caption;
		private $temp_path;
		protected $upload_dir="images";
		protected $upload_errors=array(
		UPLOAD_ERR_OK=>"no errors",
		UPLOAD_ERR_INI_SIZE =>"larger than upload_max_filesize",
		UPLOAD_ERR_FORM_SIZE =>"larger than MAZ_FILE_SIZE",
		UPLOAD_ERR_PARTIAL=>"partial upload",
		UPLOAD_ERR_NO_FILE=>"no file",
		UPLOAD_ERR_NO_TMP_DIR=>"no temporary directory",
		UPLOAD_ERR_CANT_WRITE=>"cant write to disk",
		UPLOAD_ERR_EXTENSION=>"file upload stopped by extension"
		);
		public $errors=array();

		public function comments(){
			return Comment::find_comments_on($this->id);
		}

		public static function count_all(){
			global $database;
			$sql="select count(*) from ".self::$table_name;
			$result=$database->query($sql);
			$row=$database->fetch_array($result);
			return array_shift($row);
		}

		//pass in $_FILE['uploaded_file'] as an arg.
		public function attach_file($file){
			//perform error checking on form parameters.
			if(!$file || empty($file) || !is_array($file)){
				$this->error[]="No File Was Uploaded!";
				return false;
			}
			elseif($file["error"]!=0){
				$this->error[]=$this->upload_errors[$file["error"]];
				return false;
			}
			else
			{
				//setting object attributes to form params.
				$this->temp_path=$file["tmp_name"];
				$this->filename=basename($file["name"]);
				$this->type=$file["type"];
				$this->size=$file["size"];
				return true;
			}
		}
		public function path(){
			$upload_dir="images";
			$target_path="../".$upload_dir."/".$this->filename;
			return $target_path;
		}
		public function destroy(){
			//1.Remove the database entry
			if($this->delete()){
				//2.Remove the file
				if(!unlink($this->path()))
				{
					//$_SESSION["message"]=$this->path();
					return false;
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		//Saving the file at target location and making entry in database correspondingly.
		public function save(){
			if(isset($this->id)){
				$this->update();
			}
			else{
				//checking for errors
				//Can't  save if there are pre=existing errors.
				if(!empty($this->errors)){
					return false;
				}
				//Can't save without filename and temp location on server.
				if(empty($this->filename) || empty($this->temp_path)){
					$this->errors[]="The file location is not available!";
					return false;
				}
				//Determine the target path
				$upload_dir="images";
				$target_path="../../public/".$upload_dir."/".$this->filename;
				//$target_path=$this->filename;
				if(file_exists($target_path)){
					$this->errors[]="The file {$this->filename} already exists!";
					return false;
				}
				//Attempt to move the file.
				if(move_uploaded_file($this->temp_path, $target_path)){
					//success
					//save corresponding entry into database.
					if($this->create()){
						//we are done with temp_path.
						unset($this->temp_path);
						return true;
					}
					else{
						//file not moved.
						$this->error[]="file can't be uploaded because of some denied permissions.";
						return false;
					}
				}
			}
		}
		public static function find_all(){
			global $database;
			$result=self::find_by_sql("select * from photographs");
			return $result;
		}	
		public static function find_by_id($id=0){
			global $database;
			$result=self::find_by_sql("select * from photographs where id={$id}");
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
		// public function save(){
		// 	return isset($this->id)?$this->update() : $this->create();
		// }
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
				//echo "SUCCESSFULLY INSERTED!";
				$this->id=$database->insert_id();
				return true;
			}
			else
			{
				//echo "NOT INSERTED!";
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
				//echo "SUCCESSFULLY UPDATED!";
				return true;
			}
			else
			{
				//echo "UPDATION FAILED!";
				return false;
			}
		}
		public function delete(){
			global $database;
			//$iid=$database->mysqli_prep($this->id);
			$sql="delete from ".self::$table_name;
			$sql.=" where id={$this->id}";
			if($database->affected_rows($database->query($sql))==1)
			{
				//echo "SUCCESSFULLY DELETED!";
				return true;
			}
			else
			{
				//echo "DELETION FAILED!";
				return false;
			}
		} 
	}
?>