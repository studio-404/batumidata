<?php if(!defined("DIR")){ exit(); }
class select_sub_catalog extends connection{
	public function select($c,$idx){
		$conn = $this->conn($c); 
		$sql = 'SELECT `idx`,`cid`,`title`,`slug` FROM `studio404_pages` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=1 ORDER BY `position` ASC';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":cid"=>$idx, 
			":lang"=>LANG_ID
		));
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}else{ $fetch = array(); }
		return $fetch;
	}
}
?>