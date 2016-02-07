<?php if(!defined("DIR")){ exit(); }
class grabusersdata extends connection{
	public function usersdata($c, $u_id){
		$conn = $this->conn($c); 
		$fetch = array();
		if(!is_array($u_id)){
			$sql = 'SELECT * FROM `studio404_users` WHERE `id`=:id';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":id"=>$u_id
			));
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			}
		}else if(is_array($u_id) && !empty($u_id) && $u_id!=""){
			$in = implode(',',$u_id);
			if($in){
				$sql = 'SELECT * FROM `studio404_users` WHERE `id` IN ('.$in.')';
				$prepare = $conn->prepare($sql);
				$prepare->execute();
				if($prepare->rowCount() > 0){
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
				}
			}
		}
		return $fetch;
	}
}
?>