  <div class="container">
    <h1>Daftar Dokter Spesialis Rumah Sakit Citra Medika</h1>
    <button class="btn btn-success" onclick="add_book()" style="margin-bottom: 10px;"><i class="glyphicon glyphicon-plus"></i> Add Book</button>
    <br/>
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>Kode</th>
					<th>Nama</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($dokter_daftar as $book){?>
          <tr>
            <td id="norm"><?php echo $book->Kode;?></td>
          	<td><a href="#" onclick="detail_pasien('<?php echo $book->Kode;?>');"><?php echo $book->Nama;?></a></td>
          	<td>
          		<button class="btn btn-warning" style="padding:1px 3px 1px;" onclick="edit_antrianPasien(<?php echo $book->Kode;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
          		<button class="btn btn-danger" style="padding:1px 3px 1px;" onclick="delete_book(<?php echo $book->Kode;?>)"><i class="glyphicon glyphicon-remove"></i></button>

          	</td>
          </tr>
				<?php }?>

      </tbody>

      <tfoot>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>

  </div>