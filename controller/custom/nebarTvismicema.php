<?php if(!defined("DIR")){ exit(); }
class nebarTvismicema extends connection{
	function __construct($c){
		$this->template($c,"nebarTvismicema");
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

		$sql2 = 'SELECT 
		COUNT(`studio404_module_item`.`idx`) AS allitems
		FROM `studio404_module_item` WHERE 
		`studio404_module_item`.`lang`=:lang AND 
		`studio404_module_item`.`visibility`=:visibility AND 
		`studio404_module_item`.`status`!=:status';	
		$prepare2 = $conn->prepare($sql2); 
		$prepare2->execute(array(
			":lang"=>LANG_ID, 
			":status"=>1, 
			":visibility"=>1 
		));
		$data["fetch"]  = $prepare2->fetch(PDO::FETCH_ASSOC);

		$include = WEB_DIR."/nebarTvismicema.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>