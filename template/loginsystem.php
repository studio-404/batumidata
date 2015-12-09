<?php
@include("parts/login_header.php");
?>
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
            <input type="text" class="form-control" id="login-captcha" placeholder="დამცავი კოდი">
            <span class="glyphicon glyphicon-plus form-control-feedback"></span>
            <div style="clear:both"></div>
            <?php
            $_SESSION['protect_x'] = ustring::random(4);
            ?>
            <img src="<?=WEBSITE?>protect.php" alt="" style="float:left; margin-top:15px; border:solid 1px #d2d6de; width:95px; height:35px;" class="protectimage" />
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
              <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-button">შესვლა</button>
            </div><!-- /.col -->
          </div>
        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
<?php
@include("parts/login_footer.php");
?>