$(function () {
  DISABLE_RIGHT_CLICK();

  $('.datatable').DataTable();
  $('.datatable_simple').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  });


  let prevNowPlaying = null;
  let isPaused = false;

  function reload_noclick_response(){
    // let jam = 2;
    // let menit = 0;
    // let detik = 0;
    let jam = 0;
    let menit = 2;
    let detik = 0;
    let total_detik = (jam*3600)+(menit*60)+detik; //satuan: detik    

    // check fx run
    console.log(prevNowPlaying);
    if(prevNowPlaying) { clearInterval(prevNowPlaying); }

    t=0;
    prevNowPlaying = setInterval(function(){
      // $('#detik').text(total_detik_v--);     

      if(isPaused){
      }else{
        console.log(t, isPaused);

        // if(total_detik==t || isPaused){
        if(total_detik==t){
          // alert("Apakah ingin dilanjutkan?");
          // if(isPaused){
            isPaused = true;      
            
            // Swal.fire({
            Swal({
              title: 'Anda butuh waktu lagi?',
              // showDenyButton: true,
              showCancelButton: true,
              confirmButtonText: 'Ya',
              cancelButtonText: "Tidak", 
              cancelButtonColor: '#d33', //'#df4759',
              timer: 2*60*1000,
              // denyButtonText: `Don't save`,
            }).then((result) => {
              console.log(result);
              if (result.value) {
                // Swal.fire('Saved!', '', 'success')
                isPaused = false;
                t=0;
                console.log('ok');
                // return false;
              } else if (result.dismiss == "overlay") {
                isPaused = false;
                t=0;
                // return false;
              } else reload();
              // else if (result.dismiss == "cancel") {
              //   reload();
              // }             
            });
            
        } else t++;
        
      }      
    }, (1000) );

    // setInterval(function(){
    //   window.location.reload(true)
    // }, (total_detik*1000) );
  }


  // reload_noclick_response();


    
  if( open_site('consolebox/antrian_daftar') ){
    console.log('antrian_daftar');

  }
  
  
  if( open_site('consolebox/antrian_klinik') ){
    // console.log('antrian_klinik');
    $("input[name=in_cari_by]").focus();

    $('.numpad').click(function(e){
      console.log('numpad');
      popup_numpad();
      reload_noclick_response();
    });


    $(document).on('hide.bs.modal','#modal_kb', function () {
      // destroy modal
      let get_num = $('input[name=inMdl_val_kb]').val();
      console.log(get_num);
      $("#modal_numpad").children().remove();      
      $('input[name=in_cari_by]').val(get_num);
      console.log('modal hide');
    });


    $('#btn_cetak_antrian_skdp').click(function(e){
      e.preventDefault();
      sel_cari_by = $("select[name=sel_cari_by]").val();
      in_cari_by = $("input[name=in_cari_by]").val();
      // console.log([sel_cari_by, in_cari_by]);

      if(in_cari_by==''){alert('Nomor belum dimasukkan.');return false;}
      
      // let jpost = { url:_ADDR, button_id:$(this).attr("id"), norm_noka:sel_cari_by, nomor:in_cari_by };      
      let jpost = { url:'daftarmandiri/px_cetak_antrian', button_id:$(this).attr("id"), norm_noka:sel_cari_by, nomor:in_cari_by };      
      let js_sel = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian", jpost);
      // let js_sel = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian/"+sel_cari_by+"/"+in_cari_by, jpost);
      console.log(js_sel);

      if(js_sel.metadata.status=='failed'){ 
        // Swal('Data tidak ditemukan.', '', 'info');
        Swal({
          title: 'Data tidak ditemukan. Hari pendaftaran harus sama.', // HARUS HARI TODAY
          confirmButtonText: 'Ya',
          timer: 5*1000,
        }).then((result) => {
          reload();
        }); 
      }else reload();
      
    });
  }
  

})