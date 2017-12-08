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
              <h3 class="box-title"><?=$data["language_data"]["val34"]?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                	<div class="col-md-12 form-message-output" style="display:none"><p></p></div> 
                    <div class="col-md-12">

						<div class="form-group">
                            <label><?=$data["language_data"]["val29"]?>: <font color="red">*</font></label> 
                            <input class="form-control" type="text" placeholder="" id="titlex" data-oldname="<?=$data["parent_title"]?>" value="<?=$data["parent_title"]?>" />
                            <p class="help-block titlex-required" style="display:none">
                            	<font color="red"><?=$data["language_data"]["val31"]?></font>
                            </p>
                        </div>



                 <div class="form-group">
                        <form action="" method="post" enctype="multipart/form-data" id="catalog-form">
                            <?php 
                            if(isset($data["parent_background"]) && $data["parent_background"]!=""){
                              
                              $file = explode("/home/geoweb/batumi.404.ge", $data["parent_background"]);
                              $file = isset($file[1]) ? $file[1] : "http://batumi.404.ge/template/dist/img/no_image_thumb.gif";
                              echo '<img src="'.$file.'" style="max-width:250px; border:solid 1px #ccc; border-radius:0" class="user-image img-circle" alt="User Image">';
                            }else{
                              echo '<img src="http://batumi.404.ge/template/dist/img/no_image_thumb.gif" style="max-width:250px; border:solid 1px #ccc; border-radius:0" class="user-image img-circle" alt="User Image">';
                            }
                            ?>
                        
                          
                            <div style="clear:both"></div>    
                            <label for="catalog-image">ატვირთეთ ფოტო </label><!-- User Picture -->
                            <input type="hidden" name="catalogid" value="<?=(isset($_GET["id"])) ? $_GET["id"] : 0?>" />
                            <input type="file" id="catalog-image" name="catalog-image" value="" />
                            <p class="help-block file-size" style="display:none"><font color="red">ფაილის ზომა უნდა იყოს 215x215 პიქსელი, JPG ფორმატის და არ უნდა აღემატებოდეს 1MB</font></p>
                            <div style="clear:both"></div><br />
                            <div class="form-group">
                                <label>გამოჩენა მთავარ გვერდზე: </label>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" class="showwelcome" name="showwelcome" value="1" <?=($data["parent_showwelcome"]==1)? 'checked="checked"' : ''?> />გამოჩენა
                                  </label>
                                </div>
                            </div>
                        </form>
                      </div>


                          
                    </div>
                </div>
          </div>
          <div class="box-footer">
		   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="edit-catalogue">
		   	  	<?=$data["language_data"]["val35"]?></button>
		   	  <button class="btn btn-primary" type="button" data-dlang="<?=LANG_ID?>" id="edit-catalogue-close">
		   	  	<?=$data["language_data"]["val36"]?></button>
		   	  <button class="btn btn-primary btn-warning gotoUrl" data-goto="<?=WEBSITE.LANG?>/katalogis-marTva" type="button"><?=$data["language_data"]["val33"]?></button>
		  </div>
      </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>