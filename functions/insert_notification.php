<?php if(!defined("DIR")){ exit(); }
class insert_notification extends connection{
	public function insert($c,$userid,$text_ge,$text_en){
		$conn = $this->conn($c);
		$sql = 'INSERT INTO `studio404_notifications` SET `ip`=:ip, `actionuserid`=:insertid, `date`=:datex, `description_ge`=:textx_ge, `description_en`=:textx_en';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":ip"=>$_SERVER["REMOTE_ADDR"], 
			":insertid"=>$userid, 
			":datex"=>time(), 
			":textx_ge"=>$text_ge,
			":textx_en"=>$text_en
		));
	}
}
?>