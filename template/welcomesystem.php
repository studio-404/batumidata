<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				მთავარი
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> მთავარი</a></li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added Products</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">

                <li class="item">
                  <div class="product-img">
                    <img src="<?=TEMPLATE?>dist/img/default-50x50.gif" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript::;" class="product-title">Samsung TV
                      <span class="label label-warning pull-right">$1800</span></a>
                        <span class="product-description">
                          Samsung 32" 1080p 60Hz LED Smart HDTV.
                        </span>
                  </div>
                </li>                
               
               
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="javascript::;" class="uppercase">View All Products</a>
            </div>
            <!-- /.box-footer -->
          </div>					                  
				</div>

				<div class="col-md-6">

					<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><?=$data["language_data"]["val57"]?></h3>

                  <div class="box-tools pull-right">
                  	<?php $count = count($data["userlist"]); ?>
                    <span class="label label-danger"><?=$count?> <?=$data["language_data"]["val56"]?></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  	<?php
                  	if($count) :
                  	foreach($data["userlist"] as $ulist) : 
                  		$usersprofilepicture = ($ulist["picture"]!="") ? WEBSITE."/files/usersimage/".$ulist["picture"] : TEMPLATE."dist/img/avatar04.png";
                  	?>
                    <li>
                      <img src="<?=$usersprofilepicture?>" alt="User Image">
                      <a class="users-list-name" href="javascript:;"><?=$ulist["namelname"]?></a>
                      <span class="users-list-date"><?=ucfirst(str_replace("_"," ",$ulist["user_type"]))?></span>
                    </li>
                    <?php
                    endforeach;
                    endif;
                    ?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <?php
                if($_SESSION["batumi_user_type"]=="website_manager" || $_SESSION["batumi_user_type"]=="editor"):
                ?>
                <div class="box-footer text-center">
                  <a href="<?=WEBSITE.LANG?>/momxmareblis-marTva" class="uppercase"><?=$data["language_data"]["val58"]?></a>
                </div>
                <?php
                endif;
                ?>
                <!-- /.box-footer -->
              </div>
             </div>


			</div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>