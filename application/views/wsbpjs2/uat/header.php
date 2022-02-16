<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="shortcut icon" href="<?=base_url();?>assets/img/rscm/LOGO RSCM MINI.png" />
  <title>RS. Citra Medika</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/select2/dist/css/select2.min.css">
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/dist/sweetalert2.min.css">
  
  <!-- Theme style -->

  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- bootstrap time picker -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/plugins/timepicker/bootstrap-timepicker.min.css">
  

  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/dist/css/skins/_all-skins.min.css">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/plugins/iCheck/flat/blue.css">
  <!-- JQUERY-UI -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/jquery-ui-1.12.1/jquery-ui.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/site-lte.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .rscm-bg-color{
      background-color: #117d70;
    }

    .btn-rscm{
      background-color: #117d70;
    }
    
    /*untuk menghilangkan spinner(tombol up down) di type=number*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini" data-user_logged_in="<?=$username;?>" data-baseurl="<?=base_url();?>">
<div class="wrapper">

<?php
// echo "<pre>",print_r($menu),"</pre>";

// INI YANG DIPAKAI
function buildMenuLteNew($menuArray){
  foreach ($menuArray as $node){
      
      if ( ! empty($node['children'])) {
        echo '<li class="treeview">'.
          '<a href="'. $node['url'] .'"/>'.
            '<i class="'.$node['icon'].'"></i>'.
            '<span>' . $node['title'] . '</span>'.
            '<span class="pull-right-container">'.
              '<i class="fa fa-angle-left pull-right"></i>'.
            '</span>'.
          '</a>';
          echo '<ul class="treeview-menu">';
          buildMenuLteNew($node['children']);
          echo '</ul>';
        echo "</li>";
      }else{ // children == empty
        echo '<li><a href="'. $node['url'] .'"/>'.
            '<i class="'.$node['icon'].'"></i><span>' . $node['title'] . '</span>'.
          '</a></li>';
      }
      
  }
}


// exit;
?>



  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CM</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>RS Citra Medika</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url();?>assets/plugin/lte/dist/img/userx-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$username;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url();?>assets/plugin/lte/dist/img/userx-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?=$username;?>
                  <!-- <small>Member since 2017</small> -->
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('user_xlink/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>




  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url();?>assets/plugin/lte/dist/img/userx-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$username;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <!-- target="_blank" // OPEN NEW TAB -->
      <ul class="sidebar-menu" data-widget="tree">
         
      

        <li class="header">BPJS UAT</li>
      
        <?php buildMenuLteNew($menu); ?>
        <!-- <.?php echo print_r($menu);?> -->
        

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
