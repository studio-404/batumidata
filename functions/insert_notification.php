<?php if(!defined("DIR")){ exit(); }
class insert_notification extends connection{
	public function insert($c,$userid,$text_ge,$text_en, $url="", $type = "notification", $tousers = 'nope'){
		$conn = $this->conn($c);
		$sql = 'INSERT INTO `studio404_notifications` SET `ip`=:ip, `touserids`=:touserids, `type`=:type, `url`=:url, `actionuserid`=:insertid, `date`=:datex, `description_ge`=:textx_ge, `description_en`=:textx_en';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":ip"=>$_SERVER["REMOTE_ADDR"], 
			":insertid"=>$userid, 
			":datex"=>time(), 
			":url"=>$url,
			":type"=>$type,
			":touserids"=>$tousers,
			":textx_ge"=>$text_ge,
			":textx_en"=>$text_en
		));
	}

}
?>