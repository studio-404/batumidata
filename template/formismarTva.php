<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
  <!-- START REGISTER POPUP -->
<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val64"]?></h4>
        </div>
        <div class="modal-body">
          <div class="selectoptionspopup">
          	<input type="text" class="form-control selectoptionspopup-item" value="option" />
          </div>
          <a href="javascript:void(0)" class="selectoptionspopup-item-add" style="margin-top:5px;"><?=$data["language_data"]["val27"]?></a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary insert-options"><?=$data["language_data"]["val65"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->

<!-- START REGISTER POPUP -->
<div class="modal fade bs-example-modal-sm3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val66"]?></h4>
        </div>
        <div class="modal-body">
          <div class="selectoptionspopup3">
          	<input type="text" class="form-control selectoptionspopup3-item" value="Text" />
          </div>
          <a href="javascript:void(0)" class="selectoptionspopup3-item-add" style="margin-top:5px;"><?=$data["language_data"]["val27"]?></a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary insert-checkbox-options"><?=$data["language_data"]["val65"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->

<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?> 
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-9">
					<?php
					// echo "<pre>";
					// print_r($data["select_form"]);
					// echo "</pre>";
					?>
					<div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title"><?=$data["parent_title"]?></h3>

			              <div class="box-tools pull-right">
			                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form role="form">
			              <div class="box-body">
			              	<div class="interface">
			              		<?php
			              		if(count($data["select_form"]["id"])):
			              			$x=0;
			              			foreach($data["select_form"]["id"] as $v): 
			              				$data["select_form"]["important"][$x] = ($data["select_form"]["important"][$x]=="y") ? "yes" : "no";
			              				$data["select_form"]["list"][$x] = ($data["select_form"]["list"][$x]=="y") ? "yes" : "no";
			              				$data["select_form"]["filter"][$x] = ($data["select_form"]["filter"][$x]=="y") ? "yes" : "no";
			              				if($data["select_form"]["type"][$x]=="text"){
			              			?>
						              		<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-elemvalue="<?=$data["select_form"]["placeholder"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
						              			<label><?=$data["select_form"]["label"][$x]?></label>
						              			<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
						              			<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right;" onclick="editTextElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
						              			<input type="text" class="form-control" name="elemname" value="<?=$data["select_form"]["placeholder"][$x]?>">
						              		</div>
			              			<?php
			              				}else if($data["select_form"]["type"][$x]=="date"){
			              					?>
			              					<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
			              						<label><?=$data["select_form"]["label"][$x]?></label>
			              						<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
			              						<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right; margin-left:5px;" onclick="editInputDateElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
			              						<div class="input-group">
			              							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			              								<input type="text" class="form-control" value="dd/mm/YYYY" disabled="disabled">
			              							</div>
			              						</div>
			              					<?php
			              				}else if($data["select_form"]["type"][$x]=="textarea"){
			              					?>
			              						<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
			              							<label><?=$data["select_form"]["label"][$x]?></label>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right;" onclick="editTextareaElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
			              							<textarea class="form-control" rows="3" name="elemname"></textarea>
			              						</div>
			              					<?php
			              				}else if($data["select_form"]["type"][$x]=="select"){
			              					?>
			              						<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
			              							<label><?=$data["select_form"]["label"][$x]?></label>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right; margin-left:5px" onclick="editSelectElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right;" class="edit-select-options"><i class="glyphicon glyphicon-th-list"></i></a>
			              							<select class="form-control" name="elemname">
			              								<?php
			              								foreach ($data["select_form"]["sub"][$x] as $valop) {
			              									echo '<option value="'.htmlentities($valop["text"]).'">'.$valop["text"].'</option>';
			              								}
			              								?>
			              							</select>
			              						</div>
			              					<?php
			              				}else if($data["select_form"]["type"][$x]=="checkbox"){
			              					?>
			              						<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
			              							<label><?=$data["select_form"]["label"][$x]?></label>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right; margin-left:5px" onclick="editCheckboxElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
			              							<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right;" class="edit-checkbox-options"><i class="glyphicon glyphicon-th-list"></i></a>
			              							
			              							<div class="checkbox">			              							
			              								<?php
			              								foreach ($data["select_form"]["sub"][$x] as $valop) {
			              									echo '<div class="checkbox-inside">'; 
			              									echo '<input type="checkbox" value="'.htmlentities($valop["text"]).'"> <span>'.$valop["text"].'</span>';
			              									echo '</div>';
			              								}
			              								?>
			              							</div>			              							
			              						</div>
			              					<?php
			              				}else if($data["select_form"]["type"][$x]=="file"){
			              					?>
			              					<div class="form-group element-box" id="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" data-elemtype="<?=$data["select_form"]["type"][$x]?>" data-elemlabel="<?=$data["select_form"]["label"][$x]?>" data-elemname="<?=$data["select_form"]["name"][$x]?>" data-database="<?=$data["select_form"]["attach_column"][$x]?>" data-important="<?=$data["select_form"]["important"][$x]?>" data-list="<?=$data["select_form"]["list"][$x]?>" data-filter="<?=$data["select_form"]["filter"][$x]?>">
			              						<label><?=$data["select_form"]["label"][$x]?></label>
			              						<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" data-dlang="<?=$data["select_form"]["lang"][$x]?>" style="float:right; margin-left:5px;" class="remove-element"><i class="glyphicon glyphicon-remove"></i></a>
			              						<a href="javascript:void(0)" data-uniqueclass="elementinserted<?=$x?>" style="float:right; margin-left:5px;" onclick="editInputDateElement(this)"><i class="glyphicon glyphicon-edit"></i></a>
			              						<!-- <div class="input-group">
			              							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			              								<input type="text" class="form-control" value="dd/mm/YYYY" disabled="disabled">
			              						</div> -->
			              						<div class="files"><div class="file-inside"><input type="file" value=""> </div></div>
			              					</div>
			              					<?php
			              				}
			              			$x++;
			              			endforeach;
			              		endif;
			              		?>

			              	</div>			                
			              </div>
			              <!-- /.box-body -->

			              <div class="box-footer">
						   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="save-form">
						   	  	<?=$data["language_data"]["val61"]?></button>
						   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="save-form-close">
						   	  	<?=$data["language_data"]["val62"]?></button>
						   	  <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/katalogis-marTva" type="button"><?=$data["language_data"]["val33"]?></button>
						  </div>
			            </form>
			        </div>
				</div>
				<div class="col-md-3">
					<div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title"><?=$data["language_data"]["val59"]?></h3>
			              <div class="box-tools pull-right">
			                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <div class="box-body no-padding">
			              <ul class="nav nav-pills nav-stacked">
			                <li><a href="javascript:void(0)" class="inputdateelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Date</a></li>
			                <li><a href="javascript:void(0)" class="inputtextelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Text</a></li>
			                <li><a href="javascript:void(0)" class="inputtextareaelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> TextArea</a></li>
			                <li><a href="javascript:void(0)" class="selectelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Select</a></li>
			                <li><a href="javascript:void(0)" class="checkboxelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Checkbox</a></li>
			                <li><a href="javascript:void(0)" class="inputfileelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Files</a></li>
			              </ul>
			            </div>
			        </div>



			        <div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title"><?=$data["language_data"]["val60"]?></h3>
			              <div class="box-tools pull-right">
			                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			              </div>
			            </div>
			            <div class="box-body options-box">
			           		Empty
			        	</div>
			        </div>

			         <div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title"><?=$data["language_data"]["val63"]?></h3>
			              <div class="box-tools pull-right">
			                <button class="btn btn-box-tool"><i class="glyphicon glyphicon-edit"></i></button>
			                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			              </div>
			            </div>
			            <div class="box-body no-padding">

			            	<ul class="nav nav-pills nav-stacked database-column-list">
			            		<?php
			            		foreach($data["catalog_table_columns"] as $val) :
			            		//class="active"
			            		?>
				                	<li><a href="#"><i class="glyphicon glyphicon-menu-hamburger text-light-blue"></i> <?=$val["COLUMN_NAME"]?></a></li>
				                <?php
				                endforeach;
				                ?>
			              	</ul>
			        	</div>
			        </div>




				</div>
			</div>
		</section>
	</div>
<?php
@include("parts/welcome_footer.php");
?>
<script src="<?=TEMPLATE?>dist/js/form_manipulate.js?v=<?=$c['websitevertion']?>" type="text/javascript" charset="utf-8"></script>