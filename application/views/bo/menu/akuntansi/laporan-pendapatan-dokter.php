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
    <section class="content-header" style="height:70px;"><h2 class="bold">LAPORAN PENDAPATAN DOKTER</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="form-inline" style="margin-bottom: 10px;">
            <input type="text" name="tgl_start" class="form-control datepicker" placeholder="tgl start...">
            <span> - </span>
            <input type="text" name="tgl_end" class="form-control datepicker" placeholder="tgl end...">
            
            <button type="button" class="btn btn-info btn-flat" name="btn_ld_dokter">
              Load Dokter <i class="fa fa-arrow-circle-right"></i>
            </button>
            <!-- <button type="button" class="btn btn-success btn-flat" name="btn_download_pendapatan_dokter_all">
              Download Excel ALL <i class="fa fa-arrow-circle-down"></i>
            </button> -->
          </div>

          
          
          <div class="form-inline" style="margin-bottom: 10px;">            
            <select name="sel_dokter" class="form-control select2">
              <option value="">- pilih dokter -</option>
            </select>

            <select name="sel_penanggung" class="form-control">
              <option value="bpjs">BPJS</option>
              <option value="nonbpjs">NON BPJS</option>
            </select>

            <button type="button" class="btn btn-info btn-flat" name="btn_ld_pendapatan_dokter">
              <i class="fa fa-arrow-circle-right"></i>
            </button>
            <button type="button" class="btn btn-success btn-flat" name="btn_download_pendapatan_dokter">
              Download Excel <i class="fa fa-arrow-circle-down"></i>
            </button>
          </div>

           <div class="box box-success" style="border-top-color: #117d70;">
	            <div class="box-header" style="text-align: center;">
	            	<h3 class="box-title" style="font-size:16pt;">Tabel Laporan Pendapatan Dokter</h3>
	            </div>
              <!-- <div class="box-body" name="tbl_select_kunjunganri_px_dx_top10_by_rangehari"></div> -->
	            <div class="box-body" name="">
                <table class="table table-bordered table-striped" name="tbl_select_laporan_pendapatan_dokter">
                  <!-- <thead>
                    <tr>
                      <th colspan="11" style="text-align: center;"><h4 style="font-weight: bold;">PANTAUAN TARIF</h4></th>
                    </tr>                  
                  </thead> -->
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>TANGGAL</th>
                      <th>NOBILL</th>
                      <th>NO.BUKTI</th>
                      <th>KODE</th>
                      <th>DOKTER</th>
                      <th>TINDAKAN</th>
                      <th>NAMA PASIEN</th>
                      <th>BRUTO</th>
                      <th>PPH</th>
                      <th>NETTO</th>
                    </tr>                  
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                    <!-- <tr>
                      <th colspan="4">TOTAL BIAYA RUMAH SAKIT</th>
                      <th class="tarif_rs" style="text-align: right;">{nilai}</th>
                    </tr> -->
                    <tr>
                      <th colspan="8">GRAND TOTAL</th>
                      <th name="tot_bruto" style="text-align: right;">{nilai}</th>
                      <th name="tot_pph" style="text-align: right;">{nilai}</th>
                      <th name="tot_netto" style="text-align: right;">{nilai}</th>
                    </tr>
                    <!-- <tr>
                      <th colspan="4">TARIF INACBG</th>
                      <th style="text-align: right;">{nilai}</th>
                    </tr> -->
                  </tfoot>
                </table> 
              </div>
	        </div>
        </div>

        
      </div>

      <div class="row">
        <div class="col-md-6"></div>

      </div>

          

    </section>
  </div>