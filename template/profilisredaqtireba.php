<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?=$data["text_general"][0]["title"]?>
				<!-- <small>ჰოსტელის გვერდის მოკლე აღწერა</small> -->
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">რედაქტირების ფორმა</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>ქალაქი</label>
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected">ბათუმი</option>
                      <option>ქობულეთი</option>
                    </select>
                  </div><!-- /.form-group -->
                  <!-- Date and time range -->
                  <div class="form-group">
                    <label>Date and time range:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservationtime">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                </div><!-- /.col -->
                <div class="col-md-6">
                
                  <div class="form-group">
                    <label>Date masks:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  <!-- Date range -->
                  <div class="form-group">
                    <label>Date range:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservation">
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  
                </div><!-- /.col -->
                <div class="col-md-6">
                
                  <div class="form-group">
                    <label>Text</label>
                    <input class="form-control" type="text" placeholder="Enter ...">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input id="exampleInputFile" type="file">
                  </div>
                  
                </div><!-- /.col -->
                
                <div class="col-md-6">
                
                  <div class="form-group">
                    <label>Text</label>
                    <input class="form-control" type="text" placeholder="Enter ...">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input id="exampleInputEmail1" class="form-control" type="email" placeholder="Enter email">
                  </div>
                  
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </div><!-- /.box-body -->
            <div class="box-footer">
          	  <button class="btn btn-primary" type="submit">Submit</button>
            </div>
          </div><!-- /.box -->
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>