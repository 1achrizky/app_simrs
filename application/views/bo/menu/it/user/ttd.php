
    <style>

    #content{
      width : 400px;
      height : 300px;
      margin : 10px auto;
      border : 1px dotted black;
    }

    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3 style="text-align: center;">Tanda Tangan</h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div id="content">
          <canvas id="myCanvas"></canvas>
        </div>
        <div style="text-align: center; margin-bottom: 10px;">
          <input type="text" name="kd_dokter" style="text-align: center;" placeholder="Nama file(kode dokter)...">          
        </div>
        <div style="text-align: center;">
          <button name="btn_canvas_clear" class="btn btn-danger">Bersihkan</button>
          <a name="btn_canvas_download" class="btn btn-success">Download</a>
          <a name="btn_canvas_simpan" class="btn btn-info">Simpan</a>
        </div>
          
      </div> 

      <div class="row">
        <div style="margin: 10px auto; text-align: center;">
          <?php 
          $attr = ['id' => 'frm_upload_ttd'];
          echo form_open_multipart('upload/do_upload/ttd', $attr); 
          ?> 
          <!-- <input type="text" name="kd_dokter"> -->
          <input type="file" name="gambar" style="margin:30px auto 10px;">
          <!-- <button type="submit">Upload Gambar</button> -->
          <button type="submit" id="submit_upload_img" class="btn btn-info">Upload Gambar</button>
          <!-- <button class="btn btn-info" name="btn_upload_img">Upload Gambar</button> -->
          <?php echo form_close(); ?>
        </div>      
      </div>      


    </section>
  </div>