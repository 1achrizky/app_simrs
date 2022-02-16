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
    <section class="content-header" style="height:70px;"><h2 class="bold">EFISIENSI HUNIAN TEMPAT TIDUR</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">

        <div class="col-md-6">
          	<div class="form-inline">
	            <input type="text" name="date_hunian_1bln" class="form-control datepicker-bln" placeholder="yyyy-mm..." autocomplete="off">
	            <button type="button" class="btn btn-info btn-flat" name="btn_tbl_hunian_1bln">
	              <i class="fa fa-arrow-circle-right"></i>
	            </button>

              <button type="button" class="btn btn-success btn-flat" name="btn_simpan_efihuni_1bln">
                SIMPAN
              </button>              

          	</div>

           	<div class="box box-success" style="border-top-color: #117d70;">
	            <div class="box-header" style="text-align: center;">
                <!-- (1 Bulan) -->
	            	<h3 class="box-title" style="font-size:16pt;">Efisiensi Hunian <span name="efi_huni_date"></span></h3>
	            </div>
	            
              <div class="box-body" name="tbl_select_hunian_1bln"></div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-inline">
              <!-- <button type="button" class="btn btn-warning btn-flat" name="btn_ld_db_efihuni_1bln">
                LOAD DATABASE
              </button> -->

              <button type="button" class="btn btn-success btn-flat" name="btn_dl_xls_efihuni_1bln">
                Excel
                <i class="fa fa-arrow-circle-down"></i>
              </button>

            </div> 

            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Data Statistik <span name="efi_huni_date"></span></h3>
              </div>
              
              <div class="box-body" name="tbl_dt_statistik_hunian_1bln"></div>
            </div>
        </div>
        
      </div>

          

    </section>
  </div>