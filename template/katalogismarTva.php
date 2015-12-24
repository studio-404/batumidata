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
			<div class="row">
            	<div class="col-md-12">
            		
            		<div class="box">
            			<div class="mailbox-controls">
			                <div class="btn-group">
			                  <button type="button" class="btn btn-default btn-sm gotoUrl" data-goto="<?=WEBSITE.LANG?>/katalogis-marTva/damateba"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<?=$data["language_data"]["val24"]?></button>
			                   <button type="button" class="btn btn-default btn-sm reloadMe" style="margin-left:5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?=$data["language_data"]["val25"]?></button>
			                </div>
			             </div>
			             <div class="box-body table-responsive no-padding">
	            		<table id="example1" class="table table-bordered dataTable">
	            			<tr>
	            				<th><?=$data["language_data"]["val22"]?></th>
	            				<th><?=$data["language_data"]["val23"]?></th>
	            				<th><?=$data["language_data"]["val37"]?></th>
	            				<th><?=$data["language_data"]["val21"]?></th>	            				
	            				<th><?=$data["language_data"]["val18"]?></th>
	            				<th><?=$data["language_data"]["val19"]?></th>
	            				<th><?=$data["language_data"]["val20"]?></th>
	            			</tr>
	            			<?php
	            			$select_sub_catalog = new select_sub_catalog();
	            			$x = 1;
	            			$count = count($data['cataloglist']);
	            			foreach ($data['cataloglist'] as $value) {
	            				?>
	            				<tr>
		            				<td><?=$value['idx']?></td>
		            				<td><?=$value['cid']?></td>
		            				<td><?=$value['position']?></td>
		            				<td>
		            					<?php
		            					if($x!=1):
		            					?>
		            						<a href="javascript:void(0)" class="up-catalog" data-idx="<?=$value["idx"]?>" data-cid="<?=$value["cid"]?>" data-position="<?=$value["position"]?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
		            					<?php endif; ?>
		            					<?php if($count>$x) : ?>
		            						<a href="javascript:void(0)" class="down-catalog" data-idx="<?=$value["idx"]?>" data-cid="<?=$value["cid"]?>" data-position="<?=$value["position"]?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
		            					<?php endif;?>
		            				</td>
		            				<td><?=$value['title']?></td>
		            				<td><a href="<?=WEBSITE.LANG."/".$value['slug']?>"><?=WEBSITE.LANG."/".$value['slug']?></a></td>
		            				<td>
		            					<a href="<?=WEBSITE.LANG?>/katalogis-marTva/redaqtireba?id=<?=$value['idx']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
		            					<a href="<?=WEBSITE.LANG?>/katalogis-marTva/damateba?parent=<?=$value['idx']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-plus-sign"></i></a>
		            					<a href="<?=WEBSITE.LANG?>/katalogis-marTva/formis-marTva?parent=<?=$value['idx']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-wrench"></i></a>
		            					<a href="javascript:void(0)" style="padding:0 0 0 5px" class="remove-catalogue" data-dlang="<?=LANG?>" data-catid="<?=$value["idx"]?>"><i class="glyphicon glyphicon-remove"></i></a>
		            				</td>
		            			</tr>
	            				<?php
	            				$fetchAll = $select_sub_catalog->select($c,$value['idx']);
	            				$count2 = count($fetchAll);
	            				if($count2){
	            					$y = 1; 
	            					foreach ($fetchAll as $value2) {
	            						?>
	            						<tr style="background-color: #f9f9f9;">
				            				<td><?=$value2['idx']?></td>
				            				<td><?=$value2['cid']?></td>
				            				<td><?=$value2['position']?></td>
				            				<td>
				            					<?php if($y!=1): ?>
				            					<a href="javascript:void(0)" class="up-catalog" data-idx="<?=$value2["idx"]?>" data-cid="<?=$value2["cid"]?>" data-position="<?=$value2["position"]?>"><i class="glyphicon glyphicon-arrow-up"></i></a>
				            					<?php endif; ?>
		            							<?php if($count2 > $y): ?>
		            							<a href="javascript:void(0)" class="down-catalog" data-idx="<?=$value2["idx"]?>" data-cid="<?=$value2["cid"]?>" data-position="<?=$value2["position"]?>"><i class="glyphicon glyphicon-arrow-down"></i></a>
		            							<?php endif; ?>
				            				</td>
				            				<td><?=$value2['title']?></td>
				            				<td><a href="<?=WEBSITE.LANG."/".$value2['slug']?>"><?=WEBSITE.LANG."/".$value2['slug']?></a></td>
				            				<td>
				            					<a href="<?=WEBSITE.LANG?>/katalogis-marTva/redaqtireba?id=<?=$value2['idx']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
		            							<!-- <a href="" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-plus-sign"></i></a> -->
		            							<a href="javascript:void(0)" style="padding:0 0 0 5px" class="remove-catalogue" data-dlang="<?=LANG?>" data-catid="<?=$value2["idx"]?>"><i class="glyphicon glyphicon-remove"></i></a>	
				            				</td>
				            			</tr>
	            						<?php
	            						$y++;	
	            					}
	            				}
	            				$x++;
	            			}
	            			?>
	            			
	            			
	            		</table>
	            	</div>
            		</div>



		        </div>  
          	</div>
		</section>
	</div>

<?php
@include("parts/welcome_footer.php");
?>