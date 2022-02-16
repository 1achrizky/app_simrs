<section class="content">      
  <div class="box box-info main-console"  style="margin-top:115px;">
    <div class="box-header with-border text-center">
      <h1 class="box-title title-console">Ketersediaan Kamar</h1>
    </div>
    <div class="box-body">
        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div> -->
        
        <?php
          // for ($i=0; $i < count($onload['beds']['data']) ; $i++) { 
            // <h3>'.$beds[$i]['jmlReady'].'</h3>
          $beds = $onload['beds']['data'];
          $bed_arr = [];
          $c=0;
          for ($a=0; $a < count($beds); $a++) { 
            if($a%6==0){
              $bed_arr[] = [];
              $c++;
            } 
            $bed_arr[$c-1][] = $beds[$a];
          }

          // echo "<pre>",print_r($bed_arr),"</pre>";


          // for ($i=0; $i < 6 ; $i++) { 
          //   echo '
          //   <div class="col-lg-2">
          //     <div class="small-box bg-success">
          //       <div class="inner" style="text-align:center;">
          //         <h3>'.$beds[$i]['jmlReady'].'</h3>
          //         <p style="font-size:22px;font-weight:bold;">'.$beds[$i]['namaRuang'].'</p>
          //       </div>
          //     </div>
          //   </div>
          //   ';
          // }
          
          $cols = ''; $rows = '';
          for ($i=0; $i < count($bed_arr) ; $i++) { 
            for ($j=0; $j < count($bed_arr[$i]) ; $j++) { 
              $cols .= '
                <div class="col-lg-2 col-md-4">
                  <div class="small-box bg-success">
                    <div class="inner" style="text-align:center;">
                      <h3>'.$bed_arr[$i][$j]['jmlReady'].'</h3>
                      <p style="font-size:22px;font-weight:bold;">'.$bed_arr[$i][$j]['namaRuang'].'</p>
                    </div>
                  </div>
                </div>
                ';
            }

            $rows .= '<div class="row">'.$cols.'</div>';
            $cols = '';
          }

          echo $rows;
        ?>
        
        
        <!-- <.?="<pre>",print_r($onload),"</pre>";?> -->
        
        <!-- klinik -->
        <!-- <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
              More info
          </div>
        </div> -->
    </div>
  </div>

</section>
  