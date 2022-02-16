<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Online RS Citra Medika</title>
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style rel="stylesheet">
      .control-label-my{
        font-weight: bold;
        text-align: right;
        padding:0 8px 0;
      }
      .form-data{
        font-weight: normal;
        padding:0 8px 0;
      }
      table tbody tr td{
        //padding:1px 2px 1px;
        padding:2px;
        font-size: 10pt;
      }
    </style>
  </head>
  <body>


  <div class="container">
    <h1>Daftar Absensi Pegawai Rumah Sakit Citra Medika</h1>
    <button class="btn btn-success" onclick="add_book()" style="margin-bottom: 10px;"><i class="glyphicon glyphicon-plus"></i> Add Book</button>
    <br/>
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>NORM</th>
					<th>No Anggota</th>
					<th>Nama</th>
					<th>Date</th>
					<th>Time</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($fotrbooking as $book){?>
          <tr>
            <td id="norm"><?php echo $book->norm;?></td>
            <td><?php echo $book->noanggota;?></td>
          	<td><a href="#" onclick="detail_pasien('<?php echo $book->norm;?>');"><?php echo $book->nama;?></a></td>
            <!-- get value by id norm -->
          	<td><?php echo $book->date;?></td>
          	<td><?php echo $book->time;?></td>
          	<td>
          		<button class="btn btn-warning" style="padding:1px 3px 1px;" onclick="edit_antrianPasien(<?php echo $book->norm;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
          		<button class="btn btn-danger" style="padding:1px 3px 1px;" onclick="delete_book(<?php echo $book->norm;?>)"><i class="glyphicon glyphicon-remove"></i></button>

          	</td>
          </tr>
				<?php }?>

      </tbody>

      <tfoot>
        <tr>
          <th>NORM</th>
          <th>No Anggota</th>
          <th>Nama</th>
          <th>Date</th>
          <th>Time</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>

  </div>

  <script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js')?>"></script>

  <script type="text/javascript">
  $(document).ready( function (){
      $('#table_id').DataTable({
        "order": [[ 3 , "desc" ],[ 4 , "desc" ]]
        //"fixedColumns.heightMatch": 30;
      });

      /*
      $("#namaPasien").click(function(){
        alert("detail");
      });*/
  } );

    var save_method; //for save method string
    var table;
    var id;


    function add_book(){
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function detail_pasien(id){
      //save_method = 'add';
      $('#formDetailPasien')[0].reset();
      //var tesUrl = " echo site_url('index.php/c_antrian/ajax_edit/')"+id;
      //alert(tesUrl);

      $.ajax({
        url : "<?php echo site_url('index.php/c_antrian/ajax_edit/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
          //alert(data.norm);
          //$('[name="normFormDetail"]').val(data.norm);
          $('[name="norm-FDetail"]').text(data.norm);
          $('[name="noAnggota-FDetail"]').text(data.noanggota);
          $('[name="nama-FDetail"]').text(data.nama);
          $('[name="penanggungket-FDetail"]').text(data.penanggungket);
          $('[name="alamat-FDetail"]').text(data.alamat);
          $('[name="lokasiket-FDetail"]').text(data.lokasiket);
          $('[name="diagnosaket-FDetail"]').text(data.diagnosaket);
          $('[name="dokterket-FDetail"]').text(data.dokterket);

          $('#modalFormDetailPasien').modal('show');
          $('.modal-title').text('Detail Pasien'); // Set title to Bootstrap modal title
          
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });
    }

    function edit_antrianPasien(id){
      ///save_method = 'update';
      $('#formEditPasien')[0].reset(); // reset form on modals
      var tesUrl = "<?php echo site_url('index.php/c_antrian/ajax_edit/') ?>"+id;
      alert(tesUrl);

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('index.php/c_antrian/ajax_edit/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){
          $('[name="norm-FDetail"]').val(data.norm);
          $('[name="noAnggota-FDetail"]').val(data.noanggota);
          $('[name="nama-FDetail"]').val(data.nama);
          $('[name="penanggungket-FDetail"]').val(data.penanggungket);
          $('[name="alamat-FDetail"]').val(data.alamat);
          $('[name="lokasiket-FDetail"]').val(data.lokasiket);
          $('[name="diagnosaket-FDetail"]').val(data.diagnosaket);
          $('[name="dokterket-FDetail"]').val(data.dokterket);

          $('#modalFormEditPasien').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Book'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });
    }
    function edit_book(id){ ////TEMP
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('index.php/book/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data){

          $('[name="book_id"]').val(data.book_id);
          $('[name="book_isbn"]').val(data.book_isbn);
          $('[name="book_title"]').val(data.book_title);
          $('[name="book_author"]').val(data.book_author);
          $('[name="book_category"]').val(data.book_category);

          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Book'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
      });
    }


    function save(){
      var url;
      if(save_method == 'add'){
          url = "<?php echo site_url('index.php/book/book_add')?>";
      }else{
        url = "<?php echo site_url('index.php/book/book_update')?>";
      }

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
              location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function delete_book(id){
      if(confirm('Are you sure delete this data?')){
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('index.php/book/book_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
            }
        });

      }
    }

  </script>

  <!-- Bootstrap modal Book -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Book Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="book_id"/>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Book ISBN</label>
                <div class="col-md-9">
                  <input name="book_isbn" placeholder="Book ISBN" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Book Title</label>
                <div class="col-md-9">
                  <input name="book_title" placeholder="Book_title" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Book Author</label>
                <div class="col-md-9">
  								<input name="book_author" placeholder="Book Author" class="form-control" type="text">

                </div>
              </div>
  						<div class="form-group">
  							<label class="control-label col-md-3">Book Category</label>
  							<div class="col-md-9">
  								<input name="book_category" placeholder="Book Category" class="form-control" type="text">

  							</div>
  						</div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End Bootstrap modal Book-->


  <!-- ===================== MODAL DETAIL PASIEN ======================== -->
  <div class="modal fade" id="modalFormDetailPasien" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Book Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="formDetailPasien" class="form-horizontal">
            <input type="hidden" value="" name="book_id"/>
            <div class="form-body">
              <div class="form-group">
                <label class="col-md-3 control-label-my">NORM</label>
                <label name="norm-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">No. Anggota</label>
                <label name="noAnggota-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">Nama</label>
                <label name="nama-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">Penanggung</label>
                <label name="penanggungket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Alamat</label>
                <label name="alamat-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Lokasi</label>
                <label name="lokasiket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Diagnosa</label>
                <label name="diagnosaket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Dokter</label>
                <label name="dokterket-FDetail" class="col-md-9 form-data"></label>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- ===================== /MODAL DETAIL PASIEN ======================= -->


  <!-- ===================== MODAL EDIT PASIEN ======================== -->
  <div class="modal fade" id="modalFormEditPasien" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Book Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="formEditPasien" class="form-horizontal">
            <input type="hidden" value="" name="book_id"/>
            <div class="form-body">
              <div class="form-group">
                <label class="col-md-3 control-label-my">NORM</label>
                <input name="norm-FDetail" class="col-md-9 form-control" type="text">
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">No. Anggota</label>
                <label name="noAnggota-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">Nama</label>
                <label name="nama-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="control-label-my col-md-3">Penanggung</label>
                <label name="penanggungket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Alamat</label>
                <label name="alamat-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Lokasi</label>
                <label name="lokasiket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Diagnosa</label>
                <label name="diagnosaket-FDetail" class="col-md-9 form-data"></label>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label-my">Dokter</label>
                <label name="dokterket-FDetail" class="col-md-9 form-data"></label>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- ===================== /MODAL EDIT PASIEN ======================= -->


  </body>
</html>
