<?php if(!defined("DIR")){ exit(); }
class select_disallowed_items extends connection{

	public function cc($c){
		$conn = $this->conn($c); 

		$sql2 = 'SELECT 
		COUNT(`studio404_module_item`.`idx`) AS allitems
		FROM `studio404_module_item` WHERE 
		`studio404_module_item`.`lang`=:lang AND 
		`studio404_module_item`.`module_idx`=25 AND 
		`studio404_module_item`.`visibility`=:visibility AND 
		`studio404_module_item`.`status`!=:status';	
		$prepare2 = $conn->prepare($sql2); 
		$prepare2->execute(array(
			":lang"=>LANG_ID, 
			":status"=>1, 
			":visibility"=>1 
		));
		$fetch  = $prepare2->fetch(PDO::FETCH_ASSOC);
		$count = $fetch["allitems"]; 
		return $count;
		
	}

}
?>