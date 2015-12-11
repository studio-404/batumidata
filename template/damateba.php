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
					<input type="hidden" name="parent_idx" id="parent_idx" value="<?=$data["parent_idx"]?>" />

                          <div class="form-group">
                            <label><?=$data["language_data"]["val29"]?>: <font color="red">*</font></label> <!-- Fisrname & lastname -->
                            <input class="form-control" type="text" placeholder="" id="titlex" value="">
                            <p class="help-block titlex-required" style="display:none">
                            	<font color="red"><?=$data["language_data"]["val31"]?></font></p>
                          </div>
                          
                    </div>
                </div>
          </div>
          <div class="box-footer">
		   	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="add-catalogue">
		   	  	<?=$data["language_data"]["val27"]?></button>
		   	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="add-catalogue-close">
		   	  	<?=$data["language_data"]["val28"]?></button>
		   	  <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/katalogis-marTva" type="submit"><?=$data["language_data"]["val33"]?></button>
		  </div>
      </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>