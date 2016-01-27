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
        <div class="modal-body">
          <?=$data["language_data"]["val91"]?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary deleteUnsuportedItem"><?=$data["language_data"]["val73"]?></button>
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
            <div class="col-xs-12">
              test
            </div>
          </div>
    </section>
  </div>
     

<?php
@include("parts/welcome_footer.php");
?>