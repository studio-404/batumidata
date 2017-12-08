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
			                   <button type="button" class="btn btn-default btn-sm reloadMe" style="margin-left:5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?=$data["language_data"]["val25"]?></button>
			                </div>
			             </div>
	            		<table id="example1" class="table table-bordered dataTable">
	            			<tr>
	            				<th><?=$data["language_data"]["val22"]?></th>
	            				<th><?=$data["language_data"]["val103"]?></th>
	            				<th><?=$data["language_data"]["val2"]?></th>
	            				<th><?=$data["language_data"]["val42"]?></th>		
	            				<th><?=$data["language_data"]["val126"]?></th>		
	            				<th><?=$data["language_data"]["val127"]?></th>
	            				<th><?=$data["language_data"]["val128"]?></th>
	            				<th><?=$data["language_data"]["val129"]?></th>
	            			</tr>
	            			
	         				<?php
	         				foreach($data['systemlogs'] as $val) :
	         				?>
	            			<tr>
	            				<td><?=$val["id"]?></td>
	            				<td><?=date("d/m/Y H:i:s",$val["date"])?></td>
	            				<td><?=$val["username"]?></td>
	            				<td><?=$val["namelname"]?></td>
	            				<td><?=$val["browser"]?></td>
	            				<td><?=$val["os"]?></td>
	            				<td><?=$val["ip"]?></td>
	            				<?php
	            				if($val["logtry"]=="Batumi intranet enter"){
	            					echo '<td>Success</td>';
	            				}else{
	            					echo '<td>Error</td>';
	            				}
	            				?>	            				
	            			</tr>
	            			<?php
	            			endforeach;
	            			?>
	            		</table>
	            		<?php
            			$allitems = $data['systemlogs'][0]["allitems"]; 
            			if($allitems>$data['item_per_page']):
            			?>
	            				

           <div class="box-footer clearfix">
                
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php
                $back = (Input::method("GET","pn")>2) ? Input::method("GET","pn")-1 : 1;
                $froward = (Input::method("GET","pn")<($allitems/$data['item_per_page'])) ? Input::method("GET","pn")+1 : ceil($allitems/$data['item_per_page']);
                if(!Input::method("GET","pn")){ $froward = 2; }
                ?>
                <li><a href="?pn=<?=$back?>">«</a></li>
                <?php
                $howmany = $allitems / $data['item_per_page'];
                if($howmany<1){ $howmany = 1; }
                
                for($x=1;$x<=ceil($howmany);$x++){
                  $active = (Input::method("GET","pn")==$x) ? ' class="active"' : '';
                  if(!Input::method("GET","pn") && $x==1 || (Input::method("GET","pn")<=0 && $x==1)){ $active = ' class="active"'; }
                ?>
                <li<?=$active?>><a href="?pn=<?=$x?>"><?=$x?></a></li>
                <?php } ?>
                <li><a href="?pn=<?=$froward?>">»</a></li>
              </ul>
            </div>
			<?php
			endif;
			?>
	</div>
					



		        </div>  
          	</div>
		</section>
	</div>

<?php
@include("parts/welcome_footer.php");
?>