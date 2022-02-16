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


  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


  <style>
    @import url('https://fonts.googleapis.com/css?family=Roboto+Mono:300,500');

    html, body {
        width: 100%;
        height: 100%;
    }

    body {
        background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/257418/andy-holmes-698828-unsplash.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100vh;
        min-width: 100vw;
        font-family: "Roboto Mono", "Liberation Mono", "Consolas", "monospace";
        color: rgba(255,255,255,.87);
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .container,
    .container > .row,
    .container > .row > div {
        height: 100%;
    }

    #countUp {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        
        .number {
            font-size: 4rem;
            font-weight: 500;
            
            + .text {
                margin: 0 0 1rem;
            }
        }
        
        .text {
            font-weight: 300;
            text-align: center;
        }
    }
  </style>

</head>
<body>
  <div class="container">
      <div class="row">
          <div class="xs-12 md-6 mx-auto">
              <!-- <div id="countUp">
                  <div class="number" data-count="404">0</div>
                  <div class="text">Page not found</div>
                  <div class="text">This may not mean anything.</div>
                  <div class="text">I'm probably working on something that has blown up.</div>
              </div> -->
              
              <div id="countUp" style="margin-top:200px;">
                  <div class="number" data-count="404">0</div>
                  <div class="text">Halaman Tidak Ditemukan.</div>
                  <div class="text"><a href="" onclick="window.history.go(-1);">Back</a></div>
              </div>
          </div>
      </div>
  </div>            
  

            

    <script>
    var formatThousandsNoRounding = function(n, dp){
      var e = '', s = e+n, l = s.length, b = n < 0 ? 1 : 0,
          i = s.lastIndexOf(','), j = i == -1 ? l : i,
          r = e, d = s.substr(j+1, dp);
      while ( (j-=3) > b ) { r = '.' + s.substr(j, 3) + r; }
      return s.substr(0, j + 3) + r + 
        (dp ? ',' + d + ( d.length < dp ? 
            ('00000').substr(0, dp - d.length):e):e);
    };

    var hasRun = false;

    // inView('#countUp').on('enter', function() {
    //     if (hasRun == false) {
    //         $('.number').each(function() {
    //             var $this = $(this),
    //                 countTo = $this.attr('data-count');

    //             $({ countNum: $this.text()}).animate({
    //                 countNum: countTo
    //             },
    //             {
    //                 duration: 2000,
    //                 easing:'linear',
    //                 step: function() {
    //                     $this.text(formatThousandsNoRounding(Math.floor(this.countNum)));
    //                 },
    //                 complete: function() {
    //                     $this.text(formatThousandsNoRounding(this.countNum));
    //                 }
    //             });
    //         });
    //         hasRun = true;
    //     }
    // });
    </script>

    <!-- jQuery 3 -->
    <script src="<?=base_url();?>assets/plugin/lte/bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

		<!-- dataTable -->
		<script type='text/javascript' src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script type='text/javascript' src="<?=base_url();?>assets/js/dataTables.bootstrap.min.js"></script>

		<!-- formvalidate -->
		<!-- tidak ada di folder source -->
		<!-- <script src="<.?=base_url();?>assets/plugin/jquery-validation-1.17.0/dist/jquery.validate.js"></script>
		<script src="<.?=base_url();?>assets/plugin/jquery-validation-1.17.0/dist/jquery.validate.min.js"></script> -->


		<!-- JQUERY-UI -->
		<script src="<?=base_url();?>assets/plugin/jquery-ui-1.12.1/jquery-ui.js"></script>

		<!-- Select2 -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/select2/dist/js/select2.full.min.js"></script>
		<!-- iCheck -->
		<!-- <script src="<.?=base_url();?>assets/plugin/lte/plugins/iCheck/icheck.js"></script> -->
		<script src="<?=base_url();?>assets/plugin/lte/plugins/iCheck/icheck.min.js"></script>
		<!-- InputMask -->
		<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.js"></script>
		<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
		<script src="<?=base_url();?>assets/plugin/lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
		<!-- date-range-picker -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/moment/min/moment.min.js"></script>
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- bootstrap time picker -->
		<script src="<?=base_url();?>assets/plugin/lte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
		<!-- bootstrap color picker -->


		

		<script src="<?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/dist/sweetalert2.all.min.js"></script>
		<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
		<!-- <script src="<.?=base_url();?>assets/plugin/lte/plugins/sweetalert2-7.32.2/package/web/promise-polyfill.js"></script> -->

		<!-- ChartJS -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/chart.js/Chart.js"></script>
		<!-- FastClick -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?=base_url();?>assets/plugin/lte/dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?=base_url();?>assets/plugin/lte/dist/js/demo.js"></script>
		<!-- CK Editor -->
		<script src="<?=base_url();?>assets/plugin/lte/bower_components/ckeditor/ckeditor.js"></script>
    <!--\LTE -->



    <!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script> -->
    <script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/numeral.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/lodash.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/jquery.redirect.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/plugin/lte/else/PDFObject-master/pdfobject.min.js"></script>

    <script type='text/javascript' src="<?=base_url();?>assets/js/library.js"></script>
    <script type='text/javascript' src="<?=base_url();?>assets/js/site_lte.js"></script>	

  </body>
</html>