
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h2 class="bold">Upload Artikel</h2></section>
    
    <!-- Main content -->
    <section class="content">
      	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-info">
	            <div class="box-header">
	              <h3 class="box-title">CK Editor
	                <small>Advanced and full of features</small>
	              </h3>
	              <!-- tools box -->
	              <div class="pull-right box-tools">
	                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
	                        title="Collapse">
	                  <i class="fa fa-minus"></i></button>
	                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
	                        title="Remove">
	                  <i class="fa fa-times"></i></button>
	              </div>
	              <!-- /. tools -->
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	            	<style>
	            		.input-long{
	            			width:400px;
	            		}

	            	</style>
	            	<table class="table table-stripped">
	            		<tr>
	            			<td>Judul</td>
	            			<td>: <input name="judul" type="text" class="input-long"> 
	            				<button id="create_slug">Proses URL</button>
	            			</td>	            			
	            		</tr>
	            		<tr>
	            			<td>Filename</td><td>: <input name="filename" type="text" class="input-long"></td>
	            		</tr>
	            		<tr>
	            			<td>Image Name</td><td>: <input name="imagename" type="text" class="input-long"></td>
	            		</tr>
	            		<tr>
	            			<td>Isi Artikel</td><td> <textarea name="isi_artikel" id="" cols="100" rows="6" placeholder="darurat paste sini..."></textarea></td>
	            		</tr>
						<?=slug("Waspadai Diabetes Pada Kehamilan");?></td>
	            	</table>
	            </div>
	            <div class="box-body pad">
	            	<button class="btn btn-success" id="btn_upload_artikel">Upload</button>
	              	<form>
	                    <textarea id="editor1" name="editor1" rows="10" cols="80">
	                        This is my textarea.
	                        <p>This is my textarea to be replaced with <strong>CKEditor</strong>.</p>
	                    </textarea>
	              	</form>
	            </div>
	          </div>
	          
	        </div>
    	</div>
    </section>
  </div>