<?php
@include("parts/login_header.php");
?>
<div class="modal fade" id="add-organisation" tabindex="-1" role="dialog" labelledby="smallModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">დამატების ფორმა</h4>
      </div>
      <div class="modal-body">
          <form action="" method="post">
            <select class="form-control select-catalog" id="mcat">
              <option value="">აირჩიეთ</option>
              <?php
              $x=0; 
              $subcategory = new subcategory();
              foreach($data["welcomepage_categories"]["item"]["title"] as $val){ 
                $countsub = $subcategory->counts($c,$data["welcomepage_categories"]["item"]["idx"][$x]);
                if($countsub>0){
                  ?>
                  <optgroup label="<?=$data["welcomepage_categories"]["item"]["title"][$x]?>">
                    <?php
                    $fetch2 = $subcategory->select($c,$data["welcomepage_categories"]["item"]["idx"][$x]);
                    foreach ($fetch2 as $value2) {
                      if($value2['idx']==Input::method("GET","parent")){
                        echo '<option value="'.$value2['idx'].'" selected="selected">'.$value2['title'].'</option>';
                      }else{
                        echo '<option value="'.$value2['idx'].'">'.$value2['title'].'</option>';
                      }
                    }
                    ?>
                  </optgroup>
                  <?php
                }else{
                ?>
                <option value="<?=$data["welcomepage_categories"]["item"]["idx"][$x]?>"><?=$data["welcomepage_categories"]["item"]["title"][$x]?></option>
                <?php
                }
              $x++;
              }
              ?>
            </select>
            <div class="insert-form" style="margin:20px 0 0 0; text-align:center; display:none">
              
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">დახურვა</button>
        <button type="button" class="btn btn-primary" id="add-catalogue-nouser">დამატება</button>
      </div>
    </div>
  </div>
</div>



<div class="login-box">
      <div class="login-logo">
        <a href=""><b>Intra</b>Net</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <form action="javascript:;" method="post">
          <p class="text-red">Text red to emphasize danger</p>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="login-email" placeholder="ელ. ფოსტა">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="login-password" placeholder="პაროლი">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="login-captcha" placeholder="დამცავი კოდი" autocomplete="off" />
            <span class="glyphicon glyphicon-plus form-control-feedback"></span>
            <div style="clear:both"></div>
            <?php
            $_SESSION['protect_x'] = ustring::random(4);
            ?>
            <img src="<?=WEBSITE?>protect.php" alt="" style="float:left; margin-top:15px; border:solid 1px #d2d6de; width:95px; height:35px;" class="protectimage" />
            <a href="javascript:void(0)" class="reloadprotect" style="float:left; margin:20px 0 0 10px; font-size:18px;"><i class="glyphicon glyphicon-refresh"></i></a>
            <div style="clear:both"></div>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                <input type="checkbox" id="login-testuser" /> <span style="margin-left:10px;">მომხმარებელი</span>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-button">შესვლა</button
            </div><!-- /.col -->
          </div>

        </form>


      </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    <button type="button" class="btn bg-olive margin" style="width:100%; margin:20px 0px; padding:10px 0" data-toggle="modal" data-target="#add-organisation">ორგანიზაციის დამატება</button>
<?php
@include("parts/login_footer.php");
?>