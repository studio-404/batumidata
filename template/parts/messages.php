<?php
if($_SESSION["batumi_user_type"]=="website_manager" || $_SESSION["batumi_user_type"]=="editor"):
?>
<li class="dropdown messages-menu">
  <a href="javascript:void(0)" class="dropdown-toggle messageseen" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success" id="message_count">0</span>
  </a>
  <ul class="dropdown-menu message_html">
  </ul>
</li>
<?php endif; ?>