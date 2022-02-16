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

    #content{
      width : 400px;
      height : 300px;
      margin : 10px auto;
      border : 1px dotted black;
    }

    </style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header" style="height:70px;"><h3>Tanda Tangan</h3></section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div id="content">
          <canvas id="myCanvas"></canvas>
        </div>
        <div style="text-align: center;">
          <button name="btn_canvas_clear" class="btn btn-danger">Bersihkan</button>
          <a name="btn_canvas_download" class="btn btn-success">Download</a>
        </div>
          
      </div>      


    </section>
  </div>