<?php if(!defined("DIR")){ exit(); }
			class loginsystem{
	function __construct($c){
		$this->template($c,"loginsystem");
	}
	
	public function template($c,$page){
		$include = WEB_DIR."/loginsystem.php";
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