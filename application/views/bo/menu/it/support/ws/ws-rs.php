<style>
a{
  cursor:pointer;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">RUNNING WS RS</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">
        
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-body" name="tbl_lap_daftarrj">
              <div>List:
                <ol>

              <?php 

                $links = [
                  [ 
                    "PESERTA PRB RSCM BY HARI", 
                    "main/db/m_daftarmandiri/select_prb_by_date/".date('Y-m-d')
                  ],
                  [ 
                    "Cek Karakter Aneh", 
                    "main/db/m_daftarmandiri/e_char_aneh_fotrdaftar/BL".date('ymd').".0001",
                  ],
                  [ 
                    "Laporan Tarif RJ", 
                    "ajaxreq/select_laporan_px_rj_by_date/".date('Y-m-d')."/0",
                  ],
                  [ 
                    "Billing Kosong", 
                    "ajaxreq/logdaftarrj_by_key/billing-kosong/".date('Y-m-d'),
                  ],
                  [ 
                    "Billing 2 Lokasi 2 Px", 
                    "ajaxreq/db/m_daftarmandiri/error_count_bill_by_date/".date('Y-m-d'),
                  ],
                  [ 
                    "Insert POS Tindakan", 
                    "ajaxreq/insert_pos_tindakan/IGD/10/BL".date('ymd')."0001/",
                  ],
                  [ 
                    "RECORD Insert POS Tindakan", 
                    "ajaxreq/logdaftarrj_by_key/insert-pos-tindakan/",
                  ],
                ];

                for ($l=0; $l < count($links); $l++) {
                  echo '<li>'.$links[$l][0].': <a href="'.base_url().$links[$l][1].'" target="_blank">'.$links[$l][1].'</a></li>';                    
                } 

              ?>
                  
                  <!-- <li></li> -->
                </ol>
              </div>
              
              <!-- <div class="form-inline">
                <input type="text" id="param" class="form-control" style="width:500px;" autocomplete="off">

                <button type="button" class="btn btn-info btn-flat" id="btn_run_ws_bpjs">
                  RUN <i class="fa fa-arrow-circle-right"></i>
                </button>
              </div>
              
              <h3>RESULT</h3>
              <textarea id="result" cols="70" rows="10"></textarea> -->

            </div>
          </div>
        </div>


      </div>

      <div id="div_frame"></div>

          

    </section>
  </div>