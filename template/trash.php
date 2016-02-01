<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>

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
            <div class="col-xs-12">
              <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">&nbsp;</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="<?=$data["language_data"]["val104"]?>">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr>
                    <th>ID</th>
                    <!-- <th><?=$data["language_data"]["val117"]?></th> -->
                    <th><?=$data["language_data"]["val101"]?></th>
                    <th><?=$data["language_data"]["val102"]?></th>
                    <th><?=$data["language_data"]["val103"]?></th>
                    <th><?=$data["language_data"]["val81"]?></th>
                  </tr>
                  <?php
                  foreach ($data["messages"] as $value) {
                    if($value["attchment"]==1){
                      $att = '<i class="fa fa-paperclip"></i>'; 
                    }else{ $att = '&nbsp;'; }
                  ?>
                    <tr>
                      <td class="mailbox-id"><?=$value["id"]?></td>
                      <!-- <td class="mailbox-name"><a href="<?=WEBSITE.LANG?>/mailbox/readmail?id=<?=$value['id']?>&amp;back=mailbox/trash"><?=$value["fromusername"]?></a></td> -->
                      <td class="mailbox-subject">
                        <?=$value["subject"]?>
                      </td>
                      <td class="mailbox-attachment"><?=$att?></td>
                      <td class="mailbox-date"><?=ago::time($value["date"],1)?></td>
                      <td>
                          <a href="<?=WEBSITE.LANG?>/mailbox/readmail?id=<?=$value['id']?>&amp;back=mailbox/trash"><i class="glyphicon glyphicon-eye-open"></i></a>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            
          </div>
            </div>
          </div>
    </section>
  </div>
<?php
@include("parts/welcome_footer.php");
?>