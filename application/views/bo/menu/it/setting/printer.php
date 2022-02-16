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
    <section class="content-header" style="height:70px;"><h2 class="bold">SETTING PRINTER</h2></section>
    <!-- Main content -->
    <section class="content">
    <input type="text" class="datepicker form-control" name="StartDate" value="<?=date('Y-m-d');?>">
      <div class="row">
        <div class="col-md-5">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">TAMBAH LABEL PRINTER</h3>
              </div>
              
              <div class="box-body" name="">
                <input type="text" id="in_printer_baru" style="width:100%;"> <br><br>
                <button id="btn_add_printer" class="btn btn-success">TAMBAH</button>
              </div>

            </div>

          
        </div>
        
        
        <div class="col-md-7">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">UPDATE PRINTER</h3>
              </div>
              
              <div class="box-body" name="">
                <table class="table table-bordered">
                  <tr>
                    <td>LABEL PRINTER</td>
                    <td><select id="sel_label_printer" class="form-control">
                          <option value="">-pilih-</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td>NAMA PRINTER</td>
                    <td>
                      <?php
                        //////$getprt = printer_list(PRINTER_ENUM_LOCAL);
                        //$getprt = printer_list(PRINTER_ENUM_SHARED);
                        $getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
                        $printers = serialize($getprt);
                        $printers = unserialize($printers);
                        //Menampilkan List Printer
                        echo '<select id="sel_nama_printer" class="form-control">';
                        echo '<option value="">-pilih-</option>';
                        // foreach ($printers as $PrintDest)
                        //     //echo "<option value='" . $PrintDest["NAME"] . "'>" . explode(",", $PrintDest["DESCRIPTION"])[1] . "</option>";
                        //     // echo "<option value='" .$PrintDest["NAME"]. "'>" .$PrintDest["NAME"]. "</option>"; // LAST 2020.06.08
                        //     echo "<option value='" .str_replace('\\', '_', $PrintDest["NAME"]). "'>" .$PrintDest["NAME"]. "</option>";
                        // echo '</select>';
                      ?>
                    </td>
                  </tr>
                  <tr colspan=2>
                    <td><button id="btn_update_printer" class="btn btn-success">UPDATE</button></td>
                  </tr>
                </table>

                <!--
                  SELECTOR BACKSLASH TIDAK BISA DIPILIH di JQUERY
                <select name="" id="sel">
                  <option value="aa">aa</option>
                  <option value="bb">bb</option>
                  <option value="cc" selected>cc</option>
                  <option value="//192.168.1.104/TM-P230C Series">dd</option>
                </select>
                -->
              </div>

            </div>

          
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
            <div class="box box-success" style="border-top-color: #117d70;">
              <div class="box-header" style="text-align: center;">
                <h3 class="box-title" style="font-size:16pt;">Daftar printer yang harus dikoneksikan.</h3>
              </div>
              
              <div class="box-body" id="tbl_printer">
              	<!-- <table id="tbl_printer" class="table table-bordered" style="width:600px;">
                  <tr><td>ID</td><td>LABEL PRINTER</td><td>NAMA PRINTER</td><td>OPSI</td></tr>
                </table> -->
              </div>

            </div>
        </div>        
      </div>

          

    </section>
  </div>




  
  <!-- ================ [ MODAL ] =================== -->

      <div class="modal fade" id="modal_detail" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Detail</h4>
            </div>
            <div class="modal-body" id="el_modal2">
                <table class="table table-bordered">
                  <tr>
                    <td>LABEL PRINTER</td>
                    <td id="md_label_printer"></td>
                  </tr>
                  <tr>
                    <td>NAMA PRINTER</td>
                    <td>
                      <?php
                        //////$getprt = printer_list(PRINTER_ENUM_LOCAL);
                        //$getprt = printer_list(PRINTER_ENUM_SHARED);
                        $getprt = printer_list(PRINTER_ENUM_CONNECTIONS);
                        $printers = serialize($getprt);
                        $printers = unserialize($printers);
                        //Menampilkan List Printer
                        echo '<select id="nama_printer" class="form-control">';
                        foreach ($printers as $PrintDest)
                            //echo "<option value='" . $PrintDest["NAME"] . "'>" . explode(",", $PrintDest["DESCRIPTION"])[1] . "</option>";
                            echo "<option value='" .$PrintDest["NAME"]. "'>" .$PrintDest["NAME"]. "</option>";
                        echo '</select>';
                      ?>
                    </td>
                  </tr>
                  <tr colspan=2>
                    <td><button id="btn_update_printer" class="btn btn-success">UPDATE</button></td>
                  </tr>
                </table>
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
      </div>
  <!-- ================ [ \MODAL ] =================== -->