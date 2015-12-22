<?php if(!defined("DIR")){ exit(); }
class formismarTva extends connection{
	function __construct($c){
		$this->template($c,"formismarTva");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c);
		$cache = new cache();
		$text_general = $cache->index($c,"text_general");
		$data["text_general"] = json_decode($text_general,true);
		
		/* categories list */
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		/* all columns catalog table */
		$catalog_table_columns = $cache->index($c,"catalog_table_columns");
		$data["catalog_table_columns"] = json_decode($catalog_table_columns,true);

		/* all columns catalog table */
		$select_form = $cache->index($c,"select_form");
		$data["select_form"] = json_decode($select_form,true);

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

		if(Input::method("GET","parent")!=""){
			$parent = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `idx`=:idx AND `cid`=4 AND `status`!=1 AND `lang`=:lang';
			$prepareParent = $conn->prepare($parent);
			$prepareParent->execute(array(
				":idx"=>Input::method("GET","parent"), 
				":lang"=>LANG_ID
			));
			if($prepareParent->rowCount() > 0){
				$parent_fetch = $prepareParent->fetch(PDO::FETCH_ASSOC);
				$data["parent_idx"] = $parent_fetch["idx"];
				$data["parent_title"] = $parent_fetch["title"];
			}else{
				redirect::url(WEBSITE.LANG."/katalogis-marTva");
			}
		}else{
			redirect::url(WEBSITE.LANG."/katalogis-marTva");
		}

		$include = WEB_DIR."/formismarTva.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>