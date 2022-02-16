  <style>
    a{ cursor: pointer; }

    .scroll-h{
      overflow-x: auto;
      white-space: nowrap;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">REKAP IRS</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">

        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header">
                <div class="form-inline">
                  <input type="text" name="th_bln" class="form-control datepicker-bln" autocomplete="off">
                  <select name="divisi" class="form-control">
                    <?php 
                    $divisi = ["RAJAL", "BERSALIN", "ICU", "IGD", "KAMAR OPERASI", "NICU", "RANAP 2", "RANAP 3"];
                    for ($i=0; $i < count($divisi) ; $i++) { 
                      echo '<option value="'.$divisi[$i].'">'.$divisi[$i].'</option>';                    
                    } 
                    ?>                  
                  </select>
                  
                  <button type="button" class="btn btn-info btn-flat" name="btn_rekap_irs">
                    <i class="fa fa-arrow-circle-right"></i>
                  </button>

                  <button type="button" class="btn btn-success btn-flat" name="btn_rekap_irs_download">
                    DOWNLOAD XLS <i class="fa fa-arrow-circle-down"></i>
                  </button>
                </div>
            </div>
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt; margin-bottom: 0px;"></h3>
            </div>
            
            <div class="box-body scroll-h" name="tbl_rekap_irs"></div>
          </div>
        </div>


      </div>          

    </section>
  </div>



  <!-- ================ [ MODAL ] =================== -->

      <div class="modal fade" id="modal_entry_irs" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Isikan Nilai Indikator</h4>
            </div>
            <div class="modal-body" id="el_modal2">

              <!-- <div class="container"> -->
                <div class="row">
                  <!-- <table name="tbl_detail_pasien" class="table table-bordered bold">
                    <tr><td class="col-xs-3">Billing    </td><td name="nobill" class="col-xs-4" style="width:300px;">-</td></tr>
                    <tr><td>NoRM    </td><td name="NoRM">-</td></tr>
                  </table>
                  <br> -->
                  <div class="col-md-12">
                    <input name="date_isi" type="text">
                    <button name="btn_simpan_irs" class="btn btn-success">SIMPAN</button>
                  </div>
                </div>
                <div class="row">
                  
                  <!-- <button name="btn_cetak_skdp" class="btn btn-warning">Cetak SKDP</button> -->
                  <!-- <button name="btn_del_bill" class="btn btn-danger">Delete Billing</button> -->
                </div>
                  

              <!-- </div> -->

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
      </div>
  <!-- ================ [ \MODAL ] =================== -->