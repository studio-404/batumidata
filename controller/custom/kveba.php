<?php if(!defined("DIR")){ exit(); }
			class kveba{
				function __construct($c){
					$this->template($c,"kveba");
				}
				
				public function template($c,$page){
					$include = WEB_DIR."/kveba.php";
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