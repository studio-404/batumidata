<?php if(!defined("DIR")){ exit(); }
class cataloglist_names extends connection{
	public function names($c,$idxs){
		$conn = $this->conn($c);
		$idx = explode(",",$idxs); 
		$out = array();

		foreach($idx as $i){
			$sql = 'SELECT `title` FROM `studio404_pages` WHERE `idx`="'.$i.'" AND `lang`="'.LANG_ID.'"';
			$prepare = $conn->prepare($sql);
			$prepare->execute();
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			$out[] = $fetch["title"];
		}
		// echo "<pre>";
		// print_r($out);
		// echo "</pre>";
		return $out;

	}
}
?>