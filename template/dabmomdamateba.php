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
				<!-- <small>ჰოსტელის გვერდის მოკლე აღწერა</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val45"]?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                
                <div class="col-md-12">
                
                  <div class="form-group">
                    <label><?=$data["language_data"]["val128"]?>: <font color="red">*</font></label> <!-- Username OR Email -->
                    <input class="form-control" type="text" id="ip" value=""  />
                    <p class="help-block ip-required" style="display:none"><font color="red"><?=$data["language_data"]["val131"]?></font></p>
                  </div>

                </div>

              
                
                
                
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
          	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG?>" id="add-blocked-ip"><?=$data["language_data"]["val27"]?></button>
          	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG?>" id="add-blocked-ip-close"><?=$data["language_data"]["val28"]?></button>
              <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/dablokili-momxmareblebi" type="button"><?=$data["language_data"]["val33"]?></button>
            </div>
          </div><!-- /.box -->
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>