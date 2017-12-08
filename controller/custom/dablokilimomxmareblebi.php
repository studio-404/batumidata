<?php if(!defined("DIR")){ exit(); }
class dablokilimomxmareblebi extends connection{
	function __construct($c){
		$this->template($c,"dablokilimomxmareblebi");
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

		/* log list */
		$data['item_per_page'] = 10;
		if(Input::method("GET","pn") && is_numeric(Input::method("GET","pn")) && Input::method("GET","pn") > 1){
			$limit = $data['item_per_page'].",".Input::method("GET","pn"); 
		}else{
			$limit = $data['item_per_page']; 
		}

		$selectform = 'SELECT 
		(SELECT COUNT(`id`) FROM `studio404_blocked_ips`) AS allitems, 
		`studio404_blocked_ips`.* FROM `studio404_blocked_ips` ORDER BY `id` DESC LIMIT '.$limit;
		$prepare = $conn->prepare($selectform);
		$prepare->execute();
		$data['blockedips'] = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$include = WEB_DIR."/dablokilimomxmareblebi.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>