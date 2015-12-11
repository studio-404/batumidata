<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?> ( <?=$data["language_data"]["val22"]?>: #<?=$_SESSION["batumi_id"]?> )
				<!-- <small>ჰოსტელის გვერდის მოკლე აღწერა</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val1"]?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                
                <div class="col-md-6">
                
                  <div class="form-group">
                    <label><?=$data["language_data"]["val2"]?>: <font color="red">*</font></label> <!-- Username OR Email -->
                    <input class="form-control" type="text" value="<?=$data["userdata"]["username"]?>" disabled="disabled" />
                  </div>

                  <div class="form-group">
                    <label><?=$data["language_data"]["val4"]?>: <font color="red">*</font></label> <!-- Fisrname & lastname -->
                    <input class="form-control" type="text" placeholder="" id="namelname" value="<?=$data["userdata"]["namelname"]?>" />
                    <p class="help-block namelname-required" style="display:none"><font color="red"><?=$data["language_data"]["val13"]?></font></p>
                  </div>
                  

                  <div class="form-group">
                    <label><?=$data["language_data"]["val6"]?>: <font color="red">*</font></label> <!-- Contact Mobile -->
                    <input class="form-control" type="text" placeholder="" id="mobile" value="<?=$data["userdata"]["mobile"]?>" />
                    <p class="help-block mobile-required" style="display:none"><font color="red"><?=$data["language_data"]["val14"]?></font></p>
                  </div>

                                 
                  <div class="form-group">
                    <label><?=$data["language_data"]["val7"]?>:</label> <!-- Address -->
                    <input class="form-control" type="text" placeholder="" id="address" value="<?=$data["userdata"]["address"]?>" />
                  </div>
                  

                </div>

                <div class="col-md-6">
                
                  <div class="form-group">
                    <label><?=$data["language_data"]["val12"]?>: <font color="red">*</font></label> <!-- User Type -->
                    <input class="form-control" type="text" value="<?=$data["userdata"]["user_type"]?>" disabled="disabled" />
                  </div>

                  

                  <div class="form-group">
                    <label><?=$data["language_data"]["val8"]?>:</label> <!-- Date of Birth -->
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php
                      $dob = ($data["userdata"]["dob"]) ? date("d/m/Y",$data["userdata"]["dob"]) : "";
                      ?>
                      <input type="text" class="form-control" id="dob" value="<?=$dob?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
                    </div>
                  </div>

                   <div class="form-group">
                    <label><?=$data["language_data"]["val5"]?>: <font color="red">*</font></label> <!-- Contact Email -->
                    <input class="form-control" type="text" id="email" placeholder="" value="<?=$data["userdata"]["email"]?>" />
                    <p class="help-block email-required" style="display:none"><font color="red"><?=$data["language_data"]["val15"]?></font></p>
                  </div>
                  
                  <div class="form-group">
                    <form action="" method="post" id="profile-picture-form" enctype="multipart/form-data">
                      <input type="hidden" name="typo" id="typo" value="self" />
                      <label for="profile-image"><?=$data["language_data"]["val11"]?> </label><!-- User Picture -->
                      <input type="file" id="profile-image" name="profileimage" value="" />
                      <p class="help-block file-size" style="display:none"><font color="red"><?=$data["language_data"]["val16"]?></font></p>
                    </form>
                  </div>

                </div>
                
                
                
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
          	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="update-profile"><?=$data["language_data"]["val9"]?></button>
          	  <button class="btn btn-primary" type="submit" data-dlang="<?=LANG?>" id="update-profile-close"><?=$data["language_data"]["val10"]?></button>
              <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/welcome-system" type="submit"><?=$data["language_data"]["val33"]?></button>
            </div>
          </div><!-- /.box -->
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>