<?php if(!defined("DIR")){ exit(); }
class ajax extends connection{
	public $subject,$name,$email,$message,$lang,$ip;

	function __construct($c){
		if(!isset($_SESSION["requestWiev"])){
			$_SESSION["requestWiev"] = 1;
		}else{
			$_SESSION["requestWiev"]++;
		}
		if(isset($_SESSION["requestWiev"]) && $_SESSION["requestWiev"]>100000){
			//after 10 000 request shut it down
			die('E');
		}
		$this->requests($c);
	}

	public function requests($c){ 

		// .catalog-add-form-data .form-input
		// #add-catalogue-item
		$conn = $this->conn($c); 

		if(Input::method("POST","checknotification")=="true" && $_SESSION["batumi_id"]){
			$cachfile = "_cache/notifications_".$_SESSION["batumi_id"].".json"; 
			if(file_exists($cachfile)){
				echo file_get_contents($cachfile); 
			}else{
				$session_id = $_SESSION['batumi_id'];
				$select = 'SELECT 
				`studio404_notifications`.*, 
				(SELECT `studio404_users`.`namelname` FROM `studio404_users` WHERE `studio404_users`.`id`=`studio404_notifications`.`actionuserid`) AS usersnamelname,  
				(SELECT `studio404_users`.`picture` FROM `studio404_users` WHERE `studio404_users`.`id`=`studio404_notifications`.`actionuserid`) AS userspicture 
				FROM 
				`studio404_notifications` 
				WHERE 
				NOT FIND_IN_SET('.$session_id.',`studio404_notifications`.`seen`) AND 
				`studio404_notifications`.`actionuserid`!=:actionuserid AND 
				(`studio404_notifications`.`touserids`="nope" || FIND_IN_SET('.$session_id.',`studio404_notifications`.`touserids`)) 
				ORDER BY `studio404_notifications`.`id` ASC 
				';
				$prepare = $conn->prepare($select); 
				$prepare->execute(array(
					":actionuserid"=>$session_id
				)); 

				if($prepare->rowCount() > 0){
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

					$fh = @fopen($cachfile, 'w') or die("Error opening output file");
					@fwrite($fh, json_encode($fetch,JSON_UNESCAPED_UNICODE));
					@fclose($fh);
					echo file_get_contents($cachfile); 
				}else{
					echo "Error"; 
				}
			}
			exit();
		}

		if(Input::method("POST","loadcatalogform")=="true" && Input::method("POST","v")){
			$sql = 'SELECT * FROM `studio404_forms` WHERE `cid`=:cid AND `lang`=:lang ORDER BY `id` ASC';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":cid"=>Input::method("POST","v"), 
				":lang"=>1
			));
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			echo "<div style='text-align:left' class='catalog-add-form-data'>";
			$select_form = new select_form();
			$file_count = 0;
			foreach($fetch as $form){
			if($form["type"]=="text"){
				if($form["important"]=="yes"){ $dataimportant = "data-important='true'"; }
				else{ $dataimportant = "data-important='false'"; }
			?>
	            <div class="form-group">
	               <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	               <input class="form-control form-input" type="text" placeholder="<?=$form["placeholder"]?>" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="text" data-important="<?=$form["important"]?>" value="" />
	               </div>
            <?php
            }else if($form["type"]=="select"){ 
            	$fetchx = $select_form->select_options($c,$form["id"],Input::method("POST","v"),1);
            ?>
            <div class="form-group">
	            <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	            <select class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="select">
				<?php
				
				foreach ($fetchx as $value) {
				    echo '<option value="'.htmlentities($value["text"]).'">'.$value["text"].'</option>';
				}
			?>
			</select>
	        </div>
            <?php
            }else if($form["type"]=="checkbox"){
            ?>
            <div class="form-group">
	        <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	        <?php
			$fetchx = $select_form->select_options($c,$form["id"],Input::method("POST","v"),1);
			foreach ($fetchx as $value) {
			echo '<div class="checkbox">';
			echo '<label><input type="checkbox" class="form-input" data-name="'.$form["name"].'" data-attach="'.$form["attach_column"].'" data-important="'.$form["important"].'" data-type="checkbox" value="'.htmlentities($value["text"]).'" />'.$value["text"].'</label>';
			echo '</div>';
			}
			?>
	        </div>
            <?php
            }else if($form["type"]=="filex"){ // not signed cant upload
            	$multiple = ""; // not signed cant upload multy
            	$fileformat = $form["attach_format"];
            	$fileformat = explode(",",$form["attach_format"]);
            	$accept = "";
            	foreach ($fileformat as $value) {
            		$accept .= ".".$value.",";
            	}
            ?>
            	<label><?=$form["label"]?>: <?=($multiple=="multiple") ? '<a href="javascript:void(0)" class="makemedouble" data-doubleid="form-name-'.$file_count.'" data-filename="file['.$file_count.'][]" data-fileaccept="'.$accept.'"><i class="glyphicon glyphicon-plus-sign"></i></a>' : ''?><?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?> ( <?=$form["attach_format"]?> )</label> <!-- Fisrname & lastname -->
        		<input type="hidden" name="file" value="true" />
        		<input type="hidden" name="filenumber[<?=$file_count?>]" value="<?=$file_count?>" />
        		<input type="hidden" name="form-name-<?=$file_count?>" value="<?=$form["name"]?>" />
        		<input type="hidden" name="form-attach-<?=$file_count?>" value="<?=$form["attach_column"]?>" />
        		<input type="hidden" name="form-important-<?=$file_count?>" value="<?=$form["important"]?>" />
        		<input type="hidden" name="form-multiple-<?=$file_count?>" value="<?=$multiple?>" />
        		<input type="hidden" name="form-format-<?=$file_count?>" value="<?=$form["attach_format"]?>" />
        		<?php 
        		if($multiple){
        			echo '<span id="form-name-'.$file_count.'"><input class="form-control form-input" type="file" name="file['.$file_count.'][]" value="" accept="'.$accept.'" /></span>';
        		}else{
        		?>
        			<input class="form-control form-input" type="file" name="file[<?=$file_count?>][]" value="" accept="<?=$accept?>" />
        		<?php } ?>
	            <!-- <div class="form-group">
		        	<label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> 
		        	<input class="form-control form-input" type="file" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="file" data-important="<?=$form["important"]?>" data-multiple="<?=$multiple?>" data-formatsx="<?=$form["attach_format"]?>" value="" <?=$multiple?>/>
		        </div> -->
            <?php
            }else if($form["type"]=="date"){
            ?>
            <div class="form-group">
	        <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	        <input type="text" class="form-control form-input" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="date" value="dd/mm/YYYY" />
	        </div>
            <?php
            }else if($form["type"]=="textarea"){
            ?>
            <div class="form-group">
	        <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	        <textarea class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="textarea" data-important="<?=$form["important"]?>"></textarea>
	        </div>
            <?php
            }
            $file_count++;
			}
			echo '</div>'; 
			exit();
		}

		if(Input::method("POST","deleteGalleryItem")=="true" && is_numeric(Input::method("POST","i"))){
			$sql = 'SELECT `file` FROM `studio404_gallery_file` WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":idx"=>Input::method("POST","i")
			));
			if($prepare->rowCount() > 0){
				$update = 'UPDATE `studio404_gallery_file` SET `status`=:status WHERE `idx`=:idx';
				$prepareup = $conn->prepare($update);
				$prepareup->execute(array(
					":idx"=>Input::method("POST","i"), 
					":status"=>1
				));

				$fecth = $prepare->fetch(PDO::FETCH_ASSOC);
				$getFile = DIR.$fecth['file']; 
				if(file_exists($getFile)){
					@unlink($getFile); 
				}

				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"ფოტოს წაშლა ::".Input::method("POST","i"),"Delete Photo ::".Input::method("POST","i"));

				echo "Done";
			}
		}

		if(Input::method("POST","sendmessage")=="true" && Input::method("POST","u") && Input::method("POST","s") && Input::method("POST","m") && Input::method("POST","a")){
			$u = json_decode(Input::method("POST","u"),true);
			$count = count($u);
			if($count>0){	
				$attach = (Input::method("POST","a")=="true") ? 1 : 0;
				$draft = (Input::method("POST","d")=="yes") ? 1 : 0;
				$tousers = implode(",",$u);
				$sql = 'INSERT INTO `studio404_messages` SET `date`=:date, `ip`=:ip, `fromuser`=:fromuser, `tousers`=:tousers, `subject`=:subject, `text`=:textx, `attchment`=:attchment, `draft`=:draft';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":date"=>time(), 
					":ip"=>get_ip::ip(), 
					":fromuser"=>$_SESSION["batumi_id"], 
					":tousers"=>$tousers, 
					":subject"=>Input::method("POST","s"), 
					":textx"=>Input::method("POST","m"), 
					":draft"=>$draft, 
					":attchment"=>$attach
				));
				$lastInsertId = $conn->lastInsertId();
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}
				
				$url = WEBSITE.'ge/mailbox/readmail?id='.$lastInsertId.'&back=mailbox/inbox::';
				$url .= WEBSITE.'en/mailbox/readmail?id='.$lastInsertId.'&back=mailbox/inbox';

				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],Input::method("POST","s"),Input::method("POST","s"),$url,"message",$tousers);

				echo $conn->lastInsertId();
			}else{
				echo "Error";
			}
		}

		if(Input::method("POST","messageseen")=="true"){
			$session_id = $_SESSION["batumi_id"]; 
			$sql = 'UPDATE `studio404_notifications` SET `seen` = CONCAT(`seen`, "'.$session_id.',") WHERE `type`="message" AND FIND_IN_SET("'.$session_id.'", `touserids`) AND NOT FIND_IN_SET("'.$session_id.'", `seen`)';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(); 
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			echo "Done";
		}

		//
		if(Input::method("POST","notification_count")=="true"){
			$session_id = $_SESSION["batumi_id"]; 
			$sql = 'UPDATE `studio404_notifications` SET `seen` = CONCAT(`seen`, "'.$session_id.',") WHERE `type`="notification" AND NOT FIND_IN_SET("'.$session_id.'", `seen`)';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(); 
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			echo "Done";
		}


		if(Input::method("POST","removeUnpublished")=="true" && Input::method("POST","i")){
			$sql = 'UPDATE `studio404_module_item` SET `status`=1 WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql); 
			$idx = (int)Input::method("POST","i");
			$prepare->execute(array(
				":idx"=>$idx
			));

			$sql2 = 'UPDATE `studio404_gallery_attachment` SET `status`=1 WHERE `connect_idx`=:idx';
			$prepare2 = $conn->prepare($sql2); 
			$prepare2->execute(array(
				":idx"=>$idx
			));

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"წაშალა მონაცემი ს.კ: N".$idx,"Deleted Item ID: N".$idx);

			echo "Done";
		}

		if(Input::method("POST","givepermision")=="true"){
			$idx = (Input::method("POST","p") && is_numeric(Input::method("POST","p"))) ? Input::method("POST","p") : 0;
			if($idx==0){ $idx = (Input::method("POST","i")) ? Input::method("POST","i") : 0; }
			$sql = 'UPDATE `studio404_module_item` SET `visibility`=2 WHERE `idx`='.$idx.' AND `status`!=1';
			$conn->query($sql);
			
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}

			echo "Done";
			exit();
		}

		if(Input::method("POST","removepermision")=="true"){
			$idx = (Input::method("POST","p") && is_numeric(Input::method("POST","p"))) ? Input::method("POST","p") : 0;
			$sql = 'UPDATE `studio404_module_item` SET `visibility`=1 WHERE `idx`='.$idx;
			$conn->query($sql);

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"ნებართვის მოხსნა ::".$idx,"Remove Permision ::".$idx);

			echo "Done";
			exit();
		}

		if(Input::method("POST","addCatalogItem")=="true"){
			if(!isset($_SESSION["batumi_id"])){
				$_SESSION["batumi_id"] = 0;
			}
			$macat = json_decode(Input::method("POST","macat"),true);
			$types = json_decode(Input::method("POST","ta"),true);
			$values = json_decode(Input::method("POST","va"),true);
			$names = json_decode(Input::method("POST","na"),true);
			$db_columns = json_decode(Input::method("POST","ca"),true);
			$checkbox_values = json_decode(Input::method("POST","ca2"),true);
			$importent = json_decode(Input::method("POST","ia"),true);

			$sql = 'SELECT 
			MAX(`idx`) AS maxidx, 
			(SELECT MAX(`position`) FROM `studio404_module_item` WHERE `status`!=1 ) AS maxposition
			FROM 
			`studio404_module_item`';
			$prepare = $conn->prepare($sql); 
			$prepare->execute();
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$maxidx = $fetch["maxidx"]+1;
				$maxposition = $fetch["maxposition"]+1;
			}else{
				$maxidx = 1;
				$maxposition = 1;
			}

			//select gallery max idx
			$sqlg = 'SELECT MAX(`idx`) AS maxid FROM `studio404_gallery` WHERE `lang`=:lang';
			$prepareg = $conn->prepare($sqlg);
			$prepareg->execute(array(
				":lang"=>1
			));
			$fetchg = $prepareg->fetch(PDO::FETCH_ASSOC);
			$gallery_maxidx = ($fetchg['maxid']) ? ($fetchg['maxid'] + 1) : 1; 

			$columns_and_data = '';
			$xx = 0;
			foreach($db_columns as $val){
				if($types[$xx]=="text" || $types[$xx]=="select" || $types[$xx]=="textarea" || $types[$xx]=="dateandtimerange"){
					$columns_and_data .= '`'.$val.'`="'.str_replace('"',"&quot;",$values[$xx]).'", ';
				}else if($types[$xx]=="checkbox"){
					if($checkbox_values[$xx]=="yes"){
						$checkboxdata_value[$val][] = str_replace('"',"&quot;",$values[$xx]);
					}
				}else if($types[$xx]=="file"){
					$columns_and_data .= '`'.$val.'`="'.str_replace('"',"&quot;",$values[$xx]).'", ';
				}else if($types[$xx]=="date"){
					$timestamp = strtotime(str_replace('/', '-', $values[$xx])); 
					$columns_and_data .= '`'.$val.'`="'.$timestamp.'", ';
				}
				$xx++;
			}
			
			if(isset($checkboxdata_value) && is_array($checkboxdata_value)){
				foreach($checkboxdata_value as $key => $value){
					$columns_and_data .= '`'.$key.'`="'.implode(",",$checkboxdata_value[$key]).'", ';
				}
			}
			$uid = new uid();
			$u = $uid->generate(9);
			$url = '';
			foreach ($c['languages.num.array'] as $l) {
				$insert = 'INSERT INTO `studio404_module_item` SET '.$columns_and_data.' `cataloglist`="'.implode(",",$macat).'", `insert_ip`="'.get_ip::ip().'", `insert_admin`="'.$_SESSION["batumi_id"].'", `position`="'.$maxposition.'", `idx`="'.$maxidx.'", `visibility`=2, `lang`="'.$l.'", `uid`="'.$u.'", `date`="'.time().'", `expiredate`="'.time().'", `module_idx`="25" ';
				$query = $conn->query($insert);
				$insertId = $conn->lastInsertId();

				$s = 'SELECT `idx` FROM studio404_module_item WHERE `id`=:id';
				$p = $conn->prepare($s);
				$p->execute(array(
					":id"=>$insertId
				));	
				if($p->rowCount() > 0){
					$f = $p->fetch(PDO::FETCH_ASSOC);
					$p = Input::method("POST","p");
					$url .= WEBSITE.'ge/monacemis-redaqtireba?parent='.$p.'&idx='.$f['idx'].'&back=http://batumi.404.ge/ge/Cemi-galerea?idx='.$p.'::';
				}
				
				// insert gallery
				$sql_media = 'INSERT INTO `studio404_gallery` SET 
				`idx`=:idx, 
				`date`=:datex,
				`title`=:title, 
				`lang`=:lang, 
				`status`=:status 
				';
				$prepare_media = $conn->prepare($sql_media);
				$prepare_media->execute(array(
					":idx"=>$gallery_maxidx, 
					":datex"=>time(),
					":title"=>"batumi catalog", 
					":lang"=>$l, 
					":status"=>0
				));
				// insert gallery attachment
				$sql_media2 = 'INSERT INTO `studio404_gallery_attachment` SET 
				`idx`=:idx, 
				`connect_idx`=:connect_idx, 
				`pagetype`=:pagetype, 
				`lang`=:lang, 
				`status`=:status
				'; 
				$prepare_media2 = $conn->prepare($sql_media2); 
				$prepare_media2->execute(array(
					":idx"=>$gallery_maxidx, 
					":connect_idx"=>$maxidx,
					":pagetype"=>"catalogpage", 
					":lang"=>$l, 
					":status"=>0
				));

			}

			$files = DIR.'_cache/*'; 
			array_map('unlink', glob($files));
			
			$selectCatName = 'SELECT `title` FROM `studio404_pages` WHERE `lang`=1 AND `idx` IN ('.implode(",",$macat).')'; 
			$prepareCatName = $conn->prepare($selectCatName);
			$prepareCatName->execute();
			$fetchCatName = $prepareCatName->fetchAll(PDO::FETCH_ASSOC);

			$selectCatName2 = 'SELECT `title` FROM `studio404_pages` WHERE `lang`=2 AND `idx` IN ('.implode(",",$macat).')'; 
			$prepareCatName2 = $conn->prepare($selectCatName2);
			$prepareCatName2->execute();
			$fetchCatName2 = $prepareCatName2->fetchAll(PDO::FETCH_ASSOC);	

			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"დაამატა მონაცემი","Added data",$url);

			echo $gallery_maxidx;
			exit();
		}


		/* EDIT start */
		if(Input::method("POST","editCatalogItem")=="true" && Input::method("POST","editidx")){
			if(!isset($_SESSION["batumi_id"])){
				$_SESSION["batumi_id"] = 0;
			}
			$editidx = Input::method("POST","editidx");
			$macat = json_decode(Input::method("POST","macat"),true);
			$types = json_decode(Input::method("POST","ta"),true);
			$values = json_decode(Input::method("POST","va"),true);
			$names = json_decode(Input::method("POST","na"),true);
			$db_columns = json_decode(Input::method("POST","ca"),true);
			$checkbox_values = json_decode(Input::method("POST","ca2"),true);
			$importent = json_decode(Input::method("POST","ia"),true);

		
			$columns_and_data = '';
			$xx = 0;
			foreach($db_columns as $val){
				if($types[$xx]=="text" || $types[$xx]=="select" || $types[$xx]=="textarea" || $types[$xx]=="dateandtimerange"){
					$columns_and_data .= '`'.$val.'`="'.str_replace('"',"&quot;",$values[$xx]).'", ';
				}else if($types[$xx]=="checkbox"){
					if($checkbox_values[$xx]=="yes"){
						$checkboxdata_value[$val][] = str_replace('"',"&quot;",$values[$xx]);
					}
				}else if($types[$xx]=="file"){
					$columns_and_data .= '`'.$val.'`="'.str_replace('"',"&quot;",$values[$xx]).'", ';
				}else if($types[$xx]=="date"){
					$timestamp = strtotime(str_replace('/', '-', $values[$xx])); 
					$columns_and_data .= '`'.$val.'`="'.$timestamp.'", ';
				}
				$xx++;
			}
			
			if(isset($checkboxdata_value) && is_array($checkboxdata_value)){
				foreach($checkboxdata_value as $key => $value){
					$columns_and_data .= '`'.$key.'`="'.implode(",",$checkboxdata_value[$key]).'", ';
				}
			}

			$selectEditAdmins = 'SELECT `edit_admin` FROM `studio404_module_item` WHERE `idx`=:idx AND `lang`=:lang';
			$prp = $conn->prepare($selectEditAdmins); 
			$prp->execute(array(
				":lang"=>Input::method("POST","edit_language"), 
				":idx"=>$editidx 
			));	
			$ftc = $prp->fetch(PDO::FETCH_ASSOC);
			$edit_admin = $ftc['edit_admin'].",".$_SESSION["batumi_id"]; 

			$update = 'UPDATE `studio404_module_item` SET '.$columns_and_data.' `updatedate`=:updatedate, `cataloglist`="'.implode(",",$macat).'", `edit_admin`=:edit_admin WHERE `idx`=:idx AND `lang`=:lang';
			$prepare = $conn->prepare($update); 
			$prepare->execute(array(
				":lang"=>Input::method("POST","edit_language"), 
				":updatedate"=>time(), 
				":edit_admin"=>$edit_admin, 
				":idx"=>$editidx 
			));

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			$url = '';			
			$p = Input::method("POST","p");
			$url .= WEBSITE.'ge/monacemis-redaqtireba?parent='.$p.'&idx='.$editidx.'&back=http://batumi.404.ge/ge/Cemi-galerea?idx='.$p.'::';
			$url .= WEBSITE.'en/monacemis-redaqtireba?parent='.$p.'&idx='.$editidx.'&back=http://batumi.404.ge/en/Cemi-galerea?idx='.$p;
			

			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"დაარედაქტირა მონაცემი ","Edited Data",$url);

			echo "Done";
			exit();
		}
		/* EDIT end */


		if(Input::method("POST","adddatabasecolumn")=="true" && Input::method("POST","a") && Input::method("POST","ct") && Input::method("POST","cn")){
			$arrayType = array("int","varchar","text","longtext"); 
			if(in_array(Input::method("POST","ct"),$arrayType)){
				if(Input::method("POST","ct")=="varchar"){ $type = "VARCHAR(255)"; }
				else if(Input::method("POST","ct")=="int"){ $type = "INT(11)"; }
				else if(Input::method("POST","ct")=="text"){ $type = "TEXT"; }
				else if(Input::method("POST","ct")=="longtext"){ $type = "LONGTEXT"; }
				$sql = 'ALTER TABLE `studio404_module_item` ADD COLUMN `'.Input::method("POST","cn").'` '.$type.' NOT NULL AFTER `'.str_replace(" ","",Input::method("POST","a")).'` ';
				$prepare = $conn->prepare($sql); 
				$prepare->execute();
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}
				
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"ბაზაში სვეტის დამატება ::".Input::method("POST","cn"),"Database Insert New Column ::".Input::method("POST","cn"));
				echo "Done";
			}else{
				echo "Error";
			}
			exit();
		}

		if(Input::method("POST","updatedatabasecolumn")=="true" && Input::method("POST","ecno") && Input::method("POST","ecn") && Input::method("POST","ect") && Input::method("POST","datatype")){
			if(Input::method("POST","ect")=="delete"){
				$sql = 'ALTER TABLE `studio404_module_item` DROP COLUMN `'.Input::method("POST","ecn").'`';
				$prepare = $conn->prepare($sql); 
				$prepare->execute();
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"ბაზაში სვეტის წაშლა ::".Input::method("POST","ecn"),"Database delete Column ::".Input::method("POST","ecn"));
				echo "Done";				
			}else{
				if(Input::method("POST","ecno")!=Input::method("POST","ecn")){
					$sql = 'ALTER TABLE `studio404_module_item` CHANGE COLUMN `'.Input::method("POST","ecno").'` `'.Input::method("POST","ecn").'` '.Input::method("POST","datatype");
					$prepare = $conn->prepare($sql); 
					$prepare->execute();
					$insert_notification = new insert_notification();
					$insert_notification->insert($c,$_SESSION["batumi_id"],"ბაზაში სვეტის რედაქტირება ::".Input::method("POST","ecno"),"Database rename Column ::".Input::method("POST","ecno"));
					echo "Done";					
				}else{
					echo "Done";
				}
			}
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			exit();
		}

		if(Input::method("POST","createform")=="true" && Input::method("POST","t") && Input::method("POST","lang") && Input::method("POST","l") && Input::method("POST","n") && Input::method("POST","d")){
			$catId = (int)Input::method("POST","catId");
			$type = json_decode(Input::method("POST","t"),true); 
			$lang = json_decode(Input::method("POST","lang"),true); 
			$label = json_decode(Input::method("POST","l"),true); 
			$name = json_decode(Input::method("POST","n"),true); 
			$value = json_decode(Input::method("POST","v"),true); 
			$database = json_decode(Input::method("POST","d"),true); 
			$important = json_decode(Input::method("POST","i"),true); 
			$list = json_decode(Input::method("POST","li"),true); 
			$filter = json_decode(Input::method("POST","f"),true); 
			$dataOptions = json_decode(Input::method("POST","dop"),true); 
			$dataCheckbox = json_decode(Input::method("POST","dch"),true); 
			$fileformat = json_decode(Input::method("POST","ff"),true); 
			$multiple = json_decode(Input::method("POST","mp"),true); 
			$subcat = Input::method("POST","subcat"); 
			
			if(Input::method("POST","update_lang")=="single"){
				$c['languages.num.array'] = array($lang[0]);
			}

			$tt = array(
				array( "idx" => $catId )
			);
			$sc = $tt;
			
			if($subcat=="yes"){
				$ssss = 'SELECT `idx` FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=1 AND lang=:lang';
				$ssprepare = $conn->prepare($ssss); 
				$ssprepare->execute(array(
					":cid"=>$catId, 
					":lang"=>LANG_ID 
				));
				if($ssprepare->rowCount() > 0){
					$sc = $ssprepare->fetchAll(PDO::FETCH_ASSOC);
					$sc = array_merge($sc, $tt);
				}
			}

			foreach ($sc as $ssvalue){
				$catId = $ssvalue["idx"]; 
				foreach($c['languages.num.array'] as $lang_numeric_array_value){

					// delete old catalog form
					$sql = 'DELETE FROM `studio404_forms` WHERE `cid`=:cid AND `lang`=:lang';
					$prepare = $conn->prepare($sql); 
					$prepare->execute(array(
						":cid"=>$catId, 
						":lang"=>$lang_numeric_array_value
					));

					if($prepare->rowCount() > 0){
						$sql2 = 'DELETE FROM `studio404_forms_lists` WHERE `cid`=:cid AND `lang`=:lang';
						$prepare2 = $conn->prepare($sql2); 
						$prepare2->execute(array(
							":cid"=>$catId, 
							":lang"=>$lang_numeric_array_value
						));
					}

					for($x = 0; $x<count($type);$x++){
						if($type[$x]=="text" || $type[$x]=="date" || $type[$x]=="dateandtimerange" || $type[$x]=="textarea"){
							$vdb = ($value[$x]) ? $value[$x] : "";
							$insert = 'INSERT INTO `studio404_forms` SET `cid`=:cid, `label`=:label, `type`=:type, `name`=:name, `placeholder`=:placeholder, `attach_column`=:attach_column, `important`=:important, `list`=:list, `filter`=:filter, `lang`=:lang';
							$prepare_insert = $conn->prepare($insert); 
							$prepare_insert->execute(array(
								":cid"=>$catId, 
								":label"=>$label[$x], 
								":type"=>$type[$x], 
								":name"=>$name[$x], 
								":placeholder"=>$vdb, 
								":attach_column"=>rtrim($database[$x]), 
								":important"=>$important[$x], 
								":list"=>$list[$x], 
								":filter"=>$filter[$x], 
								":lang"=>$lang_numeric_array_value, 
							));
						}else if($type[$x]=="file"){
							$vdb = ($value[$x]) ? $value[$x] : "";
							$insert = 'INSERT INTO `studio404_forms` SET `cid`=:cid, `label`=:label, `attach_format`=:attach_format, `attach_multiple`=:attach_multiple, `type`=:type, `name`=:name, `placeholder`=:placeholder, `attach_column`=:attach_column, `important`=:important, `list`=:list, `filter`=:filter, `lang`=:lang';
							$prepare_insert = $conn->prepare($insert); 
							$attachformat = ($fileformat[$x]) ? $fileformat[$x] : "jpg";
							$attachmulti = ($multiple[$x]) ? $multiple[$x] : "no";
							$prepare_insert->execute(array(
								":cid"=>$catId, 
								":label"=>$label[$x], 
								":type"=>$type[$x], 
								":name"=>$name[$x], 
								":placeholder"=>$vdb, 
								":attach_column"=>$database[$x], 
								":important"=>$important[$x], 
								":attach_format"=>$attachformat, 
								":attach_multiple"=>$attachmulti, 
								":list"=>$list[$x], 
								":filter"=>$filter[$x], 
								":lang"=>$lang_numeric_array_value, 
							));
						}else if($type[$x]=="select" || $type[$x]=="checkbox"){
							$vdb = ($value[$x]) ? $value[$x] : "";
							$insert = 'INSERT INTO `studio404_forms` SET `cid`=:cid, `label`=:label, `type`=:type, `name`=:name, `placeholder`=:placeholder, `attach_column`=:attach_column, `important`=:important, `list`=:list, `filter`=:filter, `lang`=:lang';
							$prepare_insert = $conn->prepare($insert); 
							$prepare_insert->execute(array(
								":cid"=>$catId, 
								":label"=>$label[$x], 
								":type"=>$type[$x], 
								":name"=>$name[$x], 
								":placeholder"=>$vdb, 
								":attach_column"=>$database[$x], 
								":important"=>$important[$x], 
								":list"=>$list[$x], 
								":filter"=>$filter[$x], 
								":lang"=>$lang_numeric_array_value, 
							));
							$lastId = $conn->lastInsertId();
							$foreachelement = ($type[$x]=="select") ? $dataOptions[$x] : $dataCheckbox[$x];
							foreach($foreachelement as $option){
								$optioninsert = 'INSERT INTO `studio404_forms_lists` SET `cid`=:cid, `cf_id`=:cf_id, `text`=:textx, `lang`=:lang';
								$prepare_option_insert = $conn->prepare($optioninsert); 
								$prepare_option_insert->execute(array(
									":cid"=>$catId, 
									":cf_id"=>$lastId, 
									":textx"=>$option, 
									":lang"=>$lang_numeric_array_value
								));
							}
						}
					}
				}
			}
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}

			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"ფორმის განახლება ::".$catId,"Form Updated: ".$catId);
			echo "Done";
			exit();
		}

		if(Input::method("POST","b_auth")=="true" && Input::method("POST","e") && Input::method("POST","p") && Input::method("POST","c")){
			if($_SESSION['protect_x']!=Input::method("POST","c")){
				echo "wrongCaptcha";
			}else{
				$sql = 'SELECT `id`,`username`,`namelname`,`picture`,`user_type` FROM `studio404_users` WHERE `username`=:username AND `password`=:password AND `user_type`!=:user_type'; 
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":username"=>Input::method("POST","e"), 
					":password"=>md5(Input::method("POST","p")),
					":user_type"=>"administrator"
				));
				if($prepare->rowCount()>0){
					$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
					$_SESSION["batumi_id"] = $fetch['id'];  
					$_SESSION["batumi_username"] = $fetch['username'];  
					$_SESSION["batumi_namelname"] = $fetch['namelname'];  
					$_SESSION["batumi_picture"] = $fetch['picture'];  
					$_SESSION["batumi_user_type"] = $fetch['user_type'];  
					$ip = get_ip::ip();
					$userData = new userData(); 
					$browser = $userData->getBrowser(); 
					$os = $userData->getOS(); 
					$logs = 'INSERT INTO `studio404_logs` SET `date`=:date, `namelname`=:namelname, `username`=:username, `browser`=:browser, `os`=:os, `ip`=:ip, `logtry`=:logtry';
					$prepare2 = $conn->prepare($logs); 
					$prepare2->execute(array(
						":date"=>time(), 
						":namelname"=>$fetch['namelname'], 
						":username"=>$fetch['username'], 
						":browser"=>$browser, 
						":os"=>$os, 
						":ip"=>$ip, 
						":logtry"=>"Batumi intranet enter" 
					));

					echo "Enter";
				}else{
					$now = time(); 
					$before = $now - 86400;
					$ip = get_ip::ip();
					$sql = 'SELECT `id` FROM `studio404_logs` WHERE `ip`=:ip AND `date`>:before AND `logtry`=:logtry';
					$prepare = $conn->prepare($sql); 
					$prepare->execute(array(
						":ip"=>$ip, 
						":before"=>$before, 
						":logtry"=>"Batumi intranet log try"
					));
					if($prepare->rowCount() >= 10){
						$block = 'INSERT INTO `studio404_blocked_ips` SET `date`=:date, `ip`=:ip, `insert_admin`=:insert_admin';
						$prepare = $conn->prepare($block);
						$prepare->execute(array(
							":date"=>time(), 
							":ip"=>$ip, 
							":insert_admin"=>1
						));
					}else{
						$userData = new userData(); 
						$browser = $userData->getBrowser(); 
						$os = $userData->getOS(); 
						$logs = 'INSERT INTO `studio404_logs` SET `date`=:date, `namelname`=:namelname, `username`=:username, `browser`=:browser, `os`=:os, `ip`=:ip, `logtry`=:logtry';
						$prepare2 = $conn->prepare($logs); 
						$prepare2->execute(array(
							":date"=>time(), 
							":namelname"=>"Not defined", 
							":username"=>"Not defined", 
							":browser"=>$browser, 
							":os"=>$os, 
							":ip"=>$ip, 
							":logtry"=>"Batumi intranet log try" 
						));
					} 
					echo "NoUser";
				}
				
			}
			exit();
		}

		if(Input::method("POST","removeuserx")=="true" && Input::method("POST","uid")){
			$sql = 'UPDATE `studio404_users` SET `status`=1 WHERE `id`=:uid';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":uid"=>Input::method("POST","uid")
			));

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			
			echo "Done"; 
			exit();
		}

		if(Input::method("POST","logout")=="true"){
			session_destroy();
			echo "Out";
			exit();
		}

		if(Input::method("POST","updateUserProfile")=="true" && Input::method("POST","n") && Input::method("POST","m") && Input::method("POST","e") && Input::method("POST","a") && Input::method("POST","lang")){
			$sql = 'UPDATE `studio404_users` SET `dob`=:dob, `namelname`=:namelname, `mobile`=:mobile, `email`=:email, `address`=:address WHERE `id`=:id';
			$prepare = $conn->prepare($sql); 
			$dob = str_replace("/", "-", Input::method("POST","d")); 
			$dob = strtotime($dob);
			$prepare->execute(array(
				":namelname"=>Input::method("POST","n"), 
				":dob"=>$dob, 
				":mobile"=>Input::method("POST","m"), 
				":email"=>Input::method("POST","e"), 
				":address"=>Input::method("POST","a"), 
				":id"=>$_SESSION["batumi_id"]
			));
			
			if(Input::method("POST","lang")=="en"){
				echo "Profile Updated !";
			}else{
				echo "პროფილი განახლდა !";
			}
			
			exit();
		}

		if(Input::method("POST","addcatalogue")=="true" && Input::method("POST","n")){
			
			$maxIdx = 'SELECT MAX(`idx`) as maxidx FROM `studio404_pages`';
			$prepare = $conn->prepare($maxIdx);
			$prepare->execute(); 
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$maxidx = $fetch["maxidx"] + 1;
			}else{ $maxidx = 1; }

			if(Input::method("POST","p")){
				$cid = Input::method("POST","p");
			}else{
				$cid = 4;
			}

			$pos = 'SELECT MAX(`position`) as posmax FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=1';
			$prepare2 = $conn->prepare($pos);
			$prepare2->execute(array(
				":cid"=>$cid
			)); 
			if($prepare2->rowCount() > 0){
				$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
				$posmax = $fetch2["posmax"] + 1;
			}else{ $posmax = 1; }

			$model = 'SELECT MAX(`idx`) as model_idx FROM `studio404_module_attachment`';
			$modelp = $conn->prepare($model);
			$modelp->execute(); 
			if($modelp->rowCount() > 0){
				$modelf = $modelp->fetch(PDO::FETCH_ASSOC);
				$modelx = $modelf["model_idx"] + 1;
			}else{ $posmax = 1; }

			$slug_generation = new slug_generation();
			$slug = $slug_generation->generate(Input::method("POST","n"));

			

			for($x=1;$x<=2;$x++){
				$sql = 'INSERT INTO `studio404_pages` SET `date`=:datex, `menu_type`=:menu_type, `page_type`=:page_type, `idx`=:idx, `cid`=:cid, `subid`=:cid, `title`=:titlex, `shorttitle`=:titlex, `slug`=:slug, `position`=:position, `visibility`=2, `lang`=:lang, `insert_admin`=:insert_admin';
				$preparein = $conn->prepare($sql);
				$preparein->execute(array(
					":cid"=>$cid, 
					":datex"=>time(), 
					":page_type"=>'catalogpage', 
					":menu_type"=>'sub', 
					":idx"=>$maxidx, 
					":position"=>$posmax, 
					":titlex"=>Input::method("POST","n"),
					":slug"=>$slug, 
					":lang"=>$x,
					":insert_admin"=>$_SESSION["batumi_id"] 
				));

				$insertCat = 'INSERT INTO `studio404_module_attachment` SET `idx`=:idx, `connect_idx`=:connect_idx, `page_type`=:page_type, `lang`=:lang';
				$prepatta = $conn->prepare($insertCat); 
				$prepatta->execute(array(
					":idx"=>$modelx, 
					":connect_idx"=>$maxidx, 
					":page_type"=>"catalogpage", 
					":lang"=>$x
				));

				$insertCat2 = 'INSERT INTO `studio404_module` SET `idx`=:idx, `date`=:datex, `title`=:titlex, `lang`=:lang';
				$prepatta2 = $conn->prepare($insertCat2); 
				$prepatta2->execute(array(
					":idx"=>$modelx, 
					":datex"=>time(), 
					":titlex"=>Input::method("POST","n"), 
					":lang"=>$x
				));
				
			}

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
			$name = Input::method("POST","n");
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"დაემატა კატეგორია: $name","Added сategory: $name");

			echo "Done";
			exit();
		}

		if(Input::method("POST","editcatalogue")=="true" && Input::method("POST","n") && Input::method("POST","i") && Input::method("POST","lang")){
			$n = Input::method("POST","n");
			$i = Input::method("POST","i");
			$lang = Input::method("POST","lang");
			$old = Input::method("POST","old");
			$sql = 'UPDATE `studio404_pages` SET `title`=:titlex WHERE `idx`=:idx AND `lang`=:lang';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":idx"=>$i, 
				":lang"=>$lang, 
				":titlex"=>$n
			)); 
			if($prepare->rowCount() > 0){
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}
				
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"განახლდა კატალოგის დასახელება: $old TO $n","Catalogue Updated: $old TO $n");
				echo "Done";
			}
			exit();
		}


		if(Input::method("POST","checkmodelitem") && Input::method("POST","ci") && Input::method("POST","lang")){
			// echo "a";
			$sql0 = 'SELECT `id` FROM `studio404_pages` WHERE `cid`=:cid AND `status`!=1';
			$preparex = $conn->prepare($sql0); 
			$preparex->execute(array(
				":cid"=>Input::method("POST","ci")
			));
			if($preparex->rowCount()>0){
				echo "Exists";
			}else{
				$sql = 'SELECT 
				`studio404_module_item`.`id` 
				FROM 
				`studio404_module_attachment`,`studio404_module_item`
				WHERE 
				`studio404_module_attachment`.`connect_idx`=:connect_idx AND 
				`studio404_module_attachment`.`page_type`=:page_type AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:one AND 
				`studio404_module_attachment`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`status`!=:one 
				';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":connect_idx"=>Input::method("POST","ci"), 
					":page_type"=>'catalogpage', 
					":lang"=>Input::method("POST","lang"), 
					":one"=>1 
				));
				if($prepare->rowCount() > 0){
					echo "Exists";
				}else{
					echo "Free to delete"; 
				}
			}
			exit();
		}

		if(Input::method("POST","removeCatalogue")=="true" && Input::method("POST","cidx")){
			$selPos = 'SELECT `title`,`cid`,`position` FROM `studio404_pages` WHERE `idx`=:idx';
			$prepare1 = $conn->prepare($selPos);
			$prepare1->execute(array(
				":idx"=>Input::method("POST","cidx")
			));
			if($prepare1->rowCount() > 0){
				$fetch1 = $prepare1->fetch(PDO::FETCH_ASSOC); 
				$title = $fetch1['title'];
				$cid = $fetch1['cid'];
				$posfrom = $fetch1['position'];
				

				$uppos = 'UPDATE `studio404_pages` SET `position`=`position`-1 WHERE `cid`=:cid AND `position`>:posfrom AND `status`!=1';
				$prepare2 = $conn->prepare($uppos);
				$prepare2->execute(array(
					":cid"=>$cid,
					":posfrom"=>$posfrom
				));					
					
				$sql = 'UPDATE `studio404_pages` SET `status`=1 WHERE `idx`=:idx';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":idx"=>Input::method("POST","cidx")
				));	

				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}
				
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"წაშალა კატალოგი: $title","Catalogue Deleted: $title");

				echo "Done";				
			}
			exit();
		}

		if(Input::method("POST","changeposition")=="true" && Input::method("POST","t") && Input::method("POST","i") && Input::method("POST","c") && Input::method("POST","p")){
			if(Input::method("POST","t")=="up"){
				$sql = 'UPDATE `studio404_pages` SET `position`=0 WHERE `idx`=:idx';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":idx"=>Input::method("POST","i")
				));

				if($prepare->rowCount() > 0){
					$minpos = Input::method("POST","p") - 1;
					$sql2 = 'UPDATE `studio404_pages` SET `position`=`position`+1 WHERE `position`=:minpos AND `cid`=:cid';
					$prepare2 = $conn->prepare($sql2); 
					$prepare2->execute(array(
						":minpos"=>$minpos, 
						":cid"=>Input::method("POST","c")
					));

					if($prepare2->rowCount() > 0){
						$sql3 = 'UPDATE `studio404_pages` SET `position`=:minpos WHERE `position`=0 AND `cid`=:cid';
						$prepare3 = $conn->prepare($sql3); 
						$prepare3->execute(array(
							":minpos"=>$minpos, 
							":cid"=>Input::method("POST","c")
						));
						if($prepare3->rowCount() > 0){

							$files = glob(DIR.'_cache/*'); // get all file names
							foreach($files as $file){ // iterate files
								if(is_file($file))
								@unlink($file); // delete file
							}
							
							$insert_notification = new insert_notification();
							$insert_notification->insert($c,$_SESSION["batumi_id"],"კატალოგის პოზიციის შეცვლა","Change Catalogue Position");

							echo "Done";
						}
					}
				}
			}else{
				$sql = 'UPDATE `studio404_pages` SET `position`=0 WHERE `idx`=:idx';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":idx"=>Input::method("POST","i")
				));

				if($prepare->rowCount() > 0){
					$pluspos = Input::method("POST","p") + 1;
					$sql2 = 'UPDATE `studio404_pages` SET `position`=`position`-1 WHERE `position`=:pluspos AND `cid`=:cid';
					$prepare2 = $conn->prepare($sql2); 
					$prepare2->execute(array(
						":pluspos"=>$pluspos, 
						":cid"=>Input::method("POST","c")
					));

					if($prepare2->rowCount() > 0){
						$sql3 = 'UPDATE `studio404_pages` SET `position`=:pluspos WHERE `position`=0 AND `cid`=:cid';
						$prepare3 = $conn->prepare($sql3); 
						$prepare3->execute(array(
							":pluspos"=>$pluspos, 
							":cid"=>Input::method("POST","c")
						));

						if($prepare3->rowCount() > 0){

							$files = glob(DIR.'_cache/*'); // get all file names
							foreach($files as $file){ // iterate files
								if(is_file($file))
								@unlink($file); // delete file
							}
							
							$insert_notification = new insert_notification();
							$insert_notification->insert($c,$_SESSION["batumi_id"],"კატალოგის პოზიციის შეცვლა","Change Catalogue Position");

							echo "Done";
						}
					}

				}

			}
		}

		if(Input::method("POST","adduser")=="true" && Input::method("POST","u") && Input::method("POST","us") && Input::method("POST","n") && Input::method("POST","m")){
			$sql = 'INSERT INTO `studio404_users` SET `username`=:username, `password`=:password, `user_type`=:user_type, `namelname`=:namelname, `dob`=:dob, `mobile`=:mobile, `email`=:email, `address`=:address';
			$prepare = $conn->prepare($sql); 
			$dob = str_replace("/", "-", Input::method("POST","d")); 
			$dob = strtotime($dob); 

			$username = Input::method("POST","u"); 
			$password = md5(Input::method("POST","p")); 
			$user_type = Input::method("POST","us"); 
			$namelname = Input::method("POST","n"); 
			$mobile = Input::method("POST","m"); 
			$email = Input::method("POST","e"); 
			$address = Input::method("POST","a"); 
			$image = Input::method("POST","i"); 

			$prepare->execute(array(
				":username"=>$username, 
				":password"=>$password, 
				":user_type"=>$user_type, 
				":namelname"=>$namelname, 
				":dob"=>$dob, 
				":mobile"=>$mobile, 
				":email"=>$email, 
				":address"=>$address 
			));

			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"დაამატა მომხმარებელი -> ".$namelname,"Added New User -> ".$namelname);

			if($prepare->rowCount() > 0){ 
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}	
				echo "Done"; 		
			}else{
				echo "Error"; 
			}
			exit();
		}


		if(Input::method("POST","edituser")=="true" && Input::method("POST","n") && Input::method("POST","m") && Input::method("POST","userid")){
			if(Input::method("POST","p")!=""){
				$password = md5(Input::method("POST","p")); 
				$sql_p = '`password`=:password, ';
			}else{
				$sql_p = '';
			}
			$sql = 'UPDATE `studio404_users` SET '.$sql_p.'`namelname`=:namelname, `dob`=:dob, `mobile`=:mobile, `email`=:email, `address`=:address WHERE `id`=:userid';
			$prepare = $conn->prepare($sql); 
			$dob = str_replace("/", "-", Input::method("POST","d")); 
			$dob = strtotime($dob); 

			$userid = Input::method("POST","userid"); 
			
			$namelname = Input::method("POST","n"); 
			$mobile = Input::method("POST","m"); 
			$email = Input::method("POST","e"); 
			$address = Input::method("POST","a"); 
			$image = Input::method("POST","i"); 

			if(Input::method("POST","p")!=""){
				$prepare->execute(array(
				":userid"=>$userid, 
				":password"=>$password, 
				":namelname"=>$namelname, 
				":dob"=>$dob, 
				":mobile"=>$mobile, 
				":email"=>$email, 
				":address"=>$address 
				));
			}else{
				$prepare->execute(array(
				":userid"=>$userid, 
				":namelname"=>$namelname, 
				":dob"=>$dob, 
				":mobile"=>$mobile, 
				":email"=>$email, 
				":address"=>$address 
				));
			}

			

			if($prepare->rowCount() > 0){ 
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}	
			}else{
				echo "Error"; 
			}
			exit();
		}

		if(Input::method("POST","reloadImage")=="true"){
			$_SESSION['protect_x'] = ustring::random(4);
			echo "Done";
		}

		if(Input::method("POST","removemessage")=="true" && is_numeric(Input::method("POST","rmi"))){
			$id = Input::method("POST","rmi");
			$delete_admin = $_SESSION["batumi_id"];
			$sql = 'SELECT `status` FROM `studio404_messages` WHERE `id`=:id';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":id"=>$id
			));
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$old_status = $fetch["status"]; 
				if($old_status==0){
					$new_status = $delete_admin;
				}else{
					$new_status = $old_status.",".$delete_admin;	
				}				
				$sql2 = 'UPDATE `studio404_messages` SET `status`=:status WHERE `id`=:id';
				$prepare2 = $conn->prepare($sql2); 
				$prepare2->execute(array(
					":status"=>$new_status, 
					":id"=>$id 
				));
				echo "Done";
			}
		}

		if(Input::method("POST","addblockedip")=="true" && Input::method("POST","i")!=""){
			$sql = 'INSERT INTO `studio404_blocked_ips` SET `date`=:date, `ip`=:ip, `insert_admin`=:insert_admin';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":date"=>time(), 
				":ip"=>Input::method("POST","i"), 
				":insert_admin"=>$_SESSION["batumi_id"]
			));
			if($prepare->rowCount()>0){
				echo "Done";
			}
		}

		if(Input::method("POST","addNewEvent")=="true" && Input::method("POST","etitle")!="" && Input::method("POST","estart_date")!=""){
			$estart_date = strtotime(str_replace("/","-", (Input::method("POST","estart_date")." 24:00:00") )); 
			$eend_date = strtotime(str_replace("/","-", (Input::method("POST","eend_date")." 24:00:00") )); 
			$etitle = Input::method("POST","etitle"); 
			$eaddress = Input::method("POST","eaddress"); 
			$eprice = Input::method("POST","eprice"); 
			$ecurrency = Input::method("POST","ecurrency"); 
			$edescription = Input::method("POST","edescription"); 

			$max = 'SELECT MAX(`idx`) as max FROM `studio404_events` WHERE `status`!=1';
			$prepare_max = $conn->prepare($max); 
			$prepare_max->execute();
			$fetch_max = $prepare_max->fetch(PDO::FETCH_ASSOC); 
			$max_idx = ($fetch_max['max']) ? ($fetch_max['max']+1) : 1;

			foreach ($c['languages.num.array'] as $l) {
				$sql = 'INSERT INTO `studio404_events` SET 
				`idx`=:max_idx, 
				`start_date`=:estart_date, 
				`end_date`=:eend_date, 
				`title`=:etitle, 
				`address`=:eaddress, 
				`price`=:eprice, 
				`currency`=:ecurrency, 
				`description`=:edescription, 
				`lang`=:lang, 
				`insert_admin`=:insert_admin 
				';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":max_idx"=>$max_idx, 
					":estart_date"=>$estart_date, 
					":eend_date"=>$eend_date, 
					":etitle"=>$etitle, 
					":eaddress"=>$eaddress, 
					":eprice"=>$eprice, 
					":ecurrency"=>$ecurrency, 
					":edescription"=>$edescription, 
					":lang"=>$l, 
					":insert_admin"=>$_SESSION["batumi_id"]
				));
			}

			echo "Done";
		}

	
		if(Input::method("POST","editNewEvent")=="true" && Input::method("POST","eidx")!="" && Input::method("POST","elang")!=""){
			$idx = Input::method("POST","eidx");
			$lang = Input::method("POST","elang");
			$estart_date = strtotime(str_replace("/","-", (Input::method("POST","estart_date")." 24:00:00") )); 
			$eend_date = strtotime(str_replace("/","-", (Input::method("POST","eend_date")." 24:00:00") )); 
			$etitle = Input::method("POST","etitle"); 
			$eaddress = Input::method("POST","eaddress"); 
			$eprice = Input::method("POST","eprice"); 
			$ecurrency = Input::method("POST","ecurrency"); 
			$edescription = Input::method("POST","edescription"); 

			/* Time Update all language */
			$tsql = 'UPDATE `studio404_events` SET 
			`start_date`=:estart_date, 
			`end_date`=:eend_date 
			WHERE 
			`idx`=:idx AND 
			`status`!=1';
			$tprepare = $conn->prepare($tsql);
			$tprepare->execute(array(
				":estart_date"=>$estart_date, 
				":eend_date"=>$eend_date, 
				":idx"=>$idx
			));

			$sql = 'UPDATE `studio404_events` SET 
			`title`=:etitle, 
			`address`=:eaddress, 
			`price`=:eprice, 
			`currency`=:ecurrency, 
			`description`=:edescription
			WHERE 
			`idx`=:idx AND 
			`lang`=:lang AND 
			`status`!=1';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":etitle"=>$etitle, 
				":eaddress"=>$eaddress, 
				":eprice"=>$eprice, 
				":ecurrency"=>$ecurrency, 
				":edescription"=>$edescription, 
				":idx"=>$idx, 
				":lang"=>$lang 
			));

			echo "Done";
		}


		if(Input::method("POST","selectAllEvents")=="true"){
			$fetch = array();
			$date = strtotime(Input::method("POST","date"));
			$lang_id = Input::method("POST","lang_id");
			$sql = 'SELECT 
			`idx`, `title`, `description`, `lang`
			FROM 
			`studio404_events` 
			WHERE 
			`start_date`<=:dayInTimeStamp AND 
			`end_date`>=:dayInTimeStamp AND 
			`lang`=:lang AND 
			`status`!=:status
	        ';
	        $prepare = $conn->prepare($sql); 
	        $prepare->execute(array(
				":status"=>1, 
				":dayInTimeStamp"=>$date, 
				":lang"=>$lang_id
			));
	        if($prepare->rowCount()){
	        	$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
	        }
	        echo json_encode($fetch);
		}

		if(Input::method("POST","removeEvent")=="true"){
			$idx = Input::method("POST","id");
			$sql = 'UPDATE `studio404_events` SET `status`=1 WHERE `idx`=:idx';
	        $prepare = $conn->prepare($sql); 
	        $prepare->execute(array(
				":idx"=>$idx
			));
	        if($prepare->rowCount()){
	        	echo "Done";
	        }
		}

		if(Input::method("POST","selectOneEvent")=="true"){
			$fetch = array();
			$idx = Input::method("POST","id");
			$lang_id = Input::method("POST","lang_id");
			$sql = 'SELECT 
			idx, 
			FROM_UNIXTIME(`start_date`, "%d/%m/%Y") as start_date, 
			FROM_UNIXTIME(`end_date`, "%d/%m/%Y") as end_date, 
			title, 
			address, 
			price, 
			currency, 
			description, 
			lang
			FROM 
			`studio404_events` 
			WHERE 
			`idx`=:idx AND 
			`status`!=1 AND 
			`lang`=:lang';
	        $prepare = $conn->prepare($sql); 
	        $prepare->execute(array(
				":idx"=>$idx,
				":lang"=>$lang_id
			));
	        if($prepare->rowCount()){
	        	$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			}

			echo json_encode($fetch);
		}

		if(Input::method("POST","selectCatalogItemData")=="true"){
			$sql2 = 'SELECT 
			`studio404_module_item`.* 
			FROM `studio404_module_item` WHERE 
			`module_idx`=25 AND 
			`studio404_module_item`.`idx`=:idx AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status';	
			$prepare2 = $conn->prepare($sql2); 
			$prepare2->execute(array(
				":idx"=>Input::method("POST","idx"), 
				":lang"=>Input::method("POST","lang_id"), 
				":status"=>1 
			));
			if($prepare2->rowCount()){
				$fetch  = $prepare2->fetch(PDO::FETCH_ASSOC);
				
				$cache = new cache();
				$language_data = $cache->index($c,"language_data");
				$language_data = json_decode($language_data);
				$model_template_makevars = new  model_template_makevars();
				$language_data_ = $model_template_makevars->vars($language_data); 

				$getusername = new getusername();		
				$cataloglist_names = new cataloglist_names();	
				
				$labellists = new labellists();
				$labellists_ = $labellists->loadlabels2($c);
				$out['table'] = "<table class=\"table table-hover filterEmptyTdsAjax\">";
				$out['table'] .= "<tr>";
				
				$out['table'] .= "<th style=\"min-width:250px;\">ID</th>";
				$out['table'] .= "<td>".$fetch["idx"]."</td>";
				$out['table'] .= "</tr>";

				$out['table'] .= "<th style=\"min-width:250px;\">".$language_data_["val83"]."</th>";
				$out['table'] .= "<td>".date("d/m/Y H:i:s",$fetch["date"])."</td>";
				$out['table'] .= "</tr>";

				$out['table'] .= "<th style=\"min-width:250px;\">".$language_data_["val90"]."</th>";
				$out['table'] .= "<td>".$fetch["insert_ip"]."</td>";
				$out['table'] .= "</tr>";

				$out['table'] .= "<th style=\"min-width:250px;\">".$language_data_["val86"]."</th>";
				$out['table'] .= "<td>".$getusername->names($c,$fetch["insert_admin"])."</td>";
				$out['table'] .= "</tr>";

				$out['table'] .= "<th style=\"min-width:250px;\">".$language_data_["val85"]."</th>";
				$out['table'] .= "<td>".implode(", ",$cataloglist_names->names($c,$fetch["cataloglist"]))."</td>";
				$out['table'] .= "</tr>";

				foreach ($labellists_ as $value) {
					$attach_column = explode(" ",$value['attach_column']);

					if($value['type']!="file"){
                        if($value["type"]=="date"){
                          $out['table'] .= '<tr>';
                          $out['table'] .= '<th>'.$value["label"].'</th>';
                          $out['table'] .= '<td>';
                          $out['table'] .= date("d/m/Y",$fetch[$attach_column[0]]);
                          $out['table'] .= '</td>';
                          $out['table'] .= '</tr>';
                        }else{
                          $out['table'] .= '<tr>';
                          $out['table'] .= '<th>'.$value["label"].'</th>';
                          $out['table'] .= '<td>'.$fetch[$attach_column[0]].'</td>';
                          $out['table'] .= '</tr>';
                        }
					}else if($value["type"]=="file" && ($value['attach_format']=="png" || $value['attach_format']=="gif" || $value['attach_format']=="jpg")){ 
                        $files = $labellists->loadpictures($c,$value["name"]); 
                        $out['table'] .= '<tr>';
                        $out['table'] .= '<th>'.$value["label"].'</th>';
                        $out['table'] .= '<td>';
                        foreach ($files as $v) {
                          $out['table'] .= '<div class="col-md-2">';
                          $out['table'] .= '<img src="'.WEBSITE.'files/document/'.$v['sgf_file'].'" width="100%" alt="" border="1" />';
                          $out['table'] .= '</div>';
                        }                       
                        $out['table'] .= '</td>';
                        $out['table'] .= '</tr>';
                    }else{
                        $files = $labellists->loadpictures($c,$value["name"]); 
                        $out['table'] .= '<tr>';
                        $out['table'] .= '<th>'.$value["label"].'</th>';
                        $out['table'] .= '<td>';
                        foreach ($files as $v) {
                          $out['table'] .= '<a href="'.WEBSITE.'files/document/'.$v['sgf_file'].'" target="_blank">'.$v['sgf_file'].'</a><br />';
                        }                       
                        $out['table'] .= '</td>';
                        $out['table'] .= '</tr>';
                    }
                }



				$out['table'] .= "</table>";

			}

			echo json_encode($out);
		}

		if(Input::method("POST","sendcataloglist")=="true"){
			
			// $prod = array();
			$sql2 = 'SELECT 
			`studio404_module_item`.* 
			FROM `studio404_module_item` WHERE 
			`cataloglist`=:send_idx AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status';	
			$prepare2 = $conn->prepare($sql2); 
			$prepare2->execute(array(
				":send_idx"=>Input::method("POST","send_idx"), 
				":lang"=>Input::method("POST","lang_id"), 
				":status"=>1 
			));
			if($prepare2->rowCount()){
				$fetch = $prepare2->fetchAll(PDO::FETCH_ASSOC); 
				
				$filename = uid::captcha(10); 
				$filepath = '_csv/'.$filename.'.csv';
				$csv_handler = fopen($filepath,"wb");

				$cols = "SHOW COLUMNS FROM `studio404_module_item`"; 
				$prepare_cols = $conn->prepare($cols);
				$prepare_cols->execute();
				$fetch_cols = $prepare_cols->fetchAll(PDO::FETCH_ASSOC); 
				$csv1 = array();
				foreach ($fetch_cols as $v) {
					if($v['Field']=="id" OR $v['Field']=="idx" OR $v['Field']=="uid" OR $v['Field']=="insert_ip" OR $v['Field']=="date" OR $v['Field']=="expiredate" OR $v['Field']=="updatedate" OR $v['Field']=="module_idx" OR $v['Field']=="cataloglist" OR $v['Field']=="picture" OR $v['Field']=="short_description" OR $v['Field']=="long_description" OR $v['Field']=="slug" OR $v['Field']=="insert_admin" OR $v['Field']=="edit_admin" OR $v['Field']=="position" OR $v['Field']=="lang" OR $v['Field']=="visibility" OR $v['Field']=="status"){
						continue;
					}
					$csv1[] = $v['Field'];			
				}
				fputcsv($csv_handler, $csv1);
				// $csv .= "\n";//Column headers
				foreach ($fetch as $record){
					$csv = array();
					foreach ($fetch_cols as $v) {
						if($v['Field']=="id" OR $v['Field']=="idx" OR $v['Field']=="uid" OR $v['Field']=="insert_ip" OR $v['Field']=="date" OR $v['Field']=="expiredate" OR $v['Field']=="updatedate" OR $v['Field']=="module_idx" OR $v['Field']=="cataloglist" OR $v['Field']=="picture" OR $v['Field']=="short_description" OR $v['Field']=="long_description" OR $v['Field']=="slug" OR $v['Field']=="insert_admin" OR $v['Field']=="edit_admin" OR $v['Field']=="position" OR $v['Field']=="lang" OR $v['Field']=="visibility" OR $v['Field']=="status"){
							continue;
						}
				    	$csv[] = $record[$v['Field']]; //Append data to csv
					}
					fputcsv($csv_handler, $csv);	
				}
				

				// $csv = mb_convert_encoding($csv, 'UTF-8', 'UTF-8');

				// fwrite($csv_handler,$csv);
				fclose($csv_handler);


				//////////////////////////// CSV TO Exel Start /////////////////////////////////////////
				include '_plugins/exel/PHPExcel/IOFactory.php';

				$objReader = PHPExcel_IOFactory::createReader('CSV');

				// If the files uses a delimiter other than a comma (e.g. a tab), then tell the reader
				$objReader->setDelimiter(",");
				// If the files uses an encoding other than UTF-8 or ASCII, then tell the reader
				$objReader->setInputEncoding('UTF-8');

				$objPHPExcel = $objReader->load($filepath);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$exelPath = '_xls/'.$filename.'.xls';
				$objWriter->save($exelPath);
				//////////////////////////// CSV TO Exel End /////////////////////////////////////////


				$sendemailfromserver = new sendemailfromserver(); 
				$mail = $sendemailfromserver->index(array(
					"email_host"=>"404.ge", 
					"email_username"=>"batumi@404.ge", 
					"email_password"=>"Bs9c{rMSEG9r", 
					"email_name"=>"Batumi Database", 
					"sendTo"=>Input::method("POST","send_email"), 
					"attachment"=>$exelPath, 
					"subject"=>"Database xls file", 
					"body"=>Input::method("POST","send_text")
				));
				if($mail){
					echo "Done"; 		
				}else{
					echo "Error";
				}
			}else{
				echo "Error";
			}
			
		}
		/* end batumi */
	

	}


	public function selectEmailGeneralInfo(){
		global $c;
		$conn = $this->conn($c); 
		$out = array();
		$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=:id';
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":id"=>1
		));
		$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
		$out["host"] = $fetch["host"];
		$out["user"] = $fetch["user"];
		$out["pass"] = $fetch["pass"];
		$out["from"] = $fetch["from"];
		return $out;
	}

	public function send($s,$n,$e,$m){
		$_SESSION["send_view"] = (isset($_SESSION["send_view"])) ? $_SESSION["send_view"]+1 : 1;
		if($_SESSION["send_view"]>150){ 
			echo "Error page."; 
			exit(); 
		}
		
		if(!$this->isValidEmail($e)){
			echo "Error page.";
			exit(); 
		}else{
			$i = $this->selectEmailGeneralInfo(); 
			$message = wordwrap(strip_tags($m), 70, "\r\n");
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'To: '.$n.' <'.$e.'>' . "\r\n";
			$headers .= 'From: '.$i["fromname"].' <'.$i["from"].'>' . "\r\n";
			$send_email = mail($e, $s, $m, $headers);

			if($send_email){
				echo "done !";
			}else{
				echo "Error page."; 
				exit(); 
			}
		}
	}

	public function isValidEmail($email){ 
    	return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

}
?>