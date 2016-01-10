<?php if(!defined("DIR")){ exit(); }
	class loginsystem extends connection{
	function __construct($c){
		$this->template($c,"loginsystem");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c);

		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		// echo "<pre>";
		// print_r($data["welcomepage_categories"]);
		// echo "</pre>";

		$include = WEB_DIR."/loginsystem.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>