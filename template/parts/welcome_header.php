<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IntraNet V <?=$c['websitevertion']?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=TEMPLATE?>bootstrap/css/bootstrap.min.css?v=<?=$c['websitevertion']?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css?v=<?=$c['websitevertion']?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css?v=<?=$c['websitevertion']?>"> 
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?=TEMPLATE?>plugins/daterangepicker/daterangepicker-bs3.css?v=<?=$c['websitevertion']?>">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?=TEMPLATE?>plugins/iCheck/all.css?v=<?=$c['websitevertion']?>">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?=TEMPLATE?>plugins/colorpicker/bootstrap-colorpicker.min.css?v=<?=$c['websitevertion']?>">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?=TEMPLATE?>plugins/timepicker/bootstrap-timepicker.min.css?v=<?=$c['websitevertion']?>">   
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=TEMPLATE?>plugins/select2/select2.min.css?v=<?=$c['websitevertion']?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=TEMPLATE?>dist/css/AdminLTE.min.css?v=<?=$c['websitevertion']?>">
    <link rel="stylesheet" href="<?=TEMPLATE?>dist/css/skins/skin-blue.min.css?v=<?=$c['websitevertion']?>">
    <link rel="stylesheet" href="<?=TEMPLATE?>dist/css/general.css?v=<?=$c['websitevertion']?>" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=<?=$c['websitevertion']?>"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=<?=$c['websitevertion']?>"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="overlay overlay-loader">
     <i class="fa fa-refresh fa-spin overley-loader-icon"></i>
</div>
 
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>I</b>Net</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>IntraNet</b> <?=$c['websitevertion']?></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             <?php
             @include("template/parts/messages.php");
             @include("template/parts/notifications.php");
             @include("template/parts/userprofile.php");
             ?>
             </ul>
          </div>
        </nav>
      </header>