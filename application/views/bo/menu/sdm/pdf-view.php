<style>
 
  .bold{
    font-weight: bold;
  }

  .pdfview{
    width:75%;
    height:450px;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">..</h2></section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="box box-success" style="border-top-color: #117d70;">
            <div class="box-header" style="text-align: center;">
              <h3 class="box-title" style="font-size:16pt;">File</h3>
            </div>

            <!-- <div class="box-body form-inline">
              <input type="text" id="in_datestart" class="form-control datepicker" autocomplete="off">
              &nbsp; - &nbsp;
              <input type="text" id="in_dateend" class="form-control datepicker" autocomplete="off">
              <button type="button" class="btn btn-primary btn-flat" id="btn_ld_trf_ri">
                <i class="fa fa-arrow-circle-right"></i>
              </button>
              <button type="button" class="btn btn-success btn-flat" id="btn_dl_excel">
                <i class="fa fa-download"></i> Excel
              </button>
              
            </div> -->
            <div class="box-body">
              <?php 
              $attr = ['id' => 'frm_upload_pdf'];
              echo form_open_multipart('upload/upload_pdf/', $attr); 
              ?> 

              <input type="file" name="myfile" style="margin:30px auto 10px;">
              <button type="submit" id="submit_upload" class="btn btn-info">Upload</button>
              <?php echo form_close(); ?>
            </div>

            <div class="box-body" id="main_body">



              Dan berikut ini adalah file :
              <a class="media" target="_blank" href="<?php echo base_url('uploads/hrd/pdf/tutorial-awal-dengan-zend-framework_123'); ?>.pdf">klik</a>

              <div id="viewpdf" class="pdfview"></div>
              
              <hr>
              
              <iframe class="pdfview" src="<?php echo base_url('uploads/hrd/pdf/tutorial-awal-dengan-zend-framework_123'); ?>.pdf" frameborder="0">
                <html>
                  <body>
                      <object type="application/pdf">
                          <embed type="application/pdf" />
                      </object>
                  </body>
                  </html>
              </iframe>
              
              
            </div>
          </div>
        </div>
      </div>


      <div class="box-body" id="modal_list"></div>

    </section>
  </div>