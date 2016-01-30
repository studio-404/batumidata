<?php if(!defined("DIR")){ exit(); }
class receiver extends connection{
	public function names($c,$ids){
		$conn = $this->conn($c); 
		$id = explode(",",$ids); 
		$select = 'SELECT `namelname` FROM `studio404_users` WHERE `id` IN ('.implode(",",$id).')'; 
		$prepare = $conn->prepare($select); 
		$prepare->execute();
		$names = '';
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			foreach ($fetch as $value) {
				$names .= $value["namelname"].", ";
			}
		}
		$names = rtrim($names,", "); 
		return $names;
	}
}
?>