<?php if(!defined("DIR")){ exit(); }
class select_form_label extends connection{
	public function label($c,$vv){

		$conn = $this->conn($c);
		$sql = 'SELECT `label` FROM `studio404_forms` WHERE `attach_column` LIKE "%'.$vv.'%" AND `lang`=:lang';
  		$prepare = $conn->prepare($sql); 
  		$prepare->execute(array(
  			":lang"=>1 
  		));

  		
  		if($prepare->rowCount() > 0){
 			$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
  			$out = $fetch["label"];
  		}else{
  			$out = $vv;
  		}
  		return $out;
	}
}
?>