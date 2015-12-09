<?php if(!defined("DIR")){ exit(); }
class catalog extends connection{
	function __construct($c){
		$this->template($c);
	}

	public function template($c){
		$conn = $this->conn($c); // connection

		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		$catalog_general = $cache->index($c,"catalog_general");
		$data["catalog_general"] = json_decode($catalog_general,true);

		@include($c["website.directory"]."/catalog.php"); 
	}
}
?>