<?php if(!defined("DIR")){ exit(); }
class model_template_upload_user_logo extends connection{
	function __construct(){

	}

	public function upload($c){
		
		if(isset($_FILES["profileimage"]["name"]) && !empty($_FILES["profileimage"]["name"]) && isset($_SESSION["batumi_username"])){
			$ext = explode(".",$_FILES["profileimage"]["name"]);
			$ext = strtolower(end($ext));

			if($ext!="jpg"){
				//return 2;
			}else if($_FILES["profileimage"]["size"]>1000000){
				//return 2;
			}else{
				$prefix = explode("@",$_SESSION["batumi_username"].$_SESSION["batumi_id"]);
				if(is_array($prefix) && !empty($prefix[0])){ $prefix = $prefix[0];  }else{ $prefix = '_'; }
				$fileName = $prefix.md5(time()).'.'.$ext; 
				
				$target_file = DIR . 'files/usersimage/'.$fileName;
				 if (move_uploaded_file($_FILES["profileimage"]["tmp_name"],$target_file)) {
				 	$conn = $this->conn($c); 

				 	$check = 'SELECT `picture` FROM `studio404_users` WHERE `id`=:companyId AND `username`=:username AND `status`!=:one'; 
				 	$pre_check = $conn->prepare($check);
				 	$pre_check->execute(array(
				 		":username"=>$_SESSION["batumi_username"], 
				 		":companyId"=>$_SESSION["batumi_id"], 
				 		":one"=>1
				 	));
				 	$ch_fetch = $pre_check->fetch(PDO::FETCH_ASSOC); 
				 	if(!empty($ch_fetch["picture"])){
				 		$old_pic = DIR . 'files/usersimage/'.$ch_fetch["picture"]; 
				 		@unlink($old_pic);
				 	}

				 	$sql = 'UPDATE `studio404_users` SET `picture`=:picture WHERE `id`=:companyId AND `username`=:username AND `status`!=:one'; 
				 	$prepare = $conn->prepare($sql); 
				 	$prepare->execute(array(
				 		":username"=>$_SESSION["batumi_username"], 
				 		":companyId"=>$_SESSION["batumi_id"], 
				 		":one"=>1, 
				 		":picture"=>$fileName
				 	));
				 	$_SESSION["batumi_picture"] = $fileName;
				 	if(Input::method("POST","typo")!="self"){
				 		redirect::url(WEBSITE.LANG."/welcome-system");
				 	}
        			//return 1;
    			}else{
    				//return 2; 
    			}
			}
		}


		if(isset($_FILES["profileimage2"]["name"]) && !empty($_FILES["profileimage2"]["name"])){
			$ext = explode(".",$_FILES["profileimage2"]["name"]);
			$ext = strtolower(end($ext));
			if($ext!="jpg"){
				//return 2;
			}else if($_FILES["profileimage2"]["size"]>1000000){
				//return 2;
			}else{
				$prefix = $_SESSION["batumi_id"];
				$fileName = $prefix.md5(time()).'.'.$ext; 
				
				$target_file = DIR . 'files/usersimage/'.$fileName;
				 if (move_uploaded_file($_FILES["profileimage2"]["tmp_name"],$target_file)) {
				 	$conn = $this->conn($c); 

				 	$sql = 'UPDATE `studio404_users` SET `picture`=:picture WHERE `id`=:companyId AND `status`!=:one'; 
				 	$prepare = $conn->prepare($sql); 
				 	$prepare->execute(array(
				 		":companyId"=>Input::method("POST","companyId"), 
				 		":one"=>1, 
				 		":picture"=>$fileName
				 	));

				 	if(Input::method("POST","typo")!="self"){
				 		redirect::url(WEBSITE.LANG."/momxmareblis-marTva");
				 	}
        			//return 1;
    			}else{
    				//return 2; 
    			}
			}
		}



	} 
}
?>