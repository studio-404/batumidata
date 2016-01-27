<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- <section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?>kkkk
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section> -->

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["messages"][0]["subject"]?></h3>
            </div>
            
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                  <h5>
                    <b><?=$data["language_data"]["val100"]?></b>: &nbsp;<a href=""><?=$data["messages"][0]["fromusername"]?></a>
                    <span class="mailbox-read-time pull-right">
                      <?=$data["language_data"]["val103"]?>: <?=date("d-m-Y H:m:s",$data["messages"][0]["date"])?>
                    </span>
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
              // echo "<pre>";
              // print_r($data["messages_attachs"]);
              // echo "</pre>";
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
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i></a>
                        <span class="mailbox-attachment-size">
                        <?=filesizeconvert::byt($val["size"])?>
                        <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                        </div>
                      </li>
                    <?php
                  }
                }
                ?>
                <!-- <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name">
                      <i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right">
                            <i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li> -->
                <!-- <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li> -->
                <!--  -->
                <!-- <li>
                  <span class="mailbox-attachment-icon has-img"><img src="<?=TEMPLATE?>dist/img/photo2.png" alt="Attachment"></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                        <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li> -->
              </ul>
            </div>
            <?php
            endif;
            ?>

            <div class="box-footer">
              <div class="pull-right">
                
                <button type="button" class="btn btn-default gotoUrl" data-goto="<?=WEBSITE.LANG?>/mailbox/compose?reply=<?=$data["messages"][0]["fromid"]?>&amp;subject=<?=urlencode("Re: ".$data["messages"][0]["subject"])?>"><i class="fa fa-reply"></i> <?=$data["language_data"]["val105"]?></button>
                <!-- <button type="button" class="btn btn-default"><i class="fa fa-share"></i> <?=$data["language_data"]["val106"]?></button> -->
              </div>
              <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> <?=$data["language_data"]["val73"]?></button>
              <!-- <button type="button" class="btn btn-default"><i class="fa fa-print"></i> <?=$data["language_data"]["val107"]?></button> -->
            </div>
                      
          </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>