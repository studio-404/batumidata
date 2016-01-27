<?php if(!defined("DIR")){ exit(); }
class draft extends connection{
	function __construct($c){
		$this->template($c,"draft");
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

		$catalogitemsnovisiable = $cache->index($c,"catalogitemsnovisiable");
		$data["catalogitems"] = json_decode($catalogitemsnovisiable,true);

		$include = WEB_DIR."/draft.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>