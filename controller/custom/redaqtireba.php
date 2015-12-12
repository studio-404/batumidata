<?php if(!defined("DIR")){ exit(); }
class redaqtireba extends connection{
	function __construct($c){
		if(!$_SESSION["batumi_username"]){
			redirect::url(WEBSITE);
		}
		$this->template($c,"redaqtireba");
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

		if(Input::method("GET","id")!=""){
			$parent = 'SELECT `title` FROM `studio404_pages` WHERE `idx`=:idx AND `page_type`=:page_type AND `status`!=1 AND `lang`=:lang';
			$prepareParent = $conn->prepare($parent);
			$prepareParent->execute(array(
				":page_type"=>'catalogpage', 
				":idx"=>Input::method("GET","id"), 
				":lang"=>LANG_ID
			));
			if($prepareParent->rowCount() > 0){
				$parent_fetch = $prepareParent->fetch(PDO::FETCH_ASSOC);
				$data["parent_title"] = $parent_fetch["title"];
			}else{
				redirect::url(WEBSITE.LANG."/katalogis-marTva");
			}
		}

		$include = WEB_DIR."/redaqtireba.php";
		if(file_exists($include)){
		@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>