<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
<!-- START image POPUP -->
<div class="modal fade" id="bs-example-xx" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-header" style="display:none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val38"]?></h4>
        </div>

        <div class="modal-body insertimage_popup">
         <?=$data["language_data"]["val91"]?>
        </div>

        <div class="modal-footer" style="display:none">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary deleteDocumentx"><?=$data["language_data"]["val73"]?></button>
        </div> 
    </div>
  </div>
</div>
<!-- END image POPUP -->



	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val84"]?></h3>
            </div>
           <div class="box-body">
                <div class="row">
                	<div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                    <div class="col-md-9 catalog-add-form-data">
                    	<?php
                    	$labellists = new labellists();
						$data["labellists"] = $labellists->loadlabels($c);
						?>
                   <form action=""  method="post" enctype="multipart/form-data" name="monacemisdamatebaform" id="monacemisdamatebaform">
					<?php
					if($data["fetch"]["visibility"]==1) :
					?>
                   	<div class="alert alert-danger alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-ban"></i> <?=$data["language_data"]["val94"]?></h4>
		                <?=$data["language_data"]["val121"]?>
		            </div>
		        	<?php endif; ?>

					<?php 
					$sga_idx = $labellists->loadpictures_gallery_idx($c); 
					?>
	               <input type="hidden" name="galleryidxpost" value="<?=$sga_idx?>" /> 
					<?php if($data["parent_title"]!="" && Input::method("GET","idx")) : ?>
						<div class="form-group">
						<label><?=$data["language_data"]["val32"]?>: <font color="red">*</font></label>
						<input class="form-control" type="text" placeholder="" value="<?=$data["parent_title"]?>" disabled="disabled" />
						</div>
					<?php endif; ?>

					<div class="form-group">
                    <label><?=$data["language_data"]["val75"]?> <font color="red">*</font></label>
                    <select class="form-control select2" id="mainpagecategory" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                      <?php
                      $x = 0;
                      $subcategory = new subcategory();
                      foreach ($data["welcomepage_categories"]["item"]["idx"] as $value) {
                      	$countsub = $subcategory->counts($c,$data["welcomepage_categories"]["item"]["idx"][$x]);
						$parent = explode(",", Input::method("GET","parent"));
                      	if($countsub>0){
                      		?>
		                  <optgroup label="<?=$data["welcomepage_categories"]["item"]["title"][$x]?>">
		                    <?php
		                    $fetch2 = $subcategory->select($c,$data["welcomepage_categories"]["item"]["idx"][$x]);
		                    foreach ($fetch2 as $value2) {
		                      if(in_array($value2['idx'],$parent)){
		                        echo '<option value="'.$value2['idx'].'" selected="selected">'.$value2['title'].'</option>';
		                      }else{
		                        echo '<option value="'.$value2['idx'].'">'.$value2['title'].'</option>';
		                      }
		                    }
		                    ?>
		                  </optgroup>
		                  <?php
                      	}else{
	                      	if(in_array($data["welcomepage_categories"]["item"]["idx"][$x],$parent)){
	                      		echo '<option value="'.$data["welcomepage_categories"]["item"]['idx'][$x].'" selected="selected">'.$data["welcomepage_categories"]["item"]['title'][$x].'</option>';
	                      	}else{
	                      		echo '<option value="'.$data["welcomepage_categories"]["item"]['idx'][$x].'">'.$data["welcomepage_categories"]["item"]['title'][$x].'</option>';
	                      	}
                      	}
                      	$x++;
                      }
                      ?>
                    </select>
                  </div>
						<?php
						$select_form = new select_form();
						$file_count = 0;
						$datetime_count = 0;
						foreach($data["form"] as $form){
							$attach_column = explode(" ",$form["attach_column"]);
							$value_input = $data["fetch"][$attach_column[0]];
							if($form["type"]=="text"){
								if($form["important"]=="yes"){ $dataimportant = "data-important='true'"; }
								else{ $dataimportant = "data-important='false'"; }								
							?>
	                          <div class="form-group">
	                            <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                            <input class="form-control form-input" type="text" placeholder="<?=$form["placeholder"]?>" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="text" data-important="<?=$form["important"]?>" value="<?=$value_input?>" />
	                          </div>
                        	<?php
                        	}else if($form["type"]=="select"){
							?>
                        		<div class="form-group">
	                            <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                           	<select class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="select">
				                    <?php
				                    $fetchx = $select_form->select_options($c,$form["id"]);
				                    foreach ($fetchx as $value){
				                    	$selected = ($value_input==$value["text"]) ? 'selected="selected"' : '';
				                    	echo '<option value="'.htmlentities($value["text"]).'" '.$selected.'>'.$value["text"].'</option>';
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
				                    $fetchx = $select_form->select_options($c,$form["id"]);
				                    $ex = explode(",",$value_input);
				                    foreach ($fetchx as $value) {
				                    	$selected = (in_array($value["text"], $ex)) ? 'checked="checked"' : '';
				                    	echo '<div class="checkbox">';
										echo '<label><input type="checkbox" class="form-input" data-name="'.$form["name"].'" data-attach="'.$form["attach_column"].'" data-important="'.$form["important"].'" data-type="checkbox" value="'.htmlentities($value["text"]).'" '.$selected.' />'.$value["text"].'</label>';
										echo '</div>';
				                    }
				                    ?>	                        		
	                        	</div>
                        		<?php
                        	}else if($form["type"]=="file"){
                        		$multiple = ($form["attach_multiple"]=="yes") ? "multiple" : "";
                        		?>
                        		<div class="form-group">
	                            	<?php
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
	                        	</div>
	                        	<?php
	                        	$files = $labellists->loadpictures($c,$form["name"],Input::method("GET","idx")); 
	                        	
		                    	$attach_format = explode(",",$form['attach_format']);
	                        	?>
	                        	
	                        	<div class="post">
					                <ul class="mailbox-attachments clearfix">
					                	<?php
					                	foreach ($files as $file) {
					                	$file_url = WEBSITE."files/document/".$file["sgf_file"];
					                	$file_url_dir = DIR."files/document/".$file["sgf_file"];
					                	$file_idx = $file["sgf_idx"];
					                	$filesize = filesize($file_url_dir);

					                	if(in_array("pdf", $attach_format)){
					                	?>
										<li>
											<input type="hidden" name="form-galleryidx-<?=$file_count?>" value="<?=$file["sgf_gallery_idx"]?>" />
											<span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

											<div class="mailbox-attachment-info">
												<a href="<?=$file_url?>" target="_blank" class="mailbox-attachment-name"><i class="fa fa-file-pdf-o"></i> Document PDF</a>
												<span class="mailbox-attachment-size">
												<?php echo filesizeconvert::byt($filesize); ?>
												<a href="javascript:void(0)" class="btn btn-default btn-xs pull-right delete-document" data-imageidx="<?=$file_idx?>"><i class="fa fa-times-circle"></i></a>
												<a href="<?=$file_url?>" target="_blank" class="btn btn-default btn-xs pull-right" style="margin-right:5px"><i class="fa fa-cloud-download"></i></a>
												</span>
											</div>
										</li>
										<?php
										}else if(in_array("png", $attach_format) || in_array("jpg", $attach_format) || in_array("gif", $attach_format) || in_array("jpeg", $attach_format)){
											?>
											<li>
												<span class="mailbox-attachment-icon has-img"><img src="<?=$file_url?>" alt="Attachment"></span>

												<div class="mailbox-attachment-info">
													<a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> Photo</a>
													<span class="mailbox-attachment-size">
													<?php echo filesizeconvert::byt($filesize); ?>
													<a href="javascript:void(0)" class="btn btn-default btn-xs pull-right delete-document" data-imageidx="<?=$file_idx?>"><i class="fa fa-times-circle"></i></a>
													<a href="javascript:void(0)" data-imagesrc="<?=$file_url?>" class="btn btn-default btn-xs pull-right loadimagesrc" style="margin-right:5px"><i class="fa fa-eye"></i></a>
													</span>
												</div>
											</li>
											<?php
										}else{
										?>
											<li>
												<span class="mailbox-attachment-icon"><i class="fa fa-file"></i></span>

												<div class="mailbox-attachment-info">
													<a href="<?=$file_url?>" target="_blank" class="mailbox-attachment-name"><i class="fa fa-file"></i> Document</a>
													<span class="mailbox-attachment-size">
													<?php echo filesizeconvert::byt($filesize); ?>
													<a href="javascript:void(0)" class="btn btn-default btn-xs pull-right delete-document" data-imageidx="<?=$file_idx?>"><i class="fa fa-times-circle"></i></a>
													<a href="<?=$file_url?>" target="_blank" class="btn btn-default btn-xs pull-right" style="margin-right:5px"><i class="fa fa-cloud-download"></i></a>
													
													</span>
												</div>
											</li>
										<?php
										}
										}
										?>
										
									</ul>
					            </div>
                        		<?php
                        		$file_count++;
                        	}else if($form["type"]=="date"){
                        		?>
                        		<div class="form-group">
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		<input type="text" class="form-control form-input" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="date" value="<?=date("d/m/Y",$value_input)?>" />
	                        	</div>
                        		<?php
                        	}else if($form["type"]=="dateandtimerange"){
                        		?>
                        		<div class="form-group">
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		
	                        		<div class="input-group">
										<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
										<input type="hidden" name="hidden<?=$datetime_count?>" id="hidden<?=$datetime_count?>" value="<?=$value_input?>" />
										<input type="text" class="form-control form-input pull-right reservationtime" data-hiddenname="hidden<?=$datetime_count?>" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="dateandtimerange" value="<?=$value_input?>" />
									</div>
	                        	</div>
                        		<?php
                        		$datetime_count++;
                        	}else if($form["type"]=="textarea"){
                        		?>
                        		<div class="form-group">
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		<textarea class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="textarea" data-important="<?=$form["important"]?>"><?=$value_input?></textarea>
	                        	</div>
                        		<?php
                        	}

                      	}
                    	
						if($_SESSION["batumi_user_type"]=="website_manager"):
						?>     
							<div class="form-group">
								<label style="width:100%"><?=$data["language_data"]["val87"]?></label>
								<?php
								if($data["fetch"]["visibility"]==1){
									echo '<span class="label label-success give-permision" style="cursor:pointer" data-dlang="'.LANG.'">'.$data["language_data"]["val88"].'</span>'; 
								}else{
									echo '<span class="label label-danger remove-permision" style="cursor:pointer" data-dlang="'.LANG.'">'.$data["language_data"]["val89"].'</span>';
								}
								?>
							</div> 
						<?php
						endif;
						?>
                    </form>
                    </div>
                    <?php
                	$grabusersdata = new grabusersdata(); 
                	$user = $grabusersdata->usersdata($c, $data["fetch"]["insert_admin"]);
                	$e = explode(",", $data["fetch"]["edit_admin"]); 
                	$e = array_filter($e);
                	$user_edited = $grabusersdata->usersdata($c, $e);
                	$picture = ($user["picture"]!="") ? WEBSITE."files/usersimage/".$user["picture"] : TEMPLATE.'dist/img/avatar04.png'; 
                	?>
                    <div class="col-md-3">
                    	
                    	<div class="col-md-12">
							<div class="box box-danger">
								<div class="box-header with-border">
									<h3 class="box-title"><?=$data["language_data"]["val122"]?></h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<ul class="users-list clearfix">
										<li style="width:100%;">
											<img src="<?=$picture?>" alt="User Image">
											<a class="users-list-name" href="#"><?=($user["namelname"]) ? $user["namelname"] : "Unknown: IP-".$data["fetch"]["insert_ip"]?></a>
										</li>		                    
									</ul>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="box box-danger">
								<div class="box-header with-border">
									<h3 class="box-title"><?=$data["language_data"]["val123"]?></h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<?php
									// echo "<pre>";
									// print_r($user_edited); 
									// echo "</pre>";
									?>
									<ul class="users-list clearfix">
										<?php
										foreach ($user_edited as $value) : 
											$picture = ($value["picture"]!="") ? WEBSITE."files/usersimage/".$value["picture"] : TEMPLATE.'dist/img/avatar04.png'; 
										?>
										<li style="width:50%;">
											<img src="<?=$picture?>" alt="User Image">
											<a class="users-list-name" href="#"><?=$value["namelname"]?></a>
										</li>	
										<?php endforeach; ?>	                    
									</ul>
								</div>
							</div>
						</div>


						<div class="col-md-12">
							<div class="box box-danger">
								<div class="box-header with-border">
									<h3 class="box-title"><?=$data["language_data"]["val124"]?></h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
									<?php
									if($data["fetch"]["updatedate"]=="0"){
										echo "<p style='padding:10px;'>".date( "d/m/Y H:i:s", $data["fetch"]["date"])."</p>";
									}else{
										echo "<p style='padding:10px;'>".date( "d/m/Y H:i:s", $data["fetch"]["updatedate"])."</p>";
									}
									?>
								</div>
							</div>
						</div>

            		</div>
                	
                </div>
	          </div>
	          <div class="box-footer">
			   	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="edit-catalogue-item">
			   	  	<?=$data["language_data"]["val74"]?></button>
			   	  <button class="btn btn-primary" type="submit" data-back="<?=WEBSITE.LANG?>/<?=Input::method("GET","backslug")?>?parentidx=<?=Input::method("GET","backparent")?>&amp;idx=<?=Input::method("GET","parent")?>" data-dlang="<?=LANG?>" id="edit-catalogue-item-close">
			   	  	<?=$data["language_data"]["val36"]?></button>
			   	  <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/<?=Input::method("GET","backslug")?>?parentidx=<?=Input::method("GET","backparent")?>&amp;idx=<?=Input::method("GET","parent")?>" type="submit"><?=$data["language_data"]["val33"]?></button>
			  </div>
	      </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>