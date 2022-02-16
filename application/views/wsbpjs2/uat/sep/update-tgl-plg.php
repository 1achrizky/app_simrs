<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <br>
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Update Tanggal Pulang Pasien BPJS</h3>
            </div>
            <div class="box-body">
              <form action="<?=base_url('wsbpjs2/');?>" name="frmUpdateTglPlg" method="POST">
                <table class="table table-borderred table-striped">
                  <tr>
                    <td>Nosep</td>
                    <td><input name="nosep" type="text" class="form-control" autocomplete="off" /></td>
                  </tr>
                  <tr>
                    <td>Tanggal SEP</td>
                    <td><input name="tglSepV" type="text" class="form-control" disabled="disabled"/></td>
                  </tr>
                  <input name="tglSep" type="hidden" value="">
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td><input name="nama" type="text" class="form-control" disabled="disabled"/></td>
                  </tr>
                  <tr>
                    <td>Status Kecelakaan</td>
                    <td>
                      <input name="statusKecelakaanV" type="text" class="form-control" disabled="disabled"/>
                      <input name="kdStatusKecelakaan" type="hidden" value=""/>
                    </td>
                  </tr>
                  <tr>
                    <td>Tgl.Pulang</td>
                    <td><input name="tglPulang" type="text" class="form-control datepicker" value="<?=date('Y-m-d')?>" /></td>
                  </tr>
                  <tr>
                    <td>Status Pulang</td>
                    <td>
                      <select name="statusPulang">
                        <option value="">-- pilih --</option>
                        <option value="1">Atas Persetujuan Dokter</option>
                        <option value="3">Atas Permintaan Sendiri</option>
                        <option value="4">Meninggal</option>
                        <option value="5">Lain-lain</option>
                      </select>
                    
                    </td>
                  </tr>
                  <tr>
                    <td>No.Surat Meninggal</td>
                    <td><input name="noSuratMeninggal" type="text" class="form-control"/></td>
                  </tr>
                  <tr>
                    <td>Tgl.Meninggal</td>
                    <td><input name="tglMeninggal" type="text" class="form-control datepicker" value="<?=date('Y-m-d')?>" /></td>
                  </tr>
                  <tr>
                    <td>No.Laporan Polisi (SEP KLL)</td>
                    <td><input name="noLPManual" type="text" class="form-control"/></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <!-- <button id="btn_upd_tgl_plg" class="btn btn-success">UPDATE</button> -->
                      
                      <input type="submit" name="updateTglPlg" value="UPDATE" class="btn btn-warning">
                    </td>
                  </tr>
                </table>
              </form>
              

            </div>
          </div>

        </div>

      </div>


    </section>
  </div>