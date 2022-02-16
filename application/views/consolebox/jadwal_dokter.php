<section class="content">      
  <div class="box box-info main-console"  style="margin-top:115px;">
    <div class="box-header with-border text-center" style="padding-bottom:0px;">
      <h1 class="box-title title-console">Jadwal Dokter</h1>
    </div>
    <div class="box-body" style="padding-top:0px;">
      <style>
      .nav-tabs>li>a{
        font-weight:bold;
        text-align:center;
        /* padding-left:50px;
        padding-right:50px; */
      }
      .nav-tabs>li{
        width:16%;
      }
      </style>

        <div class="row">
          <div class="col-md-12">

            <div class="nav-tabs-custom  main-console">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">SENIN</a></li>
                <li><a href="#tab_2" data-toggle="tab">SELASA</a></li>
                <li><a href="#tab_3" data-toggle="tab">RABU</a></li>
                <li><a href="#tab_4" data-toggle="tab">KAMIS</a></li>
                <li><a href="#tab_5" data-toggle="tab">JUM'AT</a></li>
                <li><a href="#tab_6" data-toggle="tab">SABTU</a></li>
                
              </ul>
              <div class="tab-content">
              <?php
                $on_jadok = $onload['jadok'][0]['data'];
                $jadok = [];
                for ($i=0; $i < count($onload['jadok'][0]['data']); $i++) { 
                  $hr = [];
                  for ($j=0; $j < count($onload['jadok'][0]['data'][$i]['dt_hr']); $j++) { 
                    $hr[] = $onload['jadok'][0]['data'][$i]['dt_hr'][$j];
                  }
                  $jadok[] = $hr;
                }
                
                // echo "<pre>",print_r($jadok),"</pre>";

                function table_return($hr=0, $jadok=null){
                  $tbl_header = '
                    <div style="width:750px;margin:0px auto;">
                        <table class="table table-striped table-bordered datatable_simple">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Hari</th>
                              <th>Spesialis</th>
                              <th>Nama Dokter</th>
                              <th>Jam Praktek</th>
                            </tr>
                          </thead>
                          <tbody>
                        ';

                  $tbl_footer = '
                        </tbody>
                      </table>
                    </div>
                    ';

                  $trs='';
                  // $hr = 0;
                  for ($h=0; $h < count($jadok[$hr]); $h++) { 
                    $trs .= '<tr>'
                      .'<td>'.($h+1).'.</td>'
                      .'<td>'.$jadok[$hr][$h]['hari'].'</td>'
                      .'<td>'.$jadok[$hr][$h]['Spesialis'].'</td>'
                      .'<td>'.$jadok[$hr][$h]['Nama'].'</td>'
                      .'<td>'.$jadok[$hr][$h]['jamMasuk'].'-'.$jadok[$hr][$h]['jamPulang'].'</td>'
                      .'</tr>';
                  }

                  $table = $tbl_header.$trs.$tbl_footer;
                  return $table;
                }
              ?>

                <div class="tab-pane active" id="tab_1">                    
                  <?=table_return(0, $jadok); ?>                      
                </div>
                
                <div class="tab-pane" id="tab_2">
                  <?=table_return(1, $jadok); ?>
                </div>
                
                <div class="tab-pane" id="tab_3">
                  <?=table_return(2, $jadok); ?>
                </div>
                
                <div class="tab-pane" id="tab_4">
                  <?=table_return(3, $jadok); ?>
                </div>
                
                <div class="tab-pane" id="tab_5">
                  <?=table_return(4, $jadok); ?>
                </div>
                
                <div class="tab-pane" id="tab_6">
                  <?=table_return(5, $jadok); ?>
                </div>

                
                
              </div>
              
            </div>
            
          </div>
          


        </div>
        <!-- /.row -->
        <!-- END CUSTOM TABS -->
    </div>
  </div>

</section>
  