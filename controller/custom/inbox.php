<?php if(!defined("DIR")){ exit(); }
class inbox extends connection{
	function __construct($c){
		$this->template($c,"inbox");
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

		$sql2 = 'SELECT 
		`studio404_messages`.*, 
		`studio404_users`.`namelname` AS fromusername 
		FROM 
		`studio404_messages`, `studio404_users`
		WHERE 
		`studio404_messages`.`fromuser`=`studio404_users`.`id` AND 
		`studio404_messages`.`tousers`=:tousers AND 
		`studio404_messages`.`draft`=0 AND 
		`studio404_messages`.`status`=0 LIMIT 20';
		$prepare2 = $conn->prepare($sql2);
		$prepare2->execute(array(
			":tousers"=>$_SESSION["batumi_id"]
		));
		if($prepare2->rowCount() > 0){
			$fetch2 = $prepare2->fetchAll(PDO::FETCH_ASSOC);
			$data["messages"] = $fetch2;
		}else{
			$data["messages"] = array();
		}

		$catalog_general = $cache->index($c,"catalog_general");
		$data["catalog_general"] = json_decode($catalog_general,true);

		$catalogitemsnovisiable = $cache->index($c,"catalogitemsnovisiable");
		$data["catalogitems"] = json_decode($catalogitemsnovisiable,true);
		
		
		$include = WEB_DIR."/inbox.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>