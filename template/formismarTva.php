<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
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
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form role="form">
			              <div class="box-body">
			                <!-- <div class="form-group">
			                  <label for="exampleInputEmail1">Email address</label>
			                  <a href="" style="float:right"><i class="glyphicon glyphicon-edit"></i></a>
			                  <input type="email" class="form-control" placeholder="Enter email" />
			                </div> -->
			                
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
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <div class="box-body no-padding">
			              <ul class="nav nav-pills nav-stacked">
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Text</a></li>
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Select</a></li>
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Checkbox</a></li>
			                <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> files</a></li>
			              </ul>
			            </div>
			        </div>



			        <div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title"><?=$data["language_data"]["val60"]?></h3>
			            </div>
			            <!-- /.box-header -->
			            <!-- form start -->
			            <form role="form">
			              
			            </form>
			        </div>




				</div>
			</div>
		</section>
	</div>

<?php
@include("parts/welcome_footer.php");
?>