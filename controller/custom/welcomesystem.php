<?php if(!defined("DIR")){ exit(); }
class welcomesystem{
	function __construct($c){
		if(!$_SESSION["batumi_username"]){
			redirect::url(WEBSITE);
		}
		$this->template($c,"welcomesystem");
	}
	
	public function template($c,$page){
		$include = WEB_DIR."/welcomesystem.php";
		if(file_exists($include)){
		/* 
		** Here goes any code developer wants to 
		*/
		@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>