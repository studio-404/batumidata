<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["messages"][0]["subject"]?></h3>
            </div>
            
            <div class="box-body no-padding">

              <div class="mailbox-read-info">
                  <h5>
                    <b><?=$data["language_data"]["val103"]?></b>: &nbsp;
                    <a href=""><?=ago::time($data["messages"][0]["date"],1)?></a>
                  </h5>
              </div>

              <div class="mailbox-read-info">
                  <h5>
                    <b><?=$data["language_data"]["val118"]?></b>: &nbsp;<a href=""><?=$data["messages"][0]["fromusername"]?></a>
                  </h5>
              </div>

              <div class="mailbox-read-info">
                  <h5>
                    <?php
                    $receiver = new receiver();
                    $names = $receiver->names($c,$data["messages"][0]["tousers"]);
                    ?>
                    <b><?=$data["language_data"]["val116"]?></b>: &nbsp;<a href=""><?=$names?></a>
                  </h5>
              </div>
             
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <label><?=$data["language_data"]["val38"]?>: </label><br />
                <?=html_entity_decode($data["messages"][0]["text"])?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>

            <?php
            if($data["messages"][0]["attchment"]) : 
            ?>
            <div class="box-footer">
              <label><?=$data["language_data"]["val115"]?>: </label><br />
              <ul class="mailbox-attachments clearfix">
                <?php
                foreach ($data["messages_attachs"] as $val) {
                  if($val["ext"]=="jpg" || $val["ext"]=="jpeg" || $val["ext"]=="png" || $val["ext"]=="gif")
                  {
                    ?>
                      <li>
                        <span class="mailbox-attachment-icon has-img">
                          <img src="<?=WEBSITE."files/attachments/".$val["file"]?>" alt="Attachment"></span>

                        <div class="mailbox-attachment-info">
                        <!-- <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i></a> -->
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" target="blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }else if($val["ext"]=="pdf"){
                    ?>
                      <li>
                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                        <div class="mailbox-attachment-info">
                        <!-- <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?=$val["file"]?></a> -->
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }else if($val["ext"]=="zip" || $val["ext"]=="rar"){
                    ?>
                    <li>
                        <span class="mailbox-attachment-icon"><i class="fa fa-file-archive-o"></i></span>

                        <div class="mailbox-attachment-info">
                        <!-- <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?=$val["file"]?></a> -->
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }else if($val["ext"]=="doc" || $val["ext"]=="docx"){
                    ?>
                    <li>
                        <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                        <div class="mailbox-attachment-info">
                        <!-- <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?=$val["file"]?></a> -->
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }else if($val["ext"]=="xls" || $val["ext"]=="xlsx"){
                    // 
                    ?>
                    <li>
                        <span class="mailbox-attachment-icon"><i class="fa fa-file-excel-o"></i></span>

                        <div class="mailbox-attachment-info">
                        <!-- <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?=$val["file"]?></a> -->
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="<?=WEBSITE."files/attachments/".$val["file"]?>" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }
                }
                ?>
              </ul>
            </div>
            <?php
            endif;
            ?>

            <div class="box-footer">
              <?php 
              if($data["messages"][0]["fromuser"]!=$_SESSION["batumi_id"]) : ?>
              <div class="pull-right">
                <button type="button" class="btn btn-default gotoUrl" data-goto="<?=WEBSITE.LANG?>/mailbox/compose?reply=<?=$data["messages"][0]["fromid"]?>&amp;subject=<?=urlencode("Re: ".$data["messages"][0]["subject"])?>"><i class="fa fa-reply"></i> <?=$data["language_data"]["val105"]?></button>
              </div>
              <?php
              endif;
              if(Input::method("GET","back")){
                $b = Input::method("GET","back");
              }else{
                $b = 'mailbox/inbox';
              }
              ?>
              <button type="button" class="btn btn-default gotoUrl" data-goto="<?=WEBSITE.LANG?>/<?=$b?>"><i class="fa fa-times"></i> <?=$data["language_data"]["val55"]?></button>
              <button type="button" class="btn btn-default deleteMailboxMessage" data-msgid="<?=Input::method("GET","id")?>" data-dlang="<?=LANG?>"><i class="fa fa-trash-o"></i> <?=$data["language_data"]["val73"]?></button>
             
            </div>
                      
          </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>