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
          
      <?php 
      if(count($data["categories_list_items"])):
        foreach ($data["categories_list_items"] as $v):
          $inner = 'SELECT `idx`,`title`,`background`,`slug` FROM `studio404_pages` WHERE `cid`=:cid AND `page_type`=:page_type AND `status`!=1 AND `lang`=:lang ORDER BY `position` ASC';
          $prepareInner = $conn->prepare($inner);
          $prepareInner->execute(array(
            ":page_type"=>'catalogpage', 
            ":cid"=>$v['idx'], 
            ":lang"=>LANG_ID
          ));
          if($prepareInner->rowCount()){
            $fetchInner = $prepareInner->fetchAll(PDO::FETCH_ASSOC);
            $url = "javascript:void(0)";
            $onclick = "animateLeft('#homepageItems".$v['idx']."')";
          }else{
            $url = "/".LANG."/".$v['slug']."?parentidx=".$v['idx']."&idx=".$v['idx']."&yyo"; 
            $onclick = "";
          }
        ?>
          <div class="col-md-4">
            <a href="<?=$url?>" onclick="<?=$onclick?>">
            <div class="box box-solid homepageItems" id="homepageItems<?=$v['idx']?>">
              <div class="box-header with-border">
                <i class="fa fa-list-ul"></i>
                <h3 class="box-title"><?=$v['title']?></h3>
              </div>
              <div class="box-body">
                <?php 
                $background = ($v['background']!="") ? $v['background'] : "http://batumi.404.ge/template/dist/img/no_image_thumb.gif";
                $background = str_replace("/home/geoweb/batumi.404.ge","", $background);
                ?>
                <div style="margin:0; padding:0; width:100%; height: 250px; background-image:url('<?=$background?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                </div>
              </div>
              <?php if($prepareInner->rowCount()) :?>
              <div class="hiddenSlide">
              <?php
              echo "<ul>"; 
              foreach ($fetchInner as $in) {
                $url = "/".LANG."/".$in['slug']."?parentidx=".$v['idx']."&idx=".$in['idx']; 
                echo sprintf(
                  "<li><a href=\"%s\">%s</a></li>", 
                  $url, 
                  $in['title']
                );
              }
              echo "</ul>";
              ?>
              </div>
              <?php endif; ?>

            </div>

            

            </a>
          </div>
        <?php 
        endforeach;
      endif;
      ?>


    </div>
  </section>

		<!--<section class="content">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val132"]?></h3>
            </div>
            <div class="box-body">
             

              <ul class="products-list product-list-in-box">
                <?php
                $getusername = new getusername();
                foreach ($data["lastproducts"] as $value) {
                ?>
                  <li class="item">
                    <div class="product-info" style="margin-left:0px;">
                      <a href="<?=WEBSITE.LANG?>/monacemis-naxva?view=<?=$value['idx']?>&amp;cataloglist=<?=$value['cataloglist']?>" class="product-title">
                        <?=date("d/m/Y g:i:s",$value['date'])?>
                        <span class="label label-warning pull-right"><?=$getusername->names($c,$value['insert_admin'])?></span></a>
                          <span class="product-description">
                            <?=strip_tags($value['title'])?>
                          </span>
                    </div>
                  </li> 
                <?php } ?>             
              </ul>
            </div>
          </div>					                  
				</div>

				<div class="col-md-6">

					<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><?=$data["language_data"]["val57"]?></h3>

                  <div class="box-tools pull-right">
                  	<?php $count = count($data["userlist"]); ?>
                    <span class="label label-danger"><?=$count?> <?=$data["language_data"]["val56"]?></span>
                  </div>
                </div>
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
                </div>
                <?php
                if($_SESSION["batumi_user_type"]=="website_manager"):
                ?>
                <div class="box-footer text-center">
                  <a href="<?=WEBSITE.LANG?>/momxmareblis-marTva" class="uppercase"><?=$data["language_data"]["val58"]?></a>
                </div>
                <?php
                endif;
                ?>
              </div>
             </div>


			</div>
		</section>-->
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>