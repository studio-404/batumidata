<li class="dropdown user user-menu">
  <!-- Menu Toggle Button -->
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <!-- The user image in the navbar-->
    <?php
    $profilePicture = ($data["userdata"]["picture"]!="") ? WEBSITE."/files/usersimage/".$data["userdata"]["picture"] : TEMPLATE."dist/img/avatar04.png";
    ?>
    <img src="<?=$profilePicture?>" class="user-image" alt="User Image" />
    <!-- hidden-xs hides the username on small devices so only the image appears. -->
    <span class="hidden-xs"><?=$data["userdata"]["namelname"]?></span>
  </a>
  <ul class="dropdown-menu">
    <!-- The user image in the menu -->
    <li class="user-header">
      <img src="<?=$profilePicture?>" class="img-circle" alt="User Image" />
      <p>
        <?=$data["userdata"]["namelname"]?>
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