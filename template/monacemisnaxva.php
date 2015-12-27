<?php
@include("parts/welcome_header.php");
@include("parts/leftside.php");
?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$data["language_data"]["val84"]?></h3>
            </div>
            <div class="box-body">
            	<?php
            	// echo "<pre>";
            	// print_r($data["catalog_table_columns"]);
            	// echo "</pre>";
            	?>
               

            	<?php
                    $cataloglist_names = new cataloglist_names();
                    $getusername = new getusername();
                    ?>
	     	 	<div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <td><?=$data["fetch"]["idx"]?></td>
                    </tr>  

                    <tr>
                      <th><?=$data["language_data"]["val83"]?></th>
                      <td><?=date("d/m/Y H:i:s",$data["fetch"]["date"])?></td>
                    </tr> 

                    <tr>
                      <th><?=$data["language_data"]["val90"]?></th>
                      <td><?=$data["fetch"]["insert_ip"]?></td>
                    </tr>  

                    <tr>
                      <th><?=$data["language_data"]["val86"]?></th>
                      <td><?=$getusername->names($c,$data["fetch"]["insert_admin"])?></td>
                    </tr> 

                    
                    
                    <tr>
                      <th><?=$data["language_data"]["val85"]?></th>
                      <td><?=implode(", ",$cataloglist_names->names($c,$data["fetch"]["cataloglist"]))?></td>
                    </tr> 

                    <tr>
                      <th><?=$data["language_data"]["val82"]?></th>
                      <td><?=$data["fetch"]["title"]?></td>
                    </tr> 

                    <?php
                    $select_form_label = new select_form_label();
                    foreach ($data["catalog_table_columns"] as $value) { 
                      	
                       	if(in_array($value["Field"], $c['database.catalog.item.lock.array'])){ continue; }
						$label = $select_form_label->label($c,$value["Field"]);
						$v = ($label) ? $label : $value["Field"]; 
						echo '<tr>
						<th>'.$v.'</th>
						<td>'.$data["fetch"][$value["Field"]].'</td>
						</tr>';
                    }
                    ?>
					 <tr>
                      <th><?=$data["language_data"]["val87"]?></th>
                      <td><?php
                      if($data["fetch"]["visibility"]==1){
                      	echo '<span class="label label-success give-permision" style="cursor:pointer" data-dlang="'.LANG.'">'.$data["language_data"]["val88"].'</span>'; 
                      }else{
                      	echo '<span class="label label-danger remove-permision" style="cursor:pointer" data-dlang="'.LANG.'">'.$data["language_data"]["val89"].'</span>';
                      }
                      ?></td>
                    </tr>               
              
                  </table>
                </div><!-- /.box-body -->

	     	 </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>