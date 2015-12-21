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
			              	<div class="interface"></div>			                
			              </div>
			              <!-- /.box-body -->

			              <div class="box-footer">
						   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="edit-form">
						   	  	<?=$data["language_data"]["val61"]?></button>
						   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="edit-form-close">
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
			                <li><a href="javascript:void(0)" class="inputtextelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Text</a></li>
			                <li><a href="javascript:void(0)" class="inputtextareaelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> TextArea</a></li>
			                <li><a href="javascript:void(0)" class="selectelement" data-dlang="<?=LANG_ID?>" data-countme="1"><i class="fa fa-circle-o text-light-blue"></i> Select</a></li>
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Checkbox</a></li>
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Files</a></li>
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