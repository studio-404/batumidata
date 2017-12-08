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
          <h4 class="modal-title">შეტყობინება</h4>
        </div>
        <div class="modal-body">
          გნებავთ წაშალოთ მონაცემი ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">დახურვა</button>
          <button type="button" class="btn btn-primary removeEventTrue">წაშლა</button>
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
        ივენთების კალენდარი
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> ივენთების კალენდარი</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-3">
        
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">დამატება / რედაქტირება</h3>
              <font id="messagex" color="red"></font>
            </div>
            <div class="box-body add_event_box">

              <div class="event_lists" style="margin-top: 20px">
                
              </div>
              
              <!-- /btn-group -->
              <div class="input-group event_form_elements">
                <input id="eidx" type="hidden" class="form-control" value="" />
                <input id="elang" type="hidden" class="form-control" value="" />
                <input id="etitle" type="text" class="form-control" placeholder="დასახელება" />
                <input id="estart_date" type="text" class="form-control datepicker" placeholder="დაწყება" />
                <input id="eend_date" type="text" class="form-control datepicker" placeholder="დასრულება" />
                <textarea id="eaddress" class="form-control" rows="3" placeholder="მისამართი"></textarea>
                <input id="eprice" type="text" class="form-control" placeholder="ფასი" />
                <select class="form-control select2" id="ecurrency" style="width: 100%;">
                  <option selected="selected">ვალუტა</option>
                  <option value="დოლარი">დოლარი</option>
                  <option value="ლარი">ლარი</option>
                  <option value="ევრო">ევრო</option>
                </select>
                <textarea id="edescription" class="form-control" rows="3" placeholder="აღწერა"></textarea>
                <div style="clear:both"></div>
              </div>

              <div class="input-group">
                <div class="input-group-btn">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">დამატება</button>
                </div>
              </div>

              <!-- /input-group -->
            </div>
          </div>
        </div>
        
        <div class="col-md-9">
            
            <?php 


            $calendar = new calendar(); 
            echo $calendar->index();
            ?>

        </div>

      </div>
    </section>
    <!-- /.content -->
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>
