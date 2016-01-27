<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>

  <!-- START REGISTER POPUP -->
<div class="modal fade" id="bs-example-xx" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val38"]?></h4>
        </div>
        <div class="modal-body messagebodytext">
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$data["catalog_general"][0]["title"]?>
        <!-- <small>ჰოსტელის გვერდის მოკლე აღწერა</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["catalog_general"][0]["title"]?></a></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
            <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">&nbsp;</div>
            <!-- /.box-header -->
            <div class="box-body">
             <?php
             if(!empty($data["upload_status"])){
                $x = 0;
                $anyError = "";
                foreach ($data["upload_status"] as $value) {
                  if($data["upload_status"]["error"][$x]==1){
                     $anyError .= "<font style='font-size:16px; padding:10px 0px; margin:10px 0; color:red'>".$data["upload_status"]["filename"][$x]." : ".$data["language_data"]["val113"]."</font><br />";
                  }
                  $x++;
                }
                if($anyError!=""){
                  echo $anyError;
                  echo "<font style='font-size:16px; padding:10px 0px; margin:10px 0; color:green'>".$data["language_data"]["val114"]."</font><br />"; 
                }else{
                  echo "<font style='font-size:16px; padding:10px 0px; margin:10px 0; color:green'>".$data["language_data"]["val114"]."</font><br />";
                }
                echo "<br />";
             }
             
             ?>
              <div class="form-group">
                <select class="form-control select2" id="selectusers" multiple="multiple" data-placeholder="<?=$data["language_data"]["val108"]?>" style="width: 100%;">
                <?php
                $x = 0;
                foreach ($data["userlist"] as $value) {
                  if($_SESSION["batumi_id"]==$value['id']){ continue; }
                  if(Input::method("GET","reply")==$value['id']){ $selected = 'selected="selected"'; }
                  else{ $selected = ''; }
                  echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['namelname'].'</option>';
                }
                ?>
                </select>
              </div>
              <div class="form-group">
                <input class="form-control" id="subject" placeholder="<?=$data["language_data"]["val109"]?>:" value="<?=(Input::method("GET","subject")) ? urldecode(Input::method("GET","subject")) : ''?>" />
              </div>
              <div class="form-group">
                    <textarea class="form-control tinyMce" id="message" style="height: 300px" placeholder="<?=$data["language_data"]["val38"]?>"></textarea>
                  </div>
              <div class="form-group">
                <form action="" method="post" id="fileupload" enctype="multipart/form-data">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> <?=$data["language_data"]["val110"]?>
                  
                    <input type="hidden" name="attach" id="attach" value="false" />
                    <input type="hidden" name="insert_id" id="insert_id" value="0" />
                    <input type="file" name="attachment[]" id="attachment" multiple />
                 
                </div>
                 </form>
                <p class="help-block">Max. <span id="maxfilesize"><?=ini_get("upload_max_filesize")?></span></p>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="button" class="btn btn-default sendmessage" data-draft="yes" data-dlang="<?=LANG?>"><i class="fa fa-pencil"></i> &nbsp;<?=$data["language_data"]["val112"]?></button>
                <button type="submit" class="btn btn-primary sendmessage" data-draft="no" data-dlang="<?=LANG?>"><i class="fa fa-envelope-o"></i> &nbsp;<?=$data["language_data"]["val111"]?></button>
              </div>
              <button type="reset" class="btn btn-default gotoUrl" data-goto="<?=WEBSITE.LANG?>/mailbox/inbox"><i class="fa fa-times"></i> &nbsp;<?=$data["language_data"]["val55"]?></button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
      </div>
    </section>
  </div>

<?php
@include("parts/welcome_footer.php");
?>