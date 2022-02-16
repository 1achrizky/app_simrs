<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Consolebox | RS Citra Medika</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/Ionicons/css/ionicons.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


  <style>
      .sidebar-menu li a{
        font-size:18pt;
      }
      .content-wrapper{
        /* background-image:url("<?=base_url()?>assets/img/rscm/rscm-kanan.JPG") !important; */
        background-image:url("<?=base_url()?>assets/img/rscm/consolebox-bg.jpg") !important;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        padding-top:0px !important;
        /* opacity: 0.5; BISA, cuman belakangnya warna hitam, jadinya gelap kalau transparan */
        /* background:blue  !important; */
      }
      
      /* .skin-blue .main-header .navbar { */
      /* .main-header.navbar { */
      .skin-blue .main-header .logo {
          background-color: #222d32 !important;
      }

      .main-footer{
        opacity: 0.5;
      }

      .main-console{
        /* opacity: 0.5; */
        background-color: rgba(255,255,255,0.9) !important;
      }

      /* .main-console .book-header .book-title{ */
      .title-console{
        font-size:20pt !important;
      }

      .text-center{
        text-align:center;
      }

      .sidebar-menu li{
        border:2px solid #ddd;
        border-radius: 10px;
        background: #008082; /* #17a2b8, #42ba96; */
        margin:0px 3px 3px;
      }

      </style>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini" data-baseurl="<?=base_url();?>">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- <header class="main-header">
    <a href="../../index2.html" class="logo">
      <.!-- mini logo for sidebar mini 50x50 pixels --.>
      <span class="logo-mini"><b>C</b>M</span>
      <.!-- logo for regular state and mobile devices --.>
      <span class="logo-lg"><b>RS Citra Medika</b></span>
    </a>

    
    <.!-- Header Navbar: style can be found in header.less --.>
    <nav class="navbar navbar-static-top">
      <.!-- Sidebar toggle button--.>
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    </nav>
  </header> -->

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- <span style="color:#FFF;">CM</span> -->
      
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree" style="margin-top:100px;">
        
        <!-- <li><a href="#" data-toggle="push-menu" role="button"><b>&#9776;</b></a></li> -->

        <!-- <li><a href="<.?=base_url('consolebox');?>"><i class="fa fa-circle-o text-success"></i> <span>Home</span></a></li>
        <li style="background:#000;"><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Booking</span></a></li>
        <li><a href="<.?=base_url('consolebox/antrian_daftar');?>"><i class="fa fa-circle-o text-aqua"></i> <span>Antrian Daftar</span></a></li>
        <li><a href="<.?=base_url('consolebox/antrian_klinik');?>"><i class="fa fa-circle-o text-success"></i> <span>Antrian Klinik</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Jadwal Dokter</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Ketersediaan <br> &nbsp;&nbsp;&nbsp;&nbsp; Kamar</span></a></li> -->


        <?php
        


        // $li_sel = ' style="background:#000;"';
        for ($i=0; $i < count($li); $i++) { 
          $li_sel = ($li[$i]['file'] == $menu_selected)? ' style="background:#000;"' : '';
          echo '<li '.$li_sel.'><a href="'.$li[$i]['href'].'">'.$li[$i]['logo'].' <span>'.$li[$i]['label'].'</span></a></li>';
        }
        ?>

        
      </ul>

      <!-- <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Home</a>
        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Profile</a>
        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>
        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>
      </div> -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">