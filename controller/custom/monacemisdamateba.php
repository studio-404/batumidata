<?php if(!defined("DIR")){ exit(); }
class monacemisdamateba extends connection{
	function __construct($c){
		$this->template($c,"monacemisdamateba");
	}
	
	public function template($c,$page){
		$conn = $this->conn($c); // connection

		$cache = new cache();
		$welcomepage_categories = $cache->index($c,"welcomepage_categories");
		$data["welcomepage_categories"] = json_decode($welcomepage_categories,true);

		/* language variables */
		$language_data = $cache->index($c,"language_data");
		$language_data = json_decode($language_data);
		$model_template_makevars = new  model_template_makevars();
		$data["language_data"] = $model_template_makevars->vars($language_data); 

		$sql = 'SELECT `namelname`,`picture` FROM `studio404_users` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$_SESSION["batumi_id"]
		));

		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$data["userdata"] = $fetch;
		}else{
			redirect::url(WEBSITE);
		}

		$form = $cache->index($c,"form");
		$data["form"] = json_decode($form,true);

		if(Input::method("POST","file")){
			// $sql = 'SELECT 
			// `studio404_gallery_attachment`.`idx` as sga_idx 
			// FROM 
			// `studio404_module_item`,`studio404_gallery_attachment` 
			// WHERE 
			// `studio404_module_item`.`cataloglist`=:cataloglist AND 
			// `studio404_module_item`.`lang`=:lang AND 
			// `studio404_module_item`.`status`!=:one AND 
			// `studio404_module_item`.`idx`=`studio404_gallery_attachment`.`connect_idx` AND 
			// `studio404_gallery_attachment`.`lang`=:lang AND  
			// `studio404_gallery_attachment`.`status`!=:one 
			// ORDER BY `studio404_module_item`.`idx` DESC LIMIT 1
			// ';
			// $prepare = $conn->prepare($sql);
			// $prepare->execute(array(
			// 	":cataloglist"=>Input::method("GET","parent"), 
			// 	":lang"=>LANG_ID, 
			// 	":one"=>1
			// ));
			// $fetch = $prepare->fetch(PDO::FETCH_ASSOC); 
			$model_admin_selectLanguage = new model_admin_selectLanguage();
			$lang_query = $model_admin_selectLanguage->select_languages($c);
			for($input_file_count = 0; $input_file_count<count($_FILES["file"]["name"]); $input_file_count++){
				foreach ($_FILES["file"]["name"][$input_file_count] as $key => $value) {
					if($value!=""){
						$gallery_idx = Input::method("POST","gallery_idx_post"); 
						$insert_admin = $_SESSION["batumi_id"]; 
						
						$filenumber = $_POST['filenumber'];
						$filenumber = $filenumber[$input_file_count];
						$inputname = Input::method("POST","form-name-".$filenumber);
						$attach = Input::method("POST","form-attach-".$filenumber);
						$important = Input::method("POST","form-important-".$filenumber);
						$multiple = Input::method("POST","form-multiple-".$filenumber);
						$format = explode(",",Input::method("POST","form-format-".$filenumber));
						
						//$format = end($format);
						$filename = $_FILES["file"]["name"][$input_file_count][$key];

						$filesize = $_FILES["file"]["size"][$input_file_count][$key];
						$filetype_arr = explode(".",$filename);
						$filetype = end($filetype_arr);
						
						if(in_array($filetype, $format)){
							
							$sqlm = 'SELECT MAX(`idx`)+1 AS maxid FROM `studio404_gallery_file`';
							$querym = $conn->query($sqlm);
							$rowm = $querym->fetch(PDO::FETCH_ASSOC);
							$max_idx = ($rowm['maxid']) ? $rowm['maxid'] : 1;

							$sql_max_posm = 'SELECT MAX(`position`)+1 AS maxpos FROM `studio404_gallery_file` WHERE `status`!=:status';
							$preparem = $conn->prepare($sql_max_posm);
							$preparem->execute(array( 
								":status"=>1 
							));
							$row2m = $preparem->fetch(PDO::FETCH_ASSOC);
							$max_pos = ($row2m['maxpos']) ? $row2m['maxpos'] : 1;	

							$filename_new = $filetype_arr[0].md5(sha1(time())).".".$filetype;
							$target_file = DIR."files/document/".$filename_new;
							
							if (move_uploaded_file($_FILES["file"]["tmp_name"][$input_file_count][$key], $target_file)) {
								
								foreach($lang_query as $lang_row){
									$insert_into_gallery = 'INSERT INTO `studio404_gallery_file` SET 
									`idx`=:idx, 
									`date`=:date, 
									`gallery_idx`=:gallery_idx, 
									`file`=:file, 
									`fileinputname`=:fileinputname, 
									`media_type`=:media_type, 
									`title`=:title, 
									`description`=:description, 
									`filesize`=:filesize, 
									`insert_admin`=:insert_admin, 
									`position`=:position, 
									`lang`=:lang';
									$prepare_insert = $conn->prepare($insert_into_gallery);
									$prepare_insert->execute(array(
										":idx"=>$max_idx, 
										":date"=>time(), 
										":gallery_idx"=>$gallery_idx, 
										":file"=>$filename_new, 
										":fileinputname"=>$inputname, 
										":media_type"=>$filetype, 
										":title"=>"Not Defined", 
										":description"=>"Not Defined", 
										":filesize"=>$filesize, 
										":insert_admin"=>$insert_admin, 
										":position"=>$max_pos, 
										":lang"=>$lang_row["id"] 
									));
								}
							}
						}
					}
				}
			}


		}

		$include = WEB_DIR."/monacemisdamateba.php";
		if(file_exists($include)){
			@include($include);
		}else{
			$controller = new error_page(); 
		}
	}
}
?>