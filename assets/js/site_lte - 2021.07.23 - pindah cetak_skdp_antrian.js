$(function () {
  let config_bpjs = {
    consid : "16141",
    kode_rs: "0195R028",
  };

  
  // function DISABLE_RIGHT_CLICK(){
  //   $(document).bind("contextmenu",function(e){
  //     // alert("OKEE");
  //     return false;
  //   });
  // }

  // DISABLE_RIGHT_CLICK();
  
  console.log(window.location.pathname);
  //***************************************************/
  //       user/login
  //***************************************************/
  if( open_site('user/login') ){
    console.log('login ini');
    let ip_server = $("input[name=ip_server]").val();
    let ip_client = $("input[name=ip_client]").val();
    console.log({ip_server:ip_server, ip_client:ip_client});
    
    if(ip_server == "192.168.1.68"){
      alert("Aplikasi ini sedang dalam pengembangan. Gunakan aplikasi di alamat : 192.168.1.99/rscm/app.");
      if(ip_client == "192.168.1.68" || ip_client == "192.168.1.192"){
      }else{
        // $.redirect("http://192.168.1.99/rscm/app");
      }
    }
    
    // $("body").children().remove();    
  }
  //***************************************************/
  //       \user/login
  //***************************************************/

  //***************************************************/
  //       daftarmandiri/daftaronline
  //***************************************************/
  if( open_site('daftarmandiri/daftaronline') ){
    console.log('daftaronline');
    $('.select2').select2();

    //Date picker
    $('.datepicker_daftaronline').datepicker({
      autoclose : true,
      format    : 'dd/mm/yyyy'
      // format    : 'yyyy-mm-dd'
    });

    //Money Euro
    // $('[data-mask]').inputmask();

 
    let in_foc = '';
    let in_foc_name = '';

    $('input').click(function(){
      in_foc = $('input:focus');
      // in_foc = $(this).is(':focus'); // true
      console.log(in_foc);
      in_foc_name = in_foc[0].name
      console.log(in_foc_name);
    });


    let val = '';
    $('.keypad div button').click(function(){
      if(in_foc=='') return false;

      let _this = $(this);
      // console.log(_this);
      // console.log(_this[0]);
      // console.log(_this[0].text());
      let ky = _this[0].textContent;

      switch (ky) {
        case 'C':
            ky  ='';
            val = '';
          break;
        
        case '<':
            val = val.slice(0, -1);
          break;
      
        default:
            val += ky;
            console.log(ky);
          break;
      }
      

      
      console.log(in_foc);
      $('input[name="'+in_foc_name+'"]').val(val);

      $('input[name="'+in_foc_name+'"]').keyup(); // ?? ANTISIPASI ERROR
    });



    // $('#modal_info_daftar_online').modal('show'); //BENERR

    let get_norm = '',
        get_noka = '',
        get_tglLahir = '',
        get_nohp = '',
        get_tgldaftar = moment().format('YYYY-MM-DD'), // default booking besok() 
        lokasiket = '';
        //xlixk : {hari ambil booking = hari ini-1}

    let _bpjs_syarat_rjk = 0; // 0 = TIDAK BOLEH, 1 = BOLEH

    let get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');



    let get_penanggung_cm_kode ='CO031',
        get_penanggung_cm_nama ='B P J S',
        get_penanggung_cm_st   ='M';

    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      $('select[name=sel_penanggung_cm]').append('<option value="'+sel_penanggung_cm.dtjs[i].Kode+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>');
    }

     // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');

    $('select[name=sel_penanggung_cm]').on('change', function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      // $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected"); 
      // asline iki, terus tak hapus, karena sebaiknya hapus selected di semua option
      // $("select[name=sel_cara_masuk_cm]").prop("selectedIndex", 0).change();
      // $("select[name=sel_rujukan_dari_db_cm]").prop("selectedIndex", 0).change();

      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      _bpjs_syarat_rjk = 1;

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('div[name=form_add_else_bpjs]').hide();
        $('input[name=noka]').removeAttr('disabled');
        _bpjs_syarat_rjk = 0;
        //input val reset
      }else{
        $('div[name=form_add_else_bpjs]').show();
        $('input[name=noka]').attr('disabled','disabled').val('');
        _bpjs_syarat_rjk = 1;
      }
      
      console.log('[get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]');
      console.log([get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]);

    });


    let hari_idx_besok = moment().weekday()+1 ; //======== AKTIFKAN
    console.log(hari_idx_besok);
    if(hari_idx_besok == 7) hari_idx_besok = 1;
    

    // let hari_idx_besok = 2 ;  //===== untuk TESTING
    // let js_jadok_hr = get_jadok_all().hr[hari_idx_besok-1].dt_hr; // REV
    let js_jdk = _ajax_web("GET", baseUrl()+'main/db/m_daftarmandiri/get_jadok_all', '');
    let js_jadok_hr = js_jdk.dokter_by_day[hari_idx_besok-1];
    console.log(js_jadok_hr);

    let sp_all_1hari = [];
    //fx fx

    // sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr); // REV
    sp_all_1hari = js_jdk.klinik_by_day[hari_idx_besok-1];
    console.log(sp_all_1hari);
    sel_append_sp_all_1hari(sp_all_1hari);
    sel_append_dokter_all_1hari(js_jadok_hr);
    create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);


    $('select[name=sel_hari_daftar]').change(function(){
      let hari_daftar = $(this).val();
      console.log(hari_daftar);

      if(hari_daftar == 'hari_besok'){
        hari_idx_besok= moment().weekday()+1 ; // DAFTAR HARI BESOK
        // js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        js_jadok_hr   = js_jdk.dokter_by_day[hari_idx_besok-1];
        get_tgldaftar = moment().format('YYYY-MM-DD');
        get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');
      }else if(hari_daftar == 'hari_ini'){
        hari_idx_besok= moment().weekday(); // DAFTAR HARI INI
        // js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        js_jadok_hr   = js_jdk.dokter_by_day[hari_idx_besok-1];
        get_tgldaftar = moment().add('days', -1).format('YYYY-MM-DD');
        get_tgl_jadok = moment().format('DD-MM-YYYY');
      }
      console.log(js_jadok_hr);

      sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr);
      // console.log(sp_all_1hari);
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);
    });

    $('select[name=sel_spesialis]').change(function(){
      let spesialis = $(this).val();
      console.log(spesialis);
      dokter_all_1sp_1hr_fx(js_jadok_hr, spesialis);
      $('select[name=sel_spesialis] option[value="'+spesialis+'"]').attr('selected','selected');
    });

    $('select[name=sel_dokter]').change(function(){
      let dokter = $(this).val();
      console.log(dokter);

      let spesialis = sp_selected_all_data(js_jadok_hr, dokter).Spesialis;
      console.log(spesialis);
      
      select_reset('sel_spesialis');
      let el = '<option value="'+spesialis+'" selected="selected">'+spesialis+'</option>';
      $('select[name=sel_spesialis]').append(el);
    });

    $('button.clear').click(function(){
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      return false;
    });

    

    $('input[name=noka]').focusout(function(e){
      e.preventDefault();
      let get_norm_cm = get_norm;
      if(get_norm_cm == ''){
        
        Swal.fire('Isi terlebih dahulu No. Rekam Medis Anda.')
          .then(function(){
            $('input[name=noka]').val('');
          // })
          // .then(function(){
            $("input[name=norm]").focus();
          });

      }else{
        get_noka = $(this).val().split('-').join('').split("_")[0];
        // console.log(get_noka);
        if(get_noka.length != 13){
          Swal.fire('Nomor kartu BPJS harus 13 digit.');
        }else{
          let jsPxCm = gd_pasien_rscm_GET(get_noka);
          console.log(jsPxCm);


          // ---- cek rujukan ada/tidak
          let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
          console.log(JS_rjk_multi);

          if(JS_rjk_multi.metaData.code == 201){ // rujukan tidak ada
            _bpjs_syarat_rjk = 0;
            let js_mrs = get_st_px_mrs_by_norm(get_norm_cm);
            if( js_mrs.count == 1 ){ // PX MRS
              // //membatasi tombol lewati, supaya data tidak di show
              // //alert('Billing RI terakhir kali'+js_mrs.datajs[0].NoBill);
              // $('#daftar_error').append( get_err_code('e_reg_rc_4').html ); 
              // $('#daftar_error').append( '<span>Billing RI terakhir kali: '+js_mrs.datajs[0].NoBill+'. Tanggal Masuk RI: '+js_mrs.datajs[0].TanggalMasuk+'</span>' );
              _bpjs_syarat_rjk = 1;
              console.log('Pasien POST MRS.');
            }else{ 
              // $('#daftar_error').append( get_err_code('e_reg_rc_bukan_px_mrs').html ); 
              Swal.fire(JS_rjk_multi.metaData.message+'. Silahkan ke Resepsionis untuk informasi lebih lanjut.')
                .then(function(){
                  window.location.reload(true);
                });
            }

            
          }else if(JS_rjk_multi.metaData.code == 200){ //SUKSES
            _bpjs_syarat_rjk = 1;
            console.log('Peserta BPJS boleh didaftarkan.');
          }else{
            _bpjs_syarat_rjk = 0;
            Swal.fire('TIDAK TERDETEKSI SISTEM BPJS.');
          }
          // ----\cek rujukan ada/tidak

          // //hanya RC yang BOLEH
          // get_norm = jsPxCm.datajs[0].NoRM;
          // // get_noka = jsPxCm.datajs[0].Barcode;
          // get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
          // get_nohp = jsPxCm.datajs[0].HP;
          
          // $("input[name=norm]").val( get_norm );
          // $("input[name=tglLahir]").val( get_tglLahir );
          // $("input[name=nohp]").val( get_nohp );
          // $("input[name=nohp]").focus();
        }
      }

        
      // // alert = function() {};
      // // delete window.alert;
      return false;
    });


    //JIKA USER : RC
    // $("input[name=norm]").keypress(function (e) { //TEKAN ENTER
    $("input[name=norm]").keyup(function (e) { //TEKAN ENTER
      console.log(e);
      let norm = $(this).val();
      console.log(norm, norm.length);

      // FILTER
      if(norm.length > 6 ){
        alert('NORM harus 6 digit.');
        // $(this).val().slice(0, -1); // TIDAK BISA utk KEYUP. BISA untuk KEYPRESS.
        $(this).val('');
        val = '';
        return false;
      } 

      else if( norm.length == 6 ){
        let jsPxCm = gd_pasien_rscm_by_norm(norm);
        console.log(jsPxCm);

        get_norm = norm;
        get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=noka]").val( get_noka );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=noka]").focus();
      }

      // if (e.which == 13) {
      //   let jsPxCm = gd_pasien_rscm_by_norm(norm);
      //   console.log(jsPxCm);

      //   get_norm = norm;
      //   get_noka = jsPxCm.datajs[0].Barcode;
      //   get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
      //   get_nohp = jsPxCm.datajs[0].HP;

      //   $("input[name=noka]").val( get_noka );
      //   $("input[name=tglLahir]").val( get_tglLahir );
      //   $("input[name=nohp]").val( get_nohp );

      //   $("input[name=noka]").focus();
      //   // $("input[name=noka]").trigger("keypress", {which:13});
      //   // $("input[name=noka]").trigger('keypress', [{preventDefault:function(){},keyCode:37}]); 

      // }


    });

    //JIKA USER : RC
    //error
    $("input[name=noka]").keypress(function (e) { //TEKAN ENTER
      get_noka = $(this).val().split('-').join('').split("_")[0];
      if (e.which == 13) {
        let jsPxCm = gd_pasien_rscm_GET(get_noka);
        console.log(jsPxCm);


        // ---- cek rujukan ada/tidak
        let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
        console.log(JS_rjk_multi);      
        if(JS_rjk_multi.metaData.code == 201){ // rujukan tidak ada
          alert(JS_rjk_multi.metaData.message);
          // window.location.reload(true);
        }else if(JS_rjk_multi.metaData.code == 200){ //SUKSES
          console.log('Peserta BPJS boleh didaftarkan.');
        }else{
          alert('TIDAK TERDETEKSI SISTEM BPJS.');
        }
        // ----\cek rujukan ada/tidak

        get_norm = jsPxCm.datajs[0].NoRM;
        // get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=norm]").val( get_norm );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=nohp]").focus();
      }
    });

    

    function fx_get_tglLahir(str_tgl_slash){
      return str_tgl_slash.split('/')[2]+'-'+str_tgl_slash.split('/')[1]+'-'+str_tgl_slash.split('/')[0];
    }

    function fx_get_tglLahir__min2garing(str_tgl){ //yyyy-mm-dd -> dd/mm/yyyy
      return str_tgl.split('-')[2]+'/'+str_tgl.split('-')[1]+'/'+str_tgl.split('-')[0];
    }

    
    // $('form[name=form_daftar_online]').submit(function(){
    $('#btn_form_daftar_online').click(function(){
      // let serial = $(this).serialize();
      // console.log(serial);

      get_norm = $('input[name=norm]').val();
      if(get_norm.length != 6){
        Swal.fire('Nomor rekam medis harus 6 digit.');
        return false;
      }
      
      get_tglLahir = fx_get_tglLahir($('input[name=tglLahir]').val()); // dd/mm/yyyy -> yyyy-mm-dd
      get_nohp = $('input[name=nohp]').val();
      console.log(get_norm+'_'+get_noka+'_'+get_tglLahir);

      lokasiket = $('select[name=sel_spesialis]').val();

      let jPost ={
          norm      : get_norm,
          noanggota : get_noka,
          nama      : 'nama',
          alamat    : 'alamat',
          penanggung: get_penanggung_cm_kode,
          penanggungket: get_penanggung_cm_nama,
          tgllahir  : get_tglLahir,
          diagnosa  : 10,
          diagnosaket:'KONTROL',
          lokasi    : 'kodelokasi',
          lokasiket : lokasiket,// $('select[name=sel_spesialis]').val(),
          typedokter: 1,
          dokter    : 'kodedokter',
          dokterket : $('select[name=sel_dokter]').val(),
          flag      : 0,
          notlp     : get_nohp,
          tglrujukan: moment().format('YYYY-MM-DD'), //kalau dikosongi akan ERROR
          rujukan   : '',
          rujukanket: '',
          instansi  : '',
          instansiket:'',
          keterangan: '',
          norequest : '',
          tgldaftar : '', //set tanggal_klik aja sepertinya?
          user : 'pasien',
          date : get_tgldaftar,
          time : moment().format('HH:mm:ss')
        };
      console.log(jPost);


      //----- final execution

      let message = '';
      if(_bpjs_syarat_rjk == 1){
        let curl_TX = send_form_daftar_online_CURL_TX(jPost);
        console.log(curl_TX);
        if(curl_TX.status != 'GAGAL'){
          message = 'Pasien bernama: '+curl_TX.nama+'.\nBerhasil didaftarkan.';
          // Swal.fire('Pasien bernama: '+curl_TX.nama+'.\nBerhasil didaftarkan.');
        }else{
          // alert(curl_TX.message);
          // Swal.fire(curl_TX.message);
          message = curl_TX.message;

        }
      }else{
        message = 'Tidak bisa mendaftar. Rujukan ada kendala. Silahkan ke Resepsionis untuk informasi lebih lanjut.';
      }
        
      //-----\final execution      

      Swal.fire(message).then(function(){
        window.location.reload(true);
      });

      return false;      
    });


    $('#btn_cek_rjk_multi').click(function(e){
      e.preventDefault();
      // console.log('okee');
      lokasiket = $('select[name=sel_spesialis]').val();
      // let lokasiket = 'SPESIALIS SARAF'; // ambil dari selected opt SPESIALIS
      // get_noka = '0001449094184';
      let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
      console.log(JS_rjk_multi);
      

      if(JS_rjk_multi.metaData.code == 201){
        alert(JS_rjk_multi.metaData.message);
      }else if(JS_rjk_multi.metaData.code == 200){
        console.log(JS_rjk_multi.response.rujukan.length);
        console.log(JS_rjk_multi.response.rujukan[0].poliRujukan.kode);
      }else{
        alert('TIDAK TERDETEKSI SISTEM BPJS.');
      }

    });
  }

  //***************************************************/
  //       \daftarmandiri/daftaronline
  //***************************************************/


  //***************************************************/
  //       daftarmandiri/daftaronlinex - 2021.04.21 - disable. 
  //       Ganti karena ada bridging antrean(mobile jkn) bpjs
  //***************************************************/
  if( open_site('daftarmandiri/daftaronlinex') ){
    console.log('daftaronline');
    $('.select2').select2();

    //Date picker
    $('.datepicker_daftaronline').datepicker({
      autoclose : true,
      format    : 'dd/mm/yyyy'
      // format    : 'yyyy-mm-dd'
    });

    //Money Euro
    $('[data-mask]').inputmask();

 
    // $('form[name=form_daftar_online]').validate({
    //   rules: {
    //     nohp: {
    //       maxlength : 13
    //     }
    //   },
    //   messages: {
    //     nohp: {
    //       maxlength : 'nomor HP maksimal 13 digit.'
    //     }
    //   }
    // });


    $('#modal_info_daftar_online').modal('show'); //BENERR
    // $('#modal_jadok_daftar_online').modal('show');

    let batas_jam_daftar_hari_ini = 10,
        get_jam_sekarang = parseInt( moment().format('HH') );
    if(get_jam_sekarang >= batas_jam_daftar_hari_ini){
      $('select[name=sel_hari_daftar] option[value=hari_ini]').remove();
    }


    let get_norm = '',
        get_noka = '',
        get_tglLahir = '',
        get_nohp = '',
        get_tgldaftar = moment().format('YYYY-MM-DD'), // default booking besok() 
        lokasiket = '';
        //xlixk : {hari ambil booking = hari ini-1}

    let _bpjs_syarat_rjk = 0; // 0 = TIDAK BOLEH, 1 = BOLEH

    let get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');



    let get_penanggung_cm_kode ='CO031',
        get_penanggung_cm_nama ='B P J S',
        get_penanggung_cm_st   ='M';

    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      $('select[name=sel_penanggung_cm]').append('<option value="'+sel_penanggung_cm.dtjs[i].Kode+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>');
    }

     // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');


    $('select[name=sel_penanggung_cm]').on('change', function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      // $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected"); 
      // asline iki, terus tak hapus, karena sebaiknya hapus selected di semua option
      // $("select[name=sel_cara_masuk_cm]").prop("selectedIndex", 0).change();
      // $("select[name=sel_rujukan_dari_db_cm]").prop("selectedIndex", 0).change();

      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      _bpjs_syarat_rjk = 1;

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('div[name=form_add_else_bpjs]').hide();
        $('input[name=noka]').removeAttr('disabled');
        _bpjs_syarat_rjk = 0;
        //input val reset
      }else{
        $('div[name=form_add_else_bpjs]').show();
        $('input[name=noka]').attr('disabled','disabled').val('');
        _bpjs_syarat_rjk = 1;
      }
      
      console.log('[get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]');
      console.log([get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]);

    });


    let hari_idx_besok = moment().weekday()+1 ; //======== AKTIFKAN
    console.log(hari_idx_besok);
    if(hari_idx_besok == 7){
      hari_idx_besok = 1;
    }

    // let hari_idx_besok = 2 ;  //===== untuk TESTING
    let js_jadok_hr = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
    console.log(js_jadok_hr);

    let sp_group;
    let sp_all_1hari = [];

    //fx fx

    sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr);
    console.log(sp_all_1hari);
    sel_append_sp_all_1hari(sp_all_1hari);
    sel_append_dokter_all_1hari(js_jadok_hr);
    create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);


    // dokter_all_1sp_1hr_fx(js_jadok_hr, 'all');
    // sp_selected_all_data(js_jadok_hr, 'all');
    

    // var fruits = ["Banana", "Orange", "Apple", "Mango"];
    // var a = fruits.indexOf("Apple");
    // console.log(a);

    // startdate = "20.03.2014";
    // var new_date = moment(startdate, "DD-MM-YYYY").add('days', 5);
    // console.log(moment().add('days', -1).format('YYYY-MM-DD') ); // bisa

    $('select[name=sel_hari_daftar]').change(function(){
      let hari_daftar = $(this).val();
      console.log(hari_daftar);

      if(hari_daftar == 'hari_besok'){
        hari_idx_besok= moment().weekday()+1 ; // DAFTAR HARI BESOK
        js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        get_tgldaftar = moment().format('YYYY-MM-DD');
        get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');
      }else if(hari_daftar == 'hari_ini'){
        hari_idx_besok= moment().weekday(); // DAFTAR HARI INI
        js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        get_tgldaftar = moment().add('days', -1).format('YYYY-MM-DD');
        get_tgl_jadok = moment().format('DD-MM-YYYY');
      }
      console.log(js_jadok_hr);

      sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr);
      // console.log(sp_all_1hari);
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);
    });

    $('select[name=sel_spesialis]').change(function(){
      let spesialis = $(this).val();
      console.log(spesialis);
      dokter_all_1sp_1hr_fx(js_jadok_hr, spesialis);
      $('select[name=sel_spesialis] option[value="'+spesialis+'"]').attr('selected','selected');
    });

    $('select[name=sel_dokter]').change(function(){
      let dokter = $(this).val();
      console.log(dokter);

      let spesialis = sp_selected_all_data(js_jadok_hr, dokter).Spesialis;
      console.log(spesialis);
      
      select_reset('sel_spesialis');
      let el = '<option value="'+spesialis+'" selected="selected">'+spesialis+'</option>';
      $('select[name=sel_spesialis]').append(el);
    });

    $('button.clear').click(function(){
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      return false;
    });

    // let oldalert = window.alert;
    // window.alert= function alert(t){
    //     // alert.count = !alert.count ? 1 : alert.count + 1;
    //     oldalert(t);
    // };

    $('input[name=norm]').focusout(function(e){
      e.preventDefault();
      get_norm = $(this).val().split("_")[0];

      if(get_norm.length != 6){
        Swal.fire('Nomor rekam medis harus 6 digit.');
      }
      // // console.log(get_norm+'_'+get_norm.length);

      // // alert = function() {};
      // // delete window.alert;
      return false;
    });

    $('input[name=noka]').focusout(function(e){
      e.preventDefault();
      let get_norm_cm = get_norm;
      if(get_norm_cm == ''){
        
        Swal.fire('Isi terlebih dahulu No. Rekam Medis Anda.')
          .then(function(){
            $('input[name=noka]').val('');
          // })
          // .then(function(){
            $("input[name=norm]").focus();
          });

      }else{
        get_noka = $(this).val().split('-').join('').split("_")[0];
        // console.log(get_noka);
        if(get_noka.length != 13){
          Swal.fire('Nomor kartu BPJS harus 13 digit.');
        }else{
          let jsPxCm = gd_pasien_rscm_GET(get_noka);
          console.log(jsPxCm);


          // ---- cek rujukan ada/tidak
          let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
          console.log(JS_rjk_multi);

          if(JS_rjk_multi.metaData.code == 201){ // rujukan tidak ada
            _bpjs_syarat_rjk = 0;
            let js_mrs = get_st_px_mrs_by_norm(get_norm_cm);
            if( js_mrs.count == 1 ){ // PX MRS
              // //membatasi tombol lewati, supaya data tidak di show
              // //alert('Billing RI terakhir kali'+js_mrs.datajs[0].NoBill);
              // $('#daftar_error').append( get_err_code('e_reg_rc_4').html ); 
              // $('#daftar_error').append( '<span>Billing RI terakhir kali: '+js_mrs.datajs[0].NoBill+'. Tanggal Masuk RI: '+js_mrs.datajs[0].TanggalMasuk+'</span>' );
              _bpjs_syarat_rjk = 1;
              console.log('Pasien POST MRS.');
            }else{ 
              // $('#daftar_error').append( get_err_code('e_reg_rc_bukan_px_mrs').html ); 
              Swal.fire(JS_rjk_multi.metaData.message+'. Silahkan ke Resepsionis untuk informasi lebih lanjut.')
                .then(function(){
                  window.location.reload(true);
                });
            }

            
          }else if(JS_rjk_multi.metaData.code == 200){ //SUKSES
            _bpjs_syarat_rjk = 1;
            console.log('Peserta BPJS boleh didaftarkan.');
          }else{
            _bpjs_syarat_rjk = 0;
            Swal.fire('TIDAK TERDETEKSI SISTEM BPJS.');
          }
          // ----\cek rujukan ada/tidak

          // //hanya RC yang BOLEH
          // get_norm = jsPxCm.datajs[0].NoRM;
          // // get_noka = jsPxCm.datajs[0].Barcode;
          // get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
          // get_nohp = jsPxCm.datajs[0].HP;
          
          // $("input[name=norm]").val( get_norm );
          // $("input[name=tglLahir]").val( get_tglLahir );
          // $("input[name=nohp]").val( get_nohp );
          // $("input[name=nohp]").focus();
        }
      }

        
      // // alert = function() {};
      // // delete window.alert;
      return false;
    });


    //JIKA USER : RC
    $("input[name=norm]").keypress(function (e) { //TEKAN ENTER
      let norm = $(this).val();
      if (e.which == 13) {
        let jsPxCm = gd_pasien_rscm_by_norm(norm);
        console.log(jsPxCm);

        get_norm = norm;
        get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=noka]").val( get_noka );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=noka]").focus();
        // $("input[name=noka]").trigger("keypress", {which:13});
        // $("input[name=noka]").trigger('keypress', [{preventDefault:function(){},keyCode:37}]); 

      }
    });

    //JIKA USER : RC
    //error
    $("input[name=noka]").keypress(function (e) { //TEKAN ENTER
      get_noka = $(this).val().split('-').join('').split("_")[0];
      if (e.which == 13) {
        let jsPxCm = gd_pasien_rscm_GET(get_noka);
        console.log(jsPxCm);


        // ---- cek rujukan ada/tidak
        let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
        console.log(JS_rjk_multi);      
        if(JS_rjk_multi.metaData.code == 201){ // rujukan tidak ada
          alert(JS_rjk_multi.metaData.message);
          // window.location.reload(true);
        }else if(JS_rjk_multi.metaData.code == 200){ //SUKSES
          console.log('Peserta BPJS boleh didaftarkan.');
        }else{
          alert('TIDAK TERDETEKSI SISTEM BPJS.');
        }
        // ----\cek rujukan ada/tidak

        get_norm = jsPxCm.datajs[0].NoRM;
        // get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=norm]").val( get_norm );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=nohp]").focus();
      }
    });

    

    function fx_get_tglLahir(str_tgl_slash){
      return str_tgl_slash.split('/')[2]+'-'+str_tgl_slash.split('/')[1]+'-'+str_tgl_slash.split('/')[0];
    }

    function fx_get_tglLahir__min2garing(str_tgl){ //yyyy-mm-dd -> dd/mm/yyyy
      return str_tgl.split('-')[2]+'/'+str_tgl.split('-')[1]+'/'+str_tgl.split('-')[0];
    }

    
    // $('form[name=form_daftar_online]').submit(function(){
    $('#btn_form_daftar_online').click(function(){
      // let serial = $(this).serialize();
      // console.log(serial);
      
      get_tglLahir = fx_get_tglLahir($('input[name=tglLahir]').val()); // dd/mm/yyyy -> yyyy-mm-dd
      get_nohp = $('input[name=nohp]').val();
      console.log(get_norm+'_'+get_noka+'_'+get_tglLahir);

      lokasiket = $('select[name=sel_spesialis]').val();

      let jPost ={
          norm      : get_norm,
          noanggota : get_noka,
          nama      : 'nama',
          alamat    : 'alamat',
          penanggung: get_penanggung_cm_kode,
          penanggungket: get_penanggung_cm_nama,
          tgllahir  : get_tglLahir,
          diagnosa  : 10,
          diagnosaket:'KONTROL',
          lokasi    : 'kodelokasi',
          lokasiket : lokasiket,// $('select[name=sel_spesialis]').val(),
          typedokter: 1,
          dokter    : 'kodedokter',
          dokterket : $('select[name=sel_dokter]').val(),
          flag      : 0,
          notlp     : get_nohp,
          tglrujukan: moment().format('YYYY-MM-DD'), //kalau dikosongi akan ERROR
          rujukan   : '',
          rujukanket: '',
          instansi  : '',
          instansiket:'',
          keterangan: '',
          norequest : '',
          tgldaftar : '', //set tanggal_klik aja sepertinya?
          user : 'pasien',
          date : get_tgldaftar,
          time : moment().format('HH:mm:ss')
        };
      console.log(jPost);


      //----- final execution

      let message = '';
      if(_bpjs_syarat_rjk == 1){
        let curl_TX = send_form_daftar_online_CURL_TX(jPost);
        console.log(curl_TX);
        if(curl_TX.status != 'GAGAL'){
          message = 'Pasien bernama: '+curl_TX.nama+'.\nBerhasil didaftarkan.';
          // Swal.fire('Pasien bernama: '+curl_TX.nama+'.\nBerhasil didaftarkan.');
        }else{
          // alert(curl_TX.message);
          // Swal.fire(curl_TX.message);
          message = curl_TX.message;

        }
      }else{
        message = 'Tidak bisa mendaftar. Rujukan ada kendala. Silahkan ke Resepsionis untuk informasi lebih lanjut.';
      }
        
      //-----\final execution      

      Swal.fire(message).then(function(){
        window.location.reload(true);
      });

      return false;      
    });


    $('#btn_cek_rjk_multi').click(function(e){
      e.preventDefault();
      // console.log('okee');
      lokasiket = $('select[name=sel_spesialis]').val();
      // let lokasiket = 'SPESIALIS SARAF'; // ambil dari selected opt SPESIALIS
      // get_noka = '0001449094184';
      let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
      console.log(JS_rjk_multi);
      

      if(JS_rjk_multi.metaData.code == 201){
        alert(JS_rjk_multi.metaData.message);
      }else if(JS_rjk_multi.metaData.code == 200){
        console.log(JS_rjk_multi.response.rujukan.length);
        console.log(JS_rjk_multi.response.rujukan[0].poliRujukan.kode);
      }else{
        alert('TIDAK TERDETEKSI SISTEM BPJS.');
      }

    });
  }

  //***************************************************/
  //       \daftarmandiri/daftaronlinex
  //***************************************************/

  //***************************************************/
  //       daftarmandiri/px_cetak_antrian
  //***************************************************/
  if( open_site('daftarmandiri/px_cetak_antrian') ){
    console.log('px_cetak_antrian');

    DISABLE_RIGHT_CLICK();

    $("input[name=in_cari_by]").focus();
    let sel_cari_by = "noka",
        // lbl_cari_by = "No.Rekam Medis",
        lbl_cari_by = "No.Kartu BPJS",
        in_cari_by = "",
        date = moment().format('YYYY-MM-DD');

    $("label[name=lbl_cari_by]").text(lbl_cari_by);

    $("select[name=sel_cari_by]").on("change", function(){
      // sel_cari_by = $("select[name=sel_cari_by]").val();
      sel_cari_by = $(this).val();
      lbl_cari_by = (sel_cari_by == "norm")? "No.Rekam Medis" : "No.Kartu BPJS" ;
      $("label[name=lbl_cari_by]").text(lbl_cari_by);
    });

    
    $('.numpad').click(function(e){
      popup_numpad();
    });


    $(document).on('hide.bs.modal','#modal_kb', function () {
      // $('#tbl_mdl_cari_px').DataTable().destroy();

      // destroy modal
      let get_num = $('input[name=inMdl_val_kb]').val();
      console.log(get_num);
      $("#modal_numpad").children().remove();      
      $('input[name=in_cari_by]').val(get_num);
      console.log('modal hide');
    });


    let jsObj_px_cm = '';
    $('#btn_cetak_antrian_skdp').click(function(e){
      e.preventDefault();
      in_cari_by = $("input[name=in_cari_by]").val();
      console.log([sel_cari_by, in_cari_by, date]);
      
      let jpost = {
        url 		  : _ADDR,
        button_id : $(this).attr("id"),
        norm_noka : sel_cari_by,
        nomor 		: in_cari_by,
      };
      
      // let js_sel = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian/"+sel_cari_by+"/"+in_cari_by, jpost);
      let js_sel = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian/", jpost);
      console.log(js_sel);        
      
      reload(); 
    });
  }

  //***************************************************/
  //       \daftarmandiri/px_cetak_antrian
  //***************************************************/
     
  
  
  //***************************************************/
  //       daftarmandiri/px_cetak_antrian_rc
  //***************************************************/
  if( open_site('daftarmandiri/px_cetak_antrian_rc') ){
    
    DISABLE_RIGHT_CLICK();

    $('#btn_cetak_antrian_rc').click(function(e){
      e.preventDefault();
      console.log('KLIK CETAK>>>');
      
      let P = { url : _ADDR, button_id : $(this).attr('id') };
      // js = _ajax_web("POST", baseUrl()+"print_termal/antrian_rc", P);
      wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/antrian_rc", P);
      console.log(wsprinter);
      reload();
    });
  }

  //***************************************************/
  //       \daftarmandiri/px_cetak_antrian_rc
  //***************************************************/

  

  //***************************************************/
  //        daftarmandiri/antrian_rc_board
  //***************************************************/
  if( open_site('daftarmandiri/antrian_rc_board') ){
    // 
    let js_bed = _ajax("GET", "view_billboard/billboard_bed", "");
    console.log(js_bed);
    for (let i = 0; i < js_bed.length; i++) {
      // let el = '<span>'+js_bed[i]['namaRuang']+'</span>';
      let el = '<span style="display:inline-block; width:200px; ">'+js_bed[i]['namaRuang']+'</span>';
      // let el = '<div style="width:200px;">'+js_bed[i]['namaRuang']+'</div>';



      // let el = 
      //   '<div class="card-span">'+
      //     '<div class="card-nomor" style="background-color: #b7fffa;">'+
      //       '<span class="card-title bold">'+js_bed[i].jmlReady+'</span>'+
      //     '</div>'+
      //     '<div class="card-label" style="background-color: #58e2d7; ">'+
      //       '<span class="bold">'+js_bed[i].namaRuang+'</span>'+
      //     '</div>'+
      //   '</div>';
        
      //   '<div class="card-span">'+
      //     '<div class="card-nomor" style="background-color: #b7fffa;">'+
      //       '<span class="card-title bold">'+js_bed[i].jmlReady+'</span>'+
      //     '</div>'+
      //     '<div class="card-label" style="background-color: #58e2d7; ">'+
      //       '<span class="bold">'+js_bed[i].namaRuang+'</span>'+
      //     '</div>'+
      //   '</div>';

      $('#mq_bed').append(el);      
    }

    
    for (let i = 0; i < 4; i++) {
      let el_card = 
        '<div class="card-span">'+
          '<div class="card-nomor" style="background-color: #b7fffa;">'+
            '<span class="card-title bold">'+js_bed[i].jmlReady+'</span>'+
          '</div>'+
          '<div class="card-label" style="background-color: #58e2d7; ">'+
            '<span class="bold">'+js_bed[i].namaRuang+'</span>'+
          '</div>'+
        '</div>';
        $('#item1').append(el_card);
    }
  }

  //***************************************************/
  //        daftarmandiri/antrian_rc_board
  //***************************************************/

  //***************************************************/
  //        daftarmandiri/ttd
  //***************************************************/
  if( open_site('daftarmandiri/ttd') ){
    sort_bubble();
    // let canvas = $('#myCanvas');
    let canvas = document.getElementById('myCanvas');
    let ctx = canvas.getContext("2d");
    let painting = document.getElementById('content');
    let paintStyle = getComputedStyle(painting);
    canvas.width = parseInt(paintStyle.getPropertyValue('width'));
    canvas.height = parseInt(paintStyle.getPropertyValue('height'));

    let mouse = {x:0, y:0};

    canvas.addEventListener('mousemove', function(e){
      mouse.x = e.pageX - this.offsetLeft;
      mouse.y = e.pageY - this.offsetTop;
    }, false);


    ctx.lineWidth = 3;
    ctx.lineJoin  = 'round';
    ctx.lineCap   = 'round';
    // ctx.strokeStyle = '#FF0000'; //red
    ctx.strokeStyle = '#000000';

    canvas.addEventListener('mousedown', function(e){
      // draw the current path on the canvas
      ctx.beginPath();
      ctx.moveTo(mouse.x, mouse.y);
      canvas.addEventListener('mousemove', onPaint, false);
    }, false);

    canvas.addEventListener('mouseup', function(){
      canvas.removeEventListener('mousemove', onPaint, false);
    }, false);

    let onPaint = function(){
      ctx.lineTo(mouse.x, mouse.y);
      ctx.stroke();
    }




    $('button[name=btn_canvas_clear]').click(function(){
      // let el = '<canvas id="myCanvas"></canvas>';
      // $('#content').children().remove().append(el);
      ctx.clearRect(0, 0,  canvas.width, canvas.height);
    });


    $('a[name=btn_canvas_download]').click(function(){
      // $(this).attr({'href': canvas.toDataURL() ).attr('download','mypainting.png');
      $(this).attr({href: canvas.toDataURL(), download: 'ttd.png' });
    });
  }//[\open_site]daftarmandiri/ttd

  //***************************************************/
  //       \daftarmandiri/ttd
  //***************************************************/

  


  //***************************************************/
  //       bo/
  //***************************************************/
  if( open_site('bo/') ){
    console.log('bo page load');
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    let data = [
      [65, 59, 80, 81, 56, 55, 40, 60],
      [28, 48, 40, 19, 86, 27, 90, 57],
      [45, 59, 48, 60, 55, 15, 65, 78]
    ];
    console.log(data);


    let lineColors = [
      'rgba(210, 214, 222, 1)', 'rgba(60,141,188,0.9)', 
      '#12b882', '#c2294f', '#a32497', '#bd7728'];
    let objLine = ['Electronics','Digital Goods','Books'];
    let xlabel = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August'];
    let datasets = [];
    for(let i=0;i<objLine.length;i++){
      let js = {
        label               : objLine[i],
        fillColor           : lineColors[i],
        strokeColor         : lineColors[i],
        pointColor          : lineColors[i],
        pointStrokeColor    : '',
        pointHighlightFill  : '',
        pointHighlightStroke: '',
        data                : data[i]
      }
      datasets.push(js);
    }

    console.log(datasets);

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)

    var lineChartData = {
      labels  : xlabel,
      datasets: datasets
    }

    
    var lineChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : 
        '<ul class="<%=name.toLowerCase()%>-legend">'+
          '<% for (var i=0; i<datasets.length; i++){%>'+
            '<li><span style="background-color:<%=datasets[i].lineColor%>"></span>'+
                // '<%if(datasets[i].label){%><%=datasets[i].label%><%}%>'+
                '<%if(datasets[i].label){ datasets[i].label }%>'+
            '</li>'+
          '<%}%>'+
        '</ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    // var lineChartOptions         = areaChartOptions;
    lineChartOptions.datasetFill = false; //true : mewarnai isi area, areaChart
    lineChart.Line(lineChartData, lineChartOptions);

    let el;
    for (let i=0; i<datasets.length; i++){
      el = 
        '<li>'+
          '<i class="fa fa-circle" style="color:'+lineColors[i]+';"></i>'+
          '<span id="label">'+objLine[i]+'</span>'+
        '</li>';
      $('#myLblLegend_lineChart').append(el);
    }


  }

  //***************************************************/
  //       \bo/
  //***************************************************/

  //***************************************************/
  //       bo/menu/dashboard
  //***************************************************/
  if( open_site('bo/menu/dashboard') ){
    console.log(baseUrl());
    //Date picker
    // $('.datepicker_dashboard').datepicker({
    //   autoclose : true,
    //   // format    : 'dd/mm/yyyy'
    //   format    : 'yyyy-mm-dd'
    // });

    $(".datepicker-y").datepicker({
      autoclose : true,
      format  : 'yyyy',
      startView: "years", 
      minViewMode: "years"
    });

    // amchart_pie(jPost_kunjungan);     

    $('#clearCanvas').click(function(e){
      let canvas= document.getElementById('pieChart');
      // let canvas = $(element);
      // $(element).getContext('2d').clearRect(0, 0,  canvas.width, canvas.height);
      canvas.getContext('2d').clearRect(0, 0,  canvas.width, canvas.height);
    });


    
    //---------------  <BOX:Kunjungan Poli Berdasarkan Penanggung 1 Tahun> ----------------
    $('button[name=btn_grf_line_kunjungan_poli]').click(function(e){
      e.preventDefault();
      let th_selected = $('input[name=sel_grf_line_kunjungan_poli]').val();

      let js_kunjunganPoli1th = select_kunjungan_group_penanggung_bln_by_th(th_selected);
      console.log('js_kunjunganPoli1th');
      console.log(js_kunjunganPoli1th);

      let penanggung_list_grf = ['ASURANSI', 'BPJS KESEHATAN', 'BPJS KETENAGAKERJAAN', 'UMUM'];
      let dt_grf_line = [];
      let jPost_data_grf = [];
      let id_bln = [];
      //translater format data grafik
      for(let penanggung=0; penanggung<4; penanggung++){
        let val_bln = [0,0,0,0, 0,0,0,0, 0,0,0,0];
        // let val_bln = ['','','','', '','','','', '','','',''];
        // let val_bln = ['','','','', '',''];
        for(let i=0; i<js_kunjunganPoli1th.length; i++){
          if(js_kunjunganPoli1th[i].penanggung == penanggung_list_grf[penanggung]){
            id_bln.push(js_kunjunganPoli1th[i].bulan);
            val_bln[(js_kunjunganPoli1th[i].bulan-1)] = js_kunjunganPoli1th[i].total_kunjungan;      
            
          }
        }

        let x = { 
          penanggung : penanggung_list_grf[penanggung],
          val : val_bln
        };
        
        dt_grf_line.push(x);
        jPost_data_grf[penanggung] = dt_grf_line[penanggung].val;
      }
      
      console.log(id_bln);
      console.log(dt_grf_line);
      console.log('jPost_data_grf');
      console.log(jPost_data_grf);
      console.log('penanggung_list_grf');
      console.log(penanggung_list_grf);

      chartjs_line('grf_line_kunjungan_poli', jPost_data_grf, penanggung_list_grf);
    });
    //---------------  <\BOX:Kunjungan Poli Berdasarkan Penanggung 1 Tahun> ----------------

    //---------------  <BOX:Kunjungan Poli(Diagram Donat)> ----------------

    $('button[name=btn_grf_kunjungan_all_by_bln_th]').click(function(e){
      e.preventDefault();
      let xjs = {
          tahun : $('input[name=sel_grf_kunjungan_all_thn]').val(),
          bulan : $('select[name=sel_grf_kunjungan_all_bln]').val()
        }
      let jPost_kunjungan = select_kunjungan_allpenanggung_by_bln_th(xjs);
      console.log(jPost_kunjungan);
      
      // chartjs_pie(jPost_kunjungan, '#pieChart', 'total_kunjungan', 'lokasi');
      chartjs_pie(
          jPost_kunjungan, 'grf_donat_kunjungan_poli', 
          'total_kunjungan', 'lokasi'
        );

      // chartjs_pie_label(
      //     jPost_kunjungan, 'grf_donat_kunjungan_poli_legend', 
      //     'total_kunjungan', 'lokasi'
      //   );
    });


    $('button[name=btn_dl_dt_grf_kunjungan_all_by_bln_th]').click(function(e){
      e.preventDefault();
      let tahun = $('input[name=sel_grf_kunjungan_all_thn]').val();
      window.open(baseUrl()+'ajaxreq/download_xls_kunjungan_1th?tahun='+tahun);
      console.log('download Success.');
    });

    //---------------  <\BOX:Kunjungan Poli(Diagram Donat)> ----------------


    //---------------  <BOX:Kunjungan Tiap Poli 1 Tahun> ----------------
    $('button[name=select_kunjungan_tiapLokasi_by_lokasi_th]').click(function(e){
      e.preventDefault();
      let lokasi = $('select[name=sel_grf_kunjungan_sp]').val();
      let tahun  = $('input[name=sel_grf_select_kunjungan_tiapLokasi_by_lokasi_th]').val();
      console.log([lokasi, tahun]);
      let js_tiappoli = select_kunjungan_tiapLokasi_by_lokasi_th( tahun, lokasi);
      console.log(js_tiappoli);



      // let js_x = select_kunjungan_group_penanggung_bln_by_th('2018');
      let js_x = js_tiappoli;
      console.log(js_x);

      let penanggung_list_grf = [lokasi];
      console.log(penanggung_list_grf);
      let dt_grf_line = [];
      let jPost_data_grf = [];
      let id_bln = [];
      
      for(let penanggung=0; penanggung<penanggung_list_grf.length; penanggung++){
        let val_bln = [0,0,0,0, 0,0,0,0, 0,0,0,0];
        for(let i=0; i<js_x.length; i++){
            id_bln.push(js_x[i].bulan);
            val_bln[(js_x[i].bulan-1)] = js_x[i].total_kunjungan;      
            
          
        }

        let x = { 
          penanggung : penanggung_list_grf[penanggung],
          val : val_bln
        };
        
        dt_grf_line.push(x);
        jPost_data_grf[penanggung] = dt_grf_line[penanggung].val;
      }
      
      console.log(id_bln);
      console.log(dt_grf_line);

      console.log('jPost_data_grf');
      console.log(jPost_data_grf);
      console.log('penanggung_list_grf');
      console.log(penanggung_list_grf);

      chartjs_line('grf_line_kunjungan_namaPoli', jPost_data_grf, penanggung_list_grf);

    });
    //---------------  <\BOX:Kunjungan Tiap Poli 1 Tahun> ----------------    

  }

  //***************************************************/
  //       \bo/menu/dashboard
  //***************************************************/





  //***************************************************/
  //       bo/menu/perpustakaan
  //***************************************************/
  if( open_site('bo/menu/perpustakaan') ){
      let ip_server = location.host;      
      console.log(ip_server);

      let js_folder = [],
          js_file_mst = [];
      
      // let url_file_utama = 'http://192.168.1.68/rscm/APP FILES/KUMPULAN UNDANG-UNDANG POKJA/';
      let url_file_utama = 'http://'+ip_server+'/rscm/APP FILES/KUMPULAN UNDANG-UNDANG POKJA/';
      let jss = _ajax_type('GET', 'text', url_file_utama, '');
      // console.log(jss);

      $(jss).find('tr td img').each(function () {
        if( $(this).attr('alt') == '[DIR]'){
          // let el_selector_href = $(this).parent().parent().find('td a').attr('href');
          let href = $(this).parent().parent().find('td a').attr('href');
          let el_selector = {
            href : href,
            label: decodeURIComponent(href)
          };
          // $("#folderNames").append( '<li><a href="'+url_file_utama+el_selector.href+'">'+el_selector.label+'</a></li>');
          js_folder.push( el_selector );

        }              
      });
      console.log(js_folder);          


      // js_folder[] = NAMA ACUAN
      //LOAD TIAP ACUAN
      for(let i=0; i<js_folder.length; i++){
        let js_file   = [];
        let url_file_det = url_file_utama+js_folder[i].label;
        console.log(url_file_det);


        //buat elemen acuan
        // $('#perpustakaan').append('<ol></ol>');
        let el_acuan = 
              '<li name="'+js_folder[i].label+'">'+
                '<span>'+js_folder[i].label+'</span>'+
                '<ol></ol>'+
              '</li>';
        console.log(el_acuan);
        $('#perpustakaan>ol').append(el_acuan);
        // $('#perpustakaan ol li[name="'+js_folder[i].label+'"]').append('<ol></ol>');
        //\buat elemen acuan



        let jss_det = _ajax_type('GET', 'text', url_file_det, '');

        $(jss_det).find('td a').each(function () {
          if( $(this).text() != 'Parent Directory'){
            let href = $(this).attr('href');
            let el_selector_det = {
              // href : href,
              href : url_file_det+href,
              label: decodeURIComponent(href)
            };

            js_file.push( el_selector_det );

            //buat elemen acuan_det
            let el_acuan_det = '<li><a href="'+el_selector_det.href+'">'+el_selector_det.label+'</a></li>';
            $('#perpustakaan>ol>li[name="'+js_folder[i].label+'"]>ol').append(el_acuan_det);
            //\buat elemen acuan_det
          }
            
        });
        console.log(js_file);


        // memasukkan ke master. TERTATA RAPI
        let a = {
          label_acuan : js_folder[i].label,
          list        : js_file
        };
        js_file_mst.push(a);

      }
      console.log(js_file_mst);
        
  }

  //***************************************************/
  //       \bo/menu/perpustakaan
  //***************************************************/



  //***************************************************/
  //       bo/menu/laporan-tahunan
  //***************************************************/
  if( open_site('bo/menu/laporan-tahunan') ){
      
      
      $('button[name=ld_laporan_tahunan]').click(function(e){
        let ip_server = location.host;      
        // console.log(ip_server);

        let js_folder   = [],
            js_file_mst = [];

        let jss = [];

        // $('#laporan-tahunan>ol').children().remove();
        $('#laporan-tahunan>ul').children().remove();

        let tahun = $('select[name=tahun]').val();
        console.log(tahun);

        // let url_file_utama = 'http://192.168.1.68/rscm/APP FILES/LAPORAN TAHUNAN/'+tahun+'/';
        let url_file_utama = 'http://'+ip_server+'/rscm/APP FILES/LAPORAN TAHUNAN/'+tahun+'/';
        jss = _ajax_type('GET', 'text', url_file_utama, '');
        console.log(jss);

        $(jss).find('tr td img').each(function () {
          // if( $(this).attr('alt') == '[DIR]'){ // ASLI
          if( $(this).attr('src') == '/icons/layout.gif' ){
            // let el_selector_href = $(this).parent().parent().find('td a').attr('href');
            let href = $(this).parent().parent().find('td a').attr('href');
            let el_selector = {
              href : href,
              label: decodeURIComponent(href)
            };
            // $("#folderNames").append( '<li><a href="'+url_file_utama+el_selector.href+'">'+el_selector.label+'</a></li>');
            js_folder.push( el_selector );

          }              
        });
        console.log(js_folder);
        // return false; 


        // js_folder[] = NAMA ACUAN
        //LOAD TIAP ACUAN
        for(let i=0; i<js_folder.length; i++){
          let js_file   = [];
          let url_file_det = url_file_utama+js_folder[i].label;
          console.log(url_file_det);


          //buat elemen acuan
          // $('#perpustakaan').append('<ol></ol>');
          let el_acuan = 
                '<li name="'+js_folder[i].label+'">'+
                  // '<span>'+js_folder[i].label+'</span>'+
                  '<a href="'+url_file_det+'">'+js_folder[i].label+'</a>'+
                  // '<ol></ol>'+
                '</li>';
          console.log(el_acuan);
          // $('#laporan-tahunan>ol').append(el_acuan);
          $('#laporan-tahunan>ul').append(el_acuan);
          // $('#perpustakaan ol li[name="'+js_folder[i].label+'"]').append('<ol></ol>');
          //\buat elemen acuan



          // let jss_det = _ajax_type('GET', 'text', url_file_det, '');

          // $(jss_det).find('td a').each(function () {
          //   if( $(this).text() != 'Parent Directory'){
          //     let href = $(this).attr('href');
          //     let el_selector_det = {
          //       // href : href,
          //       href : url_file_det+href,
          //       label: decodeURIComponent(href)
          //     };

          //     js_file.push( el_selector_det );

          //     //buat elemen acuan_det
          //     let el_acuan_det = '<li><a href="'+el_selector_det.href+'">'+el_selector_det.label+'</a></li>';
          //     $('#laporan-tahunan>ol>li[name="'+js_folder[i].label+'"]>ol').append(el_acuan_det);
          //     //\buat elemen acuan_det
          //   }
              
          // });
          // console.log(js_file);


          // // memasukkan ke master. TERTATA RAPI
          // let a = {
          //   label_acuan : js_folder[i].label,
          //   list        : js_file
          // };
          // js_file_mst.push(a);

        }

        // console.log(js_file_mst);

      });

        
        
  }

  //***************************************************/
  //       \bo/menu/laporan-tahunan
  //***************************************************/

  //***************************************************/
  //       bo/menu/surat-keterangan-kematian
  //***************************************************/
  if( open_site('bo/menu/surat-keterangan-kematian') ){
    alert('tes');
    $('button[name=btn_dl_surat_ket_kematian]').click(function(e){
      e.preventDefault();
      let norm = $('input[name=norm]').val();
      let tgl_meninggal = $('input[name=tgl_meninggal]').val();
      let kd_dokter = $('input[name=kd_dokter]').val();
      let dokter = $('select[name=dokter]').val();
      
      if(norm==''||tgl_meninggal==''||kd_dokter==''){
        alert('Semua kolom isian harus terisi.');
      }else{
        $.redirect(baseUrl()+'ajaxreq/viewpdf_surat_ket_kematian/'+norm+'/'+tgl_meninggal+'/'+kd_dokter+'/'+dokter);
      }
      
    });
  }

  //***************************************************/
  //       \bo/menu/rm/surat-keterangan-kematian
  //***************************************************/



  //***************************************************/
  //       bo/menu/mutu/laporan_indikator_mutu
  //***************************************************/
  if( open_site('bo/menu/mutu/laporan_indikator_mutu') ){
    let _user_logged_in = $('body').data('user_logged_in');

    // let js_mutu = select_lapIndikatorMutu_all();
    // console.log(js_mutu);
    // create_tbl_mutu_mst(js_mutu);

    $('button[name=btn_insert_lapIndikatorMutu]').click(function(e){
      e.preventDefault();
      let jPost = {
        pelayanan : $('select[name=sel_jnsPelayananDivisi]').val(),
        indikator : $('textarea[name=indikator]').val(),
        standar   : $('input[name=standar]').val(),
        satuanStandar : $('select[name=satuanStandar]').val()
      };
      console.log(jPost);

      $.ajax({
        async : false,
        url   : baseUrl()+'ajaxreq/insert_lapIndikatorMutu',
        type  : "POST",
        data  : jPost,
        success:function(data){ //{string}
          let x = JSON.parse( data );
          console.log(x);
          alert(x.message);
        },
        error:function(jqXHR,textStatus,errorThrown){
          console.log("ERROR[ajaxreq/insert_lapIndikatorMutu]: "+errorThrown);
        }
      });

      window.location.reload(true);
    });




    // var table = $('table[name=tbl_mutu_mst]').DataTable();
     
    // $('table[name=tbl_mutu_mst] tbody').on('click', 'tr', function () {
    //     var data = table.row( this ).data();
    //     alert( 'You clicked on '+data[0]+'\'s row' );
    // } );





    let bln_pilih = '',
        thn_pilih = '',
        thn_grf_pilih = '',
        pelayanan_grf_pilih = '';


    //onchange sel_divisi_grf

    $('select[name=sel_divisi_grf]').on('change', function(){  
      pelayanan_grf_pilih = $(this).val();
      thn_grf_pilih       = $('select[name=sel_tahun_grf]').val();
      console.log([pelayanan_grf_pilih,thn_grf_pilih]);

      let js = _ajax('GET', 'select_grf_indikator_by_pelayanan_th', {pelayanan:pelayanan_grf_pilih, tahun:thn_grf_pilih});
      console.log(js);

      $('select[name=sel_indikator_grf]').children().remove();
      for(let i=0; i<js.length; i++){
        let el = '<option value="'+js[i].id+'">'+js[i].indikator+'</option>';
        $('select[name=sel_indikator_grf]').append(el);
      }
      
    });

    $('button[name=btn_ld_grfIndikatorMutu]').click(function(e){
      e.preventDefault();
      let idIndikator = $('select[name=sel_indikator_grf]').val();
      console.log(idIndikator);
      let js = _ajax('GET', 'select_grf_indikator_by_idindikator_pelayanan_th', {idIndikator:idIndikator, pelayanan:pelayanan_grf_pilih, tahun:thn_grf_pilih});
      console.log({js:js});


      let objLine = ['Indikator'],
          jPost_data_grf = [["0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0"]];
          // jPost_data_grf = [["32", "47", "25", "25", "21", "15", "32", "17", "25", "25", "21", "15"]];

      // TRANSLATER
      for(let i=0; i<js.length; i++){
        jPost_data_grf[0][js[i].bulan-1] = js[i].nilai;
      }
      //---------------  <BOX:grf_line_indikatormutu> ----------------

      

      console.log([objLine,jPost_data_grf]);

      // chartjs_line('grf_line_indikatormutu', jPost_data_grf, penanggung_list_grf); //penanggung_list_grf = var line
      chartjs_line('grf_line_indikatormutu', jPost_data_grf, objLine); //penanggung_list_grf = var line

      //---------------  <\BOX:grf_line_indikatormutu> ----------------
    });

    $('button[name=btn_ld_lapIndikatorMutu]').click(function(e){
      e.preventDefault();
      
      //buat logika untuk MANAGER
      let filter_pelayanan = $('select[name=sel_jnsPelayananDivisi_filter]').val();
      let level_page = $('input[name=level_page]').val();
      console.log(level_page);

      // if(level_page == 'MANAGER'){
      //   js_mutu = _ajax('GET', 'select_lapIndikatorMutu_all', ''); // jika MANAGER
      // }else if(level_page == 'MEMBER'){
      //   js_mutu = _ajax('GET', 'select_indikator_by_divisi', {pelayanan:filter_pelayanan}); // jika MEMBER
      // }

      js_mutu = _ajax('GET', 'select_indikator_by_divisi', {pelayanan:filter_pelayanan});
      
      create_tbl_mutu_mst(js_mutu);
      // console.log(js_mutu);


      bln_pilih = $('select[name=sel_mutu_bulan]').val();
      thn_pilih = $('select[name=sel_mutu_tahun]').val();
      console.log(bln_pilih+'_'+thn_pilih);
      let jPost = {
        bulan : bln_pilih,
        tahun : thn_pilih,
        pelayanan : filter_pelayanan
      };
      // let js_ind = select_nd_indikator_by_bln_thn(jPost);
      let js_ind = _ajax('GET', 'select_nd_indikator_by_bln_thn_pelayanan', jPost);
      console.log(js_ind);
      // create_tbl_mutu_mst(js_ind);
      // console.log(js_ind.datajs[0].nilai);

      for(let i=0; i<js_ind.datajs.length; i++){
        let el_loc = 'table[name=tbl_mutu_mst] tbody tr[data-id="'+js_ind.datajs[i].idIndikator+'"]';
        $(el_loc+' td input[name=N]').val(js_ind.datajs[i].N);
        $(el_loc+' td input[name=D]').val(js_ind.datajs[i].D);
        $(el_loc+' td[name=nilai]').text(js_ind.datajs[i].nilai);
        // console.log(js_ind.datajs[i]);
        // $('table[name=tbl_mutu_mst]').DataTable().row(el_loc+' td input[name=N]').val(js_ind.datajs[i].N);
        // $('table[name=tbl_mutu_mst]').DataTable().row(1).col(1).data(js_ind.datajs[i].N);
        // $('table[name=tbl_mutu_mst]').DataTable().row(1).data(js_ind.datajs[i].N);
        // $('table[name=tbl_mutu_mst]').DataTable().row(1).data().search(js_ind.datajs[0].idIndikator);

      }

    });

    // let nilai = (198*100/235).toFixed(2);
    let nilai = (0*100/235).toFixed(2);
    console.log(nilai);
    // $(document).on('click','table[name=tbl_mutu_mst] tbody tr td button', function(){
    $(document).on('click','table[name=tbl_mutu_mst] tbody tr td button[name=btn_list_upload]', function(){
      let id = $(this).parent().parent().data('id'),
          N = $('tr[data-id='+id+'] td input[name=N]').val(),
          D = $('tr[data-id='+id+'] td input[name=D]').val(),
          nilai = '';

      if(N =='' || D==''){
        nilai = 0;
      }else{
        if(N ==0 || D==0){
          nilai = 0;
        }else{
          nilai = (N*100/D).toFixed(2);
        }
      }

      let jPost = {
          idIndikator : id,
          bulan : $('select[name=sel_mutu_bulan]').val(),
          tahun : $('select[name=sel_mutu_tahun]').val(),
          N     : N,
          D     : D,
          nilai : nilai,
          user  : _user_logged_in,
          date : moment().format('YYYY-MM-DD'),
          time : moment().format('HH:mm:ss')
        };

      console.log(id);
      console.log(jPost);

      // let js_in_ind = insert_nd_indikator(jPost);
      let js_in_ind = select_nd_indikator_by_id(jPost); //upload
      console.log(js_in_ind);

      //-- load again. perbaharui tabel
      $('button[name=btn_ld_lapIndikatorMutu]').trigger('click');
    });

    let id = '',
        pelayanan = '',
        indikator = '',
        standar   = '';
    $(document).on('click','table[name=tbl_mutu_mst] tbody tr td button[name=btn_list_edit]', function(){
        id = $(this).parent().parent().data('id');
        pelayanan = $('tr[data-id='+id+'] td[name=pelayanan]').text();
        indikator = $('tr[data-id='+id+'] td[name=indikator]').text();
        standar   = $('tr[data-id='+id+'] td[name=standar]').text();
        console.log(id+'_'+indikator);

        //-- load data on modal
        // $('#el_modal_mutu_edit table tr').find('select[name=sel_jnsPelayananDivisi]').val(id);
        $('#el_modal_mutu_edit table tr').find('select[name=MDEL_sel_jnsPelayananDivisi] option').removeAttr('selected');
        $('#el_modal_mutu_edit table tr').find('select[name=MDEL_sel_jnsPelayananDivisi] option[value="'+pelayanan+'"]').attr('selected','selected');

        $('#el_modal_mutu_edit table tr').find('textarea[name=MDEL_indikator]').val(indikator);
        $('#el_modal_mutu_edit table tr').find('input[name=MDEL_standar]').val(standar);
        $('#modal_mutu_edit').modal('show');

    });

    $(document).on('click','button[name=btn_mutu_edit]', function(){
      console.log(id);        
      let jPost = {
        id        : id,
        pelayanan : $('select[name=MDEL_sel_jnsPelayananDivisi]').val(),
        indikator : $('textarea[name=MDEL_indikator]').val(),
        standar   : $('input[name=MDEL_standar]').val(),
        satuanStandar : $('select[name=MDEL_satuanStandar]').val()
      };
      console.log(jPost);
      let js_ind_upd = update_indikator(jPost);
      console.log(js_ind_upd);

      //-- load again. perbaharui tabel
      $('button[name=btn_ld_lapIndikatorMutu]').trigger('click');

      $('#modal_mutu_edit').modal('hide');
    });

    $(document).on('click','button[name=btn_list_hapus]', function(){ //delete_indikator
      id = $(this).parent().parent().data('id');
      let jPost = {
        id : id
      };
      console.log(jPost);

      let js_ind_del = delete_indikator(jPost);
      console.log(js_ind_del);

      //-- load again. perbaharui tabel
      $('button[name=btn_ld_lapIndikatorMutu]').trigger('click');
    });


  }
  //***************************************************/
  //       \bo/menu/mutu/laporan_indikator_mutu
  //***************************************************/

  //***************************************************/
  //       bo/menu/mutu/rekap-irs
  //***************************************************/
  if( open_site('bo/menu/mutu/rekap-irs') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $(".datepicker-bln").datepicker({
      autoclose : true,   
      format  : 'yyyy-mm',
      startView: "months", 
      minViewMode: "months"
    });

    

    let th_bln = '',
        divisi = '';

    $('button[name=btn_rekap_irs_download]').click(function(e){
      e.preventDefault();
      th_bln = $('input[name=th_bln]').val();
      divisi = $('select[name=divisi]').val();
      if(th_bln == ''){
        alert("Kolom harus terisi.")
        return 0;
      }
      
      window.open(baseUrl()+"ajaxreq/laporan_irsbulanan/"+th_bln+"/"+divisi+"/1");
    });

    $('button[name=btn_rekap_irs]').click(function(e){
      e.preventDefault();
      th_bln = $('input[name=th_bln]').val();
      divisi = $('select[name=divisi]').val();
      if(th_bln == ''){
        alert("Kolom harus terisi.")
        return 0;
      }
      
      let dt = month_now_yesterday(th_bln+'-01');
      console.log([th_bln, divisi, dt]);
      $('.box-title').text(divisi+' - '+dt.now.bulan_indo+' '+dt.now.year);

      let js = '', rkp_irs_bln='';
      js = _ajax("GET", "select_irs_indikator", "");
      console.log(js);
      
      rkp_irs_bln = _ajax("GET", "rekap_irs_bulanan/"+th_bln+"/"+divisi, "");
      console.log(rkp_irs_bln);

      let th_list = [
        'NO.', 'IRS', 'INDIKATOR',
      ];        

      let n=dt.now.maxday;
      let arr_day = [];
      let el_dayval = [];//'<td>0</td>'

      // LOOP TANGGAL
      for(let day=0; day<n; day++){
        arr_day[day] = day+1;
        th_list.push(arr_day[day]);
        // el_dayval += '<td><a data-id="'+arr_day[day]+'">0</a></td>';
      }
      create_tbl('tbl_rekap_irs', th_list);
      console.log(arr_day);
      console.log(th_list);

      


      for(let i=0; i<js.length; i++){
        arr_day = [];
        for(let day=0; day<n; day++){
          arr_day[day] = day+1;  
          el_dayval[i] += '<td><a data-id="'+arr_day[day]+'" data-mx="'+(i+1)+'_'+arr_day[day]+'">'+rkp_irs_bln[i][day]+'</a></td>';
        }
        
          let el = 
          '<tr data-id_ind="'+js[i].id+'">'+
            '<td>'+(i+1)+'</td>'+
            '<td>'+js[i].IRS+'</td>'+
            '<td>'+js[i].indikator+'</td>'+
            el_dayval[i]+
          '</tr>';
          $('table[name=tbl_rekap_irs]>tbody').append(el);
        // }
      }

      
    });

    let id_tgl = '',
        lbl_tgl = '',
        id_indikator = '';
    $(document).on('click','table[name=tbl_rekap_irs] tbody tr td a', function(e){
      e.preventDefault();
      id_tgl = $(this).data("id");
      if(id_tgl<10){
        lbl_tgl = "0"+id_tgl;
      }else{
        lbl_tgl = id_tgl;
      }

      id_indikator = $(this).parent().parent().data('id_ind');
      console.log([id_tgl, id_indikator]);
      // let get_bill = $(this).parent().parent().data('nobill');

      $('input[name=date_isi]').val( $(this).text() );
      $('#modal_entry_irs').modal('show');
      // return false;
    });

    $(document).on('click','button[name=btn_simpan_irs]', function(e){
      e.preventDefault();
      let val = $('input[name=date_isi]').val();
      console.log(val);

      let js = _ajax("POST", "update_irs_bln_val/"+divisi+"/"+th_bln+"-"+lbl_tgl+"/"+id_indikator+"/"+val, "");
      console.log(js);

      $('#modal_entry_irs').modal('hide');
      $('input[name=date_isi]').val('');
      
      $('table[name=tbl_rekap_irs] tbody tr td a[data-mx="'+id_indikator+'_'+id_tgl+'"]').text(val);
    });
  }

  //***************************************************/
  //      \bo/menu/mutu/rekap-irs
  //***************************************************/



  
  //***************************************************/
  //       bo/menu/insiden-keselamatan-px/entry-insiden
  //***************************************************/
  if( open_site('bo/menu/insiden-keselamatan-px/entry-insiden') ){
    let _user_logged_in = $('body').data('user_logged_in');
    console.log(_user_logged_in);
    
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });
    
    // $('.datepicker').datetimepicker({
    //   autoclose : true,
    //   // format    : 'yyyy-mm-dd'
    //   format    : 'yyyy-mm-dd hh:ii:ss'
    // });

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
    

    let kliniks = _ajax('GET', 'get_klinik', '').dtjs;
    console.log(kliniks);

    let el_kli = '';
    for (let k = 0; k < kliniks.length; k++) {
      el_kli += '<option value="'+kliniks[k].Kode+'">'+kliniks[k].Keterangan+'</option>';
    }
    $('select[name=lokasiInsiden]').append(el_kli);

    let jns = '';
    $('select[name=jns]').on('change', function(){  
      jns = $(this).val();
      console.log(jns);
      if(jns=='KPC'){
        $('.non_kpc').hide();
      }else{
        $('.non_kpc').show();
      }
      // kelas_bpjs = $(this).find(":selected").data("bpjs");
    });



    let nobill = '';
    let cari_px = null;
    $("input[name=nobill]").keypress(function (e) { //TEKAN ENTER
      nobill = $(this).val();
      // console.log(norm);
      if (e.which == 13) {
        cari_px = _ajax('GET', 'db/m_daftarmandiri/select_fotrdaftar_by_bill/'+nobill, '');
        console.log(cari_px);

        if(cari_px.length<0){ alert("Data tidak ditemukan."); }
        else { cari_px = cari_px[0]; }

        console.log(cari_px);
        //cari_px.PerusahaanPenanggung
        let asuransi = '';
        if(cari_px.PerusahaanPenanggung== ''){
          asuransi = 'UMUM';
        }else if(cari_px.PerusahaanPenanggung== 'CO031'){
          asuransi = 'BPJS';
        }else{
          asuransi = 'ASURANSI LAIN';
        }
        console.log(cari_px.PerusahaanPenanggung);
        console.log(asuransi);

        let jnsAsuh = '';
        if(cari_px.StatusDaftar == 'UG') jnsAsuh = 'IGD';
        else jnsAsuh = cari_px.StatusDaftar;

        $('input[name=norm]').val(cari_px.NoRM);
        $('input[name=nama]').val(cari_px.Nama);
        $('input[name=gender]').val(cari_px.Sex);
        $('#tgl_masuk').val(cari_px.TanggalMasuk);
        $('input[name=jnsAsuhx]').val(jnsAsuh);
        $('input[name=jnsAsuh]').val(jnsAsuh);
        $('select[name=asuransix] option[value="'+asuransi+'"]').attr('selected','selected');
        $('input[name=asuransi]').val(asuransi);
        
        
        return false;

      }
    });
      

    

    // function form_post(){
      $('.Form_post').submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        let url  = $(this).attr('action');
        console.log([data, url]);

        let js = _ajax_web("POST", baseUrl()+"akreditasi/insert_insiden/akinsiden", data );
        console.log(js);

        if(js.code==200){
          alert(js.message);
          reload();
        }else{
          alert('Tidak Berhasil Entry. Ulangi proses.');
        }

        return false;
      });
    // }

    // form_post();


  }
  //***************************************************/
  //       \bo/menu/insiden-keselamatan-px/entry-insiden
  //***************************************************/



  
  
  //***************************************************/
  //       bo/menu/insiden-keselamatan-px/lap-insiden
  //***************************************************/
  if( open_site('bo/menu/insiden-keselamatan-px/lap-insiden') ){
    let _user_logged_in = $('body').data('user_logged_in');
    console.log(_user_logged_in);
    
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('#btn_ld').click(function(e){
      e.preventDefault();

      
      if($('#in_datestart').val() == '' || $('#in_dateend').val() == ''){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      js = _ajax("GET", "db/m_akreditasi/lap_insiden/"+$('#in_datestart').val()+"/"+$('#in_dateend').val() , "");
      console.log(js);

      // return false;
      
      let tbl = {
        id : 'tbl_ld_res',
        headers : [
          ['nobill', 'NOBILL', 'style="text-align:center;"',], 
          ['NoRM','NORM'], 
          ['Nama','NAMA'], 
          ['jnsAsuh','JENIS ASUHAN'],
          // ['tglIns','TGL INSIDEN'], 
          // ['jamIns','JAM INSIDEN'], 
          ['datetime','WAKTU INSIDEN'],
          ['grade','GRADE'], 
          ['jnsInsiden','JENIS INSIDEN'], 
          ['insiden','INSIDEN'], 
        ],
        data : js,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'DETAIL',
        },
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      $('#tbl_store').children().remove();
      $('#tbl_store').append(el_tbl);
      $('#tbl_ld_res').DataTable({"scrollX": true});
      

    });
    
    
    let cari_px = null;

    $(document).on('click','#tbl_ld_res tbody tr td button', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(id);

      
      js_sel = js[id];
      console.log(js_sel);

            
      $('select option').removeAttr('selected');

      $('#mdl_det').modal('show');

      //--LOAD LOKASI KLINIK
      let kliniks = _ajax('GET', 'get_klinik', '').dtjs;
      console.log(kliniks);

      let el_kli = '';
      for (let k = 0; k < kliniks.length; k++) {
        el_kli += '<option value="'+kliniks[k].Kode+'">'+kliniks[k].Keterangan+'</option>';
      }
      $('select[name=lokasiInsiden]').append(el_kli);
      //\--LOAD LOKASI KLINIK



      // console.log( $('#tbl_mdl_p1')[0] );
      $('#tbl_mdl_p1 input[name=nobill]').val(js_sel.nobill);
      $('#tbl_mdl_p1 input[name=norm]').val(js_sel.NoRM);
      $('#tbl_mdl_p1 input[name=nama]').val(js_sel.Nama);
      $('#tbl_mdl_p1 input[name=gender]').val(js_sel.Sex);
      $('#tbl_mdl_p1 #tgl_masuk').val(js_sel.TanggalMasuk);
      $('#tbl_mdl_p1 input[name=jnsAsuhx]').val(js_sel.jnsAsuh);
      $('#tbl_mdl_p1 input[name=tglIns]').val(js_sel.tglIns);
      $('#tbl_mdl_p1 input[name=jamIns]').val(js_sel.jamIns);
      $('#tbl_mdl_p1 textarea[name=insiden]').val(js_sel.insiden);
      $('#tbl_mdl_p1 input[name=grade]').val([js_sel.grade]);
      $('#tbl_mdl_p1 textarea[name=kronologis]').val(js_sel.kronologis);
      $('#tbl_mdl_p1 textarea[name=lokasiKejadian]').val(js_sel.lokasiKejadian);
      $('select[name=asuransi] option[value="'+js_sel.asuransi+'"]').attr('selected','selected');
      $('select[name=jnsInsiden] option[value="'+js_sel.jnsInsiden+'"]').attr('selected','selected');
      $('select[name=pelapor] option[value="'+js_sel.pelapor+'"]').attr('selected','selected');


      
      $('select[name=lokasiInsiden] option[value="'+js_sel.lokasiInsiden+'"]').attr('selected','selected');
      $('select[name=unitPenyebab] option[value="'+js_sel.unitPenyebab+'"]').attr('selected','selected');
      $('select[name=dampak] option[value="'+js_sel.dampak+'"]').attr('selected','selected');
      $('#tbl_mdl_p2 textarea[name=tdknStlhKejadian]').val(js_sel.tdknStlhKejadian);
      $('#tbl_mdl_p2 input[name=pelakuTindakan]').val(js_sel.pelakuTindakan);
      $('#tbl_mdl_p2 textarea[name=insidenSerupa]').val(js_sel.insidenSerupa);
      $('#tbl_mdl_p2 textarea[name=analisaRCA]').val(js_sel.analisaRCA);

    });

    

    
    $('#btn_dl_excel').click(function(e){
      e.preventDefault();
      if( $('#in_datestart').val() == '' || $('#in_dateend').val() == '' ){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      let filename = "Laporan Insiden_"+$('#in_datestart').val()+"_"+$('#in_dateend').val();
      window.open(baseUrl()+'ajaxreq/xls/m_akreditasi/lap_insiden/'+$('#in_datestart').val()+"/"+$('#in_dateend').val()+"?filename="+filename, '');
        
    });
    
  }
  //***************************************************/
  //       \bo/menu/insiden-keselamatan-px/lap-insiden
  //***************************************************/




  //***************************************************/
  //       bo/menu/sdm/legalitas-karyawan
  //***************************************************/
  if( open_site('bo/menu/sdm/legalitas-karyawan') ){
    let ip_server = location.host;      
    console.log(ip_server);

    let js_folder = [],
        js_file_mst = [];
    
    // let url_file_utama = 'http://192.168.1.68/rscm/APP FILES/KUMPULAN UNDANG-UNDANG POKJA/';
    // let url_file_utama = 'http://'+ip_server+'/rscm/APP FILES/SDM/SIP DOKTER/';


    // var db = [{
    //     "name": "John Doe",
    //     "age": 25
    //   }, {
    //       "name": "John Doe 2",
    //       "age": 21
    //   }];
      
    //   $.each(db, function(index, object) {
    //       for (var property in object) {
    //           var val = object[property];
    //           // do stuff
    //           console.log("property: " + property + ", val: " + val);
    //       }
    //   });



    let url_file_utamaX = 'https://192.168.1.5/rscm/APP FILES/SDM/list.php';
    // let jssX = _ajax_type('GET', 'json', url_file_utamaX, '');
    let jssX = _ajax_web('GET', url_file_utamaX, '');
    console.log(jssX);
    
    console.log("!!! Kalau tidak bisa load, buka new tab : https://192.168.1.5/rscm/APP%20FILES/SDM/list.php" +
        " . Kemudian, klik ADVANCE. Proccess to ...");


    // let key = Object.keys(jssX);
    // console.log(jssX[3].isi[1].label);
    // console.log(key.length);
    // return false;

    // let r = JSON.parse( JSON.stringify(jssX));
    
    for(let i=0; i<Object.keys(jssX).length; i++){ // el_acuan
      let el_nama = '';

      // for(let j=0; j<jssX[i].isi.length; j++){ // el_nama
      for(let j=0; j<Object.keys(jssX[i].isi).length; j++){ // el_nama
        let el_namaFile = '';
        if(jssX[i].isi[j] == undefined){
          console.log(['undef', jssX[i].label, i, j]);
          j++;

        }else{
            // for(let k=0; k<jssX[i].isi[j].isi.length; k++){ // el_namafile
            for(let k=0; k<Object.keys(jssX[i].isi[j].isi).length; k++){ // el_namafile
              el_namaFile += 
                '<li class="disable-ol">'+
                  '<span><a target="_blank" href="'+jssX[i].isi[j].isi[k].url+'">'+jssX[i].isi[j].isi[k].label+'</a></span>'+
                  // '<ol>'+el_namaFile+'</ol>'+
                '</li>';
                // CHECKING INI
                // console.log([i, j,k]);
                // console.log([jssX[i].isi[j].label, jssX[i].isi[j].isi[k].url]);
            }
            // console.log(jssX[i].label);
            el_nama += 
                '<li class="disable-ol">'+
                  '<span>'+jssX[i].isi[j].label+'</span>'+
                  '<ol>'+el_namaFile+'</ol>'+
                '</li>';
        }
        
        
      }

      let el_acuan = 
            '<li class="disable-ol">'+
              '<span>'+jssX[i].label+'</span>'+
              '<ol>'+el_nama+'</ol>'+
            '</li>';
      // console.log(el_acuan);
      $('#perpustakaan>ol').append(el_acuan);
    }

    return false;

    // $.each(jssX, function(index, object) {
    //   for (let property in object) {
    //     console.log([index , object]);
    //       let val = object[property];
    //       // do stuff
    //       // console.log("property: " + property + ", val: " + val);
    //       console.log({"property": property , "val " : val});
    //   }
    // });
    
    
    // USED
    let url_file_utama = 'https://'+ip_server+'/rscm/APP FILES/SDM/LEGALITAS KARYAWAN/';
    let jss = _ajax_type('GET', 'text', url_file_utama, '');
    // console.log(jss);
    
    
    
    
    
    
    $(jss).find('tr td img').each(function () {
      if( $(this).attr('alt') == '[DIR]'){
        // let el_selector_href = $(this).parent().parent().find('td a').attr('href');
        let href = $(this).parent().parent().find('td a').attr('href');
        let el_selector = {
          href : href,
          label: decodeURIComponent(href)
        };
        // $("#folderNames").append( '<li><a href="'+url_file_utama+el_selector.href+'">'+el_selector.label+'</a></li>');
        js_folder.push( el_selector );
        
      }              
    });
    console.log(js_folder);          
    
    // return false;

    // js_folder[] = NAMA ACUAN
    //LOAD TIAP ACUAN
    for(let i=0; i<js_folder.length; i++){
      let js_file   = [];
      let url_file_det = url_file_utama+js_folder[i].label;
      console.log(url_file_det);


      //buat elemen acuan
      // $('#perpustakaan').append('<ol></ol>');
      let el_acuan = 
            '<li name="'+js_folder[i].label+'" class="disable-ol">'+
              '<span>'+js_folder[i].label+'</span>'+
              '<ol></ol>'+
            '</li>';
      console.log(el_acuan);
      $('#perpustakaan>ol').append(el_acuan);
      // $('#perpustakaan ol li[name="'+js_folder[i].label+'"]').append('<ol></ol>');
      //\buat elemen acuan



      let jss_det = _ajax_type('GET', 'text', url_file_det, '');

      $(jss_det).find('td a').each(function () {
        if( $(this).text() != 'Parent Directory'){
          let href = $(this).attr('href');
          let el_selector_det = {
            // href : href,
            href : url_file_det+href,
            label: decodeURIComponent(href)
          };

          js_file.push( el_selector_det );

          //buat elemen acuan_det
          let el_acuan_det = '<li class="disable-ol"><a href="'+el_selector_det.href+'">'+el_selector_det.label+'</a></li>';
          $('#perpustakaan>ol>li[name="'+js_folder[i].label+'"]>ol').append(el_acuan_det);
          //\buat elemen acuan_det
        }
          
      });
      console.log(js_file);


      // memasukkan ke master. TERTATA RAPI
      let a = {
        label_acuan : js_folder[i].label,
        list        : js_file
      };
      js_file_mst.push(a);

    }
    console.log(js_file_mst);
      
  }

  //***************************************************/
  //       \bo/menu/sdm/legalitas-karyawan
  //***************************************************/



  //***************************************************/
  //        bo/menu/sdm/pdf-view
  //***************************************************/
  if( open_site('bo/menu/sdm/pdf-view') ){
    console.log("ok");
    // $("#main_body").media({width: 868});
    // $(".media").media({width: 868});

    let viewer = $("#viewpdf");
    let loc = baseUrl()+"uploads/hrd/pdf/";
    let filename = "tutorial-awal-dengan-zend-framework_123";
    PDFObject.embed(loc+filename+'.pdf', viewer);


    $('#frm_upload_pdf').submit(function(e){
      e.preventDefault(); 
      console.log(new FormData(this));
      $.ajax({
        async:false,
        // url : baseUrl()+'upload/do_upload/ttd', //URL submit
        url : baseUrl()+'upload/upload_pdf', //URL submit
        type: "POST", //method Submit
        enctype: 'multipart/form-data',
        data: new FormData(this), //penggunaan FormData
        processData:false,
        contentType:false,
        cache:false,
        success: function(data){
          // console.log(data);
          // alert("Upload Image Berhasil."); //alert jika upload berhasil
          Swal.fire({
            position: 'center',
            type : 'success',
            title: 'Upload Berhasil.',
            showConfirmButton: true
          });
        }
      });
      return false;
    });

  }

  //***************************************************/
  //        \bo/menu/sdm/pdf-view
  //***************************************************/



  //***************************************************/
  //        bo/menu/casemix/master_cp
  //***************************************************/
  if( open_site('bo/menu/casemix/master_cp') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _arr_sel_kegiatan_all = _ajax('GET','select_mst_kegiatan','');
    console.log(_arr_sel_kegiatan_all);

    for(let i=0; i<_arr_sel_kegiatan_all.length; i++){
      console.log();
      let el='<option value="'+_arr_sel_kegiatan_all[i].kegiatan+'">'+_arr_sel_kegiatan_all[i].kegiatan+'</option>';
      $('select.sel_kegiatan').append(el);
    }

    $('button[name=btn_insert_kegiatan]').click(function(){
      let kegiatan = $('input[name=kegiatan]').val();
      console.log(kegiatan);
      let jPost = {
        id      : '',
        kegiatan: kegiatan,
        user    : _user_logged_in,
        date    : moment().format('YYYY-MM-DD'),
        time    : moment().format('HH:mm:ss')
      }
      let dt = _ajax('POST','insert_mst_kegiatan',jPost);
      console.log(dt);
      $('input[name=kegiatan]').val('');
    });


    $('button[name=btn_mdl_det_kegiatan]').click(function(){
      let kegiatan = $('select[name=sel_kegiatan_cp]').val();
      console.log(kegiatan);
      // let jPost = {
      //   id      : '',
      //   kegiatan: kegiatan,
      //   user    : _user_logged_in,
      //   date    : moment().format('YYYY-MM-DD'),
      //   time    : moment().format('HH:mm:ss')
      // }
      // let dt = _ajax('POST','insert_mst_kegiatan',jPost);
      // console.log(dt);
      // $('input[name=kegiatan]').val('');
    });

  }
  //***************************************************/
  //       \bo/menu/casemix/master_cp
  //***************************************************/



  //***************************************************/
  //       bo/menu/casemix/pantauan_biaya_ri
  //***************************************************/
  if( open_site('bo/menu/casemix/pantauan_biaya_ri') ){
    let _user_logged_in = $('body').data('user_logged_in');

    let dt,
        // dtpx = null,
        biopx = null,
        js_histo,
        js_sepcbg = null,
        data_rec;
    

    let nobill  = '',
        norm    = '',
        sep     = '',
        dpjp    = '',
        status_kelas= '',
        // status_kelas_bpjs= '',
        hakKelas    = '',
        kelas       = '',
        kelas_bpjs  = '',
        kelas_bpjs_indikator  = '',
        id_histori  = 0;
    
    let bayi = 0,
        lbl_umur = '',
        icu_indicator = 0,
        los = 0;

    let grandTotalRs = 0, // penjumlahan debet dan kredit
        totalTarifRs = 0;
        // tarif_inacbg = 0;

    let trf_rs_ina = null;

    let sel_dpjp_auto = null;
    
    let dpjp_kode = '', dpjp_nama = '', 
        dpjp_type='';
    // $('.select2').select2();


    function my_diff(start=null, end=null, param=null ){
      let a = moment( start );
      let b = moment( end );
      //let diffInDays = a.diff(b, 'days');
      //let dur = moment.duration(a.diff(b, 'days'));
      let dur = moment.duration(a.diff(b));
      if(param == 'tahun'){
        return dur.get('years');
      }else if(param == 'bulan'){
        return dur.get('months');
      }else if(param == 'hari'){
        return dur.get('days');
      }else if(param == 'object'){
        return dur;
      }else{
        return '';
      }
    }


    //Date picker
    $('.datepicker_krs').datepicker({
        autoclose : true,
        // format    : 'dd/mm/yyyy'
        format    : 'yyyy-mm-dd'
      }).on("change", function(e){
        e.preventDefault();
        console.log($(this).val());
        if($('input[name=tgl_mrs]').val()== ''){
          alert('Kolom No.Billing harus diisi terlebih dahulu.')
        }else{
          los = my_diff($('input[name=tgl_krs]').val(), $('input[name=tgl_mrs]').val(), 'hari')+1;
          if(los < 1){
            alert('Tanggal keluar harus lebih akhir dari tanggal masuk.');
            return 0;
          }else{          
            console.log(los);
            $('#los').text(los);
          }
        }
    });

    $('input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });

    //Money Euro
    // $('[data-mask]').inputmask();
        
    let fLoad = _ajax_web('GET', baseUrl()+'casemix/first_load_eclaim','');
    console.log(fLoad);

    // let js_dpjp_new = _ajax('GET','get_dokter_luar_dalam/ALL','');
    let js_dpjp_new = fLoad['js_dpjp_new'];
    console.log(js_dpjp_new);
    
    // PUSH AUTOCOMPLETE
    for (let dpjp = 0; dpjp < js_dpjp_new.length; dpjp++) {     
      js_dpjp_new[dpjp]['value'] = js_dpjp_new[dpjp].nama;
      js_dpjp_new[dpjp]['label'] = js_dpjp_new[dpjp].nama+'('+js_dpjp_new[dpjp].kode+')';
    }
    
    $("#sel_dpjp_auto").autocomplete({
      source: js_dpjp_new,
      minLength: 2,
      select: function( event, ui ) {
        // console.log(ui); console.log(event);
        sel_dpjp_auto = ui.item;
        // console.log(sel_dpjp_auto);
        dpjp_type = sel_dpjp_auto.type;
        dpjp_kode = sel_dpjp_auto.kode;
        dpjp_nama = sel_dpjp_auto.nama;
        console.log([dpjp_type, dpjp_kode, dpjp_nama]);
      }
    });




    // let js_ckeluar = _ajax('GET','get_carakeluar','');
    let js_ckeluar = fLoad['js_ckeluar'];
    console.log(js_ckeluar);
    
    for (let c = 0; c < js_ckeluar.length; c++) {
      let el = '<option value="'+js_ckeluar[c].kode+'" data-inakode="'+js_ckeluar[c].inakode+'">'+js_ckeluar[c].inaket+'</option>';
      $('#discharge_status').append(el);
    }
    

    $("input[name=nobill]").focus();
    $("input[name=nobill]").keypress(function (e) { 
      nobill = $(this).val();
      if (e.which == 13) { //TEKAN ENTER
        console.log(nobill);

        let billEnterAll = _ajax_web("GET", baseUrl()+"casemix/billing_enter_eclaim/"+nobill, "");
        let billEnter = billEnterAll.rs;
        payment = billEnter.payment;
        
        // dtpx = billEnter.dtpx;
        biopx = billEnter.biopx;

        if(payment.length <= 0){
          alert('Data Billing(Detail Biaya RI) tidak ditemukan. [BUG] Kemungkinan belum ada payment.');
          return false;
        }else{
          console.log(payment);
        }


        if(biopx.StatusDaftar == "RJ" || biopx.StatusDaftar == "UG"){
          if(biopx.StatusDaftar == "UG"){
            $('.menu_igd').show();
          }

          $('.menu_rj').show();

          $('#btnDetailBill_pdf').attr("href",baseUrl()+"ajaxreq/modif_gd_biaya_ri_det_by_billing_pdf_v2/"+nobill);

          $('input[name=tgl_krs]').val(biopx.TanggalMasuk);

          for (let d = 0; d < js_dpjp_new.length; d++) {
            // if(js_dpjp_new[d]['kode'] == biopx.segment_det.Dokter){                
            if(js_dpjp_new[d]['kode'] == biopx.DokterKode){                
              dpjp_type = js_dpjp_new[d]['type'];
              dpjp_kode = js_dpjp_new[d]['kode'];
              dpjp_nama = js_dpjp_new[d]['nama'];
            }
          }
          console.log([dpjp_type, dpjp_kode, dpjp_nama]);
          $("#sel_dpjp_auto").val(dpjp_nama);

          $('#discharge_status').val('1'); //??

          $('.menu_ri').hide();

          $('input[name=in_diag_utama]').val(biopx.ICDKode);
          $('input[name=in_diag_sek1]').val(biopx.ICDKode2);
          $('input[name=in_diag_sek2]').val(biopx.ICDKode3);
          $('input[name=in_diag_sek3]').val(biopx.ICDKode4);
          $('input[name=in_diag_sek4]').val(biopx.ICDKode5);

          $('input[name=in_tindakan1]').val(biopx.kodetindakan);
          $('input[name=in_tindakan2]').val(biopx.kodetindakan2);
          $('input[name=in_tindakan3]').val(biopx.kodetindakan3);
          $('input[name=in_tindakan4]').val(biopx.kodetindakan4);


        }

        
        if(biopx.UmurTahun <1 ){
          if(biopx.UmurBulan <1 ){
            bayi = 1;
            // show kolom berat bayi.
            lbl_umur = biopx.UmurHari+" Hari";
            
          }else{
            bayi = 0;
            lbl_umur = biopx.UmurBulan+" Bulan";
          }
        }else{
          bayi = 0;
          lbl_umur = biopx.UmurTahun+" Tahun";
        }

        if(bayi == true){ $('.bayi').show(); }
        else{ $('.bayi').hide(); }

        $('#umur').text(lbl_umur);
        $('#barcode').text(biopx.Barcode);
        $('span[name=norm]').text(biopx.NoRM);
        $('span[name=nama]').text(biopx.Nama);
        $('input[name=tgl_mrs]').val(biopx.TanggalMasuk);
        $('input[name=nosep]').val(biopx.nosep);


        //PANTAUAN TARIF
        $('table[name=tbl_pantauan_biaya_ri] tbody').children().remove();
        for(let i=0; i<payment.length; i++){
          if(payment[i].tab != '14' && payment[i].tab != '16' ){
            totalTarifRs += parseInt(payment[i].Billing);
            // console.log(i+"_"+dt[i].tab+"_"+totalTarifRs); // >>UNTUK MONITORING CEK DATA
          }

          grandTotalRs += parseInt(payment[i].Billing);
          // console.log([totalTarifRs, grandTotalRs]); // >>UNTUK MONITORING CEK DATA
          
          let el =
            '<tr>'+
              '<td>'+(i+1)+'</td>'+
              '<td>'+payment[i].TglTrans+'</td>'+
              '<td>'+payment[i].NoNota+'</td>'+
              '<td>'+payment[i].Ket+'</td>'+
              // '<td style="text-align:right;">'+payment[i].Billing+'</td>'+
              '<td style="text-align:right;">'+numeral(payment[i].Billing).format('0,0')+'</td>'+
            '</tr>';
          $('table[name=tbl_pantauan_biaya_ri] tbody').append(el);
        }

        // $('.tarif_rs').text(totalTarifRs);
        $('.tarif_rs').text( numeral(totalTarifRs).format('0,0') );
        $('.grandTotalRs').text( numeral(grandTotalRs).format('0,0') );

        
        // trf_rs_ina = _ajax("GET", "select_tarif_rs_for_ina/"+nobill, "");
        trf_rs_ina = billEnter.trf_rs_ina;
        console.log(trf_rs_ina);
        // console.log( numeral(trf_rs_ina.detail_tarif.laboratorium).format('0,0') );
        $('input[name=prosedur_non_bedah]').val( numeral(trf_rs_ina.detail_tarif.prosedur_non_bedah).format('0,0') );
        $('input[name=prosedur_bedah]').val( numeral(trf_rs_ina.detail_tarif.prosedur_bedah).format('0,0') );
        $('input[name=konsultasi]').val( numeral(trf_rs_ina.detail_tarif.konsultasi).format('0,0') );
        $('input[name=tenaga_ahli]').val( numeral(trf_rs_ina.detail_tarif.tenaga_ahli).format('0,0') );
        $('input[name=keperawatan]').val( numeral(trf_rs_ina.detail_tarif.keperawatan).format('0,0') );
        $('input[name=penunjang]').val( numeral(trf_rs_ina.detail_tarif.penunjang).format('0,0') );
        $('input[name=radiologi]').val( numeral(trf_rs_ina.detail_tarif.radiologi).format('0,0') );
        $('input[name=laboratorium]').val( numeral(trf_rs_ina.detail_tarif.laboratorium).format('0,0') );
        $('input[name=pelayanan_darah]').val( numeral(trf_rs_ina.detail_tarif.pelayanan_darah).format('0,0') );
        $('input[name=rehabilitasi]').val( numeral(trf_rs_ina.detail_tarif.rehabilitasi).format('0,0') );
        $('input[name=kamar]').val( numeral(trf_rs_ina.detail_tarif.kamar).format('0,0') );
        $('input[name=rawat_intensif]').val( numeral(trf_rs_ina.detail_tarif.rawat_intensif).format('0,0') );
        $('input[name=obat]').val( numeral(trf_rs_ina.detail_tarif.obat).format('0,0') );
        $('input[name=alkes]').val( numeral(trf_rs_ina.detail_tarif.alkes).format('0,0') );
        $('input[name=bmhp]').val( numeral(trf_rs_ina.detail_tarif.bmhp).format('0,0') );
        $('input[name=sewa_alat]').val( numeral(trf_rs_ina.detail_tarif.sewa_alat).format('0,0') );
        $('span[name=total_tarif]').text( numeral(trf_rs_ina.total_tarif).format('0,0'));
        

        // LOAD HISTORI OBAT
        let js_obat = null, 
            val_obat = '';
        
        // js_obat = _ajax("GET", "cariObatBill/"+nobill, "");
        js_obat = billEnter.cariObatBill;
        console.log(js_obat);
        
        for(let i=0; i<js_obat.length; i++){
          if(i==0){
            val_obat = js_obat[i].kodebrgket;
          }else{
            val_obat += ', '+js_obat[i].kodebrgket;
          }
        }
        // $('textarea[name=daftarObatRscmByBill]').val(obatAllByBill(obatValArr,obatValTot));
        $('textarea[name=daftarObatRscmByBill]').val(val_obat);
        
                  
        biopx = billEnter.biopx;
        console.log(biopx);
        $('textarea[name=anamnesa]').val(biopx.Anamnesa);
        $('textarea[name=fisik]').val(biopx.fisik);
        


        // // cek nobill di historidiag
        // // let cnt_histo = _ajax("GET","count_id_historidiag_by_bill",{nobill:nobill});
        // js_histo = _ajax("GET","get_list_histori_diag_by_nobill",{nobill:nobill});
        // js_pxritarif = _ajax("GET","get_pantauritarif_by_nobill",{nobill:nobill});
       
        js_histo = billEnter.js_histo;
        js_pxritarif = billEnter.js_pxritarif;

        console.log({js_histo: js_histo});
        console.log({js_pxritarif: js_pxritarif});

        if(js_histo.length == 0){
          console.log('belum_ada_histori');
        }else{
          console.log('ada_histori');
          // load array index di histori diagnosa
          $('span[name=arr_histori_diag]').children().remove();
          for(let i=0; i<js_histo.length; i++){
            let el = '<a href="#" class="label label-info">'+js_histo[i].id+'</a>';
            $('span[name=arr_histori_diag]').append(el);
          }
        }



        if(js_pxritarif.length == 0){
          // data belum pernah dientry di page ini
          console.log('belum_create');
          if(biopx.StatusDaftar == "RI") 
            $('button[name=btn_insert_daftarritarif]').show();
        }else{
          console.log('sudah_pernah_create'); 
          $('button[name=btn_insert_daftarritarif]').hide();

          
          ////////////INI//// $('select[name=sel_dpjp] option[value="'+js_pxritarif[0].dpjp+'"]').attr('selected','selected');
          
          for (let d = 0; d < js_dpjp_new.length; d++) {
            if(js_dpjp_new[d]['kode'] == js_pxritarif[0].dpjp){                
              dpjp_type = js_dpjp_new[d]['type'];
              dpjp_kode = js_dpjp_new[d]['kode'];
              dpjp_nama = js_dpjp_new[d]['nama'];
            }
          }
          console.log([dpjp_type, dpjp_kode, dpjp_nama]);
          $("#sel_dpjp_auto").val(dpjp_nama);

          $('input[name=tgl_krs]').val(js_pxritarif[0].date_krs);
          los = my_diff($('input[name=tgl_krs]').val(), $('input[name=tgl_mrs]').val(), 'hari')+1;
          if(los < 1){
            alert('Tanggal keluar harus lebih akhir dari tanggal masuk.');
            return 0;
          }else{          
            console.log(los);
            $('#los').text(los);
          }

          $('#discharge_status').val(js_pxritarif[0].carapulang);
          $('select[name=status_kelas]').val(js_pxritarif[0].st_kelas);
          $('select[name=kelas]').val(js_pxritarif[0].kelas);          
          $('input[name=in_dx_terpilih]').val(js_pxritarif[0].id_histori);

          $('#upgrade_class_los').val(js_pxritarif[0].upgrade_class_los);

          let check_label = '';
          if(js_pxritarif[0].icu_ind == 1){ check_label = 'check';
          }else{ check_label = 'uncheck'; }

          $('#icu_indicator').iCheck(check_label).attr('value', js_pxritarif[0].icu_ind);
          // $('#icu_indicator').val(js_pxritarif[0].icu_ind); //CHECKED

          $('#icu_los').val(js_pxritarif[0].icu_los);
          $('#ventilator_hour').val(js_pxritarif[0].ventilator_hour);
          //set js_pxritarif[0].dpjp
          // hanya nambah diagnosa saja, tidak perlu insert di pantauritarif. UPDATE saja berarti
          // load array index di histori diagnosa

          //SET TABEL TAMBAHAN PEMBAYARAN KELAS
          status_kelas = js_pxritarif[0].st_kelas;
          fx_pantauan_biaya_ri_status_kelas(status_kelas);

          $('#kelasTambahanBiaya').text(js_pxritarif[0].kelas); 
          
        }


        //== BRIDGING BPJS ==
        sep = biopx.nosep;
        console.log(sep);
        let js_sep = billEnterAll.bpjs.js_sep;
        console.log('CARI PX BY SEP');
        console.log(js_sep);
        
        $('#jnsPelayanan').val(js_sep.response.jnsPelayanan);
        
        hakKelas = js_sep.response.peserta.hakKelas;
        $('span[name=brj_hakKelas]').text(hakKelas);

        
        let norm_bpjs = js_sep.response.peserta.noMr;
        if(norm_bpjs != biopx.NoRM){
          $('#status_rm').text('BEDA. BPJS:'+norm_bpjs);
        }else{
          $('#status_rm').text('SAMA');
          js_sepcbg = billEnterAll.bpjs.js_sepcbg;
          console.log("integrasi_sep_cbg");
          console.log(js_sepcbg);
        }
        //==\BRIDGING BPJS ==
        

        $("input[name=nosep]").focus();
      
        
        // $('span[name=id_historidiag]').text(id_histo_ready);
      }
    });


    
    $("input[name=nosep]").keypress(function(e) { 
      // let nosep = $(this).val();
      sep = $(this).val();
      if (e.which == 13) { //TEKAN ENTER
        console.log(sep);
        let js_sep = _ajax_bpjs("GET","sep_cari_bpjs",{nosep:sep});
        console.log('CARI PX BY SEP');
        console.log(js_sep);
        
        $('#jnsPelayanan').val(js_sep.response.jnsPelayanan);
        
        hakKelas = js_sep.response.peserta.hakKelas;
        $('span[name=brj_hakKelas]').text(hakKelas);

        
        let norm_bpjs = js_sep.response.peserta.noMr;
        if(norm_bpjs != biopx.NoRM){
          $('#status_rm').text('BEDA. BPJS:'+norm_bpjs);
        }else{
          $('#status_rm').text('SAMA');
          js_sepcbg = _ajax_bpjs("GET","integrasi_sep_cbg/"+sep, '');
          console.log("integrasi_sep_cbg");
          console.log(js_sepcbg);
        }
        
      }
    });


    $("input.in_icd").keypress(function (e) { 
      let icd = $(this).val();
      if (e.which == 13) { //TEKAN ENTER
        $(this).parent().find('select').children().remove();
        if(icd.length != ''){
          console.log(icd);
          
          let jG_icd = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/search_diagnosis/"+icd, "");
          console.log(jG_icd);


          for(let i=0; i<jG_icd.response.data.length; i++){
            let icd_kode = jG_icd.response.data[i][1],
                icd_ket  = jG_icd.response.data[i][0];
            let el = '<option value="'+icd_kode+'">'+icd_kode+'-'+icd_ket+'</option>';
            $(this).parent().find('select').append(el);
          }
        }
      }
    });



    $("input.in_tindakan").keypress(function (e) { 
      let tindakan = $(this).val();
      if (e.which == 13) { //TEKAN ENTER
        $(this).parent().find('select').children().remove();
        if(tindakan.length != ''){
          console.log(tindakan);
          
          let jG_tindakan = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/search_procedures/"+tindakan, "");
          console.log(jG_tindakan);

          for(let i=0; i<jG_tindakan.response.data.length; i++){
            let tindakan_kode = jG_tindakan.response.data[i][1],
                tindakan_ket  = jG_tindakan.response.data[i][0];
            let el = '<option value="'+tindakan_kode+'">'+tindakan_kode+'-'+tindakan_ket+'</option>';
            $(this).parent().find('select').append(el);
          }
        }
      }
    });
    
    
    //SET TABEL TAMBAHAN PEMBAYARAN KELAS
    function fx_pantauan_biaya_ri_status_kelas(status_kelas=null){
      if(status_kelas==''){
        kelas_bpjs_indikator = 0;
        $('#upgrade_class_los').hide();
        $('.trTambahanBiaya').hide();
      }else{
        kelas_bpjs_indikator = 1;
        $('#upgrade_class_los').show();
        $('.trTambahanBiaya').show();
      }

      $('#naikTurunTambahanBiaya').text(status_kelas);
      console.log([status_kelas, kelas_bpjs_indikator]);

      return {"kelas_bpjs_indikator": kelas_bpjs_indikator};
    }
    
    $('select[name=status_kelas]').on('change', function(){  
      status_kelas = $(this).val();
      fx_pantauan_biaya_ri_status_kelas(status_kelas);
    });

    $('select[name=kelas]').on('change', function(){  
      kelas = $(this).val();
      kelas_bpjs = $(this).find(":selected").data("bpjs");
      console.log([kelas, kelas_bpjs]);
      $('#kelasTambahanBiaya').text(kelas);
    });



    //BTN TXT: HAPUS KLAIM INACBG
    $('#btn_hapus_klaim_ina').click(function(e){
      e.preventDefault();
      let jpost = {
        "metadata": {
          "method":"delete_claim"
        },
        "data": {
          "nomor_sep": $('input[name=nosep]').val(),
          "coder_nik": $('#coder_nik').val(),
        }
      };

      console.log({"send_delete_claim": jpost});
      
      let res = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", jpost);
      console.log({"result_delete_claim":res});
      
      alert('('+res.metadata.code+') '+res.metadata.message);

    });

    //BTN TXT: BUAT KLAIM INACBG
    $('#btn_buat_klaim_ina').click(function(e){
      e.preventDefault();
        
        //-- NEW_CLAIM INACBG
        let j_new_claim = {
          "metadata": {
            "method": "new_claim"
          },
          "data": {
            "nomor_kartu" : biopx.Barcode,
            "nomor_sep"   : $('input[name=nosep]').val(), // sep,
            "nomor_rm"    : biopx.NoRM, // norm,
            "nama_pasien" : biopx.Nama,
            "tgl_lahir"   : biopx.TglLahir,
            "gender"      : biopx.gender_eclaim,
          }
        };
      
      console.log({"send_new_claim": j_new_claim});
      
      let res = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", j_new_claim);
      console.log({"res":res});

      alert('('+res.metadata.code+') '+res.metadata.message);
      //\-- NEW_CLAIM INACBG

    });



    //BTN TXT: HAPUS PASIEN
    $('button[name=btn_hapus_daftarritarif]').click(function(e){
      e.preventDefault();
      let jpost = {
        table_name : 'cx_daftarritarif',
        where : {
          nobill:nobill,
        },
      };
      let hps = _ajax("POST","delete",jpost);
      console.log({'hapus_res':hps});
      
      jpost = {
        table_name : 'cx_daftarrihistoridiag',
        where : {
          nobill:nobill,
        },
      };
      hps = _ajax("POST","delete",jpost);
      console.log({'hapus_res':hps});

    });


    //BTN TXT: EDIT PASIEN
    $('button[name=btn_update_daftarritarif]').click(function(){
      console.log('update_px');
      nobill= $('input[name=nobill]').val();      
      norm  = $('span[name=norm]').text();
      sep   = $('input[name=nosep]').val();
      // dpjp  = $('select[name=sel_dpjp]').val();
      // dpjp  = dpjp_kode;
      // brj_hakKelas = $('span[name=brj_hakKelas]').text();
      hakKelas = $('span[name=brj_hakKelas]').text();
      status_kelas = $('select[name=status_kelas]').val();
      kelas = $('select[name=kelas]').val();

      let id_dx_terpilih = $('input[name=in_dx_terpilih]').val();

      console.log(nobill+'_'+id_histori);


      // UPDATE
      let jPost_tbl1 = {
        sep      : sep,
        dpjp     : dpjp_kode,
        st_kelas : status_kelas,
        kelas    : kelas,
        upgrade_class_los: $('#upgrade_class_los').val(),
        // hakkelas : brj_hakKelas,
        hakkelas    : hakKelas,
        icu_ind     : icu_indicator,
        icu_los     : $('#icu_los').val(),
        ventil_hour : $('#ventilator_hour').val(),
        tarif_ina_fnl: '',
        date_krs    : $('input[name=tgl_krs]').val(),
        carapulang  : $('#discharge_status').val(),
        // tarif_rs_fnl : '',
        // date_krs     : '',
        id_histori : id_dx_terpilih, //1,
        status  : '',
        proses  : 0 // 0 = belum final
      };
      console.log(jPost_tbl1);
      // return 0;
      
      let js = _db_update( {nobill : nobill}, 'cx_daftarritarif', jPost_tbl1);
      console.log(js);

      // INSERT
      data_rec = {
          data_utama : { 
            nobill : nobill
          },
          data_paket : jPost_tbl1,
        };
      let jPost_tblrec = {
        id   : '',
        app  : 'bo/menu/casemix/pantauan_biaya_ri',
        element : $(this)[0].name,
        nama : 'update_px_to_daftarritarif',
        ket  : 'Pasien diedit di Daftar Tarif RI.',
        data : JSON.stringify(data_rec),
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')
      };

      let jInsert = _db_insert('cx_rec', jPost_tblrec);
      console.log(jInsert);

      
      // let dt = _ajax('POST','insert_daftarritarif',jPost);
      let dt = jInsert;
      console.log(dt);
      if(dt == null){
        alert('Data pasien berhasil dimasukkan di Daftar Tarif RI.');
      }else{
        alert('Proses Gagal. Silahkan ulangi.');
      }


      //UPDATE SEP      
        let dtsep = _db_update( {NoBill : nobill}, 'fotrdaftar', {nosep:sep});
        console.log(dtsep);

        if(dtsep == null){
          console.log('Edit SEP Sukses.');
        }else{
          console.log('Edit SEP Gagal. Silahkan ulangi.');
        }

        // reload();
    });
    

    // TOMBOL MASUKKAN PASIEN    
    $('button[name=btn_insert_daftarritarif]').click(function(){
      nobill= $('input[name=nobill]').val();      
      norm  = $('span[name=norm]').text();
      sep   = $('input[name=nosep]').val();
      // dpjp  = $('select[name=sel_dpjp]').val();

      // id_histori = js_histo.length+1;
      id_histori  = 0;
      // brj_hakKelas= $('span[name=brj_hakKelas]').text();
      hakKelas= $('span[name=brj_hakKelas]').text();

      console.log(nobill+'_'+id_histori);

      //UPDATE SEP      
        let dtsep = _db_update( {NoBill : nobill}, 'fotrdaftar', {nosep:sep});
        console.log(dtsep);

        if(dtsep == null){
          console.log('Edit SEP Sukses.');
        }else{
          console.log('Edit SEP Gagal. Silahkan ulangi.');
        }


      // cx_daftarritarif
      let jPost_tbl1 = {
        nobill   : nobill,
        norm     : norm,
        sep      : sep,
        dpjp     : dpjp_kode,
        st_kelas : status_kelas,
        kelas    : kelas,
        // hakkelas : brj_hakKelas,
        hakkelas : hakKelas,
        tarif_ina_fnl: '',
        tarif_rs_fnl : '',
        date_krs     : '',
        carapulang    : $('#discharge_status').val(),
        id_histori   : id_histori, //1,
        status  : '',
        proses  : 0, // 0 = belum final
        user    : _user_logged_in,
        date    : moment().format('YYYY-MM-DD'),
        time    : moment().format('HH:mm:ss')
      };


      data_rec = {
        data_utama : { 
          nobill : nobill
        },
        data_paket : jPost_tbl1,
      };
      let jPost_tblrec = {
        id   : '',
        app  : 'bo/menu/casemix/pantauan_biaya_ri',
        element : $(this)[0].name,
        nama : 'insert_px_to_daftarritarif',
        ket  : 'Pasien ditambahkan di Daftar Tarif RI.',
        data : JSON.stringify(data_rec),
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')
      };

      // insert_daftarritarif
      let jPost = {
        data1 : jPost_tbl1, // cx_daftarritarif
        data2 : jPost_tblrec  // cx_rec
      }
      console.log(jPost);


      let dt = _ajax('POST','insert_daftarritarif',jPost);
      console.log(dt);
      if(dt == null){
        alert('Data pasien berhasil dimasukkan di Daftar Tarif RI.');
                
        //-- NEW_CLAIM INACBG
        let j_new_claim = {
            "metadata": {
              "method": "new_claim"
            },
            "data": {
              "nomor_kartu" : biopx.Barcode,
              "nomor_sep"   : sep,
              "nomor_rm"    : biopx.NoRM, // norm,
              "nama_pasien" : biopx.Nama,
              "tgl_lahir"   : biopx.TglLahir,
              "gender"      : biopx.gender_eclaim,
            }
          };
        
        console.log({"send_new_claim": j_new_claim});
        let js_new_claim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", j_new_claim);
        console.log({"js_new_claim":js_new_claim});
        //\-- NEW_CLAIM INACBG

        $('button[name=btn_insert_daftarritarif]').hide();
      }else{
        alert('Proses Gagal. Silahkan ulangi.');
      }

      // reload(); //KALO ERROR, INI DI RUN saja

    });


    $('select.sel_icd').on('change', function(){     
      let val = $(this).val();
      console.log(val);
      $(this).parent().find('input').val(val);
    });
    
    
    $('select.sel_tindakan').on('change', function(){
      let val = $(this).val();
      console.log(val);
      $(this).parent().find('input').val(val);
    });

    // click id_diagnosa , click pagination diagnosa
    $(document).on('click','span[name=arr_histori_diag] a', function(e){
      e.preventDefault();
      let id = $(this).text();
      nobill = $('input[name=nobill]').val();
      console.log('id= '+id);

      let exe = _ajax('GET','get_histori_diag_by_nobill_idhisto',{nobill:nobill, id:id});
      console.log(exe);

      $('span[name=id_historidiag]').text(id);

      // ket
      $('input[name=diag_awal]').val(exe[0].dx_awal);
      $('input[name=diag_utama]').val(exe[0].dx_utama);
      $('input[name=diag_sek1]').val(exe[0].dx_sek1);
      $('input[name=diag_sek2]').val(exe[0].dx_sek2);
      $('input[name=diag_sek3]').val(exe[0].dx_sek3);
      $('input[name=diag_sek4]').val(exe[0].dx_sek4);
      $('input[name=diag_sek5]').val(exe[0].dx_sek5);

      $('input[name=tindakan1]').val(exe[0].tindakan1);
      $('input[name=tindakan2]').val(exe[0].tindakan2);
      $('input[name=tindakan3]').val(exe[0].tindakan3);
      $('input[name=tindakan4]').val(exe[0].tindakan4);

      // icd
      $('input[name=in_diag_awal]').val(exe[0].icd_awal);
      $('input[name=in_diag_utama]').val(exe[0].icd_utama);
      $('input[name=in_diag_sek1]').val(exe[0].icd_sek1);
      $('input[name=in_diag_sek2]').val(exe[0].icd_sek2);
      $('input[name=in_diag_sek3]').val(exe[0].icd_sek3);
      $('input[name=in_diag_sek4]').val(exe[0].icd_sek4);
      $('input[name=in_diag_sek5]').val(exe[0].icd_sek5);

      $('input[name=in_tindakan1]').val(exe[0].icd_tindakan1);
      $('input[name=in_tindakan2]').val(exe[0].icd_tindakan2);
      $('input[name=in_tindakan3]').val(exe[0].icd_tindakan3);
      $('input[name=in_tindakan4]').val(exe[0].icd_tindakan4);
      // enter_tindakan();


      $('input[name=tarif_inacbg]').val(exe[0].tarif_inacbg);
      $('input[name=in_verifikator]').val(exe[0].verifikator);

      // INI YANG LAMA PAKE FX JS. SEKARANG PAKE QUERY LANGSUNG BANDINGKAN TARIFNYA
      //LOGIKA PEMBANDING status_tarif
      // tarif_inacbg = exe[0].tarif_inacbg;
      // let st_tarif = pembanding_status_tarif(tarif_inacbg, totalTarifRs);
      // $('span[name=status_tarif]').text(st_tarif.status_tarif).attr('class','label label-'+st_tarif.label_css);

      // let st_tarif = pembanding_status_tarif(tarif_inacbg, totalTarifRs);
      $('span[name=status_tarif]').text(exe[0].status_tarif).attr('class','label label-'+exe[0].label_css);

    });


    // menambahkan historidiag
    $('button[name=btn_insert_historidiag]').click(function(){
      // let nobill = $('input[name=nobill]').val(),
      let id_histori = js_histo.length+1,
          verifikator= $('input[name=in_verifikator]').val();
      console.log([nobill, id_histori, verifikator]);

      if(verifikator == ''){
        alert('Kolom verifikator harus terisi.');
      }else{        
        let jPost_tbl1 = {
          nobill  : nobill,
          id      : id_histori, // hitung, hasilnya+1        
          dx_awal : $('input[name=diag_awal]').val(),
          dx_utama: $('input[name=diag_utama]').val(),
          dx_sek1 : $('input[name=diag_sek1]').val(),
          dx_sek2 : $('input[name=diag_sek2]').val(),
          dx_sek3 : $('input[name=diag_sek3]').val(),
          dx_sek4 : $('input[name=diag_sek4]').val(),
          dx_sek5 : $('input[name=diag_sek5]').val(),
          
          icd_awal: $('input[name=in_diag_awal]').val(),
          icd_utama: $('input[name=in_diag_utama]').val(),
          icd_sek1: $('input[name=in_diag_sek1]').val(),
          icd_sek2: $('input[name=in_diag_sek2]').val(),
          icd_sek3: $('input[name=in_diag_sek3]').val(),
          icd_sek4: $('input[name=in_diag_sek4]').val(),
          icd_sek5: $('input[name=in_diag_sek5]').val(),

          tindakan1 : $('input[name=tindakan1]').val(),
          tindakan2 : $('input[name=tindakan2]').val(),
          tindakan3 : $('input[name=tindakan3]').val(),
          tindakan4 : $('input[name=tindakan4]').val(),
          
          icd_tindakan1 : $('input[name=in_tindakan1]').val(),
          icd_tindakan2 : $('input[name=in_tindakan2]').val(),
          icd_tindakan3 : $('input[name=in_tindakan3]').val(),
          icd_tindakan4 : $('input[name=in_tindakan4]').val(),
          tarif_inacbg  : $('input[name=tarif_inacbg]').val(),
          status  : '',
          verifikator : verifikator,
          user    : _user_logged_in,
          date    : moment().format('YYYY-MM-DD'),
          time    : moment().format('HH:mm:ss')
        };

        data_rec = {
          data_utama : { 
            nobill : nobill
          },
          data_paket : jPost_tbl1,
        };
        let jPost_tblrec = {
          id   : '',
          app  : 'bo/menu/casemix/pantauan_biaya_ri',
          element : $(this)[0].name,
          nama : 'insert_histori_diagnosa',
          ket  : 'Histori diagnosa pasien ditambahkan.',
          data : JSON.stringify(data_rec),
          user : _user_logged_in,
          date : moment().format('YYYY-MM-DD'),
          time : moment().format('HH:mm:ss')

        };

        // insert_historidiag
        let jPost = {
          data1 : jPost_tbl1,
          data2 : jPost_tblrec
        }
        console.log(jPost);

        let dt = _ajax('POST','insert_historidiag',jPost);
        console.log(dt);
        if(dt == null){
          alert('Proses Sukses. Histori diagnosa pasien ditambahkan.');
        }else{
          alert('Proses Gagal. Silahkan ulangi.');
        }

        reload();
      }


    });


    $('button[name=btn_update_historidiag]').click(function(){
      // let nobill      = $('input[name=nobill]').val(),
      let id_histori  = $('span[name=id_historidiag]').text();
      console.log([nobill, id_histori]);

      let jPost_tbl1 = {
        dx_awal : $('input[name=diag_awal]').val(),
        dx_utama: $('input[name=diag_utama]').val(),
        dx_sek1 : $('input[name=diag_sek1]').val(),
        dx_sek2 : $('input[name=diag_sek2]').val(),
        dx_sek3 : $('input[name=diag_sek3]').val(),
        dx_sek4 : $('input[name=diag_sek4]').val(),
        dx_sek5 : $('input[name=diag_sek5]').val(),
        icd_awal: $('input[name=in_diag_awal]').val(),
        icd_utama: $('input[name=in_diag_utama]').val(),
        icd_sek1: $('input[name=in_diag_sek1]').val(),
        icd_sek2: $('input[name=in_diag_sek2]').val(),
        icd_sek3: $('input[name=in_diag_sek3]').val(),
        icd_sek4: $('input[name=in_diag_sek4]').val(),
        icd_sek5: $('input[name=in_diag_sek5]').val(),

        tindakan1 : $('input[name=tindakan1]').val(),
        tindakan2 : $('input[name=tindakan2]').val(),
        tindakan3 : $('input[name=tindakan3]').val(),
        tindakan4 : $('input[name=tindakan4]').val(),

        icd_tindakan1 : $('input[name=in_tindakan1]').val(),
        icd_tindakan2 : $('input[name=in_tindakan2]').val(),
        icd_tindakan3 : $('input[name=in_tindakan3]').val(),
        icd_tindakan4 : $('input[name=in_tindakan4]').val(),
        tarif_inacbg  : $('input[name=tarif_inacbg]').val(),
        status  : '',
        verifikator : $('input[name=in_verifikator]').val(),
        user    : _user_logged_in,
        date    : moment().format('YYYY-MM-DD'),
        time    : moment().format('HH:mm:ss')
      };


      data_rec = {
          data_utama : { 
            nobill : nobill
          },
          data_paket : jPost_tbl1,
        };
      let jPost_tblrec = {
        id   : '',
        app  : 'bo/menu/casemix/pantauan_biaya_ri',
        element : $(this)[0].name,
        nama : 'update_histori_diagnosa',
        ket  : 'Histori diagnosa pasien diedit.',
        data : JSON.stringify(data_rec),
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')

      };

      // insert_historidiag
      let jPost = {
        where : {
          nobill : nobill,
          id     : id_histori,
        },
        cx_daftarrihistoridiag  : jPost_tbl1,
        cx_rec                  : jPost_tblrec
      }
      console.log(jPost);

      let dt = _ajax('POST','update_historidiag',jPost);
      console.log(dt);
      if(dt == null){
        alert('Proses Sukses. Histori diagnosa pasien diedit.');
      }else{
        alert('Proses Gagal. Silahkan ulangi.');
      }

      reload();

    });


    $('#btn_editulangklaim').click(function(e){
      e.preventDefault();
      //--EDIT ULANG KLAIM
      let reedit_claim = {
        "metadata": {
          "method":"reedit_claim"
        },
        "data": {
          "nomor_sep": $('input[name=nosep]').val(),
        }
      };

      console.log({"send_reedit_claim_ina": reedit_claim});
      let js_reedit_claim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", reedit_claim);
      console.log(js_reedit_claim);

      // // JIKA SUKSES
      // $('#btn_editulangklaim').hide();
      // $('#btn_final').show();
      //\--EDIT ULANG KLAIM
    });


    // $('button[name=btn_final_daftarritarif]').click(function(e){
    $('#btn_final_new').click(function(e){
      e.preventDefault();
      let nobill     = $('input[name=nobill]').val(),
          id_histori = $('input[name=in_dx_terpilih]').val(),
          date_krs   = $('input[name=tgl_krs]').val();
      console.log([nobill, id_histori, date_krs]);

      if(date_krs == ''){
        alert('Tanggal KRS harus terisi.');
        return 0;
      }

      if($('#discharge_status').val() == ''){
        alert('Cara keluar pasien belum diisi.');
        return 0;
      }
      
      if($('#sel_dpjp_auto').val() == ''){
        alert('DPJP belum diisi.');
        return 0;
      }

      if(id_histori == 0 || id_histori==''){
        alert('DIAG TERPILIH harus di set (tidak boleh 0).');
        return 0;
      }


      let send = {
        data : {
          dpjp_kode : dpjp_kode,
          dpjp_nama : dpjp_nama,
          dpjp_type : dpjp_type,
          ICDKode	  : $('input[name=in_diag_utama]').val(),
          ICDKode2	: $('input[name=in_diag_sek1]').val(),
          ICDKode3	: $('input[name=in_diag_sek2]').val(),
          ICDKode4	: $('input[name=in_diag_sek3]').val(),
          ICDKode5	: $('input[name=in_diag_sek4]').val(),
          Anamnesa  : $('textarea[name=anamnesa]').val(),
          Diagnosa  : $('input[name=diag_utama]').val(),
          KeadaanKeluarKode : $('#discharge_status').val(),
          kodetindakan      : $('input[name=in_tindakan1]').val(),
          kodetindakan2     : $('input[name=in_tindakan2]').val(),
          kodetindakan3     : $('input[name=in_tindakan3]').val(),
          kodetindakan4     : $('input[name=in_tindakan4]').val(),
          tindakanket       : $('input[name=tindakan1]').val(),
          fisik             : $('textarea[name=fisik]').val(),
          final_ina   : {
            nomor_sep : $('input[name=nosep]').val(),
            coder_nik : $('#coder_nik').val(),
          },
          id_histori  : id_histori,
          date_krs    : date_krs,
          totalINA : $('input[name=tarif_inacbg]').val(),
          element  : $(this)[0].id, // $(this)[0].name,
        },
      };
      console.log(send);

      let exe = _ajax_web('POST', baseUrl()+'casemix/final_klaim/'+nobill, send);
      console.log(exe);

      if(exe.metaData.status == "failed"){
        for (let f = 0; f < exe.response.alert.length; f++) {
          alert(exe.response.alert[f].message);          
        }
      }else{
        alert("Proses Final Berhasil.");
      }

    });




    // $('#btn_final').click(function(e){
    //   e.preventDefault();
    //   let nobill     = $('input[name=nobill]').val(),
    //       // id_histori = $('span[name=id_historidiag]').text(), // id_histori!=0
    //       id_histori = $('input[name=in_dx_terpilih]').val(),
    //       date_krs   = $('input[name=tgl_krs]').val();
    //   console.log([nobill, id_histori, date_krs]);

    //   if(date_krs == ''){
    //     alert('Tanggal KRS harus terisi.');
    //     return 0;
    //   }

    //   if(id_histori == 0 || id_histori==''){
    //     alert('DIAG TERPILIH harus di set (tidak boleh 0).');
    //     return 0;
    //   }
      
    //   if($('#discharge_status').val() == ''){
    //     alert('Cara keluar pasien belum diisi.');
    //     return 0;
    //   }
      
    //   if($('#sel_dpjp_auto').val() == ''){
    //     alert('DPJP belum diisi.');
    //     return 0;
    //   }

    //   //--INSERT FORMDIAGNOSA
    //   let cek_rmdx = _ajax('GET', 'db/m_daftarmandiri/formdiagnosa_cekada_bill/'+nobill, '');
    //   console.log(cek_rmdx);
            
    //   //!!! utk bill yg di fotrdaftarri.dokterawal=20028, jangan dipakai
    //   let c_rmdx_pxri = _ajax('GET', 'formdiagnosa_get_pxri_det/'+nobill, '');
    //   console.log(c_rmdx_pxri);

    //   let send = {
    //     BillNo : nobill,
    //     BillStatusDaftar : c_rmdx_pxri.fd_pxdaf.StatusDaftar,
    //     TglMasuk : c_rmdx_pxri.fd_pxdaf.TanggalMasuk,
    //     TglKeluar : c_rmdx_pxri.fd_pxdaf.TanggalKeluar,
    //     JamMasuk : c_rmdx_pxri.fd_pxdaf.JamMasuk,
    //     JamKeluar : c_rmdx_pxri.fd_pxdaf.JamKeluar,
    //     RmNo : c_rmdx_pxri.fd_pxdaf.NoRM,
    //     RmUmurThn : c_rmdx_pxri.fd_pxdaf.UmurTahun,
    //     RmUmurBln : c_rmdx_pxri.fd_pxdaf.UmurBulan,
    //     RmUmurHari : c_rmdx_pxri.fd_pxdaf.UmurHari,
    //     Pendidikan : c_rmdx_pxri.fd_pxdaf.Pendidikan,
    //     Pekerjaan : c_rmdx_pxri.fd_pxdaf.Pekerjaan,
    //     Sex : c_rmdx_pxri.fd_pxdaf.Sex,
    //     LokasiKode : 0,
    //     DokterKode : dpjp_kode, //c_rmdx_pxri.fd_dokter.kode, //?
    //     DokterNama : dpjp_nama, //c_rmdx_pxri.fd_dokter.nama, //?
    //     DokterType : dpjp_type, // c_rmdx_pxri.fd_pxri.TypeDokter, //??
        
    //     ICDKode : $('input[name=in_diag_utama]').val(),
    //     ICDKode2 : $('input[name=in_diag_sek1]').val(),
    //     ICDKode3 : $('input[name=in_diag_sek2]').val(),
    //     ICDKode4 : $('input[name=in_diag_sek3]').val(),
    //     ICDKode5 : $('input[name=in_diag_sek4]').val(),

    //     KasusBL    : c_rmdx_pxri.fd_pxdaf.KasusBL,
    //     KasusBLBln : c_rmdx_pxri.fd_pxdaf.KasusBLBln,
    //     KasusBLTri : c_rmdx_pxri.fd_pxdaf.KasusBLTri,
    //     KasusBLSms : c_rmdx_pxri.fd_pxdaf.KasusBLSms,
    //     KasusBLThn : c_rmdx_pxri.fd_pxdaf.KasusBLThn,

    //     Anamnesa : $('textarea[name=anamnesa]').val(),
    //     Diagnosa : $('input[name=diag_utama]').val(), //'',
    //     Terapi : '', // LIST OBAT
    //     KeadaanKeluarKode : $('#discharge_status').val(), //??

    //     KodeBuilding : c_rmdx_pxri.fd_bed.KodeBuilding,
    //     KodeBuildingKet : c_rmdx_pxri.fd_bed.KodeBuildingKet,
    //     KodeLantai    : c_rmdx_pxri.fd_bed.KodeLantai,
    //     KodeLantaiKet : c_rmdx_pxri.fd_bed.KodeLantaiKet,
    //     KodeRuang     : c_rmdx_pxri.fd_bed.KodeRuang,
    //     KodeRuangKet  : c_rmdx_pxri.fd_bed.KodeRuangKet,
    //     KodeKelas     : c_rmdx_pxri.fd_bed.KodeKelas,
    //     KodeKelasKet  : c_rmdx_pxri.fd_bed.KodeKelasKet,
    //     KodeKelasLevel : c_rmdx_pxri.fd_bed.KodeKelasLevel,
    //     KodeBed       : c_rmdx_pxri.fd_bed.KodeBed,
    //     KodeBedKet    : c_rmdx_pxri.fd_bed.KodeBedket,
    //     KodePelayanan : c_rmdx_pxri.fd_pxri.PelayananRI,
    //     KodePelayananKet : c_rmdx_pxri.fd_pxri.PelayananRIKet,

    //     kodetindakan : $('input[name=in_tindakan1]').val(),
    //     kodetindakan2 : $('input[name=in_tindakan2]').val(),
    //     kodetindakan3 : $('input[name=in_tindakan3]').val(),
    //     kodetindakan4 : $('input[name=in_tindakan4]').val(),
    //     tindakanket : $('input[name=tindakan1]').val(),
    //     fisik : $('textarea[name=fisik]').val(),
    //     User : _user_logged_in,
    //     Date : moment().format('YYYY-MM-DD'),
    //     Time : moment().format('HH:mm:ss'),
    //   };
    //   console.log(send);

      
    //   if(cek_rmdx=='0'){
    //     console.log('Data tidak ada. Belum entri di RM Diagnosa.');
    //     // INSERT
    //     let jInsert = _db_insert('formdiagnosa', send);
    //     console.log(jInsert);

    //     // UPDATE FLAGDIAGNOSA
    //     let upd_td = _db_update( {nobill : nobill}, 'fotrdaftar', {FlagDiagnosa:1});
    //     console.log(upd_td);
  
    //     if(upd_td == null){
    //       console.log('Update flagdiagnosa >> Sukses.');
    //     }else{
    //       console.log('Update flagdiagnosa >> Gagal. Silahkan ulangi.');
    //     }

    //   }else{
    //     // UPDATE
    //     alert('Data sudah pernah dientri di RM Diagnosa.');
    //     // return 0;
    //   }
    //   //\--INSERT FORMDIAGNOSA


      
    //   //--FINAL
    //   let final_ina = {
    //     "metadata": {
    //       "method":"claim_final"
    //     },
    //     "data": {
    //       "nomor_sep": $('input[name=nosep]').val(),
    //       "coder_nik": $('#coder_nik').val(),
    //     }
    //   };

    //   console.log({"send_final_ina": final_ina});
    //   let js_final_ina = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", final_ina);
    //   console.log(js_final_ina);
    //   //\--FINAL

                  
    //   let jPost = {
    //     id_histori : id_histori,
    //     date_krs   : date_krs,
    //     proses     : 1,
    //   };
    //   let dt = _db_update( {nobill : nobill}, 'cx_daftarritarif', jPost);
    //   console.log(dt);

    //   if(dt == null){
    //     // UPDATE TARIF INA
    //       //SELECT field tarif_ina dari dx_terpilih
    //       let js_totINA = _ajax("GET", "db/m_daftarmandiri/select_trf_ina_by_dx_pilih/"+nobill+"/"+id_histori, "");
    //       if(js_totINA.metaData.status == "failed"){
    //         alert("ID diagnosa terpilih tidak sesuai.");
    //       }else{
    //         // let upd_td_trf_ina = _db_update( {nobill : nobill}, 'fotrdaftar', {totalINA:js_totINA.response.tarif_inacbg});
    //         totalINA = $('input[name=tarif_inacbg]').val();
    //         let upd_td_trf_ina = _db_update( {nobill : nobill}, 'fotrdaftar', { totalINA:totalINA });
    //         console.log(upd_td_trf_ina);
      
    //         if(upd_td_trf_ina == null){
    //           console.log('Update Tarif INA di trdaftar >> Sukses.');
              
    //           alert('Proses FINAL Sukses.');
    //         }else{
    //           alert('Update Tarif INA di trdaftar >> Gagal.');
    //         }

    //       }
          
    //   }else{
    //     alert('Proses FINAL Gagal. Silahkan ulangi.');
    //   }



    //   // INSERT
    //   data_rec = {
    //       data_utama : { 
    //         nobill : nobill
    //       },
    //       data_paket : jPost,
    //     };

    //   let jPost_tblrec = {
    //     id   : '',
    //     app  : 'bo/menu/casemix/pantauan_biaya_ri',
    //     element : $(this)[0].name,
    //     nama : 'final_px_to_daftarritarif',
    //     ket  : 'Set Final Pasien di Daftar Tarif RI.',
    //     data : JSON.stringify(data_rec),
    //     user : _user_logged_in,
    //     date : moment().format('YYYY-MM-DD'),
    //     time : moment().format('HH:mm:ss')
    //   };

    //   let jInsert = _db_insert('cx_rec', jPost_tblrec);
    //   console.log(jInsert);

    //   // // JIKA SUKSES
    //   // $('#btn_editulangklaim').show();
    //   // $('#btn_final').hide();

    //   // reload();
                    
    // });


    $('button[name=btn_dl_pdf_rekering_ri]').click(function(e){
      e.preventDefault();
      // let nobill = $("input[name=nobill]").val();
      js = _ajax("GET", "select_px_ri_detail_by_bill/"+nobill, "");
      console.log(js);

      if(js == null){
        alert('Pasien belum didaftarkan rawat inap.');
      }else{
        let jPost_pdf = {
          pasien        : js, // {nobill : nobill},
          list_biaya_ri : payment,
          operator      : _user_logged_in,
          grandTotalRs  : grandTotalRs,
          totalTarifRs  : totalTarifRs
        }
        console.log(jPost_pdf);
        $.redirect(baseUrl()+'ajaxreq/viewpdf_rekeningri/'+nobill, jPost_pdf);
      }

    });

    $('#btn_dl_pdf_inacbg').click(function(e){
      e.preventDefault();
      window.open(baseUrl()+'eclaim/ajax_eclaim/claim_print/'+sep+'?nobill='+nobill);
      reload();
    });

    
    // $('input[type="checkbox"].load').on('ifChanged', function(e){
    $('#icu_indicator').on('ifChanged', function(e){
      e.preventDefault();
      // alert(e.type + ' callback');
      let attr_id = '', //$(this).data('id'),
          attr_val = '';
      let attr_name = $(this).attr('id'); // $(this).attr('name');
      let attr_check = e.target.checked;
      
      // console.log(e);
      if(attr_check == true){
        $(this).attr('value',1);
        $('.rawat_intensif').show();
      }else{
        $(this).attr('value',0);        
        $('.rawat_intensif').hide();
      }

      attr_val = $(this).val();
      icu_indicator = attr_val;
      console.log([attr_id, attr_val, attr_name, attr_check, icu_indicator]);

    });

    


    let diags = [], procs = [];
    let diags_val = '', procs_val = '';
    let tarifGrouping1 = 0;
    // console.log($('#coder_nik').val());
    $('#btn_update_dx_proc_cbg').click(function(e){
      e.preventDefault();

      let update_dx = {
        "metadata": {
          "method": "set_claim_data",
          "nomor_sep": $('input[name=nosep]').val(),
        },
        "data": {
          "diagnosa": "#",
          "procedure": "#",
          "coder_nik": $('#coder_nik').val(),
        }
      };
      
      console.log({"send_update_dx_del": update_dx});
      let js_update_dx = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", update_dx);
      console.log(js_update_dx);


      // UPDATE
      diags[0] = $('input[name=in_diag_utama]').val();
      diags_val = diags[0];

      for (let i = 0; i < 5; i++) {
        diags[(i+1)] = $('input[name=in_diag_sek'+(i+1)+']').val();
        if(diags[(i+1)] != ''){
          diags_val += '#' + diags[(i+1)];
        }
      }
      console.log([diags, diags_val]);

      
      procs[0] = $('input[name=in_tindakan1]').val();
      procs_val = procs[0];
      for (let i = 1; i < 4; i++) {
        procs[(i+1)] = $('input[name=in_tindakan'+(i+1)+']').val();
        if(procs[(i+1)] != ''){
          procs_val += '#' + procs[(i+1)];
        }
      }
      console.log([procs, procs_val]);


      update_dx = {
        "metadata": {
          "method": "set_claim_data",
          "nomor_sep": $('input[name=nosep]').val(),
        },
        "data": {
          "diagnosa": diags_val,
          "procedure": procs_val,
          "coder_nik": $('#coder_nik').val(),
        }
      };
      
      console.log({"send_update_dx": update_dx});
      js_update_dx = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", update_dx);
      console.log(js_update_dx);
        
    });


    function iCheck_ifChanged(idname) {
      $(idname).on('ifChanged', function(e){
        e.preventDefault();
        // let attr_id = '', //$(this).data('id'),
        //   attr_val = '';
        // let attr_id = $(this).attr('id'); // $(this).attr('name');
        // let attr_name = $(this).attr('id'); // $(this).attr('name');
        // let attr_check = e.target.checked;
        // attr_val = ;

        res = {
          id   : $(this).attr('id'),
          name	: $(this).attr('name'),
          check: e.target.checked,
          value : $(this).val(),
        };
        return res;
      });
      
    }


    // iCheck_ifChanged('input[name=lab_asam_laktat]');
    // iCheck_ifChanged('#lab_asam_laktat');

    // $('#lab_asam_laktat').on('ifChanged', function(e){ return e.target.checked });
    // $('#lab_asam_laktat').on('ifChanged', function(e){ $(this).attr('value', (e.target.checked)? "1":"0" )  });
    $('input.cbox_cov').on('ifChanged', function(e){ $(this).attr('value', (e.target.checked)? "1":"0" ) });

    $('#tes_cbox').click(function(e){
      // console.log( iCheck_ifChanged('input[name=lab_asam_laktat]') );
      // console.log( $('#lab_asam_laktat').on('ifChanged', function(e){ return e.target.checked })  );
      console.log($('input[name=lab_asam_laktat]').val() , $('input[name=lab_procalcitonin]').val() , $('input[name=lab_crp]').val() );
      console.log($('input[name=lab_kultur]').val() , $('input[name=lab_d_dimer]').val() , $('input[name=lab_pt]').val() );      
    });


    $('#btn_grouping').click(function(e){
      e.preventDefault();

      if( biopx.StatusDaftar == 'RI'){
          if(kelas_bpjs_indikator==1){
            if($('#upgrade_class_los').val() == ''){
              alert('Hari naik kelas belum terisi.');
              return 0;
            }
          }


          // EDIT HISTORI XLINK
            // let nobill      = $('input[name=nobill]').val(),
            let id_histori  = $('span[name=id_historidiag]').text();
            console.log([nobill, id_histori]);

            let jPost_tbl1 = {
              dx_awal : $('input[name=diag_awal]').val(),
              dx_utama: $('input[name=diag_utama]').val(),
              dx_sek1 : $('input[name=diag_sek1]').val(),
              dx_sek2 : $('input[name=diag_sek2]').val(),
              dx_sek3 : $('input[name=diag_sek3]').val(),
              dx_sek4 : $('input[name=diag_sek4]').val(),
              dx_sek5 : $('input[name=diag_sek5]').val(),
              icd_awal: $('input[name=in_diag_awal]').val(),
              icd_utama: $('input[name=in_diag_utama]').val(),
              icd_sek1: $('input[name=in_diag_sek1]').val(),
              icd_sek2: $('input[name=in_diag_sek2]').val(),
              icd_sek3: $('input[name=in_diag_sek3]').val(),
              icd_sek4: $('input[name=in_diag_sek4]').val(),
              icd_sek5: $('input[name=in_diag_sek5]').val(),

              tindakan1 : $('input[name=tindakan1]').val(),
              tindakan2 : $('input[name=tindakan2]').val(),
              tindakan3 : $('input[name=tindakan3]').val(),
              tindakan4 : $('input[name=tindakan4]').val(),

              icd_tindakan1 : $('input[name=in_tindakan1]').val(),
              icd_tindakan2 : $('input[name=in_tindakan2]').val(),
              icd_tindakan3 : $('input[name=in_tindakan3]').val(),
              icd_tindakan4 : $('input[name=in_tindakan4]').val(),
              tarif_inacbg  : $('input[name=tarif_inacbg]').val(),
              status  : '',
              verifikator : $('input[name=in_verifikator]').val(),
              user    : _user_logged_in,
              date    : moment().format('YYYY-MM-DD'),
              time    : moment().format('HH:mm:ss')
            };


            data_rec = {
                data_utama : { 
                  nobill : nobill
                },
                data_paket : jPost_tbl1,
              };
            let jPost_tblrec = {
              id   : '',
              app  : 'bo/menu/casemix/pantauan_biaya_ri',
              element : $(this)[0].name,
              nama : 'update_histori_diagnosa',
              ket  : 'Histori diagnosa pasien diedit.',
              data : JSON.stringify(data_rec),
              user : _user_logged_in,
              date : moment().format('YYYY-MM-DD'),
              time : moment().format('HH:mm:ss')

            };

            // insert_historidiag
            let jPost = {
              where : {
                nobill : nobill,
                id     : id_histori,
              },
              cx_daftarrihistoridiag  : jPost_tbl1,
              cx_rec                  : jPost_tblrec
            }
            console.log(jPost);

            let dt = _ajax('POST','update_historidiag',jPost);
            console.log(dt);
            if(dt == null){
              console.log('Proses Sukses. Histori diagnosa pasien diedit.');
            }else{
              alert('Proses Gagal. Silahkan ulangi.');
              return 0;
            }
          //\EDIT HISTORI XLINK
      }

      
      diags[0] = $('input[name=in_diag_utama]').val();
      diags_val = diags[0];

      for (let i = 0; i < 5; i++) {
        diags[(i+1)] = $('input[name=in_diag_sek'+(i+1)+']').val();
        if(diags[(i+1)] != ''){
          diags_val += '#' + diags[(i+1)];
        }
      }
      console.log([diags, diags_val]);

      
      procs[0] = $('input[name=in_tindakan1]').val();
      procs_val = procs[0];
      for (let i = 1; i < 4; i++) {
        procs[(i+1)] = $('input[name=in_tindakan'+(i+1)+']').val();
        if(procs[(i+1)] != ''){
          procs_val += '#' + procs[(i+1)];
        }
      }
      console.log([procs, procs_val]);

      //-- SET_CLAIM INACBG
      let set_claim = 
      {
        "metadata": {
          "method": "set_claim_data",
          "nomor_sep": $('input[name=nosep]').val(),
        },
        "data": {
          "nomor_sep"     : $('input[name=nosep]').val(),
          "nomor_kartu"   : biopx.Barcode,
          "tgl_masuk"     : biopx.TanggalMasuk,
          "tgl_pulang"    : $('input[name=tgl_krs]').val(), //"2017-12-01 09:55:00",
          "jenis_rawat"   : js_sepcbg.response.pesertasep.tktPelayanan, //  1 = rawat inap, 2 = rawat jalan
          "kelas_rawat"   : js_sepcbg.response.pesertasep.klsRawat, // js_sepcbg.response.pesertasep.tktPelayanan;
          "adl_sub_acute" : "",
          "adl_chronic"   : "",
          "icu_indikator" :  icu_indicator, //"0",
          "icu_los"       : $('#icu_los').val(), // input
          "ventilator_hour"   : $('#ventilator_hour').val(), // input
          "upgrade_class_ind" : kelas_bpjs_indikator,
          "upgrade_class_class": kelas_bpjs, // "0",
          "upgrade_class_los" : $('#upgrade_class_los').val(),
          "add_payment_pct"   : "0",
          "birth_weight"      : $('#birth_weight').val(), //"0",
          "discharge_status"  :  $('#discharge_status').find(':selected').data('inakode'), // $('#discharge_status').val(),
          "diagnosa"  : diags_val, // "S71.0#A00.1",
          "procedure" : procs_val, // "81.52#88.38",
          "tarif_rs": {
            "prosedur_non_bedah": trf_rs_ina.detail_tarif.prosedur_non_bedah,
            "prosedur_bedah"    : trf_rs_ina.detail_tarif.prosedur_bedah,
            "konsultasi"  : trf_rs_ina.detail_tarif.konsultasi,
            "tenaga_ahli" : trf_rs_ina.detail_tarif.tenaga_ahli,
            "keperawatan" : trf_rs_ina.detail_tarif.keperawatan,
            "penunjang"   : trf_rs_ina.detail_tarif.penunjang,
            "radiologi"   : trf_rs_ina.detail_tarif.radiologi,
            "laboratorium": trf_rs_ina.detail_tarif.laboratorium,
            "pelayanan_darah" : trf_rs_ina.detail_tarif.pelayanan_darah,
            "rehabilitasi"    : trf_rs_ina.detail_tarif.rehabilitasi,
            "kamar"           : trf_rs_ina.detail_tarif.kamar,
            "rawat_intensif"  : trf_rs_ina.detail_tarif.rawat_intensif,
            "obat"      : trf_rs_ina.detail_tarif.obat,
            "alkes"     : trf_rs_ina.detail_tarif.alkes,
            "bmhp"      : trf_rs_ina.detail_tarif.bmhp,
            "sewa_alat" : trf_rs_ina.detail_tarif.sewa_alat
          },
          /* TAMBAHAN COVID */
          "pemulasaraan_jenazah": "1",
          "kantong_jenazah": "1",
          "peti_jenazah": "1",
          "plastik_erat": "1",
          "desinfektan_jenazah": "1",
          "mobil_jenazah": "0",
          "desinfektan_mobil_jenazah": "0",
          "covid19_status_cd": "1",
          "nomor_kartu_t": "nik",
          "episodes": "1;12#2;3#6;5",
          "covid19_cc_ind": "1",
          "covid19_rs_darurat_ind": "1",
          "covid19_co_insidense_ind": "1",
          "covid19_penunjang_pengurang": {
            "lab_asam_laktat"   : $('input[name=lab_asam_laktat]').val(),
            "lab_procalcitonin" : $('input[name=lab_procalcitonin]').val(),
            "lab_crp"     : $('input[name=lab_crp]').val(),
            "lab_kultur"  : $('input[name=lab_kultur]').val(),
            "lab_d_dimer" : $('input[name=lab_d_dimer]').val(),
            "lab_pt"      : $('input[name=lab_pt]').val(),
            "lab_aptt"    : $('input[name=lab_aptt]').val(),
            "lab_waktu_pendarahan" : $('input[name=lab_waktu_pendarahan]').val(),
            "lab_anti_hiv"    : $('input[name=lab_anti_hiv]').val(),
            "lab_analisa_gas" : $('input[name=lab_analisa_gas]').val(),
            "lab_albumin"     : $('input[name=lab_albumin]').val(),
            "rad_thorax_ap_pa": $('input[name=rad_thorax_ap_pa]').val()
          },
          /*\TAMBAHAN COVID */

          "tarif_poli_eks": "0",
          // "nama_dokter"   : $('select[name=sel_dpjp]').find(":selected").data('nama'), //text(),
          "nama_dokter"   : dpjp_nama, //text(),
          "kode_tarif"    : "CS",
          "payor_id"      : "3",
          "payor_cd"      : "JKN",
          "cob_cd"        : "0",
          "coder_nik"     : $('#coder_nik').val(), // detail.rscmklaim.coder_nik
        }
      };

      console.log({ "send_setklaim" : set_claim});
      let js_setklaim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", set_claim);
      console.log(js_setklaim);
      //\-- SET_CLAIM INACBG


      //-- GROUPING1
      let grouping = {
        "metadata": {
          "method":"grouper",
          "stage":"1"
        },
        "data": {
          "nomor_sep": $('input[name=nosep]').val(),
        }
      };

      console.log({"send_grouping": grouping});
      let js_grouping = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", grouping);
      console.log(js_grouping);
      
      if(js_grouping.metadata.code==200){
        tarifGrouping1 = parseInt(js_grouping.response.cbg.tariff);
        $('input[name=tarif_inacbg]').val(tarifGrouping1);
        $('#GroupKet').text(js_grouping.response.cbg.description);
        $('#GroupCode').text(js_grouping.response.cbg.code);
        $('#GroupTarif').text( numeral(tarifGrouping1).format('0,0') );

        $('#totTarifGrouper').text( numeral(tarifGrouping1).format('0,0') );

        
        let cmgOpt = {
          Proc: [],
          Pros: [],
          Inv: [],
          Drug: [],
        };
        let cmgOptLabel = null;

        // special_cmg_option !=null
        if( js_grouping.special_cmg_option != undefined){
          for (let c = 0; c < js_grouping.special_cmg_option.length; c++) {
            if(js_grouping.special_cmg_option[c].type == 'Special Procedure'){
              cmgOptLabel = 'Proc';
            }else if(js_grouping.special_cmg_option[c].type == 'Special Prosthesis'){
              cmgOptLabel = 'Pros';
            }else if(js_grouping.special_cmg_option[c].type == 'Special Investigation'){
              cmgOptLabel = 'Inv';
            }else if(js_grouping.special_cmg_option[c].type == 'Special Drug'){
              cmgOptLabel = 'Drug';
            }else{}

            cmgOpt[cmgOptLabel].push(js_grouping.special_cmg_option[c]);
            let el = 
              '<option value="'+js_grouping.special_cmg_option[c].code+'">'+
                js_grouping.special_cmg_option[c].description+
              '</option>';
            $('#Special'+cmgOptLabel).append(el);          
          }
        }
        

        // BAGIAN TAMBAHAN_BIAYA
        let ketTambahanBiaya = '',
            totTambahanBiaya = '';
        
        let GrpIna = {
          hakKelas : {
            id: '',
            label: '',
            tarif: '',
          },
          klsPilih : {
            id: '',
            label: '',
            tarif: '',
          },
          
        };
        
        
        console.log({
          kelas_bpjs_indikator:kelas_bpjs_indikator,
          hakKelas:hakKelas,
        });

        if(kelas_bpjs_indikator){ // IF NAIK/TURUN KELAS

          if(hakKelas == 'Kelas 1'){
            //VIP = 0.75*tarifHakKelas
            GrpIna.hakKelas.tarif = tarifGrouping1;
            ketTambahanBiaya = '75% x '+ numeral(GrpIna.hakKelas.tarif).format('0,0');
            totTambahanBiaya = 0.75*GrpIna.hakKelas.tarif;
          }else{
            
            GrpIna.hakKelas.id    = parseInt(hakKelas.split(" ")[1]);
            GrpIna.hakKelas.label = 'kelas_'+hakKelas.split(" ")[1];
            GrpIna.hakKelas.tarif = tarifGrouping1;
            
            // GrpIna_klsPilih.id    = $('select[name=kelas]').find(":selected").data("bpjs");
            GrpIna.klsPilih.id    = $('select[name=kelas]').find(":selected").val();
            GrpIna.klsPilih.label = 'kelas_'+GrpIna.klsPilih.id;
            GrpIna.klsPilih.tarif = js_grouping.tarif_alt[GrpIna.klsPilih.id-1].tarif_inacbg;
            // ketTambahanBiaya = tarifKelasDipilih - tarifHakKelas;
            // ketTambahanBiaya = GrpIna.klsPilih.tarif +'-'+ GrpIna.hakKelas.tarif;
            ketTambahanBiaya = numeral(GrpIna.klsPilih.tarif).format('0,0') +'-'+ numeral(GrpIna.hakKelas.tarif).format('0,0');
            totTambahanBiaya = GrpIna.klsPilih.tarif - GrpIna.hakKelas.tarif;
            console.log({
              GrpIna:GrpIna,
              ketTambahanBiaya:ketTambahanBiaya,
              totTambahanBiaya:totTambahanBiaya,
            });
          }

          $('#ketTambahanBiaya').text( ketTambahanBiaya );
          $('#totTambahanBiaya').text( numeral(totTambahanBiaya).format('0,0') );
        }

        //HASIL FILTERISASI & KLASIFIKASI special_cmg
        console.log(cmgOpt);
        // alert(js_grouping.response.cbg.code+':'+js_grouping.response.cbg.description);
      }else{
        alert(js_grouping.metadata.message);
      }
      //\-- GROUPING1

    });
      
    
    
    
    //-- GROUPING STAGE 2
    
    let cmgOptArr = ['Proc', 'Pros', 'Inv', 'Drug'];
    let cmgOptSelectedAll = [],
        cmgOptSend = '';
    $('.selCmgOpt').on('change', function(e){ //onchange??
      e.preventDefault();
      // console.log($(this+' option:selected').val());
      console.log($(this).val());
      for (let i = 0; i < cmgOptArr.length; i++) {
        // cmgOptSelectedAll[i] = $('#Special'+cmgOptArr[i]+' option:selected').val();        
        cmgOptSelectedAll[i] = $('#Special'+cmgOptArr[i]).val();
      }
      console.log(cmgOptSelectedAll);

      cmgOptSelectedAll = $.grep(cmgOptSelectedAll, function(check) {
        return (check != '');
      });
      console.log(cmgOptSelectedAll);

      cmgOptSend = cmgOptSelectedAll.join('#');
      console.log(cmgOptSend);

      if(cmgOptSend == ''){ // netralisir semua CODE & TARIF SPECIAL_CMG element table
        for (let c = 0; c < cmgOptArr.length; c++) {
          $('#Special'+cmgOptArr[c]+'Code').text('-');
          $('#Special'+cmgOptArr[c]+'Tarif').text('0');            
        }

        $('#totTarifGrouper').text( numeral(tarifGrouping1).format('0,0') );
        $('input[name=tarif_inacbg]').val(tarifGrouping1);
      }else{

        let grouping2 = {
          "metadata": {
            "method":"grouper",
            "stage":"2"
          },
          "data": {
            "nomor_sep": $('input[name=nosep]').val(),
            "special_cmg": cmgOptSend,
          }
        };

        console.log({"send_grouping2": grouping2});
        let js_grouping2 = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", grouping2);
        console.log(js_grouping2);
        if(js_grouping2.metadata.code==200){
          // HASIL GROUPING2 DITAMPILKAN DI TABEL TARIF SPESIAL CMG
          let totTarifGrouper = tarifGrouping1;
          for (let c = 0; c < js_grouping2.response.special_cmg.length; c++) {
            if(js_grouping2.response.special_cmg[c].type == 'Special Procedure'){
              cmgOptLabel = 'Proc';
            }else if(js_grouping2.response.special_cmg[c].type == 'Special Prosthesis'){
              cmgOptLabel = 'Pros';
            }else if(js_grouping2.response.special_cmg[c].type == 'Special Investigation'){
              cmgOptLabel = 'Inv';
            }else if(js_grouping2.response.special_cmg[c].type == 'Special Drug'){
              cmgOptLabel = 'Drug';
            }else{}

            totTarifGrouper += parseInt(js_grouping2.response.special_cmg[c].tariff);
            $('#Special'+cmgOptLabel+'Code').text(js_grouping2.response.special_cmg[c].code);
            $('#Special'+cmgOptLabel+'Tarif').text( numeral(js_grouping2.response.special_cmg[c].tariff).format('0,0') );
            
          }

          // $('#totTarifGrouper').text(totTarifGrouper);
          $('#totTarifGrouper').text( numeral(totTarifGrouper).format('0,0') );
          $('input[name=tarif_inacbg]').val(totTarifGrouper);
        }else{
          alert(js_grouping2.metadata.message);
        }

      }


    });

    // //\-- GROUPING STAGE 2


    $('#btn_insert_daftarrj').click(function(){
      nobill= $('input[name=nobill]').val();      
      norm  = $('span[name=norm]').text();
      sep   = $('input[name=nosep]').val();
      noka  = biopx.Barcode;
      console.log(nobill, norm, sep, noka);

      // url :"model_rscm.php?kode=nosep_replace",
      // url :"model_rscm.php?kode=noka_replace",
      // url :"model_rscm.php?kode=form_pelengkap_rscm",
      data = {
        nobill: nobill,
        norm  : norm,
        sep   : sep,
        noka  : noka,
        biopx : biopx,
        anamnesa	  : $("textarea[name=anamnesa]").val(),
        fisik		    : $("textarea[name=fisik]").val(),
        DokterKode	: $('select[name=nama_dokter]').find(":selected").val(),
        DokterNama 	: $('select[name=nama_dokter]').find(":selected").text(),
        TriageKode	: $('select[name=triage]').val(),
        kodekasus	  : $('select[name=kasus]').val(),

        ICDKode  :  $('input[name=in_diag_utama]').val(),
        ICDKode2 :  $('input[name=in_diag_sek1]').val(),
        ICDKode3 :  $('input[name=in_diag_sek2]').val(),
        ICDKode4 :  $('input[name=in_diag_sek3]').val(),
        ICDKode5 :  $('input[name=in_diag_sek4]').val(),

        kodetindakan  : $('input[name=in_tindakan1]').val(),
        kodetindakan2 : $('input[name=in_tindakan2]').val(),
        kodetindakan3 : $('input[name=in_tindakan3]').val(),
        kodetindakan4 : $('input[name=in_tindakan4]').val(),
      };
      
      let js = _ajax_web("POST", baseUrl()+"casemix/simpan_eklaimrs_rj", data);
      console.log(js);

    });


    // $("#myfile").change(function(e){
    $("input[type=file]").change(function(e){
      let file = this.files[0];
      let filetype = file.type;
      // console.log([file, filetype, $(this), $(this)[0].name ]); 
      // return false;
      
      let formdata = new FormData( $("#frmBerkas")[0] );
      formdata.append('inputName', $(this)[0].name);
      formdata.append('nosep', sep);
      console.log( formdata );
      console.log( $("#frmBerkas")[0] );

      // COBA SAJA
      // var xhr = new XMLHttpRequest;
      // xhr.open('POST', '/', true);
      // xhr.send(formdata);
      // return false;

      $.ajax({
        async : false,
        url: baseUrl()+'eclaim/cek_upload_pdf_eclaim',
        type: "POST",
        // data: new FormData( $("#frmBerkas")[0] ),
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data){
          // console.log(data);
          js = JSON.parse(data);
          console.log(js);
        }
      });
      return false;
    });


  }

  //***************************************************/
  //       \bo/menu/casemix/pantauan_biaya_ri
  //***************************************************/

  //***************************************************/
  //        bo/menu/casemix/laporan_pasien_ri
  //***************************************************/
  if( open_site('bo/menu/casemix/laporan_pasien_ri') ){
    let dt = '';
    //Date picker
    $('.datepicker').datepicker({
    // $('#datepick').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('button[name=btn_tgl_px_ri]').click(function(e){
      e.preventDefault();
      let date = $('input[name=tgl_px_ri]').val();
      let date_end = $('input[name=tgl_end_px_ri]').val();
      console.log([date, date_end]);

      // dt = _ajax('GET','select_laporan_px_ri_by_date',{date: '2019-01-17'});
      // dt = _ajax('GET','select_laporan_px_ri_by_date',{date: date});
      js = _ajax('GET', 'select_laporan_px_ri_by_daterange/'+date+'/'+date_end, '');
      dt = js.li;
      console.log(dt);
      // ld_tbl_laporan_px_ri_by_date(dt);

      //-- CREATE TABLE
      $('div[name=tbl_laporan_px_ri]').children().remove();

      let el_new_tbl = 
      '<table class="table table-bordered" name="tbl_laporan_px_ri">'+
        '<thead>'+
          '<tr>'+
            '<td>No.</td> <td>Opsi</td> <td>Billing</td>'+
            '<td>NoRM</td> <td>Nama</td> <td>Lantai</td> <td>Ruang</td>'+
            '<td>Dx Pilih</td><td>Tarif RS</td> <td>Tarif INA</td><td>Selisih INA-RS</td>'+
            '<td>Status Tarif</td> <td>Status Bill</td>'+
          '</tr>'+
        '</thead>'+
        '<tbody></tbody>'+
      '</table>';
      $('div[name=tbl_laporan_px_ri]').append(el_new_tbl);


      //$('table[name=tbl_pasien_daftarrj] tbody').children().remove();
      for(let i=0; i<dt.length; i++){
        // //pembanding_status_tarif ina dg rs
        // let st_tarif = pembanding_status_tarif(dt[i].tarif_ina_terpilih, dt[i].tarif_rs_now);
        // // $('span[name=status_tarif]').text(st_tarif.status_tarif).attr('class','label label-'+st_tarif.label_css);
        // //\pembanding_status_tarif ina dg rs

        let el = 
          '<tr data-bill="'+dt[i].nobill+'">'+
            '<td>'+(i+1)+'</td>'+
            '<td><button class="btn btn-primary" name="btn_cetak_" style="padding:0px 5px;">Cetak</button></td>'+
            '<td>'+dt[i].nobill+'</td>'+

            '<td>'+dt[i].norm+'</td>'+
            '<td><a class="mdl_detail_pasien">'+dt[i].Nama+'</a></td>'+
            '<td>'+dt[i].KodeLantai+'</td>'+
            '<td>'+dt[i].nama_ruang+'</td>'+

            // '<td>'+dt[i].tarif_rs+'</td>'+
            '<td>'+dt[i].id_histori+'</td>'+
            '<td>'+numeral(dt[i].tarif_rs_now).format('0,0')+'</td>'+
            '<td>'+numeral(dt[i].tarif_ina_terpilih).format('0,0')+'</td>'+
            '<td>'+numeral(dt[i].selisih_ina_rs).format('0,0')+'</td>'+
            '<td><span class="label label-'+dt[i].label_css+'" >'+dt[i].status_tarif+'</span></td>'+
            '<td>'+dt[i].status_bill+'</td>'+

          '</tr>';
        $('table[name=tbl_laporan_px_ri] tbody').append(el);
      }
      $('table[name=tbl_laporan_px_ri]').DataTable({"scrollX": true});
      
      //\-- CREATE TABLE
    });

    $('button[name=btn_dl_excel_px_ri]').click(function(e){
      e.preventDefault();
      let date = $('input[name=tgl_px_ri]').val();      
      let date_end = $('input[name=tgl_end_px_ri]').val();
      if(date == ''){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      console.log(date);
      // window.open(baseUrl()+'ajaxreq/download_xls_laporan_px_ri?date='+date);
      window.open(baseUrl()+'ajaxreq/select_laporan_px_ri_by_daterange/'+date+'/'+date_end+'/1', '');   
        
    });

    
  }

  //***************************************************/
  //       \bo/menu/casemix/laporan_pasien_ri
  //***************************************************/

  
  //***************************************************/
  //        bo/menu/casemix/eclaim/eclaim-rj
  //***************************************************/
  if( open_site('bo/menu/casemix/eclaim/eclaim-rj') ){
    let nomor_kartu, nomor_sep, nomor_rm, nomor_rm_param, nama_pasien, tgl_lahir, gender;
    let tglPelayanan, tktPelayanan;
    let js_nosep;

    let nomor_rm_rscm , nomor_billing, nobill_ada;

    function array2text(arr, delimiter=", "){
      let val='';
      for(i=0;i<arr.length;i++){
        // if(i>0) val += delimiter+' '+arr[i]; 
        if(i>0) val += delimiter+arr[i]; 
        else val += arr[i];
      }
      return val;
    }
    
    // function hitungUmurPart(birthDay, birthMonth, birthYear) {
    //     var currentDate = new Date();
    //     var currentYear = currentDate.getFullYear();
    //     //var currentMonth = currentDate.getMonth();
    //     var currentMonth = (currentDate.getMonth())+1;//karena januari nilainya 0
    //     var currentDay = currentDate.getDate(); 
    //     var calculatedAge = currentYear - birthYear;
    //     if(calculatedAge>0){
    //       if (currentMonth < birthMonth) {
    //           calculatedAge--;
    //       }else{
    //         if(currentDay < birthDay){
    //           calculatedAge--;
    //         }
    //       }
    //     }
    //     return calculatedAge;
    // }
    
    // di OFF kan, karena crash dengan di lib
    // function hitungUmur(dateLahir){
    //   let res = dateLahir.split("-");
    //   let tglLahir = res[2];
    //   let blnLahir = res[1];
    //   let thnLahir = res[0];
    //   return hitungUmurPart(tglLahir, blnLahir, thnLahir);
    // }


    //var age = hitungUmur("2018-01-08");
    //alert(age);	
    let daftarDiag, inputCariDiagnosa, diagCount=0;
    let inputCariProsedur, prosedurCount;
    let i,j;
    
    $('input[name=nosepIna]').focus();

    $("input[name=nosepIna]").keypress(function (e) { //TEKAN ENTER
      if (e.which == 13) {
        nomor_sep = $(this).val();
       
        if($(this).val().length != 19){
          alert('Form SEP harus diisi dan harus 19 digit!');
        }else{
          let G = _ajax_web("GET", baseUrl()+"main/db/m_casemix/cari_billing_by_nosep/"+nomor_sep, "");
          console.log(G);
          if(G[0] != undefined){
            $('input[name=nomor_billing]').val(G[0].NoBill);
          }


          let BR = _ajax_bpjs("GET", "url/GET/sep/cbg/"+nomor_sep, "");
          console.log(BR);

          if(BR.metaData.code == 200){
            $("textarea#hasiljsonIna").html(JSON.stringify(BR));
            nomor_kartu = BR.response.pesertasep.noKartuBpjs;
            nomor_rm 	  = BR.response.pesertasep.noMr; 
            nama_pasien = BR.response.pesertasep.nama; 
            tgl_lahir 	= BR.response.pesertasep.tglLahir; 
            gender 		  = BR.response.pesertasep.kelamin;

            tglPelayanan= BR.response.pesertasep.tglPelayanan;
            tgl_masuk 	= tglPelayanan;
            tgl_pulang 	= tglPelayanan;
            tktPelayanan= BR.response.pesertasep.tktPelayanan;


            $("input[name=nomor_rm]").val(nomor_rm);
            $("input[name=nama_pasien]").val(nama_pasien);
            $("input[name=tgl_lahir]").val(tgl_lahir);
            gender = (gender=='L')? 1 : 2;
            //$('input:radio[name=radioJk]').val(['2']);
            $('input:radio[name=radioJk]').val([gender]);

            $('#lblNoBpjsVal').text(nomor_kartu);
            $('#lblNosepVal').text(nomor_sep);

            $('input:radio[name=rdJenisRawat]').val([tktPelayanan]);
            $('#tgl_masuk').text(tgl_masuk);
            $('#tgl_pulang').text(tgl_pulang);
            $('#umur').text(hitungUmur(tgl_lahir));

                        
            $('input[name=nomor_billing]').focus();
            $('input[name=nomor_billing_RI]').focus();
          }else{
            alert("[code:"+BR.metaData.code+"] "+BR.metaData.message);
          }          

          return false;          
        }

        return false;    //<---- Add this line
      }
    });


    $('input[name=nomor_billing]').keypress(function (e) {
      if (e.which == 13) {
        nomor_billing = $(this).val();
        console.log(nomor_billing);
  
        //TARIF DI TAMPILKAN
        // $('#btnDetailBill_pdf').attr("href","http://192.168.1.5/rscm/app/ajaxreq/modif_gd_biaya_ri_det_by_billing_pdf/"+nomor_billing);
        
        //TARIF DI HIDDEN -> 2020.01.13
        $('#btnDetailBill_pdf').attr("href","http://192.168.1.5/rscm/app/ajaxreq/modif_gd_biaya_ri_det_by_billing_pdf_v2/"+nomor_billing);
  
        my_date = moment().format('YYYY-MM-DD');
        my_time = moment().format('hh:mm:ss');
  
        // ------------ bioPasienByBill -----------
        let billEnter = _ajax_web("GET", baseUrl()+"casemix/eclaimrj_billingEnter/"+nomor_billing, "");
        console.log(billEnter);

        if( $('#nosepIna').val() == '') $('#nosepIna').val(billEnter.bio.nosep);

        nomor_rm_rscm = billEnter.bio.NoRM;
        $("input[name=nomor_rm_xlink]").val(nomor_rm_rscm);
  
        (nomor_rm_rscm == nomor_rm)? 
          $("span[name=status_rm_xlink]").text('Sama') :
          $("span[name=status_rm_xlink]").text('Beda');
        
  
        $('span[name=pasienRscm_norm]').text(nomor_rm_rscm);
        $('span[name=pasienRscm_nama]').text(billEnter.bio.Nama);
        $('span[name=pasienRscm_jk]').text(billEnter.bio.Sex);
        $('span[name=pasienRscm_tglLahir]').text(billEnter.bio.TglLahir);
  
        $('textarea[name=anamnesa]').val(billEnter.bio.Anamnesa);
        $('textarea[name=fisik]').val(billEnter.bio.fisik);
  
        // $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');
        $('select[name=triage] option[value="'+billEnter.bio.TriageKode+'"]').attr('selected','selected');
        $('select[name=kasus] option[value="'+billEnter.bio.kodekasus+'"]').attr('selected','selected');
  
        $('input[name=inputCariDokter]').val(billEnter.bio.DokterKode);
        $('input[name=inputCariDokter]').trigger('keyup');
        //$('input[name=inputCariDokter]').triggerHandler('keyup');
  
        // ------------\bioPasienByBill -----------
             
        
        // ------------ historyDiagnosa -----------
        let hisDX = billEnter.historyDiagnosa;

        for(let i=0; i<hisDX.length; i++){
          let htmlVal = 
          '<tr>'+
            '<td>'+hisDX[i].BillNo+'</td>'+
            '<td>'+hisDX[i].Lokasi+'</td>'+
            '<td>'+hisDX[i].ICD+'</td>'+
            '<td>'+hisDX[i].ICD2+'</td>'+
            '<td>'+hisDX[i].ICD3+'</td>'+
            '<td>'+hisDX[i].ICD4+'</td>'+
            '<td>'+hisDX[i].ICD5+'</td>'+
            '<td>'+hisDX[i].Tanggal+'</td>'+
          '</tr>';
          $('table[name=tbl_historyDiagnosa]').append(htmlVal);
        }
        // ------------\historyDiagnosa -----------


        // ------------ detail_bill_tindakan -----------
        let detTX = billEnter.detail_bill_tindakan;
        $('table[name=tbl_detail_bill_tindakan] tbody').children().remove();
        for(let i=0; i<detTX.length; i++){
          let htmlVal = 
          '<tr>'+
            '<td style="text-align:center;">'+(i+1)+'</td>'+
            '<td>'+detTX[i].NoReff+'</td>'+
            '<td>'+detTX[i].nama_tindakan+' - '+detTX[i].lokasi_ket+'</td>'+
            '<td style="text-align:center;">'+detTX[i].Jumlah+'</td>'+
            '<td style="text-align:right;">'+detTX[i].GrandTotal+'</td>'+
          '</tr>';
          $('table[name=tbl_detail_bill_tindakan] tbody').append(htmlVal);
        }

        // ------------\detail_bill_tindakan -----------


        // ------------ cariTarif -----------
        let cariTarif = billEnter.cariTarif;
        $("span[name=total_tarif]").text(cariTarif.total_tarif);

        $("input[name=prosedur_non_bedah]").val(cariTarif.data.prosedur_non_bedah);
        $("input[name=prosedur_bedah]").val(cariTarif.data.prosedur_bedah);
        $("input[name=konsultasi]").val(cariTarif.data.konsultasi);
        $("input[name=tenaga_ahli]").val(cariTarif.data.tenaga_ahli);
        $("input[name=keperawatan]").val(cariTarif.data.keperawatan);
        $("input[name=penunjang]").val(cariTarif.data.penunjang);
        $("input[name=radiologi]").val(cariTarif.data.radiologi);
        $("input[name=laboratorium]").val(cariTarif.data.laboratorium);
        $("input[name=pelayanan_darah]").val(cariTarif.data.pelayanan_darah);
        $("input[name=rehabilitasi]").val(cariTarif.data.rehabilitasi);
        $("input[name=kamar]").val(cariTarif.data.kamar);
        $("input[name=rawat_intensif]").val(cariTarif.data.rawat_intensif);
        $("input[name=obat]").val(cariTarif.data.obat);
        $("input[name=alkes]").val(cariTarif.data.alkes);
        $("input[name=bmhp]").val(cariTarif.data.bmhp);
        $("input[name=sewa_alat]").val(cariTarif.data.sewa_alat);       

        // ------------\cariTarif -----------

        // ------------ cariObatBill -----------
        let cariObatBill = billEnter.cariObatBill;
        let obatValArr=[];
        for(i=0;i<cariObatBill.length;i++) 
          obatValArr.push(cariObatBill[i].kodebrgket);
        $('textarea[name=daftarObatRscmByBill]').val(array2text(obatValArr));
        // ------------\cariObatBill -----------
      
        return false;
      }
    });//[END] nomor_billing ENTER_BTN = menampilkan cek tarif
    

    //CEK RM DOUBLE >> RM VCLAIM dg RM XLINK
    $("input[name=nomor_rm]").focusout(function(){
      if($(this).val().length == 6 ){
        if( $(this).val() == nomor_rm_rscm )
          $('span[name=status_rm_xlink]').text('Sama');
        else
          alert('NoRM pada Form ini harus sama. Cek kembali NoRM!');
                
      }else{
        alert('NoRM harus 6 digit!');
      }
    });


    
    let statusBuatKlaim = 0; //utk trigger #btnSetKlaim
    $("#btnBuatKlaimBaru").click(function(){
      if($("span[name=status_rm_xlink]").text() == 'Beda' ){
        alert('No.RM VClaim dan No.RM Xlink BERBEDA. Silahkan cek kembali.');
      }else if($("span[name=status_rm_xlink]").text() == '-'){
        alert('Anda belum memasukkan nomor SEP dan nomor Billing dilangkah sebelumnya.');
      }else{
        statusBuatKlaim = 1;

        alert('rm='+$("input[name=nomor_rm]").val());

        let new_claim = 
          {
            "metadata": {
              "method": "new_claim"
            },
            "data": {
              nomor_kartu : nomor_kartu,
              nomor_sep 	: nomor_sep,
              nomor_rm 	  : $("input[name=nomor_rm]").val(), 
              nama_pasien : nama_pasien, 
              tgl_lahir	  : tgl_lahir,
              gender		  : gender
            }
          };
        
          let data = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json", new_claim);
          
          if(data.metadata.code == 200){
            //alert('Buat Klaim Berhasil. {*code='+data.metadata.code+'. Message='+data.metadata.message+'}');
            alert('Buat Klaim Berhasil.');
          }else if(data.metadata.code == 400){
            alert('{*code='+data.metadata.code+'. Message='+data.metadata.message+'}'); //Duplikasi SEP
          }else{
            alert('Gagal buat klaim. {*code='+data.metadata.code+'. Message='+data.metadata.message+'}');
          }         
            
      }

      $("#btnSetKlaim").trigger('click');
    });


    let nomor_rm_eclaim;
    //let nomor_rm_rscm; //sudah ada dan diDAPAT saat #btnCekTarif KLIK, inputan yang dibutuhkan nomor_billing,
    //nomor_billing dari nomor_sep
    $("label[name=lbl_status_rm]").click(function(){
      let data = _ajax_web("GET", baseUrl()+"eclaim/ajax_eclaim/get_claim_data/"+nomor_sep, "");          
      nomor_rm_eclaim = data.response.data.nomor_rm;  

      if(nomor_rm_rscm == nomor_rm_eclaim){
        $('label[name=status_rm]').text('Nomor RM sama').attr('class','btn btn-success');
      }else{
        $('label[name=status_rm]').text('Nomor RM beda').attr('class','btn btn-danger');
      }

      alert('norm_rscm(dari parameter billing)='+nomor_rm_rscm+' && norm_eclaim='+nomor_rm_eclaim+' && Noka='+ data.response.data.nomor_kartu);
    
    });
  

    $("#btnEditKlaim").click(function(){
      let update_patient = {
				"metadata": {
					"method"	: "update_patient",
					"nomor_rm"	: $("input[name=nomor_rm]").val(),
				},
				"data": {
					nomor_kartu	: nomor_kartu,
          nomor_rm 	  : $("input[name=nomor_rm_baru]").val(), 
          nama_pasien	: $("input[name=nama_pasien]").val(), 
          tgl_lahir	  : $("input[name=tgl_lahir]").val(),
          gender		  : $('input[name=radioJk]:checked').val()
				}
      };
      
      let data = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json", update_patient);
      alert(data);
        
    });
  


    ///////////////////////////////////////////////
    //				CARI DOKTER
    ///////////////////////////////////////////////
    $('input[name=inputCariDokter]').on('keyup',function (e) {
      $('select[name=nama_dokter]').find('option').remove();
      console.log($(this).val());
      if($(this).val().length > 2){
        // {dokter_param : $(this).val()}
        let Gdokter = _ajax_web("GET", baseUrl()+"main/db/m_casemix/cariDokter/"+$(this).val(), "");
        console.log(Gdokter);

        for(let i=0; i<Gdokter.length; i++){
          $('select[name=nama_dokter]').append('<option value="'+Gdokter[i]['kode']+'">'+Gdokter[i]['nama']+'</option>');
        }        
      }
    });


    let statusBtnPelengkap=0;
    $("#btnSepReplace").click(function(){
      if(nomor_sep==''){
        alert('Form SEP harus diisi!');
      }else{
        let anamnesa 	= $("textarea[name=anamnesa]").val(),
            fisik 		= $("textarea[name=fisik]").val(),
            DokterKode 	= $('select[name=nama_dokter]').find(":selected").val(),
            DokterNama 	= $('select[name=nama_dokter]').find(":selected").text();

        console.log([anamnesa, fisik, DokterKode, DokterNama]);

        statusBtnPelengkap=1;

        let P = {
          nomor_billing	: nomor_billing, // $("input[name=nomor_billing]").val(),
          nosep		      : nomor_sep,
          norm	  : nomor_rm_rscm,
          noka		: nomor_kartu,
          Anamnesa	 : $("textarea[name=anamnesa]").val(),
          fisik		   : $("textarea[name=fisik]").val(),
          DokterKode : $('select[name=nama_dokter]').find(":selected").val(),
          DokterNama : $('select[name=nama_dokter]').find(":selected").text(),
          TriageKode : $('select[name=triage]').val(),
          kodekasus	 : $('select[name=kasus]').val()
        };
        console.log(P);

        let sepNokaReplace = _ajax_web("POST", baseUrl()+"casemix/sepNokaReplace/"+nomor_billing, P);
        console.log(sepNokaReplace);

        if(sepNokaReplace.form_pelengkap_rscm == null){ alert('Sukses Update Form Pelengkap.'); }
        
      }
    });

    
    $('input[name=inputCariDiagnosa]').on('keyup',function (e) {
      if($(this).val().length > 2){
        $('select[name=daftarDiagnosa]').find('option').remove();
        inputCariDiagnosa = $("input[name=inputCariDiagnosa]").val();
        
        if(inputCariDiagnosa!=""){
          let data = _ajax_web("GET", baseUrl()+"eclaim/ajax_eclaim/search_diagnosis/"+inputCariDiagnosa, "");          
          console.log(data); 
          
          diagCount = data.response.count;
          
          if(diagCount > 0){
            for(let i=0; i<diagCount; i++)
              $('select#daftarDiagnosa').append('<option value="'+data.response.data[i][1]+'">'+data.response.data[i][1]+'-'+data.response.data[i][0]+'</option>');
            

            if(diagCount==1)
              $('#btnPilihDiagnosa').trigger('click');
            
          }else{
            alert('ICD tidak ditemukan.');
          }
              
        }else{
          alert("Form pencarian diagnosa tidak boleh kosong!");
        }
      }
    });


    let htmlVal;
    let diagVal, 
        diagValArr=[];

    $("#btnPilihDiagnosa").click(function(){
      diagVal = $('select[name=daftarDiagnosa]').find(":selected").val();
      let diagText = $('select[name=daftarDiagnosa]').find(":selected").text();
      //alert(diagValText);
      if(diagVal==undefined||diagVal==''){
        alert("Diagnosa harus diisi");
        
      }else{
        //cek diagnosa sudah dimasukkan/belum. TIDAK BOLEH DOBEL
        let cariDiagPilih = $.inArray(diagVal,diagValArr);
        if(cariDiagPilih<0){ //-1=data tidak ketemu
          diagValArr.push(diagVal); 

          htmlVal = 
          '<li data-label='+diagVal+'>'+
            '<span style="">'+diagText+'</span>'+
            '<button class="btn btn-danger" style="padding:0px 10px;">X</button>'+
          '</li>';
          $('ol[name=daftar_diagnosa_terpilih]').append(htmlVal);
          
          $("input[name=valReqDiagnosa]").val(array2text(diagValArr,'#'));
        }else{
          alert('Diagnosa sudah pernah ditambahkan. Tidak boleh double data.');
        }	
      }
      
    });
	

    //diagnosa_terpilih_hapus
    $(document).on("click","ol[name=daftar_diagnosa_terpilih] li button",function(){
      let lblDiagPilihDel = $(this).parents('li').data('label');
      $(this).parents('li').remove();
      ////alert($(this).parents().index()+"/"+$(this).parents('li').data('label')+"/"+nDiagTerpilih);
      
      let indexDiagPilih = $.inArray(lblDiagPilihDel, diagValArr);
      
      diagValArr.splice(indexDiagPilih, 1); //hapus

      $("input[name=valReqDiagnosa]").val( array2text(diagValArr,'#') );
    });



    $('input[name=inputCariProsedur]').on('keyup',function (e) {
      if($(this).val().length > 0){
        $('select[name=daftarProsedur]').find('option').remove();
        inputCariProsedur = $("input[name=inputCariProsedur]").val();
        if(inputCariProsedur!=""){
          let data = _ajax_web("GET", baseUrl()+"eclaim/ajax_eclaim/search_procedures/"+inputCariProsedur, "");          
          console.log(data);
          
          prosedurCount = data.response.count;
          if(prosedurCount>0){
            for (let i = 0; i < prosedurCount; i++) {              
              $('select[name=daftarProsedur]').append('<option value="'+data.response.data[i][1]+'" data-urut="'+i+'">'+data.response.data[i][1]+'-'+data.response.data[i][0]+'</option>');
            }
          }else{
            alert('Prosedur tidak ditemukan.');
          }
          
        }else{
          alert("Form pencarian prosedur tidak boleh kosong!");
        }
      }
    });
 
 
    let prosedurVal, 
        prosedurValArr=[];

    $("#btnPilihProsedur").click(function(){
      prosedurVal = $('select[name=daftarProsedur]').find(":selected").val();
      let prosedurValText = $('select[name=daftarProsedur]').find(":selected").text();
      //alert(prosedurVal);
      if(prosedurVal==undefined||prosedurVal==''){
        alert("Prosedur harus diisi"); 			
      }else{
        //cek diagnosa sudah dimasukkan/belum. TIDAK BOLEH DOBEL
        let cariProsedurPilih = $.inArray(prosedurVal,prosedurValArr);
        if(cariProsedurPilih<0){ //-1=data tidak ketemu
          prosedurValArr.push(prosedurVal); 

          htmlVal = 
          '<li data-label='+prosedurVal+'>'+
            '<span>'+prosedurValText+'</span>'+
            '<button class="btn btn-danger" style="padding:0px 10px;">X</button>'+
          '</li>';

          $('ol[name=daftar_prosedur_terpilih]').append(htmlVal);

          $("input[name=valReqProsedur]").val( array2text(prosedurValArr,'#') );
        }else{
          alert('Prosedur sudah pernah ditambahkan. Tidak boleh double data.');
        }	
      }
      /////alert(nDiagTerpilih+'/'+diagValArr.length+'/'+diagValArr);
    });

    //prosedur_terpilih_hapus
    $(document).on("click","ol[name=daftar_prosedur_terpilih] li button",function(){
      let lblProsedurPilihDel = ''+$(this).parents('li').data('label');
      $(this).parents('li').remove();
      
      let indexProsedurPilih = $.inArray(lblProsedurPilihDel,prosedurValArr);
      console.log([ lblProsedurPilihDel, indexProsedurPilih]);
      
      prosedurValArr.splice(indexProsedurPilih, 1); //hapus
      console.log(prosedurValArr);

      $("input[name=valReqProsedur]").val( array2text(prosedurValArr,'#') );
    });


    let diagArr4Rscm=[] , prosedurArr4Rscm=[];
    const MAXdiagArr4Rscm = 5 , MAXprosedurArr4Rscm = 4;
    $("#icd_input").click(function(){
      for(let i=0;i<diagValArr.length;i++){
        diagArr4Rscm[i] = diagValArr[i];
      }
      for(let i=diagValArr.length;i<MAXdiagArr4Rscm;i++){// sisa loop isinya di set''
        diagArr4Rscm[i] = '';
      }


      for(let i=0;i<prosedurValArr.length;i++){
        prosedurArr4Rscm[i] = prosedurValArr[i];
      }
      for(let i=prosedurValArr.length;i<MAXprosedurArr4Rscm;i++){// sisa loop isinya di set''
        prosedurArr4Rscm[i] = '';
      }


      // UPDATE FLAGDIAGNOSA
      let P_upd = {
        ICDKode	: diagArr4Rscm[0],
        ICDKode2: diagArr4Rscm[1],
        ICDKode3: diagArr4Rscm[2],
        ICDKode4: diagArr4Rscm[3],
        ICDKode5: diagArr4Rscm[4],
        kodetindakan : prosedurArr4Rscm[0],
        kodetindakan2: prosedurArr4Rscm[1],
        kodetindakan3: prosedurArr4Rscm[2],
        kodetindakan4: prosedurArr4Rscm[3]
      };
      let upd = _db_update( {BillNo : nobill}, 'formdiagnosa', P_upd);
      console.log(upd);

      if(upd == null){ console.log('Update diagnosa >> Sukses.');
      }else{ console.log('Update diagnosa >> Gagal. Silahkan ulangi.'); }

    });


    $("#btnGrouping").click(function(){
      if(statusBuatKlaim==0){
        alert('Anda harus Buat Klaim terlebih dahulu!');
      }else{

        let set_claim = {
          "metadata": {
            "method"    : "set_claim_data",
            "nomor_sep" : nomor_sep,
          },
          "data": {
            "nomor_sep"   : nomor_sep,
            "nomor_kartu" : nomor_kartu,
            "tgl_masuk"   : tglPelayanan,
            "tgl_pulang"  : tglPelayanan,
            "jenis_rawat" : tktPelayanan,
            "kelas_rawat" : "3",
            "adl_sub_acute" : "",
            "adl_chronic"   : "",
            "icu_indikator" : "0",
            "icu_los"       : "0",
            "ventilator_hour"   : "0",
            "upgrade_class_ind" : "0",
            "upgrade_class_class": "0",
            "upgrade_class_los" : "0",
            "add_payment_pct"   : "0",
            "birth_weight"      : "0",
            "discharge_status"  : $('select[name=discharge_status]').find(":selected").val(),
            "diagnosa"  : $("input[name=valReqDiagnosa]").val(),
            "procedure" : $("input[name=valReqProsedur]").val(),
            "tarif_rs"  : {
              "prosedur_non_bedah": $("input[name=prosedur_non_bedah]").val(),
              "prosedur_bedah": $("input[name=prosedur_bedah]").val(),
              "konsultasi"  : $("input[name=konsultasi]").val(),
              "tenaga_ahli" : $("input[name=tenaga_ahli]").val(),
              "keperawatan" : $("input[name=keperawatan]").val(),
              "penunjang"   : $("input[name=penunjang]").val(),
              "radiologi" 	:  $("input[name=radiologi]").val(),
              "laboratorium":  $("input[name=laboratorium]").val(),
              "pelayanan_darah" : $("input[name=pelayanan_darah]").val(),
              "rehabilitasi": $("input[name=rehabilitasi]").val(),
              "kamar" 			: $("input[name=kamar]").val(),
              "rawat_intensif" 	: $("input[name=rawat_intensif]").val(),
              "obat"        : $("input[name=obat]").val(),
              "alkes"       : $("input[name=alkes]").val(),
              "bmhp"        : $("input[name=bmhp]").val(),
              "sewa_alat"	  : $("input[name=sewa_alat]").val(),
            },
            "tarif_poli_eks": "0",
            "nama_dokter": $('select[name=nama_dokter]').find(":selected").text(),
            "kode_tarif": "CS",
            "payor_id"  : $('select[name=payor]').find(":selected").val(),
            "payor_cd"  : $('select[name=payor]').find(":selected").text(),//JKN
            "cob_cd"    : "0",
            "coder_nik" : $('span[name=coder]').data('codernik')
          }
        };

        let btn_grouping = _ajax_web("POST", baseUrl()+"casemix/btn_grouping/"+nomor_billing, set_claim);
        console.log(btn_grouping);

        if(btn_grouping['update_totalINA'] == null){
          alert("Grouping Berhasil. Tarif CBG= "+btn_grouping['totalINA']);
        }else{
          alert("Error GROUPING");
        }
        
                
        nomor_rm_eclaim = btn_grouping.get_claim_data.response.data.nomor_rm;
        //let strdata = JSON.stringify(data); //object json to-> string
        //$('textarea[name=jsreq_get_claim_data]').text(strdata);
        
        if(nomor_rm_rscm == nomor_rm_eclaim){
          $('label[name=status_rm]').text('Nomor RM sama').attr('class','btn btn-success');
        }else{
          $('label[name=status_rm]').text('Nomor RM beda').attr('class','btn btn-danger');
        }

        alert('norm_rscm(dari parameter billing)='+nomor_rm_rscm+' & norm_eclaim='+nomor_rm_eclaim+' & Noka='+ data.response.data.nomor_kartu);
          
      
      }
    });


    $("#btnFinalKlaim").click(function(){
      if(statusBtnPelengkap==0){
        alert('Anda harus klik tombol [SEP & NOKA Replace & Pelengkap] terlebih dahulu!');
      }else{
        let p_claim_final = {
          "metadata": {
            "method":"claim_final"
          },
          "data": {
            "nomor_sep": nomor_sep,
            "coder_nik": $('span[name=coder]').data('codernik'),
          },
        };
        let claim_final = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json", p_claim_final);
        console.log(claim_final);
        alert("Final Klaim Berhasil...");

      }  
    });


    $("#btnHapusKlaim").click(function(){
      let p_delete_claim = {
        "metadata": {
          "method":"delete_claim"
        },
        "data": {
          "nomor_sep": nomor_sep,
          "coder_nik": $('span[name=coder]').data('codernik'),
        },
      };
      let delete_claim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json", p_delete_claim);
      console.log(delete_claim);
      alert("Hapus Klaim Berhasil...");

    });

    $("#btnCetakKlaim").click(function(){ 
      // let url = 'eclaim_cetak.php?nomor_sep='+nomor_sep+'&nobill='+nomor_billing;
      let url = baseUrl()+"eclaim/ajax_eclaim/claim_print/"+nomor_sep+"?nobill="+nomor_billing;
      window.open(url);
      location.reload();
    });

  }  
  //***************************************************/
  //       \bo/menu/casemix/eclaim/eclaim-rj
  //***************************************************/

  //***************************************************/
  //       bo/menu/receptionist/lain-lain/jadwal-dokter
  //***************************************************/
  if( open_site('bo/menu/receptionist/lain-lain/jadwal-dokter') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    //================= FORM JADWAL DOKTER ========================
    let dokter_kode='-', dokter_nama='-', dokter_poli='-';
    let hari_pilih='-', hariId_pilih='-', jam_mulai='-', jam_selesai='-';
    //=================/FORM JADWAL DOKTER ========================



    $('select[name=nama_dokter]').change(function(){
      dokter_kode = $(this).val();       
      dokter_nama = $(this).find(':selected').text();
      dokter_poli = $(this).find(':selected').data('poli');
      $('td[name=kode_dokter]').text(dokter_kode);
      $('td[name=lokasi]').text(dokter_poli);
      console.log(dokter_kode, dokter_nama, dokter_poli); return false;
      
    });


    function loop_hhout(){
      let opt_hhout = '';
      for(let i=0;i<24;i++){
        if(i<10) j='0'+i;
        else j=i;
        opt_hhout += '<option value="'+j+'">'+j+'</option>';
      }
      return opt_hhout;
    }

    function loop_mmout(){
      let opt_mmout = '';
      for(let i=0; i<=45; i+=15){
        let j=0;
        if(i==0) j='00';
        else j=i;        
        opt_mmout += '<option value="'+j+'">'+j+'</option>';
      }
      return opt_mmout;
    }

    function maker_select(name, opt){
      return '<select name="'+name+'" class="form-control modewaktu">' +opt+ '</select>';
    }    
     
 
    function maker_select_full(){
      let el_tot = 
        maker_select('hh_out', loop_hhout())+
          '<span class="modewaktu">:</span>'+
        maker_select('mm_out', loop_mmout());
      return el_tot;
    }

    $('td[name=jam_selesai]').append( maker_select_full() );

    let flagCbox=0;
    // jam_selesai = $("select[name=hh_out]").find(':selected').val() +':'+ $("select[name=mm_out]").find(':selected').val();

    $('input[name=cbox_selesai]').change(function(){
      if(flagCbox==0){ //modeselesai
        $('td[name=jam_selesai]').children().remove();
        $('td[name=jam_selesai]').append('<span>Selesai</span>');
        jam_selesai = 'selesai';
        flagCbox=1;			
      }else{ //modewaktu
        $('td[name=jam_selesai]').children().remove();
        $('td[name=jam_selesai]').append( maker_select_full() );        
        flagCbox=0;
      }
      
    });



    $('button[name=simpan_jadok]').click(function(){
      hari_pilih = $("select[name=hari]").val();
      hariId_pilih = $("select[name=hari]").find(':selected').data('arr_id');
      jam_mulai = $("select[name=hh_in]").val() +':'+ $("select[name=mm_in]").val();      
      jam_selesai = $("select[name=hh_out]").val() +':'+ $("select[name=mm_out]").val();
      
      if(dokter_nama=='-' || hari_pilih=='-'){
        alert('Form harus dilengkapi semua...'); return false;
      }else{
        let P = {
          kodeDokter : dokter_kode,
          hari    : hari_pilih,
          hariId  : hariId_pilih,
          jamMasuk  : jam_mulai,
          jamPulang : jam_selesai,
          user : _user_logged_in,
          date : moment().format('DD-MM-YYYY hh:mm:ss'),
        };
        console.log(P); 
        
        let jPost = _ajax_web("POST", baseUrl()+"main/insert/cm_dokterjadwal", P);
        console.log(jPost);
        if(jPost.status == 'success') alert("Jadwal berhasil ditambahkan."); 
        else alert(jPost.message);
        
        reload();        
        return false;     
      
      }
    });


    $('.btn_del').click(function(){
      id = $(this).data('id');
      console.log(id);
      
      let jPost = _ajax_web("POST", baseUrl()+"main/delete/cm_dokterjadwal", {Id:id});
      console.log(jPost);
      if(jPost == null) alert('Jadwal berhasil dihapus.');
      reload();
      return false;
    });


    
    $('#btn_cetak').click(function(){
      
      jpost_popup = _ajax_web("GET", baseUrl()+'main/db/m_daftarmandiri/get_jadok_all')['dtjs'];
      console.log(jpost_popup);      

      // popup_print_main('jadwal-dokter', jpost_popup);
      popup_print_main_dbload('jadwal-dokter', null, 'receptionist/lain-lain/jadwal-dokter');
      return 0;

      let filename = 'jadwal-dokter';
      let src = baseUrl()+"main/popup_print?filename="+filename;
      var dummy = new iframeform(src);
      dummy.addParameter('type','test');
      dummy.addParameter('message','Works...');
      dummy.addParameter('jadok_tampil', JSON.stringify(jpost_popup) );
      
      dummy.send();
      // dummy.print();
      // console.log(dummy);

    });
  
  
  
  }
  //***************************************************/
  //       \bo/menu/receptionist/lain-lain/jadwal-dokter
  //***************************************************/






  //***************************************************/
  //       bo/menu/receptionist/pendaftaranrj/master-pasien
  //***************************************************/
  if( open_site('bo/menu/receptionist/pendaftaranrj/master-pasien') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $('#sel_negara').prop('value', '100').change();
    $('#sel_propinsi').prop('value', '1').change();

    let kota= '', kecamatan='', kelurahan='';
    $('#sel_kota').change(function(){
      kota = $(this).val();
      console.log(kota);

      let js_kec = _ajax_web("GET", baseUrl()+"main/db/m_pendaftaran/kecamatan/"+kota, "" );
      console.log(js_kec);

      $('#sel_kecamatan').children().remove();
      $('#sel_kecamatan').append('<option value="">-</option>');
      let el='';
      for (let i = 0; i < js_kec.length; i++) {
        el += '<option value="'+js_kec[i]['Kode']+'">'+js_kec[i]['Keterangan']+'</option>';
      }
      $('#sel_kecamatan').append(el);
    });
    
    
    $('#sel_kecamatan').change(function(){
      kecamatan = $(this).val();
      console.log(kecamatan);

      let js_kec = _ajax_web("GET", baseUrl()+"main/db/m_pendaftaran/kelurahan/"+kota+"/"+kecamatan, "" );
      console.log(js_kec);

      $('#sel_kelurahan').children().remove();
      $('#sel_kelurahan').append('<option value="">-</option>');
      let el='';
      for (let i = 0; i < js_kec.length; i++) {
        el += '<option value="'+js_kec[i]['Kode']+'">'+js_kec[i]['Keterangan']+'</option>';
      }
      $('#sel_kelurahan').append(el);
    });

  }
  //***************************************************/
  //       \bo/menu/receptionist/pendaftaranrj/master-pasien
  //***************************************************/
  
  //***************************************************/
  //       bo/menu/receptionist/pendaftaranrj/daftarbooking
  //***************************************************/
  if( open_site('bo/menu/receptionist/pendaftaranrj/daftarbooking') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $('.select2').select2();
    // $('.select2').select2({ placeholder:'', allowClear:true});

    //Date picker
    $('.datepicker_daftaronline').datepicker({
      autoclose : true,
      format    : 'dd/mm/yyyy'
      // format    : 'yyyy-mm-dd'
    });

    //Money Euro
    $('[data-mask]').inputmask();


    // $('#modal_info_daftar_online').modal('show'); //BENERR

    let batas_jam_daftar_hari_ini = 12,
        get_jam_sekarang = parseInt( moment().format('HH') );
    if(get_jam_sekarang >= batas_jam_daftar_hari_ini){
      $('select[name=sel_hari_daftar] option[value=hari_ini]').remove();
    }


    let get_norm = '',
        get_noka = '',
        get_tglLahir = '',
        get_nohp = '',
        get_tgldaftar = moment().format('YYYY-MM-DD'), // default booking besok() 
        lokasiket = '';
        //xlixk : {hari ambil booking = hari ini-1}

    let get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');

    let dt_book_web = null;
    // dt_book_web = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
    // console.log(dt_book_web);
    if(dt_book_web!=null){
      $("span[name=cnt_list_web]").text("("+dt_book_web.length+")");
    }

    
    let _bpjs_syarat_rjk = 0; // 0 = TIDAK BOLEH, 1 = BOLEH
    let get_penanggung_cm_kode ='CO031',
        get_penanggung_cm_nama ='B P J S',
        get_penanggung_cm_st   ='M';

    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      $('select[name=sel_penanggung_cm]').append('<option value="'+sel_penanggung_cm.dtjs[i].Kode+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>');
    }

     // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');


    $('select[name=sel_penanggung_cm]').on('change', function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      _bpjs_syarat_rjk = 1;

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('div[name=form_add_else_bpjs]').hide();
        $('input[name=noka]').removeAttr('disabled');
        _bpjs_syarat_rjk = 0;
        //input val reset
      }else{
        $('div[name=form_add_else_bpjs]').show();
        $('input[name=noka]').attr('disabled','disabled').val('');
        _bpjs_syarat_rjk = 1;
      }
      
      console.log('[get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]');
      console.log([get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]);

    });



    
    $('a[name=btn_modal_ambilweb_daftar_online]').click(function(e){
      e.preventDefault();
      
      // dt_book_web = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
      // console.log(dt_book_web);

      // create tbl
      let th_list = [
          // '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
          'No.', 'Opsi', 'Date', 'Time', 'NoRM', 'Tgl.Lahir', 'NOKA/NIK', 'Penanggung', 'Dokter', 'Klinik', 'Hapus'
        ];
      create_tbl('tbl_laporan_daftaronline_web', th_list);

      // create tbl>tbody
      for(let i=0; i<dt_book_web.length; i++){

        let el = 
          '<tr data-id="'+i+'" data-norm="'+dt_book_web[i].norm+'" data-date="'+dt_book_web[i].date+'">'+
            '<td>'+(i+1)+'</td>'+
            // '<td><button class="btn btn-danger" name="btn_del_daftaronline_web" style="padding:0px 5px;">Hapus</button></td>'+
            '<td><button class="btn btn-warning" name="btn_pilih_daftaronline_web" style="padding:0px 5px;">Pilih</button></td>'+
            '<td name="date">'+dt_book_web[i].date+'</td>'+
            '<td name="time">'+dt_book_web[i].time+'</td>'+
            '<td name="norm">'+dt_book_web[i].norm+'</td>'+
            '<td>'+dt_book_web[i].tgllahir+'</td>'+
            '<td>'+dt_book_web[i].noanggota+'</td>'+
            '<td>'+dt_book_web[i].penanggungket+'</td>'+
            '<td>'+dt_book_web[i].dokterket+'</td>'+
            '<td>'+dt_book_web[i].lokasiket+'</td>'+
            '<td><button class="btn btn-danger" name="btn_del_daftaronline_web" style="padding:0px 5px;">Hapus</button></td>'+
          '</tr>';
        $('table[name=tbl_laporan_daftaronline_web] tbody').append(el);
      }
      $('table[name=tbl_laporan_daftaronline_web]').DataTable();
    });


    // TOMBOL PILIH dari LIST yang ada di modal
    let del_web = '';
    let btn_pilih_dari_web = false;

    $(document).on('click','table[name=tbl_laporan_daftaronline_web] tbody tr td button[name=btn_pilih_daftaronline_web]', function(){

      _user_daftar = "pasien_web";
      
      let get_urut = $(this).parent().parent().data('id');
      console.log(dt_book_web[get_urut]);


      // cek NORM ada di sistem/tidak. Kalau tidak ada, kasih keputusan booking dihapus/tidak.
      let dt_cek_norm = _ajax('POST', 'gd_pasien_rscm_by_norm', {norm:dt_book_web[get_urut]['norm']} );
      console.log(dt_cek_norm);

      if(dt_cek_norm.status == 'SUKSES'){
          $('#modal_ambilweb_daftar_online').modal('hide');
          $('input[name=norm]').val(dt_book_web[get_urut]['norm']);
          // $('input[name=noka]').val(dt_book_web[get_urut]['noanggota']);
          $('input[name=noka]').val('');
          $('input[name=tglLahir]').val(fx_get_tglLahir__min2garing(dt_book_web[get_urut]['tgllahir']));
          $('input[name=nohp]').val(dt_book_web[get_urut]['notlp']);

          del_web = {
            kode:'delete_booking_1px',
            norm : dt_book_web[get_urut]['norm'],
            date : dt_book_web[get_urut]['date'],
            time : dt_book_web[get_urut]['time']
          };
          console.log(del_web);
          
          select_change_by_selected('sel_dokter', dt_book_web[get_urut]['dokterket']);
          select_change_by_selected('sel_penanggung_cm', dt_book_web[get_urut]['penanggung']);

          btn_pilih_dari_web = true;
      }else{ // jika GAGAL
        Swal.fire({
          title: 'Apakah Anda ingin menghapus data ini?',
          text: "NOTE: "+dt_cek_norm.message+" NORM tidak sesuai.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, HAPUS!'
        }).then((result) => {
          if (result.value) {
            Swal.fire(
              'TERHAPUS!',
              'Data Berhasil Dihapus.',
              'success'
            ).then(function(){
              del_web = {
                kode:'delete_booking_1px',
                norm : dt_book_web[get_urut]['norm'],
                date : dt_book_web[get_urut]['date'],
                time : dt_book_web[get_urut]['time']
              };
              // alert(JSON.stringify(del_web) );
              _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', del_web);
              window.location.reload(true);
            });
          }
        });
      }
      

    });


    // TOMBOL DELETE
    $(document).on('click','table[name=tbl_laporan_daftaronline_web] tbody tr td button[name=btn_del_daftaronline_web]', function(){
      let get_urut = $(this).parent().parent().data('id');
      console.log(dt_book_web[get_urut]);
      $('#modal_ambilweb_daftar_online').modal('hide');

      let data = {
          kode:'delete_booking_1px', 
          date: dt_book_web[get_urut]['date'],
          time: dt_book_web[get_urut]['time'],
          norm: dt_book_web[get_urut]['norm']
        };
      dt = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', data);
      console.log(dt);
      alert(dt.message);

      // dt_tbl = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_1hari', date:tgl});
      dt_tbl = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
      ld_tbl_laporan_daftaronline_web_by_date(dt_tbl);
    });
    





    let hari_idx_besok = moment().weekday()+1 ; //======== AKTIFKAN
    console.log(hari_idx_besok);
    if(hari_idx_besok == 7){
      hari_idx_besok = 1;
    }

    // let hari_idx_besok = 2 ;  //===== untuk TESTING
    let js_jadok_hr = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
    console.log(js_jadok_hr);

    let sp_group;
    let sp_all_1hari = [];

    //fx fx

    sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr);
    console.log(sp_all_1hari);
    sel_append_sp_all_1hari(sp_all_1hari);
    sel_append_dokter_all_1hari(js_jadok_hr);
    create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);


    // dokter_all_1sp_1hr_fx(js_jadok_hr, 'all');
    // sp_selected_all_data(js_jadok_hr, 'all');
    

    // startdate = "20.03.2014";
    // var new_date = moment(startdate, "DD-MM-YYYY").add('days', 5);
    // console.log(moment().add('days', -1).format('YYYY-MM-DD') ); // bisa

    // let hari_daftar = ''; //2021.04.26
    let hari_daftar = 'hari_besok';
    $('select[name=sel_hari_daftar]').change(function(){
      hari_daftar = $(this).val();
      console.log(hari_daftar);

      if(hari_daftar == 'hari_besok'){
        hari_idx_besok= moment().weekday()+1 ; // DAFTAR HARI BESOK
        js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        get_tgldaftar = moment().format('YYYY-MM-DD');
        get_tgl_jadok = moment().add('days', 1).format('DD-MM-YYYY');
      }else if(hari_daftar == 'hari_ini'){
        hari_idx_besok= moment().weekday(); // DAFTAR HARI INI
        js_jadok_hr   = get_jadok_all().hr[hari_idx_besok-1].dt_hr;
        get_tgldaftar = moment().add('days', -1).format('YYYY-MM-DD');
        get_tgl_jadok = moment().format('DD-MM-YYYY');
      }
      console.log(js_jadok_hr);

      sp_all_1hari = sel_push_sp_all_1hari(js_jadok_hr);
      // console.log(sp_all_1hari);
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      create_tbl_jadok_harian(js_jadok_hr, get_tgl_jadok);
    });

    $('select[name=sel_spesialis]').change(function(){
      let spesialis = $(this).val();
      console.log(spesialis);
      dokter_all_1sp_1hr_fx(js_jadok_hr, spesialis);
      $('select[name=sel_spesialis] option[value="'+spesialis+'"]').attr('selected','selected');
    });

    $('select[name=sel_dokter]').change(function(){
      let dokter = $(this).val();
      console.log(dokter);

      let spesialis = sp_selected_all_data(js_jadok_hr, dokter).Spesialis;
      console.log(spesialis);
      
      select_reset('sel_spesialis');
      let el = '<option value="'+spesialis+'" selected="selected">'+spesialis+'</option>';
      $('select[name=sel_spesialis]').append(el);
    });

    $('button.clear').click(function(){
      sel_append_sp_all_1hari(sp_all_1hari);
      sel_append_dokter_all_1hari(js_jadok_hr);
      return false;
    });

    // let oldalert = window.alert;
    // window.alert= function alert(t){
    //     // alert.count = !alert.count ? 1 : alert.count + 1;
    //     oldalert(t);
    // };

    $('input[name=norm]').focusout(function(e){
      e.preventDefault();
      get_norm = $(this).val().split("_")[0];

      if(get_norm.length != 6){
        Swal.fire('Nomor rekam medis harus 6 digit.');
      }
      // // console.log(get_norm+'_'+get_norm.length);
      return false;
    });


    //JIKA USER : RC
    let _FL_pdp = 0;
    $("input[name=norm]").keypress(function (e) { //TEKAN ENTER
      let norm = $(this).val();
      if (e.which == 13) {
        let jsPxCm = _ajax("GET", "db/m_daftarmandiri/gd_pasien_rscm_by_norm_n/"+norm, "");
        console.log(jsPxCm);

        if(jsPxCm.booking.length>0){
          $('#btn_form_daftar_online').hide();
          alert('Tidak bisa didaftarkan, Booking pasien masih aktif pada tanggal '+jsPxCm.booking[0].date+'.');
          return false;
        }

        if(jsPxCm.datajs[0].PDP == '1' && parseInt(jsPxCm.datajs[0].PDPSelisihHari) < 15){
          _FL_pdp = 1;

          let el = 
            '<div style="padding:5px; margin-bottom:2px;">'+
              '<span class="alert alert-danger" style="padding:5px 5px;" >'+
                '<i class="fa fa-exclamation-circle"></i>'+
                  'Pasien PDP tanggal '+jsPxCm.datajs[0].PDPDate+'. Berjalan '+jsPxCm.datajs[0].PDPSelisihHari+' hari'+
              '</span>'+
            '</div>';
          $('#errors').append(el);  
        }

        get_norm = norm;
        get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=noka]").val( get_noka );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=noka]").focus();

      }
    });


    $('input[name=noka]').focusout(function(e){
      e.preventDefault();
      let get_norm_cm = get_norm;
      if(get_norm_cm == ''){        
        Swal.fire('Isi terlebih dahulu No. Rekam Medis Anda.')
          .then(function(){
            $('input[name=noka]').val('');
            $('input[name=norm]').focus();
          });

      }else{
        get_noka = $(this).val().split('-').join('').split("_")[0];
        // console.log(get_noka);
        if(get_noka.length != 13){
          Swal.fire('Nomor kartu BPJS harus 13 digit.');
        }else{
          let jsPxCm = gd_pasien_rscm_GET(get_noka);
          console.log(jsPxCm);


          // ---- cek rujukan ada/tidak
          let JS_rjk_multi = gd_rujukan_multi_by_noka(get_noka); 
          console.log(JS_rjk_multi);

          if(JS_rjk_multi.metaData.code == 201){ // rujukan tidak ada
            _bpjs_syarat_rjk = 1; // kalo user=RC -> 1. kalo user=PASIEN -> 0. 
            let js_mrs = get_st_px_mrs_by_norm(get_norm_cm);
            if( js_mrs.count == 1 ){ // PX MRS
              // //membatasi tombol lewati, supaya data tidak di show
              // //alert('Billing RI terakhir kali'+js_mrs.datajs[0].NoBill);
              _bpjs_syarat_rjk = 1;
              console.log('Pasien POST MRS.');
              Swal.fire('Pasien POST MRS.');
            }else{
              console.log('Bukan Pasien POST MRS.');
              Swal.fire('Bukan Pasien POST MRS.');              
            }

            
          }else if(JS_rjk_multi.metaData.code == 200){ //SUKSES
            _bpjs_syarat_rjk = 1;
            console.log('Pasien boleh didaftarkan.');
          }else{
            _bpjs_syarat_rjk = 0;
            Swal.fire('TIDAK TERDETEKSI SISTEM BPJS.');
          }
          // ----\cek rujukan ada/tidak
          
        }
      }
      
      return false;
    });
    

    
    // let tglRujukan = moment().format('YYYY-MM-DD');
    let tglRujukan = moment().format('0000-00-00');

    $("input[name=noka]").keypress(function (e) { //TEKAN ENTER
      get_noka = $(this).val().split('-').join('').split("_")[0];
      if (e.which == 13) {
        let js_cek = _ajax_web("GET", baseUrl()+"booking/booking_cek_noka_enter/"+get_noka+"/"+hari_daftar, "");
        console.log(js_cek);
        // return false;
        
        if(js_cek.gen.tdk_ditanggung_bpjs == 1){ $('#btn_form_daftar_online').hide(); }

        // SHOW ERROR LIST
        err = js_cek.errors;
        for (let e = 0; e < err.length; e++) {
          // let el= '<div name="'+err[e].key+'"><i class="fa fa-exclamation-circle text-danger"></i> '+err[e].result.message+'</div>';
          let el = 
            '<div name="'+err[e].key+'" style="padding:5px; margin-bottom:2px;">'+
              '<span class="alert alert-'+err[e].status+'" style="padding:5px 5px;" >'+
                '<i class="fa fa-exclamation-circle"></i> '+err[e].result.message+
              '</span>'+
            '</div>';
          $('#errors').append(el);
        }


        if(js_cek.gen.tglRujukan != null){
          tglRujukan = js_cek.gen.tglRujukan;
          $('input[name=keterangan]').val(tglRujukan);
        }

        jsPxCm = js_cek.ws_rs.gd_px_rscm;
        get_norm = jsPxCm.datajs[0].NoRM;
        // get_noka = jsPxCm.datajs[0].Barcode;
        get_tglLahir = fx_get_tglLahir__min2garing(jsPxCm.datajs[0].TglLahir);
        get_nohp = jsPxCm.datajs[0].HP;

        $("input[name=norm]").val( get_norm );
        $("input[name=tglLahir]").val( get_tglLahir );
        $("input[name=nohp]").val( get_nohp );

        $("input[name=nohp]").focus();
      }
    });

    

    function fx_get_tglLahir(str_tgl_slash){
      return str_tgl_slash.split('/')[2]+'-'+str_tgl_slash.split('/')[1]+'-'+str_tgl_slash.split('/')[0];
    }

    function fx_get_tglLahir__min2garing(str_tgl){ //yyyy-mm-dd -> dd/mm/yyyy
      return str_tgl.split('-')[2]+'/'+str_tgl.split('-')[1]+'/'+str_tgl.split('-')[0];
    }


    $('input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });
   
    let chk_tracer_rc = false;
    $('input[name="chk_tracer_rc"]').on('ifChanged', function(e){
      chk_tracer_rc = e.target.checked;
      console.log(chk_tracer_rc);
    });


    
    $('#btn_form_daftar_online').click(function(){
      // let serial = $(this).serialize();
      // console.log(serial);
      
      get_tglLahir = fx_get_tglLahir($('input[name=tglLahir]').val()); // dd/mm/yyyy -> yyyy-mm-dd
      get_nohp = $('input[name=nohp]').val();
      console.log(get_norm+'_'+get_noka+'_'+get_tglLahir);

      lokasiket = $('select[name=sel_spesialis]').val();

      let button_id = $(this).attr('id');      
      button_id = (chk_tracer_rc) ? button_id+'/centang_rc' : button_id;      

      let jPost ={
          norm      : get_norm,
          noanggota : get_noka,
          penanggung: get_penanggung_cm_kode,
          penanggungket: get_penanggung_cm_nama,
          tgllahir  : get_tglLahir,
          lokasiket : lokasiket,// $('select[name=sel_spesialis]').val(),
          dokterket : $('select[name=sel_dokter]').val(),
          notlp     : get_nohp,
          tglrujukan: tglRujukan, // moment().format('YYYY-MM-DD'), //kalau dikosongi akan ERROR
          keterangan: $('input[name=keterangan]').val(),
          tgldaftar : moment( get_tgl_jadok,'DD-MM-YYYY' ).format('YYYY-MM-DD'),  // '', //set tanggal_klik aja sepertinya?
          user : _user_daftar, //_user_logged_in,
          date : get_tgldaftar,
          time : moment().format('HH:mm:ss'),
          url 		  : _ADDR,
          button_id : button_id,
        };
      console.log(jPost);


      //----- final execution

      let message = '';
      if(_bpjs_syarat_rjk == 1){
        // let curl_TX = send_form_daftar_online_CURL_TX(jPost);
        let curl_TX = _ajax("POST", "send_form_daftar_online_CURL_TX", jPost); // PERLU DICOBA!!
        console.log(curl_TX);
        // return false; // TESTING BILA INGIN TAHU BALASAN dengan var_dump
        // if(curl_TX == null){ return false;} // TESTING NYALAKAN INI 

        if(curl_TX.status == 'SUKSES'){
          message = 'Pasien bernama: '+curl_TX.nama+'.\nBerhasil didaftarkan.';
          // return false;

          // KETIKA SUKSES DAFTAR, DELETE data yang di WEB
          if(btn_pilih_dari_web){
            dt = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', del_web);
            console.log(dt);
          }


              // CETAK TRACER BOOKING
              jpost_cetak_tracer = curl_TX.tracer;
              console.log(jpost_cetak_tracer);
                            
              // let ct_tr1 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
              // console.log(ct_tr1);
              // console.log(">> CETAK TRACER 1");
              
              // let ct_tr2 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
              // console.log(ct_tr2);
              // console.log(">> CETAK TRACER 2");

              wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/tracer/2", jpost_cetak_tracer);
              console.log(wsprinter);

              
          //======
        }else{
          message = curl_TX.message;
        }
      }else{
        message = 'Tidak bisa mendaftar. Rujukan ada kendala. Silahkan ke Resepsionis untuk informasi lebih lanjut.';
      }
        
      //-----\final execution      

      Swal.fire(message).then(function(){
        window.location.reload(true);
      });

      return false;      
    });

  }

  //***************************************************/
  //       \bo/menu/receptionist/pendaftaranrj/daftarbooking
  //***************************************************/

  //***************************************************/
  //       bo/menu/receptionist/pendaftaranrj/antrian-panggilan
  //***************************************************/
  if( open_site('bo/menu/receptionist/pendaftaranrj/antrian-panggilan') ){
    console.log("ok");

    let run = null;    
    let val = null;
    let js = null;
    // let number = 489;
    let number = 9;


    
    let cnt = 0;
    let churuf = 0;
    let len_huruf = 1; // durasi @huruf
    let clen_huruf = 0;
    let start = 0;

    
    // let xd = document.getElementById("myAudio"); 
    // console.log(xd);
    // xd.play();
    
    // let x = $("audio[id=myAudio]"); 
    // console.log(x[0].outerHTML);
    // let xdd = x[0].outerHTML;

    let el = '<audio id="myAudio1" src="'+baseUrl()+'assets/Sounds/asli/satu.mp3" type="audio/mpeg"></audio>';
    $("#list_audio").append(el);
    
    let x1 = document.getElementById("myAudio1");    
    console.log(x1);
    
    // let el = '<source  id="myAudioSRC" src="'+baseUrl()+'assets/Sounds/asli/nomor-urut.mp3" type="audio/mpeg">';
    // x.querySelector("#myAudioSRC").src = baseUrl()+"assets/Sounds/asli/nomor-urut.mp3";

    var audio = document.createElement('audio');
    let rollSound = new Audio(baseUrl()+"assets/Sounds/asli/nomor-urut.mp3");
    console.log(rollSound);
    let sound_loket = null;
    sound_loket = new Audio(baseUrl()+"assets/Sounds/asli/loket 1.mp3");
    // let sound_loket = new Audio(baseUrl()+"assets/Sounds/asli/loket.mp3");
    let sound_loket_num = new Audio(baseUrl()+"assets/Sounds/asli/satu.mp3");
    // console.log(rollSound);
    // rollSound.play();
    // rollSound.load();
    let huruf = [];
    // huruf[0] = new Audio(baseUrl()+"assets/Sounds/asli/delapan.mp3");
    // huruf[1] = new Audio(baseUrl()+"assets/Sounds/asli/ratus.mp3");
    // huruf[2] = new Audio(baseUrl()+"assets/Sounds/asli/tiga.mp3");



    // js = _ajax("GET", "terbilang/"+number, "");
    // console.log(js);
    // for(let i = 0; i<js.nkata; i++){      
    //   huruf[i] = new Audio(baseUrl()+"assets/Sounds/asli/"+js.kata[i]+".mp3");
    //   // console.log(huruf[i]);
    // }

    function create_sounds(num=null){
      let jx = _ajax("GET", "terbilang/"+num, "");
      // console.log(js);
      for(let i = 0; i<jx.nkata; i++){      
        huruf[i] = new Audio(baseUrl()+"assets/Sounds/asli/"+jx.kata[i]+".mp3");
        // console.log(huruf[i]);
      }

      let val = {
        js    : jx,
        huruf : huruf,
      };
      return val;
    }
    

    // $('#play').click(e => rollSound.play()); 
    function playing_number(number=null,a){
      let s = create_sounds(number);
      s.huruf[a].play();
      s.huruf[a].onended = playing_number( number, a+1);
    }

    // let [dot, dash] = [
    //   new Audio('https://dl.dropboxusercontent.com/s/1cdwpm3gca9mlo0/kick.mp3'),
    //   new Audio('https://dl.dropboxusercontent.com/s/h2j6vm17r07jf03/snare.mp3')
    // ];

    let dot = new Audio(baseUrl()+"assets/Sounds/asli/satu.mp3");
    let dash = new Audio(baseUrl()+"assets/Sounds/asli/dua.mp3");

    // let dot = new Audio('https://dl.dropboxusercontent.com/s/1cdwpm3gca9mlo0/kick.mp3');
    // let dash = new Audio('https://dl.dropboxusercontent.com/s/h2j6vm17r07jf03/snare.mp3');


    
    function playMorseArr(morseArr, idx)
    {
        // Finish condition.
        if (idx >= morseArr.length)
            return;
    
        let next = function() {playMorseArr(morseArr, idx + 1)};
    
        if (morseArr[idx] === 1) {
            dot.onended = next;
            dot.play();
        }
        else if (morseArr[idx] === 2) {
            dash.onended = next;
            dash.play();
        }
        else {
            setTimeout(next, 250);
        }
    }
    
    function my_playMorseArr(morseArr, idx){
        // Finish condition.
        if (idx >= morseArr.length)
            return;
    
        let next = function() {playMorseArr(morseArr, idx + 1)};
    
        if (morseArr[idx] === 1) {
            dot.onended = next;
            dot.play();
        }
        else if (morseArr[idx] === 2) {
            dash.onended = next;
            dash.play();
        }
        else {
            setTimeout(next, 250);
        }
    }


    $('#play').click(function(){
      // rollSound.play();
      // rollSound.onended = function() {
      //   sound_loket.play();
      //   sound_loket.onended = function() {
      //     alert("The audio has ended");
      //   };
      // };

      // playing_number(123,0);
      // playing_number(123,1);

      number = 123;
      val = create_sounds(number);
      console.log(val);

      my_playMorseArr([1,1,1,0,2,2,0,1,1,1], 0);
    });
    

    $("#reset").click(function(){
      start = 0;
      cnt = 0;        
      $("#cnt").text(cnt);
      $("#start").text("Start");
      
      clearInterval(run);
    });


    $("#panggil").click(function(){
      number = $("#in_nomor").val();
      start = 0;
      val = create_sounds(number);
      console.log(val);

      $("#start").trigger("click");
    });

    $("#next").click(function(){
      start = 0;
      number++;
      val = create_sounds(number);
      console.log(val);

      $("#in_nomor").val(number);
      $("#start").trigger("click");
    });


    $("#start").click(function(){
      if(start==0){
        start = 1; // PLAY
        $("#start").text("Pause");

        val = create_sounds(number);
        console.log(val);

        run = setInterval( myTimer, 800 );
        console.log(run);

      }else{
        start = 0;
        $("#start").text("Start");
        
        // clearInterval(run);
      }
      console.log(start);
    });
      
    runt = setInterval( myCnt, 1000 );
    function myCnt(){
      if(start==1){
        cnt++;
        $("#cnt").text(cnt);
      }
      
    }

      let cstep = 0; // ["nomor_antrian", baca_nominal_terbilang[] ]
      
      // run = setInterval( myTimer, len_huruf*1000 );
      
      function myTimer(){
        let start_ckata = 6;
        let max_ckata = start_ckata+1+val.js.nkata;

        console.log("myTimer");
        if(start==1){
          // if(cstep == 0 ){
          if(cstep <2 ){
            rollSound.play();
          // }else if(cstep>=6 || cstep<12){
          }else if(cstep>=start_ckata || cstep< max_ckata){
            // console.log(churuf);
            if(churuf < val.js.nkata){
              // console.log({churuf:churuf});

              val.huruf[churuf].play(); // BISA
              console.log(val.js.kata[churuf]);
              
              churuf++;
            }else{
              sound_loket.play();
              console.log("stop");
              // start = 0;
              churuf = 0;
              cstep = 0;              
              clearInterval(run);
              return false;
            }
          }else{
            console.log("else");
          }
          cstep++;
            
        }else{
          churuf = 0;
          cstep = 0;
          clearInterval(run);
        }
        console.log({churuf:churuf, cstep:cstep});
        
      }
    
      
      
      
      
      function myTimer_BKP(){
        let start_ckata = 6;
        let max_ckata = start_ckata+1+val.js.nkata;

        console.log("myTimer");
        if(start==1){
          // if(cstep == 0 ){
          if(cstep <2 ){
            rollSound.play();
          // }else if(cstep>=6 || cstep<12){
          }else if(cstep>=start_ckata || cstep< max_ckata){
            // console.log(churuf);
            if(churuf < val.js.nkata){
              // console.log({churuf:churuf});

              val.huruf[churuf].play(); // BISA
              console.log(val.js.kata[churuf]);
              
              churuf++;
            }else{
              sound_loket.play();
              console.log("stop");
              // start = 0;
              churuf = 0;
              cstep = 0;              
              clearInterval(run);
              return false;
            }
          }else{
            console.log("else");
          }
          cstep++;
            
        }else{
          churuf = 0;
          cstep = 0;
          clearInterval(run);
        }
        console.log({churuf:churuf, cstep:cstep});
        
      }
    
      

      
      // SAVE AS JSON FILE
      // var dict = {"one" : [15, 4.5],
      //     "two" : [34, 3.3],
      //     "three" : [67, 5.0],
      //     "four" : [32, 4.1]};
      // var dictstring = JSON.stringify(dict);
      // var fs = require('fs');
      // fs.writeFile("thing.json", dictstring, function(err, result) {
      //     if(err) console.log('error', err);
      //     console.log("write");
      // });
     
      //\SAVE AS JSON FILE


      // let file = $("#file1");

      // file.on( "ended", function(){
      //     $("#file2")[0].play();
      // });

      // file[0].play();

      // function playAudio() { 
      //   x.play(); 
      // } 

      // function pauseAudio() { 
      //   x.pause(); 
      // } 
    }
  //***************************************************/
  //       \bo/menu/receptionist/pendaftaranrj/antrian-panggilan
  //***************************************************/


  //***************************************************/
  //       bo/menu/receptionist/pendaftaranrj/pendaftaran-rjri
  //***************************************************/
  if( open_site('bo/menu/receptionist/pendaftaranrj/pendaftaran-rjri') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    // ANTRIAN
    let date = moment().format('YYYY-MM-DD');

    let run = null;
    let val = null;
    let js = null;
    // let number = 489;
    let number = 0;

    // let init_loket_ip = ["192.168.1.68", "192.168.1.69"];
    let init_loket_ip = ["192.168.1.98", "192.168.1.104"];
    let ip_client = $("#ip_client").val();
    console.log(ip_client);
    
    // console.log($.inArray("192.168.1.69", init_loket_ip));
    
    let id_loket_selected = $.inArray(ip_client, init_loket_ip);
    console.log('id_loket_selected=== '+id_loket_selected);

    
    let cnt = 0;
    let churuf = 0;
    let len_huruf = 1; // durasi @huruf
    let clen_huruf = 0;
    let start = 0;

    let huruf = [];
    
    // // LOAD NO.ANTRI TERAKHIR KALI (YG BELUM DIPANGGIL)
    // js = _ajax("GET", "db/m_daftarmandiri/select_nomor_antridaftar_last_selesai_panggil/"+date, "");
    // console.log(js);

    // if(js == null){
    //   let max_number = _ajax("GET", "db/m_daftarmandiri/select_nomor_antridaftar_max/"+date, "");
    //   if(max_number==null){
    //     number = 1;
    //   }else{
    //     number = parseInt(max_number.nomor);
    //   }      
    // }else{
    //   number = parseInt(js.nomor);
    // }
    
    // $("#lbl_nomor").text(number);
    
    

    

    var audio = document.createElement('audio');
    let rollSound = new Audio(baseUrl()+"assets/Sounds/asli/nomor-urut.mp3");
    console.log(rollSound);
    let sound_loket = null;

    if(id_loket_selected>=0){ // jika ada di array
      sound_loket = new Audio(baseUrl()+"assets/Sounds/asli/loket "+(id_loket_selected+1)+".mp3");
    }else{
      sound_loket = new Audio(baseUrl()+"assets/Sounds/asli/loket 1.mp3");
    }
    // let sound_loket = new Audio(baseUrl()+"assets/Sounds/asli/loket.mp3");
    let sound_loket_num = new Audio(baseUrl()+"assets/Sounds/asli/satu.mp3");
    
    

    function penyebut(nilai=null) {
      nilai = Math.floor(nilai);
      let huruf = [ "", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", 
        "delapan", "sembilan", "sepuluh", "sebelas"];
      let temp = "";

      if (nilai < 12) {
        temp = " "+ huruf[nilai];
      } else if (nilai <20) {
        temp = penyebut(nilai - 10) + " belas";
      } else if (nilai < 100) {
        temp = penyebut(nilai/10) + " puluh"+ penyebut(nilai % 10);
      } else if (nilai < 200) {
        temp = " seratus" + penyebut(nilai - 100);
      } else if (nilai < 1000) {
        temp = penyebut(nilai/100) + " ratus" . penyebut(nilai % 100);
      } else if (nilai < 2000) {
        temp = " seribu" . penyebut(nilai - 1000);
      } else if (nilai < 1000000) {
        temp = penyebut(nilai/1000) + " ribu" + penyebut(nilai % 1000);
      } else if (nilai < 1000000000) {
        temp = penyebut(nilai/1000000) + " juta" + penyebut(nilai % 1000000);
      } else if (nilai < 1000000000000) {
        temp = penyebut(nilai/1000000000) + " milyar" + penyebut(fmod(nilai,1000000000));
      } else if (nilai < 1000000000000000) {
        temp = penyebut(nilai/1000000000000) + " trilyun" + penyebut(fmod(nilai,1000000000000));
      }     
      return temp;
    }


    function terbilang(nilai) {
      if(nilai<0) {
        // hasil = "minus "+ trim(penyebut(nilai));
        hasil = "minus "+ penyebut(nilai);
      } else {
        hasil = penyebut(nilai);
      }     		
      return hasil;
    }
    // console.log( terbilang(23) );


    function terbilang_arr(num=null){
      let nominal = parseInt(num);
      let vterbilang = terbilang(nominal);
      let kata = vterbilang.split(' ');
      kata.splice(0,1);
      // console.log(kata);

      let jx = {
          nominal: nominal,
          terbilang: vterbilang,
          kata: kata,
          nkata: kata.length,
        };
      return jx;
    }

    // console.log( [terbilang_arr(23), terbilang_arr(11)    ] );


    function create_sounds(num=null){
      // let jx = _ajax("GET", "terbilang/"+num, "");
      // console.log(jx);

      let jx = terbilang_arr(num);
      for(let i = 0; i<jx.nkata; i++){      
        huruf[i] = new Audio(baseUrl()+"assets/Sounds/asli/"+jx.kata[i]+".mp3");
        // console.log(huruf[i]);
      }

      let val = {
        js    : jx,
        huruf : huruf,
      };
      return val;
    }


    $("#panggil").click(function(){
      // number = $("#in_nomor").val(); //////
      let batas_max = _ajax("GET", "select_nomor_antri_daftar/"+date, "").count;
      console.log(batas_max);

      number = $("#lbl_nomor").text();
      if(number>batas_max){
        alert("Antrian melebihi batas.");
        return 0;
      }
      
      start = 0;
      
      val = create_sounds(number);
      console.log(val);

      // $("#start").trigger("click");
      start_sound();
    });




    let js_max = null, 
        batas_max = 0,
        nomor_update = '';
        
    $("#next").click(function(e){
      e.preventDefault(); // tambahan
      console.log('KLIK NEXT>>>');
      $("#next").hide(); // menghindari double click
      
      js_max = _ajax("GET", "db/m_daftarmandiri/select_nomor_antridaftar_max/"+date, "");
      if(js_max == null){ // antrian baru
        alert('Belum ada antrian.');
        $("#next").show();
        return 0;
      }else{
        batas_max = parseInt(js_max.nomor);
        console.log(batas_max);

        js = _ajax("GET", "db/m_daftarmandiri/select_nomor_antridaftar_last_selesai_panggil/"+date, "");
        if(js==null){
          alert('Antrian Selesai.');
          $("#next").show();
          return 0;
        }
      }
     

      nomor_update = parseInt(js.nomor);
      console.log(nomor_update);

      
      if(nomor_update>batas_max){
        alert("Antrian melebihi batas.");
        return 0;
      }


      //update
      let jPost = {
        table:"antridaftar", 
        arr_data: {
          selesai:moment().format('HH:mm:ss'),
          user : _user_logged_in,
        }, 
        where:{
          date : date,
          // nomor: number-1,
          nomor: nomor_update,
        }
      };

      let upd = _ajax("POST", "update_new", jPost);
      if(upd==null){
        console.log("UPDATE SUKSES");
        
        start = 0;
        // mencari panggilan terakhir, karena tidak selalu urut. 
        // makanya tidak memakai number++;
        js = _ajax("GET", "db/m_daftarmandiri/select_nomor_antridaftar_last_selesai_panggil/"+date, "");
        console.log(js);

        if(js==null){
          number = nomor_update;
          alert('Antrian Selesai.');
          $("#next").show();
          // return 0;
        }else{
          number = parseInt(js.nomor);          
        }        
        console.log(number);


        val = create_sounds(number);
        console.log(val);


        // $("#in_nomor").val(number);////
        $("#lbl_nomor").text(number);
        // $("#start").trigger("click");
        start_sound();

        $("#next").show();
        return 0;

      }else{
        // console.log("UPDATE GAGAL");
        alert("UPDATE GAGAL");
      }


      
    });

    
    // $("#start").click(function(){
    function start_sound(){
      if(start==0){
        start = 1; // PLAY
        $("#start").text("Pause");

        val = create_sounds(number);
        console.log(val);

        run = setInterval( myTimer, 800 );
        console.log(run);

      }else{
        start = 0;
        $("#start").text("Start");
        
        // clearInterval(run);
      }
      console.log(start);
    }
    // });
    

      let cstep = 0; // ["nomor_antrian", baca_nominal_terbilang[] ]
      
      // PLAY SOUND : menjalankan suara
      function myTimer(){
        let start_ckata = 6;
        let max_ckata = start_ckata+1+val.js.nkata;

        console.log("myTimer");
        if(start==1){
          // if(cstep == 0 ){
          if(cstep <2 ){
            rollSound.play();
          // }else if(cstep>=6 || cstep<12){
          }else if(cstep>=start_ckata || cstep< max_ckata){
            // console.log(churuf);
            if(churuf < val.js.nkata){
              // console.log({churuf:churuf});

              val.huruf[churuf].play(); // BISA
              console.log(val.js.kata[churuf]);
              
              churuf++;
            }else{
              sound_loket.play();
              console.log("stop");
              // start = 0;
              churuf = 0;
              cstep = 0;              
              clearInterval(run);
              return false;
            }
          }else{
            console.log("else");
          }
          cstep++;
            
        }else{
          churuf = 0;
          cstep = 0;
          clearInterval(run);
        }
        console.log({churuf:churuf, cstep:cstep});
        return 0;
        
      }
    

    //\ANTRIAN

    $('.select2').select2();

    let norm = "", noka = "";
    let rujukan_jsObj = "", 
        rjk_opt_jsObj = "",
        rjk_sel_jsObj = "";

    let jsObj_booking = null,
        book_plh      = null;
  
    let get_poliKode_bpjs = '', //kdpoli_bpjs
        spesialis_pilih   = '',
        get_kode_lokasi   = '',
        namaDokter_pilih  = '',
        get_kode_dokter   = '';
        
    let _bpjs_syarat_rjk = 0; // 0 = TIDAK BOLEH, 1 = BOLEH
    let get_penanggung_cm_kode ='CO031',
        get_penanggung_cm_nama ='B P J S',
        get_penanggung_cm_st   ='M',
        bpjs = 1,
        NoAnggota = "BPJS";

    let penanggung_plh = {
      status : get_penanggung_cm_st,
      kode : get_penanggung_cm_kode,
      nama : get_penanggung_cm_nama,
      bpjs : bpjs,
      _bpjs_syarat_rjk : _bpjs_syarat_rjk,
      NoAnggota : NoAnggota,
    };

    let caramasuk = "1", //Datang Sendiri
        rujukan_cm = "",
        dx_rs      = "10"; // KONTROL

    let klinik_plh = null;
    let dokter_plh = null;

    let pelayanan_rs = "RJ"; // RJ, IGD, RI

    // VAR BPJS
    let get_tglKunjungan= "",
        get_tglRujukan  = "",
        tglSep          = "";

    // VAR KLIK DAFTAR
    let get_norujukan = 0,
        get_ppkRujukan = "",
        get_ppkRujukan_nama = "";
    let get_instansi_kode_bpjs = "",
        get_instansi_nama_bpjs = "",
        get_instansi_kode_cm = "";

    let get_nosep_temp = 0;
    let StatusDaftar_cm = 'RJ'; //default. OPSI: RJ, UG, RI



    let booking = false, //var TOOGLE untuk memilih BOOKING(true) / DAFTAR LANGSUNG(false)
      _FL_ambil_px_book= 0, book_id_date='', book_id_time='', //var untuk UPDATE di fotrbooking
      _FL_daftar_ugd = 0; // FLAG INI ndak usah tidak apa2, karena sudah tercover StatusDaftar_cm


    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      let el = '<option value="'+sel_penanggung_cm.dtjs[i].Kode+'" data-noanggota="'+sel_penanggung_cm.dtjs[i].NoAnggota+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>';
      $('select[name=sel_penanggung_cm]').append(el);
    }
    

    // MAU DIHAPUS. REPAIR: 2020.09.18
    // let sel_agama = [];
    // sel_agama = _ajax("GET", "select_agama","");
    // // console.log(sel_agama);
    // for (let ii = 0; ii < sel_agama.length; ii++) {
    //   $('select[name=sel_agama]').append('<option value="'+sel_agama[ii].Kode+'">'+sel_agama[ii].Keterangan+'</option>');
    // }

    // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');
    $(".asal_instansi").hide(); // SHOW HANYA SAAT PENANGGUNG BPJS TK
    $(".selain_bpjs").hide(); // CZ DECLARE ADALAH BPJS, MAKA AWALNYA DI HIDE. SHOW SAAT SELAIN_BPJS

    $('select[name=sel_penanggung_cm]').on('change', function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      _bpjs_syarat_rjk = 1;

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      NoAnggota = $('select[name=sel_penanggung_cm] option:selected').data("noanggota");
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('table[name=tbl_data_bpjs]').show();
        $('div[name=form_add_else_bpjs]').hide();
        $('input[name=noka], input[name=Barcode]').removeAttr('disabled');
        _bpjs_syarat_rjk = 0;
        bpjs = 1;
        //input val reset
        
        $(".selain_bpjs").hide();
        caramasuk = '1'; //Datang Sendiri
        dx_rs      = "10"; // KONTROL

      }else{
        $('table[name=tbl_data_bpjs]').hide();
        $('div[name=form_add_else_bpjs]').show();
        $('input[name=noka], input[name=Barcode]').attr('disabled','disabled').val('');
        _bpjs_syarat_rjk = 1;
        bpjs = 0;

        $(".selain_bpjs").show();
      }

      if(get_penanggung_cm_kode == 'CO011'){
        $(".asal_instansi").show();
      }else{
        $(".asal_instansi").hide();
      }
      
      penanggung_plh = {
        status : get_penanggung_cm_st,
        kode : get_penanggung_cm_kode,
        nama : get_penanggung_cm_nama,
        bpjs : bpjs,
        _bpjs_syarat_rjk : _bpjs_syarat_rjk,
        NoAnggota : NoAnggota,
      };
      console.log(penanggung_plh);
      // console.log('[get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]');
      // console.log([get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]);

    });

    let get_asalPPK = 1; // set default untuk option. Pemilihan asal POSTMRS [1:FKTP, 2:FKTL]
    $('select[name=faskes]').on('change', function(){      
      // console.log(get_asalPPK); // AWAL, sebelum di change
      $('select[name=faskes] option[value='+get_asalPPK+']').removeAttr("selected");
      get_asalPPK = $(this).val();
      console.log(get_asalPPK);
      
      $('select[name=faskes] option[value='+get_asalPPK+']').attr('selected','selected');
    });
    
    
    $('#pelayanan').on('change', function(){
      pelayanan_rs = $(this).val();
      console.log(pelayanan_rs);
    });

    
    let arr_px_rs = [
      "NoRM" ,"Barcode", "NoIdentitas", "Nama", "Alamat", "Rt", "Rw", "TempatLahir",
      "TglLahir", "Telp", "HP", "agama_ket", "kelurahan_ket", "kecamatan_ket",
      "kota_ket", "propinsi_ket", "negara_ket", "pekerjaan_ket", "pendidikan_ket",
      "Sex", "GolDarah", "marital_ket", 
    ];

    // let px_rs = "";
    // function view_form_rs_by_norm(arr_px_rs, norm){
    function view_form_rs(arr_px_rs, px_rs){
      // px_rs = _ajax("GET", "get_pxrs_by_norm/"+norm,'');
      // console.log(px_rs);
      for (let i = 0; i < arr_px_rs.length; i++) {
        $("input[name='"+arr_px_rs[i]+"']").val(px_rs[arr_px_rs[i]]);          
      }
      $("textarea[name='Keterangan']").val(px_rs.Keterangan);
      $("input[name='umur']").val(hitungUmur(px_rs['TglLahir']));
      $('select[name=pasienRscm_sukubangsa] option[value="'+px_rs['Sukubangsa']+'"]').attr('selected','selected');
      $('select[name=sel_agama] option[value="'+px_rs['Agama']+'"]').attr('selected','selected');
      // $("img[name=foto]").attr("src", "file:\/"+px_rs[0].Foto);
      // $("img[name=foto]").attr("src", "file:\/\/U:\/Appllication\/XlinkMaster\/Images\/792307.JPG");
      $("img[name=foto]").attr("src", "file:/E:/792307.JPG");
      //file:///U:/Appllication/XlinkMaster/Images/792307.JPG

    }

    
    let arr_px_bpjs = [
      "noka_bpjs" ,"nik_bpjs", "nama_bpjs", "tgllahir_bpjs", "kelas_bpjs", 
      "get_tglRujukan", "asal_rujukan", "asalPPK_bpjs",
      "jns_peserta", "skdp", "dpjp_bpjs",  
      "norm_bpjs", "dxkey_bpjs", "telp_bpjs", "catatan_bpjs", "status_laka",
    ];
    //"tglsep", "norujukan" (karena kalau post mrs di set=2, makanya sebaiknya dihilangkan),

    function view_form_bpjs(arr_px_bpjs, px_bpjs_post){
      for (let i = 0; i < arr_px_bpjs.length; i++) {
        $("input[name='"+arr_px_bpjs[i]+"']").val(px_bpjs_post[arr_px_bpjs[i]]);          
      }
    }
    
    let len_rjk = null;

    function show_mdl_multi_rjk(rujukan_jsObj, faskes=null){
      rjk_opt_jsObj   = rujukan_jsObj.response.rujukan;
      $('table[name=tbl_list_rjk_multi] tbody').children().remove();

      // if(len_rjk == undefined){
      if(faskes == 2){
          let el = 
            '<tr data-id="1">'+
              '<td>1</td>'+
              '<td><button class="btn btn-primary" name="btn_mdl_plh_rjk">Pilih</button></td>'+
              '<td>'+rjk_opt_jsObj.noKunjungan+'</td>'+
              '<td>'+rjk_opt_jsObj.tglKunjungan+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj.peserta.noKartu+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj.peserta.nama+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj.poliRujukan.nama+'</td>'+
            '</tr>';
          $('table[name=tbl_list_rjk_multi] tbody').append(el);
        
      }else if(faskes == 1){ // ADA ARRAY nya
        len_rjk = rujukan_jsObj.response.rujukan.length;
        console.log(len_rjk);

        for(let i=0; i<len_rjk; i++){
          let el = 
            '<tr data-id="'+i+'">'+
              '<td>'+(i+1)+'</td>'+
              '<td><button class="btn btn-primary" name="btn_mdl_plh_rjk">Pilih</button></td>'+
              '<td>'+rjk_opt_jsObj[i].noKunjungan+'</td>'+
              '<td>'+rjk_opt_jsObj[i].tglKunjungan+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj[i].peserta.noKartu+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj[i].peserta.nama+'</td>'+
              '<td name="norm">'+rjk_opt_jsObj[i].poliRujukan.nama+'</td>'+
            '</tr>';
          $('table[name=tbl_list_rjk_multi] tbody').append(el);
        }
      }      

      $('table[name=tbl_list_rjk_multi]').DataTable();
      $('#modal_list_rjk_multi').modal('show');
    }


    $(document).on('click', 'button[name=btn_mdl_plh_rjk]', function(){
      //let id_rjk_selected  = $(this).parent().parent().find('td[name=lokasi]').data('kd_lokasi');
      let id_rjk_selected  = $(this).parent().parent().data('id');
      console.log('id_rjk_selected= '+id_rjk_selected);
      // rjk_sel_jsObj = rjk_opt_jsObj[id_rjk_selected];

      if(len_rjk == undefined){
        rjk_sel_jsObj = rjk_opt_jsObj;
      }else{
        rjk_sel_jsObj = rjk_opt_jsObj[id_rjk_selected];
      }
      
      console.log("rjk_sel_jsObj");
      console.log(rjk_sel_jsObj);

      get_ppkRujukan_nama = rjk_sel_jsObj.provPerujuk.nama;
      get_ppkRujukan = rjk_sel_jsObj.provPerujuk.kode;
      get_tglRujukan = rjk_sel_jsObj.tglKunjungan;

      console.log([get_ppkRujukan_nama, get_ppkRujukan]);

      $("input[name=asalPPK_bpjs]").val(get_ppkRujukan_nama);
      $("input[name=norujukan]").val(rjk_sel_jsObj.noKunjungan);
      $("input[name=get_tglRujukan]").val(get_tglRujukan);
      $("input[name=ket_daftar]").val(get_tglRujukan); // TAMBAHAN LOGIKA
      $("input[name=noskdp]").val('');
      $("input[name=dpjp_bpjs]").val('');
      $("input[name=dxkey_bpjs]").val(rjk_sel_jsObj.diagnosa.kode);

      $('#modal_list_rjk_multi').modal('hide');
      // validate();

    });

    

    //========================== MODAL AMBIL BOOKING ===========================
    
      $('#btn_ambil_pasien_booking').click(function(){

        let tgl = moment( moment().subtract(1, 'day') ).format('YYYY-MM-DD'); //YESTERDAY !!!!!!!
        //let tgl = moment().format('YYYY-MM-DD'); //TODAY, IKI TES, sebenere yesterday
        
        jsObj_booking = _ajax("GET", "db/m_daftarmandiri/gd_booking/"+tgl, "" );
        // console.log('[data all skdp]::');
        // console.log(js);
        $('span[name=span_ambil_tgl_book]').text(tgl);
        $('table[name=tbl_booking_daftar] tbody').children().remove();
  
        for(let i=0; i<jsObj_booking.dtjs.length; i++){
          let el = 
            '<tr data-urut="'+i+'" data-id="'+jsObj_booking.dtjs[i].time+'" data-date="'+tgl+'">'+
              '<td>'+(i+1)+'</td>'+
              '<td><button class="btn btn-primary" name="btn_mdl_plh_px_book">Pilih</button></td>'+
              '<td>'+jsObj_booking.dtjs[i].time+'</td>'+
              '<td>'+jsObj_booking.dtjs[i].norequest+'</td>'+
              '<td>'+jsObj_booking.dtjs[i].nama+'</td>'+
              '<td name="norm">'+jsObj_booking.dtjs[i].norm+'</td>'+
              '<td name="penanggungket" data-kd_penanggung="'+jsObj_booking.dtjs[i].penanggung+'">'+jsObj_booking.dtjs[i].penanggungket+'</td>'+
              '<td name="noka">'+jsObj_booking.dtjs[i].noanggota+'</td>'+
              '<td name="lokasi" data-kd_lokasi="'+jsObj_booking.dtjs[i].kd_lokasi+'" >'+jsObj_booking.dtjs[i].lokasiket+'</td>'+
              '<td name="nama_dokter" data-kd_dokter="'+jsObj_booking.dtjs[i].kd_dokter+'" data-kd_dpjp_bpjs="'+jsObj_booking.dtjs[i].kd_dpjp_bpjs+'">'+jsObj_booking.dtjs[i].dokterket+'</td>'+
            '</tr>';
          $('table[name=tbl_booking_daftar] tbody').append(el);
        }
  
        $('table[name=tbl_booking_daftar]').DataTable();
        $('#modal_ambil_px_booking').modal('show');
      });
  
      $(document).on('click','table[name=tbl_booking_daftar] tbody tr td button[name=btn_mdl_plh_px_book]', function(){
        get_noka    = $(this).parent().parent().find('td[name=noka]').text();
        get_norm    = $(this).parent().parent().find('td[name=norm]').text();
        
        namaDokter_pilih = $(this).parent().parent().find('td[name=nama_dokter]').text();
        spesialis_pilih  = $(this).parent().parent().find('td[name=lokasi]').text();
        get_kode_lokasi  = $(this).parent().parent().find('td[name=lokasi]').data('kd_lokasi');
        get_kode_dokter  = $(this).parent().parent().find('td[name=nama_dokter]').data('kd_dokter');
        get_kode_dokter_bpjs  = $(this).parent().parent().find('td[name=nama_dokter]').data('kd_dpjp_bpjs');
  
        //----- variabel untuk UPDATE flag di fotrbooking jadi 1
        _FL_ambil_px_book = 1;
        book_id_date = $(this).parent().parent().data('date');
        book_id_time = $(this).parent().parent().data('id');
        //-----
        let book_plh_urut = $(this).parent().parent().data('urut');
        book_plh = jsObj_booking.dtjs[book_plh_urut];
        console.log(book_plh);
        
        console.log({
          get_noka          : get_noka,
          _FL_ambil_px_book : _FL_ambil_px_book,
          book_id_date      : book_id_date,
          book_id_time      : book_id_time,
          book_plh          : book_plh,
        });

        
        dokter_plh = {
          nama      : namaDokter_pilih,
          kode_dok  : get_kode_dokter,
          kode_dok_bpjs : get_kode_dokter_bpjs,
          spesialis     : spesialis_pilih,
          kode_lokasi   : get_kode_lokasi,
          durasi_lokasi : "", // get_durasi_lokasi, //???
          jam_masuk     : "", // get_jamMasuk_dokter, //???
        };
        console.log(dokter_plh);

        // http://192.168.1.68/rscm/app_dev/ajaxreq/get_klinik_by_ket?ket=FISIO%20TERAPI
        let req_klinik = _ajax("GET", "get_klinik_by_ket", {ket: spesialis_pilih})[0];
        console.log(req_klinik);
        get_poliKode_bpjs = req_klinik.kdpoli_bpjs;

        klinik_plh = {
          kode      : get_kode_lokasi,
          ket       : spesialis_pilih,
          kode_bpjs : get_poliKode_bpjs,
        };
        console.log(klinik_plh);

        $('input[name=Barcode]').val(get_noka).focus();
        $('input[name=NoRM]').val(get_norm);
        $('input[name=cari_jadok]').val(namaDokter_pilih);
        $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
        $('input[name=klinikTujuan]').val(spesialis_pilih);
        $('input[name=kode_lokasi]').val(get_kode_lokasi);
        $('#ket_booking').val(book_plh.keterangan);
  
  
        $('#modal_ambil_px_booking').modal('hide');
  
        $('input[name=scan_noka]').val(get_noka);
  
  
        //delete DOM div_cbox_booking
        $('div[name=div_cbox_booking]').hide();
      });

        
      //==========================\MODAL AMBIL BOOKING ===========================


    let get_norm = "";
    let px_rs_plh = null;
    let px_rs_li = null;
    
    let cek_px_masuk = null;
    let px_bpjs = null;
    let err = null;
    let bridging_error = 0;

    $("input[name=NoRM]").keypress(function (e) { //TEKAN ENTER
      // norm = "099275";
      get_norm = $(this).val();
      if (e.which == 13) {
        if(get_norm == ''){
          alert("Kolom ini harus terisi!");
          return 0;
        }
        
        
        cek_px_masuk = _ajax("GET", "cek_px_masuk/0/"+get_norm, "");
        console.log(cek_px_masuk);
        
        // let px_rs = cek_px_masuk.ws_rs.get_pxrs;
        px_rs_li = cek_px_masuk.ws_rs.get_pxrs;
        console.log(px_rs_li);

        if(px_rs_li.length<1){
          alert("Data tidak ditemukan.");
          return 0;
        }else if(px_rs_li.length==1){
          console.log("SHOW DATA TO FORM");
          // view_form_rs(arr_px_rs, get_norm);
          px_rs_plh = px_rs_li[0];
          console.log(px_rs_plh);
          view_form_rs(arr_px_rs, px_rs_plh);
        }else if(px_rs_li.length>1){
          // SHOW MODAL LIST HASIL PENCARIAN, untuk di pilih yang sesuai
          let jsObj = px_rs_li;
          $('table[name=tbl_modal_li_px] tbody').children().remove();
          // $('table[name=tbl_modal_li_px]').DataTable().clear();
          for(let i=0; i<jsObj.length; i++){
            let el = 
              '<tr data-id="'+i+'" data-norm="'+jsObj[i].norm+'">'+
                '<td>'+(i+1)+'</td>'+
                '<td><button class="btn btn-primary" name="btn_tbl_modal_li_px_pilih">'+jsObj[i].NoRM+'</button></td>'+
                '<td>'+jsObj[i].Nama+'</td>'+
                '<td>'+jsObj[i].Alamat+'</td>'+
              '</tr>';
            $('table[name=tbl_modal_li_px] tbody').append(el);
          }
    
          $('table[name=tbl_modal_li_px]').DataTable();
          $('#modal_li_px').modal('show');
        }


        // SHOW ALERT
        err = cek_px_masuk.generate.errors;
        for (let e = 0; e < err.length; e++) {
          // let el= '<div name="'+err[e].key+'"><i class="fa fa-exclamation-circle text-danger"></i> '+err[e].result.message+'</div>';
          let el = 
            '<div name="'+err[e].key+'" style="padding:5px; margin-bottom:2px;">'+
              '<span class="alert alert-'+err[e].status+'" style="padding:5px 5px;" >'+
                '<i class="fa fa-exclamation-circle"></i> '+err[e].result.message+
              '</span>'+
            '</div>';
          $('#errors').append(el);
          
        }

        // if(cek_px_masuk["generate"]["btn_lewati"] == 1){
        //   let el = '<button name="btn_lewati_cetak_kartu" class="btn btn-success" style="padding:0px 5px;">Lewati</button>';
        //   $('#errors').append(el);
        // }

      }
    });



    
    $(document).on('click','table[name=tbl_modal_li_px] tbody tr td button[name=btn_tbl_modal_li_px_pilih]', function(){
      get_norm    = $(this).text();
      id    = $(this).parent().parent().data("id");
      px_rs_plh = px_rs_li[id];
      console.log([get_norm, id, px_rs_plh]);

      view_form_rs(arr_px_rs, px_rs_plh);

      $('#modal_li_px').modal('hide');
      $("input[name=NoRM]").val(get_norm).focus();

    });

    
    $("input[name=Barcode]").keypress(function (e) { //TEKAN ENTER
      // e.preventDefault(); // kalau diaktifkan, tidak bisa ngetik inputan
      // noka = "0001716591442";
      noka = $(this).val();
      let faskes = $('select[name=faskes]').val();
      let today = moment().format('YYYY-MM-DD'); // '2019-07-05';
      if (e.which == 13) {
        $('#errors').children().remove(); // CLEAR SETELAH DI APPEND SAAT ENTER KE2
        
        cek_px_masuk = _ajax("GET", "cek_px_masuk/1/"+noka+"/"+faskes, "");
        console.log(">>cek_px_masuk");
        console.log(cek_px_masuk);

        bridging_error = cek_px_masuk.generate.bridging_error;
        console.log(bridging_error);

        err = cek_px_masuk.generate.errors;

        px_bpjs = cek_px_masuk.bridging.peserta_bpjs;
        console.log(px_bpjs);

        // CEK CURL ERROR
        if(bridging_error){
          alert(cek_px_masuk.generate.bridging_error_message);
          // return false;
        }


        // CEK KEBERADAAN PASIEN di RS
        if(cek_px_masuk.ws_rs.get_pxrs.length == 0){
          alert("Data Pasien tidak ditemukan.");
          return 0;
        }else if(cek_px_masuk.ws_rs.get_pxrs.length >1){
          alert("No. JKN kembar dengan pasien lain.");
          return 0;
        }else{
          px_rs_plh = cek_px_masuk.ws_rs.get_pxrs[0];
          get_norm  = px_rs_plh.NoRM;
          view_form_rs(arr_px_rs, px_rs_plh);
          
          for (let e = 0; e < err.length; e++) {
            // let el= '<div name="'+err[e].key+'"><i class="fa fa-exclamation-circle text-danger"></i> '+err[e].result.message+'</div>';
            let el = 
              '<div name="'+err[e].key+'" style="padding:5px; margin-bottom:2px;">'+
                '<span class="alert alert-'+err[e].status+'" style="padding:5px 5px;" >'+
                  '<i class="fa fa-exclamation-circle"></i> '+err[e].result.message+
                '</span>'+
              '</div>';
            $('#errors').append(el);
            
          }

          if(cek_px_masuk["generate"]["btn_lewati"] == 1){
            let el = '<button name="btn_lewati_cetak_kartu" class="btn btn-success" style="padding:0px 5px;">Lewati</button>';
            $('#errors').append(el);
          }

          // SET form select[name=faskes]=2 untuk pasien POST MRS
          if(cek_px_masuk["generate"]["asalppk_postmrs"] == 2){
            $('input[name=norujukan]').val(cek_px_masuk["generate"]["norujukan_postmrs"]);

            get_asalPPK = 2;
            $('select[name=faskes] option[value='+get_asalPPK+']').attr('selected','selected');
            
          }
          


          let rjk_multi = cek_px_masuk["bridging"]["multi_rjk"];
          console.log(rjk_multi);

          if(rjk_multi != null){
            if(rjk_multi.metaData.code == 200){
              console.log("FX: show_mdl_multi_rjk");
              show_mdl_multi_rjk(rjk_multi, faskes);

              // if(get_asalPPK = 2){
              //   get_ppkRujukan_nama = cek_px_masuk.bridging.peserta_bpjs.response.provPerujuk.nama;
              //   get_ppkRujukan      = cek_px_masuk.bridging.peserta_bpjs.response.provPerujuk.kode; //???
              // }else{
                get_ppkRujukan_nama = cek_px_masuk.bridging.peserta_bpjs.response.peserta.provUmum.nmProvider;
                get_ppkRujukan = cek_px_masuk.bridging.peserta_bpjs.response.peserta.provUmum.kdProvider; //???
              // }
              console.log([get_ppkRujukan, get_ppkRujukan_nama]);

              // FORM DATA BPJS
              // >> IKI DIGANTI, DIHILANGKAN. DIGANTI FUNCTION LOAD
              $("input[name=noka_bpjs]").val(px_bpjs.response.peserta.noKartu);
              $("input[name=nik_bpjs]").val(px_bpjs.response.peserta.nik);
              $("input[name=nama_bpjs]").val(px_bpjs.response.peserta.nama);
              $("input[name=tgllahir_bpjs]").val(px_bpjs.response.peserta.tglLahir);
              $("input[name=kelas_bpjs]").val(px_bpjs.response.peserta.noKartu);
              // $("input[name=asal_rujukan]").val(''); //  HAPUS???
              // $("input[name=asalPPK_bpjs]").val(px_bpjs.response.peserta.provUmum.nmProvider);
              $("input[name=asalPPK_bpjs]").val(get_ppkRujukan_nama);
              $("input[name=jns_peserta]").val(px_bpjs.response.peserta.jenisPeserta.keterangan);
              $("input[name=norujukan]").val('');
              // $("input[name=skdp]").val('');
              $("input[name=dpjp_bpjs]").val('');
              // $("input[name=tglsep]").val('');
              $("input[name=norm_bpjs]").val(px_bpjs.response.peserta.mr.noMR);
              $("input[name=dxkey_bpjs]").val('');
              $("input[name=telp_bpjs]").val(px_bpjs.response.peserta.mr.noTelepon);
              $("input[name=catatan_bpjs]").val('');
              $("input[name=status_laka]").val('');
            }else if(rjk_multi.metaData.code == 201){ // RUJUKAN TIDAK ADA
              console.log("RUJUKAN TIDAK ADA.");
              //untuk data di trdaftar>>asalPPK = "_" , kosong
              get_ppkRujukan_nama = cek_px_masuk.bridging.peserta_bpjs.response.peserta.provUmum.nmProvider;
              get_ppkRujukan = cek_px_masuk.bridging.peserta_bpjs.response.peserta.provUmum.kdProvider; //???
              console.log([get_ppkRujukan, get_ppkRujukan_nama]);

            }
          }

          
        }

      }
    });


    //------------------- div#daftar_error --------------------------
    $(document).on('click','button[name=btn_lewati_cetak_kartu]', function(){
      console.log('btn_lewati_cetak_kartu');

      // bpjs = 0;
      // if(bpjs){
      
      if(get_penanggung_cm_kode == "CO031"){
        // let asalPPK_bpjs = null; // GANTI INI: get_ppkRujukan_nama
        if(cek_px_masuk.generate.postmrs){ // IF POSTMRS
          get_ppkRujukan_nama = cek_px_masuk.generate.postmrs_from_label; // "RS Citra Medika";
          get_ppkRujukan = "0195R028"; // "RS Citra Medika";
          get_tglRujukan = cek_px_masuk.bridging.monitoring_histori.response.histori[0].tglSep;
          $('input[name=get_tglRujukan]').val(get_tglRujukan);
        }else{
          if(get_asalPPK==1){
            get_ppkRujukan_nama = px_bpjs.response.peserta.provUmum.nmProvider;
            get_ppkRujukan      = px_bpjs.response.peserta.provUmum.kdProvider;
          }else if(get_asalPPK==2){
            get_ppkRujukan_nama = rjk_sel_jsObj.provPerujuk.nama;
            get_ppkRujukan      = rjk_sel_jsObj.provPerujuk.kode;
          }
          // get_asalPPK==2 sudah di SET >> response.provPerujuk.nmProvider
          console.log([get_ppkRujukan, get_ppkRujukan_nama]);
          get_tglRujukan = $('input[name=get_tglRujukan]').val();          
        }

        console.log(px_bpjs);

        let arr_px_bpjs_POST = {
          "noka_bpjs" : px_bpjs.response.peserta.noKartu,
          "nik_bpjs"  : px_bpjs.response.peserta.nik, 
          "nama_bpjs" : px_bpjs.response.peserta.nama, 
          "tgllahir_bpjs" : px_bpjs.response.peserta.tglLahir, 
          "kelas_bpjs"    : px_bpjs.response.peserta.noKartu, 
          "asal_rujukan" : "", 
          "asalPPK_bpjs" : get_ppkRujukan_nama, // IF POSTMRS: RS CITRA MEDIKA
          "jns_peserta" : px_bpjs.response.peserta.jenisPeserta.keterangan, 
          "get_tglRujukan" : get_tglRujukan, 
          "norujukan" : "", 
          "skdp" : "", 
          "dpjp_bpjs" : "", 
          "tglsep" : "", 
          "norm_bpjs" : px_bpjs.response.peserta.mr.noMR,
          "dxkey_bpjs" : "", 
          "telp_bpjs" : px_bpjs.response.peserta.mr.noTelepon, 
          "catatan_bpjs" : "", 
          "status_laka" : "",
        };
        console.log(arr_px_bpjs_POST);

        view_form_bpjs(arr_px_bpjs, arr_px_bpjs_POST);
      }
      

    });


    //SYARAT : HARUS TAMPIL DATA DI TABEL INFO PASIEN_RSCM
    $('select[name=pasienRscm_sukubangsa]').on('change',function(){
      let norm = $("input[name=NoRM]").val();
      // console.log(norm.length);
      if(norm != ''){
        let Sukubangsa = $(this).val();
        console.log([norm, Sukubangsa]);
        update_suku_bangsa(norm, Sukubangsa);
      }
    });
    
    $('select[name=sel_agama]').on('change',function(){
      let norm = $("input[name=NoRM]").val();
      // console.log(norm.length);
      if(norm != ''){
        let agama = $(this).val();
        let upd = _ajax("POST", "update_new", {table:"fomstpasien", arr_data:{Agama:agama}, where:{NoRM:norm}});
        
        if(upd==null){
          console.log("UPDATE AGAMA SUKSES");
        }
      }
    });

    
    $('input[name=klinikTujuan]').click(function(){
      $('#modal_klinik').modal('show');

      let js = get_klinik();
      $('#el_modal .container_poli').children().remove();
      for(let i=0; i<js.dtjs.length; i++){
        let el = 
          '<div class="obyek" data-id="'+js.dtjs[i].Kode+'" data-kdpoli_bpjs="'+js.dtjs[i].kdpoli_bpjs+'">'+
            '<img src="'+baseUrl()+'assets/img/icon-spesialis/tes/'+js.dtjs[i].Keterangan+'.png" alt="'+js.dtjs[i].Keterangan+'" />'+
            '<div class="obyek_title"><span>'+js.dtjs[i].Keterangan+'</span></div>'+
          '</div>';

        $('#el_modal .container_poli').append(el);

        //>[UNTUK MENGATUR FONT-SIZE LABEL POLI YANG PANJANG]
        if(js.dtjs[i].Keterangan.length > 30){
          //console.log(js.dtjs[i].Keterangan.length);
          $('.container_poli').find('.obyek[data-id='+js.dtjs[i].Kode+'] .obyek_title span').css("font-size", "95%");
        }
      }
    });

    let klinik_cm = false;
    
    $('input[name=cari_jadok]').click(function(){
      let booking = false;
      let js;
      let inputKlinik = $('input[name=klinikTujuan]').val();
      let fl_klinik, spesialis;
      if(inputKlinik == ''){
        fl_klinik = 0;
        spesialis = '';
      }else{
        fl_klinik = 1;
        spesialis = inputKlinik;
      }
      //console.log(fl_klinik+'&'+spesialis);
      if(booking == true){
        //////////////////let tgl = moment( moment().subtract(1, 'day') ).format('YYYY-MM-DD'); //yesterday !!!!!!!
        ///////CARI TOMORROW
        js = get_jadok_by_idhari(fl_klinik,spesialis,2); //2:SELASA
      }else{ //BILA DAFTAR LANGSUNG / TIDAK BOOKING
        if(klinik_cm){
          // js = _ajax("GET", "get_dokter_cm_internal", "");
          js = _ajax_web("GET", baseUrl()+"main/db/m_daftarmandiri/get_dokter_cm_internal", "");
          console.log("cari dokter internal rs.");
        }else{
          js = get_jadok_today(fl_klinik,spesialis);
        }
        
      }

      console.log(js); // = get_jadok_today()
      
      //////////////let js = get_jadok_today(fl_klinik,spesialis);
          
      $('table[name=tbl_cari_jadok] tbody').children().remove();
      for(let i=0; i<js.dtjs.length; i++){
        let el = 
          '<tr>'+
            '<td>'+js.dtjs[i].hari+'</td>'+
            '<td name="nama" data-kode_dokter="'+js.dtjs[i].kodeDokter+'" data-kd_dpjp_bpjs="'+js.dtjs[i].kd_dpjp_bpjs+'" data-durasi="'+js.dtjs[i].durasi+'">'+js.dtjs[i].Nama+'</td>'+
            '<td name="spesialis" data-lokasi="'+js.dtjs[i].Lokasi+'" data-kdpoli_bpjs="'+js.dtjs[i].kdpoli_bpjs+'">'+js.dtjs[i].Spesialis+'</td>'+
            '<td name="jamPraktek" data-jam_masuk="'+js.dtjs[i].jamMasuk+'">'+js.dtjs[i].jamMasuk+' - '+js.dtjs[i].jamPulang+'</td>'+
            '<td><button class="btn btn-success">Pilih</button></td>'+
          '</tr>';

        $('table[name=tbl_cari_jadok] tbody').append(el);
      }

      $('#modal_cari_jadok').modal('show');
    });

    //+++++++++++++++++++++++++++++++
    //+++++++++   MODAL   +++++++++++

    //KLIK [btn] di modal_cari_jadok 
    $(document).on('click','table[name=tbl_cari_jadok] tbody tr td button', function(){
      namaDokter_pilih = $(this).parent().parent().find('td[name=nama]').text();
      spesialis_pilih  = $(this).parent().parent().find('td[name=spesialis]').text();
      get_kode_lokasi  = $(this).parent().parent().find('td[name=spesialis]').data('lokasi');
      get_kode_dokter  = $(this).parent().parent().find('td[name=nama]').data('kode_dokter');
      get_kode_dokter_bpjs = $(this).parent().parent().find('td[name=nama]').data('kd_dpjp_bpjs');
      get_durasi_lokasi    = $(this).parent().parent().find('td[name=nama]').data('durasi');
      get_jamMasuk_dokter  = $(this).parent().parent().find('td[name=jamPraktek]').data('jam_masuk');
      // kdpoli_bpjs = $(this).parent().parent().find('td[name=spesialis]').data('kdpoli_bpjs');
      get_poliKode_bpjs = $(this).parent().parent().find('td[name=spesialis]').data('kdpoli_bpjs');
      $('#modal_cari_jadok').modal('hide');


      dokter_plh = {
        nama : namaDokter_pilih,
        kode_dok : get_kode_dokter,
        kode_dok_bpjs : get_kode_dokter_bpjs,
        spesialis : spesialis_pilih,
        kode_lokasi : get_kode_lokasi,
        durasi_lokasi : get_durasi_lokasi,
        jam_masuk : get_jamMasuk_dokter,
      };
      console.log(dokter_plh);

      klinik_plh = {
        kode      : get_kode_lokasi,
        ket       : spesialis_pilih,
        kode_bpjs : get_poliKode_bpjs, // kdpoli_bpjs,
      };
      console.log(klinik_plh);
      
      $('input[name=cari_jadok]').val(namaDokter_pilih);
      $('input[name=klinikTujuan]').val(spesialis_pilih);
      $('input[name=kode_lokasi]').val(get_kode_lokasi);
      $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
    });

    
      /*====================== [CLICK DIV KLINIK TUJUAN] ====================*/
      $(document).on('click','.obyek', function(){
        let klinik_kode = $(this).data('id');
        let klinik_ket = $(this).text();

        console.log({klinik_kode:klinik_kode, klinik_ket:klinik_ket});

        // if(klinik_ket == 'U G D'){
        if(klinik_ket == 'I G D'){
          _FL_daftar_ugd = 1;
          pelayanan_rs = "IGD";
          StatusDaftar_cm = "UG";

          get_poliKode_bpjs = 'IGD';
          spesialis_pilih   = klinik_ket;
          get_kode_lokasi   = klinik_kode;

          namaDokter_pilih  = 'dr. Lucky Dana Victory';
          get_kode_dokter   = '92516';
          // namaDokter_pilih  = 'dr. Titia Rahmania,M.H.Kes';
          // get_kode_dokter   = '92612';

          $('input[name=klinikTujuan]').val(klinik_ket);
          $('input[name=cari_jadok]').val(namaDokter_pilih);
          
          dokter_plh = {
            nama          : namaDokter_pilih,
            kode_dok      : get_kode_dokter,
            kode_dok_bpjs : "", // get_kode_dokter_bpjs, //??
            spesialis     : spesialis_pilih,
            kode_lokasi   : get_kode_lokasi,
            durasi_lokasi : "",
            jam_masuk     : "",
          };

          console.log(dokter_plh);

        }else{ // jika klinik_ket != IGD
          _FL_daftar_ugd = 0;
          pelayanan_rs = "RJ";
          StatusDaftar_cm = "RJ";
          /* 
            <CEK ADA/TIDAKNYA JADWAL SPESIALIS PADA HARI ITU> 
            Bila TIDAK ADA dokter yang hadir hari itu, muncul modal "Jadwal Spesialis" yg dipilih tersebut buka pada hari apa saja.
          */
          
          let js = get_jadok_today(1,klinik_ket); //fl_klinik : '1', //1= kliniknya diisi/sudah dipilih
          console.log(js); //MENAMPILKAN HASIL JSON DARI JADWAL DOKTER SPESIALIS
          
          klinik_cm = (klinik_kode>=1 && klinik_kode<=6);

          if(js.count > 0 || klinik_cm ){
            // if(klinik_cm){ // IF: UMUM, BKIA, GIGI

            // }else{ // IF KLINIK : PENY.DALAM, JANTUNG, PARU, DSB
              
            // }

            $('input[name=klinikTujuan]').val(klinik_ket);
            get_poliKode_bpjs = $(this).data('kdpoli_bpjs');

          }else{ //jika pada hari ini jadwal klinik yang SUDAH DIPILIH tersedia
            
            //console.log('Mohon maaf, Hari ini tidak ada jadwal spesialis tersebut.');
            $('input[name=klinikTujuan]').val('');
            
            let js_namaSp = get_jadok_by_namaspesialis(klinik_ket);
            //console.log(js_namaSp);
            $('table[name=tbl_klinik_alert] tbody').children().remove();
            for(let i=0; i<js_namaSp.dtjs.length; i++){
              let el = 
                '<tr>'+
                  '<td>'+js_namaSp.dtjs[i].hari+'</td>'+
                  '<td name="nama">'+js_namaSp.dtjs[i].Nama+'</td>'+
                  '<td name="spesialis">'+js_namaSp.dtjs[i].Spesialis+'</td>'+
                  '<td>'+js_namaSp.dtjs[i].jamMasuk+' - '+js_namaSp.dtjs[i].jamPulang+'</td>'+
                '</tr>';

              $('table[name=tbl_klinik_alert] tbody').append(el);
            }

            $('span[name=message]').html(
              'Mohon maaf, hari ini tidak ada jadwal '+klinik_ket+'. <br>'+
              'Jadwal klinik tujuan '+klinik_ket+' : '
            );


            $('#modal_klinik_alert').modal('show');
            get_poliKode_bpjs = '';
          }

          $('input[name=cari_jadok]').val('');
        }
        
        $('#modal_klinik').modal('hide');
        // console.log(klinik_kode+'_'+klinik_ket);
        // console.log(get_poliKode_bpjs);

        klinik_plh = {
          kode      :klinik_kode,
          ket       :klinik_ket,
          kode_bpjs :get_poliKode_bpjs,
        };
        console.log(klinik_plh);
      });


      $('.btn_clear').click(function(){
        $('input[name=cari_jadok]').val('');
        $('input[name=klinikTujuan]').val('');
        $('input[name=kd_dpjp_bpjs]').val('');
        get_poliKode_bpjs = '';   
        _FL_daftar_ugd = 0;
      });

      //+++++++++  \MODAL   +++++++++++
      //+++++++++++++++++++++++++++++++



      //+++++++++  MODAL:cari_skdp   +++++++++++
      $('#cari_skdp').click(function(){
        // let js = gd_skdp(get_norm_cm);
        // let js = gd_skdp("112201");
        let js = gd_skdp(get_norm);
        console.log('[data all skdp]::');
        console.log(js);
        $('table[name=tbl_cari_skdp] tbody').children().remove();
        for(let i=0; i<js.dtjs.length; i++){
          let el = 
            '<tr>'+
              '<td name="TanggalMasuk">'+js.dtjs[i].TanggalMasuk+'</td>'+
              '<td name="noskdp">'+js.dtjs[i].noskdp+'</td>'+
              '<td name="Keterangan">'+js.dtjs[i].Keterangan+'</td>'+
              '<td name="NamaDokter" data-KodeDokter="'+js.dtjs[i].KodeDokter+'" data-kd_dpjp_bpjs="'+js.dtjs[i].kd_dpjp_bpjs+'">'+js.dtjs[i].NamaDokter+'</td>'+
              '<td><button class="btn btn-success">Pilih</button></td>'+
            '</tr>';

          $('table[name=tbl_cari_skdp] tbody').append(el);
        }

        $('#modal_cari_skdp').modal('show');
      });

      //pilih_skdp
      $(document).on('click','table[name=tbl_cari_skdp] tbody tr td button', function(){
        noskdp = $(this).parent().parent().find('td[name=noskdp]').text();
        get_kode_dokter_bpjs = $(this).parent().parent().find('td[name=NamaDokter]').data('kd_dpjp_bpjs');
        noskdp_bpjs = noskdp.substring(0, 6);
        $('#modal_cari_skdp').modal('hide');

        $('input[name=skdp]').val(noskdp_bpjs);
        $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
      });
      //+++++++++ \MODAL:cari_skdp   +++++++++++



    

    $("input[name=dxkey_bpjs]").keypress(function (e) { //TEKAN ENTER
      let diagkey_bpjs = $(this).val();
      if (e.which == 13) {
        $('select[name=dx_bpjs]').children().remove();

        let jsObj_diag = ref_diagnosa(diagkey_bpjs).response.diagnosa;
        console.log(jsObj_diag);

        for(let i=0; i<jsObj_diag.length; i++){
          $('select[name=dx_bpjs]').append('<option value="'+jsObj_diag[i].kode+'">'+jsObj_diag[i].nama+'</option>');
        }

      }
    });

    $("input[name=dxkey_rs]").keypress(function (e) {
      let diagkey_rs = $(this).val();
      if (e.which == 13) {
        $('select[name=dx_rs]').children().remove();

        let sel_dx_rs = _ajax("GET", "search_dx_cm/"+diagkey_rs,"");
        console.log(sel_dx_rs);

        for(let i=0; i<sel_dx_rs.length; i++){
          $('select[name=dx_rs]').append('<option value="'+sel_dx_rs[i].Kode+'">'+sel_dx_rs[i].Keterangan+'</option>');
        }

        $('select[name=dx_rs]').focus();
                
      }
    });

    
    
    $('#btn_update_telp').click(function(e){
      e.preventDefault();
      
      let norm = $('input[name=NoRM]').val();
      let telp = $('input[name=Telp]').val();
      console.log([norm, telp]);

      if(norm == ''){
        alert("No. Rekam Medis harus terisi...");
      }else{
        let update = _db_update({NoRM : norm}, 'fomstpasien', {Telp: telp});
        if(update == null){
          alert('Proses Update Telp Berhasil.');
        }else{
          alert('Proses Update Gagal. Silahkan ulangi.');
        }
      }
        
    });
    


    
  
    $('input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });
    

    let katarak = 0;

    $('input[name="chk_katarak"]').on('ifChanged', function(e){
      let attr_check = e.target.checked;
      
      if(attr_check == true)  $(this).attr('value',1);
      else  $(this).attr('value',0);

      katarak = $(this).val();
      console.log([ katarak, attr_check ]);
    });
    
    
    
    let chk_tracer_rc = false;
    $('input[name="chk_tracer_rc"]').on('ifChanged', function(e){
      chk_tracer_rc = e.target.checked;
      console.log(chk_tracer_rc);
    });



    $('#lbl_data_bpjs').dblclick(function(e){
      e.preventDefault();
      console.log("tampil btn_create_sep");
      $('#btn_create_sep').toggle();
    });


    $('#btn_create_sep').click(function(e){
      e.preventDefault();
      // //++++++++++++++++++++ create_sep ++++++++++++++++++++++++
      
          // get_tglKunjungan = $('input[name=tglsep]').val();
          tglSep = $('input[name=tglsep]').val();
          get_tglRujukan = $('input[name=get_tglRujukan]').val();

          let get_noka = $('input[name=Barcode]').val(),
              get_jnsPelayanan = 2,
              get_klsRawat = $('input[name=kelas_bpjs]').val(),
              // get_norm_cm = $('input[name=norm_bpjs]').val(),
              get_norm_cm = $('input[name=NoRM]').val(),
              get_asalRujukan_bpjs = $('select[name=faskes]').val(),
              get_norujukan = $('input[name=norujukan]').val(),
              noskdp_bpjs = $('input[name=skdp]').val();
            
          //======   ws1.1   ============
          sep_req =                                                     
          {
            "request": {
              "t_sep": {
                  "noKartu": get_noka,
                  "tglSep": moment().format('YYYY-MM-DD'),
                  "ppkPelayanan": config_bpjs.kode_rs,
                  "jnsPelayanan": get_jnsPelayanan,
                  "klsRawat": get_klsRawat,
                  "noMR": get_norm_cm,
                  "rujukan": {
                    "asalRujukan": get_asalRujukan_bpjs, //FASKES: 1 , 2
                    "tglRujukan": get_tglRujukan,
                    "noRujukan": get_norujukan,
                    "ppkRujukan":  get_ppkRujukan
                  },
                  "catatan": $('input[name=catatan_bpjs]').val(),
                  "diagAwal": $('select[name=dx_bpjs]').val(),
                  "poli": {
                    "tujuan": klinik_plh.kode_bpjs, //get_poliKode_bpjs,
                    "eksekutif": "0"
                  },
                  "cob": {
                    "cob": "0"
                  },
                  "katarak": {
                    "katarak": katarak, // "0"
                  },
                  "jaminan": {
                    "lakaLantas": "0",
                    "penjamin": {
                      "penjamin": "0",
                      "tglKejadian": "0000-00-00",
                      "keterangan": "",
                      "suplesi": {
                        "suplesi": "0",
                        "noSepSuplesi": "",
                        "lokasiLaka": {
                          "kdPropinsi": "",
                          "kdKabupaten": "",
                          "kdKecamatan": ""
                        }
                      }
                    }
                  },
                  "skdp": {
                    "noSurat": noskdp_bpjs,
                    "kodeDPJP": $('input[name=kd_dpjp_bpjs]').val()
                  },
                  "noTelp": $('input[name=telp_bpjs]').val(),
                  // "user": "16141"
                  "user": config_bpjs.consid
              }
            }
          };
          //======   \ws1.1   ============

        console.log('[Data will send:: sep_create]::');
        console.log(sep_req);
    });

    
    

        
  
    let tc = {
      klik_daftar : "",
      bill        : "",
      noantrian   : "",
      sep         : "",
      insert_daftar_rj: "",
    };

    // let jpost_sep_create = null,
    //     res_c_sep = null;
    let sep_req = null,
        sep_res = null;
      
    let dataPost = null;
    
    // let rujukan = 0;
    

    // KLIK DAFTARRJ
    $('#btn_daftar').click(function(){
      console.log('__start_click_daftarrj__');
      tc.klik_daftar = moment().format('HH:mm:ss');
      // BAWA {cek_px_masuk} di KLIK DAFTAR, dari proses ENTER norm atau noka.
      let norm = $('input[name=NoRM]').val();
      if(norm == '') return false;

      console.log(cek_px_masuk);

      
      // CEK BILL DARI INPUTAN NORM SAAT AWAL ENTER NORM di KOLOM NORM
      if(cek_px_masuk.generate.status_billing == "open"){
        alert("Billing AKTIF. Tidak boleh mendaftar.");
        return 0;
      }

      // CEK BILLING AKTIF by JS
      let js_bill_aktif = _ajax("GET", "get_st_bill_open_rm_by_norm_n/"+norm ,"");
      console.log(js_bill_aktif); 
      if(js_bill_aktif.st_bill_rm == "open"){
        alert("Billing AKTIF. Tidak boleh mendaftar.");
        return 0;
      }

      
      if($('input[name=cari_jadok]').val()=='' || $('input[name=klinikTujuan]').val()=='' || $('select[name=pasienRscm_sukubangsa]').val()=='' || $('select[name=sel_agama]').val()==''){
        alert('Kolom dokter spesialis / klinik tujuan / suku bangsa / agama, belum diisi.');
        return 0;
      }

      console.log(px_rs_plh);
      

      //NOTE**********
      // karena default 1, maka untuk kasus pendaftaran BPJS versi OFFLINE, akan ada kendala di "px_bpjs.response.peserta.provUmum.kdProvider", karena bridging.
      console.log(penanggung_plh.bpjs);

      let bpjs_online = 1;
      if(penanggung_plh.bpjs){
          //++++++++++++++++++++ create_sep ++++++++++++++++++++++++
          
          get_norujukan = $('input[name=norujukan]').val();

          // sudah dilogika di KLIK LEWATI
          // get_ppkRujukan = px_bpjs.response.peserta.provUmum.kdProvider;
          // get_ppkRujukan_nama  = px_bpjs.response.peserta.provUmum.nmProvider;
          // let sudah dideklarasi awal, karena yg SELAIN BPJS, get_norujukan=0

          get_instansi_kode_bpjs = px_bpjs.response.peserta.jenisPeserta.kode;
          get_instansi_nama_bpjs = px_bpjs.response.peserta.jenisPeserta.keterangan;
          get_instansi_kode_cm   = gd_instansi_cm(get_instansi_kode_bpjs, get_instansi_nama_bpjs).datajs[0].kode;
          // PIKIRKAN KALAU asalinstansi di fotrdaftar dari P3K, UMUM, LAIN-LAIN, dsb

          
          // get_tglKunjungan = $('input[name=tglsep]').val();
          get_tglRujukan = $('input[name=get_tglRujukan]').val();
          tglSep = $('input[name=tglsep]').val();

          let get_noka = $('input[name=Barcode]').val(),
              get_jnsPelayanan = 2,
              get_klsRawat = $('input[name=kelas_bpjs]').val(),
              // get_norm_cm = $('input[name=norm_bpjs]').val(),
              get_norm_cm = $('input[name=NoRM]').val(),
              get_asalRujukan_bpjs = $('select[name=faskes]').val(),
              noskdp_bpjs = $('input[name=skdp]').val();

          // rujukan = get_norujukan;
          rujukan_cm = get_ppkRujukan+'_'+get_ppkRujukan_nama;

          //======   ws1.1   ============
          sep_req =                                                     
          {
            "request": {
              "t_sep": {
                  "noKartu" : get_noka,
                  "tglSep"  : tglSep, //moment().format('YYYY-MM-DD'),
                  "ppkPelayanan": config_bpjs.kode_rs,
                  "jnsPelayanan": get_jnsPelayanan,
                  "klsRawat"    : get_klsRawat,
                  "noMR"        : get_norm_cm,
                  "rujukan": {
                    "asalRujukan" : get_asalRujukan_bpjs, // FASKES : 1,2
                    "tglRujukan"  : get_tglRujukan,
                    "noRujukan"   : get_norujukan,
                    "ppkRujukan"  :  get_ppkRujukan
                  },
                  "catatan" : $('input[name=catatan_bpjs]').val(),
                  "diagAwal": $('select[name=dx_bpjs]').val(),
                  "poli": {
                    "tujuan": klinik_plh.kode_bpjs, //get_poliKode_bpjs,
                    "eksekutif": "0"
                  },
                  "cob": {
                    "cob": "0"
                  },
                  "katarak": {
                    "katarak": katarak,
                  },
                  "jaminan": {
                    "lakaLantas": "0",
                    "penjamin": {
                      "penjamin": "0",
                      "tglKejadian": "0000-00-00",
                      "keterangan": "",
                      "suplesi": {
                        "suplesi": "0",
                        "noSepSuplesi": "",
                        "lokasiLaka": {
                          "kdPropinsi": "",
                          "kdKabupaten": "",
                          "kdKecamatan": ""
                        }
                      }
                    }
                  },
                  "skdp": {
                    "noSurat": noskdp_bpjs,
                    "kodeDPJP": $('input[name=kd_dpjp_bpjs]').val()
                  },
                  "noTelp": $('input[name=telp_bpjs]').val(),
                  // "user": "16141"
                  "user": config_bpjs.consid
              }
            }
          };
          //======   \ws1.1   ============

          console.log('[Data will send:: sep_create]::');
          console.log(sep_req);

          // SEND GUNAKAN AJAX
          // RESPONSE NYA SIMPAN DI: get_nosep_temp
          // BILA BERHASIL CREATE : ...., JIKA TIDAK: ....
          // progress_daftar(10,'Mengirim data untuk CREATE SEP ke BPJS.');


          // //[== CREATE SEP ==]
          sep_res = sep_create_by_noka(sep_req); //response_create_sep [LIHAT KATALOG BPJS]
          console.log("<RESPONSE CREATE SEP> sep_res");
          console.log(sep_res);

          
          if(sep_res.metaData.code == 200 ){ //bila create_sep SUKSES
            tc.sep = moment().format('HH:mm:ss');
            
            get_nosep_temp = sep_res.response.sep.noSep;
          }else{ //bila create_sep TIDAK SUKSES
            alert('Tidak sukses daftarkan SEP. Pesan dari BPJS = '+sep_res.metaData.message);
            return false;
          }
          // //[==\CREATE SEP ==]

          
      }else{ // SELAIN PENANGGUNG BPJS
        get_instansi_kode_cm = $('select[name=asal_instansi]').val();
        rujukan_cm = $('select[name=rjk_dbcm]').val(); // INI VALUE DARI DROPDOWN_RUJUKAN_DARI_CM
        caramasuk = $('select[name=caramasuk]').val();
        dx_rs     = $('select[name=dx_rs]').val(); // ISI dg KODE_DX_RS yg terselect dari SELECT OPTION
      }      


      let get_umur_fv = get_umur_fx_new(px_rs_plh.TglLahir);
      console.log(get_umur_fv);
      
      dataPost = {
        tc : tc,
        rs : {
          pelayanan_rs : pelayanan_rs, // RJ, IGD, RI
          StatusDaftar_cm : StatusDaftar_cm, // RJ, UG, RI
          penanggung : penanggung_plh,
          faskes  : $('select[name=faskes]').val(),
          NoRM    : $('input[name=NoRM]').val(),
          Barcode : $('input[name=Barcode]').val(),
          ket_daftar : $('input[name=ket_daftar]').val(),

          rujukan : get_norujukan, //rujukan, // KALAU SELAIN BPJS, get_norujukan = 0 (ikut deklarasi var)
          get_tglRujukan : get_tglRujukan,
          asalPPK : rujukan_cm, // get_ppkRujukan+'_'+get_ppkRujukan_nama,
					asalinstansi : get_instansi_kode_cm,
					NoAnggota : NoAnggota,
          nosep     : get_nosep_temp,

          caramasuk : caramasuk,
          dx_rs      : dx_rs,
          
          klinik : klinik_plh,
          dokter : dokter_plh,
          UmurTahun : get_umur_fv.tahun, // get_umur_fx(px_rs_plh.TglLahir,'tahun'),
          UmurBulan : get_umur_fv.bulan, // get_umur_fx(px_rs_plh.TglLahir,'bulan'),
          UmurHari  : get_umur_fv.hari, // get_umur_fx(px_rs_plh.TglLahir,'hari'),
          KategoriUsia : kategori_usia(get_umur_fv.tahun),// kategori_usia( get_umur_fx(px_rs_plh.TglLahir,'tahun') ),

          mp : px_rs_plh,
        },
        flag : {
          _FL_daftar_ugd    : _FL_daftar_ugd,
          _FL_ambil_px_book : _FL_ambil_px_book,
          date : book_id_date,
          time : book_id_time,
        },
        bpjs : {
          sep : {
            request : sep_req,
            response: sep_res,
          }
        }
      };
      console.log(dataPost);

      console.log(klinik_plh);



      
      console.log(">>CREATE BILL");
      // CREATE BILL
      let exe = _ajax("POST", "daftar_pasien_klik/"+klinik_plh.kode, {dataPost:dataPost});
      console.log(exe);

      
      console.log(">>BILLING<< cek billing kosong");
      if(exe == null){
        console.log("!!! Nomor Billing kosong(tidak terbuat). Segera hapus SEP. Ulangi proses pendaftaran.");
        $('input[name=get_nosep_temp]').val(get_nosep_temp);

        alert("Nomor Billing kosong(tidak terbuat). Segera hapus SEP("+get_nosep_temp+"). Ulangi proses pendaftaran.");
        return 0;
      }
      console.log(">>BILLING JADI<< cek billing kosong");
      
      let bill_response = exe.response.xrec.data.data_utama.billing;
      console.log(bill_response);
      console.log(exe.response.xrec.time);
      console.log(exe.response.xrec.data.data_utama);

      console.log(">>RESPONSE INSERT");
      let status_execute = exe.response.insert_gen.status;
      console.log(status_execute);

      console.log(">>INSERT PENDAFTARAN TO DB => SELESAI");

      let jpost_insert_reg_cm = exe.response.xrec.data.data_paket.jpost_insert_reg_cm;// null;


      
      // CEK BILL yg BARENG di klik itu DOBEL/tidak
      // >> BILLING KOSONG, SEP JADI <<???

      if(status_execute == "success"){
        if(bill_response == '' || bill_response == null){
          alert("Nomor Billing kosong. Segera hapus SEP("+get_nosep_temp+"). Ulangi proses pendaftaran.");
        }else{
          // ENTRY TINDAKAN BILLING. KHUSUS PX BPJS
          let _FL_insert_tindakan = true;

          // SP_129 = dr. Prima
          if( dokter_plh.kode_dok == 'SP_129'){ // dokter yg tanpa auto entry tindakan
            _FL_insert_tindakan = false;
          }

          if(_FL_insert_tindakan){
              if(penanggung_plh.bpjs){
                console.log("ENTRY TINDAKAN BILLING");
                // IGD/RJ >> StatusDaftar:RJ/UG
                // let insert_tindakan = _ajax("POST", "insert_pos_tindakan/RJ/22/BL191009.0001/kd_dokter", "");
                let insert_tindakan = null;
                if(jpost_insert_reg_cm.data.StatusDaftar == "RJ"){
                  insert_tindakan = _ajax("POST", "insert_pos_tindakan/RJ/"+jpost_insert_reg_cm.data1.Lokasi+"/"+bill_response+"/"+jpost_insert_reg_cm.data1.Dokter, "");
                }else if(jpost_insert_reg_cm.data.StatusDaftar == "UG"){
                  insert_tindakan = _ajax("POST", "insert_pos_tindakan/IGD/10/"+bill_response+"/", ""); //???lokasi
                }
                
                console.log(insert_tindakan);
              }
          }
          alert("Pasien berhasil didaftarkan.");
        }

        $('input[name=get_bill_siap_pakai]').val(bill_response);
        $('input[name=get_nosep_temp]').val(get_nosep_temp);

        $('#btn_daftar').hide();

      }else{
        alert("Pendaftaran GAGAL!");
      }

      
      // return 0; //====================================================

      // START PRINT di PENDAFTARAN RJ
      
        //+++++++++++++++++++ print no_antrian di RC ++++++++++++++++++++++++++++++
        /*
          BILA FX cetak ini tidak dipakai di yg lain, hapus saja
          cetak_nomor_antrian(jpost_cetak_noantrian);           
        */
        
        let jpost_cetak_noantrian = null;

        if(_FL_daftar_ugd == 0){ // jika bukan DAFTAR UGD
          jpost_cetak_noantrian = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            billing    : exe.response.xrec.data.data_utama.billing,
            no_antrian : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.generate.antri["3d"],// noantrian_ready_3digit,
            tglrujukan : get_tglRujukan, // get_tglKunjungan,
            nama   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.data.Nama, // $('span[name=pasienRscm_nama]').text(),
            dpjp   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.nama,//$('input[name=cari_jadok]').val(),
            nosep  : get_nosep_temp
          };
          console.log({jpost_cetak_noantrian: jpost_cetak_noantrian});
          

          //BILA TIDAK AMBIL PASIEN DARI BOOKING, CETAK noantrian dan skdp
          if(_FL_ambil_px_book == 0){
            // // let js_antrian = _ajax("POST", "termal_nomor_antrian_new/1", jpost_cetak_noantrian);
            // let js_antrian = _ajax_web("POST", baseUrl()+"print_termal/termal_nomor_antrian_new", jpost_cetak_noantrian);
            // console.log(js_antrian);

            wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/termal_nomor_antrian_new", jpost_cetak_noantrian);
            console.log(wsprinter);
          }
        }

        
        //++++++++++++++++ \print no_antrian di RC ++++++++++++++++++++++++++++++++


       

        //++++++++++++++++++++++ print SKDP +++++++++++++++++++++++++++++++++++++
        
        // VARIABLE OBJECT UNTUK CETAK SKDP
        if(!penanggung_plh.bpjs){
          // sep_res.response.sep.tglSep = ""; // error response of null
          // sep_res["response"]["sep"]["tglSep"] = ""; // error response of null
          sep_res = {
            response :{
              sep : { tglSep : "" }
            }
          };

          get_ppkRujukan_nama = "";
        }

        let jpost_cetak_skdp = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            billing : exe.response.xrec.data.data_utama.billing, //get_bill_siap_pakai,
            noskdp  : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.generate.noskdp.rscm,
            norm    : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.data.NoRM,
            nama    : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Nama,
            tglLahir: exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.TglLahir, //js.response.peserta.tglLahir,              
            //provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
            provPerujuk : get_ppkRujukan_nama,
            tglSep  : sep_res.response.sep.tglSep, //js.response.tglSep,
            dpjp    : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.nama, //namaDokter_pilih
        };
        console.log({jpost_cetak_skdp: jpost_cetak_skdp});

        //BILA AMBIL PASIEN DARI BOOKING, TIDAK CETAK noantrian dan skdp
        if(_FL_ambil_px_book == 0){
          let js_skdp = _ajax_web("POST", baseUrl()+"print_termal/skdp", jpost_cetak_skdp);
          console.log(js_skdp);
        }

        //++++++++++++++++++++++ \print SKDP +++++++++++++++++++++++++++++++++++++



        //++++++++++++++++++++++ print tracer +++++++++++++++++++++++++++++++++++++
        // dataPost = [REPLACE] = exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost
        let prb = '';
        prb = (penanggung_plh.bpjs)? sep_res.response.sep.informasi.prolanisPRB : '';
        console.log(prb);
        

        let prb_lbl_rscm = '';
        if(penanggung_plh.bpjs){
          if(px_rs_plh.PRB == '1'){
            prb_lbl_rscm = "PRB";
          }
        }
        console.log(["prb_lbl_rscm", prb_lbl_rscm]);


        
        let pdp = (px_rs_plh.PDP =="1" && parseInt(px_rs_plh.PDPSelisihHari)<15 ) ? "Z038": "";
        
        let jpost_cetak_tracer = null;
        // if(_FL_daftar_ugd == 0){ // SELAIN IGD
          jpost_cetak_tracer = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            segment   : jpost_insert_reg_cm.data.StatusDaftar,
            NoBill    : exe.response.xrec.data.data_utama.billing, // get_bill_siap_pakai,
            lokasikode: jpost_insert_reg_cm.data1.Lokasi, // tambahan, apakah error?
            no_antrian: exe.response.xrec.data.data_paket.jpost_insert_reg_cm.generate.antri["3d"],// noantrian_ready_3digit,
            klinik    : dataPost.rs.dokter.spesialis, //$('input[name=klinikTujuan]').val(),
            dokter    : dataPost.rs.dokter.nama, //$('input[name=cari_jadok]').val(),
            
            // NoRM      : dataPost.rs.mp.NoRM, //get_norm_cm,
            // Nama      : dataPost.rs.mp.Nama, //$('span[name=pasienRscm_nama]').text(),
            // TglLahir  : dataPost.rs.mp.TglLahir, //pasien_cm_Obj.datajs[0].TglLahir,
            // Sex       : dataPost.rs.mp.Sex, //$('span[name=pasienRscm_jk]').text(),
            // Alamat    : dataPost.rs.mp.Alamat, //$('span[name=pasienRscm_alamat]').text(),
            // user      : _user_logged_in,
            // ket       : dataPost.rs.ket_daftar, // get_ket_fo, //???
            // umur      : get_umur_fx(dataPost.rs.mp.TglLahir, 'tahun'),
            // st_px_baru_lama : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.data.StatusBL,//st_px_baru_lama //???
            // penanggung_cm: NoAnggota, // SET PROGRAM BARU
            // prb       : prb_lbl_rscm,
            // pdp       : pdp,
            // // prb       : exe.response.xrec.data['bridging']['res_c_sep']['response']['sep']['informasi']['prolanisPRB'],
          };
          console.log(jpost_cetak_tracer);

          // JIKA _FL_ambil_px_book = 1 => TIDAK CETAK TRACER 
          if(_FL_ambil_px_book == 0){ 
            if(chk_tracer_rc){
              jpost_cetak_tracer.button_id = $(this).attr("id")+'/centang_rc';              
            }
            
            // let ct_tr1 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
            // console.log(">> CETAK TRACER 1", ct_tr1);
            
            // let ct_tr2 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
            // console.log(">> CETAK TRACER 2", ct_tr2);

            wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/tracer/2", jpost_cetak_tracer);
            console.log(wsprinter);
          }
          

          


          // cetak_tracer(jpost_cetak_tracer); //print tracer ke1
          // cetak_tracer(jpost_cetak_tracer); //print tracer ke2
          // // progress_daftar(70,'Sukses cetak tracer 2x.');
        // }

        // //+++++++++++++++++++++ /print tracer +++++++++++++++++++++++++++++++++++++






      // //+++++++++++++++++++++++ print preview cetak_resume_sep ++++++++++++++++++++++++
        
        let jpost_cetak_resume_sep = null;
        if(penanggung_plh.bpjs){
        // if(penanggung_plh.bpjs || penanggung_plh.NoAnggota == "KEMENKES"){
          prb = sep_res.response.sep.informasi.prolanisPRB;
          console.log(prb);
          // js = cari sep
          jpost_cetak_resume_sep = {
              noSep   : sep_res.response.sep.noSep,
              norm    : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.NoRM,
              alamat  : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Alamat,
              tglSep  : sep_res.response.sep.tglSep,
              noKartu : sep_res.response.sep.peserta.noKartu,
              nama    : sep_res.response.sep.peserta.nama,
              nama_cm : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Nama,
              tglLahir: sep_res.response.sep.peserta.tglLahir,
              poli    : sep_res.response.sep.poli,
              diagnosa: sep_res.response.sep.diagnosa,
              catatan : sep_res.response.sep.catatan,
              umurSaatPelayanan : get_umur_fx(sep_res.response.sep.peserta.tglLahir, 'tahun'), // get_umur_bpjs,
              sex     : sep_res.response.sep.peserta.kelamin,//(val=Laki2) //peserta.sex,
              // exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Sex, // (L/P)

              noTelepon   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.HP, // get_telp_bpjs,//???
              provPerujuk : get_ppkRujukan_nama,
              jnsPelayanan: sep_res.response.sep.jnsPelayanan,
              kelasRawat  : sep_res.response.sep.kelasRawat,
              jnsPeserta  : sep_res.response.sep.peserta.jnsPeserta,
              asuransi    : sep_res.response.sep.peserta.asuransi,
              penjamin    : sep_res.response.sep.penjamin,

              billing     : exe.response.xrec.data.data_utama.billing, //get_bill_siap_pakai,
              lokasi_ket  : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.spesialis,
              nama_dokter : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.nama,
              penanggung_cm: NoAnggota, //'BPJS', // ???
              prb         : prb,
              nourut      : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.generate.antri["3d"],
              tglRujukan  : get_tglRujukan,
          };

          console.log(jpost_cetak_resume_sep);
          cetak_resume_sep(jpost_cetak_resume_sep);

        }
        /*
        else{ // PENANGGUNG SELAIN BPJS
          jpost_cetak_resume_sep = {
            noSep   : '',
            norm    : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.NoRM, //get_norm_cm,
            alamat  : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Alamat, //get_alamat_cm,
            tglSep  : moment().format('YYYY-MM-DD'),
            // tglSep  : jsObj_px_cm.datajs[0].TanggalMasuk,
            noKartu : '',
            nama    : '',
            nama_cm : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Nama, //get_nama_cm,
            tglLahir: exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.TglLahir,
            poli    : '',
            diagnosa: '',
            catatan : '',
            umurSaatPelayanan : get_umur_fx(exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.TglLahir, 'tahun'), //get_umur_bpjs,
            sex     : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.Sex,

            noTelepon   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.mp.HP,
            provPerujuk : get_ppkRujukan_nama,
            jnsPelayanan: '',
            kelasRawat  : '',
            jnsPeserta  : '',
            asuransi    : '',
            penjamin    : '',

            billing     : exe.response.xrec.data.data_utama.billing, // get_bill_siap_pakai,
            lokasi_ket  : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.spesialis,
            nama_dokter : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.nama,
            penanggung_cm: NoAnggota,
            prb         : '',
          };
        }
        */ 
        
        // //+++++++++++++++++++++++ /print preview cetak_resume_sep ++++++++++++++++++++++++
        // progress_daftar(90,'Sukses cetak Resume SEP.');

    });


    $('button[name=btn_sep_hapus]').click(function(e){
      e.preventDefault();
      let nosep     = $('input[name=get_nosep_temp]').val();
      let sep_hapus = _ajax_bpjs("GET", "sep_hapus_bpjs11", {noSep:nosep, user:'16141'});
      console.log(sep_hapus);
      alert("("+sep_hapus.metaData.code+") "+sep_hapus.metaData.message);

    });

    

  }

  //***************************************************/
  //       \bo/menu/receptionist/pendaftaranrj/pendaftaran-rjri
  //***************************************************/



  
  //***************************************************/
  //        bo/menu/tppri/pendaftaran-ri
  //***************************************************/

  if( open_site('bo/menu/tppri/pendaftaran-ri') ){
    let _user_logged_in = $('body').data('user_logged_in');
    $('.select2').select2();
    
    let _bpjs_syarat_rjk = 0; // 0 = TIDAK BOLEH, 1 = BOLEH
    let get_penanggung_cm_kode ='CO031',
        get_penanggung_cm_nama ='B P J S',
        get_penanggung_cm_st   ='M',
        bpjs = 1,
        NoAnggota = "BPJS";

    let penanggung_plh = {
      status : get_penanggung_cm_st,
      kode : get_penanggung_cm_kode,
      nama : get_penanggung_cm_nama,
      bpjs : bpjs,
      _bpjs_syarat_rjk : _bpjs_syarat_rjk,
      NoAnggota : NoAnggota,
    };

    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      let el = '<option value="'+sel_penanggung_cm.dtjs[i].Kode+'" data-noanggota="'+sel_penanggung_cm.dtjs[i].NoAnggota+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>';
      $('select[name=sel_penanggung_cm]').append(el);
    }

    // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');

    $('select[name=sel_penanggung_cm]').on('change', function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      _bpjs_syarat_rjk = 1;

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      NoAnggota = $('select[name=sel_penanggung_cm] option:selected').data("noanggota");
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('table[name=tbl_data_bpjs]').show();
        $('div[name=form_add_else_bpjs]').hide();
        $('input[name=noka], input[name=Barcode]').removeAttr('disabled');
        _bpjs_syarat_rjk = 0;
        bpjs = 1;
        //input val reset
        
        $(".selain_bpjs").hide();
        $(".param_bpjs").show();
        caramasuk = '1'; //Datang Sendiri
        dx_rs      = "10"; // KONTROL

      }else{
        $('table[name=tbl_data_bpjs]').hide();
        $('div[name=form_add_else_bpjs]').show();
        $('input[name=noka], input[name=Barcode]').attr('disabled','disabled').val('');
        _bpjs_syarat_rjk = 1;
        bpjs = 0;

        $(".selain_bpjs").show();
        $(".param_bpjs").hide();
      }

      if(get_penanggung_cm_kode == 'CO011'){
        $(".asal_instansi").show();
      }else{
        $(".asal_instansi").hide();
      }
      
      penanggung_plh = {
        status : get_penanggung_cm_st,
        kode : get_penanggung_cm_kode,
        nama : get_penanggung_cm_nama,
        bpjs : bpjs,
        _bpjs_syarat_rjk : _bpjs_syarat_rjk,
        NoAnggota : NoAnggota,
      };
      console.log(penanggung_plh);
      // console.log('[get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]');
      // console.log([get_penanggung_cm_st, get_penanggung_cm_kode, get_penanggung_cm_nama, _bpjs_syarat_rjk]);

    });



    let rjk_ri = { kode : '', nama : ''};

    $('#rujukan_ri').on('change', function(e){
      e.preventDefault();
      rjk_ri.kode = $('#rujukan_ri option:selected').val();
      rjk_ri.nama = $('#rujukan_ri option:selected').text();
      console.log(rjk_ri);
    });



    let instansi_ri = { kode : '', nama : '',};
    
    $('#instansi_ri').on('change', function(e){
      e.preventDefault();
      instansi_ri.kode = $('#instansi_ri option:selected').val();
      instansi_ri.nama = $('#instansi_ri option:selected').text();
      console.log(instansi_ri);
    });


    let pro_masuk = 1;
    $('#pro_masuk').on('change', function(e){
      e.preventDefault();
      pro_masuk = $(this).val();
      console.log(pro_masuk);
    });

    
    
    $('#btn_update_telp').click(function(e){
      e.preventDefault();

      let norm = $("#norm_ri").val();
      let telp = $('input[name=Telp]').val();
      console.log([norm, telp]);

      if(norm == ''){
        alert("No. Rekam Medis harus terisi...");
      }else{
        let update = _db_update({NoRM : norm}, 'fomstpasien', {Telp: telp});
        if(update == null){
          alert('Proses Update Telp Berhasil.');
        }else{
          alert('Proses Update Gagal. Silahkan ulangi.');
        }
      }
        
    });
    

    // $('#btn_update_noka').click(function(e){
    //   e.preventDefault();

    //   let norm = $("#norm_ri").val();
    //   let noka_rs = $('#noka_bpjs').val();
    //   console.log([norm, telp]);

    //   if(norm == ''){
    //     alert("No. Rekam Medis harus terisi...");
    //   }else{
    //     let update = _db_update({NoRM : norm}, 'fomstpasien', {Barcode: noka_rs});
    //     if(update == null){
    //       alert('Proses Update No.Kartu BPJS Berhasil.');
    //     }else{
    //       alert('Proses Update Gagal. Silahkan ulangi.');
    //     }
    //   }
        
    // });


    //SYARAT : HARUS TAMPIL DATA DI TABEL INFO PASIEN_RSCM
    $('select[name=pasienRscm_sukubangsa]').on('change',function(){
      let norm = $("#norm_ri").val();
      // console.log(norm.length);
      if(norm != ''){
        let Sukubangsa = $(this).val();
        console.log([norm, Sukubangsa]);
        update_suku_bangsa(norm, Sukubangsa);
      }
    });
    
    $('select[name=sel_agama]').on('change',function(){
      let norm = $("#norm_ri").val();
      // console.log(norm.length);
      if(norm != ''){
        let agama = $(this).val();
        let upd = _ajax("POST", "update_new", {table:"fomstpasien", arr_data:{Agama:agama}, where:{NoRM:norm}});
        
        if(upd==null){
          console.log("UPDATE AGAMA SUKSES");
        }
      }
    });




    // ENTER NORM
    let cari_px = null;
    let norm = '', noka='';
    $("#norm_ri").keypress(function (e) { //TEKAN ENTER
      norm = $(this).val();
      // console.log(norm);
      if (e.which == 13) {
        cari_px = _ajax('GET', 'promasuk_initrm/'+pro_masuk+'/'+norm, '');
        console.log(cari_px);

        
        let tbl = {
          id : 'tbl_mdl_cari_px',
          headers : [
            ['NoRM', 'NoRM'], ['Nama','Nama'],
            ['NoBill', 'NoBill'], ['lokasiket','Lokasi'], ['Alamat','Alamat'],
          ],
          data : cari_px,
          button : {
            color : 'success',
            head : 'OPSI',
            label : 'PILIH',
          },
        };
      
        let el_tbl = create_table_return(tbl, js_bed); 


        let mdl = {
          id    : 'modal_cari_px',
          bodyId: 'el_modal2',
          size  : 'lg',
          title : 'Daftar Pasien',
          table : el_tbl,
        };
        let el = create_modal(mdl);
        $('#modal_list').append(el);
        $('#tbl_mdl_cari_px').DataTable({"scrollX": true});
        $('#modal_cari_px').modal('show'); 
      }
    });
      
  
    let cari_px_bpjs = null;
    $("#noka_bpjs").keypress(function (e) { //TEKAN ENTER
      noka = $(this).val();
      // console.log(norm);
      if (e.which == 13) {
        console.log(noka);

        cari_px_bpjs = _ajax_bpjs("GET", "url/GET/Peserta/nokartu/"+noka+"/tglSEP/"+moment().format('YYYY-MM-DD'), "");
        console.log(cari_px_bpjs);
        if(cari_px_bpjs.metaData.code!=200){
          alert('PESAN BPJS: ('+cari_px_bpjs.metaData.code+') '+cari_px_bpjs.metaData.message);
        }else{
          //-- UPDATE NOKA
          //jika norm tidak kosong
          norm = $("#norm_ri").val();
          // let noka_rs = $('#noka_bpjs').val();
          console.log(norm);

          if(norm == ''){
            alert("No. Rekam Medis harus terisi...");
            $("#norm_ri").focus();
            // return 0;
          }else{
            let update = _db_update({NoRM : norm}, 'fomstpasien', {Barcode: noka});
            if(update == null){
              console.log('Proses Update No.Kartu BPJS Berhasil.');
            }else{
              alert('Proses Update Gagal. Silahkan ulangi.');
            }
          }
          //\-- UPDATE NOKA


          $('input[name=nik_bpjs]').val(cari_px_bpjs.response.peserta.nik);
          $('input[name=nama_bpjs]').val(cari_px_bpjs.response.peserta.nama);
          $('input[name=tgllahir_bpjs]').val(cari_px_bpjs.response.peserta.tglLahir);
          // $('input[name=kelas_bpjs]').val(cari_px_bpjs.response.peserta.hakKelas.kode);
          // $('#kelas_bpjs').val(cari_px_bpjs.response.peserta.hakKelas.kode);
          $('#kelas_bpjs option[value="'+cari_px_bpjs.response.peserta.hakKelas.kode+'"]').attr('selected','selected');

          $('input[name=asalPPK_bpjs]').val(cari_px_bpjs.response.peserta.provUmum.nmProvider);
          $('input[name=jns_peserta]').val(cari_px_bpjs.response.peserta.cob.nmAsuransi);
          $('input[name=get_tglRujukan]').val();
          $('input[name=norujukan]').val();
          
          $('input[name=norm_bpjs]').val(cari_px_bpjs.response.peserta.mr.noMR);
          $('input[name=telp_bpjs]').val(cari_px_bpjs.response.peserta.mr.noTelepon);
        
        }


      }
    });


    let js_px_selected = null,
        px_rs = null,
        get_umur_fv = null;

    $(document).on('click','#tbl_mdl_cari_px tbody tr td button', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(id);
      js_px_selected = cari_px[id];
      console.log(js_px_selected);

      norm = js_px_selected.NoRM;

      px_rs = _ajax('GET', 'get_pxrs/'+norm, '')[0];
      console.log(px_rs);

      get_umur_fv = get_umur_fx_new(px_rs.TglLahir);
      console.log(get_umur_fv);  

      $('#norm_ri').val(norm);
      $('#nobill_ri').val(js_px_selected.NoBill);
      // $('#Nama').val(js_px_selected.Nama);

      let arr_px_rs = [
        // "NoRM" ,"Barcode", 
        "NoIdentitas", "Nama", 
        "Alamat", "Rt", "Rw", "TempatLahir",
        "TglLahir", "Telp", "HP", "agama_ket", "kelurahan_ket", "kecamatan_ket",
        "kota_ket", "propinsi_ket", "negara_ket", "pekerjaan_ket", "pendidikan_ket",
        "Sex", "GolDarah", "marital_ket", 
      ];  
      
      for (let i = 0; i < arr_px_rs.length; i++) {
        $("input[name='"+arr_px_rs[i]+"']").val(px_rs[arr_px_rs[i]]);          
      }

      $("textarea[name='Keterangan']").val(px_rs.Keterangan);
      $("input[name='umur']").val(hitungUmur(px_rs['TglLahir']));
      $("#keluarga_alamat").val(px_rs.Alamat);
      $('select[name=pasienRscm_sukubangsa] option[value="'+px_rs['Sukubangsa']+'"]').attr('selected','selected');
      $('select[name=sel_agama] option[value="'+px_rs['Agama']+'"]').attr('selected','selected');

      $('#noka_bpjs').val(px_rs.Barcode);

      // $('#tbl_mdl_cari_px').DataTable().destroy(); // DISABLE
      $('#modal_cari_px').modal('hide');
    });

   
    $(document).on('hide.bs.modal','#modal_cari_px', function () {
      $('#tbl_mdl_cari_px').DataTable().destroy();
      console.log('modal hide');
    });




    //BED
    
      let js_bed = null;
      let js_bed_selected = null;

      $('#kdbed_ri').click(function(e){
        e.preventDefault();

        js_bed = _ajax("GET", "db/m_daftarmandiri/get_kode_bed", "");
        console.log(js_bed);

        let tbl = {
            id : 'tbl_mdl_bedri',
            headers : [
              ['KodeBed', 'Kode Bed'], ['KeteranganBed','Keterangan'], ['Ruang','Ruang'], 
              ['Kelas','Kelas'], ['Status','Status','style="text-align:center;"'], 
              ['Tarif_Include','Tarif Include', 'style="text-align:right;"','numeral']
            ],
            data : js_bed,
            button : {
              color : 'success',
              head : 'OPSI',
              label : 'PILIH',
            },
          };
        
        let el_tbl = create_table_return(tbl, js_bed); 


        let mdl = {
          id    : 'modal_bed',
          bodyId: 'el_modal2',
          size  : 'lg',
          title : 'Daftar Kode Bed',
          table : el_tbl,
        };
        let el = create_modal(mdl);
        $('#modal_list').append(el);
        $('#tbl_mdl_bedri').DataTable({"scrollX": true});
        $('#modal_bed').modal('show');

      });


      // $(document).on('click','table[name=mdl_tbl] tbody tr td button[name=btn_pilih_daftaronline_web]', function(){
      $(document).on('click','#tbl_mdl_bedri tbody tr td button', function(e){
        e.preventDefault();
        console.log($(this).data('id'));
        js_bed_selected = js_bed[$(this).data('id')];
        console.log(js_bed_selected);
        $('#kdbed_ri').val(js_bed_selected.KodeBed);
        $('#ruangbed_ri').val(js_bed_selected.Ruang);
        $('#kelasbed_ri').val(js_bed_selected.Kelas);
        $('#tarifkamar_ri').val(js_bed_selected.Tarif_Include);        

        $('#tbl_mdl_bedri').DataTable().destroy(); // DISABLE
        $('#modal_bed').modal('hide');
      });

     
      $(document).on('hide.bs.modal','#modal_bed', function () {
        $('#tbl_mdl_bedri').DataTable().destroy();
        console.log('modal hide');
      });



    //\BED
    
    let js_pelayanan = _ajax("GET", "db/m_daftarmandiri/get_pelayanan_ri", "");
    // console.log(js_pelayanan);
    
    // PUSH AUTOCOMPLETE
    for (let dpjp = 0; dpjp < js_pelayanan.length; dpjp++) {
      js_pelayanan[dpjp]['value'] = js_pelayanan[dpjp].Keterangan;
      js_pelayanan[dpjp]['label'] = js_pelayanan[dpjp].Keterangan+'('+js_pelayanan[dpjp].Kode+')';
    }
    console.log(js_pelayanan);
    
    let sel_pelayanan = null;
    $("#pelayanan_ri").autocomplete({
      source: js_pelayanan,
      // minLength: 2,
      select: function( event, ui ) {
        // console.log(ui); console.log(event);
        sel_pelayanan = ui.item;
        console.log(sel_pelayanan);
      }
    });



    // DOKTER AWAL
    let js_dpjp_new = _ajax('GET','get_dokter_luar_dalam/ALL/','');
    console.log(js_dpjp_new);
    
    let sel_dpjp_auto = null;
    // PUSH AUTOCOMPLETE
    for (let dpjp = 0; dpjp < js_dpjp_new.length; dpjp++) {     
      js_dpjp_new[dpjp]['value'] = js_dpjp_new[dpjp].nama;
      js_dpjp_new[dpjp]['label'] = js_dpjp_new[dpjp].nama+'('+js_dpjp_new[dpjp].kode+')';
    }
    
    $("#dokter_awal_ri").autocomplete({
      source: js_dpjp_new,
      minLength: 2,
      select: function( event, ui ) {
        // console.log(ui); console.log(event);
        sel_dpjp_auto = ui.item;
        // console.log(sel_dpjp_auto);
        dpjp_type = sel_dpjp_auto.type;
        dpjp_kode = sel_dpjp_auto.kode;
        dpjp_nama = sel_dpjp_auto.nama;
        console.log([dpjp_type, dpjp_kode, dpjp_nama]);
        $('input[name=kd_dpjp_bpjs]').val(sel_dpjp_auto.kd_dpjp_bpjs);
      }
    });
    
    
    
    // DIAGNOSA(RS) AWAL RI
    let js_dx = _ajax('GET','search_dx_cm/','');
    console.log(js_dx);
    
    let sel_dx_auto = null;
    // PUSH AUTOCOMPLETE
    for (let dpjp = 0; dpjp < js_dx.length; dpjp++) {
      js_dx[dpjp]['value'] = js_dx[dpjp].Keterangan;
      js_dx[dpjp]['label'] = js_dx[dpjp].Keterangan+'('+js_dx[dpjp].Kode+')';
    }
    
    $("#dxawal_ri").autocomplete({
      source: js_dx,
      select: function( event, ui ) {
        // console.log(ui); console.log(event);
        sel_dx_auto = ui.item;
        console.log(sel_dx_auto);
      }
    });




    
    $("input[name=dxkey_bpjs]").keypress(function(e){
      let diagkey_bpjs = $(this).val();
      if (e.which == 13) {
        $('select[name=dx_bpjs]').children().remove();

        let jsObj_diag = ref_diagnosa(diagkey_bpjs).response.diagnosa;
        console.log(jsObj_diag);

        for(let i=0; i<jsObj_diag.length; i++){
          $('select[name=dx_bpjs]').append('<option value="'+jsObj_diag[i].kode+'">'+jsObj_diag[i].nama+'</option>');
        }

      }
    });


    //skdp BL191129.0169 = 290169/SKDP-IRI/11/2019
    function fx_skdp(layanan=null, nobill=null){
      let s = '';
      switch (layanan) {
        case 'RI':
            s = nobill.substr(6,2)+nobill.substr(9,4)+'/SKDP-IRI/'+nobill.substr(4,2)+'/20'+nobill.substr(2,2);
      
          break;
        
        case 'BPJS': // 6 digit: tgl+4digit nobill
            s = nobill.substr(6,2)+nobill.substr(9,4);
          break;
      
        default:
          break;
      }

      return s;
    }
    // console.log(fx_skdp('RI', 'BL191129.0169'));
    // console.log(fx_skdp('BPJS', 'BL191129.0169'));



    let exe_insert = null,
        insert_post = null,
        upd_var = null,
        sep_req = null,
        sep_res = null;

    let tc = {
      klik_daftar : "",
      bill        : "",
      noantrian   : "",
      sep         : "",
      insert_daftar_rj: "",
    };

    let spri = '',
        spri_bpjs = ''; // skdp_ri
    let get_nosep_temp = '';

    $('#btn_daftarri').click(function(e){
      e.preventDefault();
      console.log('klik DAFTAR RI');
      
      tc.klik_daftar = moment().format('HH:mm:ss');

      if(pro_masuk == 1){ // LANGSUNG MASUK RI : bayi baru lahir

        // CREATE NEW NOBILL
        let js_bill = _ajax('GET', 'db/m_daftarmandiri/create_bill', '');
        nobill = js_bill.new_bill;
        spri   = fx_skdp('RI', nobill);

        tc.bill = moment().format('HH:mm:ss');
        
        let ftd = {
          nobill    : nobill,
          nobillsub : '',
          norm      : norm,
          tanggalmasuk  : moment().format('YYYY-MM-DD'),
          tanggalkeluar : moment().format('YYYY-MM-DD'),
          jammasuk  : moment().format('HH:mm:ss'),
          jamkeluar : moment().format('HH:mm:ss'),
          statusBL  : 'LAMA', // IIf(isAdd, "BARU", "LAMA")
          flagbill  : 0,
          diagnosaawal: sel_dx_auto.Kode,
          anggota : penanggung_plh.status, // IIf(Trim(txtPenanggungKet.Text) <> "", "M", "U")
          perusahaanpenanggung: penanggung_plh.kode,
          // biayakartu: 0, 
          // biayakartuupdisc : 0,
          nama  : px_rs.Nama, //$('input[name=Nama]').val(),
          alamat: px_rs.Alamat,
          telp  : px_rs.Telp,
          hp    : px_rs.HP,
          fax   : px_rs.Fax,
          email : px_rs.Email,
          rt    : px_rs.Rt,
          rw    : px_rs.Rw,
          kelurahan : px_rs.Kelurahan,
          kecamatan : px_rs.Kecamatan,
          kota      : px_rs.Kota,
          propinsi  : px_rs.Propinsi,
          negara    : px_rs.Negara,
          agama     : px_rs.Agama,
          pendidikan: px_rs.Pendidikan,
          pekerjaan : px_rs.Pekerjaan,
          sex       : px_rs.Sex, //IIf(optSex(0).Value, "L", "P")
          marital   : px_rs.Marital, //IIf(optMarital(0).Value, "Y", IIf(optMarital(1).Value, "T", IIf(optMarital(2).Value, "D", "J")))
          statusdaftar : 'RI',
          umurtahun : get_umur_fv.tahun,
          umurbulan : get_umur_fv.bulan,
          umurhari  : get_umur_fv.hari,
          kategoriusia: kategori_usia(get_umur_fv.tahun),

          // limitkredit:0,
          noanggota : penanggung_plh.NoAnggota,
          caramasuk : $('#cara_masuk_ri option:selected').val(),
          asalPPK   : rjk_ri.nama, // txtemail.Text,
          asalinstansi: instansi_ri.kode,          
          noskdp      : spri,

          user : _user_logged_in, // _user_daftar,
          date : moment().format('YYYY-MM-DD'),
          time : moment().format('HH:mm:ss')
        };
        
        console.log(ftd);

        // LANJUT INSERT INTO FOTRDAFTAR
        exe_insert = _db_insert('fotrdaftar', ftd);
        console.log('>>RESPONSE INSERT DB XLINK');
        console.log({res_insert_ftd : exe_insert});

        if(exe_insert == null){ console.log('Proses Insert Sukses.');
        }else{ alert('Proses Insert Gagal. Silahkan ulangi.'); }

                        

        //--save fotrbillingshare
        let bshare = {
          nobill: nobill,
          no    : '1', 
          masterorextra : 'M', 
          billname      : px_rs.Nama, //txtNama.Text, 
          billket       : 'Bill From RJ', 
          billpenanggung: penanggung_plh.kode, //txtPenanggung.Text, 
          user : _user_logged_in,
          date : moment().format('YYYY-MM-DD'),
          time : moment().format('HH:mm:ss')
        };
        console.log(bshare);
        
        exe_insert = _db_insert('fotrbillingshare', bshare);
        console.log({res_insert_bshare : exe_insert});

        if(exe_insert == null){ console.log('Proses Insert Sukses.');
        }else{ alert('Proses Insert Gagal. Silahkan ulangi.'); }

        //--\save fotrbillingshare


      }else{ // pro_masus != 1
        // melalui ugd or rawatjalan (update statusdaftar)
        
        nobill = $('#nobill_ri').val();
        spri = fx_skdp('RI', nobill);
        tc.bill = moment().format('HH:mm:ss');

        //skdp BL191129.0169 = 290169/SKDP-IRI/11/2019
        upd_var = {
          noanggota   : penanggung_plh.NoAnggota, 
          // limitkredit : txtLimitKredit.TextSQL,
          statusdaftar:'RI',
          noskdp      : spri,
          User        : _user_logged_in,
        };

        let upd = _db_update( {nobill : nobill}, 'fotrdaftar', upd_var);
        console.log(upd);
  
        if(upd == null){ console.log('Update >> Sukses.');
        }else{ console.log('Update >> Gagal. Silahkan ulangi.'); }

      }


      //--update status bed
      let upd = _db_update( {kode : $('#kdbed_ri').val() }, 'fokmrmstbed', {Status:'IN'});
      console.log(upd);

      if(upd == null){ console.log('Update BED >> Sukses.');
      }else{ console.log('Update BED >> Gagal. Silahkan ulangi.'); }
      //--\update status bed


      //--save uang muka
      // {SCRIPT BELUM}
      // If optCorD(0).Value Then
      // Data.SQLExecute _
      //   "INSERT INTO fotrpayment " & _
     
      
      // let insert_um = {
      //   TglTrans, 
      //   NoBill, 
      //   No, 
      //   MasterOrExtra, 
      //   NoNota, 
      //   Tab,
      //   Lokasi, 
      //   StandartCost, 
      //   Cash, 
      //   Debit, 
      //   KreditCard,
      //   CL, 
      //   Gratis, 
      //   Billing, 
      //   CashBayar, 
      //   CashKembali,
      //   DebitNoCard, 
      //   DebitNoApprov,
      //   DebitKeterangan, KreditCardName, KreditNoCard,
      //   KreditNoApprov, KreditProvisi, KreditProvisiRP, KreditKeterangan, CLPenanggung,
      //   CLKeterangan, GratisKategori, GratisTgJwb, GratisKeterangan, BillingKeterangan,
      //   User, Date, Time
      // };
      //--\save uang muka


      //--Save trDaftarRI
      //fotrdaftarri
      insert_post = {
        NoBill    : nobill,
        Kodebed   : $('#kdbed_ri').val(), // txtKodeBed.Text,
        TypeTarif : 1,//INCLUDE=optTypeTarif(1) // IIf(optTypeTarif(0).Value, "0", "1")
        Tarif     : $('#tarifkamar_ri').val(), // txtTarifKamar.TextSQL,
        // PenanggungNama  : '', // $('#penanggung_nama').val(), // txtNamaPenanggung.Text,
        // PenanggungAlamat: '', // $('#penanggung_alamat').val(), // txtAlamatPenanggung.Text,
        // PenanggungTelp  : '', // $('#penanggung_telp').val(), // txtTelpPenanggung.Text,
        KeluargaNama    : $('#keluarga_nama').val(), // txtNamaKeluarga.Text,
        KeluargaAlamat  : $('#keluarga_alamat').val(), // txtAlamatKeluarga.Text,
        KeluargaTelp    : $('#keluarga_telp').val(), // txtTelpKeluarga.Text,
        TypeDokter      : sel_dpjp_auto.type, //IIf(optTypeM(0).Value, "0", "1")
        DokterAwal      : sel_dpjp_auto.kode, // txtDokterAwal.Text,
        // PerawatPenerima : txtPerawatPenerima.Text,
        // PetugasAdmission: txtPetugasAdmission.Text,
        // UangMuka    : txtUangMuka.TextSQL,
        // LimitKredit : txtLimitKredit.Text,
        // Paket       : txtPaket.Text,
        ProsedurMskRS : pro_masuk,
        PelayananRI : sel_pelayanan.Kode, //txtPelayanan.Text,
        CaraMasuk   : $('#cara_masuk_ri option:selected').val(), // txtCaraMasuk.Text,
        Rujukan     : rjk_ri.kode, // txtemail.Text,
        FlagDaftar  : 0,
        KasusPolisi : 1, //IIf(optKasusPolisi(0).Value, "0", "1")
        User : _user_logged_in,
        Date : moment().format('YYYY-MM-DD'),
        Time : moment().format('HH:mm:ss')
      };
      console.log(insert_post);

      exe_insert = _db_insert('fotrdaftarri', insert_post);
      console.log('>>INSERT DAFTARRI');
      console.log({res_insert_ftdi : exe_insert});

      if(exe_insert == null){ console.log('Proses Insert Sukses.');
      }else{ alert('Proses Insert Gagal. Silahkan ulangi.'); }

      //--\Save trDaftarRI


      // let bpjs = 0;
      // if(bpjs){
      spri_bpjs   = fx_skdp('BPJS', nobill);

      if(penanggung_plh.bpjs){
        // sep_ri
        sep_req =
          {
            "request": {
              "t_sep": {
                  "noKartu" : $('#noka_bpjs').val(), //get_noka,
                  "tglSep"  : moment().format('YYYY-MM-DD'), // $('input[name=tglsep]').val(),// tglSep,
                  "ppkPelayanan": config_bpjs.kode_rs,
                  "jnsPelayanan": '1', // get_jnsPelayanan,
                  "klsRawat"    : $('#kelas_bpjs option:selected').val(), // dropdown 123, //cari_px_bpjs.response.peserta.hakKelas.kode, // get_klsRawat,
                  "noMR"        : norm, // get_norm_cm,
                  "rujukan": {
                    "asalRujukan" : "2", // get_asalRujukan_bpjs, // FASKES : 1,2
                    "tglRujukan"  : moment().format('YYYY-MM-DD'), //?? get_tglRujukan,
                    "noRujukan"   : $('#noka_bpjs').val(), //?? get_norujukan,
                    "ppkRujukan"  : "0195R028", //CITRA MEDIKA // get_ppkRujukan
                  },
                  "catatan" : $('input[name=catatan_bpjs]').val(),
                  "diagAwal": $('select[name=dx_bpjs] option:selected').val(),
                  "poli": {
                    "tujuan": "",// klinik_plh.kode_bpjs, //get_poliKode_bpjs,
                    "eksekutif": "0"
                  },
                  "cob": {
                    "cob": "0"
                  },
                  "katarak": {
                    "katarak": "0"
                  },
                  "jaminan": {
                    "lakaLantas": "0",
                    "penjamin": {
                      "penjamin": "0",
                      "tglKejadian": "0000-00-00",
                      "keterangan": "",
                      "suplesi": {
                        "suplesi": "0",
                        "noSepSuplesi": "",
                        "lokasiLaka": {
                          "kdPropinsi": "",
                          "kdKabupaten": "",
                          "kdKecamatan": ""
                        }
                      }
                    }
                  },
                  "skdp": {
                    "noSurat" : spri_bpjs, // $('input[name=skdp]').val(), // noskdp_bpjs,
                    "kodeDPJP": $('input[name=kd_dpjp_bpjs]').val(),
                  },
                  "noTelp": $('input[name=telp_bpjs]').val(),
                  // "user": "16141"
                  "user": config_bpjs.consid
              }
            }
          };
          //======   \ws1.1   ============

          console.log('[Data will send:: sep_create]::');
          console.log(sep_req);

          // //[== CREATE SEP RI ==]
          sep_res = sep_create_by_noka(sep_req); //response_create_sep [LIHAT KATALOG BPJS]
          console.log("<RESPONSE CREATE SEP> sep_res");
          console.log(sep_res);

          
          if(sep_res.metaData.code == 200 ){ //bila create_sep SUKSES
            tc.sep = moment().format('HH:mm:ss');
            
            get_nosep_temp = sep_res.response.sep.noSep;
            sep = get_nosep_temp;
            // $('input[name=get_nosep_temp]').val(sep);
            $('#get_nosep_temp').val(sep);
            // CASEMIX:MASUKKAN PASIEN
            
              //UPDATE SEP RI
                let dtsep = _db_update( {NoBill : nobill}, 'fotrdaftar', {nosep:sep, User:_user_logged_in});
                console.log(dtsep);

                if(dtsep == null){ console.log('Edit SEP Sukses.');
                }else{ console.log('Edit SEP Gagal. Silahkan ulangi.'); }


              // cx_daftarritarif
              let jPost_tbl1 = {
                nobill   : nobill,
                norm     : norm,
                sep      : sep,
                dpjp     : sel_dpjp_auto.kode, //dpjp_kode,
                st_kelas : $('select[name=status_kelas] option:selected').val(),
                kelas    : $('select[name=kelas] option:selected').val(), // $('#kelas_bpjs option:selected').val(),
                hakkelas : 'Kelas '+$('#kelas_bpjs option:selected').val(), //kelas,
                user    : _user_logged_in,
                date    : moment().format('YYYY-MM-DD'),
                time    : moment().format('HH:mm:ss')
              };


              data_rec = {
                data_utama : { 
                  nobill : nobill
                },
                data_paket : jPost_tbl1,
              };
              let jPost_tblrec = {
                id   : '',
                app  : 'bo/menu/casemix/pantauan_biaya_ri',
                element : $(this)[0].id, // $(this)[0].name,
                nama : 'insert_px_to_daftarritarif',
                ket  : 'Pasien ditambahkan di Daftar Tarif RI.',
                data : JSON.stringify(data_rec),
                user : _user_logged_in,
                date : moment().format('YYYY-MM-DD'),
                time : moment().format('HH:mm:ss')
              };

              // insert_daftarritarif
              let jPost = {
                data1 : jPost_tbl1, // cx_daftarritarif
                data2 : jPost_tblrec  // cx_rec
              }
              console.log(jPost);


              let dt = _ajax('POST','insert_daftarritarif',jPost);
              console.log(dt);
              if(dt == null){ // SUKSES
                
                //-- INSERT DIAGNOSA AWAL di CASEMIX
                  let j_hisdx = {
                    nobill  : nobill,
                    id      : 1,
                    dx_awal : $('#dx_casemix').val(),
                    user : _user_logged_in,
                    date : moment().format('YYYY-MM-DD'),
                    time : moment().format('HH:mm:ss')
                  };

                  let exe_ins_hisdx = _db_insert('cx_daftarrihistoridiag', j_hisdx);
                  console.log(exe_ins_hisdx);

                  if(exe_ins_hisdx == null){
                    console.log('Insert [HISTORI DIAGNOSA] >> Sukses.');
                  }else{
                    alert('Insert [HISTORI DIAGNOSA] >> Gagal. Silahkan ulangi.');
                  }
                //\-- INSERT DIAGNOSA AWAL di CASEMIX


                //-- NEW_CLAIM INACBG
                let j_new_claim = {
                    "metadata": {
                      "method": "new_claim"
                    },
                    "data": {
                      "nomor_kartu" : $('#noka_bpjs').val(),
                      "nomor_sep"   : sep,
                      "nomor_rm"    : norm,
                      "nama_pasien" : px_rs.Nama,
                      "tgl_lahir"   : px_rs.TglLahir,
                      "gender"      : px_rs.gender_eclaim,
                    }
                  };
                
                console.log({"send_new_claim": j_new_claim});
                let js_new_claim = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/json/", j_new_claim);
                console.log({"js_new_claim":js_new_claim});
                //\-- NEW_CLAIM INACBG

                alert('Data pasien berhasil dimasukkan di Daftar Tarif RI.');
                
                // $('button[name=btn_insert_daftarritarif]').hide(); //?
              }else{
                alert('Proses Gagal. Silahkan ulangi.');
              }
            //\CASEMIX:MASUKKAN PASIEN


            // POPUP AUTO:CETAK SEP RI
              let sep_cari = _ajax_bpjs("GET", "sep_cari_bpjs", {nosep: sep});
              console.log({sep_cari:sep_cari});
        
              let get_noka = sep_cari.response.peserta.noKartu;
              // let tgl = moment().format('YYYY-MM-DD');
              let peserta_cari = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep: moment().format('YYYY-MM-DD') });
              console.log({peserta_cari:peserta_cari});
        
              jpost_cetak_sep = {
                noSep   : sep,
                tglSep  : sep_cari.response.tglSep,
                noKartu : sep_cari.response.peserta.noKartu,
                nama    : sep_cari.response.peserta.nama,
                tglLahir: sep_cari.response.peserta.tglLahir,
                poli    : sep_cari.response.poli,
                diagnosa: sep_cari.response.diagnosa,
                catatan : sep_cari.response.catatan,
        
                noTelepon   : peserta_cari.response.peserta.mr.noTelepon,
                provPerujuk : peserta_cari.response.peserta.provUmum.nmProvider,
                jnsPelayanan: sep_cari.response.jnsPelayanan,
                kelasRawat  : sep_cari.response.kelasRawat,
                jnsPeserta  : sep_cari.response.peserta.jnsPeserta,
                asuransi    : sep_cari.response.peserta.asuransi,
                penjamin    : sep_cari.response.penjamin,
                prb         : peserta_cari.response.peserta.informasi.prolanisPRB,
              }; 
        
              console.log({"CETAK SEP":jpost_cetak_sep}); //return 0;
              print_preview("sep_cetak", jpost_cetak_sep);
      
            //\POPUP AUTO:CETAK SEP RI

          }else{ //bila create_sep TIDAK SUKSES
            
            //UPDATE SEP
            let dtsep = _db_update( {NoBill : nobill}, 'fotrdaftar', {nosep:0, User:_user_logged_in});
            console.log(dtsep);

            if(dtsep == null){ console.log('Edit SEP 0 Sukses.');
            }else{ console.log('Edit SEP 0 Gagal. Silahkan ulangi.'); }

            //UPDATE SEP di fotrdaftar.nosep = 0
            alert('Tidak sukses daftarkan SEP. Pesan BPJS = '+sep_res.metaData.message);
            return 0;
          }
          // //[==\CREATE SEP ==]
      }
      

    });
    // \#btn_daftarri.click



    // let send = null;
    $('#btn_daftarri_new').click(function(e){
      e.preventDefault();
      console.log('klik DAFTAR RI NEW');

      // //====tes
      // let sendt = {
      //   a : "book",
      //   a2 : "book2",
      //   asub : {
      //     aa:"booka",
      //     aa2:"booka2",
      //   },
      // };
      // let rest = _ajax("POST", "daftar_pasienri_klik", sendt);
      // console.log(rest);
      // return 0;
      // //====tes

      // alert("JANGAN PAKAI INI"); return 0;

      let send = {
        pro_masuk : pro_masuk,
        nobill_ri : $('#nobill_ri').val(), // pro_masuk != 1
        noka_bpjs : $('#noka_bpjs').val(), // KHUSUS BPJS
        kdbed_ri  : $('#kdbed_ri').val(),

        sel_dpjp_auto   : sel_dpjp_auto,
        sel_pelayanan   : sel_pelayanan,
        tarifkamar_ri   : $('#tarifkamar_ri').val(),
        KeluargaNama    : $('#keluarga_nama').val(), // txtNamaKeluarga.Text,
        KeluargaAlamat  : $('#keluarga_alamat').val(), // txtAlamatKeluarga.Text,
        KeluargaTelp    : $('#keluarga_telp').val(),
        px_rs: px_rs,
        ftd : {
          sel_dx_auto     : sel_dx_auto,
          penanggung_plh  : penanggung_plh,
          get_umur_fv     : {
            tahun : get_umur_fv.tahun,
            bulan : get_umur_fv.bulan,
            hari  : get_umur_fv.hari,
          },
          kategori_usia   : kategori_usia(get_umur_fv.tahun),
          cara_masuk_ri   : $('#cara_masuk_ri option:selected').val(),
          rjk_ri          : rjk_ri,
          instansi_ri     : instansi_ri,
        },
        sep_req : {
          noKartu     : $('#noka_bpjs').val(), //get_noka,
          ppkPelayanan: config_bpjs.kode_rs,
          klsRawat    : $('#kelas_bpjs option:selected').val(), // dropdown 123, //cari_px_bpjs.response.peserta.hakKelas.kode, // get_klsRawat,
          noMR        : norm, // get_norm_cm,
          noRujukan   : $('#noka_bpjs').val(), //?? get_norujukan,
          catatan     : $('input[name=catatan_bpjs]').val(),
          diagAwal    : $('select[name=dx_bpjs] option:selected').val(),
          kodeDPJP  : $('input[name=kd_dpjp_bpjs]').val(),
          noTelp    : $('input[name=telp_bpjs]').val(),
          user      : config_bpjs.consid
        },
        casemix : {
          st_kelas : $('select[name=status_kelas] option:selected').val(),
          kelas    : $('select[name=kelas] option:selected').val(), // $('#kelas_bpjs option:selected').val(),
          hakkelas : 'Kelas '+$('#kelas_bpjs option:selected').val(), //kelas,
          element  : $(this)[0].id,
          dx_awal : $('#dx_casemix').val(),
        },
      };
      console.log(send);

      let res = _ajax("POST", "daftar_pasienri_klik", send);
      console.log(res);

      let res_nobill= res.generate.nobill;
      let res_sep   = res.generate.sep;
      
      if(penanggung_plh.bpjs){
        let sep_cari = res.bridging.bpjs.sep_cari;
        let peserta_cari = res.bridging.bpjs.peserta_cari;

        // POPUP AUTO:CETAK SEP RI
        jpost_cetak_sep = {
          noSep   : res_sep,
          tglSep  : sep_cari.response.tglSep,
          noKartu : sep_cari.response.peserta.noKartu,
          nama    : sep_cari.response.peserta.nama,
          tglLahir: sep_cari.response.peserta.tglLahir,
          poli    : sep_cari.response.poli,
          diagnosa: sep_cari.response.diagnosa,
          catatan : sep_cari.response.catatan,

          noTelepon   : peserta_cari.response.peserta.mr.noTelepon,
          provPerujuk : peserta_cari.response.peserta.provUmum.nmProvider,
          jnsPelayanan: sep_cari.response.jnsPelayanan,
          kelasRawat  : sep_cari.response.kelasRawat,
          jnsPeserta  : sep_cari.response.peserta.jnsPeserta,
          asuransi    : sep_cari.response.peserta.asuransi,
          penjamin    : sep_cari.response.penjamin,
          prb         : peserta_cari.response.peserta.informasi.prolanisPRB,
        }; 

        console.log({"CETAK SEP":jpost_cetak_sep}); //return 0;
        print_preview("sep_cetak", jpost_cetak_sep);

        //\POPUP AUTO:CETAK SEP RI
      }


      
      $('#get_nosep_temp').val(res_sep);
      $('#get_bill_siap_pakai').val(res_nobill);

      $('#btn_daftarri_new').hide();

      if($res["generate"]["status_daftarri"]){
        alert("Pasien berhasil didaftarkan.");
      }else{
        alert("Tidak berhasil mendaftarkan pasien. Hapus SEP di VCLAIM kemudian ulangi proses.");
      }

    });
    // \#btn_daftarri_new.click



    $('#lbl_data_bpjs').dblclick(function(e){
      e.preventDefault();
      console.log("toggle btn_create_sep");
      $('#btn_buatSepRI').toggle();
      $('.tr_bpjs').toggle();
    });

    

    
    $('#btn_cetak_tracer_ri').click(function(e){
      e.preventDefault();
      // let sep = $('#get_nosep_temp').val();
      // console.log(sep);

      let nobill = $('#get_bill_siap_pakai').val();      

      if(nobill==''){
        alert("Nomor Billing harus diisi!");
        $('#get_bill_siap_pakai').focus();
        return 0;
      }

      
      let js_sel = _ajax("GET", "db/m_daftarmandiri/pxri_det/"+nobill, "");
      console.log(js_sel);

        
      console.log(">> BTN/CETAK TRACER");
      let jpost_cetak_tracerri = {
        NoBill    : js_sel.nobill,
        NoRM      : js_sel.norm,
        Nama      : js_sel.nama,
        TglLahir  : js_sel.tgllahir,
        Sex       : js_sel.jeniskelamin,
        Alamat    : js_sel.alamat,
        kelas_ruang : js_sel.kelas_ruang,
        bed_tarif : js_sel.tarif_bedri,
        // dokter    : js_sel.dokter_nama,
        user      : _user_logged_in,
        ket       : js_sel.keterangan,
        umur      : js_sel.umur,
        kategori_usia   : js_sel.kategori_usia,
        st_px_baru_lama : js_sel.statuspasien,
        penanggung_cm   : js_sel.penanggung_ket, 
        nosep           : js_sel.nosep, 
      };
      console.log(jpost_cetak_tracerri);

      // let T_ajax = _ajax('POST', 'encrypt_post_cetak', jpost_cetak_tracerri );
      // console.log(T_ajax);
      
      popup_print('tracer-ri', jpost_cetak_tracerri);
      return 0;
      
    });


    $('#btn_cetak_sep_ri').click(function(e){
      e.preventDefault();
      let sep = $('#get_nosep_temp').val();
      // let nobill = $('#get_bill_siap_pakai').val();
      console.log(sep);

      let sep_cari = _ajax_bpjs("GET", "sep_cari_bpjs", {nosep: sep});
      console.log({sep_cari:sep_cari});

      let get_noka = sep_cari.response.peserta.noKartu;
      // let tgl = moment().format('YYYY-MM-DD');
      let peserta_cari = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep: moment().format('YYYY-MM-DD') });
      console.log({peserta_cari:peserta_cari});

      jpost_cetak_sep = {
        noSep   : sep,
        tglSep  : sep_cari.response.tglSep,
        noKartu : sep_cari.response.peserta.noKartu,
        nama    : sep_cari.response.peserta.nama,
        tglLahir: sep_cari.response.peserta.tglLahir,
        poli    : sep_cari.response.poli,
        diagnosa: sep_cari.response.diagnosa,
        catatan : sep_cari.response.catatan,

        noTelepon   : peserta_cari.response.peserta.mr.noTelepon,
        provPerujuk : peserta_cari.response.peserta.provUmum.nmProvider,
        jnsPelayanan: sep_cari.response.jnsPelayanan,
        kelasRawat  : sep_cari.response.kelasRawat,
        jnsPeserta  : sep_cari.response.peserta.jnsPeserta,
        asuransi    : sep_cari.response.peserta.asuransi,
        penjamin    : sep_cari.response.penjamin,
        prb         : peserta_cari.response.peserta.informasi.prolanisPRB,
      }; 

      console.log({"CETAK SEP":jpost_cetak_sep}); //return 0;
      print_preview("sep_cetak", jpost_cetak_sep);


    });



    
    // TOMBOL KHUSUS BUAT SEP RI SAJA , HIDDEN
    $('#btn_buatSepRI').click(function(e){
      e.preventDefault();

      if($('#kelas_bpjs option:selected').val() == ''){
        alert('KELAS belum diisi.');
        return 0;
      }

      nobill = $('#nobill_param').val();
      console.log(nobill);

      sep_req =                                                     
        {
          "request": {
            "t_sep": {
                "noKartu" : $('#noka_bpjs').val(), //get_noka,
                "tglSep"  : moment().format('YYYY-MM-DD'), // $('input[name=tglsep]').val(),// tglSep,
                "ppkPelayanan": config_bpjs.kode_rs,
                "jnsPelayanan": '1', // get_jnsPelayanan,
                "klsRawat"    : $('#kelas_bpjs option:selected').val(), // dropdown 123, //cari_px_bpjs.response.peserta.hakKelas.kode, // get_klsRawat,
                "noMR"        : norm, // get_norm_cm,
                "rujukan": {
                  "asalRujukan" : "2", // get_asalRujukan_bpjs, // FASKES : 1,2
                  "tglRujukan"  : moment().format('YYYY-MM-DD'), //?? get_tglRujukan,
                  "noRujukan"   : $('#noka_bpjs').val(), //?? get_norujukan,
                  "ppkRujukan"  : "0195R028", //CITRA MEDIKA // get_ppkRujukan
                },
                "catatan" : $('input[name=catatan_bpjs]').val(),
                "diagAwal": $('select[name=dx_bpjs] option:selected').val(),
                "poli": {
                  "tujuan": "",// klinik_plh.kode_bpjs, //get_poliKode_bpjs,
                  "eksekutif": "0"
                },
                "cob": {
                  "cob": "0"
                },
                "katarak": {
                  "katarak": "0"
                },
                "jaminan": {
                  "lakaLantas": "0",
                  "penjamin": {
                    "penjamin": "0",
                    "tglKejadian": "0000-00-00",
                    "keterangan": "",
                    "suplesi": {
                      "suplesi": "0",
                      "noSepSuplesi": "",
                      "lokasiLaka": {
                        "kdPropinsi": "",
                        "kdKabupaten": "",
                        "kdKecamatan": ""
                      }
                    }
                  }
                },
                "skdp": {
                  "noSurat" : $('input[name=skdp]').val(), // noskdp_bpjs,
                  "kodeDPJP": $('input[name=kd_dpjp_bpjs]').val(),
                },
                "noTelp": $('input[name=telp_bpjs]').val(),
                // "user": "16141"
                "user": config_bpjs.consid
            }
          }
        };
        //======   \ws1.1   ============

        console.log('[Data will send:: sep_create]::');
        console.log(sep_req);

        // createSepRI = _ajax_bpjs("POST", "url/POST/SEP/1.1/insert", sep_req);
        // console.log(createSepRI);
        // if(createSepRI.metaData.code!=200){
        //   alert('PESAN BPJS: ('+createSepRI.metaData.code+') '+createSepRI.metaData.message);
        // }else{
        //   console.log({createSepRI:createSepRI});
        // }

        
          // //[== CREATE SEP ==]
          sep_res = sep_create_by_noka(sep_req); //response_create_sep [LIHAT KATALOG BPJS]
          console.log("<RESPONSE CREATE SEP> sep_res");
          console.log(sep_res);

          
          if(sep_res.metaData.code == 200 ){ //bila create_sep SUKSES
            tc.sep = moment().format('HH:mm:ss');
            
            get_nosep_temp = sep_res.response.sep.noSep;
            let sep = get_nosep_temp;

            //-- UPDATE SEP RI to fotrdaftar.nosep
              let dtsep = _db_update( {NoBill : nobill}, 'fotrdaftar', {nosep:sep});
              console.log(dtsep);

              if(dtsep == null){ console.log('Edit SEP Sukses.');
              }else{ console.log('Edit SEP Gagal. Silahkan ulangi.'); }

            //\-- UPDATE SEP RI to fotrdaftar.nosep

            //-- MASUKKAN PASIEN KE CASEMIX & ENTRY HISTORI DIAGNOSA & BUAT KLAIM INA

            //\-- MASUKKAN PASIEN KE CASEMIX & ENTRY HISTORI DIAGNOSA & BUAT KLAIM INA


            //-- POPUP AUTO:CETAK SEP RI
            
              let sep_cari = _ajax_bpjs("GET", "sep_cari_bpjs", {nosep: sep});
              console.log({sep_cari:sep_cari});

              let get_noka = sep_cari.response.peserta.noKartu;
              // let tgl = moment().format('YYYY-MM-DD');
              let peserta_cari = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep: moment().format('YYYY-MM-DD') });
              console.log({peserta_cari:peserta_cari});

              jpost_cetak_sep = {
                noSep   : sep,
                tglSep  : sep_cari.response.tglSep,
                noKartu : sep_cari.response.peserta.noKartu,
                nama    : sep_cari.response.peserta.nama,
                tglLahir: sep_cari.response.peserta.tglLahir,
                poli    : sep_cari.response.poli,
                diagnosa: sep_cari.response.diagnosa,
                catatan : sep_cari.response.catatan,

                noTelepon   : peserta_cari.response.peserta.mr.noTelepon,
                provPerujuk : peserta_cari.response.peserta.provUmum.nmProvider,
                jnsPelayanan: sep_cari.response.jnsPelayanan,
                kelasRawat  : sep_cari.response.kelasRawat,
                jnsPeserta  : sep_cari.response.peserta.jnsPeserta,
                asuransi    : sep_cari.response.peserta.asuransi,
                penjamin    : sep_cari.response.penjamin,
                prb         : peserta_cari.response.peserta.informasi.prolanisPRB,
              }; 

              console.log({"CETAK SEP":jpost_cetak_sep}); //return 0;
              print_preview("sep_cetak", jpost_cetak_sep);


            //\--POPUP AUTO:CETAK SEP RI
          }else{ //bila create_sep TIDAK SUKSES
            alert('Tidak sukses daftarkan SEP. Pesan BPJS = '+sep_res.metaData.message);
            return 0;
          }
          // //[==\CREATE SEP ==]
          

    });
    // \#btn_buatSepRI.click


  }

  //***************************************************/
  //       \bo/menu/tppri/pendaftaran-ri
  //***************************************************/


  

  
  let ip = {rscmon: "https://citramedika.com/rscmon/"};
  //***************************************************/
  //        bo/menu/tppri/klaim-jr-entry
  //***************************************************/
  // function formatCurrency(num) {
  //   num = num.toString().replace(/$|,/g,");
  //   // num = num.toString().replace(/$|,/g,);
  //     if(isNaN(num))
  //        num = "0";
  //        sign = (num == (num = Math.abs(num)));
  //        num = Math.floor(num*100+0.50000000001);
  //       cents = num%100;
  //    num = Math.floor(num/100).toString();
  //      if(cents<10)
  //        cents = "0" + cents;
  //      for (var i = 0; i < Math.floor((num.length–(1+i))/3); i++)
  //          num = num.substring(0,num.length-(4*i+3))+'.'+
  //          num.substring(num.length-(4*i+3));
  //      return (((sign)?":'-') + 'Rp' + num + ',' + cents);
  //      }


  if( open_site('bo/menu/tppri/klaim-jr-entry') ){
    let _user_logged_in = $('body').data('user_logged_in');
    console.log(_user_logged_in);
    
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });
    
    $("#nobill").focus();
    
    let nobill = '';
    let cari_px = null;
    $("#nobill").keypress(function (e) { //TEKAN ENTER
      nobill = $(this).val();
      
      if (e.which == 13) {
        cari_px = _ajax('GET', 'db/m_daftarmandiri/select_fotrdaftar_by_bill/'+nobill, '');
        console.log(cari_px);

        if(cari_px.length<0){ alert("Data tidak ditemukan."); }
        else { cari_px = cari_px[0]; }

        console.log(cari_px);
        console.log(cari_px.DiagnosaAwalKet);
        

        $('#norm').val(cari_px.NoRM);
        $('#nama').val(cari_px.Nama);
        $('#TanggalMasuk').val(cari_px.TanggalMasuk);
        $('#sex').val(cari_px.Sex);
        $('#nik').val(cari_px.NoIdentitas);
        $('#TempatLahir').val(cari_px.TempatLahir);
        $('#tglLahir').val(cari_px.TglLahir);
        $('#telp').val(cari_px.Telp);
        $('#dxawal').val(cari_px.DiagnosaAwalKet);
        $('#ruang').val(cari_px.ruangJR);
        $('#statusPengajuan').val('PASIEN '+cari_px.StatusBL);
        $('#alamat').val(cari_px.Alamat);        
        
        return false;
      }
    });


    // $(".keypress").keypress(function (e) { //TEKAN ENTER
    let kp_tmp = '';
    $(".keypress").keyup(function (e) { //TEKAN ENTER
      
      console.log(e.which);
      if ((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8) {
        // keypress = $(this).val();
        // kp_tmp = $(this).val();
        kp_tmp = numeral( $(this).val() ).format('0,0');
        console.log([kp_tmp]);

        $(this).val( numeral(kp_tmp).format('0,0') );
      }else{
        $(this).val(kp_tmp);
      }      

    });


    const number = 12345678912;
    // console.log(new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(number));
    console.log(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number));
    // expected output: "123.456,79 €"
    // console.log(  numeral('159,0000').format('0,0') ); // 1,590,000

    // let exe = _ajax_web("GET", ip.rscmon+"jrklaim/db/m_jrklaim/select_list_klaim", "" );
    // console.log(exe);
        
    $('#btn_entry').click(function(e){
      e.preventDefault();
      console.log("ok");
      
      if(nobill == ''){
        alert('Nomor Billing belum diisi.');
        $('#nobill').focus();
        return false;
      }

      js_cek = _ajax_web("GET", ip.rscmon+ "jrklaim/db/m_jrklaim/select_klaim_by_nobill/"+nobill, "");
      console.log(js_cek);
      if(js_cek.length > 0){
        alert('Nomor Billing sudah pernah dientry.');
        return false;
      }else{
          
        let jPost = {
          norm  : $('#norm').val(),
          nobill: $('#nobill').val(),
          nama  : $('#nama').val(),
          tglMasuk  : $('#TanggalMasuk').val(),
          sex   : $('#sex').val(),
          nik   : $('#nik').val(),
          tempatLahir   : $('#TempatLahir').val(),
          tglLahir: $('#tglLahir').val(),
          telp    : $('#telp').val(),
          dxAwal  : $('#dxawal').val(),
          ruang   : $('#ruang').val(),
          statusPengajuan   : $('#statusPengajuan').val(),
          alamat  : $('#alamat').val(),
          tglPengajuan  : $('#tglPengajuan').val(),
          jamPengajuan  : $('#jamPengajuan').val(),
          tglLaka       : $('#tglLaka').val(),
          tkp           : $('#tkp').val(),
          statusLP      : $('#statusLP').val(),
          biayaAmbulan  : numeral( $('#biayaAmbulan').val() ).format('0'),
          biayaP3K      : numeral( $('#biayaP3K').val() ).format('0'),
          biayaPerawatan: numeral( $('#biayaPerawatan').val() ).format('0'),
          biayaAmbulanVerif   : 0,
				  biayaP3KVerif 	    : 0,
				  biayaPerawatanVerif : 0,
          user : _user_logged_in,
          date : moment().format('YYYY-MM-DD'),
          time : moment().format('HH:mm:ss'),
        };
        console.log(jPost);
        
        //BISA
        // let exe = _ajax_web("GET", ip.rscmon+"jrklaim/db/m_jrklaim/select_list_klaim", "" );
        // console.log(exe);
        
        let exe = _ajax_web("POST", ip.rscmon+"main/insert/jrlist", jPost );
        console.log(exe);

        if(exe.status=='success'){
          let exe2 = _ajax_web("POST", baseUrl()+"main/insert/jrlist", jPost );
          console.log(exe2);
          if(exe2.status=='success'){
            alert('Data berhasil dientry.');
            reload();
          }else{
            alert("Entry gagal. ("+exe2.metaData.code+") "+exe2.metaData.message);
          }
          
        }else{
          alert("Entry gagal. ("+exe.metaData.code+") "+exe.metaData.message);
        }
      }
      

    });
  }
  
  //***************************************************/
  //        \bo/menu/tppri/klaim-jr-entry
  //***************************************************/


  
  //***************************************************/
  //        bo/menu/tppri/klaim-jr-list
  //***************************************************/
    
  if( open_site('bo/menu/tppri/klaim-jr-list') ){
    let _user_logged_in = $('body').data('user_logged_in');
    console.log(_user_logged_in);
    
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });
    
    // // let ip = {rscmon: "https://citramedika.com/rscmon/"};
    // let exe = _ajax_web("GET", ip.rscmon+"jrklaim/db/m_jrklaim/select_list_klaim", "" );
    // console.log(exe);

    let tgl = '', selVerif = '';
    let js = '', brj = '';

    $("#btn_ld_jrlist").click(function(e){
      e.preventDefault();
      // tgl = $('input[name=tgl]').val();
      selVerif = $('#selVerif').val();
      console.log(selVerif);

      // js = _ajax_web("GET", baseUrl()+ "jrklaim/db/m_jrklaim/select_list_klaim", "");
      // console.log(js);

      js = _ajax_web("GET", ip.rscmon+ "jrklaim/db/m_jrklaim/select_list_klaim_by_verif/"+selVerif, "");
      console.log(js);


      let tbl = {
        id : 'tbl_jrlist_tmp',
        headers : [
          ['id','OPSI', 'style="text-align:center;"', 'button', {color : 'success', label : 'DETAIL', trigger: 'btnDetIdList'}],
          ['nobill', 'NOBILL', 'style="text-align:center;"',], 
          ['norm','NORM'], 
          ['nama','NAMA'],
          ['nik','NIK'],
          ['sex','GENDER'],
          ['tglLaka','TANGGAL LAKA'],
          ['tkp','TKP'],
          ['verif','VERIF', 'style="text-align:center;"', 'checkbox_disabled'],
          ['id','PRINT', 'style="text-align:center;"', 'button',
          {color:'info', label:'PRINT', trigger:'btnPrintIdList'}],
          ['id','HAPUS', 'style="text-align:center;"', 'button', 
            {color:'danger', label:'X', trigger:'btnDelIdList'}],
        ],
        data : js,
        button : null,
        // {
        //   color : 'success',
        //   head 	: 'OPSI',
        //   label : 'DETAIL',
        // },
      };
    
      let el_tbl = create_table_return2(tbl, js); 
      
      $('#tbl_jrlist').children().remove();
      $('#tbl_jrlist').append(el_tbl);
      $('#tbl_jrlist_tmp').DataTable({"scrollX": true});      

    });
    
    
  	$(document).on('click','#tbl_jrlist_tmp tbody tr td .btnDelIdList', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(['delete', id]);
      // return 0;
      let js_sel = js[id];
      console.log(js_sel);

      // DELETE
      if(js_sel.verif=='checked'){
        alert('Data sudah diverif, tidak boleh dihapus.');
      }else{
        del = _ajax_web("POST", ip.rscmon+ "jrklaim/delete_px/"+js_sel.id, "");
        console.log(del);

        if(del==null){
          // alert('Data berhasil dihapus.');
          // reload();
          // let exe2 = _ajax_web("POST", baseUrl()+"main/db/m_main/delete/jrlist", jPost );
          where_del = {id: js_sel.id};
          let exe2 = _ajax_web("POST", baseUrl()+"main/delete/jrlist", where_del );
          console.log(exe2);
          if(exe2==null){
            alert('Data berhasil dihapus.');
            reload();
          }else{
            alert("Data gagal dihapus.");
          }

        }else{
          alert('Data gagal dihapus.');
        }
      }      

  	});
    
    
    $(document).on('click','#tbl_jrlist_tmp tbody tr td .btnDetIdList', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(['detail', id]);
      // return 0;
      let js_sel = js[id];
      console.log(js_sel);

      
      $('#md_nobill').text(js_sel.nobill);
      $('#md_nama').text(js_sel.nama);
      $('#md_norm').text(js_sel.norm);
      $('#md_nik').text(js_sel.nik);
      $('#md_tempatLahir').text(js_sel.tempatLahir);
      $('#md_tglLahir').text(js_sel.tglLahir);
      $('#md_telp').text(js_sel.telp);
      $('#md_dxawal').text(js_sel.dxAwal);
      $('#md_ruang').text(js_sel.ruang);
      $('#md_stPengajuan').text(js_sel.statusPengajuan);
      $('#md_alamat').text(js_sel.alamat);


      $('#md_tglPengajuan').text(js_sel.tglPengajuan);
      $('#md_jamPengajuan').text(js_sel.jamPengajuan);
      $('#md_tglLaka').text(js_sel.tglLaka);
      $('#md_tkp').text(js_sel.tkp);
      $('#md_statusLP').text(js_sel.statusLP);
      $('#md_biayaAmbulan').text( numeral(js_sel.biayaAmbulan).format('0,0') );
      $('#md_biayaP3K').text( numeral(js_sel.biayaP3K).format('0,0') );
      $('#md_biayaPerawatan').text( numeral(js_sel.biayaPerawatan).format('0,0') );

      $('#md_biayaAmbulanVerif').val( numeral(js_sel.biayaAmbulanVerif).format('0,0') );
      $('#md_biayaP3KVerif').val( numeral(js_sel.biayaP3KVerif).format('0,0') );
      $('#md_biayaPerawatanVerif').val( numeral(js_sel.biayaPerawatanVerif).format('0,0') );
      $('#md_noSurat').val(js_sel.noSurat);
      $('#md_lampiran').val(js_sel.lampiran);

      $('#modal_detail_pasien').modal('show');

    });
    

    //PRINT
  	$(document).on('click','#tbl_jrlist_tmp tbody tr td .btnPrintIdList', function(e){
      e.preventDefault();
      urut = $(this).data('id');
      console.log(urut);
      // // return 0;
      // js_sel = js[urut];
      // console.log(js_sel);

      js_sel = _ajax_web("GET", ip.rscmon+ "jrklaim/db/m_jrklaim/select_klaim_by_nobill/"+js[urut].nobill, "");
      console.log(js_sel);

      if(js_sel.length>0){ js_sel = js_sel[0]; }

      if(js_sel.verif==''){
      	alert('Belum diverif.');
      	return false;
      }

      let jpost_popup = {
      	"verifDate" : js_sel.verifDate, // '2020-03-31',
				"namapx"    : js_sel.nama, // "nama_px", 
				"tglMasuk"  : js_sel.tglMasuk, // '2020-03-30',
				"gender"    : js_sel.sex, // "L", // 'js_sel.nobill',
				"usia"    	: get_umur_fx_new(js_sel.tglLahir).tahun, // "50", // 'js_sel.nobill',
				"biayaAmbulanVerif" : js_sel.biayaAmbulanVerif, // "500000",
				"biayaP3KVerif" 		: js_sel.biayaP3KVerif,  // "1000000",
				"biayaPerawatanVerif" : js_sel.biayaPerawatanVerif,  // "20000000",
				"alamat"    : js_sel.alamat, // "Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat Alamat", // 'js_sel.alamat',
				"tglLaka"   : js_sel.tglLaka,  // "2010-08-08",
				"noSurat"   : js_sel.noSurat,
      	"lampiran"  : js_sel.lampiran,
      };

      console.log(jpost_popup);

      popup_print_main('surat-jrklaim', jpost_popup);
      return 0;
  	});

  }
  
  //***************************************************/
  //        \bo/menu/tppri/klaim-jr-list
  //***************************************************/




  

  //***************************************************/
  //        bo/menu/receptionist/update-tgl-plg
  //***************************************************/
  if( open_site('bo/menu/receptionist/update-tgl-plg') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    let nosep="", tgl_sep="", nama="", tgl_plg="";
    $("input[name=nosep]").keypress(function (e) { //TEKAN ENTER
      nosep = $(this).val();
      // console.log(nosep);
      if (e.which == 13) {
        let cari_px = _ajax_bpjs("GET", "sep_cari_bpjs", {nosep:nosep});
        console.log(cari_px);
        nama = cari_px.response.peserta.nama;
        tgl_sep = cari_px.response.tglSep;
        $('input[name=nama]').val(nama);    
        $('input[name=tgl_sep]').val(tgl_sep);    
      }
    });

    
    $('#btn_upd_tgl_plg').click(function(e){
      e.preventDefault();
      
      tgl_plg = $('input[name=tgl_plg]').val();
      if(nama==""){
        alert("Nama masih kosong. Lakukan ENTER setelah memasukkan nomor SEP.");
        return 0;
      }

      if(nosep=="" && tgl_plg==""){
        alert("Semua form harus diisi.");
        return 0;
      }
      
      // let upd = _ajax_bpjs("GET", "update_tgl_pulang/"+nosep+"/"+tgl_plg, "");
      let upd = _ajax_bpjs("PUT", "update_tgl_pulang/"+nosep+"/"+tgl_plg, "");
      console.log(upd);

      if(upd.metaData.code == 200){        
        alert("Update BERHASIL.");
        reload();
      }else{
        alert("UPDATE gagal. ("+upd.metaData.code+") "+upd.metaData.message);
      }
      
    });
  }
  //***************************************************/
  //        bo/menu/receptionist/update-tgl-plg
  //***************************************************/

  //***************************************************/
  //        bo/menu/receptionist/laporan/laporan-daftaronline-web
  //***************************************************/
  if( open_site('bo/menu/receptionist/laporan/laporan-daftaronline-web') ){
    // alert('ok');
    let dt     = '',
        dt_tbl = '',
        tgl    = '';
    //Date picker
    $('.datepicker').datepicker({
    // $('#datepick').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    // $('button[name=btn_ld_daftaronline_web]').click(function(e){
    //   e.preventDefault();
    //   tgl = $('input[name=tgl_daftaronline_web]').val();
    //   console.log(tgl);
    //   //https://citramedika.com/daftaronline/model-pdo.php?kode=select_booking_1hari&date=2019-02-19
    //   // dt = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_1hari', date:tgl});
    //   dt = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
    //   ld_tbl_laporan_daftaronline_web_by_date(dt);
    // });

    dt_tbl = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
    ld_tbl_laporan_daftaronline_web_by_date(dt_tbl);

    $(document).on('click','table[name=tbl_laporan_daftaronline_web] tbody tr td button[name=btn_del_daftaronline_web]', function(){
      let get_norm = $(this).parent().parent().find('td[name=norm]').text();
      let get_date = $(this).parent().parent().find('td[name=date]').text();
      let get_time = $(this).parent().parent().find('td[name=time]').text();
      console.log([get_norm, get_date, get_time]);

      let data = {
          kode:'delete_booking_1px', 
          date: get_date,
          time: get_time,
          norm: get_norm
        };
      dt = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', data);
      console.log(dt);
      alert(dt.message);

      // dt_tbl = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_1hari', date:tgl});
      dt_tbl = _ajax_web('GET', 'https://citramedika.com/daftaronline/model-pdo.php', {kode:'select_booking_all'});
      ld_tbl_laporan_daftaronline_web_by_date(dt_tbl);
    });

  }

  //***************************************************/
  //       \bo/menu/receptionist/laporan/laporan-daftaronline-web
  //***************************************************/

  //***************************************************/
  //       bo/menu/receptionist/laporan/lap-daftarrj
  //***************************************************/
  if( open_site('bo/menu/receptionist/laporan/lap-daftarrj') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    let tgl = '';
    let js = '', brj = '';

    $("button[name=btn_ld_lap_daftarrj]").click(function(e){
      e.preventDefault();
      // $('#spin').show();
      tgl = $('input[name=tgl]').val();

      // js = _ajax("GET", "laporan_pendaftaran_px/ALL/"+tgl, "");
      js = _ajax("GET", "db/m_daftarmandiri/laporan_pendaftaran_px_soft/ALL/"+tgl, "");
      console.log(js);

      // $.ajax({
      //   async : false,
      //   type  : "GET",
      //   datatype  : "JSON",
      //   url: baseUrl()+"main/db/m_daftarmandiri/laporan_pendaftaran_px_soft/ALL/"+tgl,
      //   // cache: false,
      //   success: function(html){
      //     // $('.info').append(html);
      //     console.log(html);
      //     js = html;
      //   },
      //   complete: function(){
      //     $('#spin').hide();
      //   }
      // });
      // console.log(js);

      // let brj = _ajax_bpjs("GET", "monitoring_dt_history_pelayanan_px/"+noka+"/"+tgl+"/"+tgl, "");
      brj = _ajax_bpjs("GET", "monitoring_dt_kunjungan", {Tanggal: tgl, JnsPelayanan:2});
      console.log(brj);

      $( "div[name=tbl_lap_daftarrj]" ).scrollLeft();

      let th_list = [
          'NO.', 'NOBILL', 'ANTRIAN', 'NOSEP', 'NORM', 'NAMA', 'SEGMENT', 'LOKASI', 'PENANGGUNG', 
          // '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
        ];
      create_tbl('tbl_lap_daftarrj', th_list);

      let th_foot = '';
      for(let j=0; j<th_list.length; j++){
        th_foot += "<th></th>";
      }


      let tbl = $('table[name=tbl_lap_daftarrj]');
      tbl.find('tfoot').remove();
      tbl.append("<tfoot>"+th_foot+"</tfoot>");
      // $('table[name=tbl_lap_daftarrj]').find("tfoot").remove().append(tf_list);
      

      // $('table[name=tbl_lap_daftarrj] tfoot th').each( function () {
      //   var title = $(this).text();
      //   $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
      // } );


      let list_update_sep = [];
      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<js.length; i++){
        let update_sep = ''; 
        let lbl_sep = ''; 
        if(js[i].nosep == "0" && js[i].penanggung_kd == 'CO031'){
          update_sep = ' <button name="update" data-noka="'+js[i].noka+'" class="btn btn-success" style="padding:0px 5px;" >'+
            '<i class="glyphicon glyphicon-chevron-up"></i>'+
          '</button>';
          lbl_sep = "SEP0";
          list_update_sep.push(js[i].norm);
        }else{
          lbl_sep = js[i].nosep;
        }
        
        let el = 
        '<tr data-id="'+i+'" data-nobill="'+js[i].nobill+'" data-nosep="'+js[i].nosep+'" data-noka="'+js[i].noka+'" >'+
          '<td><button name="btn_cetak_antrian_skdp_langsung" class="btn btn-success" title="Cetak Antrian & SKDP">'+(i+1)+'</button></td>'+
          '<td><a class="mdl_detail_pasien">'+js[i].nobill+'</a></td>'+
          '<td>'+js[i].nourut+'</td>'+
          '<td>'+lbl_sep+'</td>'+
          // '<td>'+js[i].nosep+'</td>'+
          '<td>'+js[i].norm+' / '+js[i].noka+'</td>'+
          '<td>'+js[i].nama+'</td>'+
          '<td>'+js[i].segment+'</td>'+
          '<td>'+js[i].lokasi+'</td>'+
          '<td>'+js[i].penanggung_ket + update_sep+'</td>'+
        '</tr>';
        $('table[name=tbl_lap_daftarrj]>tbody').append(el);
      }

      console.log(list_update_sep);

      // DataTable
      var table = tbl.DataTable({"scrollX": true});
      // table.columns().every( function(){
      //   var that = this; 
      //   $( 'input', this.footer() ).on( 'keyup change', function(){
      //       if( that.search() !== this.value ){
      //           that.search( this.value )
      //               .draw();
      //       }
      //   });
      // });


    });

    let T_urut ="";
    
    let sep_cari="", 
        peserta_cari="";

    $(document).on('click','table[name=tbl_lap_daftarrj]>tbody>tr>td>button[name=update]', function(e){
      e.preventDefault();
      let T_sep_det = ""; //TEMP SEP DETAIL
      let nobill = $(this).parent().parent().data("nobill");
      let noka = $(this).data("noka");
      console.log([nobill, noka]);

      for (let i=0; i<brj.response.sep.length; i++) {
        if(brj.response.sep[i].noKartu == noka){
          T_sep_det = brj.response.sep[i];          
        }
      }
      console.log(T_sep_det);

      
      if(T_sep_det==""){
        alert("SEP TIDAK DITEMUKAN/DATA TIDAK SESUAI.");
      }else{
        // UPDATE NOSEP
        let update = _db_update({NoBill : nobill}, 'fotrdaftar', {nosep: T_sep_det.noSep});
        if(update == null){
          alert('Proses Update SEP Berhasil.');
          $(this).remove();
          // tambah INSERT ke>> xrec. variabelnya nobill,nosep saja 
        }else{
          alert('Proses Update Gagal. Silahkan ulangi.');
        }
      }
      
    });



    let all_log = '';
    let get_id = '',
        get_bill = '',
        get_sep  = '',
        get_noka = '',
        get_kdlokasi = '';
    let js_sel = '';
      //open modal saat klik link a
      $(document).on('click','table[name=tbl_lap_daftarrj] tbody tr td a', function(e){
        e.preventDefault();
        get_id = $(this).parent().parent().data('id');
        console.log({get_id:get_id});

        // get_kdlokasi = js[get_id]["kodelokasi"];
        get_bill= $(this).parent().parent().data('nobill');
        get_sep = $(this).parent().parent().data('nosep');
        get_noka= $(this).parent().parent().data('noka');
        // console.log([ js[get_id]["segment"] , get_bill, get_sep]);
        console.log([ js[get_id] , get_bill, get_sep]);
        // return 0;

        // if(get_sep!=0){
        //   all_log = _ajax("GET", "logdaftarrj_by_key/nosep/"+get_sep, "");
        //   console.log(all_log);
        // }

        js_sel = _ajax("GET", "db/m_daftarmandiri/laporan_pendaftaran_px_soft_by_bill/"+js[get_id]["segment"]+"/"+get_bill+"/"+js[get_id]["kodelokasi"], "");
        if(js_sel.length>0) js_sel = js_sel[0];
        console.log(js_sel);
        

        $('#modal_detail_pasien').modal('show');
        $('table[name=tbl_detail_pasien] tr td[name=nobill]').text(js_sel.nobill);
        $('table[name=tbl_detail_pasien] tr td[name=nosep]').text(js_sel.nosep);
        $('table[name=tbl_detail_pasien] tr td[name=noskdp]').text(js_sel.noskdp);
        $('table[name=tbl_detail_pasien] tr td[name=norm]').text(js_sel.norm);
        $('table[name=tbl_detail_pasien] tr td[name=nama]').text(js_sel.nama);
        $('table[name=tbl_detail_pasien] tr td[name=lokasi]').text(js_sel.lokasi);
        $('table[name=tbl_detail_pasien] tr td[name=dokter_nama]').text(js_sel.dokter_nama);
        $('table[name=tbl_detail_pasien] tr td[name=nourut]').text(js_sel.nourut);
        $('table[name=tbl_detail_pasien] tr td[name=tglrujukan]').text(js_sel.tglrujukan);
        $('table[name=tbl_detail_pasien] tr td input[name=keterangan]').val(js_sel.keterangan);
        
      });

      $('#btn_upd_ket').click(function(e){
        e.preventDefault();
        console.log(js_sel.nobill, $('input[name=keterangan]').val());
        exe_update = _db_update({NoBill:js_sel.nobill}, 'fotrdaftar', {keterangan: $('input[name=keterangan]').val()});
        console.log(exe_update);
        if(exe_update==null) alert('Data berhasil diupdate.');
        return false;
      });

      
      // TOMBOL HIJAU(NOMOR) di LIST Laporan Pendaftaran 
      $(document).on('click','table[name=tbl_lap_daftarrj] tbody tr td button[name=btn_cetak_antrian_skdp_langsung]', function(e){
        e.preventDefault();
        console.log('--> TOMBOL HIJAU(NOMOR)');
        get_id = $(this).parent().parent().data('id');
        console.log({get_id:get_id});
        console.log(js[get_id]);
        
        // // REPAIRING_RIZ
        let jpost = { url: _ADDR, button_id:$(this).attr("name"), norm_noka:'norm', nomor:js[get_id].norm,};
        // let wsprinter = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian/norm/"+js[get_id].norm, jpost);
        let wsprinter = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian", jpost);
        console.log(wsprinter);
                
      });

      
      $(document).on('click','#btn_cetak_antrian', function(e){
        e.preventDefault();
        let jpost_cetak_noantrian = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            billing   : js_sel.nobill,
            no_antrian: js_sel.nourut,
            tglrujukan: js_sel.tglrujukan,
            nama      : js_sel.nama,
            dpjp      : js_sel.dokter_nama,
            nosep     : js_sel.nosep,
          }; 

        console.log({jpost_cetak_noantrian: jpost_cetak_noantrian});
        // cetak_nomor_antrian(jpost_cetak_noantrian);
        // let js_antrian = _ajax_web("POST", baseUrl()+"print_termal/termal_nomor_antrian_new", jpost_cetak_noantrian);
        // console.log(js_antrian);

        wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/termal_nomor_antrian_new", jpost_cetak_noantrian);
        console.log(wsprinter);

      });

      $(document).on('click','#btn_cetak_skdp', function(e){
        e.preventDefault();
        let jpost_cetak_skdp = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            billing : js_sel.nobill,
            noskdp  : js_sel.noskdp,
            norm    : js_sel.norm,
            nama    : js_sel.nama,
            tglLahir: js_sel.tgllahir,
            provPerujuk : js_sel.asalPPK,
            tglSep  : js_sel.tanggalmasuk,
            dpjp    : js_sel.dokter_nama,
        };
        console.log( {jpost_cetak_skdp: jpost_cetak_skdp} );
        // let js_skdp = _ajax_web("POST", baseUrl()+"print_termal/skdp", jpost_cetak_skdp);
        // console.log(js_skdp);

        wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/skdp", jpost_cetak_skdp);
        console.log(wsprinter);
      });


      $(document).on('click','#btn_cetak_tracer', function(e){
        e.preventDefault();
        console.log(">> BTN/CETAK TRACER");
        
        // let prb_lbl_rscm = (js_sel.PRB=='1')? 'PRB': '';

        let jpost_cetak_tracer = {
          url 		  : _ADDR,
          button_id : $(this).attr("id"),
          NoBill    : js_sel.nobill,
          lokasikode: js_sel.lokasikode, // +
          segment   : js_sel.segment, // +

          no_antrian: js_sel.nourut,
          klinik    : js_sel.lokasi,
          dokter    : js_sel.dokter_nama,
          
          // NoRM      : js_sel.norm,
          // Nama      : js_sel.nama,
          // TglLahir  : js_sel.tgllahir,
          // Sex       : js_sel.jeniskelamin,
          // Alamat    : js_sel.alamat,
          // user      : _user_logged_in,
          // ket       : js_sel.keterangan,
          // umur      : js_sel.umur,
          // st_px_baru_lama : js_sel.statuspasien,
          // penanggung_cm   : js_sel.penanggung_ket, 
          // prb : js_sel.prb_str, // prb_lbl_rscm,
        };
        console.log(jpost_cetak_tracer);
        
        // let ct_tr1 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
        // console.log(ct_tr1);
        // console.log(">> CETAK TRACER 1");
        
        // let ct_tr2 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
        // console.log(ct_tr2);
        // console.log(">> CETAK TRACER 2");


        wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/tracer/2", jpost_cetak_tracer);
        console.log(wsprinter);

      });
      

      
      
      $(document).on('click','#btn_cetak_tracer_igd', function(e){
        e.preventDefault();
        console.log(">> BTN/CETAK TRACER IGD");

        let jpost_cetak_tracer = {
          url 		  : _ADDR,
          button_id : $(this).attr("id"),
          NoBill    : js_sel.nobill,
          lokasikode: js_sel.lokasikode,
          segment   : js_sel.segment, // 'IGD',
          no_antrian: js_sel.nourut,
          klinik    : js_sel.lokasi,
          dokter    : js_sel.dokter_nama,
        };
        console.log(jpost_cetak_tracer);
        
        // let ct_tr1 = _ajax_web("POST", baseUrl()+"print_termal/tracer", jpost_cetak_tracer);
        wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/tracer/1", jpost_cetak_tracer);
        console.log(wsprinter);

        console.log(">> CETAK TRACER IGD");
        // return 0;
        
      });
      
      
      $(document).on('click','#btn_cetak_tracer_rj_popup', function(e){
        e.preventDefault();
        console.log(">> BTN/CETAK TRACER");
        let jpost_cetak_tracer = {
          NoBill    : js_sel.nobill,
          NoRM      : js_sel.norm,
          no_antrian: js_sel.nourut,
          Nama      : js_sel.nama,
          TglLahir  : js_sel.tgllahir,
          Sex       : js_sel.jeniskelamin,
          Alamat    : js_sel.alamat,
          klinik    : js_sel.lokasi,
          dokter    : js_sel.dokter_nama,
          user      : _user_logged_in,
          ket       : js_sel.keterangan,
          umur      : js_sel.umur,
          st_px_baru_lama : js_sel.statuspasien,
          penanggung_cm   : js_sel.penanggung_ket, 
        };
        console.log(jpost_cetak_tracer);
        
        popup_print('tracer-rj', jpost_cetak_tracer);
        return 0;
      });


      $(document).on('click','button[name=btn_cetak_resume_sep]', function(e){
        e.preventDefault();
        console.log([get_bill,get_sep]);

        // let px_by_bill = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: js_sel.noka, tglSep:tgl});
        // console.log(px_by_bill);

        if(get_sep == 0 || get_sep == ''){
          alert("SEP 0. Tidak bisa cetak RESUME SEP.");
          return 0;
          jpost_cetak_resume_sep = {
              noSep   : '',
              norm    : js_sel.norm,
              alamat  : js_sel.alamat,
              // tglSep  : moment().format('YYYY-MM-DD'),
              tglSep  : jsObj_px_cm.datajs[0].TanggalMasuk, //?
              noKartu : '',
              nama    : '',
              nama_cm : js_sel.nama,
              tglLahir: jsObj_px_cm.datajs[0].TglLahir, //?
              poli    : '',
              diagnosa: '',
              catatan : '',
              umurSaatPelayanan : js_sel.umur,
              sex     : js_sel.jeniskelamin,

              noTelepon   : get_telp_bpjs, // ?
              provPerujuk : js_sel.asalPPK,
              jnsPelayanan: '',
              kelasRawat  : '',
              jnsPeserta  : '',
              asuransi    : '',
              penjamin    : '',

              billing     : js_sel.nobill,
              lokasi_ket  : spesialis_pilih, //?
              nama_dokter : namaDokter_pilih, //?
              penanggung_cm: get_penanggung_cm_nama, //?
              prb         : '',
          };
        }else{
          let js_sep = get_data_sep(get_sep);
          console.log(js_sep);      
          
          peserta_cari = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: js_sel.noka, tglSep:tgl});
          console.log(peserta_cari);

          jpost_cetak_resume_sep = {
              noSep   : js_sel.nosep,
              norm    : js_sel.norm,
              alamat  : js_sel.alamat,
              tglSep  : js_sep.response.tglSep,
              noKartu : js_sel.noka,
              nama    : js_sep.response.peserta.nama,
              nama_cm : js_sel.nama,
              tglLahir: js_sep.response.peserta.tglLahir,
              poli    : js_sep.response.poli,
              diagnosa: js_sep.response.diagnosa,
              catatan : js_sep.response.catatan,
              umurSaatPelayanan : js_sel.umur,
              sex     : js_sel.jeniskelamin,//peserta_cari.response.peserta.sex, //get_sex_bpjs,

              noTelepon   : peserta_cari.response.peserta.mr.noTelepon, //get_telp_bpjs,
              provPerujuk : js_sel.asalPPK,
              jnsPelayanan: js_sep.response.jnsPelayanan,
              kelasRawat  : js_sep.response.kelasRawat,
              jnsPeserta  : js_sep.response.peserta.jnsPeserta,
              asuransi    : js_sep.response.peserta.asuransi,
              penjamin    : js_sep.response.penjamin,

              billing     : js_sel.nobill,
              lokasi_ket  : js_sel.lokasi,
              nama_dokter : js_sel.dokter_nama,
              penanggung_cm: 'BPJS',
              prb         : peserta_cari.response.peserta.informasi.prolanisPRB,//prb,
              nourut      : js_sel.nourut,
              tglRujukan  : js_sel.tglrujukan,
          };
        }
        

          // //+++++++++++++++++++++++ print preview cetak_resume_sep ++++++++++++++++++++++++  
          console.log(jpost_cetak_resume_sep);
          // return 0;
          cetak_resume_sep(jpost_cetak_resume_sep);
          // cetak_resume_sep_pdf(jpost_cetak_resume_sep);

          // //+++++++++++++++++++++++ /print preview cetak_resume_sep ++++++++++++++++++++++++
      });

      $(document).on('click','button[name=btn_cetak_sep_preview]', function(e){
        e.preventDefault();
        let jpost_cetak_sep = '';
        if(get_sep != 0){
          all_log = _ajax("GET", "logdaftarrj_by_key/nosep/"+get_sep, "");
          console.log(all_log);

          if(all_log != undefined){
            let log_sep = all_log[0]["data"]["bridging"]["res_c_sep"]["response"]["sep"];
            console.log(log_sep);

            jpost_cetak_sep = {
                noSep   : log_sep.noSep,
                tglSep  : log_sep.tglSep,
                noKartu : log_sep.peserta.noKartu,
                nama    : log_sep.peserta.nama,
                tglLahir: log_sep.peserta.tglLahir,
                poli    : log_sep.poli,
                diagnosa: log_sep.diagnosa,
                catatan : log_sep.catatan,
                // provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,

                noTelepon   : all_log[0]["data"]["data_paket"]["jpost_insert_reg_cm"]["data"]["HP"],
                provPerujuk : all_log[0]["data"]["data_paket"]["jpost_insert_reg_cm"]["data"]["asalPPK"],
                jnsPelayanan: log_sep.jnsPelayanan,
                kelasRawat  : log_sep.kelasRawat,
                jnsPeserta  : log_sep.peserta.jnsPeserta,
                asuransi    : log_sep.peserta.asuransi,
                penjamin    : log_sep.penjamin,
                prb         : log_sep.informasi.prolanisPRB,
              }; 
          }else{ //bridging
            sep_cari = _ajax_bpjs("GET", "sep_cari_bpjs", {nosep: get_sep});
            console.log(sep_cari);

            peserta_cari = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep:tgl});
            console.log(peserta_cari);

            jpost_cetak_sep = {
              noSep   : get_sep,
              tglSep  : sep_cari.response.tglSep,
              noKartu : sep_cari.response.peserta.noKartu,
              nama    : sep_cari.response.peserta.nama,
              tglLahir: sep_cari.response.peserta.tglLahir,
              poli    : sep_cari.response.poli,
              diagnosa: sep_cari.response.diagnosa,
              catatan : sep_cari.response.catatan,
              // provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,

              noTelepon   : peserta_cari.response.peserta.mr.noTelepon,
              provPerujuk : peserta_cari.response.peserta.provUmum.nmProvider,
              jnsPelayanan: sep_cari.response.jnsPelayanan,
              kelasRawat  : sep_cari.response.kelasRawat,
              jnsPeserta  : sep_cari.response.peserta.jnsPeserta,
              asuransi    : sep_cari.response.peserta.asuransi,
              penjamin    : sep_cari.response.penjamin,
              prb         : peserta_cari.response.peserta.informasi.prolanisPRB,
            }; 
          }
          
        }else if(get_sep == 0){
          
        }       

        console.log("[jpost_cetak_sep]::");
        console.log(jpost_cetak_sep);
        print_preview("sep_cetak", jpost_cetak_sep);

      });


      
      // console.log(ADDR);
      $(document).on('click','#btn_cetak_antrian_skdp_1', function(e){
        e.preventDefault();
        console.log(js[get_id]);

        let jpost = { url : _ADDR, button_id : $(this).attr("id"), };
        let wsprinter = _ajax_web("POST", baseUrl()+"print_termal/cetak_skdp_antrian/norm/"+js[get_id].norm, jpost);
        console.log(wsprinter);            
      });
      
      
      // LENOVO PUTIH TOUCHSCREEN
      $(document).on('click','#btn_cetak_antrian_skdp_2', function(e){
        e.preventDefault();
              
          let jpost_cetak_noantrian = {
              url 		  : _ADDR,
              button_id : $(this).attr("id"),
              billing   : js_sel.nobill,
              no_antrian: js_sel.nourut,
              tglrujukan: js_sel.tglrujukan,
              nama      : js_sel.nama,
              dpjp      : js_sel.dokter_nama,
              nosep     : js_sel.nosep,
            }; 

          console.log({jpost_cetak_noantrian: jpost_cetak_noantrian});
          // let js_antrian = _ajax("POST", "termal_nomor_antrian_new", jpost_cetak_noantrian);
          let js_antrian = _ajax_web("POST", baseUrl()+"print_termal/termal_nomor_antrian_new", jpost_cetak_noantrian);
          console.log(js_antrian);
          

          let jpost_cetak_skdp = {
            url 		  : _ADDR,
            button_id : $(this).attr("id"),
            billing : js_sel.nobill,
            noskdp  : js_sel.noskdp,
            norm    : js_sel.norm,
            nama    : js_sel.nama,
            tglLahir: js_sel.tgllahir,
            provPerujuk : js_sel.asalPPK,
            tglSep  : js_sel.tanggalmasuk,
            dpjp    : js_sel.dokter_nama,
          };
          // console.log('[jpost_cetak_skdp]=');
          console.log({jpost_cetak_skdp: jpost_cetak_skdp});

          let js_skdp = _ajax_web("POST", baseUrl()+"print_termal/skdp", jpost_cetak_skdp);
          console.log(js_skdp);            
      });
      


  }
  //***************************************************/
  //      \bo/menu/receptionist/laporan/lap-daftarrj
  //***************************************************/




  //***************************************************/
  //       bo/menu/receptionist/laporan/lap-booking
  //***************************************************/
  if( open_site('bo/menu/receptionist/laporan/lap-booking') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    let tgl = '';
    let js = '', brj = '';
    let js_sel = '';

    let tglBooking = '';

    $('button[name=btn_ld_booking]').click(function(){
      tglBooking = $('input[name=in_tglBooking]').val();
      let jsObj_booking = _ajax("GET", "db/m_daftarmandiri/gd_booking/"+tglBooking+"/all", "" );
      console.log(jsObj_booking);
      
      js = jsObj_booking.dtjs;

      let tbl = {
        id : 'tbl_book_tmp',
        headers : [
          // ['nobill', 'NOBILL', 'style="text-align:center;"',], 
          ['time','PRINT', 'style="text-align:center;"', 'button',
          {color:'info', label:'PRINT', trigger:'btnPrintIdList'}],
          ['norm','NORM', 'style="text-align:center;"',], 
          ['noanggota','NOKA', 'style="text-align:center;"',], 
          ['nama','NAMA'],
          ['penanggungket','PENANGGUNG'],
          ['norequest','NOREQUEST'],
          ['lokasiket','LOKASI'],
          ['dokterket','DOKTER'],
          ['tgldaftar','TGL DAFTAR'],
          ['flag','FLAG'],
          ['user','USER'],
          ['time','TIME'],
          // ['verif','VERIF', 'style="text-align:center;"', 'checkbox_disabled'],
          ['time','HAPUS', 'style="text-align:center;"', 'button', 
            {color:'danger', label:'X', trigger:'btnDelIdList'}],
        ],
        data : js,
        button : null,
      };
    
      let el_tbl = create_table_return2(tbl, js); 
      
      $('#tbl_book').children().remove();
      $('#tbl_book').append(el_tbl);
      $('#tbl_book_tmp').DataTable({"scrollX": true});  

    });
    
  
    
    // let bookUtkTgl = moment('2020-04-30').add('days', 1).format('YYYY-MM-DD');
    // console.log(bookUtkTgl);


    $(document).on('click','#tbl_book_tmp tbody tr td .btnDelIdList', function(e){
      e.preventDefault();
      urut = $(this).data('id');
      console.log(urut);

      js_sel = js[urut];
      // console.log(js_sel);

      console.log( [js_sel.date, js_sel.time, js_sel.norm] );

      let jPost = _ajax("POST", "db/m_daftarmandiri/delete_booking/"+js_sel.date+"/"+js_sel.time+"/"+js_sel.norm, "");
      console.log(jPost);

    });

    $(document).on('click','#tbl_book_tmp tbody tr td .btnPrintIdList', function(e){
      e.preventDefault();
      urut = $(this).data('id');
      console.log(urut);

      js_sel = js[urut];
      console.log(js_sel);

      // let pdp = (js_sel.PDP =="1" && parseInt(js_sel.PDPSelisihHari)<15 ) ? "Z038": "";
      let jpost_cetak_tracer = {
        // NoBill    : "BOOK"+ moment(js_sel.date).add('days', 1).format('YYYY-MM-DD'),
        url 		  : _ADDR,
        button_id : 'btnPrintIdList', // $(this).attr("id"),
        // NoBill    : js_sel.nobill_book_tracer, //tglbook??
        NoBill    : js_sel.norm, //tglbook??
        lokasikode: js_sel.kd_lokasi,
        segment   : 'BOOK_RJ',
        // tgldaftar : js_sel.tgldaftar,
        no_antrian: js_sel.norequest,
        klinik    : js_sel.lokasiket,
        dokter    : js_sel.dokterket,
      };
      console.log(jpost_cetak_tracer);
      // return false;
            
      wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/tracer/2", jpost_cetak_tracer);
      console.log(wsprinter);

      return false;

    });




    // $('button[name=btn_del_booking]').click(function(){
    //   tglBooking = $('input[name=in_tglBooking]').val();
    //   console.log('delete tanggal booking: '+tglBooking);
    //   alert(delete_booking_by_date(tglBooking) );
    //   window.location.reload(true);
    // });

    $('button[name=btn_dl_booking_xls]').click(function(){
      tglBooking = $('input[name=in_tglBooking]').val();
      download_booking_xls(tglBooking);
    });

  }
  //***************************************************/
  //      \bo/menu/receptionist/laporan/lap-booking
  //***************************************************/

  
  
  
  //************************************************************/
  //       bo/menu/receptionist/laporan/log-pendaftaranrj
  //************************************************************/
    
  if( open_site('bo/menu/receptionist/laporan/log-pendaftaranrj') ){
    console.log('ok');
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    let in_tgl = moment().format('YYYY-MM-DD');
    $('input[name=in_tgl]').val( in_tgl );
    

      let jsObj_log = _ajax("GET", "logdaftarrj_by_key/pendaftaran-rjri/"+in_tgl, "");
      console.log('[gd_logpendaftaranrj_by_date]::');
      console.log(jsObj_log);

      // let paket = jsObj_log[0].data;
      // console.log(paket);
      // console.log(paket.data_utama.norm);

      
      let jsObj_pasienrj = gd_pasienrj_by_date(in_tgl);
      console.log(jsObj_pasienrj);

      $('div[name=div_val]').children().remove();

      let el_new_tbl = 
      '<table class="table table-bordered" name="tbl_val">'+
        '<thead>'+
          '<tr>'+
            '<td>No.</td> <td>Billing</td>'+
            '<td>NoRM</td> <td>Nama</td>'+
            '<td>Status Rec</td>'+
            '<td>Date</td> <td>Time</td> <td>User</td>'+
          '</tr>'+
        '</thead>'+
        '<tbody></tbody>'+
      '</table>';
      $('div[name=div_val]').append(el_new_tbl);


      //$('table[name=tbl_pasien_daftarrj] tbody').children().remove();
      for(let i=0; i<jsObj_log.length; i++){
        let st_rec = jsObj_log[i].data.time_create.tc_insert_daftar_rj;
        if(st_rec == '' ){
          st_rec = 'bill_no_record';
        }


        let el = 
          '<tr data-id="'+jsObj_log[i].Id+'">'+
            '<td>'+(i+1)+'</td>'+
            '<td>'+jsObj_log[i].data.data_utama.billing+'</td>'+
            '<td>'+jsObj_log[i].data.data_utama.norm+'</td>'+
            '<td><a class="mdl_log_daftarrj">'+jsObj_log[i].data.data_utama.nama+'</a></td>'+
            '<td>'+st_rec+'</td>'+
            '<td>'+jsObj_log[i].date+'</td>'+
            '<td>'+jsObj_log[i].time+'</td>'+
            '<td>'+jsObj_log[i].user+'</td>'+
          '</tr>';
        $('table[name=tbl_val] tbody').append(el);
      }

      $('table[name=tbl_val]').DataTable();



    

    $('input[name=in_tgl]').change(function(){
      in_tgl = $(this).val();
      ld_tbl(in_tgl);
    });

    //open modal saat klik link a
    $(document).on('click','table[name=tbl_val] tbody tr td a', function(e){
      e.preventDefault();
      let get_id = $(this).parent().parent().data('id');
      console.log(get_id);

      $('#mdl_log_daftarrj').modal('show');

      let js = gd_logpendaftaranrj_by_id(get_id);

      let dt = js.dtjs[0].data; //isi di db dg field "data" berupa format string 
      let new_dt = JSON.stringify( JSON.parse(dt) , null, 4); // untuk cetak di <pre> , supaya json viewernya bagus 

      console.log(js);
      $('pre[name=val_js_all]').text(new_dt);
                    
    });

  }

  

  
  //************************************************************/
  //       \bo/menu/receptionist/laporan/log-pendaftaranrj
  //************************************************************/


  //***************************************************/
  //       bo/menu/receptionist/laporan/lap-lain
  //***************************************************/
  if( open_site('bo/menu/receptionist/laporan/lap-lain') ){
    let _user_logged_in = $('body').data('user_logged_in');
    let _user_daftar = _user_logged_in;

    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    let js = '';

    $("button[name=btn_ld_lap_lain]").click(function(e){
      e.preventDefault();
      let tgl_start = $('input[name=tgl_start]').val();
      let tgl_end   = $('input[name=tgl_end]').val();
      console.log([tgl_start, tgl_end]);

      js = _ajax("GET", "dl_xls_sukubangsa_kosong/"+tgl_start+"/"+tgl_end+"/0", "");
      console.log(js);

      let th_list = [
          'NO.', 'NOBILL', 'NORM', 'NAMA', 'STATUS DAFTAR', 'DATE', 'USER', 
          // '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
        ];
      create_tbl('tbl_lap_lain', th_list);

      for(let i=0; i<js.length; i++){
        let el = 
        '<tr data-nobill="'+js[i].nobill+'" data-nosep="'+js[i].nosep+'" >'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+js[i].NoBill+'</td>'+
          '<td>'+js[i].NoRM+'</td>'+
          '<td>'+js[i].Nama+'</td>'+
          '<td>'+js[i].StatusDaftar+'</td>'+
          '<td>'+js[i].Date+'</td>'+
          '<td>'+js[i].User+'</td>'+
        '</tr>';
        $('table[name=tbl_lap_lain]>tbody').append(el);
      }
      $('table[name=tbl_lap_lain]').DataTable();

    });

    $("button[name=btn_ld_lap_agama]").click(function(e){
      e.preventDefault();
      let tgl_start_agama = $('input[name=tgl_start_agama]').val();
      let tgl_end_agama   = $('input[name=tgl_end_agama]').val();
      console.log([tgl_start_agama, tgl_end_agama]);


      js = _ajax("GET", "dl_xls_agama_kosong/"+tgl_start_agama+"/"+tgl_end_agama+"/0", "");
      console.log(js);

      let th_list = [
          'NO.', 'NOBILL', 'NORM', 'NAMA', 'STATUS DAFTAR', 'DATE', 'USER', 
          // '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
        ];
      create_tbl('tbl_lap_agama', th_list);

      for(let i=0; i<js.length; i++){
        let el = 
        '<tr data-nobill="'+js[i].nobill+'" data-nosep="'+js[i].nosep+'" >'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+js[i].NoBill+'</td>'+
          '<td>'+js[i].NoRM+'</td>'+
          '<td>'+js[i].Nama+'</td>'+
          '<td>'+js[i].StatusDaftar+'</td>'+
          '<td>'+js[i].Date+'</td>'+
          '<td>'+js[i].User+'</td>'+
        '</tr>';
        $('table[name=tbl_lap_agama]>tbody').append(el);
      }
      $('table[name=tbl_lap_agama]').DataTable();

    });
  }


  //***************************************************/
  //      \bo/menu/receptionist/laporan/lap-lain
  //***************************************************/


  //***************************************************/
  //        bo/menu/manajemen/dashboard-manajemen
  //***************************************************/
  if( open_site('bo/menu/manajemen/dashboard-manajemen') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });
    
    let tgl_start = '',
        tgl_end   = '';
    
    $('#btn_dl_rincianKlinikSP').click(function(e){
      e.preventDefault();
      console.log('rincian SP');
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();

      // let dt_perklinik = _ajax_web("GET", baseUrl()+"manajemen/select_kunjunganrj_px_tiapklinik_by_rangehari/"+tgl_start+"/"+tgl_end, "");
      window.open(baseUrl()+'manajemen/select_kunjunganrj_px_tiapklinik_by_rangehari/'+tgl_start+'/'+tgl_end+'/1', '');
      
    });


    $('button[name=btn_ld_dboard_mnj_visit_rj]').click(function(e){
      e.preventDefault();
      console.log('>>RJ_LOAD');
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      console.log([tgl_start,tgl_end]);
      

      
      let mnj_rj = _ajax_web("GET", baseUrl()+"manajemen/dboard_mnj_rj/"+tgl_start+"/"+tgl_end, "");

      //++++++++++++ BOX: Rincian Tiap Klinik Spesialis +++++++++++++
      let dt_perklinik = mnj_rj.dt_perklinik;
      console.log(dt_perklinik);
      let tot_rincian_grf_bar_kunjungan_klinik_1hari = 0;
      for(let i=0; i<dt_perklinik.length; i++){
        tot_rincian_grf_bar_kunjungan_klinik_1hari += parseInt(dt_perklinik[i].jml_px_all);
      }

      $('span[name=tot_rincian_grf_bar_kunjungan_klinik_1hari]').text(tot_rincian_grf_bar_kunjungan_klinik_1hari);

      chartjs_pie( dt_perklinik, 'grf_bar_kunjungan_klinik_1hari', 'jml_px_all', 'lokasiket');
      // return false;
      //++++++++++++\BOX: Rincian Tiap Klinik Spesialis +++++++++++++

      //++++++++++++ BOX: Rincian Tiap Dokter Spesialis +++++++++++++
      let dt_per_sp = mnj_rj.dt_per_sp;
      console.log(dt_per_sp);

      let th_list = [
          'No.', 'Kode', 'Nama Dokter', 'Lokasi', 'Jumlah Kunjungan', 
          // '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
        ];
      create_tbl('tbl_kunjungan_px_to_sp_by_1hari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_per_sp.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_per_sp[i].Dokter+'</td>'+
          '<td>'+dt_per_sp[i].nama_dokter+'</td>'+
          '<td>'+dt_per_sp[i].Keterangan+'</td>'+
          '<td>'+dt_per_sp[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_kunjungan_px_to_sp_by_1hari]>tbody').append(el);
      }

      progress_bar(".progress", 30, "Selesai Load: Rincian Tiap Dokter Spesialis");
      //++++++++++++\BOX: Rincian Tiap Dokter Spesialis +++++++++++++


      //++++++++++++ BOX: Rincian Tiap Penanggung +++++++++++++
      let dt_penanggung = mnj_rj.dt_penanggung;
      console.log(dt_penanggung);
      chartjs_pie( dt_penanggung, 'grf_donat_kunjungan_px_penanggung_by_rangehari', 'jml_px_all', 'penanggung');
      
      let tot = 0;
      for(let i=0; i<dt_penanggung.length; i++){
        tot += parseInt(dt_penanggung[i].jml_px_all);
      }
      $('span[name=tot_kunjungan_px_penanggung_by_rangehari]').text(tot);
      //++++++++++++ BOX: Rincian Tiap Penanggung +++++++++++++


      //++++++++++++ BOX: Rincian Tiap Demografi +++++++++++++
      //++ SUKU BANGSA ++
      let dt_suku = mnj_rj.dt_suku;
      console.log(dt_suku);
      chartjs_pie( dt_suku, 'grf_donat_kunjungan_px_demografi_suku_by_rangehari', 'jml_px_all', 'Sukubangsa');
      //++\SUKU BANGSA ++

      //++ AGAMA ++
      let dt_agama = mnj_rj.dt_agama;
      console.log(dt_agama);
      chartjs_pie( dt_agama, 'grf_donat_kunjungan_px_demografi_agama_by_rangehari', 'jml_px_all', 'Agama');
      //++\AGAMA ++

      //++ WILAYAH ++
      let dt_wilayah = mnj_rj.dt_wilayah;
      console.log(dt_wilayah);
      //tbl_kunjungan_px_demografi_kec_top10_by_rangehari

      th_list = ['No.', 'Kecamatan', 'Kota/Kabupaten', 'Jumlah Kunjungan'];
      create_tbl('tbl_kunjungan_px_demografi_kec_top10_by_rangehari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_wilayah.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_wilayah[i].kec+'</td>'+
          '<td>'+dt_wilayah[i].kota+'</td>'+
          '<td>'+dt_wilayah[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_kunjungan_px_demografi_kec_top10_by_rangehari]>tbody').append(el);
      }
      //++\WILAYAH ++

      //++++++++++++\BOX: Rincian Tiap Demografi +++++++++++++


    });



    
    $('button[name=btn_ld_dboard_mnj_visit_ri]').click(function(e){
      e.preventDefault();
      console.log('>>RI_LOAD');
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      console.log([tgl_start,tgl_end]);

      let mnj_ri = _ajax_web("GET", baseUrl()+"manajemen/dboard_mnj_ri/"+tgl_start+"/"+tgl_end, "");
      console.log(mnj_ri);

      // ========
      // START RI
      //++++++++++++ BOX RI: Rincian Tiap Penanggung +++++++++++++
      let dt_penanggungri = mnj_ri.dt_penanggungri;

      let tot_rincian_grf_donat_kunjunganri_penanggung_rangehari = 0;
      for(let i=0; i<dt_penanggungri.length; i++){
        tot_rincian_grf_donat_kunjunganri_penanggung_rangehari += parseInt(dt_penanggungri[i].jml_px_all);
      }

      $('span[name=tot_rincian_grf_donat_kunjunganri_penanggung_rangehari]').text(tot_rincian_grf_donat_kunjunganri_penanggung_rangehari);

      chartjs_pie( dt_penanggungri, 'grf_donat_kunjunganri_px_penanggung_by_rangehari', 'jml_px_all', 'penanggung');

      progress_bar(".progress", 55, "Selesai Load: Rincian Tiap Penanggung");
      //++++++++++++\BOX RI: Rincian Tiap Penanggung +++++++++++++

      //++++++++++++ BOX RI: Rincian Tiap Kamar +++++++++++++
      let dt_kamar = mnj_ri.dt_kamar;

      th_list = ['No.', 'Nama Kamar', 'Jumlah Kunjungan'];
      create_tbl('tbl_select_kunjunganri_px_kmr_by_rangehari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_kamar.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_kamar[i].keterangan+'</td>'+
          '<td>'+dt_kamar[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_select_kunjunganri_px_kmr_by_rangehari]>tbody').append(el);
      }

      progress_bar(".progress", 65, "Selesai Load: Rincian Tiap Kamar");
      //++++++++++++\BOX RI: Rincian Tiap Kamar +++++++++++++

      //++++++++++++ BOX RI: Rincian Tiap Demografi +++++++++++++
      //++ SUKU BANGSA ++
      let dt_suku_ri = mnj_ri.dt_suku_ri;
      chartjs_pie( dt_suku_ri, 'grf_donat_select_kunjunganri_px_demografi_suku_by_rangehari', 'jml_px_all', 'Sukubangsa');
      //++\SUKU BANGSA ++

      //++ AGAMA ++
      let dt_agama_ri = mnj_ri.dt_agama_ri;
      chartjs_pie( dt_agama_ri, 'grf_donat_select_kunjunganri_px_demografi_agama_by_rangehari', 'jml_px_all', 'Agama');
      //++\AGAMA ++

      //++ WILAYAH ++
      let dt_wilayah_ri = mnj_ri.dt_wilayah_ri;
      //tbl_kunjungan_px_demografi_kec_top10_by_rangehari

      th_list = ['No.', 'Kecamatan', 'Kota/Kabupaten', 'Jumlah Kunjungan'];
      create_tbl('tbl_select_kunjunganri_px_demografi_kec_top10_by_rangehari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_wilayah_ri.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_wilayah_ri[i].kec+'</td>'+
          '<td>'+dt_wilayah_ri[i].kota+'</td>'+
          '<td>'+dt_wilayah_ri[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_select_kunjunganri_px_demografi_kec_top10_by_rangehari]>tbody').append(el);
      }
      //++\WILAYAH ++

      //++++++++++++\BOX RI: Rincian Tiap Demografi +++++++++++++


      //++++++++++++ BOX RI: Rincian Diagnosa RI +++++++++++++
      let dt_dx_ri = mnj_ri.dt_dx_ri;

      th_list = ['No.', 'ICD Kode', 'ICD Ket', 'Jumlah Kunjungan'];
      create_tbl('tbl_select_kunjunganri_px_dx_top10_by_rangehari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_dx_ri.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_dx_ri[i].ICDKode+'</td>'+
          '<td>'+dt_dx_ri[i].ICDKet+'</td>'+
          '<td>'+dt_dx_ri[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_select_kunjunganri_px_dx_top10_by_rangehari]>tbody').append(el);
      }

      progress_bar(".progress", 100, "Selesai Load: Rincian Diagnosa RI");

      //++++++++++++\BOX RI: Rincian Diagnosa RI +++++++++++++


    });

      
  }

  //***************************************************/
  //       \bo/menu/manajemen/dashboard-manajemen
  //***************************************************/


  //***************************************************/
  //        bo/menu/manajemen/morbiditas
  //***************************************************/
  if( open_site('bo/menu/manajemen/morbiditas') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $(".datepicker-bln").datepicker({      
      format  : 'yyyy-mm',
      startView: "months", 
      minViewMode: "months"
    });

    let tgl_start = '',
        tgl_end   = '';

    let icd_param = '',
        kode_icd  = '',
        thn_icd   = '';


    $('button[name=btn_ld_morbiditas]').click(function(e){
      e.preventDefault();
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      console.log([tgl_start,tgl_end]);

      //++++++++++++ BOX RI: Rincian Diagnosa RI +++++++++++++
      let dt_dx_ri = _ajax_web("GET", baseUrl()+"main/db/m_daftarmandiri/select_kunjunganri_px_dx_top10_by_rangehari_n/"+tgl_start+"/"+tgl_end, "");
      console.log(dt_dx_ri);

      th_list = ['No.', 'ICD Kode', 'ICD Ket', 'Jumlah Kunjungan'];
      create_tbl('tbl_select_kunjunganri_px_dx_top10_by_rangehari', th_list);

      // create tbl_kunjungan_px_to_sp_by_1hari>tbody
      for(let i=0; i<dt_dx_ri.length; i++){
        let el = 
        '<tr>'+
          '<td>'+(i+1)+'</td>'+
          '<td>'+dt_dx_ri[i].ICDKode+'</td>'+
          '<td>'+dt_dx_ri[i].ICDKet+'</td>'+
          '<td>'+dt_dx_ri[i].jml_px_all+'</td>'+
        '</tr>';
        $('table[name=tbl_select_kunjunganri_px_dx_top10_by_rangehari]>tbody').append(el);
      }

      //++++++++++++\BOX RI: Rincian Diagnosa RI +++++++++++++

    });


    $("input[name=kode_icd]").keypress(function (e) { //TEKAN ENTER
      icd_param = $(this).val();
      if (e.which == 13) {
        let js = _ajax_web("POST", baseUrl()+"eclaim/ajax_eclaim/search_diagnosis/"+icd_param, "");
        console.log(js);      

        $('select[name=sel_icd]').children().remove();
        for(let i=0; i<js.response.count; i++){
          $('select[name=sel_icd]').append('<option value="'+js.response.data[i][1]+'">'+js.response.data[i][1]+' - '+js.response.data[i][0]+'</option>');
        }
      }
    });

    $('select[name=sel_icd]').on('change', function(e){
      e.preventDefault();
      kode_icd = $(this).val();
    });

    $('button[name=btn_ld_grf_line_morbiditas]').click(function(e){
      e.preventDefault();
      kode_icd = $('select[name=sel_icd]').val();
      thn_icd   = $('input[name=thn_icd]').val();
      console.log([kode_icd,thn_icd]);

      let dt_icd_th = _ajax("GET", "select_kunjunganri_px_dx_by_icd_thn/"+kode_icd+"/"+thn_icd, "");
      console.log(dt_icd_th);

      let dt_jml_px_1th = [];
      for(let i=0; i<dt_icd_th.length; i++){
        dt_jml_px_1th.push(dt_icd_th[i].jml_px_all);
      }

      let jPost_data_grf = [dt_jml_px_1th];
      let list_grf = [kode_icd];
      chartjs_line('grf_line_morbiditas_1th_1icd', jPost_data_grf, list_grf);
    });

      
  }
  //***************************************************/
  //       \bo/menu/manajemen/morbiditas
  //***************************************************/



  //***************************************************/
  //        bo/menu/manajemen/info-tt-mnj
  //***************************************************/
  if( open_site('bo/menu/manajemen/info-tt-mnj') ){
    let tt = _ajax_web("GET", baseUrl()+"main/db/m_bed/cnt_info_tt_rs", "")
    console.log(tt);
    
    let tbl = {
      id : 'tbl_ld_tbl_tt',
      headers : [
        ['namaRuang', 'NAMA RUANG'], 
        ['jml_bayangan','BAYANGAN', "style='text-align:center;'"],
        ['jml_checkout','CHECKOUT', "style='text-align:center;'"],
        ['jml_in','TERPAKAI', "style='text-align:center;'"],
        ['jml_inAddBayangan','TOTAL', "style='text-align:center;'"],
      ],
      data : tt.list,
      button : null,
    };
  
    let el_tbl = create_table_return(tbl, tt.list);
    $("#ld_tbl_tt").append(el_tbl);

    let footer = "<tfoot><tr>"+
        "<th style='text-align:center;'>TOTAL</th>"+
        "<th style='text-align:center;'>"+tt.sum.jml_bayangan+"</th>"+
        "<th style='text-align:center;'>"+tt.sum.jml_checkout+"</th>"+
        "<th style='text-align:center;'>"+tt.sum.jml_in+"</th>"+
        "<th style='text-align:center;'>"+tt.sum.jml_inAddBayangan+"</th>"+
      "</tr></tfoot>"
    $("#ld_tbl_tt>table").append(footer);

  }
  //***************************************************/
  //        bo/menu/manajemen/info-tt-mnj
  //***************************************************/


  
  //***************************************************/
  //        bo/menu/manajemen/efihuni-tt/efihuni-tt-bln
  //***************************************************/
  if( open_site('bo/menu/manajemen/efihuni-tt/efihuni-tt-bln') ){
    $(".datepicker-bln").datepicker({
      autoclose : true,
      format  : 'yyyy-mm',
      startView: "months", 
      minViewMode: "months"
    });

    let get_date = '',
        bln_hunian_1bln = '',
        thn_hunian_1thn = '';

    let lbl_det = ["HP", "LD", "KHM", "dead<48", "dead>=48", "dead", "hidup"];
    let lbl_stat = ["TT", "BOR", "LOS", "TOI", "BTO", "GDR", "NDR"];
    let tot_tbl = 
      [
        {
          "HP":0, "LD":0, "KHM":0, 
          "dead<48":0, "dead>=48":0,
          "dead":0, "hidup":0
        }
      ]
    ;
    
    let cek_statistik_inserted = '', 
        js_huni_all = '', 
        js_huni = '';
    let idx_kmr_huni = []; // utk kebutuhan cari index array by nama kamar
    let T = 0; //periode

    let el_foot_arr = '',
        el_foot     = '';

    $('button[name=btn_tbl_hunian_1bln]').click(function(e){
      e.preventDefault();
      get_date = $('input[name=date_hunian_1bln]').val();
      if(get_date==''){
        alert("Kolom isian belum diisi.");
      }else{
        bln_hunian_1bln = get_date.split('-')[1];
        thn_hunian_1thn = get_date.split('-')[0];
        console.log([bln_hunian_1bln, thn_hunian_1thn]);

        $("span[name=efi_huni_date]").text(bulan_indo(bln_hunian_1bln)+" "+thn_hunian_1thn);

        cek_statistik_inserted = _ajax("GET", "cek_statistik_inserted/"+thn_hunian_1thn+"/"+bln_hunian_1bln, "");
        console.log(cek_statistik_inserted);


        // [BOX: EFISIENSI HUNIAN]
          js_huni_all = _ajax_web("GET", baseUrl()+"main/db/m_daftarmandiri/select_efihuni_det_by_bln_thn/"+thn_hunian_1thn+"/"+bln_hunian_1bln, "");
          js_huni = js_huni_all.list;
          console.log(js_huni);

          th_list = ['No.', 'Nama Kelas', 'HP', 'LD', 'KHM', 'MATI<48', 'MATI>=48', 'MATI', 'HIDUP'];
          create_tbl('tbl_select_hunian_1bln', th_list);
          
          for(let i=0; i<js_huni.length; i++){
            idx_kmr_huni.push(js_huni[i].kls_mor);

            let el = 
            '<tr>'+
              '<td>'+(i+1)+'</td>'+
              '<td>'+js_huni[i].kls_mor+'</td>'+
              '<td>'+js_huni[i].detail['HP']+'</td>'+
              '<td>'+js_huni[i].detail['LD']+'</td>'+
              '<td>'+js_huni[i].detail['KHM']+'</td>'+
              '<td>'+js_huni[i].detail['dead<48']+'</td>'+
              '<td>'+js_huni[i].detail['dead>=48']+'</td>'+
              '<td>'+js_huni[i].detail['dead']+'</td>'+
              '<td>'+js_huni[i].detail['hidup']+'</td>'+
            '</tr>';
            $('table[name=tbl_select_hunian_1bln]>tbody').append(el);

            // SUM TABEL[0]
            
            for(let l=0; l<lbl_det.length; l++){
              tot_tbl[0][lbl_det[l]] += parseInt(js_huni[i].detail[lbl_det[l]]); 
            }

          }
          console.log(tot_tbl);

          
          el_foot_arr = '';
          for(let l=0; l<lbl_det.length; l++){
            // el_foot_arr += '<th>'+tot_tbl[0][lbl_det[l]]+'</th>'; // LAMA
            el_foot_arr += '<th>'+js_huni_all.jumlah[lbl_det[l]]+'</th>';
          }

          el_foot = '<tfoot>'+
            '<tr>'+
              '<th></th>'+
              '<th>TOTAL</th>'+el_foot_arr+
            '</tr>'+
          '</tfoot>';

          $('table[name=tbl_select_hunian_1bln]').append(el_foot);
        // \[BOX: EFISIENSI HUNIAN]




        //  [BOX: STATISTIK]
          th_list = ['No.', 'Nama Kelas', 'TT', 'BOR', 'LOS', 'TOI', 'BTO', 'GDR', 'NDR'];
          create_tbl('tbl_dt_statistik_hunian_1bln', th_list);        
                
          for(let i=0; i<js_huni_all.list.length; i++){
            // //SEARCH ID in ARRAY
            // let idx_kmr = $.inArray( js_tt.list[i].namaKelas, idx_kmr_huni );
            // js_tt.list[i].detail = js_huni[idx_kmr].detail;
            let el = 
            '<tr>'+
              '<td>'+(i+1)+'</td>'+
              '<td>'+js_huni_all.list[i].kls_mor+'</td>'+
              '<td>'+js_huni_all.list[i].TT+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['BOR']+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['LOS']+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['TOI']+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['BTO']+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['GDR']+'</td>'+
              '<td>'+js_huni_all.list[i]['stat']['NDR']+'</td>'+
            '</tr>';
            $('table[name=tbl_dt_statistik_hunian_1bln]>tbody').append(el);
          }

          el_foot_arr = '';
          for(let l=0; l<lbl_stat.length; l++){
            el_foot_arr += '<th>'+js_huni_all.jumlah[lbl_stat[l]]+'</th>';
          }

          el_foot = '<tfoot>'+
            '<tr>'+
              '<th></th>'+
              '<th>TOTAL</th>'+el_foot_arr+
            '</tr>'+
          '</tfoot>';

          $('table[name=tbl_dt_statistik_hunian_1bln]').append(el_foot);
        // \[BOX: STATISTIK]

        // alert("Load data selesai.");
        Swal.fire({
          position: 'center',
          type : 'success',
          title: "Load data selesai.",
          showConfirmButton: true
        });
      }

    });



    $('button[name=btn_dl_xls_efihuni_1bln]').click(function(e){
      e.preventDefault();
      get_date = $('input[name=date_hunian_1bln]').val();
      bln_hunian_1bln = get_date.split('-')[1];
      thn_hunian_1thn = get_date.split('-')[0];
      console.log([bln_hunian_1bln, thn_hunian_1thn]);

      if($('input[name=date_hunian_1bln]').val() == ''){
        alert('Kolom kalender tidak boleh kosong.');
      }else{
        window.open(baseUrl()+'ajaxreq/dl_xls_stat_hospital/'+thn_hunian_1thn+'/'+bln_hunian_1bln+'/1');
      }
    });


    $('button[name=btn_simpan_efihuni_1bln]').click(function(e){
      e.preventDefault();
      get_date = $('input[name=date_hunian_1bln]').val();
      bln_hunian_1bln = get_date.split('-')[1];
      thn_hunian_1thn = get_date.split('-')[0];
      console.log([bln_hunian_1bln, thn_hunian_1thn]);

      cek_statistik_inserted = _ajax("GET", "cek_statistik_inserted/"+thn_hunian_1thn+"/"+bln_hunian_1bln, "");
      console.log(cek_statistik_inserted);
      let status = cek_statistik_inserted.status;

      if(status=="update"){
        Swal.fire({
          title: cek_statistik_inserted.message,
          text: "",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, UPDATE!'
        }).then((result) => {
          if (result.value) {
            // OK >> insert
            js_exe = _ajax("GET", "execute_statistik/update/"+thn_hunian_1thn+"/"+bln_hunian_1bln, "");
            console.log(js_exe);
            console.log("PROSES UPDATE SUKSES.");
            if(js_exe == null){
              Swal.fire({
                position: 'center',
                type : 'success',
                title: "PROSES UPDATE SUKSES.",
                showConfirmButton: true
              });
            }else{
              alert("error");
            }
          }
        });
        
      }else if(status=="insert"){ // insert
        js_exe = _ajax("GET", "execute_statistik/insert/"+thn_hunian_1thn+"/"+bln_hunian_1bln, ""); 
        if(js_exe == null){
          Swal.fire({
            position: 'center',
            type : 'success',
            title: "Data berhasil tersimpan.",
            showConfirmButton: true
          });
        }else{
          alert("error");
        }
      }
 
    });



  }
  //***************************************************/
  //       \bo/menu/manajemen/efihuni-tt/efihuni-tt-bln
  //***************************************************/


  //***************************************************/
  //        bo/menu/manajemen/efihuni-tt/efihuni-tt-thn
  //***************************************************/
  if( open_site('bo/menu/manajemen/efihuni-tt/efihuni-tt-thn') ){
    $(".datepicker-bln").datepicker({
      autoclose : true,
      format  : 'yyyy',
      startView: "years", 
      minViewMode: "years"
    });

    let get_th = '';
    let js;

    let TT_default = 122;

    $("button[name=btn_ld_grf]").click(function(e){
      e.preventDefault();

      get_th = $('input[name=date_hunian_1bln]').val();
      $("span[name=efi_huni_date]").text(get_th);

      let jss = _ajax_web("GET", baseUrl()+"main/db/m_manajemen/select_statistik_det/"+get_th, "");
      let js = jss.list;
      console.log(js);

      let js_last_th = _ajax_web("GET", baseUrl()+"main/db/m_manajemen/select_statistik/"+(get_th-1), "");
      console.log(js_last_th);

      let thead_list = ["BULAN", "TT", "HP", "LD", "KHM", "MATI<48", "MATI>48", "MATI", "HIDUP", "BOR", "LOS", "TOI", "BTO", "GDR", "NDR"];
      create_tbl("tbl_efihuni_1th", thead_list);

      // create tbl_user_checkbox>tbody
      for(let i=0; i<js.length; i++){
        let el = 
        '<tr>'+
          '<td>'+js[i]["bulan"]+'</td>'+
          // '<td>'+js[i]["TT"]+'</td>'+
          '<td>'+TT_default+'</td>'+
          '<td>'+js[i]["HP"]+'</td>'+
          '<td>'+js[i]["LD"]+'</td>'+
          '<td>'+js[i]["KHM"]+'</td>'+
          '<td>'+js[i]["dead_krg48"]+'</td>'+
          '<td>'+js[i]["dead_lbh48"]+'</td>'+
          '<td>'+js[i]["dead"]+'</td>'+
          '<td>'+js[i]["hidup"]+'</td>'+
          '<td>'+js[i]["BOR"]+'</td>'+
          '<td>'+js[i]["LOS"]+'</td>'+
          '<td>'+js[i]["TOI"]+'</td>'+
          '<td>'+js[i]["BTO"]+'</td>'+
          '<td>'+js[i]["GDR"]+'</td>'+
          '<td>'+js[i]["NDR"]+'</td>'+
          // '<td><button name="btn_'+dt_user_all[i].id+'" data-id="'+dt_user_all[i].id+'" class="btn btn-success">Simpan</button></td>'+
        '</tr>';
        $('table[name=tbl_efihuni_1th]>tbody').append(el);
      }

        let el_foot = 
        '<tfoot>'+
          '<tr>'+
            '<th colspan="2">TOTAL</th>'+
            '<th>'+jss.sum["HP"]+'</th>'+
            '<th>'+jss.sum["LD"]+'</th>'+
            '<th>'+jss.sum["KHM"]+'</th>'+
            '<th>'+jss.sum["dead_krg48"]+'</th>'+
            '<th>'+jss.sum["dead_lbh48"]+'</th>'+
            '<th>'+jss.sum["dead"]+'</th>'+
            '<th>'+jss.sum["hidup"]+'</th>'+
            '<th>'+jss.sum["BOR"]+'</th>'+
            '<th>'+jss.sum["LOS"]+'</th>'+
            '<th>'+jss.sum["TOI"]+'</th>'+
            '<th>'+jss.sum["BTO"]+'</th>'+
            '<th>'+jss.sum["GDR"]+'</th>'+
            '<th>'+jss.sum["NDR"]+'</th>'+
          '</tr>'+
          '<tr>'+
            '<th colspan="2">RATA-RATA</th>'+
            '<th>'+jss.ave["HP"]+'</th>'+
            '<th>'+jss.ave["LD"]+'</th>'+
            '<th>'+jss.ave["KHM"]+'</th>'+
            '<th>'+jss.ave["dead_krg48"]+'</th>'+
            '<th>'+jss.ave["dead_lbh48"]+'</th>'+
            '<th>'+jss.ave["dead"]+'</th>'+
            '<th>'+jss.ave["hidup"]+'</th>'+
            '<th>'+jss.ave["BOR"]+'</th>'+
            '<th>'+jss.ave["LOS"]+'</th>'+
            '<th>'+jss.ave["TOI"]+'</th>'+
            '<th>'+jss.ave["BTO"]+'</th>'+
            '<th>'+jss.ave["GDR"]+'</th>'+
            '<th>'+jss.ave["NDR"]+'</th>'+
          '</tr>'+
        '</tfoot>'
        ;
        $('table[name=tbl_efihuni_1th]').append(el_foot);
      


      let label_loop = ["BOR", "LOS", "TOI", "BTO", "GDR", "NDR"];
      for (let j=0; j<label_loop.length; j++) {        
        let data_grf = [],
            data_grf2 = [];
        // let label = [label_loop[j]];
        let label = [ get_th, (get_th-1)];

        for (let i=0; i<js.length; i++) {
          data_grf[i] = js[i][label_loop[j]];
        }

        for (let i=0; i<js_last_th.length; i++) {
          data_grf2[i] = js_last_th[i][label_loop[j]];
        }

        console.log([data_grf, data_grf2]);
        chartjs_line('grf_line_'+label_loop[j], [data_grf, data_grf2], label);
        
      }

    });
  }
  //***************************************************/
  //       \bo/menu/manajemen/efihuni-tt/efihuni-tt-thn
  //***************************************************/




  
  //***************************************************/
  //        bo/menu/manajemen/dokter-spesialis/tarifri-sp-ina-rs
  //***************************************************/
  if( open_site('bo/menu/manajemen/dokter-spesialis/tarifri-sp-ina-rs') ){
    let js = '';
    //Date picker
    $('.datepicker').datepicker({
    // $('#datepick').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('#btn_ld_trf').click(function(e){
      e.preventDefault();
      
      if($('#in_datestart').val() == '' || $('#in_dateend').val() == ''){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      // js = _ajax("GET", "db/m_manajemen/lap_ri_selisih_trf_rs_ina_grp_sp/"+$('#in_datestart').val()+"/"+$('#in_dateend').val() , "");
      js = _ajax("GET", "db/m_manajemen/lap_ricx_selisih_trf_rs_ina_grp_sp/"+$('#in_datestart').val()+"/"+$('#in_dateend').val() , "");
      console.log(js);

      
      let tbl = {
        id : 'tbl_selisih_trf_rs_ina',
        headers : [
          ['Dokter', 'KODE DOKTER', 'style="text-align:center;"',], 
          ['namadokter','NAMA DOKTER'], 
          ['total_ina','TOTAL INA', 'style="text-align:right;"','numeral'],
          ['total_ina_verif','TOTAL INA VERIF', 'style="text-align:right;"','numeral'], 
          ['total_rs','TOTAL RS', 'style="text-align:right;"','numeral'], 
          ['selisihInaRs','SELISIH (INA VRF-RS)','style="text-align:right;"','numeral'], 
        ],
        data : js,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'DETAIL',
        },
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      $('#tbl_laporan').children().remove();
      $('#tbl_laporan').append(el_tbl);
      $('#tbl_selisih_trf_rs_ina').DataTable({"scrollX": true});
      

    });



    
    $(document).on('click','#tbl_selisih_trf_rs_ina tbody tr td button', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(id);
      // return 0;
      js_selected = js[id].detail;
      console.log(js_selected);

      
      let tbl = {
        id : 'tbl_mdl_selisih_trf_rs_ina',
        headers : [
          ['Dokter', 'KODE DOKTER', 'style="text-align:center;"',], 
          ['namadokter','NAMA DOKTER'], 
          ['nobill','NOBILL', 'style="text-align:center;"',], 
          ['nosep','NOSEP', 'style="text-align:center;"',], 
          ['norm','NORM', 'style="text-align:center;"',], 
          ['nama','PASIEN'], 
          ['total_ina','TOTAL INA', 'style="text-align:right;"','numeral'], 
          ['total_ina_verif','TOTAL INA VERIF', 'style="text-align:right;"','numeral'], 
          ['total_rs','TOTAL RS', 'style="text-align:right;"','numeral'], 
          ['selisihInaRs','SELISIH (INA VRF-RS)','style="text-align:right;"','numeral'], 
        ],
        data : js_selected,
        button : null,
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      let mdl = {
        id    : 'modal_det',
        bodyId: 'el_modal2',
        size  : 'lg',
        title : 'Detail Selisih Tarif Dokter Spesialis - '+js[id].namadokter,
        table : el_tbl,
      };
      let el = create_modal(mdl);

      $('#modal_list').children().remove();
      $('#modal_list').append(el);
      $('#tbl_mdl_selisih_trf_rs_ina').DataTable({"scrollX": true});
      $('#modal_det').modal('show');

      //====================

      // $('#tbl_mdl_bedri').DataTable().destroy(); // DISABLE
      // $('#modal_bed').modal('hide');
    });

   
    $(document).on('hide.bs.modal','#modal_det', function () {
      $('#tbl_mdl_selisih_trf_rs_ina').DataTable().destroy();
      console.log('modal hide');
    });


    $('#btn_dl_excel').click(function(e){
      e.preventDefault();
      if( $('#in_datestart').val() == '' || $('#in_dateend').val() == '' ){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      let filename = "Lap RI Spesialis - Selisih INA RS_"+$('#in_datestart').val()+"_"+$('#in_dateend').val();
      // window.open(baseUrl()+'ajaxreq/xls/m_manajemen/lap_selisih_trf_rs_ina_grp_sp_det/'+$('#in_datestart').val()+"/"+$('#in_dateend').val()+"?filename="+filename, ''); // last
      window.open(baseUrl()+'ajaxreq/xls/m_manajemen/lap_ricx_selisih_trf_rs_ina_grp_sp_det/'+$('#in_datestart').val()+"/"+$('#in_dateend').val()+"?filename="+filename, '');
        
    });

  }
  //***************************************************/
  //       \bo/menu/manajemen/dokter-spesialis/tarifri-sp-ina-rs
  //***************************************************/



  
  //***************************************************/
  //        bo/menu/manajemen/dokter-spesialis/tarif-sp-ina-rs
  //***************************************************/
  if( open_site('bo/menu/manajemen/dokter-spesialis/tarif-sp-ina-rs') ){
    let js = '';
    //Date picker
    $('.datepicker').datepicker({
    // $('#datepick').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('#btn_ld_trf').click(function(e){
      e.preventDefault();

      if($('#in_datestart').val() == '' || $('#in_dateend').val() == ''){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      js = _ajax("GET", "db/m_manajemen/lap_selisih_trf_rs_ina_grp_sp/"+$('#in_datestart').val()+"/"+$('#in_dateend').val() , "");
      console.log(js);

      
      let tbl = {
        id : 'tbl_selisih_trf_rs_ina',
        headers : [
          ['Dokter', 'KODE DOKTER', 'style="text-align:center;"',], 
          ['namadokter','NAMA DOKTER'], 
          ['total_ina','TOTAL INA', 'style="text-align:right;"','numeral'],
          ['total_ina_verif','TOTAL INA VERIF', 'style="text-align:right;"','numeral'], 
          ['total_rs','TOTAL RS', 'style="text-align:right;"','numeral'], 
          ['selisihInaRs','SELISIH (INA VRF-RS)','style="text-align:right;"','numeral'], 
        ],
        data : js,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'DETAIL',
        },
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      $('#tbl_laporan').children().remove();
      $('#tbl_laporan').append(el_tbl);
      $('#tbl_selisih_trf_rs_ina').DataTable({"scrollX": true});
      

      // let mdl = {
      //   id    : 'modal_bed',
      //   bodyId: 'el_modal2',
      //   size  : 'lg',
      //   title : 'Daftar Kode Bed',
      //   table : el_tbl,
      // };
      // let el = create_modal(mdl);
      // $('#modal_list').append(el);
      // $('#tbl_mdl_bedri').DataTable({"scrollX": true});
      // $('#modal_bed').modal('show');

    });


    $(document).on('click','#tbl_selisih_trf_rs_ina tbody tr td button', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log(id);
      // return 0;
      js_selected = js[id].detail;
      console.log(js_selected);


      
      let tbl = {
        id : 'tbl_mdl_selisih_trf_rs_ina',
        headers : [
          ['Dokter', 'KODE DOKTER', 'style="text-align:center;"',], 
          ['namadokter','NAMA DOKTER'], 
          ['nobill','NOBILL', 'style="text-align:center;"',], 
          ['nosep','NOSEP', 'style="text-align:center;"',], 
          ['norm','NORM', 'style="text-align:center;"',], 
          ['nama','PASIEN'], 
          ['total_ina','TOTAL INA', 'style="text-align:right;"','numeral'], 
          ['total_ina_verif','TOTAL INA VERIF', 'style="text-align:right;"','numeral'], 
          ['total_rs','TOTAL RS', 'style="text-align:right;"','numeral'], 
          ['selisihInaRs','SELISIH (INA VRF-RS)','style="text-align:right;"','numeral'], 
        ],
        data : js_selected,
        button : null,
        // {
        //   color : 'success',
        //   head : 'OPSI',
        //   label : 'DETAIL',
        // },
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      let mdl = {
        id    : 'modal_det',
        bodyId: 'el_modal2',
        size  : 'lg',
        title : 'Detail Selisih Tarif Dokter Spesialis - '+js[id].namadokter,
        table : el_tbl,
      };
      let el = create_modal(mdl);

      $('#modal_list').children().remove();
      $('#modal_list').append(el);
      $('#tbl_mdl_selisih_trf_rs_ina').DataTable({"scrollX": true});
      $('#modal_det').modal('show');

      //====================

      // $('#tbl_mdl_bedri').DataTable().destroy(); // DISABLE
      // $('#modal_bed').modal('hide');
    });

   
    $(document).on('hide.bs.modal','#modal_det', function () {
      $('#tbl_mdl_selisih_trf_rs_ina').DataTable().destroy();
      console.log('modal hide');
    });


    $('#btn_dl_excel').click(function(e){
      e.preventDefault();
      if( $('#in_datestart').val() == '' || $('#in_dateend').val() == '' ){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      let filename = "Lap RJ Spesialis - Selisih INA RS_"+$('#in_datestart').val()+"_"+$('#in_dateend').val();
      window.open(baseUrl()+'ajaxreq/xls/m_manajemen/lap_selisih_trf_rs_ina_grp_sp_det/'+$('#in_datestart').val()+"/"+$('#in_dateend').val()+"?filename="+filename, '');
        
    });




  }
  //***************************************************/
  //       \bo/menu/manajemen/dokter-spesialis/tarif-sp-ina-rs
  //***************************************************/








  //***************************************************/
  //        bo/menu/it/dev/fb_bot
  //***************************************************/
  if( open_site('bo/menu/it/dev/fb_bot') ){
    $.ajaxSetup({ cache: true });
    $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
      FB.init({
        appId: '...',
        version: 'v4.0' // or v2.1, v2.2, v2.3, ...
      });     
      $('#loginbutton,#feedbutton').removeAttr('disabled');
      FB.getLoginStatus(updateStatusCallback);
    });
  }

  
  //***************************************************/
  //       \bo/menu/it/dev/fb_bot
  //***************************************************/

  //***************************************************/
  //        bo/menu/it/support/departemen/transfer-billing
  //***************************************************/
  if( open_site('bo/menu/it/support/departemen/transfer-billing') ){
    let js_str = "";
    let noreff_obat = "";
    let noreff_tindakan = "";

    let nobill_obat_lama = "",
        nobill_obat_new = '',
        nobill_tindakan_lama = "",
        nobill_tindakan_new = '',
        nama_new   = '',
        alamat_new = '';

    let q = '', exe_update = '';

    
    $("input[name=noreff_obat]").keypress(function (e) { //TEKAN ENTER
      noreff_obat = $(this).val();
      if (e.which == 13) {
        let js_obat = _ajax("GET", "select_transfer_obat/"+noreff_obat, '');
        console.log(js_obat);
        nobill_obat_lama = js_obat[0].NoBill;
        js_str = JSON.stringify(js_obat, null, 4);
        $('#val_obat').text(js_str);

        $("input[name=nobill_obat]").focus();
      }
    });

    $("input[name=nobill_obat]").keypress(function (e) { //TEKAN ENTER
      nobill_obat_new = $(this).val();
      if (e.which == 13) {
        //select fotr daftar, get Nama & Alamat
        let js_obat = _ajax("GET", "select_fotrdaftar_by_bill/"+nobill_obat_new, '');
        console.log(js_obat);

        nama_new    = js_obat[0].Nama;
        alamat_new  = js_obat[0].Alamat;
        console.log([noreff_obat, nobill_obat_lama, nobill_obat_new, nama_new, alamat_new]);

        // update fotrpayment
          exe_update = _db_update({NoNota:noreff_obat}, 'fotrpayment', { NoBill:nobill_obat_new });
          console.log(exe_update);
          // if(exe_update == null){
          //   console.log('Proses Update Sukses.');
          // }else{
          //   alert('Proses Update Gagal. Silahkan ulangi.');
          // }

        // update boivsales
          exe_update = _db_update({nobukti:noreff_obat}, 'boivsales', { NoBilling:nobill_obat_new, Nama:nama_new, Alamat:alamat_new });
          console.log(exe_update);

        let js = _ajax("GET", "select_transfer_obat/"+noreff_obat, '');
        console.log(js);

        $('#val_obat_final').text( JSON.stringify(js, null, 4) );
      }
    });

    
    $("input[name=noreff_tindakan]").keypress(function (e) { //TEKAN ENTER
      noreff_tindakan = $(this).val();
      if (e.which == 13) {
        let js = _ajax("GET", "select_transfer_obat/"+noreff_tindakan, '');
        console.log(js);
        nobill_tindakan_lama = js[0].NoBill;
        js_str = JSON.stringify(js, null, 4);
        $('#val_tindakan').text(js_str);

        $("input[name=nobill_tindakan]").focus();
      }
    });

    $("input[name=nobill_tindakan]").keypress(function (e) { //TEKAN ENTER
      nobill_tindakan_new = $(this).val();
      if (e.which == 13) {
        console.log(nobill_tindakan_new);

        // update fotrpayment
          exe_update = _db_update({NoNota:noreff_tindakan}, 'fotrpayment', { NoBill:nobill_tindakan_new });
          console.log(exe_update);
          
        // update fotrpostindakan
          exe_update = _db_update({NoReff:noreff_tindakan}, 'fotrpostindakan', { NoBill:nobill_tindakan_new });
          console.log(exe_update);

        let js = _ajax("GET", "select_transfer_obat/"+noreff_tindakan, '');
        console.log(js);

        $('#val_tindakan_final').text( JSON.stringify(js, null, 4) );
      }
    });

  }

  //***************************************************/
  //       \bo/menu/it/support/departemen/transfer-billing
  //***************************************************/


  //***************************************************/
  //        bo/menu/it/support/dokter/jadwal-dokter
  //***************************************************/
  if( open_site('bo/menu/it/support/dokter/jadwal-dokter') ){
    let hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];

    // //$('.timepicker').wickedpicker();
    // var options = {
    //       now: "12:35", //hh:mm 24 hour format only, defaults to current time
    //       twentyFour: false,  //Display 24 hour format, defaults to false
    //       upArrow: 'wickedpicker__controls__control-up',  //The up arrow class selector to use, for custom CSS
    //       downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
    //       close: 'wickedpicker__close', //The close class selector to use, for custom CSS
    //       hoverState: 'hover-state', //The hover state class to use, for custom CSS
    //       title: 'Timepicker', //The Wickedpicker's title,
    //       showSeconds: false, //Whether or not to show seconds,
    //       timeSeparator: ' : ', // The string to put in between hours and minutes (and seconds)
    //       secondsInterval: 1, //Change interval for seconds, defaults to 1,
    //       minutesInterval: 1, //Change interval for minutes, defaults to 1
    //       beforeShow: null, //A function to be called before the Wickedpicker is shown
    //       afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
    //       show: null, //A function to be called when the Wickedpicker is shown
    //       clearable: false, //Make the picker's input clearable (has clickable "x")
    //   };
    //   $('.timepicker').wickedpicker(options);



    let contentType ="application/x-www-form-urlencoded; charset=utf-8";
    if(window.XDomainRequest) contentType = "text/plain";
    //=============== formPasien.php=============================

    
    //==============index.php =============================
    
    //loop hari seminggu
    //arr_id= dipakai utk mendapat urutan index dokter dr response json
    for(i=0;i<hari.length;i++){
      let contentLoad = 
      '<option value="'+hari[i]+'" data-arr_id="'+i+'">'+
        hari[i]+
      '</option>';
      $("select[name=hari]").append(contentLoad);
    }

    let dokter_daftar = _ajax_web("GET", baseUrl()+"main/db/m_itsupport/dokter_daftar", "")
    console.log(dokter_daftar);


    // let dtjson = JSON.parse(data);
    for(i=0;i<dokter_daftar.length;i++){
      let contentLoad = 
      '<option value="'+dokter_daftar[i].Kode+'" data-arr_id="'+i+'">'+
        dokter_daftar[i].Nama+
      '</option>';
      $("select[name=nama_dokter]").append(contentLoad);
    }


    function jadok_tampil(){
      $("table[name=tbl_jadok] tr").remove();
      $("table[name=tbl_jadok]").append(
        '<tr style="background-color: yellow; text-align: center;">'+
          //'<th>No.</th>'+
          '<th>Hari</th>'+
          '<th>Poli Spesialis</th>'+
          '<th>Nama Dokter</th>'+
          '<th>Jam Praktek</th>'+
          '<th>Opsi</th>'+
        '</tr>'
      );

      let jadok_tampil = _ajax_web("GET", baseUrl()+"main/db/m_itsupport/jadok_tampil", "")
      console.log(jadok_tampil);
      
      let nEachHari = [0,0,0,0,0,0,0];

      for(i=0;i<jadok_tampil.length;i++){
        let contentLoad = 
        '<tr data-id="'+jadok_tampil[i].Id+'">'+
          //xx//'<td>'+(+dtjson[i].hariId+1)+'</td>'+
          //'<td>'+dtjson[i].hariId+'</td>'+
          '<td>'+jadok_tampil[i].hari+'</td>'+
          '<td>'+jadok_tampil[i].Spesialis+'</td>'+
          '<td>'+jadok_tampil[i].Nama+'</td>'+
          '<td>'+jadok_tampil[i].jamMasuk+' - '+jadok_tampil[i].jamPulang+'</td>'+
          '<td><button id="btn_hapus_jadok" class="btn btn-danger">X</button></td>'+
        '</tr>';

        nEachHari[jadok_tampil[i].hariId]++;        

        $("table[name=tbl_jadok]").append(contentLoad);
      }

      for(let n=0; n<nEachHari.length; n++){
        console.log('nEachHari['+n+']= '+nEachHari[n]);
      }      
    }

    jadok_tampil();

    $(document).on('click','#btn_hapus_jadok', function(){
      let idJadok = $(this).parent().parent().data('id');
      console.log(idJadok);
      
      let del = _ajax_web("POST", baseUrl()+"main/delete/cm_dokterjadwal", {Id: idJadok} );
      console.log(del);

      jadok_tampil();
      return false;
    });




    //================= FORM JADWAL DOKTER ========================
    let dokter_kode='-', dokter_nama='-', dokter_poli='-';
    let hari_pilih='-', hariId_pilih='-', jam_mulai='-', jam_selesai='-';
    //=================/FORM JADWAL DOKTER ========================



    $('select[name=nama_dokter]').change(function(){
      //alert(js_dokter);
      dokter_kode = $("select[name=nama_dokter]").val();
      let arr_id_pilih = $("select[name=nama_dokter]").find(':selected').data('arr_id');
      //console.log(kode_dokter+'/'+arr_id_pilih);

      let jsp_dokter = JSON.parse(js_dokter);
      dokter_nama = jsp_dokter[arr_id_pilih].Nama;
      dokter_poli = jsp_dokter[arr_id_pilih].Keterangan;
      //////////////////alert(dokter_nama+'/'+arr_id_pilih);
      //////console.log(jsp_dokter[2].Kode);

      //alert(jsp_dokter.Kode);
      $('td[name=kode_dokter]').text(dokter_kode);
      $('td[name=lokasi]').text(dokter_poli);
    });

    
    function loop_hhout(){
      let opt_hhout = '';
      for(let i=0;i<24;i++){
        if(i<10) j='0'+i;
        else j=i;
        opt_hhout += '<option value="'+j+'">'+j+'</option>';
      }
      return opt_hhout;
    }

    function loop_mmout(){
      let opt_mmout = '';
      for(let i=0; i<=45; i+=15){
        let j=0;
        if(i==0) j='00';
        else j=i;        
        opt_mmout += '<option value="'+j+'">'+j+'</option>';
      }
      return opt_mmout;
    }

    function maker_select(name, opt){
      let el = '<select name="'+name+'" class="form-control modewaktu">' +opt+ '</select>';
      return el;
    }    
    

    function maker_select_full(){
      let el_tot = 
        maker_select('hh_out', loop_hhout())+
          '<span class="modewaktu">:</span>'+
        maker_select('mm_out', loop_mmout());

      $('td[name=jam_selesai]').append(el_tot);
    }

    maker_select_full();
    
    $('td[name=jam_selesai]').append();

    let flagCbox=0;
    $('input[name=cbox_selesai]').change(function(){
      if(flagCbox==0){ //modeselesai
        $('td[name=jam_selesai]').children().remove();
        $('td[name=jam_selesai]').append('<span>Selesai</span>');
        jam_selesai = 'selesai';
        flagCbox=1;			
      }else{ //modewaktu
        $('td[name=jam_selesai]').children().remove();
        maker_select_full();
        flagCbox=0;
      }
      
    });


    let jam_user_input, user_input;
    $('button[name=simpan_jadok]').click(function(){
      jam_user_input = moment().format('DD-MM-YYYY hh:mm:ss');

      hari_pilih = $("select[name=hari]").val();
      hariId_pilih = $("select[name=hari]").find(':selected').data('arr_id');
      jam_mulai = $("select[name=hh_in]").val() +':'+ $("select[name=mm_in]").val();

      if(flagCbox==0){
        jam_selesai = $("select[name=hh_out]").val() +':'+ $("select[name=mm_out]").val();
      }
      
      if(dokter_nama=='-' || hari_pilih=='-'){
        alert('Form harus dilengkapi semua...');
      }else{
        //alert(dokter_kode+'/'+hari_pilih+'/'+hariId_pilih+'/'+jam_mulai+'/'+jam_selesai+'/'+jam_user_input);
        $.ajax({
          url:"model_rscm.php?kode=jadok_input",
          data:{
            kodeDokter : dokter_kode,
            hari : hari_pilih,
            hariId : hariId_pilih,
            jamMasuk : jam_mulai,
            jamPulang : jam_selesai,
            user : 'Rizky',
            date : jam_user_input
          },
          type:"POST",
          //dataType:"json",
          //contentType:contentType,
          success:function(data){
            alert(data);
            jadok_tampil();
          },
          error:function(jqXHR,textStatus,errorThrown){
            alert("ERROR[dokter_daftar]: "+errorThrown);
          }
        });
      
      }
    });
  }

  //***************************************************/
  //       \bo/menu/it/support/dokter/jadwal-dokter
  //***************************************************/

  
  //***************************************************/
  //        bo/menu/it/support/ws/ws-bpjs-run
  //***************************************************/
  if( open_site('bo/menu/it/support/ws/ws-bpjs-run') ){
    $('#btn_run_ws_bpjs').click(function(e){
      e.preventDefault();
      let url = $('#param').val();
      // let js = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep:tgl});
      let js = _ajax_web("GET", baseUrl()+"ajax_bpjs11/url/GET/"+url,'');
      // ajax_bpjs11/url/GET/
      console.log(js);
      
      js_str = JSON.stringify(js, null, 4);
      $('#result').val(js_str);
    });
  }

  //***************************************************/
  //       \bo/menu/it/support/ws/ws-bpjs-run
  //***************************************************/
  
  
  
  //***************************************************/
  //        bo/menu/it/support/bpjs/aplicare
  //***************************************************/
  if( open_site('bo/menu/it/support/bpjs/aplicare') ){
    let ld_tt_bpjs = _ajax_web("GET", baseUrl()+"aplicare/ketersediaan_kamar_rs/0195R028/1/20", "");
    console.log(ld_tt_bpjs);

    let tbl = {
      // id : 'tbl_mdl_cari_px',
      id : 'tbl_ld_tbl_tt',
      headers : [
        ['rownumber', 'No.'], ['koderuang','Kode Ruang'], ['namaruang','Nama Ruang'],
        ['kodekelas', 'Kode Kelas'], ['namakelas', 'Nama Kelas'], 
        ['tersedia','Tersedia'], ['tersediapriawanita','Tersedia(P/W)'],
        ['lastupdate','Last Update'],
      ],
      data : ld_tt_bpjs.response.list,
      button : null,
    };
  
    let el_tbl = create_table_return(tbl, ld_tt_bpjs.response.list); 
    $("#ld_tbl_tt").html(el_tbl);
  }

  //***************************************************/
  //       \bo/menu/it/support/bpjs/aplicare
  //***************************************************/


  //***************************************************/
  //        bo/menu/it/user/user-akses
  //***************************************************/
  if( open_site('bo/menu/it/user/user-akses') ){
    $('.select2').select2();    

    let dt = '',
        dt_user_all = '';
    let id_user = '';
    let sel_menu = '',
        filter_name_chk = 'menu_bo_sidebar';

    dt_user_all = _ajax('GET','select_user','');
    console.log(dt_user_all);

    for(let i=0; i<dt_user_all.length; i++){
      let el = '<option value="'+dt_user_all[i].id+'">'+dt_user_all[i].username+'</option>';
      $('select[name=sel_user]').append(el);
    }


    //------ box:Registrasi User --------
      // let js_user = _ajax_web("GET", baseUrl()+"user/list_karyawan", "");
      let js_user = _ajax_web("GET", baseUrl()+"user/list_karyawan_registered_app", "");
      console.log(js_user);
      
      // PUSH AUTOCOMPLETE
      for (let i = 0; i < js_user.length; i++) {
        js_user[i]['value'] = js_user[i].kode;
        js_user[i]['label'] = js_user[i].nama+'('+js_user[i].kode+')';
      }
      console.log(js_user); // SETELAH PUSH
      
      let sel_user = null;
      $("input[name=noreg]").autocomplete({
        source: js_user,
        // minLength: 2,
        select: function( event, ui ) {
          // console.log(ui); console.log(event);
          sel_user = ui.item;
          console.log(sel_user);
        }
      });
    //------\box:Registrasi User --------

    //------ box:User Akses Setting Menu --------


    // create tbl_user_checkbox
    let th_list = [
        'Id', 'Noreg',
        'Username', 'Departemen Sub',
        '<label><input type="checkbox" name="chk_all_user" title="Toggle Cek All">Toggle</label>',
        // 'Opsi'
      ];
    create_tbl('tbl_user_checkbox', th_list);

    // create tbl_user_checkbox>tbody
    for(let i=0; i<dt_user_all.length; i++){
      let el = 
      '<tr>'+
        '<td>'+dt_user_all[i].id+'</td>'+
        '<td>'+dt_user_all[i].noreg+'</td>'+
        '<td>'+dt_user_all[i].username+'</td>'+
        '<td>'+dt_user_all[i].departemensub+'</td>'+
        '<td><input type="checkbox" name="cbox_'+dt_user_all[i].id+'" data-id="'+dt_user_all[i].id+'" class="load" value="" /></td>'+
        // '<td><button name="btn_'+dt_user_all[i].id+'" data-id="'+dt_user_all[i].id+'" class="btn btn-success">Simpan</button></td>'+
      '</tr>';
      $('table[name=tbl_user_checkbox]>tbody').append(el);
    }
    // $('table[name=tbl_user_checkbox]').DataTable();

    $('input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });
    // \create tbl_user_checkbox



    // IF CLICK masing2 checkbox
    // $('input[type="checkbox"].load').on('ifToggled', function(e){
    // $('input[type="checkbox"].load').on('ifClicked', function(e){
    $('input[type="checkbox"].load').on('ifChanged', function(e){
      // alert(e.type + ' callback');
      let attr_id = $(this).data('id'),
          attr_val = '';
      let attr_name = $(this).attr('name');
      let attr_check = e.target.checked;
      
      // console.log(e);
      if(attr_check == true){
        $(this).attr('value',1);
      }else{
        $(this).attr('value',0);
      }

      attr_val = $(this).val();
      console.log([attr_id, attr_val, attr_name, attr_check]);

      // START AKSES DB
      if(sel_menu == ''){
        alert('Filter Value belum dipilih');
      }else{
        let jPost = {
          id_user   : attr_id,
          filter_val: sel_menu,
        };
        console.log(jPost);

        let dt = _ajax('GET', 'select_menu_bo_sidebar_by_id', jPost);
        console.log(dt);

        if(dt.length == 0){ // insert
          if(attr_check == true){
            console.log('insert');
            let jPost_insert = {
                id        : '',
                id_user   : attr_id,
                pageurl   : '',
                level_page: '',
                filter_name: 'menu_bo_sidebar',
                filter_val: sel_menu,
                status    : attr_val,
                user : _user_logged_in,
                date : moment().format('YYYY-MM-DD'),
                time : moment().format('HH:mm:ss')
              };
            console.log(jPost_insert);

            let exe_insert = _db_insert('xuserakses', jPost_insert);
            console.log(exe_insert);

            if(exe_insert == null){
              console.log('Proses Insert Sukses.');
            }else{
              alert('Proses Insert Gagal. Silahkan ulangi.');
            }
          }          
        }else{ // update
          console.log('update');
          let where = {
              id_user     : attr_id, 
              filter_name : 'menu_bo_sidebar',
              filter_val  : sel_menu
            };

          // let jPost_update = {status : attr_val};
          // console.log(jPost_update);

          let exe_update = _db_update(where,'xuserakses', {status : attr_val});
          console.log(exe_update);
          if(exe_update == null){
            console.log('Proses Update Sukses.');
          }else{
            alert('Proses Update Gagal. Silahkan ulangi.');
          }
        }
      }  
    });

    // JANGAN CHECK ALL, EXECUTE ALL USER
    $('input[name="chk_all_user"]').on('ifToggled', function(e){
      // // alert(e.type + ' callback');
      // let attr_name = $(this).attr('name');
      // let attr_check = e.target.checked;
      // console.log(attr_name+'_'+attr_check);
      // // console.log(e);
      // if(attr_check == true){
      //   // $('input.load').iCheck('check');
      //   $('input.load').iCheck('check').attr('value',1);
      // }else{
      //   $('input.load').iCheck('uncheck').attr('value',0);
      // }
    });

    // LOAD data CHECK saat ganti filter_val(it,receptionist,dsb)
    $('select[name=sel_menu]').on('change', function(e){
      e.preventDefault();
      sel_menu = $(this).val();
      console.log(sel_menu);
      // netralisir checkbox
      for(let i=0; i<dt_user_all.length; i++){
        // if(dt_user_all[i].id == db_sel_menu[i].id_user)
        // $('input[name=cbox_'+db_sel_menu[i].id_user+']').iCheck(check_label).attr('value',db_sel_menu[i].status);
        $('input.load').iCheck('uncheck').removeAttr('value');
      }

      // load data CHECKBOX : CHECKED/UNCHECKED
      let db_sel_menu = _ajax('GET', 'select_menu_bo_sidebar_by_filterval', {filter_val: sel_menu} );
      console.log(db_sel_menu);

      let id_user_checked = [];
      
      for(let i=0; i<db_sel_menu.length; i++){
        let check_label = '';
        if(db_sel_menu[i].status == 1){
          check_label = 'check';
        }else{
          check_label = 'uncheck';
        }

        id_user_checked.push(db_sel_menu[i].id_user); // yg uncheck, tidak ada di array
        $('input[name=cbox_'+db_sel_menu[i].id_user+']').iCheck(check_label).attr('value',db_sel_menu[i].status);
      }  
        

    });



    $('button[name=btn_simpan_uakses_setmenu]').click(function(e){
      e.preventDefault();

      // RENDER SIMPAN
      for(let i=0; i<3; i++){
        // dt_user_all
        let name = $('table[name=tbl_user_checkbox]>tbody>tr:nth-child('+i+')>td>input').attr('name');
        console.log('name: '+'_'+i+'_'+name);
      }
      // let id_user = '1',
      // let id_user    = $('input[name=cbox_3]').val(),
      let id_user    = $('input[name=cbox_3]').val(),
      // let id_user    = document.getElementsByName("fname"),
          filter_val = sel_menu;
      let jPost = {
        id_user   : id_user,
        filter_val: filter_val
      };
      console.log(jPost);

      // if(sel_menu == ''){
      //   alert('Filter Value belum dipilih');
      // }else{
      //   let dt = _ajax('GET', 'select_menu_bo_sidebar_by_id', jPost);
      //   console.log(dt);

      //   if(dt.length == 0){ // insert
      //     console.log('insert');
      //   }else{ // update
      //     console.log('update');
      //   }
      // }
      
    });

    //------\box:User Akses Setting Menu --------

    //------ box:User Akses Setting -------- 

    $('select[name=sel_user]').on('change', function(e){
      e.preventDefault();
      id_user = $('select[name=sel_user]').val();
      console.log(id_user);
    });

    $('button[name=btn_set_user_akses]').click(function(e){
      e.preventDefault();
      // INSERT
      let jPost = {
        id        : '',
        id_user   : id_user,// sel_user
        pageurl   : $('input[name=in_page_url]').val(),
        level_page  : $('select[name=sel_level_page]').val(),
        filter_name : $('input[name=filter_name]').val(),
        filter_val  : $('input[name=filter_val]').val(),
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')
      };

      let dt = _db_insert('xuserakses', jPost);
      console.log(dt);

      if(dt == null){
        alert('Proses Sukses.');
        reload();
      }else{
        alert('Proses Gagal. Silahkan ulangi.');
      }
    });

    //------\box:User Akses Setting --------   

  }

  //***************************************************/
  //       \bo/menu/it/user/user-akses
  //***************************************************/
  

  //***************************************************/
  //        bo/menu/it/user/user-akses-page
  //***************************************************/
  if( open_site('bo/menu/it/user/user-akses-page') ){
    
    $('#tbl_akses_halaman>tbody tr td input').click(function(e){
      // e.preventDefault();
      let y = ''+$(this).parent().parent().data('sort');
      console.log(y);
      
      let s = y.split('.');
      console.log(s);
      
      let get = [];
      let ss = '';
      
      if($(this)[0].checked){
        for (let i = 0; i < (s.length-1); i++) {
          if(i>0) ss +='.'+ s[i];
          else ss = s[i];
          
          get[i] = ss;
          
          // input/td/tr/tbody/find TR
          $(this).parent().parent().parent().find('tr[data-sort="'+get[i]+'"]>td>input').prop('checked',1);
          // $(this).parent().parent().parent().find('tr[data-id="'+get[i]+'"]>td>input').attr('value',1);
        }
        console.log(get);
      }else{ // if uncheck, children of that sub 'uncheck all' 
        // count banyak tr table, mulai iterasi di posisi click, hingga 'levelsub sama'
        let row = $(this).parent().parent().parent().children();
        let index = $(this).parent().parent()[0].sectionRowIndex;
        console.log(row, index);

        for (let i = (index+1); i < row.length; i++) {          
          let sort = row[i].children[1].textContent;
          console.log(sort);
          if( (sort.split('.').length) > s.length)
            $(this).parent().parent().parent().find('tr[data-sort="'+sort+'"]>td>input').prop('checked',0);
          else break; // break jika level sama
        }
      }
      
    });
    
        
        
    $('#btn_simpan_akses2').click(function(e){
      e.preventDefault();
      let sel_level = $('#sel_level option:selected').val();
      console.log(sel_level);
      if(sel_level == ''){ alert('Level belum dipilih.'); return false; }

      let row = $('#tbl_akses_halaman>tbody').children();
      console.log(row);

      let cboxs = [];
      let chk_tf = {
        level: sel_level,
        tru : [],
        fal : [],
      };

      console.log(row.length);
      for (let i = 0; i < row.length; i++) {
        let id_chk = $('#tbl_akses_halaman>tbody>tr[data-index="'+i+'"]>td>input').data('id');
        console.log(id_chk);
        
        let tmp_chk = $('input[data-index="'+i+'"]')[0].checked;
        cboxs['cbox'+i] = tmp_chk;

        if(tmp_chk) chk_tf.tru.push(id_chk);
        else chk_tf.fal.push(id_chk);       
      }

      console.log(cboxs, chk_tf);

      let P = _ajax_web("POST", baseUrl()+"user_xlink/update_user_akses_xmenulevel", chk_tf);
      console.log(P);

      if(P.response.insert.status == 'success') alert("Data berhasil diupdate.");
      else alert("Data tidak berhasil diupdate.");

    });
    
    
    $('#btn_hapus_akses_user_exc').click(function(e){
      e.preventDefault();
      let sel_user_exc = $('#sel_user_exc option:selected').val();
      console.log(sel_user_exc);
      if(sel_user_exc == ''){ alert('User belum dipilih.'); return false; }

      let exe2 = _ajax_web("POST", baseUrl()+"main/delete/xmenuuser", {username: sel_user_exc} );
      console.log(exe2);
      if(exe2==null){
        alert('Data berhasil dihapus.');
        reload();
      }else{
        alert("Data gagal dihapus.");
      }


    });

    $('#btn_simpan_akses_user_exc').click(function(e){
      e.preventDefault();
      let sel_user_exc = $('#sel_user_exc option:selected').val();
      console.log(sel_user_exc);
      if(sel_user_exc == ''){ alert('User belum dipilih.'); return false; }

      let row = $('#tbl_akses_halaman>tbody').children();
      console.log(row);

      let cboxs = [];
      let chk_tf = {
        username: sel_user_exc,
        tru : [],
        fal : [],
      };
      for (let i = 0; i < row.length; i++) {
        let id_chk = $('#tbl_akses_halaman>tbody>tr[data-index="'+i+'"]>td>input').data('id');
        // console.log(id_chk);
        
        let tmp_chk = $('input[data-index="'+i+'"]')[0].checked;
        cboxs['cbox'+i] = tmp_chk;

        if(tmp_chk) chk_tf.tru.push(id_chk);
        else chk_tf.fal.push(id_chk);       
      }

      console.log(cboxs, chk_tf);

      let P = _ajax_web("POST", baseUrl()+"user_xlink/update_user_akses_xmenuuser", chk_tf);
      console.log(P);

      if(P.response.insert.status == 'success') alert("Data berhasil diupdate.");
      else alert("Data tidak berhasil diupdate.");

    });
    

    $('#sel_user_exc').on('change', function(e){
      e.preventDefault();
      sel_user_exc = $(this).val();
      console.log(sel_user_exc);

      let GL = _ajax_web("GET", baseUrl()+"main/db/m_user_xlink/get_menu_by_username/"+sel_user_exc, "");
      console.log(GL);

      // clear
      let row = $('#tbl_akses_halaman>tbody').children();
      for (let c = 0; c < row.length; c++) {
        $(this).parent().parent().parent().find('tr[data-index="'+c+'"]>td>input').prop('checked',0);
      } 

      for (let i = 0; i < GL.length; i++) {    
        // $(this).parent().parent().parent().find('tr[data-sort="'+get[i]+'"]>td>input').prop('checked',1);
        $(this).parent().parent().parent().find('tr[data-sort="'+GL[i].sort+'"]>td>input').prop('checked',1);
      }

      
    });
    
    
    $('#sel_level').on('change', function(e){
      e.preventDefault();
      sel_level = $(this).val();
      console.log(sel_level);

      // let sel_level = $('#sel_level option:selected').val();
      // console.log(sel_level);
      if(sel_level == ''){ alert('Level belum dipilih.'); return false; }
      
      let G = _ajax_web("GET", baseUrl()+"main/db/m_user_xlink/get_level_users/"+sel_level, "");
      console.log(G);
      
      let GL = _ajax_web("GET", baseUrl()+"main/db/m_user_xlink/get_menu_by_level/"+sel_level, "");
      console.log(GL);

      // clear
      let row = $('#tbl_akses_halaman>tbody').children();
      for (let c = 0; c < row.length; c++) {
        $(this).parent().parent().parent().find('tr[data-index="'+c+'"]>td>input').prop('checked',0);
      } 

      for (let i = 0; i < GL.length; i++) {    
        // $(this).parent().parent().parent().find('tr[data-sort="'+get[i]+'"]>td>input').prop('checked',1);
        $(this).parent().parent().parent().find('tr[data-sort="'+GL[i].sort+'"]>td>input').prop('checked',1);
      }

      let users = [];
      for (let i = 0; i < G.length; i++) {
        users.push(G[i].userlogin);        
      }

      $('#txtUser').val(users.join(", "));
        

    });
    

    // $('#frm_akses').submit(function(e){
    //   e.preventDefault();
    //   let P = null;

    //     let data = $(this).serialize();
    //     let url  = $(this).attr('action');
    //     console.log([data, url]);

    //     return false;
    // });


    $('#btn_add_page').click(function(e){
      e.preventDefault();
      // INSERT
      let jPost = {
        id      : '',
        menuname: $('#menu_name').val(),
        sort    : $('#sort').val(),
        url     : $('#url').val(),
        status  : 1,
        icon_name  : $('#icon_name').val(),
        icon_color : $('#icon_color').val(),
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')
      };

      let dt = _db_insert('xmenu', jPost);
      console.log(dt);

      if(dt == null){
        alert('Proses Sukses.');
        reload();
      }else{
        alert('Proses Gagal. Silahkan ulangi.');
      }
    });
  }

  //***************************************************/
  //        \bo/menu/it/user/user-akses-page
  //***************************************************/

  //***************************************************/
  //        bo/menu/it/user/ttd
  //***************************************************/
  if( open_site('bo/menu/it/user/ttd') ){
    sort_bubble();
    // let canvas = $('#myCanvas');
    let canvas = document.getElementById('myCanvas');
    let ctx = canvas.getContext("2d");
    let painting = document.getElementById('content');
    let paintStyle = getComputedStyle(painting);
    canvas.width = parseInt(paintStyle.getPropertyValue('width'));
    canvas.height = parseInt(paintStyle.getPropertyValue('height'));

    let mouse = {x:0, y:0};

    let arr_arc = [];

    canvas.addEventListener('mousemove', function(e){
      mouse.x = e.pageX - this.offsetLeft;
      mouse.y = e.pageY - this.offsetTop;
    }, false);


    ctx.lineWidth = 3;
    ctx.lineJoin  = 'round';
    ctx.lineCap   = 'round';
    // ctx.strokeStyle = '#FF0000'; //red
    ctx.strokeStyle = '#000000';

    canvas.addEventListener('mousedown', function(e){
      // draw the current path on the canvas
      ctx.beginPath();
      ctx.moveTo(mouse.x, mouse.y);
      // console.log(mouse.x, mouse.y); // hanya saat klik muncul koordinat
      canvas.addEventListener('mousemove', onPaint, false);
    }, false);

    canvas.addEventListener('mouseup', function(){
      canvas.removeEventListener('mousemove', onPaint, false);
    }, false);

    let onPaint = function(){
      ctx.lineTo(mouse.x, mouse.y);
      ctx.stroke();
      arr_arc.push([mouse.x, mouse.y]);
      console.log(arr_arc);
    }




    $('button[name=btn_canvas_clear]').click(function(){
      // let el = '<canvas id="myCanvas"></canvas>';
      // $('#content').children().remove().append(el);
      ctx.clearRect(0, 0,  canvas.width, canvas.height);
    });


    $('a[name=btn_canvas_download]').click(function(){
      let kd_dokter = $('input[name=kd_dokter]').val();
      if(kd_dokter==''){
        alert('Nama file tidak boleh kosong');
      }else{
        $(this).attr({href: canvas.toDataURL(), download: kd_dokter+'.png' });
      }
        
    });

    $('a[name=btn_canvas_simpan]').click(function(e){
      e.preventDefault();
      console.log('simpan');
      let dataURL = canvas.toDataURL();
      console.log(dataURL);

      let kd_dokter = $('input[name=kd_dokter]').val();
      if(kd_dokter==''){
        Swal.fire('Nama file tidak boleh kosong.');
      }else{
        let jPost = {
            imgBase64 : dataURL,
            filename  : kd_dokter,
            format    : 'png',
            location  : 'uploads/img/ttd/'
          };

        $.ajax({
          async: false,
          url  : baseUrl()+'upload/upload_canvas', //URL submit
          type : "POST", //method Submit
          data : jPost,
          success: function(data){
            console.log(data);
            Swal.fire({
              position: 'center',
              type : 'success',
              title: 'Upload Image Berhasil.',
              showConfirmButton: true
            });
          }
        });
      }

    });

    // FormData(this) GAK KENEK KALO NDAK PAKE FORM
    // $('button[name=btn_upload_img]').click(function(e){
    $('#frm_upload_ttd').submit(function(e){
      e.preventDefault(); 
      $.ajax({
        async:false,
        url : baseUrl()+'upload/do_upload/ttd', //URL submit
        type: "POST", //method Submit
        data: new FormData(this), //penggunaan FormData
        processData:false,
        contentType:false,
        cache:false,
        success: function(data){
          // console.log(data);
          // alert("Upload Image Berhasil."); //alert jika upload berhasil
          Swal.fire({
            position: 'center',
            type : 'success',
            title: 'Upload Image Berhasil.',
            showConfirmButton: true
          });
        }
      });
      return false;
    });

  }

  //***************************************************/
  //       /bo/menu/it/user/ttd
  //***************************************************/




  //***************************************************/
  //        bo/menu/it/web/upload-artikel
  //***************************************************/
  if( open_site('bo/menu/it/web/upload-artikel') ){
    let _user_logged_in = $('body').data('user_logged_in');
    console.log(_user_logged_in);

    CKEDITOR.replace('editor1');
    // console.log('a');
    let judul = '', filename = '', imagename = '', isi_artikel = '';
    $('#create_slug').click(function(e){
      e.preventDefault();
      // let artikel_html = $('#editor1').val();
      // let artikel_html = CKEDITOR.instances.DSC.getData();
      judul = $('input[name=judul]').val();
      console.log(judul);

      let js = _ajax("GET", "slug", {judul:judul} );
      console.log(js.slug);
      $('input[name=filename]').val(js.slug);
      $('input[name=imagename]').val(js.slug+".png");
    });

    $('#btn_upload_artikel').click(function(e){
      e.preventDefault();
      // let artikel_html = $('#editor1').val();
      // let artikel_html = CKEDITOR.instances.DSC.getData();
      let artikel_html = CKEDITOR.instances['editor1'].getData();
      
      judul = $('input[name=judul]').val();
      filename = $('input[name=filename]').val();
      imagename = $('input[name=imagename]').val();
      isi_artikel = $('textarea[name=isi_artikel]').val();
      let jPost = {
        judul : judul,
        filename : filename,
        imagename: imagename,
        isi_artikel : isi_artikel,
        // artikel_html : artikel_html, // dari CKEDITOR
        user : _user_logged_in,
        date : moment().format('YYYY-MM-DD'),
        time : moment().format('HH:mm:ss')
      };
      console.log(jPost);


    });

  }

  //***************************************************/
  //       /bo/menu/it/web/upload-artikel
  //***************************************************/


  //***************************************************/
  //        bo/menu/it/setting/printer
  //***************************************************/
  if( open_site('bo/menu/it/setting/printer') ){
    let pr_all = _ajax_web('GET', baseUrl()+'main/db/m_it/select_printer', '');
    let pr = pr_all.db;
    console.log(pr);

    let sel_pr = null;

    let opt = '';
    for (let i = 0; i < pr.length; i++) {
      opt += '<option value="'+pr[i].name+'">'+pr[i].name+'</option>';
    }
    $('#sel_label_printer').append(opt);

    
    let tbl = {
      id : 'tbl_printer_tmp',
      headers : [
        ['id','ID',], 
        ['value','NAMA PRINTER'],
        ['name','LABEL PRINTER'],
        // ['id','OPSI', 'style="text-align:center;"', 'button', 
        //   {color:'primary', label:'EDIT', trigger:'btnEditIdList'}],
      ],
      data : pr,
      button : null,
    };
  
    let el_tbl = create_table_return2(tbl, pr); 
    
    $('#tbl_printer').children().remove();
    $('#tbl_printer').append(el_tbl);
    $('#tbl_printer_tmp').DataTable({"scrollX": true});  

    let el_opt = '';
    for (let op = 0; op < pr_all.connected.length; op++) {
      el_opt += '<option value="'+pr_all.connected[op].str+'">'+pr_all.connected[op].NAME+'</option>';      
    }
    $('#sel_nama_printer').append(el_opt);


    $('.btnEditIdList').click(function(e){
      e.preventDefault();
      let sel_urut = $(this).parent().parent().data('sort');
      // console.log(sel_urut);

      sel_pr = pr[sel_urut];
      console.log(sel_pr);

      // MODAL SHOW
      $('#modal_detail').modal('show');
      $('#md_label_printer').text(sel_pr.name);

    });
    
    
    let get_label_printer = '',
        get_nama_printer = ''; //  'cetak_sep_langsung';
    // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    // $('#sel_label_printer option[value='+get_label_printer+']').attr('selected','selected');


    let filteredObj = null;
    let prn_lbl = null;
    let index = -1;
    let index_lbl = -1;

    $('#sel_label_printer').on('change', function(){
      $('#sel_nama_printer option').removeAttr("selected");
      
      get_label_printer = $(this).val();
      console.log(get_label_printer);      
      
      prn_lbl = pr_all.db.find(function(item_lbl, i_lbl){
        if(item_lbl.name == get_label_printer){
          index_lbl = i_lbl;
          // console.log(item_lbl, i_lbl);
          return item_lbl;
        }
      });
      console.log(index_lbl, prn_lbl);

      
      filteredObj = pr_all.connected.find(function(item, i){
        if(item.str == prn_lbl.str){
          index = i;
          return item;
        }else{
          return null;
        }
      });
      console.log(index, filteredObj);
      // filteredObjn.value = String.raw`${filteredObj.value}`.split('\\').join('/');
      
      if(filteredObj == undefined) {
        filteredObj = {'value' : ''};
        $("#sel_nama_printer").prop("selectedIndex", 0 ).change();
      }else
        $("#sel_nama_printer").prop("selectedIndex", (index+1) ).change(); // +1 karena pertama ada OPTION: --pilih--
      
        // $('#sel_nama_printer option[value="'+filteredObj.value+'"]').attr('selected', true); 
        //  ATAS, TIDAK BISA RUN, mungkin karena ada backslass \\ di nama printer
        
        get_nama_printer = $('#sel_nama_printer option:selected').val();
        console.log([get_label_printer, get_nama_printer, filteredObj.value, filteredObj.str]);
    });
    
    
    $('#sel_nama_printer').on('change', function(){
      $('#sel_nama_printer option').removeAttr("selected");
      
      $('#sel_nama_printer option[value="'+filteredObj.value+'"]').attr('selected', true);
      get_nama_printer = $('#sel_nama_printer option:selected').val();
      console.log([get_label_printer, get_nama_printer]);
    });
    
    
    $('#btn_update_printer').click(function(e){
      e.preventDefault();
      let label_printer = $('#sel_label_printer option:selected').val();
      let nama_printer  = $('#sel_nama_printer option:selected').text();
      if(nama_printer=='-pilih-') nama_printer= '';
      console.log([label_printer, nama_printer]);

      // UPDATE
      let upd = _db_update( {app_menu:'printer', name : label_printer}, 'xsetting', {value:nama_printer});
      console.log(upd);

      if(upd == null){
        alert('Update >> Sukses.');
      }else{
        alert('Update >> Gagal. Silahkan ulangi.');
      }

      // let str = $.escapeSelector( "\\192.168.1.104\TM-P230C Series" );
      // let str = "\\\\192.168.1.104\\TM-P230C Series"; echo: \\192.168.1.104\TM-P230C Series
      // var str = String.raw`\\192.168.1.104\TM-P230C Series`.split('\\').join('/');
      // alert(str);

    });
    
    $('#btn_add_printer').click(function(e){
      e.preventDefault();
      let in_printer_baru = $('#in_printer_baru').val();
      console.log(in_printer_baru);
      
      let exe_insert = _db_insert('xsetting', { app_menu: 'printer', name: in_printer_baru,} );
      console.log('>>RESPONSE INSERT DB XLINK');
      console.log(exe_insert);

      if(exe_insert == null){ alert('Proses Insert Sukses.');
      }else{ alert('Proses Insert Gagal. Silahkan ulangi.'); }

    });





  }

  //***************************************************/
  //       \bo/menu/it/setting/printer
  //***************************************************/


  //***************************************************/
  //        bo/menu/rm/other/perbaikan-karakter-aneh
  //***************************************************/
  if( open_site('bo/menu/rm/other/perbaikan-karakter-aneh') ){
    let dt = '',
        dt_mst = '';
    let id_user = '';

    $('button[name=btn_select_billing_karakter_aneh]').click(function(e){
      e.preventDefault();
      let nobill = $('input[name=nobill]').val();
      console.log('PENDAFTARAN PASIEN');
      dt = _ajax_web('GET', baseUrl()+'main/db/m_daftarmandiri/select_billing_karakter_aneh/'+nobill, '');
      console.log(dt);

      // ngeVIEW data master pasien saja
      console.log('MASTER PASIEN');
      dt_mst = _ajax_web('GET', baseUrl()+'main/db/m_daftarmandiri/select_billing_karakter_aneh_mstpx/'+dt[0].NoRM, '');
      console.log(dt_mst);

      $('input[name=norm]').val(dt[0].NoRM);
      $('input[name=nama]').val(dt[0].Nama);
      $('input[name=alamat]').val(dt[0].Alamat);
      $('input[name=rt]').val(dt[0].RT);
      $('input[name=rw]').val(dt[0].RW);
    });

    $('button[name=btn_update_billing_karakter_aneh]').click(function(e){
      let nobill = $('input[name=nobill]').val();
      let norm = $('input[name=norm]').val();
      console.log(nobill);

      let js = {
        Nama : $('input[name=nama]').val(),
        Alamat : $('input[name=alamat]').val(),
        RT : $('input[name=rt]').val(),
        RW : $('input[name=rw]').val()
      };
      console.log(js);

      let js_mstpx = {
        Nama : $('input[name=nama]').val(),
        Alamat : $('input[name=alamat]').val(),
        Rt : $('input[name=rt]').val(),
        Rw : $('input[name=rw]').val()
      };

      let update = _db_update({NoBill : nobill}, 'fotrdaftar', js);
      if(update == null){
        let update_mst = _db_update({NoRM : norm}, 'fomstpasien', js_mstpx);
        if(update_mst == null){
          alert('Proses Update di Pendaftaran dan Master Pasien, Sukses.');
        }else{
          alert('Proses Update Gagal. Silahkan ulangi.');
        }
      }else{
        alert('Proses Update Gagal. Silahkan ulangi.');
      }
    });
    
  }

  //***************************************************/
  //       \bo/menu/rm/other/perbaikan-karakter-aneh
  //***************************************************/

  
  //***************************************************/
  //        bo/menu/rm/surat/form-surat-ket
  //***************************************************/
  if( open_site('bo/menu/rm/surat/form-surat-ket') ){
    
    $('.datepickers').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

   

    let nobill = '';
    let id_sel = '';
    let dokter_sel = '';
    let js = null;

    $('form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    function fx_clear(){
      $("#btn_insert").show();
      $('.ada_surat').hide();

      // CLEAR form select, input, textarea, dsb.
      $('input[name=pcrTgl]').val('');
      $('select[name=pcr] option').removeAttr('selected');
      $('select[name=pcrHasil] option').removeAttr('selected');
      
      $('input[name=rapidTgl]').val('');
      $('select[name=rapid] option').removeAttr('selected');
      $('select[name=rapidHasil] option').removeAttr('selected');
      $('select[name=igM] option').removeAttr('selected');
      $('select[name=igG] option').removeAttr('selected');
      
      $('select[name=rad] option').removeAttr('selected');
      $('textarea[name=radKet]').text('');

      $('select[name=dokter] option').removeAttr('selected');
    }

    fx_clear();

    // bakul ud indo prima rasa
    $("input[name=nobill]").focus();
    $("input[name=nobill]").keypress(function (e) { //TEKAN ENTER
      // e.preventDefault();
      nobill = $(this).val();
      // console.log(norm);
      if (e.which == 13) {
        // js = _ajax_web('GET', baseUrl()+'main/db/m_daftarmandiri/px_by_bill/'+nobill, '');
        js = _ajax_web('GET', baseUrl()+'main/db_param/m_rm/getsurat_ket_by_nobill?param='+nobill, '');
        console.log(js);

        if(js.length<1){
          alert("Data pasien tidak ditemukan.");
          return false;
        }else{
          console.log(js.kodeSurat);
          if(js.kodeSurat == undefined){
            // BELUM PERNAH ENTRY SURAT
            fx_clear();
          }else{
            $("#btn_insert").hide();
            $('.ada_surat').show();

            $('input[name=kodeSurat]').val(js.kodeSurat);
            $('input[name=pcrTgl]').val(js.pcrTgl);
            $('select[name=pcr] option[value="'+js.pcr+'"]').attr('selected','selected');
            $('select[name=pcrHasil] option[value="'+js.pcrHasil+'"]').attr('selected','selected');
            
            $('input[name=rapidTgl]').val(js.rapidTgl);
            $('select[name=rapid] option[value="'+js.rapid+'"]').attr('selected','selected');
            $('select[name=rapidHasil] option[value="'+js.rapidHasil+'"]').attr('selected','selected');
            $('select[name=igM] option[value="'+js.igM+'"]').attr('selected','selected');
            $('select[name=igG] option[value="'+js.igG+'"]').attr('selected','selected');
            
            $('select[name=rad] option[value="'+js.rad+'"]').attr('selected','selected');
            $('textarea[name=radKet]').text(js.radKet);

            $('select[name=dokter] option[value="'+js.dokter+'"]').attr('selected','selected');
          
          
            /* ADD INPUT HIDDEN */ 
            // form = $('#form_ket');
            // form.addParameter = function(parameter,value){
            //   $("<input type='hidden' />")
            //   .attr("name", parameter)
            //   .attr("value", value)
            //   .appendTo(form);
            // };
            // form.addParameter("kodeSurat", 'XXX');

            function formAddInputHidden(form, parameter, value){
              $("<input type='hidden' />")
                .attr("name", parameter)
                .attr("value", value)
                .appendTo($(form));
            }

            // console.log( form.serialize() );
            formAddInputHidden('#form_ket', "kodeSurat", js.kodeSurat);
            console.log( $('#form_ket').serialize() );
            /*\ADD INPUT HIDDEN */ 
          
          }

          $("input[name=nama]").val(js.nama);
          $("input[name=usia]").val(js.umur);
          $("input[name=sex]").val(js.jeniskelamin_str);
          $("input[name=ktp]").val(js.noka);
          $("textarea[name=alamat]").val(js.alamat);

          // $('select[name=paket]').focus();

          // for (let p = 0; p < js.list_paket.length; p++)
          //   $('select[name=paket]').append('<option value="'+js.list_paket[p].idasesmen+'" data-idx="'+p+'">'+js.list_paket[p].idasesmen+'</option>');
          
        }

      }
    });


    $('select[name=pcr]').on('change', function(e){
      e.preventDefault();
      $(this).children().removeAttr('selected');
      let _selected = $(this).find('option:selected').val();
      if( _selected == 'Tidak' ){
        $('input[name=pcrTgl]').val('');
        $('select[name=pcrHasil] option').removeAttr('selected');
      }
    });
    
    $('select[name=rapid]').on('change', function(e){
      e.preventDefault();
      // console.log($(this).attr('name'));
      // $(this).find('option:selected').removeAttr('selected'); // TIDAK BISA HAPUS
      // let rapid_selected = $('select[name=rapid] option:selected').val();
      // $('select[name='+$(this).attr('name')+'] option').removeAttr('selected'); //BISA
      $(this).children().removeAttr('selected'); //BISA
      let _selected = $(this).find('option:selected').val();
      if( _selected == '' ){
        $('input[name=rapidTgl]').val('');
        $('select[name=rapidHasil] option').removeAttr('selected');
        $('select[name=igM] option').removeAttr('selected');
        $('select[name=igG] option').removeAttr('selected');
      }
    });


    $("#btn_insert").click(function(){     
      let url = $(this).attr('href');
      res = submitForm("#form_ket", url);
      console.log(url);
      console.log(res);

      if(res.response.xsurat.status == 'success' && res.response.xsurat_ket.status == 'success'){
        alert('Data berhasil disimpan.');
      }else{
        alert('Data gagal disimpan.');
      }
      return false;
    });
    
    $("#btn_update").click(function(){     
      let url = $(this).attr('href');
      res = submitForm("#form_ket", url);
      console.log(url);
      console.log(res);
      if(res==null){
        alert('Kode Surat berhasil diupdate');
      }
      return false;
    });
    
    $("#btn_delete").click(function(){     
      let url = $(this).attr('href')+'?kodeSurat='+ js.kodeSurat;
      console.log(url);
      res = _ajax_web('GET', url, '');
      console.log(res);
      if(res==null){
        alert('Kode Surat berhasil dihapus');
      }
      return false;
    });


    $("#btn_cetak").click(function(){ 
      if(nobill == ''){ alert('Nomor Billing belum diisi.'); return false; }
      console.log(nobill);
      // id_sel = $("select[name=paket]").find('option:selected').val();
      // if(id_sel == ''){ alert('Paket belum dipilih.'); return false; }

      popup_print_url('surat-ket/'+nobill);
      return false;      
    });


    
  }

 
  //***************************************************/
  //        \bo/menu/rm/surat/form-surat-ket
  //***************************************************/
 
  //***************************************************/
  //        bo/menu/rm/asesmen-rehab-medis
  //***************************************************/
  if( open_site('bo/menu/rm/asesmen-rehab-medis') ){
    
    $('.datepickers').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
    });

    $('input.cbox_tindakLanjut').on('ifChanged', function(e){ $(this).attr('value', (e.target.checked)? "1":"0" ) });


    $("#btn_update").hide();
    $("#btn_delete").hide();

    let norm = '';
    let id_sel = '';
    let dokter_sel = '';
    let dokterPerujuk_sel = '';
    let js = null;

    // $("#").click(function(e){
    //   e.preventDefault();

    // });

    // $(document).on('change', '.datepickers[]', function() { 
    // $(document).on('change', '.datepickers[name=tgl_end]', function(e) { 
    $(document).on('change', '.date_xls', function(e) { 
      // console.log(this);  
      $("#btn_dl_excel").attr('href', '');
      console.log($(".datepickers[name=tgl_start]").val(), $(".datepickers[name=tgl_end]").val());
      let href = baseUrl()+"main/xls/m_rm/list_rehab_by_rangedate/"
        +$(".datepickers[name=tgl_start]").val()+"/"
        +$(".datepickers[name=tgl_end]").val()
        +"?filename=list_rehab_by_rangedate_"
        +$(".datepickers[name=tgl_start]").val()+"_"
        +$(".datepickers[name=tgl_end]").val()
        ;
      $("#btn_dl_excel").attr('href', href);
    });

    $("input[name=norm]").focus();
    $("input[name=norm]").keypress(function (e) { //TEKAN ENTER
      // e.preventDefault();
      norm = $(this).val();
      // console.log(norm);
      if (e.which == 13) {
        js = _ajax_web('GET', baseUrl()+'main/db/m_rm/asesmen_rehab_medis_by_norm/'+norm, '');
        console.log(js);

        if(js.bio.length<1){
          alert("Data pasien tidak ditemukan.");
          return false;
        }else{
          $("input[name=nama]").val(js.bio.Nama);
          $("input[name=tglLahir]").val(js.bio.TglLahir);
          $("input[name=sex]").val(js.bio.Sex);
          $("textarea[name=alamat]").val(js.bio.Alamat);

          $('select[name=paket]').focus();

          for (let p = 0; p < js.list_paket.length; p++)
            $('select[name=paket]').append('<option value="'+js.list_paket[p].idasesmen+'" data-idx="'+p+'">'+js.list_paket[p].idasesmen+'</option>');
          
        }

      }
    });


    let paket_pilih = null;
    let tdkn_sel = [];
    $('select[name=paket]').on('change', function(){
      console.log('CHANGE>> select[name=paket]');
      // $('select[name=paket] option').removeAttr("selected");
      // $('select[name=paket] option[value="'+filteredObj.value+'"]').attr('selected', true);
      // id_sel = $('select[name=paket] option:selected').val();
      id_sel = $(this).find('option:selected').val();
      console.log(id_sel);

      if(id_sel != ''){
        idx_arr_paket = $(this).find('option:selected').data('idx');
        console.log(id_sel, idx_arr_paket, js.list_paket[idx_arr_paket]);

        // $('#btn_download').attr('href','');
  
        paket_pilih = js.list_paket[idx_arr_paket];
        $('input[name=tglPelayanan]').val(paket_pilih.tglPelayanan);
        $('textarea[name=anamnesa]').text(paket_pilih.anamnesa);
        $('textarea[name=fisik]').text(paket_pilih.fisik);
        $('textarea[name=penunjang]').text(paket_pilih.penunjang);
        $('input[name=dxPrimer]').val(paket_pilih.dxPrimer);
        $('input[name=dxSekunder]').val(paket_pilih.dxSekunder);
        $('textarea[name=tatalaksanaKFR]').text(paket_pilih.tatalaksanaKFR);
        $('textarea[name=anjuran]').text(paket_pilih.anjuran);

        // TAMBAHAN BARU 2021.03.19
        $('input[name=tglRujukan]').val(paket_pilih.tglRujukan);
        $('input[name=frekuensi]').val(paket_pilih.frekuensi);
        $('input[name=siklus]').val(paket_pilih.siklus);
        $('input[name=goal]').val(paket_pilih.goal);
        $('input[name=goalTgl]').val(paket_pilih.goalTgl);
        $('textarea[name=goalHasil]').text(paket_pilih.goalHasil);
        
        $('select[name=dokter] option').removeAttr("selected");
        $('select[name=dokter] option[value="'+paket_pilih.dokter+'"]').attr('selected', true);
        dokter_sel = $('select[name=dokter] option:selected').val();

        $('select[name=dokterPerujuk] option').removeAttr("selected");
        $('select[name=dokterPerujuk] option[value="'+paket_pilih.dokterPerujuk+'"]').attr('selected', true);
        dokterPerujuk_sel = $('select[name=dokterPerujuk] option:selected').val();

        tdkn_sel = _ajax_web("GET", baseUrl()+"main/db/m_rm/detail_tindakan_rehab_by_norm/"+norm+"/"+id_sel, "").detail_paket;
        console.log(tdkn_sel);

        //== checkbox tindakLanjut
        paket_pilih['arr_tindak'] = [];
        $('input.cbox_tindakLanjut').iCheck('uncheck').attr('value', 0);

        if(paket_pilih.tindakLanjut != ''){
          paket_pilih['arr_tindak'] = paket_pilih.tindakLanjut.split(',');
          // console.log(paket_pilih);          
          for(let i=0; i<paket_pilih['arr_tindak'].length; i++)
            $('input[name=tindak'+paket_pilih['arr_tindak'][i]+']').iCheck('check').attr('value', 1);          
        }
        //==\checkbox tindakLanjut

        create_tbody("#tbl_li_sel", tdkn_sel);

        $("#btn_paketbaru").hide();
        $("#btn_update").show();
        $("#btn_delete").show();
      }else{
        create_tbody("#tbl_li_sel", []);

        $("#btn_paketbaru").show();
        $("#btn_update").hide();
        $("#btn_delete").hide();
      }
    });

    

    let li = null;
    $("#btn_li_tindakan").click(function(){
      console.log('KLIK>> #btn_li_tindakan')
      if(norm == ''){ alert('NORM belum diisi.'); return false; }

      id_sel = $("select[name=paket]").find('option:selected').val();
      // console.log(id_sel);
      if(id_sel == ''){ alert('Paket belum dipilih.'); return false; }
      

      $('#mdl_body textarea').remove();
      
      li = js.list;
      console.log(li);
      
      let tbl = {
        id : 'tbl_mdl_store',
        headers : [
          ['nobill','No.Billing'], 
          ['detail_tx','Tindakan'],
          // ['Tarif_Include','Tarif Include', 'style="text-align:right;"','numeral']
        ],
        data : li,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'PILIH',
        },
      };
    
      let el_tbl = create_table_return(tbl, li); 
      // console.log(el_tbl);

      let mdl = {
        id    : 'modal_tindakan',
        bodyId: 'modal_list',
        size  : 'md',
        title : 'Daftar Tindakan',
        table : el_tbl,
      };
      let el = create_modal(mdl);

      // $('#modal_list').append(el_tbl);
      $('#modal_store_tindakan').append(el);
      $('#tbl_mdl_store').DataTable({"scrollX": true});
      
      $('#mdl_body').prepend('<textarea name="ket" rows="3" placeholder="Keterangan..."></textarea>');

      $('#modal_tindakan').modal('show');
    });
    

    function create_tbody(id, li){
      $(id+ ' tbody').children().remove();
      let el = '';
      for (let i = 0; i < li.length; i++) {
        el += '<tr data-id="'+i+'">'+
            '<td>'+(i+1)+'</td>'+
            // '<td>'+li[i]['nobill']+'</td>'+
            '<td>'+li[i]['nosep']+'</td>'+
            '<td>'+li[i]['TanggalMasuk']+'</td>'+
            '<td>'+li[i]['detail_tx']+'</td>'+
            '<td>'+li[i]['ket']+'</td>'+
            '<td><button class="btn-danger" data-id="'+i+'">x</button></td>'+
          '</tr>';        
      }
      $(id+ ' tbody').append(el);
    }


    
    // ('======[PILIH TINDAKAN]======');
    $(document).on('click','#tbl_mdl_store tbody tr td button', function(e){
      e.preventDefault();

      // $('textarea[name=ket]').val();
      
      console.log('======[PILIH TINDAKAN]======');
      let id = $(this).data('id');
      console.log(id);
      
      li[id].ket = $('textarea[name=ket]').val();
      js_selected = li[id];
      console.log(js_selected);

      tdkn_sel.push(js_selected);
      console.log(tdkn_sel);

      create_tbody("#tbl_li_sel", tdkn_sel);

      let P = {
        norm      : norm,
        idasesmen : id_sel,
        list      : tdkn_sel,
        paket_pilih : paket_pilih,
      };
      console.log(P);
      // return false;

      ins = _ajax_web("POST", baseUrl()+"rm/insert_batch_detail_tindakan_rehab", P);
      console.log(ins);

      $('#modal_tindakan').modal('hide');
    });


    // DELETE DETAIL TINDAKAN
    $(document).on('click','#tbl_li_sel tbody tr td button', function(e){
      e.preventDefault();
      let id = $(this).data('id');
      console.log('======[DEL]======');
      console.log(id);
      tdkn_sel.splice(id,1);
      console.log(tdkn_sel);
      create_tbody("#tbl_li_sel", tdkn_sel);

      let P = {
        norm : norm,
        idasesmen : id_sel,
        list : tdkn_sel,
      };
      console.log(P);
      // return false;
      
      ins = _ajax_web("POST", baseUrl()+"rm/insert_batch_detail_tindakan_rehab", P);
      console.log(ins);

    });

    $(document).on('hide.bs.modal','#modal_tindakan', function () {
      $('#tbl_mdl_store').DataTable().destroy();
      console.log('modal hide');
    });


    // https://stackoverflow.com/questions/11235622/jquery-disable-form-submit-on-enter
    // ERROR HANDLING FORM SUBMIT(ENTER BUTTON)
    $('form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });


    function clear_form(){
      // NETRALISIR. CLEAR FORM
      $('input[name=tglPelayanan]').val('');
      $('textarea[name=anamnesa]').text('');
      $('textarea[name=fisik]').text('');
      $('textarea[name=penunjang]').text('');
      $('input[name=dxPrimer]').val('');
      $('input[name=dxSekunder]').val('');
      $('textarea[name=tatalaksanaKFR]').text('');
      $('textarea[name=anjuran]').text('');
      $('input[name=tglRujukan]').val('');
      $('input[name=frekuensi]').val('');
      $('input[name=siklus]').val('');
      $('input[name=goal]').val('');
      $('input[name=goalTgl]').val('');
      $('textarea[name=goalHasil]').text('');
      create_tbody("#tbl_li_sel", []);
    }

    $("#btn_paketbaru").click(function(){
      if(norm == ''){ alert('NORM belum diisi.'); return false; }

      let url = $(this).attr('href');
      console.log(url);

      // let js_ins = _ajax_web("POST", baseUrl()+"insert_asesmen_rehab", {norm:norm, idasesmen:(js.list_paket.length+1) } );
      let js_ins = _ajax_web("POST", url, {norm:norm} );
      console.log(js_ins);

      if(js_ins.metadata.status=='success'){
        $('select[name=paket]').append('<option value="'+js_ins.idasesmen+'" data-idx="'+js_ins.idasesmen+'">'+js_ins.idasesmen+'</option>');
        
        $('select[name=paket] option').removeAttr("selected");
        $('select[name=paket] option[value="'+js_ins.idasesmen+'"]').attr('selected', true);
        id_sel = $('select[name=paket] option:selected').val();
        
        $('select[name=dokter] option').removeAttr("selected");
        $('select[name=dokter] option[value=""]').attr('selected', true);
        dokter_sel = $('select[name=dokter] option:selected').val();
        
        $('select[name=dokterPerujuk] option').removeAttr("selected");
        $('select[name=dokterPerujuk] option[value=""]').attr('selected', true);
        dokterPerujuk_sel = $('select[name=dokterPerujuk] option:selected').val();
        
        $("#btn_paketbaru").hide();
        $("#btn_update").show();
        $("#btn_delete").show();
  
        // CLEAR FORM
        clear_form();

      }else{
        alert(js_ins.metadata.message);
      }
      return false;
    });
    
    $("#btn_update").click(function(){     
      let url = $(this).attr('href');
      res = submitForm("#asesmen-form", url);
      console.log(url);
      console.log(res);
      return false;
    });
    
    $("#btn_delete").click(function(){     
      let url = $(this).attr('href');
      res = submitForm("#asesmen-form", url);
      console.log(url);
      console.log(res);
      reload();
      return false;
    });


    // !!!HAPUS
    // function popup_print_url(url=null){
    //   // let data = btoa( JSON.stringify(jpost) );
    //   // console.log(data);

    //   $("#div_frame").children().remove();
    //   let src = baseUrl()+"main/file_template/popup_print/"+url;
    //   $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
    //   window.frames['frame'].print();

    //   window.frames['frame'].onafterprint = function(){
    //     $("#div_frame").children().remove();
    //     //alert("Printing completed...");
    //     /////window.location = baseUrl()+"vclaim/tes_cetak";
    //   };

    // }

    

    
    $("#btn_cetak_protokol_terapi").click(function(){ 
      if(norm == ''){ alert('NORM belum diisi.'); return false; }
      id_sel = $("select[name=paket]").find('option:selected').val();
      if(id_sel == ''){ alert('Paket belum dipilih.'); return false; }

      popup_print_url('protokol-terapi-rehab/'+norm+'/'+id_sel);
      return false;
    });


    $("#btn_download").click(function(){
      if(norm == ''){ alert('NORM belum diisi.'); return false; }
      id_sel = $("select[name=paket]").find('option:selected').val();
      if(id_sel == ''){ alert('Paket belum dipilih.'); return false; }

      url = baseUrl()+"main/file_pdf/popup_print/protokol-terapi-rehab/"+norm+"/"+id_sel;
      window.open(url, '_blank');
      reload();
    });


    // !!!HAPUS
    // function submitForm(idForm=null, url=null){
    //   var data = $(idForm).serialize();

    //   let js_submit = _ajax_web("POST", url, data );
    //   return js_submit;

    //   // console.log(js);
    //   // return false;

    //   // $.ajax({
    //   //     type : 'POST',
    //   //     url  : url,
    //   //     data : data,
    //   //     success :  function(data){
    //   //         $(".display").html(data);
    //   //     }
    //   // });
    // }


  }
  //***************************************************/
  //       \bo/menu/rm/asesmen-rehab-medis
  //***************************************************/



  //***************************************************/
  //        bo/menu/receptionist/upload_data_billboard
  //***************************************************/
  if( open_site('bo/menu/receptionist/upload_data_billboard') ){
    let js = '',
        js_str = '',
        js_str_jadok = '';

    // LOAD BED & JADOK
      js = _ajax_web("GET", baseUrl()+"main/db/m_bed/cnt_info_tt_rs", "")['billboard'];
      console.log(js);
      js_str = JSON.stringify(js, null, 4);
      $('pre[name=val_js_all_bed]').text(js_str);

      let js_jadok = get_jadok_all();
      js_str_jadok = JSON.stringify(js_jadok.hr, null, 4);
      $('pre[name=val_js_all_jadok]').text(js_str_jadok);
    // \LOAD BED & JADOK

        
    $('button[name=btn_upld_bboard_bed_jadok_cm]').click(function(){
      let web = _ajax_web("GET", baseUrl()+"online/update_billboard_new" , "");
      console.log(web);

      if(web.response.res_bed_web == null){
        alert('Update bed berhasil.');
      }else{
        alert('Update bed gagal.');
      }

    });


    // let url = "https://www.google.co.id/complete/search?"+
    //   "q=jual%20madu&cp=9&client=psy-ab&xssi=t&gs_ri=gws-wiz&hl=en-ID"+
    //   "&authuser=0&psi=rJo7X4rFMN2Z4-EPrquF-A8.1597741746321"+
    //   "&dpr=0.8999999761581421&ei=rJo7X4rFMN2Z4-EPrquF-A8";
    // let web = _ajax_web("GET", url , '');
    // console.log(web);
    
  
  }

  //***************************************************/
  //       \bo/menu/receptionist/upload_data_billboard
  //***************************************************/



  //***************************************************/
  //        bo/menu/akuntansi/upload-verif-bpjs
  //***************************************************/
  if( open_site('bo/menu/akuntansi/upload-verif-bpjs') ){
    console.log('okay');
    $(".datepicker-bln").datepicker({
      autoclose : true,
      format  : 'yyyy-mm',
      startView: "months", 
      minViewMode: "months"
    });

    let get_date = '', status = '',
        bln = '',
        thn = '';

    $('#btn_ld').click(function(e){
      e.preventDefault();
      get_date = $('#date_1bln').val();
      status = $('#rjri').val();
      bln = parseInt( get_date.split('-')[1] );
      thn = get_date.split('-')[0];
      console.log([get_date, status, bln, thn]);

      if( $('#date_1bln').val() == ''){
        alert('Kolom kalender tidak boleh kosong.');
      }else{
        let js = _ajax_web("GET", baseUrl()+"main/db/m_akuntansi/lap_verif_inacbg/"+thn+"/"+bln+"/"+status, "");
        console.log(js);
        // window.open(baseUrl()+'ajaxreq/dl_xls_stat_hospital/'+thn_hunian_1thn+'/'+bln_hunian_1bln+'/1');
        
        let tbl = {
          id : 'tbl_ld_res',
          headers : [
            ['Nobill', 'NOBILL', 'style="text-align:center;"',], 
            ['NoRM','NORM'], 
            ['Nama','NAMA'], 
            ['Inacbg','INACBG', 'style="text-align:right;"', 'numeral'],
          ],
          data : js,
          button : null,
          // {
          //   color : 'success',
          //   head : 'OPSI',
          //   label : 'DETAIL',
          // },
        };
      
        let el_tbl = create_table_return(tbl, js); 
        
        $('#tbl_ld').children().remove();
        $('#tbl_ld').append(el_tbl);
        $('#tbl_ld_res').DataTable({"scrollX": true});


        $('#title_ld').text(status+' '+ bulan_indo(bln)+' '+thn);
      }
    });

    $("#myfile").change(function(e){
      let file = this.files[0];
      let filetype = file.type;
      console.log([file, filetype]);

      $.ajax({
        url: baseUrl()+'akuntansi/cek_upload_verif_bpjs',
        type: "POST",
        data: new FormData( $("#frmExcelImport")[0] ),
        processData: false,
        contentType: false,
        cache: false,
        // type: 'POST',
        success: function(data){
          // Swal.fire({
          //   position: 'center',
          //   type : 'success',
          //   title: 'Upload Berhasil.',
          //   showConfirmButton: true
          // });
          js = JSON.parse(data);
          console.log(js);
          $('#val_cek').text(js.join(', '));
        }
      });
      return false;
    });

    // $("#import").click(function(e){
    // $("#frmExcelImportt").submit(function(e){
    $("#frmExcelImport").on('submit',function(e){
      e.preventDefault();
      
      // console.log(this); return false;
      console.log('import');
      let frm = $(this);
      console.log(frm);
      // return false;
      $.ajax({
        // url: baseUrl()+'akuntansi/upload_verif_bpjs',
        type: frm.attr('method'), //ngambil dari form method
        url: frm.attr('action'),  //ngambil dari form action
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        // type: 'POST',
        success: function(data){
          Swal.fire({
            position: 'center',
            type : 'success',
            title: 'Upload Berhasil.',
            showConfirmButton: true
          });
        }
      });
      return false;


    });
  }
  //***************************************************/
  //       \bo/menu/akuntansi/upload-verif-bpjs
  //***************************************************/

  //***************************************************/
  //        bo/menu/akuntansi/laporan-pendapatan-dokter
  //***************************************************/
  if( open_site('bo/menu/akuntansi/laporan-pendapatan-dokter') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });


    let tgl_start = '',
        tgl_end   = '',
        kd_dokter = '',
        penanggung= '';

    $('button[name=btn_ld_dokter]').click(function(e){
      e.preventDefault();

      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();

      let js_dokter = _ajax('GET',"select_dokter_all_lappendapatandokter/"+tgl_start+"/"+tgl_end,'');
      console.log(js_dokter);

      $('select[name=sel_dokter]').children().remove();
      for(let i=0; i<js_dokter.length; i++){
        let el = '<option value="'+js_dokter[i].kodeDokter+'">'+js_dokter[i].kodeDokter+' - '+js_dokter[i].Nama+'</option>'
        $('select[name=sel_dokter]').append(el);
      }
      $('.select2').select2();

    });


    $('button[name=btn_ld_pendapatan_dokter]').click(function(e){
      e.preventDefault();
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      kd_dokter = $('select[name=sel_dokter]').val();
      penanggung= $('select[name=sel_penanggung]').val();

      console.log([tgl_start, tgl_end, kd_dokter, penanggung]);

      let dt = _ajax("GET","select_laporan_pendapatan_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/"+penanggung+"/0", "");
      console.log(dt);

      let dt_tes = _ajax("GET","select_voucher_hutang_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/0", "");
      console.log(dt_tes);

      ///=====
        let tot_netto = 0,
            tot_bruto = 0,
            tot_pph   = 0;
        $('table[name=tbl_select_laporan_pendapatan_dokter] tbody').children().remove();
        for(let i=0; i<dt.length; i++){
          tot_netto += parseFloat(dt[i].netto);
          tot_bruto += parseFloat(dt[i].bruto);
          tot_pph += parseFloat(dt[i].pph);
          // console.log([totalTarifRs, grandTotalRs]);
          
          let el =
            '<tr>'+
              '<td>'+(i+1)+'</td>'+
              '<td>'+dt[i].Tgl+'</td>'+
              '<td>'+dt[i].NoBill+'</td>'+
              '<td>'+dt[i].NoBukti+'</td>'+
              '<td>'+dt[i].Kode+'</td>'+
              '<td>'+dt[i].Dokter+'</td>'+
              '<td>'+dt[i].Tindakan+'</td>'+
              '<td>'+dt[i].NamaPasien+'</td>'+
              '<td style="text-align:right;">'+dt[i].bruto+'</td>'+
              '<td style="text-align:right;">'+dt[i].pph+'</td>'+
              '<td style="text-align:right;">'+dt[i].netto+'</td>'+
            '</tr>';
          $('table[name=tbl_select_laporan_pendapatan_dokter] tbody').append(el);
        }

        $("th[name=tot_bruto]").text(tot_bruto);
        $("th[name=tot_netto]").text(tot_netto);
        $("th[name=tot_pph]").text(tot_pph);

    });


    $('button[name=btn_download_pendapatan_dokter]').click(function(e){
      e.preventDefault();
      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      kd_dokter = $('select[name=sel_dokter]').val();
      penanggung= $('select[name=sel_penanggung]').val();

      window.open(baseUrl()+"ajaxreq/select_laporan_pendapatan_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/"+penanggung+"/1");
    });

  }


  //***************************************************/
  //       \bo/menu/akuntansi/laporan-pendapatan-dokter
  //***************************************************/

  //***************************************************/
  //       bo/menu/akuntansi/voucher-hutang
  //***************************************************/
  if( open_site('bo/menu/akuntansi/voucher-hutang') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $(".datepicker-bln").datepicker({
      autoclose : true,
      format  : 'yyyy-mm',
      startView: "months", 
      minViewMode: "months"
    });

    // //Money Euro
    // $('[data-mask]').inputmask();
    // $('.money').mask('000.000.000.000.000,00', {reverse: true});

    let tgl_start = '',
        tgl_end   = '',
        tgl_start_yerterday = '',
        tgl_end_yerterday   = '',
        kd_dokter = '',
        penanggung= '';
        
    $('button[name=btn_ld_dokter]').click(function(e){
      e.preventDefault();

      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();      
      tgl_start_yesterday = month_now_yesterday(tgl_start).yesterday.startday;
      tgl_end_yesterday   = month_now_yesterday(tgl_start).yesterday.endday;
      console.log([tgl_start, tgl_end, tgl_start_yesterday, tgl_end_yesterday]);

      let js_dokter = _ajax('GET',"select_dokter_all_lappendapatandokter/"+tgl_start+"/"+tgl_end,'');
      console.log(js_dokter);

      for(let i=0; i<js_dokter.length; i++){
        let el = '<option value="'+js_dokter[i].kodeDokter+'">'+js_dokter[i].kodeDokter+' - '+js_dokter[i].Nama+'</option>'
        $('select[name=sel_dokter]').append(el);
      }
      $('.select2').select2();
    });


    $('button[name=btn_ld_voucher]').click(function(e){
      e.preventDefault();

      tgl_start = $('input[name=tgl_start]').val();
      tgl_end   = $('input[name=tgl_end]').val();
      kd_dokter = $('select[name=sel_dokter]').val();


      let dt = _ajax("GET","select_voucher_hutang_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/0", "");
      console.log(dt);

      $("span[name=vendor]").text(kd_dokter);
      $("input[name=keterangan]").val("BY. HUTANG MEDIS - "+kd_dokter+" - BULAN "+dt.data.pendapatan_bpjs.bulan+" "+dt.data.pendapatan_bpjs.tahun+" + "+dt.data.pendapatan_nonbpjs.bulan+" "+dt.data.pendapatan_nonbpjs.tahun);

      $("input[name=trf_dokter_bpjs]").val(dt.data.pendapatan_bpjs.total);
      $("input[name=trf_dokter_nonbpjs]").val(dt.data.pendapatan_nonbpjs.total);
      $("input[name=trf_dokter_bhp_bpjs]").val(dt.data.bhp_bpjs.total);
      $("input[name=trf_dokter_bhp_nonbpjs]").val(dt.data.bhp_nonbpjs.total);
      
      $("span[name=bln_nonbpjs]").text(dt.data.pendapatan_nonbpjs.bulan+" "+dt.data.pendapatan_nonbpjs.tahun);
      $("span[name=bln_bpjs]").text(dt.data.pendapatan_bpjs.bulan+" "+dt.data.pendapatan_bpjs.tahun);
      $("span[name=bln_bhp_nonbpjs]").text(dt.data.bhp_nonbpjs.bulan+" "+dt.data.bhp_nonbpjs.tahun);
      $("span[name=bln_bhp_bpjs]").text(dt.data.bhp_bpjs.bulan+" "+dt.data.bhp_bpjs.tahun);
    });

    $('button[name=btn_addlist_voucher]').click(function(e){
      e.preventDefault();
      let pendapatan_bhp = $("select[name=sel_pendapatan_bhp]").val();
      let rjri = $("select[name=sel_rjri]").val();
      let penanggung = $("select[name=sel_penanggung]").val();
      let date = $("input[name=date]").val();
      let tgl_awal = date+"-01", 
          tgl_akhir= month_now_yesterday(date+"-01").now.endday;

      let val_tot = 0;
      let dt = _ajax("GET","select_laporan_dokter_det/"+pendapatan_bhp+'/'+date+'/'+kd_dokter+'/'+penanggung, "");
      console.log(dt);
      val_tot = dt.total;

      console.log([pendapatan_bhp, rjri, penanggung, date, tgl_awal, tgl_akhir]);
      let cnt_el = $("table[name=tbl_list_voucher_hutang]>tbody").children().length;
      let val_url_dl = pendapatan_bhp+'/'+date+'/'+kd_dokter+'/'+penanggung+'/1';
      let onclick="window.location.href='"+baseUrl()+"ajaxreq/select_laporan_dokter/"+val_url_dl+"'";
      let el = 
        '<tr data-id="'+(cnt_el+1)+'">'+
          '<td>'+(cnt_el+1)+'</td>'+
          '<td><button type="button" class="btn btn-success btn-flat" name="btn_dl_lap_dokter" data-val_url_dl="'+val_url_dl+'" onclick='+onclick+'>'+
                'Excel <i class="fa fa-arrow-circle-down"></i>'+
              '</button>'+
          '</td>'+
          '<td>'+pendapatan_bhp+' ('+penanggung+') - <span name="bln_bpjs">'+date+'</span></td>'+
          '<td>-</td>'+
          '<td>'+
            '<input name="trf_dokter_bpjs" type="text" class="money" style="width:80px; text-align:right;" disabled="disabled" value="'+val_tot+'">'+
          '</td>'+
          '<td>-</td>'+
          '<td>-</td>'+
          '<td><button type="button" class="btn btn-danger btn-flat btn_del" name="btn_dl_lap_dokter">'+
                '<i class="fa fa-trash"></i>'+
              '</button>'+
          '</td>'+
        '</tr>';
      $("table[name=tbl_list_voucher_hutang]>tbody").append(el);
    });



    // $('button.btn_del').click(function(e){
    $(document).on("click", "table[name=tbl_list_voucher_hutang]>tbody>tr>td>button.btn_del", function(e){
      let get_id = $(this).parent().parent().data('id');
      // console.log($(this).parent().parent().data('id'));
      console.log(get_id);
      $(this).parent().parent().remove();
    });

    $('button[name=btn_dl_pendapatan_nonbpjs]').click(function(e){
      e.preventDefault();
      window.open(baseUrl()+"ajaxreq/select_laporan_pendapatan_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/nonbpjs/1");
    });

    $('button[name=btn_dl_pendapatan_bpjs]').click(function(e){
      e.preventDefault();
      window.open(baseUrl()+"ajaxreq/select_laporan_pendapatan_dokter/"+tgl_start_yesterday+"/"+tgl_end_yesterday+"/"+kd_dokter+"/bpjs/1");
    });

    $('button[name=btn_dl_bhp_nonbpjs]').click(function(e){
      e.preventDefault();
      window.open(baseUrl()+"ajaxreq/select_laporan_pendapatan_dokter_bhp/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/nonbpjs/1");
    });

    $('button[name=btn_dl_bhp_bpjs]').click(function(e){
      e.preventDefault();
      window.open(baseUrl()+"ajaxreq/select_laporan_pendapatan_dokter_bhp/"+tgl_start_yesterday+"/"+tgl_end_yesterday+"/"+kd_dokter+"/bpjs/1");
    });

    $('button[name=btn_dl_detail_all_pdf]').click(function(e){
      e.preventDefault();
      $.redirect(baseUrl()+"ajaxreq/select_voucher_hutang_dokter/"+tgl_start+"/"+tgl_end+"/"+kd_dokter+"/0/1");
    });



  }

  //***************************************************/
  //       \bo/menu/akuntansi/voucher-hutang
  //***************************************************/



  //***************************************************/
  //        bo/menu/farmasi/laporan/selisih-klaim-obat-kronis
  //***************************************************/
  if( open_site('bo/menu/farmasi/laporan/selisih-klaim-obat-kronis') ){
    
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $('#btn_ld').click(function(e){
      e.preventDefault();
      // console.log('ld');
      if($('#in_datestart').val() == '' || $('#in_dateend').val() == ''){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      let js = _ajax_web("GET", baseUrl()+"main/db/m_farmasi/detail_rekap_obat_range_date/"+$('#in_datestart').val()+"/"+$('#in_dateend').val(), "");
      console.log(js);
  
      
      let tbl = {
        id : 'tbl_ld_res',
        headers : [
          ['nobilling', 'NOBILL', 'style="text-align:center;"',], 
          // ['NoRM','NORM'], 
          ['nama','NAMA'],
          ['nosep','NOSEP'],
          ['nobukti','NOBUKTI'],
          ['SUM_GTOT','SUM_GTOT', 'style="text-align:right;"', 'numeral'],
          ['verif','VERIF', 'style="text-align:right;"', 'numeral'],
          ['SELISIH','SELISIH(BPJS-RS)', 'style="text-align:right;"', 'numeral'],
        ],
        data : js,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'DETAIL',
        },
      };
    
      let el_tbl = create_table_return(tbl, js); 
      
      $('#tbl_store').children().remove();
      $('#tbl_store').append(el_tbl);
      $('#tbl_ld_res').DataTable({"scrollX": true});

    });


    $('#btn_dl_excel').click(function(e){
      e.preventDefault();
      if( $('#in_datestart').val() == '' || $('#in_dateend').val() == '' ){
        alert('Kolom tanggal tidak boleh kosong.');
        return 0;
      }

      let filename = "Lap Rekap Obat Kronis - "+$('#in_datestart').val()+"_"+$('#in_dateend').val();
      window.open(baseUrl()+'ajaxreq/xls/m_farmasi/detail_rekap_obat_range_date/'+$('#in_datestart').val()+"/"+$('#in_dateend').val()+"?filename="+filename, '');
        
    });
      



  }
  //***************************************************/
  //        \bo/menu/farmasi/laporan/selisih-klaim-obat-kronis
  //***************************************************/
  

  //***************************************************/
  //        bo/menu/akun-saya/ubah-password
  //***************************************************/
  

  if( open_site('bo/menu/akun-saya/ubah-password') ){
    let _user_logged_in = $('body').data('user_logged_in');
    $('input[name=username]').val(_user_logged_in);

    $('button[name=btn_ubah_password]').click(function(e){
      e.preventDefault();

      let pw_lama = $('input[name=pw_lama]').val();
      let pw_baru = $('input[name=pw_baru]').val();
      console.log([_user_logged_in, pw_lama, pw_baru]);

      // cek username password
      let cek_user_pw = _ajax_type('GET', 'json', baseUrl()+'user/my_username_password_check/'+_user_logged_in+'/'+pw_lama, '');
      console.log(cek_user_pw);

      if(cek_user_pw == true){
        console.log('oke');
        // ubah password
        let ubah_pw = _ajax_type('GET', 'json', baseUrl()+'user/my_password_change/'+_user_logged_in+'/'+pw_baru, '');
        console.log(ubah_pw);

        Swal.fire({
          position: 'center',
          type    : 'success',
          title   : 'Password Berhasil diubah.',
          showConfirmButton: true
        }).then(function(){
          $.redirect(baseUrl()+'user/logout');
        });          

        // SUKSES, session_destroy(). Ke halaman login
      }else{
        // Swal.fire('Password yang Anda masukkan tidak sesuai.');
        Swal.fire({
          position: 'center',
          type    : 'error',
          title   : 'Password yang Anda masukkan tidak sesuai.',
          showConfirmButton: true
        })
      }

    });

  }


  //***************************************************/
  //        \bo/menu/akun-saya/ubah-password
  //***************************************************/
  
  
  
  //***************************************************/
  //         bo/menu/it/dev/accelero
  //***************************************************/
  
  if( open_site('bo/menu/it/dev/accelero') ){
    window.addEventListener("deviceorientation", handleOrientation, true);

    function handleOrientation(event) {
      var absolute = event.absolute;
      var alpha    = event.alpha;
      var beta     = event.beta;
      var gamma    = event.gamma;
    
      // Do stuff with the new orientation data
    }

    let acc = handleOrientation(DeviceOrientationEvent);
    // let acc = handleOrientation();
    console.log(acc);
    console.log(DeviceOrientationEvent);

  }
  //***************************************************/
  //        \bo/menu/it/dev/accelero
  //***************************************************/


})




// === NOTE ===
  //>> ini keypress trigger. debuggernya jangan dihapus.
  // debugger
  // var e = $.Event("keypress");
  // e.keyCode = 13; // # Some key code value
  // $('input.in_icd').trigger(e);
// ===\NOTE ===
