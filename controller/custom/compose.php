<?php if(!defined("DIR")){ exit(); }
class compose extends connection{
	function __construct($c){
		$this->template($c,"compose");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c); // connection

		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		/* language variables */
		$language_data = $cache->index($c,"language_data");
		$language_data = json_decode($language_data);
		$model_template_makevars = new  model_template_makevars();
		$data["language_data"] = $model_template_makevars->vars($language_data); 

		$sql = 'SELECT `namelname`,`picture` FROM `studio404_users` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$_SESSION["batumi_id"]
		));
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$data["userdata"] = $fetch;
		}else{
			redirect::url(WEBSITE);
		}

		$catalog_general = $cache->index($c,"catalog_general");
		$data["catalog_general"] = json_decode($catalog_general,true);

		$userlist = $cache->index($c,"userlist");
		$data["userlist"] = json_decode($userlist,true);
		
		if(Input::method("POST","attach")=="true" && isset($_FILES["attachment"]["name"])){
			$x = 0;
			$data["upload_status"] = array();
			foreach ($_FILES["attachment"]["name"] as $value) { 
				$ext = explode(".",$_FILES["attachment"]["name"][$x]);
				$ext = strtolower(end($ext));
				$newFilename = $x.md5(time()).".".$ext; 
				$target_dir = DIR."files/attachments/";
				$target_file = $target_dir . $newFilename;
				
				// Allow certain file formats
				if($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif" && $ext != "doc" && $ext != "docx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar") {
				    $data["upload_status"]["filename"][] = $_FILES["attachment"]["name"][$x]; 
				    $data["upload_status"]["error"][] = true; 
				}else{					
				    if (move_uploaded_file($_FILES["attachment"]["tmp_name"][$x], $target_file)) {
				        $insert = 'INSERT INTO `studio404_messages_attachments` SET `msg_id`=:msg_id, `file`=:file, `ext`=:ext, `size`=:size';
				        $prepare = $conn->prepare($insert);
				        $prepare->execute(array(
				        	":msg_id"=>Input::method("POST","insert_id"), 
				        	":file"=>$newFilename, 
				        	":ext"=>$ext, 
				        	":size"=>$_FILES["attachment"]["size"][$x]
				        ));
				        $data["upload_status"]["filename"][] = $_FILES["attachment"]["name"][$x]; 
				    	$data["upload_status"]["error"][] = false; 
				    } else {
				        $data["upload_status"]["filename"][] = $_FILES["attachment"]["name"][$x]; 
				    	$data["upload_status"]["error"][] = true; 
				    }
				}
				$x++;
			}
		}

		$catalogitemsnovisiable = $cache->index($c,"catalogitemsnovisiable");
		$data["catalogitems"] = json_decode($catalogitemsnovisiable,true);
		$include = WEB_DIR."/compose.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>