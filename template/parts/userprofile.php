<li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?=TEMPLATE?>dist/img/avatar04.png" class="user-image" alt="User Image" />
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?=$_SESSION["batumi_namelname"]?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?=TEMPLATE?>dist/img/avatar04.png" class="img-circle" alt="User Image" />
                  <p>
                    <?=$_SESSION["batumi_namelname"]?>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?=WEBSITE.LANG?>/profilis-redaqtireba" class="btn btn-default btn-flat">პროფილი</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" id="system-out">გასვლა</a>
                  </div>
                </li>
              </ul>
            </li>