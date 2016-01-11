<?php if(!defined("DIR")){ exit(); }
class monacemisnaxva extends connection{
	function __construct($c){
		if(!Input::method("GET","view") || !is_numeric(Input::method("GET","view"))){
			redirect::url(WEBSITE.LANG."/welcomesystem"); 
		}
		$this->template($c,"monacemisnaxva");
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

		$data["cataloglist_names"] = new cataloglist_names();
        $data["getusername"] = new getusername();

		$labellists = new labellists();
		$data["labellists"] = $labellists->loadlabels($c);
		
		
		$sql2 = 'SELECT 
		`studio404_module_item`.* 
		FROM `studio404_module_item` WHERE 
		`module_idx`=25 AND 
		`studio404_module_item`.`idx`=:idx AND 
		`studio404_module_item`.`lang`=:lang AND 
		`studio404_module_item`.`status`!=:status';	
		$prepare2 = $conn->prepare($sql2); 
		$prepare2->execute(array(
			":idx"=>Input::method("GET","view"), 
			":lang"=>LANG_ID, 
			":status"=>1 
		));
		if($prepare2->rowCount() > 0){
			$data["fetch"]  = $prepare2->fetch(PDO::FETCH_ASSOC);
		}else{
			redirect::url(WEBSITE.LANG."/welcomesystem"); 
		}
		$include = WEB_DIR."/monacemisnaxva.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>