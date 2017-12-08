<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val26"]?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                	<div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                    <div class="col-md-12 catalog-add-form-data">
                 

                   <form action=""  method="post" enctype="multipart/form-data" name="monacemisdamatebaform" id="monacemisdamatebaform">
					<?php if($data["parent_title"]!="" && Input::method("GET","parent")) : ?>
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
                      	if($countsub>0){
                      		echo '<optgroup label="'.$data["welcomepage_categories"]["item"]['title'][$x].'">';
                      		$fetch2 = $subcategory->select($c,$data["welcomepage_categories"]["item"]["idx"][$x]);
                      		foreach ($fetch2 as $value2) {
                      			if($value2['idx']==Input::method("GET","parent")){
	                      		echo '<option value="'.$value2['idx'].'" selected="selected">'.$value2['title'].'</option>';
		                      	}else{
		                      		echo '<option value="'.$value2['idx'].'">'.$value2['title'].'</option>';
		                      	}
                      		}
                      		echo '</optgroup>';
                      	}else{
	                      	if($data["welcomepage_categories"]["item"]["idx"][$x]==Input::method("GET","parent")){
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
						foreach($data["form"] as $form){
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
                        		?>
                        		<div class="form-group">
	                            <label><?=$form["label"]?>: <?=($form["important"]=="yes") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                           	<select class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-important="<?=$form["important"]?>" data-type="select">
				                    <?php
				                    $fetchx = $select_form->select_options($c,$form["id"]);
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
				                    $fetchx = $select_form->select_options($c,$form["id"]);
				                    foreach ($fetchx as $value) {
				                    	echo '<div class="checkbox">';
										echo '<label><input type="checkbox" class="form-input" data-name="'.$form["name"].'" data-attach="'.$form["attach_column"].'" data-important="'.$form["important"].'" data-type="checkbox" value="'.htmlentities($value["text"]).'" />'.$value["text"].'</label>';
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
                        		$file_count++;
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

                      	}
                        ?>
                    </div>
                	</form>
                </div>
	          </div>
	          <div class="box-footer">
			   	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="add-catalogue-item">
			   	  	<?=$data["language_data"]["val27"]?></button>
			   	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="add-catalogue-item-close">
			   	  	<?=$data["language_data"]["val28"]?></button>
			   	  <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/sastumroebi?idx=<?=Input::method("GET","parent")?>" type="submit"><?=$data["language_data"]["val33"]?></button>
			  </div>
	      </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>