<?php if(!defined("DIR")){ exit(); }
class katalogisdamateba extends connection{
	function __construct($c){
		if(!$_SESSION["batumi_username"]){
			redirect::url(WEBSITE);
		}
		$this->template($c,"katalogisdamateba");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c);

		$cache = new cache();
		$text_general = $cache->index($c,"text_general");
		$data["text_general"] = json_decode($text_general,true);
		
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		/* language variables */
		$language_data = $cache->index($c,"language_data");
		$language_data = json_decode($language_data);
		$model_template_makevars = new  model_template_makevars();
		$data["language_data"] = $model_template_makevars->vars($language_data); 

		/* Upload Users profile picture */
		if(isset($_FILES["profileimage"]["name"])){
			$model_template_upload_user_logo = new model_template_upload_user_logo();
			$upload = $model_template_upload_user_logo->upload($c);
		}

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


		$include = WEB_DIR."/katalogisdamateba.php";
		
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>