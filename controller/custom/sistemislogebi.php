<?php if(!defined("DIR")){ exit(); }
class sistemislogebi extends connection{
	function __construct($c){
		$this->template($c,"sistemislogebi");
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
			$from = $data['item_per_page'] * (Input::method("GET","pn")-1);
			$to = $data['item_per_page'];
		}else{
			$limit = $data['item_per_page']; 
			$from = 0;
			$to = $data['item_per_page'];
		}

		$selectform = 'SELECT 
		(SELECT COUNT(`id`) FROM `studio404_logs` WHERE `logtry`="Batumi intranet enter" OR `logtry`="Batumi intranet log try") AS allitems, 
		`studio404_logs`.* FROM `studio404_logs` WHERE `logtry`="Batumi intranet enter" OR `logtry`="Batumi intranet log try" ORDER BY `date` DESC LIMIT '.$from.','.$to;
		$prepare = $conn->prepare($selectform);
		$prepare->execute();
		$data['systemlogs'] = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$include = WEB_DIR."/sistemislogebi.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>