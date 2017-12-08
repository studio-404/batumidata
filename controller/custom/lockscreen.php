<?php if(!defined("DIR")){ exit(); }
class lockscreen extends connection{
	function __construct($c){
		$this->template($c,"lockscreen");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c);
		
		$cache = new cache();
		$text_general = $cache->index($c,"text_general");
		$data["text_general"] = json_decode($text_general,true);
		
		$language_data = $cache->index($c,"language_data");
		$language_data = json_decode($language_data);
		$model_template_makevars = new  model_template_makevars();
		$data["language_data"] = $model_template_makevars->vars($language_data); 
		
		$include = WEB_DIR."/lockscreen.php";
		if(file_exists($include)){	
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>