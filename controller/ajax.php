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

				$sql = 'INSERT INTO `studio404_messages` SET `date`=:date, `ip`=:ip, `fromuser`=:fromuser, `tousers`=:tousers, `subject`=:subject, `text`=:textx, `attchment`=:attchment, `draft`=:draft';
				$prepare = $conn->prepare($sql);
				$prepare->execute(array(
					":date"=>time(), 
					":ip"=>get_ip::ip(), 
					":fromuser"=>$_SESSION["batumi_id"], 
					":tousers"=>implode(",",$u), 
					":subject"=>Input::method("POST","s"), 
					":textx"=>Input::method("POST","m"), 
					":draft"=>$draft, 
					":attchment"=>$attach
				));

				$files = glob(DIR.'_cache/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
					@unlink($file); // delete file
				}

				echo $conn->lastInsertId();
			}else{
				echo "Error";
			}
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
			
			if(is_array($checkboxdata_value)){
				foreach($checkboxdata_value as $key => $value){
					$columns_and_data .= '`'.$key.'`="'.implode(",",$checkboxdata_value[$key]).'", ';
				}
			}

			$update = 'UPDATE `studio404_module_item` SET '.$columns_and_data.' `cataloglist`="'.implode(",",$macat).'" WHERE `idx`=:idx AND `lang`=:lang';
			$prepare = $conn->prepare($update); 
			$prepare->execute(array(
				":lang"=>Input::method("POST","edit_language"), 
				":idx"=>$editidx 
			));

			$files = glob(DIR.'_cache/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
				@unlink($file); // delete file
			}
				
			$insert_notification = new insert_notification();
			$insert_notification->insert($c,$_SESSION["batumi_id"],"მონაცემის განახლება ::".$editidx,"Edit Data ::".$editidx);

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

		if(Input::method("POST","reloadImage")=="true"){
			$_SESSION['protect_x'] = ustring::random(4);
			echo "Done";
		}

		if(Input::method("POST","removemessage")=="true" && is_numeric(Input::method("POST","rmi"))){
			$id = Input::method("POST","rmi");
			$delete_admin = $_SESSION["batumi_id"];
			$sql = 'SELECT `draft` FROM `studio404_messages` WHERE `id`=:id';
			$prepare = $conn->prepare($sql); 
			$prepare->execute(array(
				":id"=>$id
			));
			if($prepare->rowCount() > 0){
				$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$old_draft = $fetch["draft"]; 
				$new_draft = $old_draft.",".$delete_admin;
				$sql2 = 'UPDATE `studio404_messages` SET `draft`=:draft WHERE `id`=:id';
				$prepare2 = $conn->prepare($sql2); 
				$prepare2->execute(array(
					":draft"=>$new_draft, 
					":id"=>$id 
				));
				echo "Done";
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