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
          <h4 class="modal-title"><?=$data["language_data"]["val38"]?></h4>
        </div>
        <div class="modal-body">
          <?=$data["language_data"]["val91"]?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary deleteUnsuportedItem"><?=$data["language_data"]["val73"]?></button>
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
                      <div class="btn-group" style="width:100%">
                        <button type="button" class="btn btn-default btn-sm gotoUrl" data-goto="<?=WEBSITE.LANG?>/monacemis-damateba?parent=<?=Input::method("GET","idx")?>&amp;back=<?=$data["catalog_general"][0]["slug"]?>" style="float:left"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;<?=$data["language_data"]["val24"]?></button>
                        <button type="button" class="btn btn-default btn-sm reloadMe" style="float:left; margin-left:5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?=$data["language_data"]["val25"]?></button>
                        
                        <label style="float:right; width:135px;">
                        <span style="line-height:30px;"><?=$data["language_data"]["val79"]?>: &nbsp;&nbsp;</span> 
                        <select name="show"  id="showitems" class="form-control input-sm" style="float:right; width:70px;">
                            <option value="10" <?=(Input::method("GET","sw")==10) ? 'selected="selected"' : ''?>>10</option>
                            <option value="25" <?=(Input::method("GET","sw")==25) ? 'selected="selected"' : ''?>>25</option>
                            <option value="50" <?=(Input::method("GET","sw")==50) ? 'selected="selected"' : ''?>>50</option>
                            <option value="100" <?=(Input::method("GET","sw")==100) ? 'selected="selected"' : ''?>>100</option>
                         </select> 
                        </label>
                      </div>

                     

                   </div>
                   
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <?php
                      foreach($data["catalog_table_list"] as $val){
                        echo '<th>'.$val['label'].'</th>';
                      }
                      ?>
                      <th><?=$data["language_data"]["val80"]?></th>
                      <th><?=$data["language_data"]["val81"]?></th>
                    </tr>
                    <?php
                    $getusername = new getusername();
                    foreach($data["catalogitems"] as $key => $val){
                    ?>
                      <tr>
                        <td><?=$val['idx']?></td>
                        <?php
                        $actual_link = $c['site.protocol']."$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        foreach($data["catalog_table_list"] as $v){
                          $attach_column = explode(" ",$v['attach_column']);
                          echo '<td>'.$val[$attach_column[0]].'</td>';
                        }
                        ?>
                        <td><a href=""><?=$getusername->names($c,$val['insert_admin'])?></a></td>
                        <td>
                          <a href="<?=WEBSITE.LANG."/monacemis-naxva?view=".$val['idx']?>&amp;cataloglist=<?=$val['cataloglist']?>" target="_blank" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-new-window"></i></a>
                          <a href="<?=WEBSITE.LANG?>/monacemis-redaqtireba?parent=<?=$val['cataloglist']?>&amp;idx=<?=$val['idx']?>&amp;back=<?=$actual_link?>" style="padding:0 0 0 5px"><i class="glyphicon glyphicon-edit"></i></a>
                          <a href="javascript:void(0)" style="padding:0 0 0 5px" class="deleteUnpublishData" data-dlang="<?=LANG?>" data-id="<?=$val['idx']?>"><i class="glyphicon glyphicon-remove"></i></a>
                        </td>
                      </tr> 
                    <?php
                    }
                    ?>
              
                  </table>
                </div><!-- /.box-body -->


                <div class="box-footer clearfix">
                
              <ul class="pagination pagination-sm no-margin pull-right">
                <?php
                $sw = (Input::method("GET","sw")) ? '&sw='.Input::method("GET","sw") : '';
                $back = (Input::method("GET","pn")>2) ? Input::method("GET","pn")-1 : 1;
                $froward = (Input::method("GET","pn")<$data["fetch"]["allitems"]) ? Input::method("GET","pn")+1 : $data["fetch"]["allitems"];
                if(!Input::method("GET","pn")){ $froward = 2; }
                ?>
                <li><a href="?idx=<?=Input::method("GET","idx")?>&amp;pn=<?=$back?><?=$sw?>">«</a></li>
                <?php
                $howmany = $data["fetch"]["allitems"] / Input::method("GET","sw");
                if($howmany<1){ $howmany = 1; }
                
                for($x=1;$x<=ceil($howmany);$x++){
                  $active = (Input::method("GET","pn")==$x) ? ' class="active"' : '';
                  if(!Input::method("GET","pn") && $x==1){ $active = ' class="active"'; }
                ?>
                <li<?=$active?>><a href="?idx=<?=Input::method("GET","idx")?>&amp;pn=<?=$x?><?=$sw?>"><?=$x?></a></li>
                <?php } ?>
                <li><a href="?idx=<?=Input::method("GET","idx")?>&amp;pn=<?=$froward?><?=$sw?>">»</a></li>
              </ul>
            </div>

              </div><!-- /.box -->
            </div>
          </div>
		</section>
	</div>
     

<?php
@include("parts/welcome_footer.php");
?>