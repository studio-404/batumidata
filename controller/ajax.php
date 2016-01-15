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
	        <input type="text" class="form-control form-input" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="date" value="" />
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

		if(Input::method("POST","removeUnpublished")=="true" && Input::method("POST","i")){
			$sql = 'UPDATE `studio404_module_item` SET `status`=1 WHERE `idx`=:idx';
			$prepare = $conn->prepare($sql); 
			$idx = (int)Input::method("POST","i");
			$prepare->execute(array(
				":idx"=>$idx
			));
			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"მონაცემის წაშლა ::".$idx,"Delete Item ::".$idx);

			echo "Done";
		}

		if(Input::method("POST","givepermision")=="true"){
			$idx = (Input::method("POST","p") && is_numeric(Input::method("POST","p"))) ? Input::method("POST","p") : 0;
			$sql = 'UPDATE `studio404_module_item` SET `visibility`=2 WHERE `idx`='.$idx;
			$conn->query($sql);

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"ნებართვის მიცემა ::".$idx,"Give Permision ::".$idx);

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
			`studio404_module_item`
			WHERE `status`!=1';
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
				if($types[$xx]=="text" || $types[$xx]=="select" || $types[$xx]=="textarea"){
					$columns_and_data .= '`'.$val.'`="'.$values[$xx].'", ';
				}else if($types[$xx]=="checkbox"){
					if($checkbox_values[$xx]=="yes"){
						$checkboxdata_value[$val][] = $values[$xx];
					}
				}else if($types[$xx]=="file"){
					$columns_and_data .= '`'.$val.'`="'.$values[$xx].'", ';
				}else if($types[$xx]=="date"){
					$timestamp = strtotime(str_replace('/', '-', $values[$xx])); 
					$columns_and_data .= '`'.$val.'`="'.$timestamp.'", ';
				}
				$xx++;
			}
			// echo '<pre>';
			// print_r($values);
			// echo '</pre>';
			if(is_array($checkboxdata_value)){
				foreach($checkboxdata_value as $key => $value){
					$columns_and_data .= '`'.$key.'`="'.implode(",",$checkboxdata_value[$key]).'", ';
				}
			}
			$uid = new uid();
			$u = $uid->generate(9);
			foreach ($c['languages.num.array'] as $l) {
				$insert = 'INSERT INTO `studio404_module_item` SET '.$columns_and_data.' `cataloglist`="'.implode(",",$macat).'", `insert_ip`="'.get_ip::ip().'", `insert_admin`="'.$_SESSION["batumi_id"].'", `position`="'.$maxposition.'", `idx`="'.$maxidx.'", `visibility`=1, `lang`="'.$l.'", `uid`="'.$u.'", `date`="'.time().'", `expiredate`="'.time().'", `module_idx`="25" ';
				$query = $conn->query($insert);

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

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"მონაცემის დამატება ::".$maxidx,"Add Data ::".$maxidx);

			echo $gallery_maxidx;
			exit();
		}

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
			
			if(Input::method("POST","update_lang")=="single"){
				$c['languages.num.array'] = array($lang[0]);
			}			

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
					if($type[$x]=="text" || $type[$x]=="date" || $type[$x]=="textarea"){
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
					echo "Enter";
				}else{
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
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"წაიშალა მომხმარებელი: ID ".Input::method("POST","uid"),"User Deleted: ID ".Input::method("POST","uid"));

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
			
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"პროფილი განაახლა","Profile Updated");
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
			$insert_notification->insert($c,$_SESSION["batumi_id"],"დაემატა კატალოგის კატეგორია: $name","Catalogue's Category Added: $name");

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

			if($prepare->rowCount() > 0){ 
				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}
				
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"მომხმარებლის დამატება","Add User");
				if($image=="true"){
					echo $conn->lastInsertId();
				}else{
					echo "Done"; 
				}				
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
				
				$insert_notification = new insert_notification();
				$insert_notification->insert($c,$_SESSION["batumi_id"],"მომხმარებლის რედაქტირება","Edit User");
				if($image=="true"){
					echo $conn->lastInsertId();
				}else{
					echo "Done"; 
				}				
			}else{
				echo "Error"; 
			}
			exit();
		}


		/* end batumi */

		if(Input::method("POST","changeusertype")=="true" && Input::method("POST","t") && $_SESSION["tradewithgeorgia_user_id"]) :
			$userid = $_SESSION["tradewithgeorgia_user_id"]; 
			$typetochange = Input::method("POST","t"); 
			if($typetochange=="sp"){
				$findtype = "serviceprovider";
				$url = WEBSITE.'en/profile-service';
			}else{
				$findtype = "manufacturer";
				$url = WEBSITE.'en/profile-products';
			}
			
			
			
			$sql = 'SELECT * FROM `studio404_users` WHERE `username`=:username AND `company_type`=:type';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":username"=>$_SESSION["tradewithgeorgia_username"], 
				":type"=>$findtype
			));
			if($prepare->rowCount() > 0) {
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
				$_SESSION["tradewithgeorgia_company_type"] = $findtype;  
				$_SESSION["tradewithgeorgia_user_id"] = $fetch["id"]; 

				if($findtype=="manufacturer"){
					$_SESSION["user_data"]["picture"] = $fetch["picture"]; // *
					$_SESSION["user_data"]["companyname"] = $fetch["namelname"]; // *
					$_SESSION["user_data"]["sector"] = $fetch["sector_id"]; // *
					$_SESSION["user_data"]["subsector"] = $fetch["sub_sector_id"]; // *
					$_SESSION["user_data"]["establishedin"] = $fetch["established_in"];
					$_SESSION["user_data"]["productioncapasity"] = $fetch["production_capacity"];
					$_SESSION["user_data"]["address"] = $fetch["address"];
					$_SESSION["user_data"]["mobiles"] = $fetch["mobile"]; // *
					$_SESSION["user_data"]["numemploy"] = $fetch["number_of_employes"];
					$_SESSION["user_data"]["certificates"] = $fetch["certificates"];
					$_SESSION["user_data"]["contactpersones"] = $fetch["contact_person"];
					$_SESSION["user_data"]["officephone"] = $fetch["office_phone"];
					$_SESSION["user_data"]["companysize"] = $fetch["company_size"];
					$_SESSION["user_data"]["webaddress"] = $fetch["web_address"];
					$_SESSION["user_data"]["ad_position1"] = $fetch["ad_position1"]; // *
					$_SESSION["user_data"]["ad_email1"] = $fetch["ad_email1"]; //*
					$_SESSION["user_data"]["ad_person2"] = $fetch["ad_person2"];
					$_SESSION["user_data"]["ad_position2"] = $fetch["ad_person2"];
					$_SESSION["user_data"]["ad_mobile2"] = $fetch["ad_mobile2"];
					$_SESSION["user_data"]["ad_email2"] = $fetch["ad_email2"];
					$_SESSION["user_data"]["ad_upload_catalog"] = $fetch["ad_upload_catalog"];
					$_SESSION["user_data"]["contactemail"] = $fetch["email"]; // *
					$_SESSION["user_data"]["about"] = $fetch["about"]; // *
					$_SESSION["user_data"]["products"] = $fetch["products"];
					$_SESSION["user_data"]["exportmarkets"] = $fetch["export_markets_id"];
				}else{
					$_SESSION["user_data"]["picture"] = $fetch["picture"];
					$_SESSION["user_data"]["companyname"] = $fetch["namelname"];
					$_SESSION["user_data"]["sector"] = $fetch["sector_id"];
					$_SESSION["user_data"]["subsector"] = $fetch["sub_sector_id"];
					$_SESSION["user_data"]["establishedin"] = $fetch["established_in"];
					$_SESSION["user_data"]["productioncapasity"] = $fetch["production_capacity"];
					$_SESSION["user_data"]["address"] = $fetch["address"];
					$_SESSION["user_data"]["mobiles"] = $fetch["mobile"];
					$_SESSION["user_data"]["numemploy"] = $fetch["number_of_employes"];
					$_SESSION["user_data"]["certificates"] = $fetch["certificates"];
					$_SESSION["user_data"]["contactpersones"] = $fetch["contact_person"];
					$_SESSION["user_data"]["officephone"] = $fetch["office_phone"];
					$_SESSION["user_data"]["companysize"] = $fetch["company_size"];
					$_SESSION["user_data"]["webaddress"] = $fetch["web_address"];
					$_SESSION["user_data"]["ad_position1"] = $fetch["ad_position1"];
					$_SESSION["user_data"]["ad_email1"] = $fetch["ad_email1"];
					$_SESSION["user_data"]["ad_person2"] = $fetch["ad_person2"];
					$_SESSION["user_data"]["ad_position2"] = $fetch["ad_person2"];
					$_SESSION["user_data"]["ad_mobile2"] = $fetch["ad_mobile2"];
					$_SESSION["user_data"]["ad_email2"] = $fetch["ad_email2"];
					$_SESSION["user_data"]["ad_upload_catalog"] = $fetch["ad_upload_catalog"];
					$_SESSION["user_data"]["contactemail"] = $fetch["email"];
					$_SESSION["user_data"]["about"] = $fetch["about"];
					$_SESSION["user_data"]["products"] = $fetch["products"];
					$_SESSION["user_data"]["exportmarkets"] = $fetch["export_markets_id"];
				}
				echo $url;
			}else{
				echo "Error";
			}
		endif;

		if(Input::method("POST","sendemail1") && Input::method("POST","email1") && isset($_COOKIE["password1"]) && Input::method("POST","lc")==$_SESSION['protect_x']) : 
			$sendemail1 = Input::method("POST","sendemail1");
			$email1 = Input::method("POST","email1");
			$password1 = $_COOKIE["password1"];
			$email2 = explode("@",$email1);
			if(is_array($email2)){ $email2 = $email2[0]; }else{ $email2 = "none"; }
			$hash = ustring::random(18);
			$msg = '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader2.png" width="100%" alt="Mail header"/></div>';
			$msg .= '<p style="font-size:14px; font-family:roboto">Hello dear user, you have registered to our website: <b>'.WEBSITE.'</b></font></p>';
			//$msg .= '<p><a href="'.WEBSITE.'en/start?popup=true&email='.$email2.'&hash='.$hash.'">'.WEBSITE.'en/start?popup=true&email='.$email2.'&hash='.$hash.'</a></p>';
			
			$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:email AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":email"=>$email1, 
				":status"=>1
			));
			if($prepare->rowCount() > 0){
				echo "Error";
			}else{
				//$this->send("::Registration::","Dear user",$email1,$msg);
				$insert_pre = 'INSERT INTO `studio404_users_pre` SET `date`=:datex, `ip`=:ip, `hash`=:hash, `email`=:email, `password`=:password, `status`=1';
				$prepare = $conn->prepare($insert_pre); 
				$prepare->execute(array(
					":datex"=>time(), 
					":ip"=>get_ip::ip(), 
					":hash"=>$hash, 
					":email"=>$email1, 
					":password"=>$_COOKIE["password1"]
				));

				$ip = get_ip::ip();				
				$companyUserTypes = array("manufacturer","serviceprovider","company","individual");
				foreach($companyUserTypes as $ctype) :
					$sql2 = 'INSERT INTO `studio404_users` SET `registered_date`=:registered_date, `registered_ip`=:registered_ip, `username`=:email, `password`=:password, `company_type`=:company_type, `user_type`=:user_type, `allow`=:allow';
					$prepare2 = $conn->prepare($sql2);
					$prepare2->execute(array(
						":registered_date"=>time(), 
						":registered_ip"=>$ip, 
						":email"=>$email1, 
						":password"=>md5($password1), 
						":company_type"=>$ctype, 
						":user_type"=>'website', 
						":allow"=>2 
					));
				endforeach;

				$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=1';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(); 
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
				
				$host = $fetch["host"]; 
				$user = $fetch["user"]; 
				$pass = $fetch["pass"]; 
				$from = $fetch["from"]; 
				$fromname = $fetch["fromname"]; 

				$send_email = new send_email(); 
				$send_email->send($host,$user,$pass,$from,$fromname,$email1,"::Registration::",$msg); 
				echo $_SESSION['protect_x'];
			}
		endif;

		if(Input::method("POST","sendemail2")) : 
			$sendemail2 = Input::method("POST","sendemail3");
			$type2 = Input::method("POST","type2");
			$email2 = Input::method("POST","email2");
			$_SESSION["register_code_tradewithgeorgia"] = ustring::random(6);
			$msg = '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader.png" width="100%" alt="Mail header"/></div>';
			$msg .= '<p style="font-size:14px; font-family:roboto">Hello dear user, you have registered to our website: <b>'.WEBSITE.'</b>; Your registration code is: <font color="red">'.$_SESSION["register_code_tradewithgeorgia"].'</font></p>';
			$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:email AND `status`!=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":email"=>$email2, 
				":status"=>1
			));
			if($prepare->rowCount() > 0){
				echo "Error";
			}else{
				$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=1';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(); 
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
				
				$host = $fetch["host"]; 
				$user = $fetch["user"]; 
				$pass = $fetch["pass"]; 
				$from = $fetch["from"]; 
				$fromname = $fetch["fromname"]; 

				$send_email = new send_email(); 
				$send_email->send($host,$user,$pass,$from,$fromname,$email2,"::Registration::",$msg); 
			}
		endif;

		if(Input::method("POST","finalregister")=="true") : 
			if(!Input::method("POST","e") || !Input::method("POST","h")){
				echo "Error"; 
			}else{
				$e = Input::method("POST","e");
				$h = Input::method("POST","h");
				
				$sqlCheckPre = 'SELECT * FROM `studio404_users_pre` WHERE `email` LIKE "'.$e.'%" AND `hash`=:hash AND `status`=1';
				$preparePre = $conn->prepare($sqlCheckPre);
				$preparePre->execute(array(
					":hash"=>$h
				));
				if($preparePre->rowCount() > 0){
					$fetchPre = $preparePre->fetch(PDO::FETCH_ASSOC); 
					$email_pre = $fetchPre['email'];
					$password_pre = $fetchPre['password'];
					$id_pre = $fetchPre['id'];

					$sqlUpdatePre = 'UPDATE `studio404_users_pre` SET `status`=2 WHERE `id`=:id';
					$prepareUpdatePre = $conn->prepare($sqlUpdatePre);
					$prepareUpdatePre->execute(array(
						":id"=>$id_pre
					)); 
				}else{
					echo "Error"; 
					return 2;
				}


				$ip = get_ip::ip();

				$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:email AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":email"=>$email_pre, 
					":status"=>1
				));
				if($prepare->rowCount() > 0){
					echo "Error";
				}else{
					$companyUserTypes = array("manufacturer","serviceprovider","company","individual");
					foreach($companyUserTypes as $ctype) :
						$sql2 = 'INSERT INTO `studio404_users` SET `registered_date`=:registered_date, `registered_ip`=:registered_ip, `username`=:email, `password`=:password, `company_type`=:company_type, `user_type`=:user_type, `allow`=:allow';
						$prepare2 = $conn->prepare($sql2);
						$prepare2->execute(array(
							":registered_date"=>time(), 
							":registered_ip"=>$ip, 
							":email"=>$email_pre, 
							":password"=>md5($password_pre), 
							":company_type"=>$ctype, 
							":user_type"=>'website', 
							":allow"=>2
						));
					endforeach;
					echo "Done";
				}
			}			
		endif;

		if(Input::method("POST","finalregister2")) : 
			if(empty(Input::method("POST","code")) || Input::method("POST","code")!=$_SESSION["register_code_tradewithgeorgia"]){
				echo "Error"; 
			}else if(!Input::method("POST","t") || !Input::method("POST","e") || !Input::method("POST","p") || !Input::method("POST","p2")){
				echo "Error"; 
			}else if(!$this->isValidEmail(Input::method("POST","e"))){
				echo "Error"; 
			}else{
				$e = Input::method("POST","e");
				$p = Input::method("POST","p");
				$t = Input::method("POST","t");
				$ip = get_ip::ip();

				$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:email AND `status`!=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":email"=>$e, 
					":status"=>1
				));
				if($prepare->rowCount() > 0){
					echo "Error";
				}else{
					$companyUserTypes = array("manufacturer","serviceprovider","company","individual");
					foreach($companyUserTypes as $ctype) :
					$sql2 = 'INSERT INTO `studio404_users` SET `registered_date`=:registered_date, `registered_ip`=:registered_ip, `username`=:email, `password`=:password, `company_type`=:company_type, `user_type`=:user_type, `allow`=:allow';
					$prepare2 = $conn->prepare($sql2);
					$prepare2->execute(array(
						":registered_date"=>time(), 
						":registered_ip"=>$ip, 
						":email"=>$e, 
						":password"=>md5($p), 
						":company_type"=>$t, 
						":user_type"=>'website', 
						":allow"=>2
					));
					endforeach;
					echo "Done";
				}
			}
		endif;

		if(Input::method("POST","logintry")) :
			if(!Input::method("POST","lg") || !Input::method("POST","e") || !Input::method("POST","p") || !Input::method("POST","c")){
				echo "Error empty";
			}else if(Input::method("POST","c")!=$_SESSION['protect_x']){
				echo "Error code";
			}else{
				$e = Input::method("POST","e");
				$p = Input::method("POST","p");
				$sql = 'SELECT * FROM `studio404_users` WHERE `username`=:username AND `company_type`=:companyType AND `password`=:password AND `user_type`=:user_type AND `allow`=:two AND `status`!=:one'; 
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":username"=>$e, 
					":password"=>md5($p), 
					":user_type"=>'website', 
					":companyType"=>Input::method("POST","lg"), 
					":two"=>2, 
					":one"=>1 
				));
				if($prepare->rowCount() > 0){
					$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
					$_SESSION["tradewithgeorgia_username"] = $e; 
					$_SESSION["tradewithgeorgia_company_type"] = $fetch["company_type"]; 
					$_SESSION["tradewithgeorgia_user_id"] = $fetch["id"]; 
					if(!empty($fetch["namelname"])){
						$_SESSION["tradewithgeorgia_user_namelname"] = $fetch["namelname"]; 
					}
					// update 
					$usql = 'UPDATE `studio404_users` SET `logtime`=:logtime, `log`=`log`+1 WHERE `id`=:id';
					$prepare2 = $conn->prepare($usql); 
					$prepare2->execute(array(
						":logtime"=>time(), 
						":id"=>$fetch["id"], 
					));
					echo "Done"; 
				}else{
					echo "Error numrows"; 
				}
			}
		endif;

		if(Input::method("POST","logout")) :
			session_destroy();
			echo "Done"; 
		endif;

		if(Input::method("POST","loadsubsector") && $_SESSION["tradewithgeorgia_username"]){
			$sval = json_decode(Input::method("POST","sval")); 
			$l = count($sval);
			// echo "ass ".$l;
			$x = 1;
			$in = '';
			foreach($sval as $i){
				$i = (int)$i;
				if($x>=$l){
					$in .= $i;
				}else{
					$in .= $i.",";
				}
				$x++;
			}
			//echo $in;
			if(!Input::method("POST","products")){
				//echo '<option value="">Choose</option>';
			}
			try{
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid` IN ('.$in.') AND `visibility`!=:visibility AND `status`!=:status';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":visibility"=>1, 
					":status"=>1
				));
				
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				$i = 0;
				foreach ($fetch as $val) {
					//echo '<option value="'.$val['idx'].'" title="'.htmlentities($val['title']).'">'.$val['title'].'</option>';
					echo '<div class="selectItem2" data-checkbox="selectItemx'.$i.'">
							<input type="checkbox" name="selectItem2[]" class="sector_ids2" id="selectItemx'.$i.'" value="'.$val['idx'].'" />
							<span>'.$val['title'].'</span>
						</div>';
						$i++;
				}
			}catch(Exception $e){

			}
		}

		if(Input::method("POST","loadproducts") && $_SESSION["tradewithgeorgia_username"]){
			$sval = json_decode(Input::method("POST","sval")); 
			$l = count($sval);
			// echo "ass ".$l;
			$x = 1;
			$in = '';
			foreach($sval as $i){
				$i = (int)$i;
				if($x>=$l){
					$in .= $i;
				}else{
					$in .= $i.",";
				}
				$x++;
			}
			try{
				$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid` IN ('.$in.') AND `visibility`!=:visibility AND `status`!=:status';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":visibility"=>1, 
					":status"=>1
				));
				
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

				$checkusersproducts = 'SELECT `products` FROM `studio404_users` WHERE `username`=:username AND `status`!=:one';
				$prepare2 = $conn->prepare($checkusersproducts);
				$prepare2->execute(array(
					":username"=>$_SESSION["tradewithgeorgia_username"], 
					":one"=>1 
				));
				$f = $prepare2->fetch(PDO::FETCH_ASSOC);
				if($prepare2->rowCount()){
					$e = explode(",",$f["products"]);
				}else{
					$e = array();
				}
				$i = 0;
				foreach ($fetch as $val) {
					if(Input::method("POST","option")){
						if(!in_array($val['idx'], $e)){ continue; }
						echo '<option value="'.$val['idx'].'" title="'.htmlentities($val['title']).'">'.$val['title'].'</option>';
					}else{
						echo '<div class="selectItem3" data-checkbox="selectItemxx'.$i.'">
							<input type="checkbox" name="selectItem3[]" class="sector_ids3" id="selectItemxx'.$i.'" value="'.$val['idx'].'" />
							<span>'.$val['title'].'</span>
						</div>';
					}	
					$i++;
				}
			}catch(Exception $e){

			}
		}

		if(Input::method("POST","changeprofile")=="true" && $_SESSION["tradewithgeorgia_username"] && strlen(Input::method("POST","p_about")) <= 350){
			$p_companyname = strip_tags(Input::method("POST","p_companyname")); 
			$p_establishedin = strip_tags(Input::method("POST","p_establishedin"));
			$p_productioncapasity = strip_tags(Input::method("POST","p_productioncapasity"));
			$p_address = strip_tags(Input::method("POST","p_address"));
			$p_mobiles = strip_tags(Input::method("POST","p_mobiles"));
			$p_numemploy = strip_tags(Input::method("POST","p_numemploy"));
			
			$p_contactpersones = strip_tags(Input::method("POST","p_contactpersones"));
			$p_officephone = strip_tags(Input::method("POST","p_officephone"));
			$p_companysize = strip_tags(Input::method("POST","p_companysize"));
			$p_webaddress = strip_tags(Input::method("POST","p_webaddress"));

			$p_ad_position1 = strip_tags(Input::method("POST","p_ad_position1"));
			$p_ad_email1 = strip_tags(Input::method("POST","p_ad_email1"));
			$p_ad_person2 = strip_tags(Input::method("POST","p_ad_person2"));
			$p_ad_position2 = strip_tags(Input::method("POST","p_ad_position2"));
			$p_ad_mobile2 = strip_tags(Input::method("POST","p_ad_mobile2"));
			$p_ad_email2 = strip_tags(Input::method("POST","p_ad_email2"));

			// if(Input::method("POST","p_ad_upload_catalog")!=""){
			// 	$extention = explode(".",Input::method("POST","p_ad_upload_catalog")); 
			// 	$ext = strtolower(end($extention)); 
			// 	if($ext=="pdf"){
			// 		$str = file_get_contents("php://input");
			// 		$p_ad_upload_catalog = md5(time())."manu.pdf";
			// 		$path = DIR.'/files_pre/'.$p_ad_upload_catalog;
			// 		$path2 = DIR.'/files/document/'.$p_ad_upload_catalog;
			// 		file_put_contents($path, $str);
			// 		rename($path, $path2);
			// 	}
			// }
			
			$p_contactemail = strip_tags(Input::method("POST","p_contactemail"));
			$p_about = strip_tags(nl2br(Input::method("POST","p_about")));
			
			$p_products = json_decode(Input::method("POST","p_products"));
			$p_products = implode(",", $p_products); 

			$p_exportmarkets = json_decode(Input::method("POST","p_exportmarkets"));
			$p_exportmarkets = implode(",", $p_exportmarkets); 

			$p_sector = json_decode(Input::method("POST","p_sector"));
			$p_sector = implode(",", $p_sector); 

			$p_subsector = json_decode(Input::method("POST","p_subsector"));
			$p_subsector = implode(",", $p_subsector); 
			$p_file = Input::method("POST","p_file");

			$p_certificates = json_decode(Input::method("POST","p_certificates"));
			$p_certificates = implode(",", $p_certificates); 

			// $str = file_get_contents("php://input");
			// if($str){
			// 	$filename = md5(time()).".jpg";
			// 	$path = 'testu/'.$filename;
			// 	file_put_contents($path, $str);
			// }
			$sql = 'UPDATE `studio404_users` SET 
			`namelname`=:namelname, 
			`sector_id`=:sector_id, 
			`sub_sector_id`=:sub_sector_id, 
			`established_in`=:established_in, 
			`production_capacity`=:production_capacity, 
			`address`=:address, 
			`mobile`=:mobile, 
			`number_of_employes`=:number_of_employes, 
			`certificates`=:certificates, 
			`contact_person`=:contact_person, 
			`office_phone`=:office_phone, 
			`company_size`=:company_size, 
			`web_address`=:web_address, 
			`ad_position1`=:ad_position1, 
			`ad_email1`=:ad_email1, 
			`ad_person2`=:ad_person2, 
			`ad_position2`=:ad_position2, 
			`ad_mobile2`=:ad_mobile2, 
			`ad_email2`=:ad_email2, 
			`email`=:email, 
			`about`=:about, 
			`products`=:products, 
			`export_markets_id`=:export_markets_id 
			WHERE 
			`username`=:username AND 
			`id`=:companyId AND 
			`allow`!=:one AND 
			`status`!=:one 
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":namelname"=>$p_companyname, 
				":sector_id"=>$p_sector, 
				":sub_sector_id"=>$p_subsector, 
				":established_in"=>$p_establishedin, 
				":production_capacity"=>$p_productioncapasity, 
				":address"=>$p_address, 
				":mobile"=>$p_mobiles, 
				":number_of_employes"=>$p_numemploy, 
				":certificates"=>$p_certificates, 
				":contact_person"=>$p_contactpersones, 
				":office_phone"=>$p_officephone, 
				":company_size"=>$p_companysize, 
				":web_address"=>$p_webaddress, 
				":ad_position1"=>$p_ad_position1, 
				":ad_email1"=>$p_ad_email1, 
				":ad_person2"=>$p_ad_person2, 
				":ad_position2"=>$p_ad_position2, 
				":ad_mobile2"=>$p_ad_mobile2, 
				":ad_email2"=>$p_ad_email2, 
				":email"=>$p_contactemail, 
				":about"=>$p_about, 
				":products"=>$p_products, 
				":export_markets_id"=>$p_exportmarkets, 
				":username"=>$_SESSION["tradewithgeorgia_username"], 
				":companyId"=>$_SESSION["tradewithgeorgia_user_id"],  
				":one"=>1
			));

			$_SESSION["user_data"]["companyname"] = $p_companyname;
			$_SESSION["user_data"]["sector"] = $p_sector;
			$_SESSION["user_data"]["subsector"] = $p_subsector;
			$_SESSION["user_data"]["establishedin"] = $p_establishedin;
			$_SESSION["user_data"]["productioncapasity"] = $p_productioncapasity;
			$_SESSION["user_data"]["address"] = $p_address;
			$_SESSION["user_data"]["mobiles"] = $p_mobiles;
			$_SESSION["user_data"]["numemploy"] = $p_numemploy;
			$_SESSION["user_data"]["certificates"] = $p_certificates;
			$_SESSION["user_data"]["contactpersones"] = $p_contactpersones;
			$_SESSION["user_data"]["officephone"] = $p_officephone;
			$_SESSION["user_data"]["companysize"] = $p_companysize;
			$_SESSION["user_data"]["webaddress"] = $p_webaddress;
			
			$_SESSION["user_data"]["ad_position1"] = $p_ad_position1;
			$_SESSION["user_data"]["ad_email1"] = $p_ad_email1;
			$_SESSION["user_data"]["ad_person2"] = $p_ad_person2;
			$_SESSION["user_data"]["ad_position2"] = $p_ad_position2;
			$_SESSION["user_data"]["ad_mobile2"] = $p_ad_mobile2;
			$_SESSION["user_data"]["ad_email2"] = $p_ad_email2;

			$_SESSION["user_data"]["contactemail"] = $p_contactemail;
			$_SESSION["user_data"]["about"] = $p_about;
			$_SESSION["user_data"]["products"] = $p_products;
			$_SESSION["user_data"]["exportmarkets"] = $p_exportmarkets;

			echo "Done";
		}

	
		if(Input::method("POST","changecompanyprofile")=="true" && $_SESSION["tradewithgeorgia_username"]){
			$p_companyname = strip_tags(Input::method("POST","p_companyname")); 
			$p_establishedin = strip_tags(Input::method("POST","p_establishedin"));
			$p_address = strip_tags(Input::method("POST","p_address"));
			$p_mobiles = strip_tags(Input::method("POST","p_mobiles"));
			$p_numemploy = strip_tags(Input::method("POST","p_numemploy"));
			$p_contactpersones = strip_tags(Input::method("POST","p_contactpersones"));
			$p_officephone = strip_tags(Input::method("POST","p_officephone"));
			$p_companysize = strip_tags(Input::method("POST","p_companysize"));
			$p_webaddress = strip_tags(Input::method("POST","p_webaddress"));

			$p_ad_position1 = strip_tags(Input::method("POST","p_ad_position1"));
			$p_ad_email1 = strip_tags(Input::method("POST","p_ad_email1"));
			$p_ad_person2 = strip_tags(Input::method("POST","p_ad_person2"));
			$p_ad_position2 = strip_tags(Input::method("POST","p_ad_position2"));
			$p_ad_mobile2 = strip_tags(Input::method("POST","p_ad_mobile2"));
			$p_ad_email2 = strip_tags(Input::method("POST","p_ad_email2"));

			$p_contactemail = strip_tags(Input::method("POST","p_contactemail"));
			$p_about = strip_tags(nl2br(Input::method("POST","p_about")));
			
			$p_sector = json_decode(Input::method("POST","p_sector"));
			$p_sector = implode(",", $p_sector); 

		
			$p_file = Input::method("POST","p_file"); 

			// $str = file_get_contents("php://input");
			// if($str){
			// 	$filename = md5(time()).".jpg";
			// 	$path = 'testu/'.$filename;
			// 	file_put_contents($path, $str);
			// }
			$sql = 'UPDATE `studio404_users` SET 
			`namelname`=:namelname, 
			`sector_id`=:sector_id, 
			`sub_sector_id`=:sub_sector_id, 
			`established_in`=:established_in, 
			`production_capacity`=:production_capacity, 
			`address`=:address, 
			`mobile`=:mobile, 
			`number_of_employes`=:number_of_employes, 
			`certificates`=:certificates, 
			`contact_person`=:contact_person, 
			`office_phone`=:office_phone, 
			`company_size`=:company_size, 
			`web_address`=:web_address, 
			`ad_position1`=:ad_position1, 
			`ad_email1`=:ad_email1, 
			`ad_person2`=:ad_person2, 
			`ad_position2`=:ad_position2, 
			`ad_mobile2`=:ad_mobile2, 
			`ad_email2`=:ad_email2, 
			`email`=:email, 
			`about`=:about, 
			`products`=:products, 
			`export_markets_id`=:export_markets_id 
			WHERE 
			`username`=:username AND 
			`id`=:companyId AND 
			`allow`!=:one AND 
			`status`!=:one 
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":namelname"=>$p_companyname, 
				":sector_id"=>$p_sector, 
				":sub_sector_id"=>$p_subsector, 
				":established_in"=>$p_establishedin, 
				":production_capacity"=>$p_productioncapasity, 
				":address"=>$p_address, 
				":mobile"=>$p_mobiles, 
				":number_of_employes"=>$p_numemploy, 
				":certificates"=>$p_certificates, 
				":contact_person"=>$p_contactpersones, 
				":office_phone"=>$p_officephone, 
				":company_size"=>$p_companysize, 
				":web_address"=>$p_webaddress, 
				":ad_position1"=>$p_ad_position1, 
				":ad_email1"=>$p_ad_email1, 
				":ad_person2"=>$p_ad_person2, 
				":ad_position2"=>$p_ad_position2, 
				":ad_mobile2"=>$p_ad_mobile2, 
				":ad_email2"=>$p_ad_email2, 
				":email"=>$p_contactemail, 
				":about"=>$p_about, 
				":products"=>$p_products, 
				":export_markets_id"=>$p_exportmarkets, 
				":username"=>$_SESSION["tradewithgeorgia_username"], 
				":companyId"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));

			$_SESSION["user_data"]["companyname"] = $p_companyname;
			$_SESSION["user_data"]["sector"] = $p_sector;
			$_SESSION["user_data"]["establishedin"] = $p_establishedin;
			$_SESSION["user_data"]["address"] = $p_address;
			$_SESSION["user_data"]["mobiles"] = $p_mobiles;
			$_SESSION["user_data"]["numemploy"] = $p_numemploy;
			$_SESSION["user_data"]["contactpersones"] = $p_contactpersones;
			$_SESSION["user_data"]["officephone"] = $p_officephone;
			$_SESSION["user_data"]["companysize"] = $p_companysize;
			$_SESSION["user_data"]["webaddress"] = $p_webaddress;

			$_SESSION["user_data"]["ad_position1"] = $p_ad_position1;
			$_SESSION["user_data"]["ad_email1"] = $p_ad_email1;
			$_SESSION["user_data"]["ad_person2"] = $p_ad_person2;
			$_SESSION["user_data"]["ad_position2"] = $p_ad_position2;
			$_SESSION["user_data"]["ad_mobile2"] = $p_ad_mobile2;
			$_SESSION["user_data"]["ad_email2"] = $p_ad_email2;
			
			$_SESSION["user_data"]["contactemail"] = $p_contactemail;
			$_SESSION["user_data"]["about"] = $p_about;
		
			echo "Done";
		}



		if(Input::method("POST","changeindividualprofile")=="true" && $_SESSION["tradewithgeorgia_username"]){
			$p_companyname = strip_tags(Input::method("POST","p_companyname")); 
			$p_address = strip_tags(Input::method("POST","p_address"));
			$p_mobiles = strip_tags(Input::method("POST","p_mobiles"));
			$p_webaddress = strip_tags(Input::method("POST","p_webaddress"));
			$p_contactemail = strip_tags(Input::method("POST","p_contactemail"));

			$p_sector = json_decode(Input::method("POST","p_sector"));
			$p_sector = implode(",", $p_sector); 
			
			$sql = 'UPDATE `studio404_users` SET 
			`namelname`=:namelname, 
			`sector_id`=:sector_id, 
			`address`=:address, 
			`mobile`=:mobile, 
			`web_address`=:web_address, 
			`email`=:email 
			WHERE 
			`username`=:username AND 
			`id`=:companyId AND 
			`allow`!=:one AND 
			`status`!=:one 
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":namelname"=>$p_companyname, 
				":sector_id"=>$p_sector, 
				":address"=>$p_address, 
				":mobile"=>$p_mobiles, 
				":web_address"=>$p_webaddress, 
				":email"=>$p_contactemail, 
				":username"=>$_SESSION["tradewithgeorgia_username"], 
				":companyId"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));

			$_SESSION["user_data"]["companyname"] = $p_companyname;
			$_SESSION["user_data"]["sector"] = $p_sector;
			$_SESSION["user_data"]["address"] = $p_address;
			$_SESSION["user_data"]["mobiles"] = $p_mobiles;
			$_SESSION["user_data"]["webaddress"] = $p_webaddress;
			$_SESSION["user_data"]["contactemail"] = $p_contactemail;
		
			echo "Done";
		}



		if(Input::method("POST","changepassword")){
			if( !empty(Input::method("POST","o")) && !empty(Input::method("POST","n")) && !empty(Input::method("POST","r")) && (!empty(Input::method("POST","n"))==!empty(Input::method("POST","r"))) ){
				$oldpass = Input::method("POST","o");
				$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:username AND `password`=:password AND `allow`!=:one AND `status`!=:one';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":username"=>$_SESSION["tradewithgeorgia_username"], 
					":password"=>md5($oldpass), 
					":one"=>1
				));
				if($prepare->rowCount()){ 
					$n = md5(Input::method("POST","n"));
					$update = 'UPDATE `studio404_users` SET `password`=:password WHERE `username`=:username AND `allow`!=:one AND `status`!=:one'; 
					$prepare2 = $conn->prepare($update); 
					$prepare2->execute(array(
						":username"=>$_SESSION["tradewithgeorgia_username"], 
						":password"=>$n,
						":one"=>1
					));
					echo "Done";
				}else{
					echo "Error";
				}
			}else{
				echo "Error";
			}
		}

		if(Input::method("POST","hscode") && Input::method("POST","hscode")=="true" && Input::method("POST","s") && strlen(Input::method("POST","s"))>=3){
			if(is_numeric(Input::method("POST","s"))){
				$like = ' AND `title` LIKE "'.Input::method("POST","s").'%" ';
			}else{
				$like = ' AND `title` LIKE "%'.Input::method("POST","s").'%" ';
			}
			$sql = 'SELECT `idx`,`title` FROM `studio404_pages` WHERE `cid`=:cid '.$like.' AND `status`!=:one ORDER BY `title` ASC';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":cid"=>769, 
				":one"=>1
			));
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			if($prepare->rowCount()){
				foreach($fetch as $val){
					echo '<li><a href="javascript:;" class="resultx" data-idx="'.$val["idx"].'">'.$val["title"].'</a></li>';
				}
			}else{
				echo '';
			}
		}

		if(Input::method("POST","delproduct") && Input::method("POST","delproduct")=="true" && Input::method("POST","pid") && is_numeric(Input::method("POST","pid")) && !empty($_SESSION["tradewithgeorgia_user_id"])){
			
			$check = 'SELECT `position`,`picture` FROM `studio404_module_item` WHERE `idx`=:idx AND `module_idx`=3 AND `insert_admin`=:insert_admin'; 
		 	$pre_check = $conn->prepare($check);
		 	$pre_check->execute(array(
		 		":idx"=>(int)Input::method("POST","pid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"]
		 	));
		 	$ch_fetch = $pre_check->fetch(PDO::FETCH_ASSOC); 
		 	if(!empty($ch_fetch["picture"])){
		 		$old_pic = DIR . 'files/usersproducts/'.$ch_fetch["picture"]; 
		 		@unlink($old_pic);
		 	}

		 	$update_pos = 'UPDATE `studio404_module_item` SET `position`=`position`-1 WHERE `status`!=1 AND `position`>'.$ch_fetch['position'].' AND `module_idx`=3 ';
		 	$query = $conn->query($update_pos); 

			$sql = 'UPDATE `studio404_module_item` SET `status`=:one WHERE `insert_admin`=:insert_admin AND `module_idx`=:module_idx AND `idx`=:idx';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>(int)Input::method("POST","pid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
		 		":module_idx"=>3, 
		 		":one"=>1
			));
			echo "Done"; 
		}


		if(Input::method("POST","delservice") && Input::method("POST","delservice")=="true" && Input::method("POST","sid") && is_numeric(Input::method("POST","sid")) && !empty($_SESSION["tradewithgeorgia_user_id"])){
			
			$check = 'SELECT `position` FROM `studio404_module_item` WHERE `idx`=:idx AND `module_idx`=4 AND `insert_admin`=:insert_admin'; 
		 	$pre_check = $conn->prepare($check);
		 	$pre_check->execute(array(
		 		":idx"=>(int)Input::method("POST","sid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"]
		 	));
		 	$ch_fetch = $pre_check->fetch(PDO::FETCH_ASSOC); 
		 	// if(!empty($ch_fetch["picture"])){
		 	// 	$old_pic = DIR . 'files/usersproducts/'.$ch_fetch["picture"]; 
		 	// 	@unlink($old_pic);
		 	// }

		 	$update_pos = 'UPDATE `studio404_module_item` SET `position`=`position`-1 WHERE `status`!=1 AND `position`>'.$ch_fetch['position'].' AND `module_idx`=4 ';
		 	$query = $conn->query($update_pos); 

			$sql = 'UPDATE `studio404_module_item` SET `status`=:one WHERE `insert_admin`=:insert_admin AND `module_idx`=:module_idx AND `idx`=:idx';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>(int)Input::method("POST","sid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
		 		":module_idx"=>4, 
		 		":one"=>1
			));
			echo "Done"; 
		}

		if(Input::method("POST","delenquire")=="true" && Input::method("POST","eid") && is_numeric(Input::method("POST","eid")) && !empty($_SESSION["tradewithgeorgia_user_id"])){
			
			$check = 'SELECT `position` FROM `studio404_module_item` WHERE `idx`=:idx AND `module_idx`=5 AND `insert_admin`=:insert_admin'; 
		 	$pre_check = $conn->prepare($check);
		 	$pre_check->execute(array(
		 		":idx"=>(int)Input::method("POST","eid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"]
		 	));
		 	$ch_fetch = $pre_check->fetch(PDO::FETCH_ASSOC); 
		 	// if(!empty($ch_fetch["picture"])){
		 	// 	$old_pic = DIR . 'files/usersproducts/'.$ch_fetch["picture"]; 
		 	// 	@unlink($old_pic);
		 	// }

		 	$update_pos = 'UPDATE `studio404_module_item` SET `position`=`position`-1 WHERE `status`!=1 AND `position`>'.$ch_fetch['position'].' AND `module_idx`=5 ';
		 	$query = $conn->query($update_pos); 

			$sql = 'UPDATE `studio404_module_item` SET `status`=:one WHERE `insert_admin`=:insert_admin AND `module_idx`=:module_idx AND `idx`=:idx';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>(int)Input::method("POST","eid"), 
		 		":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
		 		":module_idx"=>5, 
		 		":one"=>1
			));
			echo "Done"; 
		}

		if(Input::method("POST","addproduct")=="true" && Input::method("POST","p") && Input::method("POST","pn") && Input::method("POST","d") && strlen(Input::method("POST","d")) <= 350)
		{
			if(isset($_SESSION["addproducttry"]) && $_SESSION["addproducttry"] == Input::method("POST","pn")){
				echo "Error";
			}
			$topublish = calculate::filled($_SESSION["user_data"]);
			if($topublish<100){ exit(); }
			$products = (int)Input::method("POST","p");
			$shelf_life = strip_tags(Input::method("POST","s"));
			$packaging = strip_tags(Input::method("POST","pkg"));
			$awards = strip_tags(Input::method("POST","a"));
			$prcap = strip_tags(Input::method("POST","prcap"));

			$check_product = 'SELECT `cid` FROM `studio404_pages` WHERE `idx`=:idx AND `status`!=:one'; 
			$prepare = $conn->prepare($check_product); 
			$prepare->execute(array(
				":idx"=>$products, 
				":one"=>1
			));
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			
			$retrieve_users_info = new retrieve_users_info();
			$subsector = (int)$retrieve_users_info->retrieve_subsector_from_product($products,"idx"); 

			$check_hscode = 'SELECT `id` FROM `studio404_pages` WHERE `cid`=:cid AND `idx`=:idx AND `status`!=:one';
			$prepare2 = $conn->prepare($check_hscode); 
			$prepare2->execute(array(
				":cid"=>769, 
				":idx"=>(int)Input::method("POST","c"), 
				":one"=>1
			));

			if(!$prepare->rowCount() || !$prepare2->rowCount()){
				echo "Error"; 
			}else{

				//select max idx
				$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_module_item`';
				$querym = $conn->query($sqlm);
				$rowm = $querym->fetch(PDO::FETCH_ASSOC);
				$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

				// pos
				$sqlm2 = 'SELECT MAX(`position`)+1 AS pos FROM `studio404_module_item` WHERE `module_idx`=3 AND `status`!=1';
				$querym2 = $conn->query($sqlm2);
				$rowm2 = $querym2->fetch(PDO::FETCH_ASSOC);
				$pos = ($rowm2['pos']) ? $rowm2['pos'] : 1;

				$slug_generation = new slug_generation();
				$uid = new uid();
				$u = $uid->generate();
				$slug = PRE_VIEW."/".$u."/".$slug_generation->generate(Input::method("POST","pn"));

				$sql = 'INSERT INTO `studio404_module_item` SET 
				`idx`=:idx, 
				`uid`=:uid, 
				`insert_ip`=:insert_ip, 
				`date`=:datex, 
				`module_idx`=:module_idx, 
				`title`=:title, 
				`hscode`=:hscode, 
				`sub_sector_id`=:sub_sector_id, 
				`products`=:products, 
				`shelf_life`=:shelf_life, 
				`packaging`=:packaging, 
				`awards`=:awards, 
				`production_capacity`=:production_capacity, 
				`long_description`=:long_description, 
				`slug`=:slug, 
				`insert_admin`=:insert_admin, 
				`position`=:position, 
				`lang`=:lang, 
				`visibility`=:visibility, 
				`status`=:status';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":idx"=>$maxidm, 
					":uid"=>$u, 
					":insert_ip"=>get_ip::ip(), 
					":datex"=>time(), 
					":module_idx"=>3, 
					":title"=>strip_tags(Input::method("POST","pn")), 
					":hscode"=>strip_tags(Input::method("POST","c")), 
					":sub_sector_id"=>$subsector, 
					":products"=>$products, 
					":shelf_life"=>$shelf_life, 
					":packaging"=>$packaging, 
					":awards"=>$awards, 
					":production_capacity"=>$prcap, 
					":long_description"=>strip_tags(nl2br(Input::method("POST","d"))), 
					":slug"=>$slug, 
					":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
					":position"=>$pos, 
					":lang"=>LANG_ID, 
					":visibility"=>1, 
					":status"=>0 
				));
				if(!$prepare){
					echo "Error";
				}else{
					echo $maxidm;
					$_SESSION["addproducttry"] = Input::method("POST","pn");
				}
			}
		}


		if(Input::method("POST","loadproduct")=="true" && Input::method("POST","prid") && is_numeric(Input::method("POST","prid"))){
			// load project info for update form
			$products_sql = 'SELECT 
			`studio404_module_item`.`id`,
			`studio404_module_item`.`idx`,
			`studio404_module_item`.`title`,
			`studio404_module_item`.`picture`,
			`studio404_module_item`.`shelf_life`,
			`studio404_module_item`.`packaging`,
			`studio404_module_item`.`awards`,
			`studio404_module_item`.`production_capacity`,
			`studio404_module_item`.`long_description`,
			`studio404_module_item`.`visibility`, 
			`studio404_pages`.`idx` AS hs_id,
			`studio404_pages`.`title` AS hs_title
			FROM 
			`studio404_module_item`, `studio404_pages`
			WHERE 
			`studio404_module_item`.`idx`=:idx AND 
			`studio404_module_item`.`insert_admin`=:insert_admin AND 
			`studio404_module_item`.`status`!=:one AND 
			`studio404_module_item`.`hscode`=`studio404_pages`.`idx` AND 
			`studio404_pages`.`status`!=:one  
			ORDER BY `studio404_module_item`.`date` DESC LIMIT 10';
			$prepare_product = $conn->prepare($products_sql);
			$prepare_product->execute(array(
				":idx"=>Input::method("POST","prid"), 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			$fetch = $prepare_product->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($fetch);
		}




		if(Input::method("POST","loadservices")=="true" && Input::method("POST","srid") && is_numeric(Input::method("POST","srid")) && $_SESSION["tradewithgeorgia_user_id"]){
			// load project info for update form
			$products_sql = 'SELECT `id`,`idx`,`title`,`products`,`long_description`
			FROM `studio404_module_item` WHERE `id`=:id AND `insert_admin`=:insert_admin AND `status`!=:one ORDER BY `date` DESC LIMIT 10';
			$prepare_product = $conn->prepare($products_sql);
			$prepare_product->execute(array(
				":id"=>Input::method("POST","srid"), 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			$fetch = $prepare_product->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($fetch);
		}

		if(Input::method("POST","loadenquires")=="true" && Input::method("POST","eid") && is_numeric(Input::method("POST","eid")) && $_SESSION["tradewithgeorgia_user_id"]){
			// load project info for update form
			$products_sql = 'SELECT `id`,`idx`,`title`,`type`,`sector_id`,`long_description`
			FROM `studio404_module_item` WHERE `id`=:id AND `insert_admin`=:insert_admin AND `status`!=:one ORDER BY `date` DESC LIMIT 10';
			$prepare_product = $conn->prepare($products_sql);
			$prepare_product->execute(array(
				":id"=>Input::method("POST","eid"), 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			$fetch = $prepare_product->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($fetch);
		}

		if(Input::method("POST","changeservice")=="true" && is_numeric(Input::method("POST","i")) && Input::method("POST","s") && Input::method("POST","t") && Input::method("POST","d")){
			$i = Input::method("POST","i"); 
			$s = Input::method("POST","s"); 
			$t = Input::method("POST","t"); 
			$d = Input::method("POST","d"); 
			$retrieve_users_info = new retrieve_users_info();
			//$p = $retrieve_users_info->retrieveDb($s); 

			$subsector = (int)$retrieve_users_info->retrieve_subsector_from_product($s,"idx"); 

			$sql = 'UPDATE `studio404_module_item` SET 
			`title`=:title, 
			`sub_sector_id`=:sub_sector_id, 
			`products`=:products, 
			`long_description`=:long_description, 
			`visibility`=:one  
			WHERE 
			`id`=:id AND  
			`insert_admin`=:insert_admin   
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":title"=>$t, 
				":sub_sector_id"=>$subsector, 
				":products"=>$s, 
				":long_description"=>$d, 
				":id"=>$i, 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			echo "Done"; 
		}

		//
		if(Input::method("POST","changeenquire")=="true" && is_numeric(Input::method("POST","i")) && Input::method("POST","t") && Input::method("POST","s") && Input::method("POST","ti") && Input::method("POST","d")){
			$i = Input::method("POST","i"); 
			$t = Input::method("POST","t"); 
			$s = Input::method("POST","s"); 
			$ti = Input::method("POST","ti"); 
			$d = Input::method("POST","d"); 
			

			$sql = 'UPDATE `studio404_module_item` SET 
			`type`=:type, 
			`sector_id`=:sector_id, 
			`title`=:title, 
			`long_description`=:long_description, 
			`visibility`=:one  
			WHERE 
			`id`=:id AND  
			`insert_admin`=:insert_admin   
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":type"=>$t, 
				":sector_id"=>$s, 
				":title"=>$ti, 
				":long_description"=>$d, 
				":id"=>$i, 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			echo "Done"; 
		}


		if(Input::method("POST","makeitchange")=="true"){
			$pi = Input::method("POST","pi"); 
			$pn = Input::method("POST","pn"); 
			$phs = Input::method("POST","phs"); 
			$psl = Input::method("POST","psl"); 
			$pp = Input::method("POST","pp"); 
			$pa = Input::method("POST","pa"); 
			$pd = Input::method("POST","pd"); 
			$prdcap = Input::method("POST","prdcap"); 
			$sql = 'UPDATE `studio404_module_item` SET 
			`title`=:title, 
			`hscode`=:hscode, 
			`shelf_life`=:shelf_life, 
			`packaging`=:packaging, 
			`awards`=:awards, 
			`production_capacity`=:production_capacity, 
			`long_description`=:long_description, 
			`visibility`=:one  
			WHERE 
			`id`=:id AND  
			`insert_admin`=:insert_admin   
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":title"=>$pn, 
				":hscode"=>$phs, 
				":shelf_life"=>$psl, 
				":packaging"=>$pp, 
				":awards"=>$pa, 
				":long_description"=>$pd, 
				":production_capacity"=>$prdcap, 
				":id"=>$pi, 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":one"=>1
			));
			echo "Done"; 
		}

		if(Input::method("POST","addservice")=="true" && Input::method("POST","t") && Input::method("POST","s") && Input::method("POST","d")){
			$t = Input::method("POST","t");
			$s = Input::method("POST","s");
			$d = Input::method("POST","d");

			if(isset($_SESSION["addproducttry"]) && $_SESSION["addproducttry"] == Input::method("POST","s")){
				echo "Error";
			} 

			//select max idx
			$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_module_item`';
			$querym = $conn->query($sqlm);
			$rowm = $querym->fetch(PDO::FETCH_ASSOC);
			$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

			// pos
			$sqlm2 = 'SELECT MAX(`position`)+1 AS pos FROM `studio404_module_item` WHERE `module_idx`=5197 AND `status`!=1';
			$querym2 = $conn->query($sqlm2);
			$rowm2 = $querym2->fetch(PDO::FETCH_ASSOC);
			$pos = ($rowm2['pos']) ? $rowm2['pos'] : 1;

			$slug_generation = new slug_generation();
			$uid = new uid();
			$u = $uid->generate();
			$slug = PRE_VIEW."/".$u."/".$slug_generation->generate(Input::method("POST","t"));

			$retrieve_users_info = new retrieve_users_info();
			//$p = $retrieve_users_info->retrieveDb($t); 

			$subsector = (int)$retrieve_users_info->retrieve_subsector_from_product($t,"idx"); 

			$sql = 'INSERT INTO `studio404_module_item` SET 
			`idx`=:idx, 
			`uid`=:uid, 
			`insert_ip`=:insert_ip, 
			`date`=:datex, 
			`module_idx`=:module_idx, 
			`title`=:title,
			`sub_sector_id`=:sub_sector_id,
			`products`=:products,
			`long_description`=:long_description, 
			`slug`=:slug, 
			`insert_admin`=:insert_admin, 
			`position`=:position, 
			`lang`=:lang, 
			`visibility`=:visibility, 
			`status`=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$maxidm, 
				":uid"=>$u, 
				":insert_ip"=>get_ip::ip(), 
				":datex"=>time(), 
				":module_idx"=>4, 
				":title"=>$s, 
				":sub_sector_id"=>$subsector, 
				":products"=>(int)$t, 
				":long_description"=>strip_tags(nl2br($d)), 
				":slug"=>$slug, 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":position"=>$pos, 
				":lang"=>LANG_ID, 
				":visibility"=>1, 
				":status"=>0 
			));
			$_SESSION["addproducttry"] = Input::method("POST","s"); 
			echo "Done";
		}

		if(Input::method("POST","addenquire")=="true" && Input::method("POST","t") && Input::method("POST","s") && Input::method("POST","ti") && Input::method("POST","d")){
			$t = Input::method("POST","t");
			$s = Input::method("POST","s");
			$ti = Input::method("POST","ti");
			$d = Input::method("POST","d");

			//select max idx
			$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_module_item`';
			$querym = $conn->query($sqlm);
			$rowm = $querym->fetch(PDO::FETCH_ASSOC);
			$maxidm = ($rowm['maxid']) ? $rowm['maxid'] : 1;

			// pos
			$sqlm2 = 'SELECT MAX(`position`)+1 AS pos FROM `studio404_module_item` WHERE `module_idx`=5198 AND `status`!=1';
			$querym2 = $conn->query($sqlm2);
			$rowm2 = $querym2->fetch(PDO::FETCH_ASSOC);
			$pos = ($rowm2['pos']) ? $rowm2['pos'] : 1;

			$slug_generation = new slug_generation();
			$uid = new uid();
			$u = $uid->generate();
			$slug = PRE_VIEW."/".$u."/".$slug_generation->generate($ti);


			$sql = 'INSERT INTO `studio404_module_item` SET 
			`idx`=:idx, 
			`uid`=:uid, 
			`insert_ip`=:insert_ip, 
			`date`=:datex, 
			`module_idx`=:module_idx, 
			`type`=:type, 
			`title`=:title,
			`sector_id`=:sector_id,
			`long_description`=:long_description, 
			`slug`=:slug, 
			`insert_admin`=:insert_admin, 
			`position`=:position, 
			`lang`=:lang, 
			`visibility`=:visibility, 
			`status`=:status';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":idx"=>$maxidm, 
				":uid"=>$u, 
				":insert_ip"=>get_ip::ip(), 
				":datex"=>time(), 
				":module_idx"=>5, 
				":type"=>$t, 
				":title"=>$ti, 
				":sector_id"=>(int)$s, 
				":long_description"=>strip_tags(nl2br($d)), 
				":slug"=>$slug, 
				":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
				":position"=>$pos, 
				":lang"=>LANG_ID, 
				":visibility"=>1, 
				":status"=>0 
			));
			echo "Done";
		}

		if(Input::method("POST","saveusersemail") && Input::method("POST","e")){
			
			if($this->isValidEmail(Input::method("POST","e"))){
				if(Input::method("POST","latestupdates")=="true"){//products and enquires
					$sql = 'SELECT `id` FROM `studio404_newsletter_emails` WHERE `type`="email" AND `group_id`=1 AND `email`=:email AND `status`!=:one ';
					$prepare = $conn->prepare($sql); 
					$prepare->execute(array(
						":email"=>Input::method("POST","e"), 
						":one"=>1
					));
					if($prepare->rowCount() > 0){
						echo "Exists";
					}else{
						$unsubscribe = sha1(md5(Input::method("POST","e")."Studio404"));
						$sql_insert = 'INSERT INTO `studio404_newsletter_emails` SET `type`="email", `unsubscribe`=:unsubscribe, `u_ip`=:u_ip, `name`="User", `group_id`=1, `email`=:email ';
						$prepare2 = $conn->prepare($sql_insert); 
						$prepare2->execute(array(
							":unsubscribe"=>$unsubscribe,
							":u_ip"=>get_ip::ip(), 
							":email"=>Input::method("POST","e")
						));
						echo "Done"; 
					}
				}	
			}else{
				echo "Error";
			}

		}

		if(Input::method("POST","loadevents")=="true"){
			$current = time(); 
			$sql = 'SELECT 
			`studio404_module_item`.`idx` AS smi_idx,  
			`studio404_module_item`.`title` AS smi_title 
			FROM 
			`studio404_module_attachment`, `studio404_module`, `studio404_module_item`
			WHERE 
			`studio404_module_attachment`.`connect_idx`=:sma_connect_id AND 
			`studio404_module_attachment`.`page_type`=:sma_page_type AND 
			`studio404_module_attachment`.`lang`=:lang AND 
			`studio404_module_attachment`.`status`!=:status AND 
			`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
			`studio404_module`.`lang`=:lang AND 
			`studio404_module`.`status`!=:status AND 
			`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
			`studio404_module_item`.`date`>:current AND 
			`studio404_module_item`.`lang`=:lang AND 
			`studio404_module_item`.`status`!=:status 
			ORDER BY 
			`studio404_module_item`.`date` DESC
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":sma_connect_id"=>16, 
				":sma_page_type"=>'eventpage', 
				":lang"=>LANG_ID, 
				":status"=>1, 
				":current"=>$current
			));
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC); 
			echo json_encode($fetch);
		}

		if(Input::method("POST","regEvent")=="true" && Input::method("POST","ei") && Input::method("POST","n") && Input::method("POST","e") && Input::method("POST","m")){
			$event = 'SELECT `title` FROM `studio404_module_item` WHERE `idx`=:idx';
			$prepare_e = $conn->prepare($event); 
			$prepare_e->execute(array(
				":idx"=>(int)Input::method("POST","ei")
			));
			$fetch_e = $prepare_e->fetch(PDO::FETCH_ASSOC); 

			$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=1';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(); 
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			
			$host = $fetch["host"]; 
			$user = $fetch["user"]; 
			$pass = $fetch["pass"]; 
			$where_to_send = $fetch["from"]; 
			$subject = "::Event registration:: - Trade with georgia"; 

			$from = Input::method("POST","e"); 
			$fromname = Input::method("POST","n"); 
			$mobile = Input::method("POST","m"); 

			$uid = new uid();
			$event_ticket_id = $uid->generate(6);

			$message = '';
			$message .= '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader.png" width="100%" alt="Mail header"/></div>';
			$message .= '<b>Send time: </b>'.date("d/m/Y H:m:s")."<br />";
			$message .= '<b>Tickit: </b> #'.$event_ticket_id."<br />";
			$message .= '<b>Company or Person Name: </b>'.$fromname."<br />";
			$message .= '<b>Event: </b>'.$fetch_e["title"]."<br />";
			$message .= '<b>Email address: </b>'.$from."<br />";
			$message .= '<b>Mobile / Phone number: </b>'.$mobile."<br />";
			$message .= '<b>Sender IP: </b>'.get_ip::ip()."<br />";

			$message2 = '';
			$message2 .= '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader.png" width="100%" alt="Mail header"/></div>';
			$message2 .= '<b>Send time: </b>'.date("d/m/Y H:m:s")."<br />";
			$message2 .= '<b>Tickit: </b> #'.$event_ticket_id."<br />";
			$message2 .= 'You have successfully registered for the event: <b>'.$fetch_e["title"]."</b> <br />";


			$send_email = new send_email(); 
			$send_email->send($host,$user,$pass,$from,$fromname,$where_to_send,$subject,$message); 
			$send_email->send($host,$user,$pass,$fetch["from"],$fetch["fromname"],Input::method("POST","e"),$subject,$message2); 
			echo "Done"; 
		}

		if(Input::method("POST","sendmsgtouser")=="true" && is_numeric(Input::method("POST","i")) && Input::method("POST","n") && Input::method("POST","c") && Input::method("POST","e") && Input::method("POST","cn") && Input::method("POST","m")){

			if($this->isValidEmail(Input::method("POST","e"))){

				$sql = 'SELECT `id`,`namelname`,`email` FROM `studio404_users` WHERE `id`=:id AND `status`!=:one';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":id"=>(int)Input::method("POST","i"), 
					":one"=>1
				));

				if($prepare->rowCount() > 0){
					$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
					if($fetch["email"]){

						$sql2 = 'SELECT `title` FROM `studio404_pages` WHERE `idx`=:idx';
						$prepare2 = $conn->prepare($sql2);
						$prepare2->execute(array(
							":idx"=>(int)Input::method("POST","c") 
						));
						$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);

						// select email hosts
						$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=1';
						$prepare = $conn->prepare($sql); 
						$prepare->execute(); 
						$fetch_ = $prepare->fetch(PDO::FETCH_ASSOC); 
						
						$host = $fetch_["host"]; 
						$user = $fetch_["user"]; 
						$pass = $fetch_["pass"]; 
						$from = $fetch_["from"]; 
						$fromname = $fetch_["fromname"]; 
						$subject = "::Message::";


						$message = '';
						$message .= '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader.png" width="100%" alt="Mail header"/></div>';
						$message .= '<b>Send time: </b>'.date("d/m/Y H:m:s")."<br />";
						$message .= '<b>Company or Person Name: </b>'.strip_tags(Input::method("POST","n"))."<br />";
						$message .= '<b>Country: </b>'.strip_tags($fetch2["title"])."<br />";
						$message .= '<b>Email address: </b>'.strip_tags(Input::method("POST","e"))."<br />";
						$message .= '<b>Contact number: </b>'.strip_tags(Input::method("POST","cn"))."<br />";
						$message .= '<b>Message: </b>'.strip_tags(Input::method("POST","m"))."<br />";
						$message .= '<b>Sender IP: </b>'.get_ip::ip()."<br />";



						$send_email = new send_email(); 
						$send_email->send($host,$user,$pass,$from,$fromname,$fetch["email"],$subject,$message); 

						$to_to = '<i>Msg sent to '.$fetch["id"].') '.$fetch["namelname"].'</i>';

						$send_email->send($host,$user,$pass,$from,$fromname,$from,"::Message::", $message.$to_to); 
						echo "Done";

					}else{
						echo "Error";
					}
				}else{
					echo "Error";
				}

			}else{
				echo "Error";
			}

		}

		if(Input::method("POST","asktoaddcertificate")=="true" && Input::method("POST","c") && $_SESSION["tradewithgeorgia_user_id"]){
			
			$sql = 'SELECT `id` FROM `studio404_pages` WHERE `title`=:title AND `cid`=755 AND `status`!=1';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":title"=>Input::method("POST","c")
			));
			if($prepare->rowCount() > 0){
				echo "Exists";
			}else{
				$max = 'SELECT `id`, (SELECT MAX(`idx`) FROM `studio404_pages`) AS maxidx, (SELECT MAX(`position`) FROM `studio404_pages` WHERE `cid`=755 AND `status`!=1) AS maxposition FROM `studio404_pages` LIMIT 1';
				$prepareMax = $conn->prepare($max);
				$prepareMax->execute();
				$fetchMax = $prepareMax->fetch(PDO::FETCH_ASSOC); 

				$c = Input::method("POST","c");
				$slug = slug_generation::gen($c);
				$maxidx = ($fetchMax["maxidx"]+1);
				$maxposition = ($fetchMax["maxposition"]+1);
				
				$sqlinsert = 'INSERT INTO `studio404_pages` SET `idx`=:maxidx, `cid`=755, `date`=:datex, `menu_type`="sub", `page_type`="textpage", `title`=:title, `shorttitle`=:title, `redirectlink`="false", `slug`=:slug, `insert_admin`=:insert_admin, `lang`=5, `visibility`=1, `position`=:maxposition ';
				
				$prepareinsert = $conn->prepare($sqlinsert); 
				$prepareinsert->execute(array(
					":maxidx"=>$maxidx, 
					":maxposition"=>$maxposition,
					":datex"=>time(), 
					":title"=>$c, 
					":slug"=>$slug, 
					":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"]
				));
				echo "Done";
			}
		}

		if(Input::method("POST","loadreadmore")=="true" && is_numeric(Input::method("POST","u")) && is_numeric(Input::method("POST","p"))){
			$sql = 'SELECT 
			`studio404_module_item`.*, 
			(SELECT `studio404_users`.`company_type` FROM `studio404_users` WHERE `studio404_users`.`id`=`studio404_module_item`.`insert_admin`) AS com_type, 
			(SELECT `studio404_users`.`namelname` FROM `studio404_users` WHERE `studio404_users`.`id`=`studio404_module_item`.`insert_admin`) AS com_name, 
			(SELECT `studio404_pages`.`title` FROM `studio404_pages` WHERE `studio404_pages`.`idx`=`studio404_module_item`.`hscode`) AS hscode_title 
			FROM 
			 `studio404_module_item`
			 WHERE 
			 `studio404_module_item`.`insert_admin`='.(int)Input::method("POST","u").' AND 
			 `studio404_module_item`.`id`='.(int)Input::method("POST","p").' AND 
			 `studio404_module_item`.`status`!=:one
			';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":one"=>1
			));
			if($prepare->rowCount()>0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
				$retrieve_users_info = new retrieve_users_info();

				$out = '';

				$picture = ($fetch["picture"]) ? WEBSITE.'image?f='.WEBSITE.'files/usersproducts/'.$fetch["picture"].'&w=175&h=175' : '';

				if($fetch["com_type"]=="manufacturer"){
					$out .= '<div class="col-sm-12"><h3 class="modal-title">'.$fetch["title"].'</h3></div>';
					$out .= '<div class="col-sm-4">';
					$out .= '<div class="form-group"><img src="'.$picture.'" class="img-responsive" alt="" style="width:100%" /></div>';
					$out .= '</div>';
					// ------------------------------------------------------------//
					$out .= '<div class="col-sm-8">';

					$out .= '<div class="form-group"><b>HS code:</b> '.$fetch["hscode_title"].'</div>';
					$out .= '<div class="form-group"><b>Packiging:</b> '.$fetch["packaging"].'</div>';
					$out .= '<div class="form-group"><b>Shelf life:</b> '.$fetch["shelf_life"].'</div>';
					$out .= '<div class="form-group"><b>Awards:</b> '.$fetch["awards"].'</div>';
					$out .= '<div class="form-group"><b>Description:</b> '.nl2br(strip_tags($fetch["long_description"])).'</div>';
					$out .= '<div class="form-group"><b>Product Analysis:</b> <a href="'.WEBSITE.'files/document/'.$fetch["productanalisis"].'" target="_blank">PDF</a></div>';
					$out .= '<div class="form-group"><b>User:</b> '.$fetch["com_name"].'</div>';
					$out .= '</div>';
				}else if($fetch["com_type"]=="serviceprovider"){
					$out .= '<div class="col-sm-12">';
					$out .= '<h3 class="modal-title">'.$fetch["title"].'</h3>';
					$out .= '<div class="form-group"><b>Description:</b> '.nl2br(strip_tags($fetch["long_description"])).'</div>';
					$out .= '<div class="form-group"><b>User:</b> '.$fetch["com_name"].'</div>';
					$out .= '</div>';
				}else if($fetch["com_type"]=="company" || $fetch["com_type"]=="individual"){
					$out .= '<div class="col-sm-12">';
					$out .= '<h3 class="modal-title">'.$fetch["title"].'</h3>';
					$out .= '<div class="form-group"><b>Date:</b> '.date("d.m.Y",$fetch["date"]).'</div>';
					$out .= '<div class="form-group"><b>Description:</b> '.nl2br(strip_tags($fetch["long_description"])).'</div>';
					$out .= '<div class="form-group"><b>User:</b> '.$fetch["com_name"].'</div>';
					$out .= '</div>';
				}
				echo $out;
			}	
		}

		if(Input::method("POST","loadmore")=="true"){
			$type = Input::method("POST","t"); 
			$typex = Input::method("POST","tx"); 
			$sector = Input::method("POST","sec"); 
			$subsector = Input::method("POST","ss"); 
			$products = Input::method("POST","p");
			$exportmarkets = Input::method("POST","e");
			$certificate = Input::method("POST","c");
			$enquire_type = Input::method("POST","v");
			$from = Input::method("POST","f");
			$load = Input::method("POST","l");
			$search = Input::method("POST","ser");
			$uid = Input::method("POST","uid");

			switch($type){
				case "companylist":
				$limit = ' LIMIT '.$from.', '.$load;
				$orderBy = ' ORDER BY `studio404_users`.`id` DESC';

				$subsectors = ($subsector && is_numeric($subsector)) ? ' FIND_IN_SET('.$subsector.',`studio404_users`.`sub_sector_id`) AND ' : '';
				$products = ($products && is_numeric($products)) ? ' FIND_IN_SET('.$products.',`studio404_users`.`products`) AND ' : '';
				$exportmarkets = ($exportmarkets && is_numeric($exportmarkets)) ? ' FIND_IN_SET('.$exportmarkets.',`studio404_users`.`export_markets_id`) AND ' : '';
				$certificates = ($certificate && is_numeric($certificate)) ? ' FIND_IN_SET('.$certificate.',`studio404_users`.`certificates`) AND ' : '';
				$search = (!empty($search)) ? '`studio404_users`.`namelname` LIKE "%'.$search.'%" AND ' : '';
				 
				$sql = 'SELECT 
				`studio404_users`.`id` AS su_id,
				`studio404_users`.`username` AS su_username,
				`studio404_users`.`sub_sector_id` AS su_sub_sector_id,
				`studio404_users`.`namelname` AS su_namelname,
				`studio404_users`.`picture` AS su_picture,
				`studio404_users`.`products` AS su_products, 
				`studio404_users`.`export_markets_id` AS su_export_markets_id, 
				`studio404_users`.`certificates` AS su_certificates, 
				`studio404_users`.`company_type` AS su_companytype
				FROM 
				`studio404_users`
				WHERE 
				`studio404_users`.`user_type`=:user_type AND 
				`studio404_users`.`allow`!=:one AND 
				`studio404_users`.`namelname`<>"" AND 
				`studio404_users`.`picture`<>"" AND 
				`studio404_users`.`sector_id`<>"" AND 
				`studio404_users`.`sub_sector_id`<>"" AND 
				`studio404_users`.`products`<>"" AND 
				'.$subsectors.' 
				'.$products.' 
				'.$exportmarkets.' 
				'.$certificates.' 
				'.$search.' 
				(`studio404_users`.`company_type`=:manufacturer OR `studio404_users`.`company_type`=:serviceprovider) AND 
				`studio404_users`.`status`!=:one '.$orderBy.' '.$limit.'
				';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":manufacturer"=>'manufacturer', 
					":serviceprovider"=>'serviceprovider', 
					":user_type"=>'website', 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$retrieve_users_info = new retrieve_users_info();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["su_id"] = $val["su_id"];  
						$result[$x]["su_username"] = $val["su_username"];  
						$result[$x]["su_namelname"] = $val["su_namelname"];  
						$result[$x]["su_picture"] = $val["su_picture"];  
						$result[$x]["su_companytype"] = $val["su_companytype"];

						$result[$x]["su_sub_sector_id"] = $retrieve_users_info->retrieveDb($val["su_sub_sector_id"]);  
						$result[$x]["su_products"] = $retrieve_users_info->retrieveDb($val["su_products"]);  
						$result[$x]["su_export_markets_id"] = $retrieve_users_info->retrieveDb($val["su_export_markets_id"]);  
						$result[$x]["su_certificates"] = $retrieve_users_info->retrieveDb($val["su_certificates"]); 
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "productslist":
				$limit = ' LIMIT '.$from.', '.$load;
				$orderBy = ' ORDER BY `studio404_module_item`.`id` DESC';
				$subsectors = ($subsector && is_numeric($subsector)) ? ' FIND_IN_SET('.$subsector.',`studio404_module_item`.`sub_sector_id`) AND ' : '';
				$products = ($products && is_numeric($products)) ? ' FIND_IN_SET('.$products.',`studio404_module_item`.`products`) AND ' : '';
				$search = (!empty($search)) ? '`studio404_module_item`.`title` LIKE "%'.$search.'%" AND ' : '';
				 
				$sql = 'SELECT 
				`studio404_module_item`.`id`, 
				`studio404_module_item`.`idx`, 
				`studio404_module_item`.`title`, 
				`studio404_module_item`.`picture`, 
				`studio404_module_item`.`sub_sector_id`, 
				`studio404_module_item`.`hscode`, 
				`studio404_module_item`.`products`, 
				`studio404_module_item`.`shelf_life`, 
				`studio404_module_item`.`packaging`, 
				`studio404_module_item`.`awards`, 
				`studio404_module_item`.`long_description`, 
				`studio404_users`.`id` AS users_id,
				`studio404_users`.`namelname` AS users_name, 
				`studio404_users`.`company_type` AS su_companytype
				FROM 
				`studio404_module_item`, `studio404_users`
				WHERE 
				`studio404_module_item`.`module_idx`=3 AND 
				'.$subsectors.' 
				'.$products.' 
				'.$search.' 
				`studio404_module_item`.`visibility`=:two AND 
				`studio404_module_item`.`status`!=:one AND 
				`studio404_module_item`.`insert_admin`=`studio404_users`.`id` AND 
				`studio404_users`.`status`!=:one  
				'.$orderBy.' '.$limit.'
				';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":two"=>2, 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$retrieve_users_info = new retrieve_users_info();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					$ctext = new ctext();
					
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["title"] = $val["title"];  
						$result[$x]["picture"] = $val["picture"];  
						$result[$x]["hscode"] = $val["hscode"];
						$result[$x]["shelf_life"] = $val["shelf_life"];
						$result[$x]["packaging"] = $val["packaging"];
						$result[$x]["awards"] = $val["awards"];
						$result[$x]["long_description"] = $ctext->cut(strip_tags($val["long_description"]),120);
						$result[$x]["users_id"] = $val["users_id"];
						$result[$x]["users_name"] = $val["users_name"];
						$result[$x]["su_companytype"] = $val["su_companytype"];

						$result[$x]["sub_sector_id"] = $retrieve_users_info->retrieveDb($val["sub_sector_id"]);  
						$result[$x]["products"] = $retrieve_users_info->retrieveDb($val["products"]);  
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "servicelist":
				$limit = ' LIMIT '.$from.', '.$load;
				$orderBy = ' ORDER BY `studio404_module_item`.`id` DESC';
				$subsectors = ($subsector && is_numeric($subsector)) ? ' FIND_IN_SET('.$subsector.',`studio404_module_item`.`sub_sector_id`) AND ' : '';
				$services = ($products && is_numeric($products)) ? ' FIND_IN_SET('.$products.',`studio404_module_item`.`products`) AND ' : '';
				$search = (!empty($search)) ? '`studio404_module_item`.`long_description` LIKE "%'.$search.'%" AND ' : '';
				 
				$sql = 'SELECT 
				`studio404_module_item`.`id`, 
				`studio404_module_item`.`idx`, 
				`studio404_module_item`.`title`, 
				`studio404_module_item`.`picture`, 
				`studio404_module_item`.`sub_sector_id`, 
				`studio404_module_item`.`hscode`, 
				`studio404_module_item`.`products`, 
				`studio404_module_item`.`shelf_life`, 
				`studio404_module_item`.`packaging`, 
				`studio404_module_item`.`awards`, 
				`studio404_module_item`.`long_description`, 
				`studio404_users`.`id` AS users_id,
				`studio404_users`.`namelname` AS users_name, 
				`studio404_users`.`picture` AS users_picture, 
				`studio404_users`.`company_type` AS su_companytype
				FROM 
				`studio404_module_item`, `studio404_users`
				WHERE 
				`studio404_module_item`.`module_idx`=4 AND 
				'.$subsectors.' 
				'.$services.' 
				'.$search.' 
				`studio404_module_item`.`visibility`=:two AND 
				`studio404_module_item`.`status`!=:one AND 
				`studio404_module_item`.`insert_admin`=`studio404_users`.`id` AND 
				`studio404_users`.`status`!=:one  
				'.$orderBy.' '.$limit.'
				';
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":two"=>2, 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$retrieve_users_info = new retrieve_users_info();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					$ctext = new ctext();
					
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["title"] = $val["title"];  
						$result[$x]["picture"] = $val["users_picture"];  
						$result[$x]["hscode"] = $val["hscode"];
						$result[$x]["shelf_life"] = $val["shelf_life"];
						$result[$x]["packaging"] = $val["packaging"];
						$result[$x]["awards"] = $val["awards"];
						$result[$x]["long_description"] = $ctext->cut(strip_tags($val["long_description"]),120);
						$result[$x]["users_id"] = $val["users_id"];
						$result[$x]["users_name"] = $val["users_name"];
						$result[$x]["su_companytype"] = $val["su_companytype"];

						$result[$x]["sub_sector_id"] = $retrieve_users_info->retrieveDb($val["sub_sector_id"]);  
						$result[$x]["products"] = $retrieve_users_info->retrieveDb($val["products"]);  
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "enquirelist":
				$limit = ' LIMIT '.$from.', '.$load;
				$orderBy = ' ORDER BY `studio404_module_item`.`id` DESC';
				$sector = ($sector && is_numeric($sector)) ? ' FIND_IN_SET('.$sector.',`studio404_module_item`.`sector_id`) AND ' : '';
				$ctype = ($typex) ? '`studio404_users`.`company_type`="'.$typex.'" AND ' : '';
				$type = ($enquire_type) ? '`studio404_module_item`.`type`="'.$enquire_type.'" AND ' : '';
				$search = (!empty($search)) ? '`studio404_module_item`.`title` LIKE "%'.$search.'%" AND ' : '';
				 
				$sql = 'SELECT 
				`studio404_module_item`.`id`, 
				`studio404_module_item`.`idx`, 
				`studio404_module_item`.`date`, 
				`studio404_module_item`.`title`, 
				`studio404_module_item`.`type`, 
				`studio404_module_item`.`long_description`, 
				`studio404_users`.`id` AS users_id,
				`studio404_users`.`namelname` AS users_name, 
				`studio404_users`.`company_type` AS su_companytype, 
				(SELECT `title` FROM `studio404_pages` WHERE `studio404_pages`.`idx`=`studio404_module_item`.`sector_id` AND `lang`=:lang) AS sector_name 
				FROM 
				`studio404_module_item`, `studio404_users`
				WHERE 
				`studio404_module_item`.`module_idx`=5 AND 
				'.$sector.' 
				'.$type.'
				'.$search.' 
				`studio404_module_item`.`visibility`=:two AND 
				`studio404_module_item`.`status`!=:one AND 
				`studio404_module_item`.`insert_admin`=`studio404_users`.`id` AND 
				'.$ctype.'
				`studio404_users`.`status`!=:one  
				'.$orderBy.' '.$limit.'
				';
				// echo $sql;
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":lang"=>LANG_ID, 
					":two"=>2, 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					$ctext = new ctext();
					
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["date"] = date("d.m.Y", $val['date']); 
						$result[$x]["title"] = $val["title"];  
						$result[$x]["type"] = $val["type"];
						$result[$x]["long_description"] = nl2br($ctext->cut(strip_tags($val['long_description']),260));
						$result[$x]["users_id"] = $val["users_id"];
						$result[$x]["users_name"] = $val["users_name"];
						$result[$x]["su_companytype"] = $val["su_companytype"];
						$result[$x]["sector_name"] = $val["sector_name"];  
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "eventslist": 
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT 
				`studio404_module_item`.`slug`, 
				`studio404_module_item`.`date`, 
				`studio404_module_item`.`expiredate`, 
				`studio404_module_item`.`title`, 
				`studio404_module_item`.`event_booth`, 
				( 
					SELECT `studio404_gallery_file`.`file` FROM 
					`studio404_gallery_attachment`,`studio404_gallery`,`studio404_gallery_file` 
					WHERE 
					`studio404_gallery_attachment`.`connect_idx`=`studio404_module_item`.`idx` AND 
					`studio404_gallery_attachment`.`pagetype`=:pagetype AND 
					`studio404_gallery_attachment`.`lang`=:lang AND 
					`studio404_gallery_attachment`.`status`!=:status AND 
					`studio404_gallery_attachment`.`idx`=`studio404_gallery`.`idx` AND 
					`studio404_gallery`.`lang`=:lang AND 
					`studio404_gallery`.`status`!=:status AND 
					`studio404_gallery`.`idx`=`studio404_gallery_file`.`gallery_idx` AND 
					`studio404_gallery_file`.`media_type`=:media_type AND 
					`studio404_gallery_file`.`lang`=:lang AND 
					`studio404_gallery_file`.`status`!=:status 
					ORDER BY `studio404_gallery_file`.`position` ASC LIMIT 1 
				) AS pic 
				FROM 
				`studio404_pages`,`studio404_module_attachment`, `studio404_module`, `studio404_module_item` 
				WHERE 
				`studio404_pages`.`page_type`=:pagetype AND 
				`studio404_pages`.`lang`=:lang AND 
				`studio404_pages`.`status`!=:status AND 
				`studio404_pages`.`idx`=`studio404_module_attachment`.`connect_idx` AND 
				`studio404_module_attachment`.`page_type`=:pagetype AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`visibility`!=:visibility AND 
				`studio404_module_item`.`status`!=:status 
				ORDER BY `studio404_module_item`.`date` DESC '.$limit.' 
				';	
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":pagetype"=>'eventpage', 
					":media_type"=>'photo', 
					":lang"=>LANG_ID, 
					":status"=>1, 
					":visibility"=>1, 
				)); 
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["datetime"] = $val["expiredate"];  
						$result[$x]["date"] = date("d M Y",$val["date"]);  
						$result[$x]["slug"] = $val["slug"];  
						$result[$x]["pic"] = $val["pic"];  
						$result[$x]["event_booth"] = $val["event_booth"];  
						$result[$x]["title"] = $ctext->cut($val["title"],30);  						
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "newslist": 
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT 
				`studio404_module_item`.`date`, 
				`studio404_module_item`.`slug`, 
				`studio404_module_item`.`title` 
				FROM 
				`studio404_pages`,`studio404_module_attachment`, `studio404_module`, `studio404_module_item` 
				WHERE 
				`studio404_pages`.`page_type`=:pagetype AND 
				`studio404_pages`.`lang`=:lang AND 
				`studio404_pages`.`status`!=:status AND 
				`studio404_pages`.`idx`=`studio404_module_attachment`.`connect_idx` AND 
				`studio404_module_attachment`.`page_type`=:pagetype AND 
				`studio404_module_attachment`.`lang`=:lang AND 
				`studio404_module_attachment`.`status`!=:status AND 
				`studio404_module_attachment`.`idx`=`studio404_module`.`idx` AND 
				`studio404_module`.`lang`=:lang AND 
				`studio404_module`.`status`!=:status AND 
				`studio404_module`.`idx`=`studio404_module_item`.`module_idx` AND 
				`studio404_module_item`.`lang`=:lang AND 
				`studio404_module_item`.`visibility`!=:visibility AND 
				`studio404_module_item`.`status`!=:status 
				ORDER BY `studio404_module_item`.`date` DESC '.$limit.' 
				';	
				$prepare = $conn->prepare($sql); 
				$prepare->execute(array(
					":pagetype"=>'newspage', 
					":media_type"=>'photo', 
					":lang"=>LANG_ID, 
					":status"=>1, 
					":visibility"=>1, 
				)); 
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["date"] = "<span>".date("d",$val["date"])."</span> ".date("M",$val["date"]);  
						$result[$x]["slug"] = $val["slug"];  
						$result[$x]["title"] = $ctext->cut($val["title"],30);  						
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "profileproductlist": 
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT 
				`studio404_module_item`.`idx`,
				`studio404_module_item`.`title`,
				`studio404_module_item`.`picture`,
				`studio404_module_item`.`packaging`,
				`studio404_module_item`.`awards`,
				`studio404_module_item`.`long_description`,
				`studio404_module_item`.`productanalisis`,
				`studio404_module_item`.`visibility`, 
				`studio404_pages`.`title` AS hs_title
				FROM 
				`studio404_module_item`, `studio404_pages`
				WHERE 
				`studio404_module_item`.`insert_admin`=:insert_admin AND 
				`studio404_module_item`.`module_idx`=:module_idx AND 
				`studio404_module_item`.`status`!=:one AND 
				`studio404_module_item`.`hscode`=`studio404_pages`.`idx` AND 
				`studio404_pages`.`status`!=:one  
				ORDER BY `studio404_module_item`.`date` DESC '.$limit;
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
					":module_idx"=>3, 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["title"] = $val["title"];  						
						$result[$x]["picture"] = $val["picture"];  						
						$result[$x]["packaging"] = $val["packaging"];  						
						$result[$x]["awards"] = $val["awards"];  						
						$result[$x]["long_description"] = $val["long_description"];  						
						$result[$x]["productanalisis"] = $val["productanalisis"];  						
						$result[$x]["visibility"] = $val["visibility"];  						
						$result[$x]["hs_title"] = $val["hs_title"];  						
						$x++; 
					}

					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "profileservicelist": 
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT `id`,`idx`,`title`,`long_description`, `visibility` FROM `studio404_module_item` WHERE `module_idx`=:module_idx AND `insert_admin`=:insert_admin AND `status`!=:one ORDER BY `date` DESC '.$limit;
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":module_idx"=>4, 
					":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["title"] = $val["title"];   						
						$result[$x]["long_description"] = $val["long_description"];  						
						$result[$x]["visibility"] = $val["visibility"];  							
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "profileenquirelist": 
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT 
				`studio404_module_item`.`id`,
				`studio404_module_item`.`idx`,
				`studio404_module_item`.`date`,
				`studio404_module_item`.`title`,
				`studio404_module_item`.`sector_id`,
				`studio404_module_item`.`type`, 
				`studio404_module_item`.`long_description`,
				`studio404_module_item`.`visibility`
				FROM 
				`studio404_module_item`
				WHERE 
				`studio404_module_item`.`insert_admin`=:insert_admin AND 
				`studio404_module_item`.`module_idx`=:module_idx AND 
				`studio404_module_item`.`status`!=:one 
				ORDER BY `studio404_module_item`.`date` DESC '.$limit;
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":insert_admin"=>$_SESSION["tradewithgeorgia_user_id"], 
					":module_idx"=>5, 
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];  
						$result[$x]["date"] = date("d.m.Y",$val["date"]);  
						$result[$x]["title"] = $val["title"];   						
						$result[$x]["sector_id"] = $val["sector_id"];   						
						$result[$x]["type"] = $val["type"];   						
						$result[$x]["long_description"] = strip_tags(nl2br($val["long_description"]));  						
						$result[$x]["visibility"] = $val["visibility"];  							
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "userspageserviceprovider":
				$limit = ' LIMIT '.$from.', '.$load;
				$model_template_userstatements = new model_template_userstatements(); 
				$fetch = $model_template_userstatements->stats($c,'serviceprovider',$uid,$limit);
				if($fetch){
					$ctext = new ctext();
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];   
						$result[$x]["title"] = $val["title"];   						
						$result[$x]["long_description"] = strip_tags(nl2br($val["long_description"]));  							
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "userspagemanufacturer":
				$limit = ' LIMIT '.$from.', '.$load;
				$model_template_userstatements = new model_template_userstatements(); 
				$fetch = $model_template_userstatements->stats($c,'manufacturer',$uid,$limit);
				if($fetch){
					$ctext = new ctext();
					$result = array();
					$x = 0;
					$retrieve_users_info = new retrieve_users_info();
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];   
						$result[$x]["title"] = $val["title"];   						
						$result[$x]["picture"] = $val["picture"];   						
						$result[$x]["hscode"] = $val["hscode"];   						
						$result[$x]["shelf_life"] = $val["shelf_life"];   						
						$result[$x]["packaging"] = $val["packaging"];   						
						$result[$x]["awards"] = $val["awards"];   						
						$result[$x]["sub_sector_id"] = $retrieve_users_info->retrieveDb($val["sub_sector_id"]);   						
						$result[$x]["products"] = $retrieve_users_info->retrieveDb($val["products"]);   						
						$result[$x]["long_description"] = strip_tags(nl2br($val["long_description"]));  							
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "userspageenquires":
				$limit = ' LIMIT '.$from.', '.$load;
				$model_template_userstatements = new model_template_userstatements(); 
				$fetch = $model_template_userstatements->stats($c,'company',$uid,$limit);
				if($fetch){
					$ctext = new ctext();
					$result = array();
					$x = 0;
					$retrieve_users_info = new retrieve_users_info();
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["idx"] = $val["idx"];   
						$result[$x]["date"] = date("d.m.Y",$val["date"]);   
						$result[$x]["title"] = $val["title"];   						
						$result[$x]["type"] = $val["type"];   						
						$result[$x]["long_description"] = strip_tags(nl2br($val["long_description"]));  							
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
				case "usefulllinks":
				$limit = ' LIMIT '.$from.', '.$load;
				$sql = 'SELECT 
				`studio404_components_inside`.`id`,
				`studio404_components_inside`.`title`,
				`studio404_components_inside`.`desc`,
				`studio404_components_inside`.`image`,
				`studio404_components_inside`.`url` 
				FROM 
				`studio404_components_inside`
				WHERE 
				`studio404_components_inside`.`cid`=3 AND 
				`studio404_components_inside`.`status`!=:one 
				ORDER BY `studio404_components_inside`.`position` ASC '.$limit;
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":one"=>1
				));
				if($prepare->rowCount()>0){
					$ctext = new ctext();
					$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
					$result = array();
					$x = 0;
					foreach($fetch as $val){
						$result[$x]["id"] = $val["id"];  
						$result[$x]["title"] = $val["title"];   
						$result[$x]["titleShort"] = $ctext->cut($val["title"],110);   
						$result[$x]["desc"] = $val["desc"];   						
						$result[$x]["image"] = WEBSITE.'image?f='.WEBSITE_.$val["image"].'&amp;w=215&amp;h=80';   						
						$result[$x]["url"] = $val["url"];  						
						$x++; 
					}
					echo json_encode($result);
				}else{
					echo "Empty"; 
				}
				break;
			}
		}

		if(Input::method("POST","passwordRecover")=="true" && Input::method("POST","e") && Input::method("POST","c")){
			if($this->isValidEmail(Input::method("POST","e")) && Input::method("POST","c")===$_SESSION['protect_x']){
				try{
					$sql = 'SELECT `id` FROM `studio404_users` WHERE `username`=:username AND `status`!=1';
					$prepare = $conn->prepare($sql); 
					$prepare->execute(array(
						":username"=>Input::method("POST","e")
					));
					if($prepare->rowCount()>0){
						$recover = ustring::random(15);
						$ufetch = $prepare->fetch(PDO::FETCH_ASSOC);
						$setRecover = 'UPDATE `studio404_users` SET `recover`=:recover WHERE `id`=:id';
						$setPrepare = $conn->prepare($setRecover); 
						$setPrepare->execute(array(
							":id"=>$ufetch['id'], 
							":recover"=>$recover
						));

						$msg = '<div style="margin:0; padding:0; width:100%;"><img src="'.TEMPLATE.'img/mailheader.png" width="100%" alt="Mail header"/></div>';
						$msg .= '<p style="font-size:14px; font-family:roboto">Password recover link: <a href="'.WEBSITE.LANG.'/recover?rl='.$recover.'&ui='.$ufetch['id'].'" style="color:red">Click here</a></p>';
						$sql = 'SELECT `host`,`user`,`pass`,`from`,`fromname` FROM `studio404_newsletter` WHERE `id`=1';
						$prepare = $conn->prepare($sql); 
						$prepare->execute(); 
						$fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
						
						$host = $fetch["host"]; 
						$user = $fetch["user"]; 
						$pass = $fetch["pass"]; 
						$from = $fetch["from"]; 
						$fromname = $fetch["fromname"]; 

						$send_email = new send_email(); 
						$send_email->send($host,$user,$pass,$from,$fromname,Input::method("POST","e"),"::Recover password::",$msg); 
						echo "Please check your email address !";
					}else{
						echo "Error";
					}
				}catch(Exception $e){
					echo "Error";
				}				
			}else{
				echo "Error";
			}
		}
		
		if(Input::method("POST","loadCountriesExport")=="true"){
			$val = strip_tags(Input::method("POST","v"));
			$userId = $_SESSION["tradewithgeorgia_user_id"];
			$selectMarket = 'SELECT `export_markets_id` FROM `studio404_users` WHERE `id`="'.(int)$userId.'"';
			$prepare = $conn->prepare($selectMarket); 
			$prepare->execute();
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				if($fetch["export_markets_id"]!=""){
					$selectxx = 'SELECT `idx`,`title`,(SELECT `id` FROM `studio404_users` LIMIT 1) AS xx FROM `studio404_pages` WHERE `cid`="561" AND `idx` IN('.$fetch["export_markets_id"].') AND `status`!=1 ORDER BY `title` ASC';
					$preparexx = $conn->prepare($selectxx);
					$preparexx->execute();
					$fetchxx = $preparexx->fetchAll(PDO::FETCH_ASSOC);
					if(!empty(Input::method("POST","v"))){
						$v = '`title` LIKE "'.$val.'%" AND ';
					}else{ $v = ''; }
				}else{
					$fetchxx = array();
					if(!empty(Input::method("POST","v"))){
						$v = '`title` LIKE "'.$val.'%" AND ';
					}else{ $v = ''; }
					$fetch["export_markets_id"] = 5555;
				}

				$select = 'SELECT `idx`,`title`,(SELECT `id` FROM `studio404_users` WHERE `id`=0 LIMIT 1) AS xx FROM `studio404_pages` WHERE '.$v.' `cid`="561" AND `idx` NOT IN('.$fetch["export_markets_id"].') AND `status`!=1 ORDER BY `title` ASC';
				$preparexxx = $conn->prepare($select);
				$preparexxx->execute();
				$fetchxxx = $preparexxx->fetchAll(PDO::FETCH_ASSOC);

				$result = array_merge($fetchxxx, $fetchxx); 			
				
				echo json_encode($result);
			}
		}

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