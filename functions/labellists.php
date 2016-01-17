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
		`studio404_gallery_file`.`gallery_idx` AS sgf_gallery_idx, 
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

	public function loadpictures_gallery_idx($c){
		$conn = $this->conn($c);
		$idx = Input::method('GET','idx');
		$sql = 'SELECT 
		`studio404_gallery_attachment`.`idx` AS sga_idx 
		FROM 
		`studio404_gallery_attachment`
		WHERE 
		`studio404_gallery_attachment`.`connect_idx`=:connect_idx AND 
		`studio404_gallery_attachment`.`status`!=1 AND 
		`studio404_gallery_attachment`.`lang`=:lang
		';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":connect_idx"=>$idx, 
			":lang"=>LANG_ID 
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		$out = $fetch["sga_idx"];
		return $out;
	}

}
?>