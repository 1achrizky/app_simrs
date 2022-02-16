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
    <section class="content-header" style="height:70px;"><h3></h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Surat Keterangan Kematian</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>No.RM</td>
                  <td>: <input name="norm" type="number" autocomplete="off" /></td>
                </tr>
                <tr>
                  <td>Tgl. Meninggal</td>
                  <td>: <input name="tgl_meninggal" type="text" /></td>
                </tr>
                <tr>
                  <td>Kode Dokter</td>
                  <td>: <input name="kd_dokter" type="text" /></td>
                </tr>
                <tr>
                  <td>Dokter</td>
                  <td>: 
                    <select name="dokter">
                      <option value="dr. Lucky Dana Victory">dr. Lucky Dana Victory</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_dl_surat_ket_kematian" class="btn btn-success">Download Surat</button>
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>

      </div>


    </section>
  </div>