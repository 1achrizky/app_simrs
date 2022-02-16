   <!-- Styles -->
    <style>
    #chartdiv {
      width: 90%;
      height: 500px;
      /*width: 300px;
      height: 500px;*/
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }

    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3>Master Clinical Pathway</h3></section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Formulir Master Kegiatan</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Nama Kegiatan</td>
                  <td>: 
                    <input name="kegiatan" type="text" style="width: 70%;" />
                    <button name="btn_insert_kegiatan">Tambah</button>
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Formulir Master Rincian Kegiatan</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Kegiatan</td>
                  <td>: 
                    <select name="sel_kegiatan" class="sel_kegiatan"></select>
                  </td>
                </tr>
                <tr>
                  <td>Nama Detail Kegiatan</td>
                  <td>: <input name="nama_det_kegiatan" type="text" /></td>
                </tr>
                <tr>
                  <td>Tarif</td>
                  <td>: <input name="tarif" type="text" /></td>
                </tr>              
                <tr>
                  <td>Keterangan</td>
                  <td>&ensp;<textarea name="indikator" cols="30" rows="4"></textarea></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="" class="btn btn-primary">Tambah</button>
                    <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                    <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>
      </div>

      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Formulir Master Clinical Pathway</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Kode</td>
                  <td>: <input name="kode" type="text" /></td>
                </tr>
                <tr>
                  <td>Nama Clinical Pathway</td>
                  <td>: <input name="cp" type="text" /></td>
                </tr>
                <tr>
                  <td>Kegiatan</td>
                  <td>: 
                    <select name="sel_kegiatan_cp" class="sel_kegiatan"></select>
                    <button name="btn_mdl_det_kegiatan">Pilih</button>
                  </td>
                </tr>
                <tr>
                  <td>Detail Kegiatan</td>
                  <td>
                    <ul>
                      <li>Detail 1</li>
                      <li>Detail 2</li>
                      <li>Detail 3</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_insert_lapIndikatorMutu" class="btn btn-primary">Tambah</button>
                    <!-- <button name="btn_update_lapIndikatorMutu" class="btn btn-warning">Edit</button> &emsp;
                    <button name="btn_delete_lapIndikatorMutu" class="btn btn-danger">Hapus</button> -->
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Master Clinical Pathway</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Nama Clinical Pathway</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              
              

            </div>
          </div>

        </div>
      </div>

          

    </section>
  </div>