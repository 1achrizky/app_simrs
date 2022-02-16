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
    <section class="content-header" style="height:70px;"><h2 class="bold">User Akses</h2></section>
    <!-- Main content -->
    <section class="content">
      
      
      <div class="row">

        <div class="col-md-6">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Registrasi User</h3>
            </div>
            <div class="box-body" name="tbl_">
              <?=form_open(base_url()."ajaxreq/tambah_user","name='tambah_user'");?>
                <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                          <div class="ui-widget">
                            <input type="text" name="noreg" class="form-control" placeholder="no.pegawai..." autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <select class="form-control" name="level">
                          <option value="">-Level Pengguna-</option>
                          <option value="Staff">Staff</option>
                          <option value="Kanit">Kanit</option>
                        </select>
                      </div> -->
                    </div>
                </div>
                <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" class="form-control" placeholder="username..." autocomplete="off" required>
                </div>
                <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="password" name="password" class="form-control" placeholder="password..." autocomplete="off" required>
                </div>             
                
                <input type="hidden" name="level" value="">
                <input type="submit" name="submit_tambah_user" class="btn btn-success btn-block" value="Tambah User">
              <?=form_close();?>
            </div>
          </div>


          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">User Akses Setting</h3>
            </div>
            <div class="box-body" name="tbl_user_setting">
              <table class="table table-stripped">
                <tr>
                  <td>Page URL(Filename)</td>
                  <td><input type="text" name="in_page_url" class="form-control"></td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td>
                    <div class="form-inline">
                      <select name="sel_user" class="select2" style="width:50%;">
                        <option value=""></option>
                      </select>
                    </div>                      
                  </td>
                </tr>
                <tr>
                  <td>Level Page</td>
                  <td>
                    <select name="sel_level_page" class="select2" style="width:50%;">
                      <option value="MEMBER">MEMBER</option>
                      <option value="MANAGER">MANAGER</option>
                    </select>
                  </td>
                </tr>                
                <tr>
                  <td>Filter Name</td>
                  <td><input type="text" name="filter_name" class="form-control"></td>
                </tr>
                <tr>
                  <td>Filter Value</td>
                  <td><input type="text" name="filter_val" class="form-control"></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_set_user_akses" class="btn btn-primary">Set User Akses</button>
                  </td>
                </tr>
              </table>
              
            </div>
          </div>
        </div>


        <div class="col-md-6">
          
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">User Akses Setting Menu</h3>
            </div>
            <div class="box-body">
                      
              <table class="table table-stripped">
                <tr>
                  <td>Filter Name</td>
                  <td name="filter_name">menu_bo_sidebar</td>
                </tr>
                <tr>
                  <td>Filter Value</td>
                  <td>
                    <!-- <select name="sel_menu" class="select2" style="width:50%;"> -->
                    <select name="sel_menu" style="width:50%;">
                      <option value=""></option>
                      <?php
                      $departments = ["it", "receptionist", "casemix", "rm", "tppri", "mutu", "hrd", "manajemen", "akuntansi" ];
                      for($i=0; $i<count($departments); $i++){
                        // echo $departments[$i];
                        echo '<option value="'.$departments[$i].'">'.$departments[$i].'</option>';
                      }
                      ?>
                      <!-- 
                      <option value="it">it</option>
                      <option value="receptionist">receptionist</option>
                      <option value="casemix">casemix</option>
                      <option value="rm">rm</option>
                      <option value="tppri">tppri</option>
                      <option value="mutu">mutu</option>
                      <option value="hrd">hrd</option>
                      <option value="manajemen">manajemen</option> -->
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button name="btn_simpan_uakses_setmenu" class="btn btn-primary" disabled="disabled">Simpan</button>
                  </td>
                </tr>
              </table>

              <!-- <table class="table table-stripped" name="tbl_user_checkbox">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th><input type="checkbox" name="chk_all_user">(Toogle Cek ALL)</th>
                  </tr>
                </thead>
                <tbody></tbody>                  
              </table> -->
              
            </div>
            
            <div class="box-body" name="tbl_user_checkbox"  style="overflow-y: auto; height:400px;"></div>

          </div>



        </div>


      </div>

          

    </section>
  </div>