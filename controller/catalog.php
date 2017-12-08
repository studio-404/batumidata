<?php if(!defined("DIR")){ exit(); }
class catalog extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		if(!Input::method("GET","idx")){
			redirect::url(WEBSITE.LANG."/welcomesystem");
		}


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

		$catalog_table_list = $cache->index($c,"catalog_table_list");
		$data["catalog_table_list"] = json_decode($catalog_table_list,true);

		$catalogitems = $cache->index($c,"catalogitems");
		$data["catalogitems"] = json_decode($catalogitems,true);

		$catalog_form = $cache->index($c,"catalog_form");
		$data["catalog_form"] = json_decode($catalog_form,true);

		
		$already = array();
		if(Input::method("GET","filter")=="true"){
			try{
				$searchKey = ' AND ';
				$idx = Input::method("GET","idx");
				foreach ($_GET as $key => $value) {
					if($key=="idx" || $key=="filter" || $value=="" || empty($value)){ continue; }
					if(is_array($value)){// checkbox 
						if(!in_array($key, $already)){
							$already[] = $key;
							$s = '( ';
							foreach($value as $v) {
								$s .= 'FIND_IN_SET("'.$v.'", `studio404_module_item`.`'.$key.'`) OR ';
							}
							$s .= '`studio404_module_item`.`id`=0 ) AND ';
							$searchKey .= $s;
						}else{
							continue;
						}
					}else{
						if(validatedate::val($value,"d-m-Y")){ // date
							$d = strtotime($value);
							$searchKey .= '`studio404_module_item`.`'.$key.'`="'.$d.'" AND ';
						}else{ // text, select
							$searchKey .= '`studio404_module_item`.`'.$key.'` LIKE "%'.$value.'%" AND ';
						}
					}
				}
				$searchKey .= '`studio404_module_item`.`id` != "0" ';
				$offset = (Input::method("GET","pn")) ? Input::method("GET","pn")-1 : 0;
				$sw = (Input::method("GET","sw") && is_numeric(Input::method("GET","sw"))) ? Input::method("GET","sw") : 10;
				if(!Input::method("GET","pn") || !is_numeric(Input::method("GET","pn"))){ $offset = 0; }
				$sql = 'SELECT 
				`studio404_module_item`.*
				FROM `studio404_module_item` WHERE 
				FIND_IN_SET('.Input::method("GET","idx").', `studio404_module_item`.`cataloglist`) AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`visibility`!=:visibility AND 
				`studio404_module_item`.`status`!=:status '.$searchKey.' ORDER BY `studio404_module_item`.`id` DESC LIMIT '.$offset.', '.$sw;	
				
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":lang"=>LANG_ID, 
					":status"=>1, 
					":visibility"=>1 
				)); 
				$data["catalogitems"] = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			}catch(Exception $e){
			}
		}

		$sql2 = 'SELECT 
		COUNT(`studio404_module_item`.`idx`) AS allitems
		FROM `studio404_module_item` WHERE 
		FIND_IN_SET('.(int)Input::method("GET","idx").', `studio404_module_item`.`cataloglist`) AND 
		`studio404_module_item`.`lang`=:lang AND 
		`studio404_module_item`.`visibility`!=:visibility AND 
		`studio404_module_item`.`status`!=:status';	
		$prepare2 = $conn->prepare($sql2); 
		$prepare2->execute(array(
			":lang"=>LANG_ID, 
			":status"=>1, 
			":visibility"=>1 
		));
		$data["fetch"]  = $prepare2->fetch(PDO::FETCH_ASSOC);


		@include($c["website.directory"]."/catalog.php"); 
	}
}
?>