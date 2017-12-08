<?php if(!defined("DIR")){ exit(); }
class subcategory extends connection{

	public function counts($c,$idx){
		$conn = $this->conn($c); 
		$count = 0;
		$sql = 'SELECT COUNT(`id`) AS cc FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=1 AND `lang`=:lang';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":cid"=>$idx, 
			":lang"=>LANG_ID 
		));
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			$count = $fetch['cc'];
		}
		return $count;
	}

	public function select($c,$idx){
		$conn = $this->conn($c); 
		$fetch = array();
		$sql = 'SELECT 
		`idx`,`title` 
		FROM 
		`studio404_pages` 
		WHERE 
		`cid`=:cid AND 
		`status`!=1 AND 
		`lang`=:lang';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":cid"=>$idx, 
			":lang"=>LANG_ID 
		));
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
		}
		return $fetch;
	}

}

?>