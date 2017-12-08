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
            	if(isset($_GET['print'])){
                echo '<script> window.print(); </script>';
              }
            	?>
	     	 	<div class="box-body table-responsive no-padding">
                  <table class="table table-hover filterEmptyTds">
                    <tr>
                      <th style="min-width:250px;">ID</th>
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
                      <td><?=$data["getusername"]->names($c,$data["fetch"]["insert_admin"])?></td>
                    </tr>                     
                    
                    <tr>
                      <th><?=$data["language_data"]["val85"]?></th>
                      <td><?=implode(", ",$data["cataloglist_names"]->names($c,$data["fetch"]["cataloglist"]))?></td>
                    </tr> 
                        
                    <?php 
                    // $select_form_label = new select_form_label();
                    foreach ($data["labellists"] as $value) {
                      $attach_column = explode(" ",$value['attach_column']);

                      if($value['type']!="file"){
                        if($value["type"]=="date"){
                          echo '<tr>';
                          echo '<th>'.$value["label"].'</th>';
                          echo '<td>';
                          echo date("d/m/Y",$data["fetch"][$attach_column[0]]);
                          echo '</td>';
                          echo '</tr>';
                        }else{
                          echo '<tr>';
                          echo '<th>'.$value["label"].'</th>';
                          echo '<td>'.$data["fetch"][$attach_column[0]].'</td>';
                          echo '</tr>';
                        }
                      }else if($value["type"]=="file" && ($value['attach_format']=="png" || $value['attach_format']=="gif" || $value['attach_format']=="jpg")){ 
                        $files = $labellists->loadpictures($c,$value["name"]); 
                        echo '<tr>';
                        echo '<th>'.$value["label"].'</th>';
                        echo '<td>';
                        foreach ($files as $v) {
                          echo '<div class="col-md-2">';
                          echo '<img src="'.WEBSITE.'files/document/'.$v['sgf_file'].'" width="100%" alt="" border="1" />';
                          echo '</div>';
                        }                       
                        echo '</td>';
                        echo '</tr>';
                      }else{
                        $files = $labellists->loadpictures($c,$value["name"]); 
                        echo '<tr>';
                        echo '<th>'.$value["label"].'</th>';
                        echo '<td>';
                        foreach ($files as $v) {
                          echo '<a href="'.WEBSITE.'files/document/'.$v['sgf_file'].'" target="_blank">'.$v['sgf_file'].'</a><br />';
                        }                       
                        echo '</td>';
                        echo '</tr>';
                      }
                    
                    }
                    ?>    
                    <?php
                    if($_SESSION["batumi_user_type"]=="website_manager"):
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
                    <?php
                    endif;
                    ?>
                  </table>
                </div><!-- /.box-body -->

	     	 </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>
<script type="text/javascript">
     $(".filterEmptyTds tr").each(function(){
       var td = $("td", this).html(); 
       if(td==""){ $(this).hide(); }
      });
     </script>