<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="ძებნა...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">მთავარი მენიუ</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="<?=WEBSITE.LANG?>/<?=$c["welcome.page.class"]?>"><i class="fa fa-link"></i> <span>მთავარი</span></a></li>
            <?php
            $x = 0;
            foreach ($data["welcomepage_categories"]["item"]["title"] as $val) {
              // echo $data["welcomepage_categories"]["item"]['idx'][$x]."--test--";
              $parentIdx = $data["welcomepage_categories"]["item"]['idx'][$x];
              $insideArray = $data["welcomepage_categories"]["item"]["sub"][$parentIdx]["cid"];               
              if(in_array($data["welcomepage_categories"]["item"]['idx'][$x],$insideArray)){
                echo '<li class="treeview">';
                echo '<a href="#"><i class="fa fa-link"></i> <span>'.$data["welcomepage_categories"]["item"]["title"][$x].'</span> <i class="fa fa-angle-left pull-right"></i></a>';
                echo '<ul class="treeview-menu">';
                $y = 0;
                foreach ($insideArray as $value) {
                  echo '<li><a href="'.WEBSITE.LANG.'/'.$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["slug"][$y].'">'.$data["welcomepage_categories"]["item"]["sub"][$parentIdx]["title"][$y].'</a></li>';
                  $y++;
                }
                
                echo '</ul>';
                echo '</li>';
              }else{
                echo '<li><a href="'.WEBSITE.LANG.'/'.$data["welcomepage_categories"]["item"]["slug"][$x].'"><i class="fa fa-link"></i> <span>'.$data["welcomepage_categories"]["item"]["title"][$x].'</span></a></li>';
              }
              $x++;
            }
            ?>

            <!-- <li><a href="#"><i class="fa fa-link"></i> <span>კვების ობიექტები</span></a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>განთავსების ობიექტები</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">სასტუმრო</a></li>
              </ul>
            </li> -->
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>