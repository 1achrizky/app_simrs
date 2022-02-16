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

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/bower_components/select2/dist/css/select2.min.css">
  
  <!-- sweetalert2 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/dist/sweetalert2.min.css">
  
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

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<!-- <body class="hold-transition skin-blue layout-top-nav" data-user_logged_in="<?=$username;?>" data-baseurl="<.?=base_url();?>"> -->
<body class="hold-transition skin-blue layout-top-nav" data-baseurl="<?=base_url();?>">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top" style="background-color: #117d70;">
      <div class="container">
        <div class="navbar-header">
          <!-- <a href="http://www.citramedika.com" class="navbar-brand"><b>RS. Citra Medika</b></a> -->
          <a href="<?=base_url();?>" class="navbar-brand"><b>RS. Citra Medika</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if(my_ip()['client'] != '192.168.1.93'){ ?>
              <li class="active"><a href="<?=base_url();?>daftarmandiri/daftaronline">Pendaftaran Mandiri<span class="sr-only">(current)</span></a></li>
            <?php } ?>

            <li><a href="<?=base_url();?>it_support/billboard">Billboard</a></li>
            <li><a href="<?=base_url();?>daftarmandiri/px_cetak_antrian">Antrian Klinik</a></li>
            <li><a href="<?=base_url();?>daftarmandiri/px_cetak_antrian_rc">Antrian Pendaftaran</a></li>
            <li><a href="<?=base_url();?>daftarmandiri/px_cetak_antrian_book">Antrian Booking (No.Request)</a></li>
            
            <!-- <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li> -->
          </ul>
          <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form> -->
        </div>
        <!-- /.navbar-collapse -->

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- User Account Menu
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<.?=base_url();?>assets/plugin/lte/dist/img/userx-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$username;?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="<.?=base_url();?>assets/plugin/lte/dist/img/userx-160x160.jpg" class="img-circle" alt="User Image">

                  <p><?=$username;?></p>
                </li>

                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div> -->
        <!-- /.navbar-custom-menu -->

      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>