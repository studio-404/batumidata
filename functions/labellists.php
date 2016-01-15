<?php if(!defined("DIR")){ exit(); }
class labellists extends connection{
	
	public function loadlabels($c){
		$cataloglist = Input::method("GET","cataloglist");
		$conn = $this->conn($c);
		$sql = 'SELECT * FROM `studio404_forms` WHERE `cid`=:cid AND `lang`=:lang ORDER BY `id` ASC';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":cid"=>$cataloglist, 
			":lang"=>LANG_ID 
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function loadpictures($c,$name,$idx = ""){
		$conn = $this->conn($c);
		$view = ($idx == "") ? Input::method('GET','view') : $idx;
		$sql = 'SELECT 
		`studio404_gallery_file`.`idx` AS sgf_idx, 
		`studio404_gallery_file`.`file` AS sgf_file 
		FROM 
		`studio404_gallery_attachment`, `studio404_gallery_file` 
		WHERE 
		`studio404_gallery_attachment`.`connect_idx`=:connect_idx AND 
		`studio404_gallery_attachment`.`status`!=1 AND 
		`studio404_gallery_attachment`.`lang`=:lang AND 
		`studio404_gallery_attachment`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
		`studio404_gallery_file`.`fileinputname`=:fileinputname AND 
		`studio404_gallery_file`.`lang`=:lang AND 
		`studio404_gallery_file`.`status`!=1 ORDER BY `position` ASC 
		';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":connect_idx"=>$view, 
			":fileinputname"=>$name, 
			":lang"=>LANG_ID 
		));
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		return $fetch;
	}

}
?>