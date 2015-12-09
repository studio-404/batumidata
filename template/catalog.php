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
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">ჰოსტელების ჩამონათვალი</h3>
                  <div class="box-tools pull-right">
                   <span class="glyphicon glyphicon-plus">&nbsp;დამატება</span>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th>დასახელება</th>
                      <th>თარიღი</th>
                      <th>მისამართი</th>
                      <th>ტელ. / მობ.</th>
                      <th>აღწერა მოკლედ</th>
                      <th>ვრცლად</th>
                      <th>რედაქტირება</th>
                      <th>წაშლა</th>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <th>ბათუმი, ფარნავაზ მეფის ქ. №86</th>
                      <th>+995 591 22 44 00</th>
                      <th>აღწერა მოკლედ ჰოსტელის შესახებ</th>
                      <th><button class="btn btn-block btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign" title="ვრცლად"></span></button></th>
                      <td><button class="btn btn-block btn-success btn-sm"><span class="glyphicon glyphicon-edit" title="რედაქტირება"></span></button></td>
                      <td><button class="btn btn-block btn-danger btn-sm"><span class="glyphicon glyphicon-remove" title="წაშლა"></span></button></td>
                    </tr>
                    <tr>
                      <td>219</td>
                      <td>Alexander Pierce</td>
                      <td>11-7-2014</td>
                      <th>ბათუმი, ფარნავაზ მეფის ქ. №86</th>
                      <th>+995 591 22 44 00</th>
                      <th>აღწერა მოკლედ ჰოსტელის შესახებ</th>
                      <th><button class="btn btn-block btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign" title="ვრცლად"></span></button></th>
                      <td><button class="btn btn-block btn-success btn-sm"><span class="glyphicon glyphicon-edit" title="რედაქტირება"></span></button></td>
                      <td><button class="btn btn-block btn-danger btn-sm"><span class="glyphicon glyphicon-remove" title="წაშლა"></span></button></td>
                    </tr>
                    <tr>
                      <td>657</td>
                      <td>Bob Doe</td>
                      <td>11-7-2014</td>
                      <th>ბათუმი, ფარნავაზ მეფის ქ. №86</th>
                      <th>+995 591 22 44 00</th>
                      <th>აღწერა მოკლედ ჰოსტელის შესახებ</th>
                      <th><button class="btn btn-block btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign" title="ვრცლად"></span></button></th>
                      <td><button class="btn btn-block btn-success btn-sm"><span class="glyphicon glyphicon-edit" title="რედაქტირება"></span></button></td>
                      <td><button class="btn btn-block btn-danger btn-sm"><span class="glyphicon glyphicon-remove" title="წაშლა"></span></button></td>
                    </tr>
                    <tr>
                      <td>175</td>
                      <td>Mike Doe</td>
                      <td>11-7-2014</td>
                      <th>ბათუმი, ფარნავაზ მეფის ქ. №86</th>
                      <th>+995 591 22 44 00</th>
                      <th>აღწერა მოკლედ ჰოსტელის შესახებ</th>
                      <th><button class="btn btn-block btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign" title="ვრცლად"></span></button></th>
                      <td><button class="btn btn-block btn-success btn-sm"><span class="glyphicon glyphicon-edit" title="რედაქტირება"></span></button></td>
                      <td><button class="btn btn-block btn-danger btn-sm"><span class="glyphicon glyphicon-remove" title="წაშლა"></span></button></td>
                    </tr>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>