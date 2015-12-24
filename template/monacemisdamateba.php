<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- <section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section> -->

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val26"]?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                	<div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                    <div class="col-md-12">

					<?php if($data["parent_title"]!="" && Input::method("GET","parent")) : ?>
						<div class="form-group">
						<label><?=$data["language_data"]["val32"]?>: <font color="red">*</font></label>
						<input class="form-control" type="text" placeholder="" value="<?=$data["parent_title"]?>" disabled="disabled" />
						</div>
					<?php endif; ?>
						<?php
						$select_form = new select_form();
						foreach($data["form"] as $form){
							if($form["type"]=="text"){
								if($form["important"]=="y"){ $dataimportant = "data-important='true'"; }
								else{ $dataimportant = "data-important='false'"; }
							?>
	                          <div class="form-group">
	                            <label><?=$form["label"]?>: <?=($form["important"]=="y") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                            <input class="form-control form-input" type="text" placeholder="<?=$form["placeholder"]?>" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="text" value="" />
	                          </div>
                        	<?php
                        	}else if($form["type"]=="select"){
                        		?>
                        		<div class="form-group">
	                            <label><?=$form["label"]?>: <?=($form["important"]=="y") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                           	<select class="form-control form-input" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="select">
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
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="y") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		<?php
				                    $fetchx = $select_form->select_options($c,$form["id"]);
				                    foreach ($fetchx as $value) {
				                    	echo '<div class="checkbox">';
										echo '<label><input type="checkbox" class="form-input" data-name="'.$form["name"].'" data-attach="'.$form["attach_column"].'" data-type="checkbox" value="'.htmlentities($value["text"]).'" />'.$value["text"].'</label>';
										echo '</div>';
				                    }
				                    ?>
	                        		
	                        	</div>
                        		<?php
                        	}else if($form["type"]=="file"){
                        		?>
                        		<div class="form-group">
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="y") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		<input class="form-control form-input" type="file" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="file" value="" multiple />
	                        	</div>
                        		<?php
                        	}else if($form["type"]=="date"){
                        		?>
                        		<div class="form-group">
	                            	<label><?=$form["label"]?>: <?=($form["important"]=="y") ? '<font color="red">*</font>' : ''?></label> <!-- Fisrname & lastname -->
	                        		<input type="text" class="form-control form-input" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-name="<?=$form["name"]?>" data-attach="<?=$form["attach_column"]?>" data-type="date" />
	                        	</div>
                        		<?php
                        	}

                      	}
                        ?>
                    </div>
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