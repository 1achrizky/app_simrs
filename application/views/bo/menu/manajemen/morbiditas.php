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
    <section class="content-header" style="height:70px;"><h2 class="bold">MORBIDITAS RAWAT INAP</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <div class="form-inline">
            <input type="text" name="tgl_start" class="form-control datepicker" autocomplete="off">
            <span> - </span>
            <input type="text" name="tgl_end" class="form-control datepicker" autocomplete="off">

            <button type="button" class="btn btn-info btn-flat" name="btn_ld_morbiditas">
              <i class="fa fa-arrow-circle-right"></i>
            </button>
          </div>

           <div class="box box-success" style="border-top-color: #117d70;">
	            <div class="box-header" style="text-align: center;">
	            	<h3 class="box-title" style="font-size:16pt;">10 Besar Morbiditas Rawat Inap</h3>
	            </div>
	            <div class="box-body" name="tbl_select_kunjunganri_px_dx_top10_by_rangehari"></div>
	        </div>
        </div>

        <div class="col-md-6">
			<!-- <div class="form-inline">
	            <input type="text" name="tgl_start" class="form-control datepicker-bln">
	            <span> - </span>
	            <input type="text" name="tgl_end" class="form-control datepicker-bln">

	            <button type="button" class="btn btn-info btn-flat" name="btn_ld_morbiditas">
	              <i class="fa fa-arrow-circle-right"></i>
	            </button>
          	</div> -->

          	<div class="form-inline">
	            <input type="text" name="kode_icd" class="form-control" placeholder="kode/ket icd...">
	            <select name="sel_icd" class="form-control"></select>
	            <input type="text" name="thn_icd" class="form-control" placeholder="tahun...">
	            <button type="button" class="btn btn-info btn-flat" name="btn_ld_grf_line_morbiditas">
	              <i class="fa fa-arrow-circle-right"></i>
	            </button>
          	</div>

           	<div class="box box-success" style="border-top-color: #117d70;">
	            <div class="box-header" style="text-align: center;">
	            	<h3 class="box-title" style="font-size:16pt;">Grafik Morbiditas 1 Tahun</h3>
	            </div>
	            <div class="box-body" name="grf_line_morbiditas_1th_1icd"></div>
	        </div>
        </div>
        
      </div>

      <div class="row">
        <!-- ------------------------------------------------- RAWAT INAP ------------------------------------------------- -->

        <div class="col-md-6">
          <!-- <h3 class="box-title" style="text-align: center;font-weight: bold;">MORBIDITAS</h3> -->
          <!-- <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Rincian Tiap Penanggung</h3><br>
              <h3 class="box-title" style="font-size:16pt;">Total : <span name="tot_rincian_grf_donat_kunjunganri_penanggung_rangehari"></span></h3>
            </div>
            <div class="box-body" name="grf_donat_kunjunganri_px_penanggung_by_rangehari"></div>
            <div class="box-body with-border" name="grf_donat_kunjunganri_px_penanggung_by_rangehari_legend"></div>

          </div> -->


	       


        </div>



      </div>

          

    </section>
  </div>