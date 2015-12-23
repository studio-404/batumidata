<?php if(!defined("DIR")){ exit(); }
class clearcache{
	public static function do(){
		$files = glob(DIR.'_cache/*'); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file))
			@unlink($file); // delete file
		}
	}
}
?>