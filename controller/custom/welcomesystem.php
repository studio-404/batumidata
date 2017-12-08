<?php if(!defined("DIR")){ exit(); }
class welcomesystem extends connection{
	function __construct($c){
		if(!$_SESSION["batumi_username"]){
			redirect::url(WEBSITE);
		}
		$this->template($c,"welcomesystem");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c); 
		
		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		/* language variables */
		$language_data = $cache->index($c,"language_data");
		$language_data = json_decode($language_data);
		$model_template_makevars = new  model_template_makevars();
		$data["language_data"] = $model_template_makevars->vars($language_data); 

		/* fetch last 10 user */
		$userlist = $cache->index($c,"userlist");
		$data["userlist"] = json_decode($userlist,true);

		/* last 10 products */
		$lastproducts = $cache->index($c,"lastproducts");
		$data["lastproducts"] = json_decode($lastproducts,true);


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


		$parent = 'SELECT `idx`, `title`,`background`,`slug` FROM `studio404_pages` WHERE `cid`=:cid AND `page_type`=:page_type AND `showwelcome`=1 AND `status`!=1 AND `lang`=:lang ORDER BY `position` ASC';
		$prepareParent = $conn->prepare($parent);
		$prepareParent->execute(array(
			":page_type"=>'catalogpage', 
			":cid"=>4, 
			":lang"=>LANG_ID
		));
		if($prepareParent->rowCount() > 0){
			$data["categories_list_items"] = $prepareParent->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$data["categories_list_items"] = array();
		}

		$include = WEB_DIR."/welcomesystem.php";
		if(file_exists($include))
		{
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>