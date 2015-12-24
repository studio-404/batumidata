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
                   <div class="mailbox-controls">
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm gotoUrl" data-goto="<?=WEBSITE.LANG?>/monacemis-damateba?parent=<?=Input::method("GET","idx")?>"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<?=$data["language_data"]["val24"]?></button>
                         <button type="button" class="btn btn-default btn-sm reloadMe" style="margin-left:5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?=$data["language_data"]["val25"]?></button>
                      </div>
                   </div>
                   <?php
// echo "<pre>";
// print_r($data["catalog_table_list"]);
// echo "</pre>";
                   ?>

                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <?php
                      foreach($data["catalog_table_list"] as $val){
                        echo '<th>'.$val['label'].'</th>';
                      }
                      ?>
                      <th>მოქმედება</th>
                    </tr>
                    <!-- <tr>
                      <td>183</td>
                      
                      <td>
                        <a href="<?=WEBSITE.LANG?>/katalogis-marTva/redaqtireba?id=<?=$value['idx']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="javascript:void(0)" style="padding:0 0 0 5px" class="remove-catalogue" data-dlang="<?=LANG?>" data-catid="<?=$value["idx"]?>"><i class="glyphicon glyphicon-remove"></i></a>
                      </td>
                    </tr> -->
                    
              
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