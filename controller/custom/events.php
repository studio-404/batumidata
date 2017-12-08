<?php
class events extends connection{
	function __construct($c){
		$this->template($c,"events");
	}
	
	public function template($c,$page){
		echo "Hoo";
	}
}
?>