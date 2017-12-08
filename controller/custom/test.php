<?php if(!defined("DIR")){ exit(); }
			class test{
				function __construct($c){
					$this->template($c,"test");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/test.php";
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