<?php if(!defined("DIR")){ exit(); }
class welcomesystem{
	function __construct($c){
		if(!$_SESSION["batumi_username"]){
			redirect::url(WEBSITE);
		}
		$this->template($c,"welcomesystem");
	}
	
	public function template($c,$page){
		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

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