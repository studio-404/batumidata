<?php if(!defined("DIR")){ exit(); } 
class getusername extends connection{

	public function names($c,$id){
		$conn = $this->conn($c); 
		$sql = 'SELECT `namelname` FROM `studio404_users` WHERE `id`="'.(int)$id.'"';
		$prepare = $conn->prepare($sql);
		$prepare->execute(); 
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
		$out = $fetch["namelname"];
		return $out;
	}

}
?>