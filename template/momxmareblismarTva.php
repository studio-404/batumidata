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
			                  <button type="button" class="btn btn-default btn-sm gotoUrl" data-goto="<?=WEBSITE.LANG?>/momxmareblis-marTva/momxmareblis-damateba"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<?=$data["language_data"]["val24"]?></button>
			                   <button type="button" class="btn btn-default btn-sm reloadMe" style="margin-left:5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?=$data["language_data"]["val25"]?></button>
			                </div>
			             </div>
						<?php
						// echo "<pre>"; 
						// print_r($data['userlist']);
						// echo "</pre>";
						?>
	            		<table id="example1" class="table table-bordered dataTable">
	            			<tr>
	            				<th><?=$data["language_data"]["val22"]?></th>
	            				<th><?=$data["language_data"]["val2"]?></th>		
	            				<th><?=$data["language_data"]["val42"]?></th>		
	            				<th><?=$data["language_data"]["val43"]?></th>		
	            				<th><?=$data["language_data"]["val20"]?></th>
	            			</tr>
	            			
	         				<?php
	         				foreach($data['userlist'] as $val) :
	         				?>
	            			<tr>
	            				<td><?=$val["id"]?></td>
	            				<td><?=$val["username"]?></td>
	            				<td><?=$val["namelname"]?></td>
	            				<td><?=$val["user_type"]?></td>
	            				<td>
	            					<a href="<?=WEBSITE.LANG?>/momxmareblis-marTva/momxmareblis-redaqtireba?id=<?=$val['id']?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
		            				<a href="javascript:void(0)" style="padding:0 0 0 5px" class="remove-user" data-dlang="<?=LANG?>" data-userid="<?=$val["id"]?>"><i class="glyphicon glyphicon-remove"></i></a>
	            				</td>
	            			</tr>
	            			<?php
	            			endforeach;
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