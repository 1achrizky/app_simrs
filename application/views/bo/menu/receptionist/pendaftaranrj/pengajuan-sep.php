<div class="content-wrapper">
    <!-- <section class="content-header" style="height:70px;"><h3></h3></section> -->

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Pengajuan SEP</h3>
            </div>
            <div class="box-body">

              <!-- <form action="<.?=base_url();?>ajax_bpjs11/pengajuanSep" method="POST" name="pengajuanSep"> -->
              
                <table class="table table-borderred table-striped">
                  <tr>
                    <td>Nomor Kartu BPJS</td>
                    <td><input name="noKartu" type="text" class="form-control" autocomplete="off" /></td>
                  </tr>
                  <tr>
                    <td>Tanggal SEP</td>
                    <td><input name="tglSep" type="text" class="form-control datepicker" autocomplete="off" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td><input name="nama" type="text" class="form-control" disabled="disabled"/></td>
                  </tr>
                  <tr>
                    <td>Jenis Pelayanan</td>
                    <td>
                      <!-- <input name="jnsPelayanan" type="text" class="form-control" /> -->
                      <select name="jnsPelayanan">
                        <option value="2">2. R.Jalan</option>
                        <option value="1">1. R.Inap</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Jenis Pengajuan</td>
                    <td>
                    <!-- <input name="jnsPengajuan" type="text" class="form-control" /> -->
                      <select name="jnsPengajuan">
                        <option value="1">1. pengajuan backdate</option>
                        <option value="2">2. pengajuan finger print</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td><input name="keterangan" type="text" class="form-control" /></td>
                  </tr>
                  <input type="hidden" name="user" value="16141">
                  <tr>
                    <td colspan="2">
                      <!-- <input type="submit"> -->
                      <button id="btn_ok" class="btn btn-success">PENGAJUAN</button>
                      <button id="btn_aproval" class="btn btn-info">APROVAL</button>
                    </td>
                  </tr>
                </table>
              
              <!-- </form> -->
              
              

            </div>
          </div>

        </div>

      </div>


    </section>
  </div>