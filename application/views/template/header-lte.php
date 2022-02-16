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

// $menu = [
$menuX = [
  [
    "title" => "Manajemen",
    "url" => "",
    "icon" => ["fa fa-folder", ""],
    "children" => [
      [
        "title" => "Dashboard",
        "url" => base_url()."bo/menu/manajemen/dashboard-manajemen",
        "icon" => ["fa fa-book", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Morbiditas",
        "url" => base_url()."bo/menu/manajemen/morbiditas",
        "icon" => ["fa fa-book", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Informasi Ketersediaan TT",
        "url" => base_url()."bo/menu/manajemen/info-tt-mnj",
        "icon" => ["fa fa-book", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Efisiensi Huni Tempat Tidur",
        "url" => "#",
        "icon" => ["fa fa-folder", ""],
        "children" => [
          [
            "title" => "Bulanan",
            "url" => base_url()."bo/menu/manajemen/efihuni-tt/efihuni-tt-bln",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Tahunan",
            "url" => base_url()."bo/menu/manajemen/efihuni-tt/efihuni-tt-thn",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
      [
        "title" => "Dokter Spesialis",
        "url" => "#",
        "icon" => ["fa fa-folder", ""],
        "children" => [
          [
            "title" => "Tarif RJ (INA-RS)",
            "url" => base_url()."bo/menu/manajemen/dokter-spesialis/tarif-sp-ina-rs",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Tarif RI (INA-RS)",
            "url" => base_url()."bo/menu/manajemen/dokter-spesialis/tarifri-sp-ina-rs",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
    ],
  ],
  
  [
    "title" => "IT",
    "url" => base_url()."bo/menu/pembelian",
    "icon" => ["fa fa-folder", ""],
    "children" => [
      [
        "title" => "Upload Billboard Auto",
        "url" => base_url()."it_support/upload_data_billboard_auto",
        "icon" => ["fa fa-circle-o", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Support",
        "url" => "#",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "Departemen",
            "url" => "#",
            "icon" => ["fa fa-file-text", ""],
            "children" => [
              [
                "title" => "Ganti Penanggung",
                "url" => base_url()."it_support/ganti_penanggung",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
              [
                "title" => "Hapus Tindakan",
                "url" => base_url()."it_support/tindakan_hapus",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
              [
                "title" => "Transfer Billing",
                "url" => base_url()."bo/menu/it/support/departemen/transfer-billing",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
            ],
          ],
          [
            "title" => "Dokter",
            "url" => "#",
            "icon" => ["fa fa-file-text", ""],
            "children" => [
              [
                "title" => "Jadwal Dokter Nonaktif",
                "url" => base_url()."bo/menu/it/support/dokter/jadwal-dokter-nonaktif",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
            ],
          ],
          [
            "title" => "Pasien",
            "url" => "#",
            "icon" => ["fa fa-file-text", ""],
            "children" => [
              [
                "title" => "Billboard",
                "url" => base_url()."it_support/billboard",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
            ],
          ],
          [
            "title" => "BPJS",
            "url" => "#",
            "icon" => ["fa fa-file-text", ""],
            "children" => [
              [
                "title" => "Aplicare",
                "url" => base_url()."bo/menu/it/support/bpjs/aplicare",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
            ],
          ],
          [
            "title" => "WS",
            "url" => "#",
            "icon" => ["fa fa-file-text", ""],
            "children" => [
              [
                "title" => "WS BPJS RUN",
                "url" => base_url()."bo/menu/it/support/ws/ws-bpjs-run",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
              [
                "title" => "WS RS",
                "url" => base_url()."bo/menu/it/support/ws/ws-rs",
                "icon" => ["fa fa-circle-o", "text-aqua"],
                "children" => null,
              ],
            ],
          ],
          
        ],
      ],
      [
        "title" => "User",
        "url" => "#",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "User Akses",
            "url" => base_url()."bo/menu/it/user/user-akses",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Tanda Tangan",
            "url" => base_url()."bo/menu/it/user/ttd",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
      [
        "title" => "Web",
        "url" => "#",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "Upload Artikel",
            "url" => base_url()."bo/menu/it/web/upload-artikel",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Daftar Artikel",
            "url" => base_url()."bo/menu/it/web/daftar-artikel",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
      [
        "title" => "Setting",
        "url" => "#",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "Printer",
            "url" => base_url()."bo/menu/it/setting/printer",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
    ],
    
  ],
  
  [
    "title" => "Receptionist",
    "url" => "#",
    "icon" => ["fa fa-folder", ""],
    "children" => [
      [
        "title" => "Upload Bed & Jadwal Dokter",
        "url" => base_url()."bo/menu/receptionist/upload_data_billboard",
        "icon" => ["fa fa-circle-o", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Update Tanggal Pulang",
        "url" => base_url()."bo/menu/receptionist/update-tgl-plg",
        "icon" => ["fa fa-circle-o", "text-aqua"],
        "children" => null,
      ],
      [
        "title" => "Pendaftaran RJ",
        "url" => "",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "Pendaftaran Booking",
            "url" => base_url()."bo/menu/receptionist/pendaftaranrj/daftarbooking",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Pendaftaran Mandiri",
            "url" => base_url()."daftarmandiri/admin",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Pendaftaran Mandiri(NEW)",
            "url" => base_url()."bo/menu/receptionist/pendaftaranrj/pendaftaran-rjri",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
      [
        "title" => "Laporan",
        "url" => "",
        "icon" => ["fa fa-file-text", ""],
        "children" => [
          [
            "title" => "Pendaftaran RJ",
            "url" => base_url()."bo/menu/receptionist/laporan/lap-daftarrj",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Booking",
            "url" => base_url()."bo/menu/receptionist/laporan/lap-booking",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "LOG Pendaftaran RJ",
            "url" => base_url()."bo/menu/receptionist/laporan/log-pendaftaranrj",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
          [
            "title" => "Lain-lain",
            "url" => base_url()."bo/menu/receptionist/laporan/lap-lain",
            "icon" => ["fa fa-circle-o", "text-aqua"],
            "children" => null,
          ],
        ],
      ],
    ],
  ],
  // [
  //   "title" => "Penjualan",
  //   "url" => base_url()."bo/menu/penjualan",
  //   "icon" => ["fa fa-shopping-cart", "text-aqua"],
  //   "children" => [
  //     [
  //       "title" => "Entry Penjualan",
  //       "url" => base_url()."bo/menu/penjualan/faktur",
  //       "icon" => ["fa fa-usd", "text-aqua"],
  //       "children" => null,
  //     ],
  //     [
  //       "title" => "Laporan Penjualan",
  //       "url" => base_url()."bo/menu/penjualan/lap-penjualan",
  //       "icon" => ["fa fa-book", "text-aqua"],
  //       "children" => null,
  //     ],
     
  //   ],
    
  // ],
  


];


// echo "<pre>",print_r($menu),"</pre>";




function buildMenuLte($menuArray){
  foreach ($menuArray as $node){
      
      if ( ! empty($node['children'])) {
        echo '<li class="treeview">'.
          '<a href="'. $node['url'] .'"/>'.
            '<i class="'.$node['icon'][0].' '.$node['icon'][1].'"></i>'.
            '<span>' . $node['title'] . '</span>'.
            '<span class="pull-right-container">'.
              '<i class="fa fa-angle-left pull-right"></i>'.
            '</span>'.
          '</a>';
          echo '<ul class="treeview-menu">';
          buildMenuLte($node['children']);
          echo '</ul>';
        echo "</li>";
      }else{ // children == empty
        echo '<li><a href="'. $node['url'] .'"/>'.
            '<i class="'.$node['icon'][0].' '.$node['icon'][1].'"></i><span>' . $node['title'] . '</span>'.
          '</a></li>';
      }
      
  }
}


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
        <li class="header">MENU UTAMA</li>
        
        <li>
          <a href="<?=base_url();?>bo/menu/dashboard">
            <i class="fa fa-pie-chart text-aqua"></i> <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="<?=base_url();?>it_support/billboard" target="_blank">
            <i class="fa fa-desktop text-aqua"></i> <span>Billboard</span>
          </a>
        </li>
        
        <li>
          <a href="<?=base_url();?>bo/menu/perpustakaan">
            <i class="fa fa-book text-aqua"></i> <span>Perpustakaan</span>
          </a>
        </li>

        <li>
          <a href="<?=base_url();?>bo/menu/laporan-tahunan">
            <i class="fa fa-book text-aqua"></i> <span>Laporan Tahunan</span>
          </a>
        </li>

      
      
      

      <li class="header">DEPARTEMEN & TIM</li>
      
      <!-- <.?php buildMenuLte($menu); ?> -->
      <?php buildMenuLteNew($menu); ?>
      <!-- <.?php echo print_r($menu_new);?> -->
        

        <li class="header">AKUN SAYA</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user text-aqua"></i> <span>Akun Saya</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url();?>bo/menu/akun-saya/ubah-password"><i class="fa fa-key text-aqua"></i>Ubah Password</a></li>
          </ul>
            
        </li>

        <!-- <.?php echo "<pre>", print_r($uakses_det),"</pre>";?> -->
        <!-- <.?php echo "<pre>", print_r($data_header),"</pre>";?> -->

<!-- 
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
