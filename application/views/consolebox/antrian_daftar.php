<section class="content">      
  
        <div class="row" style="margin-top:115px;">
          <!-- <form action="#" name="form_daftar_online" method="POST"> -->
            <div class="col-md-6 col-md-offset-3">
              <div class="box box-success main-console" style="border-top-color: #117d70;">
              <!-- <div class="box box-info"> -->
                <div class="box-header" style="text-align: center;">
                  <h1 class="box-title" style="font-size:30pt;">Pengambilan <br> Antrian Pendaftaran</h1>
                </div>
                <div class="box-body">
                  <!-- <form name="frm_antrian_rc" action="<.?=base_url('print_termal/wsprinter_send/antrian_rc');?>" method="POST"> -->
                  <form name="frm_antrian_rc" action="<?=base_url('print_termal/wsprinter_send_redirect/antrian_rc');?>" method="POST">
                      <div class="row font-big">
                        <div class="col-md-8 col-md-offset-2">
                          <h1 id="number" style="font-weight:bold; font-size:70pt;text-align:center;"><?=(isset($next['nominal']))?$next['nominal']:1;?> </h1>

                        </div>
                      </div>


                      <div class="row font-big">
                        <div class="col-md-8 col-md-offset-2">
                          <button id="btn_cetak_antrian_rc" class="btn btn-lg btn-success btn-rscm" style="margin-top: 30px; font-size:30pt; width:100%;">CETAK</button>
                        </div>
                      </div>

                      <input type="hidden" name="url" value="daftarmandiri/px_cetak_antrian_rc">
                      <input type="hidden" name="button_id" value="btn_cetak_antrian_rc">
                  
                  </form>
                      

                </div>
                <div class="box-footer">
                  <!-- <button type="submit" id="btn_daftar" class="btn btn-success btn-rscm">Daftar</button> -->
                  
                  <!-- <button id="btn_cek_rjk_multi" class="btn btn-success btn-rscm">Cek Rujukan Multi</button> -->
                </div>
              </div>

            </div>
          
          <!-- </form> -->
        </div>
        <!-- /.row -->
    

</section>

<script type='text/javascript'>
  
</script>
  