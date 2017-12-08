<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php
            $profilePicture = ($data["userdata"]["picture"]!="") ? WEBSITE."/files/usersimage/".$data["userdata"]["picture"] : TEMPLATE."dist/img/avatar04.png";
          ?>
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=$profilePicture?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
            <p><?=$data["userdata"]["namelname"]?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> <?=$data["language_data"]["val17"]?></a>
            </div>
          </div>

          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="<?=$data["language_data"]["val3"]?>...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>

          <!-- Sidebar Menu -->
          <?php
          $obj  = new url_controll(); // url controlls
          $slug_second = $obj->url("segment",2);
          $slug_third = $obj->url("segment",2)."/".$obj->url("segment",3);

          if($slug_third=="mailbox/compose" || $slug_third=="mailbox/inbox" || $slug_third=="mailbox/sent" || $slug_third=="mailbox/draft" || $slug_third=="mailbox/trash"){
            $display ='display:block';
            $active =' active';
          }else{
            $display ='display:none';
            $active ='';
          }
          ?>
          <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="<?=($slug_second=="welcomesystem") ? 'active' : ''?>"><a href="<?=WEBSITE.LANG?>/<?=$c["welcome.page.class"]?>"><i class="fa fa-home"></i> <span><?=(LANG=="ge") ? "მთავარი" : "Home"?></span></a></li>
            
            <?php
            if($_SESSION["batumi_user_type"]=="website_manager" || $_SESSION["batumi_user_type"]=="editor"):
            ?>

            <li class="treeview<?=$active?>">
              <a href="#">
                <i class="fa fa-envelope"></i>
                <span><?=$data["language_data"]["val94"]?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="<?=$display?>">
                <li<?=($slug_third=="mailbox/compose") ? ' class="active"' : ''?>><a href="<?=WEBSITE.LANG?>/mailbox/compose"><?=$data["language_data"]["val99"]?></a></li>
                <li<?=($slug_third=="mailbox/inbox") ? ' class="active"' : ''?>><a href="<?=WEBSITE.LANG?>/mailbox/inbox"><?=$data["language_data"]["val95"]?></a></li>
                <li<?=($slug_third=="mailbox/sent") ? ' class="active"' : ''?>><a href="<?=WEBSITE.LANG?>/mailbox/sent"><?=$data["language_data"]["val96"]?></a></li>
                <!-- <li<?=($slug_third=="mailbox/draft") ? ' class="active"' : ''?>><a href="<?=WEBSITE.LANG?>/mailbox/draft"><?=$data["language_data"]["val97"]?></a></li> -->
                <li<?=($slug_third=="mailbox/trash") ? ' class="active"' : ''?>><a href="<?=WEBSITE.LANG?>/mailbox/trash"><?=$data["language_data"]["val98"]?></a></li>
              </ul>
            </li>

            <li class="<?=($slug_second=="ourevents") ? 'active' : ''?>">
              <a href="<?=WEBSITE.LANG?>/ourevents">
                <i class="fa fa-calendar-check-o"></i> 
                <span><?=(LANG=="ge") ? "ივენთები" : "Events"?></span>
              </a>
            </li>

            <?php
            endif;
            $x = 0;
            foreach ($data["welcomepage_categories"]["item"]["title"] as $val) {
              $parentIdx = $data["welcomepage_categories"]["item"]['idx'][$x];
              $insideArray = $data["welcomepage_categories"]["item"]["sub"][$parentIdx]["cid"];

              if($parentIdx==Input::method("GET","parentidx")){
                $display ='display:block';
                $active ='active ';
              }else{
                $display ='display:none';
                $active ='';
              }

                            
              if(in_array($data["welcomepage_categories"]["item"]['idx'][$x],$insideArray)){
                echo '<li class="'.$active.'treeview">';
                echo '<a href="#"><i class="fa fa-list-ul"></i> <span>'.$data["welcomepage_categories"]["item"]["title"][$x].'</span> <i class="fa fa-angle-left pull-right"></i></a>';
                echo '<ul class="treeview-menu" style="'.$display.'">';
                $y = 0;
                foreach ($insideArray as $value) {
                  $active_tree2 = (Input::method("GET","idx")==$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["idx"][$y]) ? ' class="active"' : '';
                  echo '<li'.$active_tree2.'><a href="'.WEBSITE.LANG.'/'.$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["slug"][$y].'?parentidx='.$parentIdx.'&idx='.$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["idx"][$y].'">'.$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["title"][$y].'</a></li>';
                  $y++;
                }
                
                echo '</ul>';
                echo '</li>';
              }else{
                $active_tree = (Input::method("GET","idx")==$data["welcomepage_categories"]["item"]["idx"][$x]) ? ' class="active"' : "";
                echo '<li'.$active_tree.'><a href="'.WEBSITE.LANG.'/'.$data["welcomepage_categories"]["item"]["slug"][$x].'?parentidx='.$parentIdx.'&idx='.$data["welcomepage_categories"]["item"]["idx"][$x].'"><i class="fa fa-list-ul"></i> <span>'.$data["welcomepage_categories"]["item"]["title"][$x].'</span> </a></li>';
              }
              $x++;
            }
            $select_disallowed_items = new select_disallowed_items(); 

            if($_SESSION["batumi_user_type"]=="website_manager"):
            ?>
            <li class="<?=($slug_second=="nebarTvis-micema") ? 'active' : ''?>">
              <a href="<?=WEBSITE.LANG?>/nebarTvis-micema"><i class="fa fa-minus-circle"></i> <span><?=(LANG=="ge") ? "ნებართვის მიცემა" : "Allow"?></span> <small class="label pull-right bg-red"><?=$select_disallowed_items->cc($c)?></small></a>
            </li>
            <li class="<?=($slug_second=="katalogis-marTva") ? 'active' : ''?>">
              <a href="<?=WEBSITE.LANG?>/katalogis-marTva"><i class="fa fa-wrench"></i> <span><?=(LANG=="ge") ? "კატალოგის მართვა" : "Manage catalog"?></span></a>
            </li>
            <li class="<?=($slug_second=="momxmareblis-marTva") ? 'active' : ''?>"><a href="<?=WEBSITE.LANG?>/momxmareblis-marTva"><i class="fa fa-users"></i> <span><?=$data['language_data']["val40"]?></span></a></li>
            <?php endif; ?>
            <li class="<?=($slug_second=="profilis-redaqtireba") ? 'active' : ''?>"><a href="<?=WEBSITE.LANG?>/profilis-redaqtireba"><i class="fa fa-user-secret"></i> <span><?=$data['language_data']["val39"]?></span></a></li>
            <li class="<?=($slug_second=="sistemis-logebi") ? 'active' : ''?>"><a href="<?=WEBSITE.LANG?>/sistemis-logebi"><i class="fa fa-unlock"></i> <span><?=$data['language_data']["val125"]?></span></a></li> 
            <li class="<?=($slug_second=="dablokili-momxmareblebi") ? 'active' : ''?>"><a href="<?=WEBSITE.LANG?>/dablokili-momxmareblebi"><i class="fa fa-lock"></i> <span><?=$data['language_data']["val130"]?></span></a></li> 
           
         </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>