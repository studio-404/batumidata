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
              <h3 class="box-title"><?=$data["language_data"]["val52"]?></h3>
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
                    <input class="form-control" type="text" id="username" value="<?=$data["ouserdata"]["username"]?>" disabled="disabled" />
                    <p class="help-block username-required" style="display:none"><font color="red"><?=$data["language_data"]["val50"]?></font></p>
                  </div>

                  <div class="form-group">
                    <label><?=$data["language_data"]["val4"]?>: <font color="red">*</font></label> <!-- Fisrname & lastname -->
                    <input class="form-control" type="text" placeholder="" id="namelname" value="<?=$data["ouserdata"]["namelname"]?>" />
                    <p class="help-block namelname-required" style="display:none"><font color="red"><?=$data["language_data"]["val13"]?></font></p>
                  </div>
                  

                  <div class="form-group">
                    <label><?=$data["language_data"]["val6"]?>: <font color="red">*</font></label> <!-- Contact Mobile -->
                    <input class="form-control" type="text" placeholder="" id="mobile" value="<?=$data["ouserdata"]["mobile"]?>" />
                    <p class="help-block mobile-required" style="display:none"><font color="red"><?=$data["language_data"]["val14"]?></font></p>
                  </div>

                                 
                  <div class="form-group">
                    <label><?=$data["language_data"]["val7"]?>:</label> <!-- Address -->
                    <input class="form-control" type="text" placeholder="" id="address" value="<?=$data["ouserdata"]["address"]?>" />
                  </div>

                  <div class="form-group">
                    <?php
                      $usersprofilepicture = ($data["ouserdata"]["picture"]!="") ? WEBSITE."/files/usersimage/".$data["ouserdata"]["picture"] : TEMPLATE."dist/img/avatar04.png";
                    ?>
                    <img src="<?=$usersprofilepicture?>" class="user-image img-circle" alt="User Image" />
    
                    <form action="" method="post" id="profile-picture-form" enctype="multipart/form-data">
                      <input type="hidden" name="typo" id="typo" value="self" />
                      <input type="hidden" name="companyId" id="companyId" value="<?=Input::method("GET","id")?>" />
                      <label for="profile-image"><?=$data["language_data"]["val11"]?> </label><!-- User Picture -->
                      <input type="file" id="profile-image" name="profileimage2" value="" />
                      <p class="help-block file-size" style="display:none"><font color="red"><?=$data["language_data"]["val16"]?></font></p>
                    </form>
                  </div>
                  

                </div>

                <div class="col-md-6">
                
                  <div class="form-group">
                    <label><?=$data["language_data"]["val49"]?>:</label> <!-- User Type -->
                    <input type="text" class="form-control" id="password" value="" />
                    <p class="help-block password-required" style="display:none"><font color="red"><?=$data["language_data"]["val51"]?></font></p>
                  </div>


                  <div class="form-group">
                    <label><?=$data["language_data"]["val12"]?>: <font color="red">*</font></label> <!-- User Type -->
                    <?php
                    $usertype = $data["ouserdata"]["user_type"];
                    ?>
                    <select class="form-control" id="user_type" disabled="disabled">
                      <option value="editor" <?=($usertype=="editor") ? 'selected="selected"' : ''?>><?=$data["language_data"]["val46"]?></option>
                      <option value="just_user" <?=($usertype=="just_user") ? 'selected="selected"' : ''?>><?=$data["language_data"]["val47"]?></option>
                    </select>
                  </div>
                  

                  <div class="form-group">
                    <label><?=$data["language_data"]["val8"]?>:</label> <!-- Date of Birth -->
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" id="dob" value="<?=date("d/m/Y",$data["ouserdata"]["dob"])?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
                    </div>
                  </div>

                   <div class="form-group">
                    <label><?=$data["language_data"]["val5"]?>: <font color="red">*</font></label> <!-- Contact Email -->
                    <input class="form-control" type="text" id="email" placeholder="" value="<?=$data["ouserdata"]["email"]?>" />
                    <p class="help-block email-required" style="display:none"><font color="red"><?=$data["language_data"]["val15"]?></font></p>
                  </div>
                  
                  

                </div>
                
                
                
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
          	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG?>" data-userid="<?=Input::method("GET","id")?>" id="edit-user"><?=$data["language_data"]["val53"]?></button>
          	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG?>" data-userid="<?=Input::method("GET","id")?>" id="edit-user-close"><?=$data["language_data"]["val54"]?></button>
              <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/momxmareblis-marTva" type="button"><?=$data["language_data"]["val55"]?></button>
            </div>
          </div><!-- /.box -->
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>