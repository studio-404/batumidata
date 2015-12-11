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
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> <?=$data["text_general"][0]["title"]?></a></li>
			</ol>
		</section>

		<section class="content">
			<?php
			// echo "<pre>";
			// print_r($data['cataloglist']);
			// echo "</pre>";
			?>
			<div class="row">
            	<div class="col-md-12">
            		<a href="" class="btn btn-app" style="margin:10px 0;">
		               	<i class="fa fa-plus"></i> Add
		            </a>
		            <a href="" class="btn btn-app" style="margin:10px 0 10px 10px;">
		               	<i class="fa fa-times"></i> Delete
		            </a>
					<div style="clear:both"></div>
            		<div class="box">
            			

	            		<table id="example1" class="table table-bordered dataTable">
	            			<tr>
	            				<th>
	            					<div class="icheckbox_flat-blue checked" aria-checked="true" aria-disabled="false">
	            							<input type="checkbox" style="position: absolute; opacity: 0;">
	            							<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
	            					</div>
	            				</th>
	            				<th><?=$data["language_data"]["val22"]?></th>
	            				<th><?=$data["language_data"]["val23"]?></th>
	            				<th><?=$data["language_data"]["val21"]?></th>	            				
	            				<th><?=$data["language_data"]["val18"]?></th>
	            				<th><?=$data["language_data"]["val19"]?></th>
	            				<th><?=$data["language_data"]["val20"]?></th>
	            			</tr>
	            			<?php
	            			$select_sub_catalog = new select_sub_catalog();
	            			foreach ($data['cataloglist'] as $value) {
	            				?>
	            				<tr>
		            				<td>
		            					<div class="icheckbox_flat-blue checked" aria-checked="true" aria-disabled="false">
	            							<input type="checkbox" style="position: absolute; opacity: 0;">
	            							<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
	            						</div>
		            				</td>
		            				<td><?=$value['idx']?></td>
		            				<td><?=$value['cid']?></td>
		            				<td>
		            					<a href=""><i class="glyphicon glyphicon-arrow-up"></i></a>
		            					<a href=""><i class="glyphicon glyphicon-arrow-down"></i></a>
		            				</td>
		            				<td><?=$value['title']?></td>
		            				<td><a href="<?=WEBSITE.LANG."/".$value['slug']?>"><?=WEBSITE.LANG."/".$value['slug']?></a></td>
		            				<td>
		            					<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
		            					<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-plus-sign"></i></a>
		            					<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-remove"></i></a>
		            				</td>
		            			</tr>
	            				<?php
	            				$fetchAll = $select_sub_catalog->select($c,$value['idx']);
	            				if(count($fetchAll)){
	            					foreach ($fetchAll as $value2) {
	            						?>
	            						<tr style="background-color: #f9f9f9;">
				            				<td>
				            					<div class="icheckbox_flat-blue checked" aria-checked="true" aria-disabled="false">
			            							<input type="checkbox" style="position: absolute; opacity: 0;">
			            							<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
			            						</div>
				            				</td>
				            				<td><?=$value2['idx']?></td>
				            				<td><?=$value2['cid']?></td>
				            				<td>
				            					<a href=""><i class="glyphicon glyphicon-arrow-up"></i></a>
		            							<a href=""><i class="glyphicon glyphicon-arrow-down"></i></a>
				            				</td>
				            				<td><?=$value2['title']?></td>
				            				<td><a href="<?=WEBSITE.LANG."/".$value2['slug']?>"><?=WEBSITE.LANG."/".$value2['slug']?></a></td>
				            				<td>
				            					<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
		            							<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-plus-sign"></i></a>
		            							<a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-remove"></i></a>	
				            				</td>
				            			</tr>
	            						<?php	
	            					}
	            				}
	            			}
	            			?>
	            			
	            			
	            		</table>
            		</div>
		        </div>  
          	</div>
		</section>
	</div>

<?php
@include("parts/welcome_footer.php");
?>