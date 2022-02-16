

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3>Perbaikan Karakter Aneh</h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Data</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Billing</td>
                  <td>: <input name="nobill" type="text" /></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_select_billing_karakter_aneh" class="btn btn-primary">Cari Data Billing</button>
                    <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                    <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                  </td>
                </tr>
              </table>

              <span>Hasil Pencarian</span>
              <style>
                table[name=tbl_billing_karakter_aneh_val] tr td input{
                  font-family: 'courier';
                }
              </style>
              <table class="table table-borderred table-striped tbl_billing_karakter_aneh_val" name="tbl_billing_karakter_aneh_val">
                <tr>
                  <td>NORM</td>
                  <td>: <input name="norm" type="text" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>: <input name="nama" type="text" /></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>: <input name="alamat" type="text" /></td>
                </tr>
                <tr>
                  <td>RT</td>
                  <td>: <input name="rt" type="text" /></td>
                </tr>
                <tr>
                  <td>RW</td>
                  <td>: <input name="rw" type="text" /></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_update_billing_karakter_aneh" class="btn btn-warning">Edit Data Billing</button>
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>

      </div>



      <!-- ================ [ MODAL ] =================== -->

      <div class="modal fade" id="modal_mutu_edit" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Indikator Mutu: </h4>
            </div>
            <div class="modal-body" id="el_modal_mutu_edit">

                
                    <table class="table table-borderred table-striped">
                      <tr>
                        <td>Jenis Pelayanan</td>
                        <td>: 
                          <?php $jnsPelayananDivisi = array(
                            "RANAP", "ICU", "NICU", "BERSALIN", "IRJ",
                            "IKO", "IGD", "RADIOLOGI", "LAB", "GIZI", 
                            "IFRS", "SDM", "PK", "PEMASARAN", "KEUANGAN", 
                            "IPS", "RM", "PEMBELIAN&GUDANG NON MEDIS", "PPI"
                          ); ?>
                          <select name="MDEL_sel_jnsPelayananDivisi">
                            <?php 
                            foreach($jnsPelayananDivisi as $divisi){
                              echo '<option value="'.$divisi.'">'.$divisi.'</option>';
                            } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Indikator</td>
                        <td>&ensp;<textarea name="MDEL_indikator" cols="30" rows="4"></textarea></td>
                      </tr>
                      <tr>
                        <td>Standar</td>
                        <td>: <input name="MDEL_standar" type="text" /></td>
                      </tr>
                      <tr>
                        <td>Satuan</td>
                        <td>: 
                          <select name="satuanStandar">
                            <option value="">%</option>
                            <option value="">menit</option>
                            <option value="">detik</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <button name="btn_mutu_edit" class="btn btn-warning">Edit Indikator</button>
                          <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                          <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                        </td>
                      </tr>
                    </table>
                   

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- ================ [ MODAL ] =================== -->
          

    </section>
  </div>