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
    <section class="content-header" style="height:70px;"><h2 class="bold">User Akses Page</h2></section>
    <!-- Main content -->
    <section class="content">
            
      <div class="row">

        <div class="col-md-6">
          
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tambah Halaman</h3>
            </div>
            <div class="box-body" name="tbl_user_setting">
              <table class="table table-stripped">
                <tr>
                  <td>Nama menu</td>
                  <td><input type="text" id="menu_name" class="form-control"></td>
                </tr>
                <tr>
                  <td>URL</td>
                  <td><input type="text" id="url" class="form-control"></td>
                </tr>
                <tr>
                  <td>Sort</td>
                  <td><input type="text" id="sort" class="form-control"></td>
                </tr>
                <tr>
                  <td>Icon Name</td>
                  <td><input type="text" id="icon_name" class="form-control"></td>
                </tr>
                <tr>
                  <td>Icon Color</td>
                  <td><input type="text" id="icon_color" class="form-control"></td>
                </tr>
                <tr>
                  
                <tr>
                  <td colspan="2">
                    <button id="btn_add_page" class="btn btn-primary">Tambah</button>
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
              <h3 class="box-title" style="font-size:16pt;">Akses Halaman</h3>
            </div>
            <div class="box-body">
              <div class="form-inline">
                USER EXCEPTION: 
                <select id="sel_user_exc" class="select2 form-control" style="width:200px;">
                  <option value="">-pilih-</option>
                  <?php
                    for ($u=0; $u < count($user); $u++) { 
                      echo '<option value="'.$user[$u]['userlogin'].'">'.$user[$u]['userlogin'].'</option>';
                    }
                  ?>
                </select>
                <br>
                <button class="btn btn-warning" id="btn_simpan_akses_user_exc">Simpan</button>
                <button class="btn btn-danger" style="margin-left:10px; margin-top:5px;" id="btn_hapus_akses_user_exc">Hapus</button>
                
              </div>
              <hr>
              
              <div class="form-inline">
                LEVEL: 
                <select id="sel_level" class="select2 form-control" style="width:100px;">
                  <option value="">-pilih-</option>
                <?php
                  for ($u=0; $u < count($level); $u++) { 
                    echo '<option value="'.$level[$u]['level'].'">'.$level[$u]['level'].'</option>';
                  }
                ?>
                </select>
                <button class="btn btn-success" id="btn_simpan_akses2">Simpan</button>
                

              </div>
              <textarea id="txtUser" cols="30" rows="3" disabled="disabled"></textarea>

              
              <!-- <form id="frm_akses" action="">
                <input type="submit" value="submit"> -->

                <div style="overflow-y: auto; height:500px;">
                
                  <table id="tbl_akses_halaman" class="table table-stripped">
                    <thead><tr>
                        <th>NO.</th>
                        <th>ID</th>
                        <th>SORT</th>
                        <th>HALAMAN</th>
                        <th>AKSES</th>
                      <tr></thead>
                    <tbody>
                      <?php
                      for ($i=0; $i < count($menu); $i++) { 
                        $title = '';
                        $url = '';
                        if($menu[$i]['url'] == null) $title = $menu[$i]['title'];
                        else $title = '<a href="'.$menu[$i]['url'].'">'.$menu[$i]['title'].'</a>';
                        echo '<tr data-index="'.$i.'" data-sort="'.$menu[$i]['sort'].'">'.
                          '<td>'.($i+1).'.</td>'.
                          '<td>'.$menu[$i]['id'].'</td>'.
                          '<td>'.$menu[$i]['sort'].'</td>'.
                          '<td>'.$title.'</td>'.
                          '<td><input type="checkbox" id="cbox_'.$menu[$i]['id'].'" data-index="'.$i.'" data-id="'.$menu[$i]['id'].'" data-sort="'.$menu[$i]['sort'].'"></td>'.                    
                        '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                
                </div>

              <!-- </form> -->
              
            </div>
          </div>



        </div>


      </div>
      
      <?php echo "<pre>",print_r($menu),"</pre>";?>
          

    </section>
  </div>