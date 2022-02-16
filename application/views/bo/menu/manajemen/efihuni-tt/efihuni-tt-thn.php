   <!-- Styles -->
    <style>
    #chartdiv {
      width: 90%;
      height: 500px;
      /*width: 300px;
      height: 500px;*/
    }

    .bold{
      font-weight: bold;
    }

    </style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">EFISIENSI HUNIAN TEMPAT TIDUR TAHUNAN</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="form-inline">
            <input type="text" name="date_hunian_1bln" class="form-control datepicker-bln" placeholder="tahun..." autocomplete="off">
            <button type="button" class="btn btn-info btn-flat" name="btn_ld_grf">
              <i class="fa fa-arrow-circle-right"></i>
            </button>            
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Tabel Efisiensi Hunian Tahun - <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="tbl_efihuni_1th"></div>

            </div>
        </div>        
      </div>

      <div class="row">
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik BOR <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_BOR"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_BOR_legend"></ul>                
              </div>

            </div>
        </div>

 
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik LOS <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_LOS"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_LOS_legend"></ul>                
              </div>

            </div>
        </div>
        
      </div>


      <div class="row">
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik TOI <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_TOI"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_TOI_legend"></ul>                
              </div>
            </div>
        </div>
 
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik BTO <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_BTO"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_BTO_legend"></ul>                
              </div>
            </div>
        </div>        
      </div>

      <div class="row">
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik GDR <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_GDR"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_GDR_legend"></ul>                
              </div>
            </div>
        </div>

 
        <div class="col-md-6">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Grafik NDR <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="grf_line_NDR"></div>

              <div class="box-footer with-border">
                <ul class="list-inline" name="grf_line_NDR_legend"></ul>                
              </div>
            </div>
        </div>
        
      </div>

          

    </section>
  </div>