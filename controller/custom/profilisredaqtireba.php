<?php if(!defined("DIR")){ exit(); }
class profilisredaqtireba{
	function __construct($c){
		$this->template($c,"profilisredaqtireba");
	}
	
	public function template($c,$page){
		$cache = new cache();
		$text_general = $cache->index($c,"text_general");
		$data["text_general"] = json_decode($text_general,true);
		
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		$include = WEB_DIR."/profilisredaqtireba.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>