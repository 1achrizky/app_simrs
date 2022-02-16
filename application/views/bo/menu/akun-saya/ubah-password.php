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
              <h3 class="box-title" style="font-size:16pt;">Ubah Password</h3>
            </div>
            <div class="box-body">
              <table class="table table-borderred table-striped">
                <tr>
                  <td>Username</td>
                  <td>: <input name="username" autocomplete="off" disabled="disabled" /></td>
                </tr>
                <tr>
                  <td>Password Lama</td>
                  <td>: <input name="pw_lama" type="text" /></td>
                </tr>
                <tr>
                  <td>Password Baru</td>
                  <td>: <input name="pw_baru" type="text" /></td>
                </tr>

                <tr>
                  <td colspan="2">
                    <button name="btn_ubah_password" class="btn btn-success">Ubah Password</button>
                  </td>
                </tr>
              </table>
              
              

            </div>
          </div>

        </div>

      </div>


    </section>
  </div>