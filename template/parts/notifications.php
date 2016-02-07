<?php
if($_SESSION["batumi_user_type"]=="website_manager" || $_SESSION["batumi_user_type"]=="editor"):
?>
<!-- Notifications Menu -->
<li class="dropdown messages-menu">
  <!-- Menu toggle button -->
  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="notificationseen">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning" id="notification_count">0</span>
  </a>
  <ul class="dropdown-menu notification_html">
  </ul>
</li>
<?php
endif;
?>