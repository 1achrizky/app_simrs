<style>
  html, body { height: 100%; margin: 0; background: #eeffff;}

.container{
	font-weight: bold;
	//height: 100vh;
	width: 100%;
	//background:#eaeaea;
	padding-top: 20px;
}
.labelPilih{
	height:20vh;
	line-height: 15vh;
	background:yellow;
	text-align: center;
	font-weight: bold;
}

h4{
	font-size: 26pt;
	margin-top: 50px;
	font-weight: bold;
}

select{
	margin:5px 0px;
}

select.form-control{
	width:calc(100% - 20px);
}

select option{
	width:200px;
}

input[name=pasienRscm_norm]{
	width:150px;
	margin:10px 10px;

}

select[name=hh_in].form-control, 
select[name=mm_in].form-control,
select[name=hh_out].form-control, 
select[name=mm_out].form-control{
	width: 70px;
}

table[name=tblFormJadok]{
	margin:0px auto;
}


table[name=tblFormJadok] tr td{
	height:52px;
}

table[name=tblFormJadok] td span{
	padding: 0px 10px;
}

table[name=tblFormJadok] td:nth-child(1){
	width:150px;
	text-align: right;
	padding-right: 15px;
}

table[name=tblFormJadok] td:nth-child(2){
	text-align: left;
	padding-left: 15px;
}

table[name=tblFormJadok] td[name=jam_selesai]{
	//background-color: yellow;
	//height: 60px;
}

table[name=tblFormJadok] td[name=jam_mulai] select,
table[name=tblFormJadok] td[name=jam_mulai] span{
	float: left;
}

table[name=tblFormJadok] td[name=jam_selesai] select.modewaktu,
table[name=tblFormJadok] td[name=jam_selesai] span.modewaktu{
	float: left;
}

table[name=tblFormJadok] td[name=jam_mulai] span,
table[name=tblFormJadok] td[name=jam_selesai] span{
	//vertical-align: middle; margin-top: 15px;
}

button[name=simpan_jadok]{
	display: block;
	margin:0px auto;
	text-align: center;
	width:100%;
}

/*==================== TABEL JADWAL DOKTER ==================*/

table[name=tbl_jadok]{
	margin:0px auto;
}


table[name=tbl_jadok] td span{
	padding: 0px 10px;
}
/*menghapus <TD name=no/hariId>
table[name=tbl_jadok] th:nth-child(1), 
table[name=tbl_jadok] td:nth-child(1){ /\*No*\/
	width:25px;
	text-align: center;
}
*/
table[name=tbl_jadok] th:nth-child(1),
table[name=tbl_jadok] td:nth-child(1){ /*Hari*/
	width:70px;
	text-align: center;
}

table[name=tbl_jadok] th:nth-child(2),
table[name=tbl_jadok] td:nth-child(2){ /*Poli Spesialis*/
	width:200px;
	text-align: center;
}

table[name=tbl_jadok] th:nth-child(3){
	width:250px;
	text-align: center;
}
table[name=tbl_jadok] td:nth-child(3){ /*Nama Dokter*/
	width:250px;
	text-align: left;
}

table[name=tbl_jadok] th:nth-child(4),
table[name=tbl_jadok] td:nth-child(4){ /*Jam Praktek*/
	width:120px;
	text-align: center;
}

table[name=tbl_jadok] th:nth-child(5),
table[name=tbl_jadok] td:nth-child(5){ /*OPSI*/
	width:100px;
	text-align: center;
}

table[name=tbl_jadok] button{
	//height:20px;
	padding:0px 10px;
}

#li_jadok tbody tr:hover {
    /* softgrey: #ccc; */
    /* tosca: #00f0c4; */
    color: #f33;
    background-color: #fee;
}

#li_jadok thead tr th{
  text-align:center;
  background-color: yellow;

}
/*====================\TABEL JADWAL DOKTER ==================*/
</style>

<div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3></h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-4">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Entry Jadwal Dokter</h3>
            </div>
            <div class="box-body">
              
              <table name="tblFormJadok" border=1>
                <tr>
                  <td width="150px">Nama Dokter</td>
                  <td width="400px">
                    <select name="nama_dokter" class="form-control">
                      <option value="-">-- Pilih Dokter --</option>
                      <?php
                        for ($i=0; $i < count($dokter); $i++) { 
                          echo '<option value="'.$dokter[$i]['Kode'].'" data-poli="'.$dokter[$i]['Keterangan'].'">'
                            .$dokter[$i]['Nama'].'</option>';
                        }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="150px">Kode Dokter</td>
                  <td width="300px" name="kode_dokter">-</td>
                </tr>
                <tr>
                  <td>Poli</td>
                  <td name="lokasi">-</td>
                </tr>
                <tr>
                  <td>Hari</td>
                  <td><select name="hari" class="form-control">
                      <option value="-">-- Pilih Hari --</option>
                      <?php
                      $hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
                      for ($i=0; $i < count($hari); $i++) 
                        echo '<option value="'.$hari[$i].'" data-arr_id="'.$i.'">'.$hari[$i].'</option>';
                      
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Jam Mulai</td>
                  <td name="jam_mulai">
                    <select name="hh_in" class="form-control">
                      <?php
                      for($i=0;$i<24;$i++){
                        if($i<10) $i='0'.$i;
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                      ?>
                    </select>
                    <span>:</span>
                    <select name="mm_in" class="form-control">
                      <?php
                      for($i=0; $i<=45; $i+=15){
                        if($i==0) $i='00';
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Jam Selesai
                    <input type="checkbox" name="cbox_selesai" value="selesai" title="*Centang bila SELESAI">
                  </td>
                  <td name="jam_selesai">
                    
                    <!-- 
                    <input type="text" id="timepicker-one" name="timepicker-one" class="timepicker"/> -->
                  </td>
                </tr>
              </table>
              <br>
              <button class="btn btn-primary" name="simpan_jadok" id="simpan_jadok"> SIMPAN </button>
              
              <br><br>
            </div>
            

          </div>
        </div>



        <div class="col-md-8">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">Tabel Jadwal Dokter</h3>
              <button id="btn_cetak" class="btn btn-info" style="margin-left:20px;">Cetak</button>
            </div>
            <div class="box-body">
              <div style="overflow-y: auto; height:500px;  overflow-x: scroll; width:100%;">
                <!-- <table class="table table-bordered table-stripped"> -->
                <table id="li_jadok" border=1 style="width:100%;">
                  <thead>
                    <tr>
                      <th>Hari</th>
                      <th>Poli Spesialis</th>
                      <th>Nama Dokter</th>
                      <th>Jam Praktek</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $el = '';
                      $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
                      $chari = [0, 0, 0, 0, 0, 0];
                       

                      for ($i=0; $i < count($jadok_tampil); $i++) { 
                        for ($h=0; $h < count($hari); $h++) { 
                          if($jadok_tampil[$i]['hari'] == $hari[$h]) $chari[$h]++;
                        }
                      }
                      // $chari = [17, 17, 18, 18, 15, 9];


                      $rspan = [0, 0, 0, 0, 0, 0];
                      for ($r=0; $r < count($chari); $r++) { 
                        // for ($s=0; $s <= $r; $s++) { 
                        for ($s=0; $s < $r; $s++) { 
                          $rspan[$r] += $chari[$s];
                        }
                      }


                      $c = 0;
                      $rowspan = '';
                      for ($i=0; $i < count($jadok_tampil); $i++) { 
                        
                        if(in_array($i, $rspan)) {
                          $rowspan = '<td rowspan="'.$chari[$c].'">'.$jadok_tampil[$i]['hari'].'</td>';
                          $c++;                            
                        }else{
                          $rowspan = '';
                        }

                        $el .= '<tr>'
                            .$rowspan
                            // .'<td>'.$i.'</td>'
                            .'<td>'.$jadok_tampil[$i]['Spesialis'].'</td>'
                            .'<td>'.$jadok_tampil[$i]['Nama'].'</td>'
                            .'<td>'.$jadok_tampil[$i]['jamMasuk'].' - '.$jadok_tampil[$i]['jamPulang'].'</td>'
                            .'<td style="text-align:center;"><button class="btn_del btn-danger" data-id="'.$jadok_tampil[$i]['Id'].'" style="margin:2px auto;">x</button></td>'
                          .'</tr>';
                                        
                      }
                      echo $el;
                    ?>
                  </tbody>
                </table>

                
              </div>

            </div>
          </div>
        </div>
        
        <?php 
          //echo "<pre>",print_r($chari),"</pre>";
          // echo "<pre>",print_r($rspan),"</pre>";                
          // echo "<pre>",print_r($jadok_tampil),"</pre>";
          // echo "<pre>",print_r($dokter),"</pre>";
        ?>

        
      
      </div>

      <!-- <div>
      <iframe name="my-iframe" src="<.?=base_url("main/popup_print?filename=jadwal-dokter");?>" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe>
      </div> -->

      <div id="div_frame"></div>

    </section>
  </div>

  

