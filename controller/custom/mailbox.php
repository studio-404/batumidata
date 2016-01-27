<?php if(!defined("DIR")){ exit(); }
class mailbox{
	function __construct($c){
		redirect::url(WEBSITE.$c['main.language']."/mailbox/inbox");
		// $this->template($c,"mailbox");
	}
	
	public function template($c,$page){

	}
}
?>