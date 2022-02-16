$(function(event){
  let config_bpjs = {
    consid : ""
  };

  let _user_logged_in = '';

  // if($('input[name=user_logged_in]')[0] ){
  //   _user_logged_in = $('input[name=user_logged_in]').val(); //input[type:hidden] di setiap page
  // }
  // console.log('user:'+ _user_logged_in);

  _user_logged_in = $('body').data('user_logged_in');
  console.log('user_logged_in:'+ _user_logged_in );
  //$.backstretch("../img/rscm/RS Citra Medika-coloring2-light.jpg");
  //$.backstretch("images/RS Citra Medika-coloring2-light.jpg");



  //let pathnames = getUrl.pathname.split('/')[1] + "/" + getUrl.pathname.split('/')[2] + "/" + getUrl.pathname.split('/')[3] + "/" + getUrl.pathname.split('/')[4] + "/";
  
	var fullDate = new Date();
	console.log(fullDate);
	//Thu Otc 15 2014 17:25:38 GMT+1000 {}
	  
	//convert month to 2 digits
	var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) :(fullDate.getMonth()+1);
	var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
	//alert(currentDate);
	
	let contentType ="application/x-www-form-urlencoded; charset=utf-8";
	if(window.XDomainRequest) contentType = "text/plain";


  $( ".datepicker" ).datepicker();
  $( ".datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd" );

  $('.select2').select2();

  //==================== [CLICK & SCROLL] ======================
    // var curDown = false,
    //  curYPos = 0,
    //  curXPos = 0;

    // $(window).mousemove(function(m){
    //  if(curDown === true){
    //    $(window).scrollTop($(window).scrollTop() + (curYPos - m.pageY)); 
    //    $(window).scrollLeft($(window).scrollLeft() + (curXPos - m.pageX));
    //  }
    // });

    // $(window).mousedown(function(m){
    //  curDown = true;
    //  curYPos = m.pageY;
    //  curXPos = m.pageX;
    // });

    // $(window).mouseup(function(){
    //  curDown = false;
    // });

  //====================\[CLICK & SCROLL] ======================
	
//sample
 // 	$('.inputx').keypress(function (e) {
	// 	if (e.which == 13) {
	// 		$('form#login').submit();
	// 		return false;    //<---- Add this line
	// 	}
	// });


  //*************************************************************************/
  //
  //                        page:vclaim/sep_cari
  //
  //*************************************************************************/

  if( open_site('vclaim/sep_cari') ){

  
    // $("input[name=noRujukanCari]").keypress(function (e) { //TEKAN ENTER
    //  noRujukan = $(this).val();
    // });
  

    
    $('button[name=btn_sep_resume_cetak]').click(function(){
      let js = get_data_sep( $('input[name=nosep_cari]').val() );
      let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );

        if(js.metaData.code == '200'){
          //alert(js.response.peserta.nama);
          $.ajax({
            async : false,
            url   : baseUrl()+"ajaxreq/encrypt_post_cetak",
            type  : "POST",
            data  : {
              noSep   : js.response.noSep,
              tglSep  : js.response.tglSep,
              noKartu : js.response.peserta.noKartu,
              nama    : js.response.peserta.nama,
              tglLahir: js.response.peserta.tglLahir,
              poli    : js.response.poli,
              diagnosa: js.response.diagnosa,
              catatan : js.response.catatan,
              umurSaatPelayanan : js_rujukan.response.rujukan.peserta.umur.umurSaatPelayanan,
              sex     : js_rujukan.response.rujukan.peserta.sex,

              noTelepon   : js_rujukan.response.rujukan.peserta.mr.noTelepon,
              provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
              jnsPelayanan: js.response.jnsPelayanan,
              kelasRawat  : js.response.kelasRawat,
              jnsPeserta  : js.response.peserta.jnsPeserta,
              asuransi    : js.response.peserta.asuransi,
              penjamin    : js.response.penjamin
            },
            success:function(data){         
              let src = baseUrl()+"ajaxreq/tes_cetak_enc/?js="+data;
              //alert(src);

              var iframe = $('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
              $("#div_frame").append(iframe);
              window.frames['frame'].print();

              window.frames['frame'].onafterprint = function(){
                //$("#div_frame").find("#frame").remove();
                $("#div_frame").children().remove();
                //alert("Printing completed...");
                /////window.location = baseUrl()+"vclaim/tes_cetak";
              };

            },
            error:function(jqXHR,textStatus,errorThrown){
              alert("Error SEP Cari By Noka: "+errorThrown);
            }
          });
        }else{
          alert('Pencarian SEP tidak berhasil. [message]='+js.metaData.message);
        }          
          
    });


    $('button[name=btn_sep_cetak]').click(function(){
      let data = encrypt_post_cetak( $('input[name=nosep_cari]').val() );   

      let src = baseUrl()+"ajaxreq/cetak_sep_enc_to_frame/?js="+data;
      //alert(src);

      var iframe = $('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
      $("#div_frame").append(iframe);
      window.frames['frame'].print();

      window.frames['frame'].onafterprint = function(){
        //$("#div_frame").find("#frame").remove();
        $("#div_frame").children().remove();
        //alert("Printing completed...");
        /////window.location = baseUrl()+"vclaim/tes_cetak";
      };
          
    });

    $('button[name=btn_cetak_bukti_daftar]').click(function(){
      let printer = $("#printer").val();
      $.ajax({
          url  : baseUrl()+"ajaxreq/cetak_bukti_daftar_request",
          type : "POST",
          data : "nama_printer="+printer,
          success: function(data, textStatus, jqXHR){
              alert('[Alamat::'+data+'] '+'Data Sudah Dicetak Ke Printer : '+printer);
          }
      });

    });

    $('button[name=btn_cetak_nomor_antrian]').click(function(){
      let printer = $("#printer").val();
      $.ajax({
          url  : baseUrl()+"ajaxreq/cetak_nomor_antrian",
          type : "POST",
          data : "nama_printer="+printer,
          success: function(data, textStatus, jqXHR){
              alert('[Alamat::'+data+'] '+'Data Sudah Dicetak Ke Printer : '+printer);
          }
      }); 
    });
   

    $('button[name=btn_cetak_tracer]').click(function(){
      //alert('ok');
      let printer = $("#printer").val();
      $.ajax({
          url : baseUrl()+"ajaxreq/cetak_tracer",
          type: "POST",
          data : "nama_printer="+printer,
          success: function(data, textStatus, jqXHR){
              alert('[Alamat::'+data+'] '+'Data Sudah Dicetak Ke Printer : '+printer);
          }
      }); 
    });

  }

      //KAREPE KATE NGEDIT >> GOOGLE PRINT PREVIEW
      //document.getElementsByClassName('header-footer-checkbox')[0].checked=true;
      //$('input.user-value').val(80);
       

  //*************************************************************************/
  //
  //                        \page:vclaim/sep_cari
  //
  //*************************************************************************/


  //*************************************************************************/
  //
  //                        page:vclaim/sep_create_tes
  //
  //*************************************************************************/

    /***************      page:vclaim   ****************/
    if( open_site('vclaim') ){
      //alert("yuhu");
      $('button[name=btn_sep_create]').click(function(){
        //alert('oke');
        //iki ws1
        let jpost_sep_create = {
                 "request"  : {
                    "t_sep" : {
                      "noKartu" : $('input[name=noKartu]').val(),
                      "tglSep"  : moment().format('YYYY-MM-DD'),
                      "ppkPelayanan"  : '0195R028',
                      "jnsPelayanan"  : $('input[name=jnsPelayanan]').val(),
                      "klsRawat": $('input[name=klsRawat]').val(),
                      "noMR"    : $('input[name=noMR]').val(),
                      "rujukan" : {
                        "asalRujukan": '1',
                        "tglRujukan" : $('input[name=tglRujukan]').val(),
                        "noRujukan"  : $('input[name=noRujukan]').val(),
                        "ppkRujukan" : $('input[name=ppkRujukan]').val()
                      },
                      "catatan" : $('input[name=catatan_sep]').val(),
                      "diagAwal": $('input[name=diagAwal]').val(),
                      "poli"    : {
                        "tujuan"   : $('input[name=poli_tujuan]').val(),
                        "eksekutif": '0'
                      },
                      "cob" : {
                        "cob" : '0'
                      },
                      "jaminan" : {
                        "lakaLantas"  : '0',
                        "penjamin"    : '0',
                        "lokasiLaka"  : '0'
                      },
                      "noTelp": $('input[name=noTelp]').val(),
                      "user"  : $('input[name=user]').val()
                    }               
                  }
            };
            
          console.log(jpost_sep_create);

        $.ajax({
          async: false,
          url  : baseUrl()+"ajax_bpjs11/sep_create_bpjs",
          type :"POST",
          data : jpost_sep_create,
          success:function(data){
            console.log(data);
            let js = JSON.parse(data);
            alert(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/sep_create_bpjs]: "+errorThrown);
          }
        });
      });
    }
    /***************      \page:vclaim   ****************/

    /***************       page:vclaim/tes_katalog_bpjs   ****************/
    if( open_site('vclaim/tes_katalog_bpjs') ){
      
      //----------- panel:ref_diagnosa -----------------
      $('button[name=btn_ref_diagnosa]').click(function(){
        let _this = $(this);
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/ref_diagnosa",
          type     : "GET",
          data     : {
            //diagnosa : $('div[name=ref_diagnosa] div input[name=diagnosa]').val(),
            diagnosa : $(this).parent().find('input[name=diagnosa]').val()
          },
          success:function(data){
            $(_this).parent().parent().find('textarea.val').val(data);
            //alert(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/ref_diagnosa]: "+errorThrown);
          }
        });

      });

      //-----------\panel:ref_diagnosa -----------------

      //----------- panel:ref_cari_dpjp -----------------
      $('button[name=btn_dokter_dpjp]').click(function(){
        let _this = $(this);
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/dokter_dpjp",
          type     : "GET",
          data     : {
            //diagnosa : $('div[name=ref_diagnosa] div input[name=diagnosa]').val(),
            pelayanan   : $(this).parent().find('input[name=inp_jnsPelayanan]').val(),
            tglPelayanan: $(this).parent().find('input[name=inp_tglPelayanan]').val(),
            Spesialis   : $(this).parent().find('input[name=inp_kd_spesialis]').val()
          },
          success:function(data){
            $(_this).parent().parent().find('textarea.val').val(data);
            //alert(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/dokter_dpjp]: "+errorThrown);
          }
        });

      });

      //-----------\panel:ref_cari_dpjp -----------------



      //----------- panel:pencarian_peserta -----------------


      $('button[name=btn_cari_peserta]').click(function(){
        //alert($('div[name=cari_peserta_by_noka] div input[name=in_noka]').val());
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/peserta_cari",
          type     : "GET",
          dataType : "json",
          data     : {
            noKartu : $('div[name=cari_peserta_by_noka] div input[name=in_noka]').val(),
            tglSep  : $('div[name=cari_peserta_by_noka] div input[name=in_tglPelayanan]').val()
          },
          success:function(data){
            console.log(data);
            let str = JSON.stringify(data);
            $('div[name=cari_peserta_by_noka] div textarea.val').val(str);
            //alert(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/peserta_cari]: "+errorThrown);
          }
        });

      });

      $('button[name=btn_cari_peserta_by_nik]').click(function(){
        //alert($('div[name=cari_peserta_by_noka] div input[name=in_noka]').val());
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/peserta_cari_by_nik",
          type     : "GET",
          dataType : "json",
          data     : {
            nik   : $('div[name=cari_peserta_by_nik] div input[name=in_nik]').val(),
            tglSep: $('div[name=cari_peserta_by_nik] div input[name=in_tglPelayanan]').val()
          },
          success:function(data){
            console.log(data);
            let str = JSON.stringify(data);
            $('div[name=cari_peserta_by_nik] div textarea.val').val(str);
            //alert(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/peserta_cari_by_nik]: "+errorThrown);
          }
        });

      });


      //-----------\panel:pencarian_peserta -----------------

      //----------- panel:cari_rjk_by_norujukan -----------------
      $('button[name=btn_cari_rjk_by_norujukan]').click(function(){
        let _this = $(this);
        let noRujukan = $(this).parent().find('input[name=noRujukan]').val();
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/rujukan",
          type     : "GET",
          data     : {
            noRujukan   : noRujukan
          },
          success:function(data){
            $(_this).parent().parent().find('textarea.val').val(data);
            console.log(JSON.parse(data) );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/cari_rjk_by_norujukan]: "+errorThrown);
          }
        });
      });

      //-----------\panel:cari_rjk_by_norujukan -----------------

      //----------- panel:cari_rjk_by_noka_multi -----------------
      $('button[name=btn_cari_rjk_by_noka_multi]').click(function(){
        let _this = $(this);
        let noka = $(this).parent().find('input[name=noka]').val();
        $.ajax({
          async    : false,
          url      : baseUrl()+"ajax_bpjs11/rujukan_multirecord",
          type     : "GET",
          data     : {
            noka   : noka
          },
          success:function(data){
            $(_this).parent().parent().find('textarea.val').val(data);
            console.log(JSON.parse(data) );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajax_bpjs11/cari_rjk_by_noka_multi]: "+errorThrown);
          }
        });
      });

      //-----------\panel:cari_rjk_by_noka_multi -----------------

    }
      


    /***************      \page:vclaim/tes_katalog_bpjs   ****************/



  //*************************************************************************/
  //
  //                        \page:vclaim/sep_create_tes
  //
  //*************************************************************************/



  //*************************************************************************/
  //
  //                        page:daftarmandiri/admin
  //
  //*************************************************************************/


  //console.log(buat_antrian_klinik_baru());


  let rujukan_jsObj = '',
      rjk_opt_jsObj = '', // ini utk rujukan multi record array
      rjk_sel_jsObj = '', // ini utk rujukan multi record yang dipilih 
      get_norujukan = '',
      get_noka = '', 
      get_statusKode, 
      get_statusKet, 
      get_tglKunjungan,
      get_poliNama_bpjs = '',
      get_poliKode_bpjs = '',
      get_ppkRujukan = '', 
      get_ppkRujukan_nama='', 
      get_jnsPelayanan, 
      get_klsRawat, 
      get_diagAwal = '',
      get_telp_bpjs= '',
      get_sex_bpjs = '',
      get_umur_bpjs= '',
      get_asalRujukan_bpjs= 1; // {asal rujukan ->1.Faskes 1, 2. Faskes 2(RS)}

  let get_tglLahir = '';

  let pasien_cm_Obj,
      get_norm_cm = '',
      get_nama_cm = '',
      get_alamat_cm = '',
      get_telp_cm = '',
      get_hp_cm  = '',
      get_sex_cm = '',
      get_umur_cm= '';

  let noskdp = '',
      noskdp_lama = '',
      noskdp_bpjs = '';

  let digit_noRujukan = 19,
      digit_noka      = 13,
      cnt_noAction    = 0,
      durasi_noAction = 10 ; //10detik

  let namaDokter_pilih= '', 
      spesialis_pilih = '',
      get_kode_lokasi = '',
      get_kode_dokter = '',
      get_kode_dokter_bpjs = '',
      get_durasi_lokasi = '',
      get_durasi_lokasi_total = '',
      get_jamMasuk_dokter = '',
      get_ket_fo = '',
      get_ket_mst_px = '';

  let klinik_jsObj;

  let get_nosep_temp = ''; //nosep yang didapat setelah create_sep

  let jpost_cetak_skdp,
      jpost_cetak_resume_sep;

  let booking = false, //var TOOGLE untuk memilih BOOKING(true) / DAFTAR LANGSUNG(false)
      _FL_ambil_px_book= 0, book_id_date='', book_id_time='', //var untuk UPDATE di fotrbooking
      _FL_daftar_ugd = 0; 


  let get_instansi_kode_bpjs = '',
      get_instansi_nama_bpjs = '',
      get_instansi_kode_cm = '',
      get_instansi_nama_cm = '';

  let st_bill_rm = '',
      st_px_baru_lama = ''; // BARU/LAMA

  // let get_penanggung_cm_kode ='',
  //     get_penanggung_cm_nama ='',
  //     get_penanggung_cm_st   ='U';

  let get_penanggung_cm_kode ='CO031',
      get_penanggung_cm_nama ='B P J S',
      get_penanggung_cm_st   ='M';
  let get_cara_masuk_cm      = '',
      get_rujukan_dari_db_cm = '',
      get_instansi_cm        = '';

  let jpost_show = '';

  if( open_site('daftarmandiri/admin') ){

    // //testing VERSUS
    // let get_bill_datajs     = buat_bill_baru();
    // let get_bill_siap_pakai = get_bill_datajs.bill_baru;
    // let get_bill_4d         = get_bill_datajs.bill_baru_4d;
    // console.log('get_bill_siap_pakai: '+get_bill_siap_pakai+'_&&_get_bill_4d: '+get_bill_4d);

    // get_bill_datajs     = new_bill_by_php();
    // get_bill_siap_pakai = get_bill_datajs.new_bill;
    // get_bill_4d         = get_bill_datajs.new_bill_4d;
    // console.log('get_bill_siap_pakai: '+get_bill_siap_pakai+'_&&_get_bill_4d: '+get_bill_4d);

    

    //==================

    //load data penanggung_cm , lalu di masukkan ke select option
    let sel_penanggung_cm = gd_penanggung_cm();
    for(let i=0; i<sel_penanggung_cm.count; i++){
      $('select[name=sel_penanggung_cm]').append('<option value="'+sel_penanggung_cm.dtjs[i].Kode+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>');
    }


    // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
    $('select[name=sel_penanggung_cm] option').removeAttr('selected');
    $('select[name=sel_penanggung_cm] option[value='+get_penanggung_cm_kode+']').attr('selected','selected');



    // load gd_cara_masuk_cm ON select option
    let cara_masuk_cm = gd_cara_masuk_cm();
    for(let i=0; i<cara_masuk_cm.length; i++){
      $('select[name=sel_cara_masuk_cm]').append('<option value="'+cara_masuk_cm[i].Kode+'">'+cara_masuk_cm[i].Keterangan+'</option>');
    }


    // load gd_rujukan_dari_db_cm ON select option
    let rujukan_dari_db_cm = gd_rujukan_dari_db_cm();
    for(let i=0; i<rujukan_dari_db_cm.length; i++){
      $('select[name=sel_rujukan_dari_db_cm]').append('<option value="'+rujukan_dari_db_cm[i].kode+'">'+rujukan_dari_db_cm[i].ppk+'</option>');
    }

    
    let instansi_cm_all = gd_instansi_cm_all();
    for(let i=0; i<instansi_cm_all.length; i++){
      $('select[name=sel_instansi_cm_all]').append('<option value="'+instansi_cm_all[i].kode+'">'+instansi_cm_all[i].Keterangan+'</option>');
    }


      
    // ELEMENT SUDAH DIHAPUS,  BUAT NOTE BELAJAR
    $('#clr_sel').click(function(){
      //$('select[name=sel_cara_masuk_cm]').val('');
      //$('select[name=sel_cara_masuk_cm] option:selected').removeAttr("selected");
      //$('select[name=sel_cara_masuk_cm] option[value=""]').attr('selected','selected');
      console.log('klik');
      //$("select[name=sel_cara_masuk_cm]")[0].selectedIndex = 0;
      //$("select[name=sel_cara_masuk_cm]").val($("select[name=sel_cara_masuk_cm] option:first").val());
      //$("select[name=sel_cara_masuk_cm]").prop("selectedIndex", 0).change(); //BISA
      get_cara_masuk_cm      = $('select[name=sel_cara_masuk_cm]').val();
      get_rujukan_dari_db_cm = $('select[name=sel_rujukan_dari_db_cm]').val();
      get_instansi_cm        = $('select[name=sel_instansi_cm_all]').val();
      console.log(get_cara_masuk_cm+'_'+get_rujukan_dari_db_cm+'_'+get_instansi_cm);
    });

    

    $('select[name=sel_penanggung_cm]').on('change',function(){
      $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
      $("select[name=sel_cara_masuk_cm]").prop("selectedIndex", 0).change();
      $("select[name=sel_rujukan_dari_db_cm]").prop("selectedIndex", 0).change();
      $("select[name=sel_instansi_cm_all]").prop("selectedIndex", 0).change();

      
      if($(this).val() == ''){
        get_penanggung_cm_st = 'U';
      }else{
        get_penanggung_cm_st = 'M';
      }

      get_penanggung_cm_kode = $(this).val();
      get_penanggung_cm_nama = $('select[name=sel_penanggung_cm] option:selected').text();
      //console.log(get_penanggung_cm_nama);

      if(get_penanggung_cm_kode == 'CO031'){
        $('div[name=form_add_else_bpjs]').hide();
        //input val reset
      }else{
        $('div[name=form_add_else_bpjs]').show();
      }
      
      console.log(get_penanggung_cm_st+'_'+get_penanggung_cm_kode+'_'+get_penanggung_cm_nama);
    });


    $("input[name=diagkey_bpjs]").keypress(function (e) { //TEKAN ENTER
      let diagkey_bpjs = $(this).val();
      if (e.which == 13) {
        $('select[name=sel_diag_bpjs]').children().remove();

        let jsObj_diag = ref_diagnosa(diagkey_bpjs).response.diagnosa;
        console.log(jsObj_diag);

        for(let i=0; i<jsObj_diag.length; i++){
          $('select[name=sel_diag_bpjs]').append('<option value="'+jsObj_diag[i].kode+'">'+jsObj_diag[i].nama+'</option>');
        }

      }
    });




    // let _run_scan_rjk = 1;

    setInterval(function(){
      if($('input[name=scan_noka]').val() != undefined){
        if( $('input[name=scan_noka]').val().length == digit_noka){

          scan_rujukan();

        }else{
          //hitung 10 detik
          cnt_noAction++;
          if(cnt_noAction == durasi_noAction && $('input[name=scan_noka]').val() != ''){
            set_default_formDaftar_admin();
            cnt_noAction = 0;
          }
        }
      }
        
      
    }, 1000 );

    //TOGGLE CHECKBOX BOOKING
    $('input[name=cbox_booking]').click(function(){
      booking = $(this).is( ":checked" );
      console.log(booking);
      if(booking == true){
        $('button[name=btn_daftarrj]').text('Booking');
      }else{
        $('button[name=btn_daftarrj]').text('Daftar');
      }
    });

  

    function scan_rujukan(){
      //console.log( get_data_rujukan($('input[name=noRujukan]').val()) ); 
      //////////get_norujukan = $('input[name=noRujukan]').val();
      get_noka = $('input[name=scan_noka]').val();

      //////////////////////////rujukan_jsObj   = get_data_rujukan( get_norujukan ); // get data rujukan by noRujukan
      // rujukan_jsObj   = get_data_rujukan_by_noka( get_noka );
      rujukan_jsObj   = gd_rujukan_multi_by_noka( get_noka );
      console.log(rujukan_jsObj);

      // BRIDGING TIDAK DI RESPONSE/MASALAH JARINGAN
      if(rujukan_jsObj == undefined){
        alert('Bridging BPJS LEMOT/ERROR NASIONAL.');
        console.log('Bridging BPJS LEMOT ATAU ERROR NASIONAL/koneksi internet bermasalah.');
        $('input[name=scan_noka]').val('').focus();
      }else{
        // BRIDGING DI RESPONSE
        if(rujukan_jsObj.metaData.code == 200){ // RUJUKAN AKTIF
          rjk_opt_jsObj   = rujukan_jsObj.response.rujukan;
          console.log(rjk_opt_jsObj);
          
          show_mdl_multi_rjk();
        }else if(rujukan_jsObj.metaData.code == 201){ 
          // RUJUKAN TIDAK ADA. Multi RJK =null && TIDAK ADA MASALAH PEMBAYARAN
          console.log([rujukan_jsObj.metaData.code, rujukan_jsObj.metaData.message]);
          validate();
        }else{ // >>Rujukan tidak ada & masalah kepesertaan(ADA PREMI)
          console.log([rujukan_jsObj.metaData.code, rujukan_jsObj.metaData.message]);
          $('#daftar_error').append( '<div class="alert alert-danger">'+rujukan_jsObj.metaData.message+'</div>' );
        }

        $('input[name=scan_noka]').val('');
      }        
      
    }

    function show_mdl_multi_rjk(){
      $('table[name=tbl_list_rjk_multi] tbody').children().remove();

      for(let i=0; i<rujukan_jsObj.response.rujukan.length; i++){
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

      $('table[name=tbl_list_rjk_multi]').DataTable();
      $('#modal_list_rjk_multi').modal('show');
    }

    $(document).on('click', 'button[name=btn_mdl_plh_rjk]', function(){
      //let id_rjk_selected  = $(this).parent().parent().find('td[name=lokasi]').data('kd_lokasi');
      let id_rjk_selected  = $(this).parent().parent().data('id');
      console.log('id_rjk_selected= '+id_rjk_selected);
      rjk_sel_jsObj = rjk_opt_jsObj[id_rjk_selected];
      $('#modal_list_rjk_multi').modal('hide');
      validate();

    });




    function validate(){
      let _FLAG_cari_norm = 0;
      $('#daftar_error').children().remove();
            
      if(rujukan_jsObj.metaData.code == 200){
        //get_noka        = rujukan_jsObj.response.rujukan.peserta.noKartu;
        get_norujukan   = rjk_sel_jsObj.noKunjungan;
        get_statusKode  = rjk_sel_jsObj.peserta.statusPeserta.kode;
        get_statusKet   = rjk_sel_jsObj.peserta.statusPeserta.keterangan;
        get_tglKunjungan= rjk_sel_jsObj.tglKunjungan;
        //////console.log(get_noka+'_'+get_statusKode+'('+get_statusKet+')'+'_'+get_tglKunjungan+'_');
        get_tglLahir  = rjk_sel_jsObj.peserta.tglLahir;
        get_umur_bpjs = rjk_sel_jsObj.peserta.umur.umurSaatPelayanan;
        get_sex_bpjs  = rjk_sel_jsObj.peserta.sex;
        get_poliNama_bpjs = rjk_sel_jsObj.poliRujukan.nama;
        get_poliKode_bpjs = rjk_sel_jsObj.poliRujukan.kode;

        get_ppkRujukan  = rjk_sel_jsObj.provPerujuk.kode;
        get_ppkRujukan_nama  = rjk_sel_jsObj.provPerujuk.nama;
        get_jnsPelayanan= rjk_sel_jsObj.pelayanan.kode;
        get_klsRawat    = rjk_sel_jsObj.peserta.hakKelas.kode;
        get_diagAwal    = rjk_sel_jsObj.diagnosa.kode;
        get_telp_bpjs   = rjk_sel_jsObj.peserta.mr.noTelepon;

        get_instansi_kode_bpjs = rjk_sel_jsObj.peserta.jenisPeserta.kode;
        get_instansi_nama_bpjs = rjk_sel_jsObj.peserta.jenisPeserta.keterangan;
        get_instansi_kode_cm   = gd_instansi_cm(get_instansi_kode_bpjs, get_instansi_nama_bpjs).datajs[0].kode;

        klinik_jsObj = get_klinik_ket(get_poliKode_bpjs);

        // console.log('[klinik_jsObj]::');
        // console.log(klinik_jsObj);
      }else if(rujukan_jsObj.metaData.code == 201){ // Rujukan tidak ada
        //$('#daftar_error').append( '<div class="alert alert-danger">'+rujukan_jsObj.metaData.message+'</div>' );
        //TAMBAHI tombol lewati. Jika lewati, cari peserta by noka
        $('#daftar_error').append( get_err_code('e_reg_rc_rjk_tdk_ada').html );

        px_bpjs_Obj = gd_peserta_by_noka(get_noka);
        console.log(px_bpjs_Obj);
        if(px_bpjs_Obj.metaData.code == 201){ //Peserta Tidak Terdaftar
          $('#daftar_error').append( '<div class="alert alert-danger">'+px_bpjs_Obj.metaData.message+'</div>' );
        }else if(px_bpjs_Obj.metaData.code == 200){
          get_norujukan   = '1111111111111111111';//19digit
          get_statusKode  = px_bpjs_Obj.response.peserta.statusPeserta.kode;
          get_statusKet   = px_bpjs_Obj.response.peserta.statusPeserta.keterangan;
          get_tglKunjungan= moment().format('YYYY-MM-DD');//?moment().format('YYYY-MM-DD')
          //////console.log(get_noka+'_'+get_statusKode+'('+get_statusKet+')'+'_'+get_tglKunjungan+'_');
          get_tglLahir  = px_bpjs_Obj.response.peserta.tglLahir;
          get_umur_bpjs = get_umur_fx(px_bpjs_Obj.response.peserta.tglLahir,'tahun');//get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun')
          get_sex_bpjs  = px_bpjs_Obj.response.peserta.sex;

          get_ppkRujukan  = px_bpjs_Obj.response.peserta.provUmum.kdProvider;
          get_ppkRujukan_nama  = px_bpjs_Obj.response.peserta.provUmum.nmProvider;
          get_jnsPelayanan= '2';
          get_klsRawat    = px_bpjs_Obj.response.peserta.hakKelas.kode;
          get_telp_bpjs   = px_bpjs_Obj.response.peserta.mr.noTelepon;
          get_diagAwal    = '';// kolom icd

          get_instansi_kode_bpjs = px_bpjs_Obj.response.peserta.jenisPeserta.kode;
          get_instansi_nama_bpjs = px_bpjs_Obj.response.peserta.jenisPeserta.keterangan;
          get_instansi_kode_cm   = gd_instansi_cm(get_instansi_kode_bpjs, get_instansi_nama_bpjs).datajs[0].kode;

          klinik_jsObj = get_klinik_ket(get_poliKode_bpjs);

        }

      }else{ // >>Tidak dapat respon
        $('#daftar_error').append( '<div class="alert alert-danger">'+rujukan_jsObj.metaData.message+'</div>' );
        //alert(rujukan_jsObj.metaData.message);
      }



          console.log('[klinik_jsObj]::');
          console.log(klinik_jsObj);

          console.log(
              get_norujukan+'__'+get_statusKode+'__'+get_statusKet+'__'+
              get_tglKunjungan+'__'+get_tglLahir+'__'+get_umur_bpjs+'__'+
              get_sex_bpjs+'__'+get_ppkRujukan+'__'+get_ppkRujukan_nama+'__'+get_jnsPelayanan+'__'+
              get_klsRawat+'__'+get_instansi_kode_bpjs+'__'+get_instansi_nama_bpjs+'__'+
              get_instansi_kode_cm
            );



      $('input[name=scan_noka]').val('');  
          

      // console.log( get_hitungBulanRujukan_by_noRujukan( get_norujukan ) );  // hapus ini jika tdk dipakai
      console.log('Tgl Kunjungan = '+get_tglKunjungan);
      console.log('Htg Selisih Bln Rjkn = '+ get_hitungBulanRujukan_by_tglKunjungan(get_tglKunjungan)); 

      
      if(get_statusKode == 0){ //NOKA AKTIF (0=AKTIF)
        console.log('StatusPeserta: '+get_statusKet);
        console.log('Status_rujukan3bln: '+st_Rujukan3Bln(get_tglKunjungan));

        if( st_Rujukan3Bln(get_tglKunjungan) == 'AKTIF' ){
          console.log('Rujukan aktif');
          //Cari noRM 
          _FLAG_cari_norm = 1;

        }else if( st_Rujukan3Bln(get_tglKunjungan) == 'HABIS' ){ //Rujukan 3 bulan habis   
          $('#daftar_error').append( get_err_code('e_reg_rc_3a').html );
        }else{ //Status Rujukan Tidak Terdefinisi.
          $('#daftar_error').append( get_err_code('e_reg_rc_2a').html );
        }

      }else{ //NOKA NONAKTIF (1=NONAKTIF)
        $('#daftar_error').append( get_err_code('e_reg_rc_1').html );
      }



      //masuk logika:: Cari No.RM dengan parameter NOKA di Master Pasien = 'ada'
      if(_FLAG_cari_norm == 1){
        console.log('[GET NOKA]= '+get_noka);
        pasien_cm_Obj = get_data_pasien_rscm(get_noka);
        console.log(pasien_cm_Obj);

        if(pasien_cm_Obj.count == 0){
          //NOKA pasien di db RSCM kosong 
          $('#daftar_error').append( get_err_code('e_reg_rc_5').html );
        }else if(pasien_cm_Obj.count == 1){ //jika data pasien di db RSCM ada. Memastikan passing data tidak error karena data json pasien kosong.
          get_norm_cm = pasien_cm_Obj.datajs[0].NoRM;
          get_alamat_cm= pasien_cm_Obj.datajs[0].Alamat;
          get_nama_cm  = pasien_cm_Obj.datajs[0].Nama;
          get_sex_cm   = pasien_cm_Obj.datajs[0].Sex;
          get_umur_cm  = get_umur_bpjs;

          st_bill_rm    = get_st_bill_rm_by_norm(get_norm_cm).st_bill_rm; // CLOSE/OPEN
          console.log('[st_bill_rm]:: '+st_bill_rm);
          if(st_bill_rm == 'open'){
            alert('Billing AKTIF. Tidak boleh mendaftar');
          }else if(st_bill_rm == 'close'){
            console.log('Billing close.');
          }else{
            alert('Status Billing tidak diketahui sistem. Tidak boleh mendaftar');
          }

          st_px_baru_lama = gd_st_px_baru_lama_by_norm(get_norm_cm)[0].status_px;
          console.log('[st_px_baru_lama]:: '+st_px_baru_lama);

          jpost_show = {
              get_norm_cm : get_norm_cm,
              get_nama_cm : get_nama_cm,
              get_tglLahir: get_tglLahir,
              get_umur_cm : get_umur_cm,
              get_sex_cm  : get_sex_cm,
              get_alamat_cm : get_alamat_cm,
              klinikTujuan  : klinik_jsObj[0].Keterangan,
              get_noka      : get_noka,
              get_norujukan : get_norujukan,
              get_poliNama_bpjs : get_poliNama_bpjs,
              get_ket_fo    : get_tglKunjungan,
              get_diagAwal  : get_diagAwal
              // $('textarea[name=ket_mst_px]').val(js.datajs[0].Keterangan);
            }

          if(pasien_cm_Obj.datajs[0].flagkartu == 0){ //flagkartu = 0 (BELUM CETAK KARTU)
            let js_mrs = get_st_px_mrs_by_norm(get_norm_cm);
            if( js_mrs.count == 1 ){ // PX MRS
              //membatasi tombol lewati, supaya data tidak di show
              //alert('Billing RI terakhir kali'+js_mrs.datajs[0].NoBill);
              $('#daftar_error').append( get_err_code('e_reg_rc_4').html ); 
              $('#daftar_error').append( '<span>Billing RI terakhir kali: '+js_mrs.datajs[0].NoBill+'. Tanggal Masuk RI: '+js_mrs.datajs[0].TanggalMasuk+'</span>' ); 
            }else{ 
              $('#daftar_error').append( get_err_code('e_reg_rc_bukan_px_mrs').html ); 
            }
            

          }else{ //flagkartu = 1 (SUDAH CETAK KARTU)
            console.log('Lanjut langkah selanjutnya. Replace noka di db rscm...');           
            
            show_dataHTML_scan_noka_daftarrj(jpost_show);
          }
        }else{
          //ada >1 pasien memiliki NOKA sama (NOKA KEMBAR)  //e_reg_rc_5a
          $('#daftar_error').append( get_err_code('e_reg_rc_5a').html );
        }
      }
      /////////////////////////$('input[name=scan_noka]').val('');  

    }
    
    //------------------- div#daftar_error --------------------------
    $(document).on('click','button[name=btn_lewati_cetak_kartu]', function(){
      console.log('btn_lewati_cetak_kartu');
      show_dataHTML_scan_noka_daftarrj(jpost_show);
      $('input[name=pasienRscm_norm]').focus(); // setelah focusout, mengeluarkan data fomstpasien.keterangan
      $('input[name=skdp]').focus();

    });


    $(document).on('click','button[name=btn_lewati_rjk_tdk_ada]', function(){
      console.log('btn_lewati_rjk_tdk_ada');
      show_dataHTML_scan_noka_daftarrj(jpost_show);

    });
    //-------------------\#daftar_error --------------------------

    //================ CARI DOKTER
    function input_hdn(name,val){
      return '<input type="hidden" name="'+name+'" value="'+val+'">';
    }

      const digitNorm_Rscm = 6;

      $( "input[name=pasienRscm_norm]" ).focusout(function() {
        let norm = $(this).val();
        let hitungDigit = norm.length;
        
        if(hitungDigit != digitNorm_Rscm){
          alert("NoRM harus 6 digit");
        }else{
          let js = gd_pasien_rscm_by_norm(norm);

          if(js.count==1){
            $('span[name=pasienRscm_nama]').text(js.datajs[0].Nama);
            $('form').append(input_hdn('pasien_nama',js.datajs[0].Nama));

            $('span[name=pasienRscm_tglLahir]').text(js.datajs[0].TglLahir);
            $('form').append(input_hdn('pasien_tglLahir',js.datajs[0].TglLahir));

            $('span[name=pasienRscm_umur]').text(hitungUmur(js.datajs[0].TglLahir)+' Tahun');
            $('form').append( input_hdn('pasien_umur', hitungUmur(js.datajs[0].TglLahir) ));

            $('span[name=pasienRscm_jk]').text(js.datajs[0].Sex);
            $('form').append(input_hdn('pasien_jk',js.datajs[0].Sex));

            $('span[name=pasienRscm_alamat]').text(js.datajs[0].Alamat);
            $('form').append(input_hdn('pasien_alamat',js.datajs[0].Alamat));

            $('textarea[name=ket_mst_px]').val(js.datajs[0].Keterangan);

            $('select[name=pasienRscm_sukubangsa] option[value="'+js.datajs[0].Sukubangsa+'"]').attr('selected','selected');

          }else{
            $('span[name=pasienRscm_nama]').text('-');
            $('span[name=pasienRscm_tglLahir]').text('-');
            $('span[name=pasienRscm_umur]').text('-');
            $('span[name=pasienRscm_jk]').text('-');
            $('span[name=pasienRscm_alamat]').text('-');
          }
            
        }

      });

      //SYARAT : HARUS TAMPIL DATA DI TABEL INFO PASIEN_RSCM
      $('select[name=pasienRscm_sukubangsa]').on('change',function(){
        // $('select[name=sel_penanggung_cm] option[value=CO031]').removeAttr("selected");
        let norm = $('input[name=pasienRscm_norm]').val();
        // console.log(norm.length);
        if(norm != ''){
          let Sukubangsa = $(this).val();
          console.log(Sukubangsa);
          update_suku_bangsa(norm, Sukubangsa);
        }
      });

      $('input[name=cari_jadok]').click(function(){
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
          js = get_jadok_today(fl_klinik,spesialis);
        }
        
        //////////////let js = get_jadok_today(fl_klinik,spesialis);
            
        $('table[name=tbl_cari_jadok] tbody').children().remove();
        for(let i=0; i<js.dtjs.length; i++){
          let el = 
            '<tr>'+
              '<td>'+js.dtjs[i].hari+'</td>'+
              '<td name="nama" data-kode_dokter="'+js.dtjs[i].kodeDokter+'" data-kd_dpjp_bpjs="'+js.dtjs[i].kd_dpjp_bpjs+'" data-durasi="'+js.dtjs[i].durasi+'">'+js.dtjs[i].Nama+'</td>'+
              '<td name="spesialis" data-lokasi="'+js.dtjs[i].Lokasi+'">'+js.dtjs[i].Spesialis+'</td>'+
              '<td name="jamPraktek" data-jam_masuk="'+js.dtjs[i].jamMasuk+'">'+js.dtjs[i].jamMasuk+' - '+js.dtjs[i].jamPulang+'</td>'+
              '<td><button class="btn btn-success">Pilih</button></td>'+
            '</tr>';

          $('table[name=tbl_cari_jadok] tbody').append(el);
        }

        $('#modal_cari_jadok').modal('show');
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


      $('span[name=cari_skdp]').click(function(){
        let js = gd_skdp(get_norm_cm);
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
        // spesialis_pilih = $(this).parent().parent().find('td[name=Keterangan]').text();
        // namaDokter_pilih = $(this).parent().parent().find('td[name=NamaDokter]').text();
        get_kode_dokter_bpjs = $(this).parent().parent().find('td[name=NamaDokter]').data('kd_dpjp_bpjs');
        noskdp_bpjs = noskdp.substring(0, 6);
        $('#modal_cari_skdp').modal('hide');

        $('input[name=skdp]').val(noskdp_bpjs);
        // $('input[name=klinikTujuan]').val(spesialis_pilih);
        // $('input[name=cari_jadok]').val(namaDokter_pilih);
        $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
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
        $('#modal_cari_jadok').modal('hide');

        //alert(lokasi);
        console.log('[namaDokter_pilih]_[spesialis_pilih]_[get_kode_lokasi]_[get_kode_dokter]');
        console.log(namaDokter_pilih+'_'+spesialis_pilih+'_'+get_kode_lokasi+'_'+get_kode_dokter+'_'+get_kode_dokter_bpjs);
        console.log(get_durasi_lokasi+'_'+get_jamMasuk_dokter);
        $('input[name=cari_jadok]').val(namaDokter_pilih);
        $('input[name=klinikTujuan]').val(spesialis_pilih);
        $('input[name=kode_lokasi]').val(get_kode_lokasi);
        $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
      });


      /*====================== [CLICK DIV KLINIK TUJUAN] ====================*/
      $(document).on('click','.obyek', function(){
        let klinik_kode = $(this).data('id');
        let klinik_ket = $(this).text();

        // if(klinik_ket == 'U G D'){
        if(klinik_ket == 'I G D'){
          _FL_daftar_ugd = 1;
          get_poliKode_bpjs = 'IGD';
          spesialis_pilih   = klinik_ket;
          get_kode_lokasi   = klinik_kode;

          namaDokter_pilih  = 'dr. Lucky Dana Victory';
          get_kode_dokter   = '92516';

          $('input[name=klinikTujuan]').val(klinik_ket);
          $('input[name=cari_jadok]').val(namaDokter_pilih);

          console.log('[namaDokter_pilih]_[spesialis_pilih]_[get_kode_lokasi]_[get_kode_dokter]');
          console.log(namaDokter_pilih+'_'+spesialis_pilih+'_'+get_kode_lokasi+'_'+get_kode_dokter);

        }else{ // jika klinik_ket != IGD
          _FL_daftar_ugd = 0;
          /* 
            <CEK ADA/TIDAKNYA JADWAL SPESIALIS PADA HARI ITU> 
            Bila TIDAK ADA dokter yang hadir hari itu, muncul modal "Jadwal Spesialis" yg dipilih tersebut buka pada hari apa saja.
          */
          
          let js = get_jadok_today(1,klinik_ket); //fl_klinik : '1', //1= kliniknya diisi/sudah dipilih
          //console.log(js); //MENAMPILKAN HASIL JSON DARI JADWAL DOKTER SPESIALIS
          if(js.count == 0){
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
          }else{ //jika pada hari ini jadwal klinik yang SUDAH DIPILIH tersedia
            $('input[name=klinikTujuan]').val(klinik_ket);
            get_poliKode_bpjs = $(this).data('kdpoli_bpjs');
          }

          $('input[name=cari_jadok]').val('');
        }
        
        $('#modal_klinik').modal('hide');
        console.log(klinik_kode+'_'+klinik_ket);
        console.log(get_poliKode_bpjs);
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


      //================ \CARI DOKTER

      //let jpost_sep_create;
      // console.log(jpost_sep_create);
      // console.log('LUAR= '+jpost_sep_create.noTelp);
      
      $('button[name=btn_sep_create]').click(function(){
        let jpost_sep_create = {
             "request"  : {
                "t_sep" : {
                  "noKartu" : get_noka,
                  "tglSep"  : moment().format('YYYY-MM-DD'),
                  "ppkPelayanan"  : '0195R028',
                  "jnsPelayanan"  : get_jnsPelayanan,
                  "klsRawat": get_klsRawat,
                  "noMR"    : get_norm_cm,
                  "rujukan" : {
                    "asalRujukan": '1',
                    "tglRujukan" : get_tglKunjungan,
                    "noRujukan"  : get_norujukan,
                    "ppkRujukan" : get_ppkRujukan
                  },
                  "catatan" : $('input[name=catatan_sep]').val(),
                  "diagAwal": get_diagAwal,
                  "poli"    : {
                    "tujuan"   : get_poliKode_bpjs,
                    "eksekutif": '0'
                  },
                  "cob" : {
                    "cob" : '0'
                  },
                  "jaminan" : {
                    "lakaLantas"  : '0',
                    "penjamin"    : '0',
                    "lokasiLaka"  : '0'
                  },
                  "noTelp": $('input[name=telp]').val(),
                  "user"  : config_bpjs.consid
                }               
              }
            
        };


        console.log('[Data will send (sep_create)]::');
        console.log(jpost_sep_create);

        // console.log('[json_parse:: sep_create]::');
        // console.log(JSON.parse(jpost_sep_create) );

        //response_create_sep [== LIHAT KATALOG BPJS ==]
        let res_c_sep = sep_create_by_noka(jpost_sep_create); 
        console.log(res_c_sep);

        if(res_c_sep.metaData.code == 200 ){
          get_nosep_temp = res_c_sep.response.sep.noSep;
          console.log('nosep_created= '+ get_nosep_temp);
        }else{ //bila create_sep TIDAK SUKSES
          alert('Tidak sukses daftarkan SEP. Pesan dari BPJS = '+res_c_sep.metaData.message);
        }

      });


    //========================== MODAL AMBIL BOOKING ===========================

    //$('button[name=btn_ambil_pasien_booking]').click(function(){
    $('span[name=btn_ambil_pasien_booking]').click(function(){

      let tgl = moment( moment().subtract(1, 'day') ).format('YYYY-MM-DD'); //YESTERDAY !!!!!!!
      //let tgl = moment().format('YYYY-MM-DD'); //TODAY, IKI TES, sebenere yesterday
      let jsObj_booking = gd_booking(tgl);
      // console.log('[data all skdp]::');
      // console.log(js);
      $('span[name=span_ambil_tgl_book]').text(tgl);
      $('table[name=tbl_booking_daftar] tbody').children().remove();

      for(let i=0; i<jsObj_booking.dtjs.length; i++){
        let el = 
          '<tr data-id="'+jsObj_booking.dtjs[i].time+'" data-date="'+tgl+'">'+
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

      console.log('[namaDokter_pilih]_[spesialis_pilih]_[get_kode_lokasi]_[book_id_date]_[book_id_time]_[get_kode_dokter_bpjs]');
      console.log(namaDokter_pilih+'_'+spesialis_pilih+'_'+get_kode_lokasi+'_'+book_id_date+'_'+book_id_time+'_'+get_kode_dokter_bpjs);
      $('input[name=cari_jadok]').val(namaDokter_pilih);
      $('input[name=kd_dpjp_bpjs]').val(get_kode_dokter_bpjs);
      $('input[name=klinikTujuan]').val(spesialis_pilih);
      $('input[name=kode_lokasi]').val(get_kode_lokasi);


      $('#modal_ambil_px_booking').modal('hide');

      //console.log(namaDokter_pilih+'_'+spesialis_pilih+'_'+get_kode_lokasi);
      $('input[name=scan_noka]').val(get_noka);


      //delete DOM div_cbox_booking
      $('div[name=div_cbox_booking]').hide();
    });

    //==========================\MODAL AMBIL BOOKING ===========================




    //+++++++++++++TESSSSSS print iframe ++++++
    $('button[name=btn_cetak_resume_sep]').click(function(){ //BTN di ADMIN
      //let js = get_data_sep( $('input[name=nosep_cari]').val() );
      let js = get_data_sep( '0195R0280818V000316' ); //XX untuk TESTING PROGRAM, komen kalo sudah
      //let js = get_data_sep( get_nosep_temp ); //BRIDGING CARI SEP
      let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );

      if(js.metaData.code == '200'){
        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/encrypt_post_cetak",
          //url   : baseUrl()+"ajaxreq/look_post",
          type  : "POST",
          data  : {
            noSep   : js.response.noSep,
            norm    : get_norm_cm,
            alamat  : get_alamat_cm,
            tglSep  : js.response.tglSep,
            noKartu : js.response.peserta.noKartu,
            nama    : js.response.peserta.nama,
            tglLahir: js.response.peserta.tglLahir,
            poli    : js.response.poli,
            diagnosa: js.response.diagnosa,
            catatan : js.response.catatan,
            umurSaatPelayanan : js_rujukan.response.rujukan.peserta.umur.umurSaatPelayanan,
            sex     : js_rujukan.response.rujukan.peserta.sex,

            noTelepon   : js_rujukan.response.rujukan.peserta.mr.noTelepon,
            provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
            jnsPelayanan: js.response.jnsPelayanan,
            kelasRawat  : js.response.kelasRawat,
            jnsPeserta  : js.response.peserta.jnsPeserta,
            asuransi    : js.response.peserta.asuransi,
            penjamin    : js.response.penjamin,
            billing     : 'BL121212.1234'//'get_bill_siap_pakai'

          },
          success:function(data){    
          //console.log(data);     
            let src = baseUrl()+"ajaxreq/tes_cetak_enc?filename=sep_resume_cetak&js="+data;
            $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
            window.frames['frame'].print();

            window.frames['frame'].onafterprint = function(){
              //$("#div_frame").find("#frame").remove();
              $("#div_frame").children().remove();
              //alert("Printing completed...");
              /////window.location = baseUrl()+"vclaim/tes_cetak";
            };

          },
          error:function(jqXHR,textStatus,errorThrown){
            alert("Error SEP Cari By Noka: "+errorThrown);
          }
        });
      }else{
        alert('Pencarian SEP tidak berhasil. [message]='+js.metaData.message);
      }
    });




    ////////////////console.log(generateProductKey());
    

    $('#tes_prog').click(function(){
      // // console.log(get_durasi_lokasi+'_'+get_jamMasuk_dokter);
      // let noantri_3dgt_redy = '011';
      // let int_noantri_3dgt_redy = parseInt(noantri_3dgt_redy);

      console.log( waktu_pelayanan_klinik(get_jamMasuk_dokter+':00', '011', get_durasi_lokasi, 'HH:mm:ss' ) );
    });


    
       
    
    console.log(moment().format('YYYY-MM-DD'));
    console.log(moment().format('HH:mm:ss'));

    $('button[name=btn_daftarrj]').click(function(){
      console.log('__start_click_daftarrj__');
      let tc_klik_daftarrj = moment().format('HH:mm:ss'),
          tc_bill       = '',
          tc_noantrian  = '',
          tc_sep        = '',
          tc_insert_daftar_rj = '';


      if($('input[name=cari_jadok]').val()=='' || $('input[name=klinikTujuan]').val()=='' || $('select[name=pasienRscm_sukubangsa]').val()==''){
        alert('Kolom dokter spesialis / klinik tujuan / suku bangsa belum diisi.');
      }else{
        if(st_bill_rm == 'open'){
          alert('Billing AKTIF.');
        }else if(st_bill_rm == 'close'){ // bila STATUS_BILLING_CLOSE

          get_asalRujukan_bpjs = $('#asalRujukan_bpjs').val();
          if(get_asalRujukan_bpjs == 2){ // jika PPK 2(RS)
            console.log('<Log> Px MRS/dari PPK2');
            get_norujukan = $('#noRujukan_ppk2_bpjs').val();
            get_ppkRujukan= '0195R028';
          }

          pasien_cm_Obj = gd_pasien_rscm_by_norm(get_norm_cm); //dari scan input rujukan
          // console.log(pasien_cm_Obj);
          // console.log(buat_antrian_klinik_baru( get_kode_lokasi ));
          // console.log( get_kode_dokter );

          // create_billing LOGIKA AWAL
          // let get_bill_datajs     = buat_bill_baru(); // !![HARUS] pada saat 1 instruksi saja, supaya TIDAK mengCREATE bill lagi
          // let get_bill_siap_pakai = get_bill_datajs.bill_baru;
          // let get_bill_4d         = get_bill_datajs.bill_baru_4d;

          let get_bill_datajs     = new_bill_by_php();
          let get_bill_siap_pakai = get_bill_datajs.new_bill;
          let get_bill_4d         = get_bill_datajs.new_bill_4d;
          console.log('get_bill_siap_pakai: '+get_bill_siap_pakai+'_&&_get_bill_4d: '+get_bill_4d);

          tc_bill    = moment().format('HH:mm:ss');

          //if( noskdp == '' ){ }
          noskdp      = moment().format('DD') +get_bill_4d+'/KP/'+moment().format('MM')+'/'+moment().format('YYYY');
          // noskdp_bpjs = moment().format('DD') +get_bill_4d;
          // noskdp_bpjs = $('input[name=skdp]').val();
          
          let noantrian_ready_3digit = '',
              noantrian_ready_full   = '';
          let StatusDaftar_cm = 'RJ'; //default
          let fotrdaftar_pilih = {}; //var_json


          if(_FL_daftar_ugd == 0){ //JIKA BUKAN PASIEN UGD >> dapat antrian poli, cetak.
            noantrian_ready_3digit = ready_antrian_klinik_3digit( get_antrian_klinik( get_kode_lokasi ) ); //INI DIPAKAI PASSING
            noantrian_ready_full = ready_antrian_klinik_full( noantrian_ready_3digit ); //INI DIPAKAI PASSING
            tc_noantrian    = moment().format('HH:mm:ss');
            StatusDaftar_cm = 'RJ';

            let fotrdaftar_rj = {
              NoBill  : get_bill_siap_pakai,
              Lokasi  : $('input[name=kode_lokasi]').val(),
              NoUrut  : noantrian_ready_full,
              typedokter  : 1,
              Dokter      : get_kode_dokter,
              Pemeriksaan : 0,
              Biaya   : 0,
              Total   : 0,
              PemeriksaanUpDisc : 0,
              BiayaUpDisc : 0,
              TotalUpDisc : 0,
              FlagDaftar  : 0,
              Rujukan     : get_norujukan, //get_noRujukan,
              StatusPayment : "B", //B=belum
              KetRujukan  : "",
              Flagantrian : 1,
              tglrujukan  : get_tglKunjungan,
              User : _user_logged_in,
              Date : moment().format('YYYY-MM-DD'),
              Time : moment().format('HH:mm:ss'),
              CaraMasuk  : 1
            };

            fotrdaftar_pilih = fotrdaftar_rj;
            
          }else{ //JIKA PASIEN UGD
            StatusDaftar_cm = 'UG';

            let fotrdaftar_ugd = {
              nobill  : get_bill_siap_pakai,
              triage  : 0,
              dokterrs: "92516",
              TypeDokterJaga: 0,
              dokterjaga    : "92516",
              pemeriksaan   : 0,
              biaya   : 0,
              pemeriksaanupdisc: 0,
              biayaupdisc   : 0,
              total         : 0,
              totalupdisc   : 0,
              statuspayment : "B",
              keterangan  : "",
              kasuspolisi : "T",
              lokasi      : 10,//U G D
              flagdaftar  : 0,
              user : _user_logged_in,
              date : moment().format('YYYY-MM-DD'),
              time : moment().format('HH:mm:ss'),
              CaraMasuk   : "1", //Datang Sendiri
              AlasanDatang: "PENYAKIT",
              Rujukan     : get_norujukan
            };

            fotrdaftar_pilih = fotrdaftar_ugd;
          }
          

          console.log('get_bill_siap_pakai_+_get_kode_lokasi_+_noantrian_ready_3digit_+_noantrian_ready_full');
          console.log(get_bill_siap_pakai+'_'+get_kode_lokasi+'_'+noantrian_ready_3digit+'_'+noantrian_ready_full);

          get_ket_fo = $('input[name=ket_fo]').val();
          get_hp_cm = pasien_cm_Obj.datajs[0].HP;

          // //++++++++++++++++++++ create_sep ++++++++++++++++++++++++

                //======   ws1.1   ============
              let jpost_sep_create =                                                     
                {
                   "request": {
                      "t_sep": {
                         "noKartu": get_noka,
                         "tglSep": moment().format('YYYY-MM-DD'),
                         "ppkPelayanan": "0195R028",
                         "jnsPelayanan": get_jnsPelayanan,
                         "klsRawat": get_klsRawat,
                         "noMR": get_norm_cm,
                         "rujukan": {
                            "asalRujukan": get_asalRujukan_bpjs, //"1",
                            "tglRujukan": get_tglKunjungan,
                            "noRujukan": get_norujukan,
                            "ppkRujukan":  get_ppkRujukan
                         },
                         "catatan": $('input[name=catatan_sep]').val(),
                         "diagAwal": $('select[name=sel_diag_bpjs]').val(),
                         "poli": {
                            "tujuan": get_poliKode_bpjs,
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
                            "noSurat": noskdp_bpjs,
                            "kodeDPJP": $('input[name=kd_dpjp_bpjs]').val()
                         },
                         "noTelp": $('input[name=telp]').val(),
                         // "user": "16141"
                         "user": config_bpjs.consid
                      }
                   }
                };
                //======   \ws1.1   ============

            console.log('[Data will send:: sep_create]::');
            console.log(jpost_sep_create);
            progress_daftar(10,'Mengirim data untuk CREATE SEP ke BPJS.');


            //[== CREATE SEP ==]
            let res_c_sep = sep_create_by_noka(jpost_sep_create); //response_create_sep [LIHAT KATALOG BPJS]
            console.log("<RESPONSE CREATE SEP> res_c_sep");
            console.log(res_c_sep);

            if(res_c_sep.metaData.code == 200 ){ //bila create_sep SUKSES
              tc_sep    = moment().format('HH:mm:ss');
              get_nosep_temp = res_c_sep.response.sep.noSep;
              get_nosep_temp = get_nosep_temp.toUpperCase(); // TAMBAHAN
              console.log('nosep_created= '+ get_nosep_temp);
              progress_daftar(30,'SEP berhasil dibuat.');

              $('input[name=get_nosep_temp]').val(get_nosep_temp);
              $('input[name=get_bill_siap_pakai]').val(get_bill_siap_pakai);


              //++++++++++++++++++++ insert_daftar_rj to DB rscm ++++++++++++++++++++++++
              
              let jpost_insert_reg_cm = {
                data : {
                  NoBill: get_bill_siap_pakai,
                  NoRM  : get_norm_cm,
                  TanggalMasuk  : moment().format('YYYY-MM-DD'),
                  JamMasuk      : moment().format('HH:mm:ss'),
                  TanggalKeluar : moment().format('YYYY-MM-DD'),
                  JamKeluar     : moment().format('HH:mm:ss'),
                  StatusBL    : st_px_baru_lama, //Bila di mstpasien ada No.RM, isikan LAMA. 
                  FlagBill    : 0,
                  DiagnosaAwal: '10',
                  Anggota     : 'M',//BPJS: M
                  PerusahaanPenanggung: 'CO031', //BPJS: CO031
                  BiayaKartu          : 0,
                  BiayaKartuUpDisc    : 0,
                  StatusDaftar : StatusDaftar_cm,
                  Nama  : $('span[name=pasienRscm_nama]').text(),
                  Alamat: $('span[name=pasienRscm_alamat]').text(),
                  Telp  : pasien_cm_Obj.datajs[0].Telp,
                  HP    : get_hp_cm,
                  RT    : pasien_cm_Obj.datajs[0].Rt,
                  RW    : pasien_cm_Obj.datajs[0].Rw,
                  Kelurahan : pasien_cm_Obj.datajs[0].Kelurahan,
                  Kecamatan : pasien_cm_Obj.datajs[0].Kecamatan,
                  Kota      : pasien_cm_Obj.datajs[0].Kota,
                  Propinsi  : pasien_cm_Obj.datajs[0].Propinsi,
                  Negara    : pasien_cm_Obj.datajs[0].Negara,
                  Agama     : pasien_cm_Obj.datajs[0].Agama,
                  Pendidikan: pasien_cm_Obj.datajs[0].Pendidikan,
                  Pekerjaan : pasien_cm_Obj.datajs[0].Pekerjaan,

                  Sex       : $('span[name=pasienRscm_jk]').text(),
                  Marital   : pasien_cm_Obj.datajs[0].Marital,
                  UmurTahun : get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun'), //mstpasien->tgl Lahir TglLahir
                  UmurBulan : get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'bulan'), //mstpasien->tgl Lahir
                  UmurHari  : get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'hari'), //mstpasien->tgl Lahir
                  KategoriUsia : kategori_usia( get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun') ),//mstpasien->tgl Lahir

                  LimitKredit    : 0,
                  flagpostkartu  : 0,
                  flagpostperiksa: 0,
                  flagpostbiaya  : 0,
                  FlagDiagnosa   : 0,
                  
                  NoAnggota : 'BPJS',
                  keterangan: get_ket_fo,
                  caramasuk   : '1', //Datang Sendiri
                  asalPPK     : get_ppkRujukan+'_'+get_ppkRujukan_nama,
                  asalinstansi: get_instansi_kode_cm,
                  nosep  : get_nosep_temp,
                  noskdp : noskdp,
                  User   : _user_logged_in,
                  Date   : moment().format('YYYY-MM-DD'),
                  Time   : moment().format('HH:mm:ss')
                },
                data1: fotrdaftar_pilih,
                data2: {
                  "nobill": get_bill_siap_pakai,
                  "no"    : 1,
                  "masterorextra" : "M",
                  "billname"      : $('span[name=pasienRscm_nama]').text(),
                  "billket"       : "Bill From RJ",
                  "billpenanggung": "CO031",
                  "user" : _user_logged_in,
                  "date" : moment().format('YYYY-MM-DD'),
                  "time" : moment().format('HH:mm:ss')
                },
                flag : {
                  "_FL_daftar_ugd"    : _FL_daftar_ugd,
                  "_FL_ambil_px_book" : _FL_ambil_px_book,
                  "date" : book_id_date,
                  "time" : book_id_time
                }
              };

              
              $.ajax({
                async : false,
                url   : baseUrl()+"ajaxreq/insert_daftar_rj",
                type  : "POST",
                data  : jpost_insert_reg_cm,
                success:function(data){
                  tc_insert_daftar_rj = moment().format('HH:mm:ss');
                  //console.log(data);
                  console.log('Pendaftaran pasien berhasil.');
                  progress_daftar(50,'Sukses memasukkan data pendaftaran ke database Rumah Sakit.');             
                },
                error:function(jqXHR,textStatus,errorThrown){
                  console.log('ERROR[insert_daftar_rj]: '+errorThrown);
                }
              });

              

              //+++++++++++++++++++ \insert_daftar_rj TO db rscm ++++++++++++++++++++++++


              //+++++++++++++++++++ insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++
              let data_post = {
                app  : 'daftarmandiri/admin',
                data : {
                  data_utama  : {
                    billing : get_bill_siap_pakai,
                    noka    : get_noka,
                    norm    : get_norm_cm,
                    nama    : get_nama_cm,
                    antrian : noantrian_ready_full
                  },
                  time_create: {
                    tc_klik_daftarrj: tc_klik_daftarrj,
                    tc_bill         : tc_bill,
                    tc_noantrian    : tc_noantrian,
                    tc_sep          : tc_sep,
                    tc_insert_daftar_rj : tc_insert_daftar_rj
                  },
                  data_paket: {
                    jpost_insert_reg_cm : jpost_insert_reg_cm
                  },
                  bridging  : {
                    res_c_sep : res_c_sep
                  }                
                },
                user : _user_logged_in,
                date : moment().format('YYYY-MM-DD'),
                time : moment().format('HH:mm:ss')
              };

              $.ajax({
                async: false,
                url: baseUrl()+"ajaxreq/insert_daftar_rj_xrec",
                type:"POST",
                data  : data_post,
                success:function(data){
                  console.log('SUKSES insert daftar record log');
                  // console.log('[ajaxreq/insert_daftar_rj_xrec]::');
                  // console.log(data);          
                },
                error:function(jqXHR,textStatus,errorThrown){
                  console.log('ERROR[insert_daftar_rj_xrec]: '+errorThrown);
                }
              });

              //+++++++++++++++++++ \insert_all_data_pendaftaran TO db rscm[xrec] ++++++++++++++++++++++++


              if(tc_insert_daftar_rj == ''){
                alert('GAGAL DAFTAR. Hapus SEP dan Ulangi Pendaftaran.');
              }else{ // jika tc_insert_daftar_rj tidak kosong, BERARTI BERHASIL DAFTARRJ
                
                //+++++++++++++++++++ MULAI PRINTING ++++++++++++++++++++++++++++++

                //+++++++++++++++++++ print no_antrian di RC ++++++++++++++++++++++++++++++
                let jpost_cetak_noantrian = {
                  billing    : get_bill_siap_pakai,
                  no_antrian : noantrian_ready_3digit,
                  tglrujukan : get_tglKunjungan,
                  nama   : $('span[name=pasienRscm_nama]').text(),
                  dpjp   : $('input[name=cari_jadok]').val(),
                  nosep  : get_nosep_temp
                };
                console.log(jpost_cetak_noantrian);

                if(_FL_daftar_ugd == 0){ // jika bukan DAFTAR UGD
                  //BILA TIDAK AMBIL PASIEN DARI BOOKING, CETAK noantrian dan skdp
                  if(_FL_ambil_px_book == 0){
                    cetak_nomor_antrian(jpost_cetak_noantrian); 
                  }
                }

                progress_daftar(60,'Sukses cetak nomor antrian.');
                

               
                //++++++++++++++++ \print no_antrian di RC ++++++++++++++++++++++++++++++++


                //++++++++++++++++++++++ print tracer +++++++++++++++++++++++++++++++++++++
                let jpost_cetak_tracer = {
                    NoBill    : get_bill_siap_pakai,
                    NoRM      : get_norm_cm,
                    no_antrian: noantrian_ready_3digit,
                    Nama      : $('span[name=pasienRscm_nama]').text(),
                    TglLahir  : pasien_cm_Obj.datajs[0].TglLahir,
                    Sex       : $('span[name=pasienRscm_jk]').text(),
                    Alamat    : $('span[name=pasienRscm_alamat]').text(),
                    klinik    : $('input[name=klinikTujuan]').val(),
                    dokter    : $('input[name=cari_jadok]').val(),
                    user      : _user_logged_in,
                    ket       : get_ket_fo,
                    umur      : get_umur_fx(pasien_cm_Obj.datajs[0].TglLahir,'tahun'),
                    st_px_baru_lama : st_px_baru_lama
                };
                console.log(jpost_cetak_tracer);

                cetak_tracer(jpost_cetak_tracer); //print tracer ke1
                cetak_tracer(jpost_cetak_tracer); //print tracer ke2
                progress_daftar(70,'Sukses cetak tracer 2x.');

                // //+++++++++++++++++++++ /print tracer +++++++++++++++++++++++++++++++++++++


                //BRIDGING [== CARI SEP ==]
                let js = get_data_sep( get_nosep_temp ); 
                let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );
                let _FLAG_cetak_skdp = 0;

                // VARIABLE OBJECT UNTUK CETAK SKDP
                jpost_cetak_skdp = {
                    billing : get_bill_siap_pakai,
                    noskdp  : noskdp,
                    norm    : get_norm_cm,
                    nama    : get_nama_cm,
                    tglLahir: js.response.peserta.tglLahir,              
                    //provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
                    provPerujuk : get_ppkRujukan_nama,
                    tglSep  : js.response.tglSep,
                    dpjp    : namaDokter_pilih
                };
                console.log('[jpost_cetak_skdp]=');
                console.log(jpost_cetak_skdp);
                //$('button[name=btn_cetak_skdp]').trigger('click');

                //BILA AMBIL PASIEN DARI BOOKING, TIDAK CETAK noantrian dan skdp
                if(_FL_ambil_px_book == 0){
                  cetak_skdp_langsung(jpost_cetak_skdp);
                }
                progress_daftar(80,'Sukses cetak SKDP.');


                if(js.metaData.code == 200){ //JIKA [get_data_sep] dari [BRIDGING CARI SEP] = BERHASIL

                  // //+++++++++++++++++++++++ print preview cetak_resume_sep ++++++++++++++++++++++++
                  // let all_log = _ajax("GET", "logdaftarrj_by_key/nosep/"+js.response.noSep, "");
                  // let prb = all_log[0]["data"]["bridging"]["res_c_sep"]["response"]["sep"]["informasi"]["prolanisPRB"];
                  let prb = res_c_sep.response.sep.informasi.prolanisPRB;
                  console.log(prb);

                  jpost_cetak_resume_sep = {
                      noSep   : js.response.noSep,
                      norm    : get_norm_cm,
                      alamat  : get_alamat_cm,
                      tglSep  : js.response.tglSep,
                      noKartu : js.response.peserta.noKartu,
                      nama    : js.response.peserta.nama,
                      nama_cm : get_nama_cm,
                      tglLahir: js.response.peserta.tglLahir,
                      poli    : js.response.poli,
                      diagnosa: js.response.diagnosa,
                      catatan : js.response.catatan,
                      umurSaatPelayanan : get_umur_bpjs,
                      sex     : get_sex_bpjs,

                      noTelepon   : get_telp_bpjs,
                      provPerujuk : get_ppkRujukan_nama,
                      jnsPelayanan: js.response.jnsPelayanan,
                      kelasRawat  : js.response.kelasRawat,
                      jnsPeserta  : js.response.peserta.jnsPeserta,
                      asuransi    : js.response.peserta.asuransi,
                      penjamin    : js.response.penjamin,

                      billing     : get_bill_siap_pakai,
                      lokasi_ket  : spesialis_pilih,
                      nama_dokter : namaDokter_pilih,
                      penanggung_cm: 'BPJS',
                      prb         : prb,
                  };

                  cetak_resume_sep(jpost_cetak_resume_sep);
                  // //+++++++++++++++++++++++ /print preview cetak_resume_sep ++++++++++++++++++++++++
                  progress_daftar(90,'Sukses cetak Resume SEP.');
              
                }else{ //JIKA [get_data_sep] dari [BRIDGING CARI SEP] = GAGAL
                  alert('Pencarian SEP tidak berhasil. [message]='+js.metaData.message);
                }
              } // \jika tc_insert_daftar_rj tidak kosong, BERARTI BERHASIL DAFTARRJ
            
            }else{ //bila create_sep TIDAK SUKSES
              alert('Tidak sukses daftarkan SEP. Pesan dari BPJS = '+res_c_sep.metaData.message);
            }
          // //++++++++++++++++++++ \create_sep ++++++++++++++++++++++++
           
        }else{
          alert('Status Billing tidak diketahui sistem.');
        }

      }

      progress_daftar(100,'Selesai.');
    });

    
    // untuk menangani bill_no_record.
    // SEP sudah jadi, billing crash. makanya hapus SEP
    $('button[name=btn_sep_hapus]').click(function(){
      $.ajax({
        async: false,
        url : baseUrl()+"ajax_bpjs11/sep_hapus_bpjs",
        type:"GET",
        data: { 
          //_method : 'delete',
          nosep: $('input[name=get_nosep_temp]').val(),
          //user : $('input[name=user]').val()
          user : '16141'
        },
        success:function(data){
          console.log(data);
          let js = JSON.parse(data);
          alert(data);
        },
        error:function(jqXHR,textStatus,errorThrown){
          console.log("ERROR[ajax_bpjs11/sep_hapus_bpjs]: "+errorThrown);
        }
      });
    });


    $('button[name=btn_cetak_skdp]').click(function(){
        cetak_skdp(jpost_cetak_skdp);

    });

    
  }//[\open_site]daftarmandiri/admin

  
  //*************************************************************************/
  //
  //                        \page:daftarmandiri/admin
  //
  //*************************************************************************/



  //*************************************************************************/
  //
  //                        page:daftarmandiri/booking
  //
  //*************************************************************************/
    
    //let opened_site= window.location.protocol + "//" + window.location.host + window.location.pathname;
    //autoload page
    //if(opened_site() == baseUrl()+'daftarmandiri/booking'){
    if( open_site('daftarmandiri/booking') ){
      //saat klik BTN_DAFTAR, CREATE table[name=tbl_booking_daftar] hanya butuh NORM dan NOKA saja cukup, 
      //karena saat pindah dari BOOKING ke FOTRDAFTAR, prosesnya seperti [REGISTRASI RJ LANGSUNG]

      //console.log('ok');
      $('input[name=in_tglBooking]').val( moment().format('YYYY-MM-DD') );
      let tglBooking = $('input[name=in_tglBooking]').val();

      $('button[name=btn_ld_booking]').click(function(){
        tglBooking = $('input[name=in_tglBooking]').val();
        let jsObj_booking = gd_booking(tglBooking);

        $('table[name=tbl_booking_daftar] tbody').children().remove();
        for(let i=0; i<jsObj_booking.dtjs.length; i++){
          let el = 
            '<tr data-id="'+jsObj_booking.dtjs[i].time+'">'+
              '<td>'+(i+1)+'</td>'+
              '<td><button class="btn btn-primary">Daftar</button></td>'+
              '<td>'+jsObj_booking.dtjs[i].time+'</td>'+
              '<td>'+jsObj_booking.dtjs[i].nama+'</td>'+
              '<td name="norm">'+jsObj_booking.dtjs[i].norm+'</td>'+
              '<td name="noka">'+jsObj_booking.dtjs[i].noanggota+'</td>'+
              '<td>'+jsObj_booking.dtjs[i].lokasiket+'</td>'+
              '<td>'+jsObj_booking.dtjs[i].dokterket+'</td>'+
            '</tr>';
          $('table[name=tbl_booking_daftar] tbody').append(el);
        }
      });

      $('button[name=btn_del_booking]').click(function(){
        tglBooking = $('input[name=in_tglBooking]').val();
        console.log('delete tanggal booking: '+tglBooking);
        alert(delete_booking_by_date(tglBooking) );
        window.location.reload(true);
      });

      $('button[name=btn_dl_booking_xls]').click(function(){
        tglBooking = $('input[name=in_tglBooking]').val();
        download_booking_xls(tglBooking);
      });

      $(document).on('click','table[name=tbl_booking_daftar] tbody tr td button', function(){
        let get_id      = $(this).parent().parent().data('id'); //tr
        let get_norm_cm = $(this).parent().parent().find('td[name=norm]').text();
        let get_noka    = $(this).parent().parent().find('td[name=noka]').text();
        tglBooking = $('input[name=in_tglBooking]').val();
        console.log(tglBooking+'_'+get_id+'_'+get_norm_cm+'_'+get_noka);
        //console.log(get_id);

        let jsObj_book_pilih = gd_booking_by_datetime( tglBooking, get_id ); 
        console.log(jsObj_book_pilih);

        let get_kode_lokasi = jsObj_book_pilih.dtjs[0].lokasi;
        let get_kode_dokter = jsObj_book_pilih.dtjs[0].dokter;


        let pasien_cm_Obj = gd_pasien_rscm_by_norm(get_norm_cm); //dari scan input rujukan
        console.log(pasien_cm_Obj);
        // // console.log(buat_antrian_klinik_baru( get_kode_lokasi ));
        // // console.log( get_kode_dokter );

        let get_bill_datajs     = buat_bill_baru(); // !![HARUS] pada saat 1 instruksi saja, supaya TIDAK mengCREATE bill lagi
        let get_bill_siap_pakai = get_bill_datajs.bill_baru;
        let get_bill_4d         = get_bill_datajs.bill_baru_4d;
        //noskdp = moment().format('DD') +get_bill_4d+'/SKDP-IRJ/'+moment().format('MM')+'/'+moment().format('YYYY');
        noskdp = moment().format('DD') +get_bill_4d+'/KP/'+moment().format('MM')+'/'+moment().format('YYYY');
                       

        let noantrian_ready_3digit = ready_antrian_klinik_3digit( get_antrian_klinik( get_kode_lokasi ) );
        let noantrian_ready_full = ready_antrian_klinik_full( noantrian_ready_3digit );

        console.log(get_bill_siap_pakai+'_'+get_kode_lokasi+'_'+noantrian_ready_3digit+'_'+noantrian_ready_full);

      });



    }

  //*************************************************************************/
  //
  //                        \page:daftarmandiri/booking
  //
  //*************************************************************************/


  //*************************************************************************/
  //
  //                        page:daftarmandiri/daftar_pasienrj
  //
  //*************************************************************************/
    
    //let opened_site= window.location.protocol + "//" + window.location.host + window.location.pathname;
    //autoload page
    //if(opened_site() == baseUrl()+'daftarmandiri/booking'){

    if( open_site('daftarmandiri/daftar_pasienrj') ){
      // console.log('ok');
      $('input[name=in_tglDaftarrj]').val( moment().format('YYYY-MM-DD') );
      let tglDaftarrj = $('input[name=in_tglDaftarrj]').val();
      console.log(tglDaftarrj);

        

      function ld_tbl_pasien_daftarrj(tglDaftarrj){
        let jsObj_pasienrj = gd_pasienrj_by_date(tglDaftarrj);
        console.log(jsObj_pasienrj);

        $('div[name=tbl_pasien_daftarrj]').children().remove();

        let el_new_tbl = 
        '<table class="table table-bordered" name="tbl_pasien_daftarrj">'+
          '<thead>'+
            '<tr>'+
              '<td>No.</td> <td>Opsi</td> <td>Billing</td>'+
              '<td>NoRM</td> <td>Nama</td> <td>Penanggung</td>'+
              '<td>Lokasi</td> <td>Nama Dokter</td>'+
            '</tr>'+
          '</thead>'+
          '<tbody></tbody>'+
        '</table>';
        $('div[name=tbl_pasien_daftarrj]').append(el_new_tbl);


        //$('table[name=tbl_pasien_daftarrj] tbody').children().remove();
        for(let i=0; i<jsObj_pasienrj.dtjs.length; i++){
          let update_sep = ''; 
          let lbl_sep = ''; 
          if(jsObj_pasienrj.dtjs[i].nosep == 0){
            update_sep = ' <button name="update" data-noka="'+jsObj_pasienrj.dtjs[i].Barcode+'" data-tglmasuk="'+jsObj_pasienrj.dtjs[i].TanggalMasuk+'" class="btn btn-success" style="padding:0px 5px;" >'+
              '<i class="glyphicon glyphicon-chevron-up"></i>'+
            '</button>';
            lbl_sep = "SEP0";
          }else{
            lbl_sep = jsObj_pasienrj.dtjs[i].nosep;
          }

          let el = 
            '<tr data-bill="'+jsObj_pasienrj.dtjs[i].NoBill+'" data-kd_lokasi="'+jsObj_pasienrj.dtjs[i].kd_lokasi+'">'+
              '<td>'+(i+1)+'</td>'+
              '<td><button class="btn btn-primary" name="btn_cetak_antrian_skdp_langsung" style="padding:0px 5px;">Cetak</button></td>'+
              '<td>'+jsObj_pasienrj.dtjs[i].NoBill+
                // ' / <a name="nosep" style="font-size:10pt;">'+jsObj_pasienrj.dtjs[i].nosep+'</a>'+
                ' / '+lbl_sep+''+
              '</td>'+
              '<td>'+jsObj_pasienrj.dtjs[i].NoRM+
                // ' / <a name="noka" style="font-size:10pt;">'+jsObj_pasienrj.dtjs[i].Barcode+'</a>'+
                ' / '+jsObj_pasienrj.dtjs[i].Barcode+''+
              '</td>'+
              '<td>'+
                '<a class="mdl_detail_pasien">'+jsObj_pasienrj.dtjs[i].Nama+'</a>'+
              '</td>'+
              '<td name="penanggung" data-kd_penanggung="'+jsObj_pasienrj.dtjs[i].kd_penanggung+'">'+
                jsObj_pasienrj.dtjs[i].penanggung+
                update_sep+
              '</td>'+
              '<td name="lokasi" data-kd_lokasi="'+jsObj_pasienrj.dtjs[i].kd_lokasi+'">'+jsObj_pasienrj.dtjs[i].Lokasi+'</td>'+
              '<td name="dokter" data-kd_dokter="'+jsObj_pasienrj.dtjs[i].kd_dokter+'">'+jsObj_pasienrj.dtjs[i].NamaDokter+'</td>'+
            '</tr>';
          $('table[name=tbl_pasien_daftarrj] tbody').append(el);
        }
        $('table[name=tbl_pasien_daftarrj]').DataTable();
        
      }

      ld_tbl_pasien_daftarrj(tglDaftarrj);
      

      $('input[name=in_tglDaftarrj]').change(function(){
        //$('table[name=tbl_pasien_daftarrj]').remove();

        tglDaftarrj = $(this).val();
        //jsObj_pasienrj = gd_pasienrj_by_date(tglDaftarrj);
        ld_tbl_pasien_daftarrj(tglDaftarrj);
      });

        

      
      let jsObj_px_cm;
      $(document).on('click','table[name=tbl_pasien_daftarrj] tbody tr td button[name=btn_cetak_antrian_skdp_langsung]', function(){
        let get_bill = $(this).parent().parent().data('bill');
        let get_kd_lokasi = $(this).parent().parent().data('kd_lokasi');
        console.log(get_bill, get_kd_lokasi);
        //alert('yes');

        //////jsObj_px_cm = gd_pasien_rscm_by_bill(get_bill);
        jsObj_px_cm = gd_pasien_rscm_by_bill_lokasi(get_bill, get_kd_lokasi);
        console.log(jsObj_px_cm);

        let jpost_cetak_noantrian = {
              billing   : get_bill,
              no_antrian: jsObj_px_cm.datajs[0].NoUrut.substring(6, 9), //NoUrut
              tglrujukan: jsObj_px_cm.datajs[0].tglrujukan,
              nama      : jsObj_px_cm.datajs[0].Nama,
              dpjp      : cari_namadokter_by_kddokter(jsObj_px_cm.datajs[0].Dokter)[0].val,
              nosep     : jsObj_px_cm.datajs[0].nosep
          }; 

        console.log('[jpost_cetak_noantrian]=');
        console.log(jpost_cetak_noantrian);
        cetak_nomor_antrian(jpost_cetak_noantrian);

        jpost_cetak_skdp = {
            //billing : get_bill,
            billing : jsObj_px_cm.datajs[0].NoBill,
            noskdp  : jsObj_px_cm.datajs[0].noskdp,
            norm    : jsObj_px_cm.datajs[0].NoRM,
            nama    : jsObj_px_cm.datajs[0].Nama,
            tglLahir    : jsObj_px_cm.datajs[0].TglLahir,
            provPerujuk : jsObj_px_cm.datajs[0].asalPPK,
            tglSep      : jsObj_px_cm.datajs[0].TanggalMasuk,
            dpjp        : cari_namadokter_by_kddokter(jsObj_px_cm.datajs[0].Dokter)[0].val
        };
        console.log('[jpost_cetak_skdp]=');
        console.log(jpost_cetak_skdp);
        cetak_skdp_langsung(jpost_cetak_skdp);   
                
      });

      $(document).on('click','table[name=tbl_pasien_daftarrj]>tbody>tr>td>button[name=update]', function(e){
        e.preventDefault();
        
        let nobill = $(this).parent().parent().data("bill");
        let noka = $(this).data("noka");
        let tglmasuk = $(this).data("tglmasuk");
        // let tglmasuk_post = $(this).data("tglmasuk").split("-")[0] +"-"+ $(this).data("tglmasuk").split("-")[1]+$(this).data("tglmasuk").split("-")[2]; // INI UNTUK WS MONITORING HISTORY, WS nya ndak bisa
        console.log([nobill, noka, tglmasuk]);

        // let brj = _ajax_bpjs("GET", "monitoring_dt_history_pelayanan_px/"+noka+"/"+tglmasuk_post+"/"+tglmasuk_post, "");
        // let brj = _ajax_bpjs("GET", "monitoring_dt_kunjungan/Tanggal="+tglmasuk+"&JnsPelayanan=2", {Tanggal: tglmasuk, JnsPelayanan:2});
        let brj = _ajax_bpjs("GET", "monitoring_dt_kunjungan", {Tanggal: tglmasuk, JnsPelayanan:2});
        console.log(brj);
        let T_urut ="";
        let T_sep_det = "";
        for (let i=0; i<brj.response.sep.length; i++) {
          if(brj.response.sep[i].noKartu == noka){
            T_sep_det = brj.response.sep[i];
          }
        }
        console.log(T_sep_det);

        // UPDATE NOSEP
        let update = _db_update({NoBill : nobill}, 'fotrdaftar', {nosep: T_sep_det.noSep});
        if(update == null){
          alert('Proses Update SEP Berhasil.');
          $(this).remove();
        }else{
          alert('Proses Update Gagal. Silahkan ulangi.');
        }
      });


      let all_log = '';
      //open modal saat klik link a
      $(document).on('click','table[name=tbl_pasien_daftarrj] tbody tr td a', function(){
        let get_bill = $(this).parent().parent().data('bill');
        let get_kd_lokasi = $(this).parent().parent().data('kd_lokasi');
        console.log([get_bill, get_kd_lokasi]);

        if(get_kd_lokasi !=null){
          //jsObj_px_cm = gd_pasien_rscm_by_bill(get_bill);
          jsObj_px_cm = gd_pasien_rscm_by_bill_lokasi(get_bill, get_kd_lokasi);
          console.log(jsObj_px_cm);
          //console.log( cari_namadokter_by_kddokter(js.datajs[0].Dokter)[0].val );
          if(jsObj_px_cm.datajs.length != 0){
            $('#modal_detail_pasien').modal('show');

            $('table[name=tbl_detail_pasien] tr td[name=nobill]').text(get_bill);
            $('table[name=tbl_detail_pasien] tr td[name=nosep]').text(jsObj_px_cm.datajs[0].nosep);
            $('table[name=tbl_detail_pasien] tr td[name=noskdp]').text(jsObj_px_cm.datajs[0].noskdp);
            $('table[name=tbl_detail_pasien] tr td[name=Nama]').text(jsObj_px_cm.datajs[0].Nama);
            $('table[name=tbl_detail_pasien] tr td[name=NoRM]').text(jsObj_px_cm.datajs[0].NoRM);
            $('table[name=tbl_detail_pasien] tr td[name=Lokasi]').text(jsObj_px_cm.datajs[0].Lokasi);
            $('table[name=tbl_detail_pasien] tr td[name=Dokter]').text(jsObj_px_cm.datajs[0].Dokter);
            $('table[name=tbl_detail_pasien] tr td[name=namaDokter]').text( cari_namadokter_by_kddokter(jsObj_px_cm.datajs[0].Dokter)[0].val );
            $('table[name=tbl_detail_pasien] tr td[name=tglRujukan]').text(jsObj_px_cm.datajs[0].tglrujukan);
            $('table[name=tbl_detail_pasien] tr td[name=NoUrut]').text(jsObj_px_cm.datajs[0].NoUrut.substring(6, 9));

            if(jsObj_px_cm.datajs[0].nosep == 0){
              alert("SEP 0.");
            }else{
              all_log = _ajax("GET", "logdaftarrj_by_key/nosep/"+jsObj_px_cm.datajs[0].nosep, "");
            }
          }else{
            alert("Data kosong. {IGD, else error}");
          }
            
        }else{
          alert("Lokasi tidak ditemukan.");
        }
          

                          
      });

      
      $(document).on('click','button[name=btn_cetak_antrian]', function(){
        let jpost_cetak_noantrian = {
              billing   : $('table[name=tbl_detail_pasien] tr td[name=nobill]').text(),
              no_antrian: $('table[name=tbl_detail_pasien] tr td[name=NoUrut]').text(), //NoUrut
              tglrujukan: $('table[name=tbl_detail_pasien] tr td[name=tglRujukan]').text(),
              nama      : $('table[name=tbl_detail_pasien] tr td[name=Nama]').text(),
              dpjp      : $('table[name=tbl_detail_pasien] tr td[name=namaDokter]').text(),
              nosep     : $('table[name=tbl_detail_pasien] tr td[name=nosep]').text()
          }; 

        console.log(jpost_cetak_noantrian);
        cetak_nomor_antrian(jpost_cetak_noantrian);
      });


      //$(document).on('click','table[name=tbl_booking_daftar] tbody tr td button[name=btn_cetak_resume_sep]', function(){
      $(document).on('click','button[name=btn_cetak_resume_sep]', function(){
        let get_nosep = $('table[name=tbl_detail_pasien] tr td[name=nosep]').text();

        get_norm_cm   = $('table[name=tbl_detail_pasien] tr td[name=NoRM]').text();
        get_alamat_cm = jsObj_px_cm.datajs[0].Alamat;
        get_nama_cm   = $('table[name=tbl_detail_pasien] tr td[name=Nama]').text();

        get_umur_bpjs = jsObj_px_cm.datajs[0].UmurTahun;
        get_sex_bpjs  = jsObj_px_cm.datajs[0].Sex;
        get_telp_bpjs = jsObj_px_cm.datajs[0].HP;
        get_ppkRujukan_nama = jsObj_px_cm.datajs[0].asalPPK;


        get_bill_siap_pakai = $('table[name=tbl_detail_pasien] tr td[name=nobill]').text();
        spesialis_pilih     = jsObj_px_cm.datajs[0].lokasi_ket;
        namaDokter_pilih    = $('table[name=tbl_detail_pasien] tr td[name=namaDokter]').text();
        get_penanggung_cm_nama = jsObj_px_cm.datajs[0].NoAnggota;


        if(get_nosep == 0 || get_nosep == ''){
          jpost_cetak_resume_sep = {
              noSep   : '',
              norm    : get_norm_cm,
              alamat  : get_alamat_cm,
              // tglSep  : moment().format('YYYY-MM-DD'),
              tglSep  : jsObj_px_cm.datajs[0].TanggalMasuk,
              noKartu : '',
              nama    : '',
              nama_cm : get_nama_cm,
              tglLahir: jsObj_px_cm.datajs[0].TglLahir,
              poli    : '',
              diagnosa: '',
              catatan : '',
              umurSaatPelayanan : get_umur_bpjs,
              sex     : get_sex_bpjs,

              noTelepon   : get_telp_bpjs,
              provPerujuk : get_ppkRujukan_nama,
              jnsPelayanan: '',
              kelasRawat  : '',
              jnsPeserta  : '',
              asuransi    : '',
              penjamin    : '',

              billing     : get_bill_siap_pakai,
              lokasi_ket  : spesialis_pilih,
              nama_dokter : namaDokter_pilih,
              penanggung_cm: get_penanggung_cm_nama,
              prb         : '',
          };
        }else{
          let js = get_data_sep(get_nosep);
          console.log(js);

          let prb = all_log[0]["data"]["bridging"]["res_c_sep"]["response"]["sep"]["informasi"]["prolanisPRB"];
          console.log(prb);

          jpost_cetak_resume_sep = {
              noSep   : js.response.noSep,
              norm    : get_norm_cm,
              alamat  : get_alamat_cm,
              tglSep  : js.response.tglSep,
              noKartu : js.response.peserta.noKartu,
              nama    : js.response.peserta.nama,
              nama_cm : get_nama_cm,
              tglLahir: js.response.peserta.tglLahir,
              poli    : js.response.poli,
              diagnosa: js.response.diagnosa,
              catatan : js.response.catatan,
              umurSaatPelayanan : get_umur_bpjs,
              sex     : get_sex_bpjs,

              noTelepon   : get_telp_bpjs,
              provPerujuk : get_ppkRujukan_nama,
              jnsPelayanan: js.response.jnsPelayanan,
              kelasRawat  : js.response.kelasRawat,
              jnsPeserta  : js.response.peserta.jnsPeserta,
              asuransi    : js.response.peserta.asuransi,
              penjamin    : js.response.penjamin,

              billing     : get_bill_siap_pakai,
              lokasi_ket  : spesialis_pilih,
              nama_dokter : namaDokter_pilih,
              penanggung_cm: 'BPJS',
              prb         : prb,
          };
        }
        

          // //+++++++++++++++++++++++ print preview cetak_resume_sep ++++++++++++++++++++++++  
          console.log(jpost_cetak_resume_sep);

          cetak_resume_sep(jpost_cetak_resume_sep);
          // cetak_resume_sep_pdf(jpost_cetak_resume_sep);

          // //+++++++++++++++++++++++ /print preview cetak_resume_sep ++++++++++++++++++++++++

        
      });

      $(document).on('click','button[name=btn_cetak_sep]', function(){
        let get_nosep = $('table[name=tbl_detail_pasien] tr td[name=nosep]').text();
        let js = get_data_sep(get_nosep);
        console.log(js);
        let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );

        let jpost_cetak_sep = {
              noSep   : get_nosep,
              // norm    : get_norm_cm,
              // alamat  : get_alamat_cm,
              tglSep  : js.response.tglSep,
              noKartu : js.response.peserta.noKartu,
              nama    : js.response.peserta.nama,
              tglLahir: js.response.peserta.tglLahir,
              poli    : js.response.poli,
              diagnosa: js.response.diagnosa,
              catatan : js.response.catatan,
              // umurSaatPelayanan : js_rujukan.response.rujukan.peserta.umur.umurSaatPelayanan,
              // sex     : js_rujukan.response.rujukan.peserta.sex,

              noTelepon   : js_rujukan.response.rujukan.peserta.mr.noTelepon,
              provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
              jnsPelayanan: js.response.jnsPelayanan,
              kelasRawat  : js.response.kelasRawat,
              jnsPeserta  : js.response.peserta.jnsPeserta,
              asuransi    : js.response.peserta.asuransi,
              penjamin    : js.response.penjamin

              // billing     : get_bill_siap_pakai
            }; 

        console.log("[jpost_cetak_sep]::");
        console.log(jpost_cetak_sep);
        cetak_sep_langsung(jpost_cetak_sep);
      });


      $(document).on('click','button[name=btn_cetak_sep_preview]', function(e){
        e.preventDefault();
        let get_nosep = $('table[name=tbl_detail_pasien] tr td[name=nosep]').text();
        let js = get_data_sep(get_nosep);
        console.log(js);
        let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );
        
        let prb = all_log[0]["data"]["bridging"]["res_c_sep"]["response"]["sep"]["informasi"]["prolanisPRB"];
        console.log(prb);

        let jpost_cetak_sep = {
              noSep   : get_nosep,
              // norm    : get_norm_cm,
              // alamat  : get_alamat_cm,
              tglSep  : js.response.tglSep,
              noKartu : js.response.peserta.noKartu,
              nama    : js.response.peserta.nama,
              tglLahir: js.response.peserta.tglLahir,
              poli    : js.response.poli,
              diagnosa: js.response.diagnosa,
              catatan : js.response.catatan,
              // umurSaatPelayanan : js_rujukan.response.rujukan.peserta.umur.umurSaatPelayanan,
              // sex     : js_rujukan.response.rujukan.peserta.sex,

              noTelepon   : js_rujukan.response.rujukan.peserta.mr.noTelepon,
              provPerujuk : js_rujukan.response.rujukan.provPerujuk.nama,
              jnsPelayanan: js.response.jnsPelayanan,
              kelasRawat  : js.response.kelasRawat,
              jnsPeserta  : js.response.peserta.jnsPeserta,
              asuransi    : js.response.peserta.asuransi,
              penjamin    : js.response.penjamin,
              prb         : prb,

              // billing     : get_bill_siap_pakai
            }; 

        console.log("[jpost_cetak_sep]::");
        console.log(jpost_cetak_sep);

          // cetak_resume_sep(jpost_cetak_sep);
        print_preview("sep_cetak", jpost_cetak_sep);
        // let y = _ajax("GET", "tes_view?filename=sep_cetak", jpost_cetak_sep);
        // console.log(y);

      });


      $(document).on('click','button[name=btn_cetak_skdp]', function(){
        let get_bill = $(this).parent().parent().data('bill');
        console.log(get_bill);
        
        // VARIABLE OBJECT UNTUK CETAK SKDP
        jpost_cetak_skdp = {
            //billing : get_bill,
            billing : jsObj_px_cm.datajs[0].NoBill,
            noskdp  : jsObj_px_cm.datajs[0].noskdp,
            norm    : jsObj_px_cm.datajs[0].NoRM,
            nama    : jsObj_px_cm.datajs[0].Nama,
            tglLahir    : jsObj_px_cm.datajs[0].TglLahir,
            provPerujuk : jsObj_px_cm.datajs[0].asalPPK,
            tglSep      : jsObj_px_cm.datajs[0].TanggalMasuk,
            dpjp        : cari_namadokter_by_kddokter(jsObj_px_cm.datajs[0].Dokter)[0].val
        };
        console.log('[jpost_cetak_skdp]=');
        console.log(jpost_cetak_skdp);
        cetak_skdp_langsung(jpost_cetak_skdp);
      });



      $(document).on('click','button[name=btn_del_bill]', function(){
        let bill_delete = $('table[name=tbl_detail_pasien] tr td[name=nobill]').text();
        console.log(bill_delete);
        //alert(bill_delete);
        delete_billing(bill_delete);
      });
    }

    
    

  //*************************************************************************/
  //
  //                        \page:daftarmandiri/daftar_pasienrj
  //
  //*************************************************************************/

  

  //*************************************************************************/
  //
  //                        page:daftarmandiri/log_pendaftaranrj
  //
  //*************************************************************************/
    
    if( open_site('daftarmandiri/log_pendaftaranrj') ){
      //console.log('ok');
      $('input[name=in_tgl]').val( moment().format('YYYY-MM-DD') );
      let in_tgl = $('input[name=in_tgl]').val();

        

      function ld_tbl(in_tgl){
        let jsObj_log = gd_logpendaftaranrj_by_date(in_tgl);
        console.log('[gd_logpendaftaranrj_by_date]::');
        //console.log(jsObj_log);
        console.log(jsObj_log.dtjs[0].data);

        let paket = JSON.parse(jsObj_log.dtjs[0].data);
        console.log(paket.data_utama.norm);

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
        for(let i=0; i<jsObj_log.dtjs.length; i++){
          let st_rec = JSON.parse(jsObj_log.dtjs[i].data).time_create.tc_insert_daftar_rj;
          if(st_rec == '' ){
            st_rec = 'bill_no_record';
          }


          let el = 
            '<tr data-id="'+jsObj_log.dtjs[i].Id+'">'+
              '<td>'+(i+1)+'</td>'+
              '<td>'+JSON.parse(jsObj_log.dtjs[i].data).data_utama.billing+'</td>'+
              '<td>'+JSON.parse(jsObj_log.dtjs[i].data).data_utama.norm+'</td>'+
              '<td><a class="mdl_log_daftarrj">'+JSON.parse(jsObj_log.dtjs[i].data).data_utama.nama+'</a></td>'+
              '<td>'+st_rec+'</td>'+
              '<td>'+jsObj_log.dtjs[i].date+'</td>'+
              '<td>'+jsObj_log.dtjs[i].time+'</td>'+
              '<td>'+jsObj_log.dtjs[i].user+'</td>'+
            '</tr>';
          $('table[name=tbl_val] tbody').append(el);
        }

        $('table[name=tbl_val]').DataTable();
        
      }

      ld_tbl(in_tgl);
      

      $('input[name=in_tgl]').change(function(){
        in_tgl = $(this).val();
        ld_tbl(in_tgl);
      });

      //open modal saat klik link a
      $(document).on('click','table[name=tbl_val] tbody tr td a', function(){
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

    

    
  //*************************************************************************/
  //
  //                        \page:daftarmandiri/log_pendaftaranrj
  //
  //*************************************************************************/




  //*************************************************************************/
  //
  //                        page:user/index
  //
  //*************************************************************************/
  //$('input[name=submit_tambah_user]').submit(function(e){}
  $('form[name=tambah_user]').submit(function(e){

    e.preventDefault();
    let form = $("form[name=tambah_user]").serialize();
    console.log(form);
    //alert(form);
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/tambah_user",
      //url   : baseUrl()+"user/register",
      type  : "POST",
      data  : form,
      success:function(data){
        //let js = JSON.parse(data);
        console.log(data);

      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[tambah_user]: "+errorThrown);
      }
    });
    $(this)[0].reset();

    //$('form[name=tambah_user]').reset();
    return false;
  });




  //*************************************************************************/
  //
  //                       \page:user/index
  //
  //*************************************************************************/

  //*************************************************************************/
  //
  //                        page:it_support
  //
  //*************************************************************************/

  
   /***************      page:it_support/tindakan_hapus    ****************/
    if( open_site('it_support/tindakan_hapus') ){
      let NoNota = '';
      $('button[name=btnCari_tindakan_hapus]').click(function(){
        NoNota = $('input[name=inp_tindakan_hapus_NoNota]').val();

        if(NoNota == ''){
          alert('Kolom NoNota harus terisi...');
          return false;
        }
                  
          
        let jsObj = _ajax( "GET", "get_tindakan_hapus_3tabel/"+NoNota, "" );
        console.log(jsObj);
        
        $('#hasil_jview_del_tind_fotrpayment').text( JSON.stringify(jsObj.payment.dtjs) );
        $('#hasil_jview_del_tind_postindakan').text( JSON.stringify(jsObj.tindakan.dtjs) );
        $('#hasil_jview_del_tind_postindakandet').text( JSON.stringify(jsObj.tindakan_det.dtjs) );

        if(jsObj.payment.dtjs[0].FlagBill == 1){
          alert('Billing sudah CLOSE (FlagBill=1). Bilang kasir dulu.');
          // $('button[name=btn_del_tind_on_3tabel]').hide();
        }        
        
        if(jsObj.tindakan.dtjs[0].flagpostTindakan == 1){
          alert('Billing sudah POSTING TINDAKAN (flagpostTindakan=1).');
          // $('button[name=btn_del_tind_on_3tabel]').hide();
        }        

      });
    

      $('button[name=btn_del_tind_on_3tabel]').click(function(){
        NoNota = $('input[name=inp_tindakan_hapus_NoNota]').val();

        if(NoNota == ''){
          alert('Kolom NoNota harus terisi...');
          return false;
        }else{
          
          // let val = delete_tindakan(NoNota); // HAPUS FUNGSI delete_tindakan() di LIBRARY.JS
          let val = _ajax( "GET", "db/m_itsupport/delete_tindakan/"+NoNota, "" );
          console.log(val);
          
          if(val == null){
            alert('Hapus Tindakan('+NoNota+') = BERHASIL');
            
            let jsObj = _ajax( "GET", "get_tindakan_hapus_3tabel/"+NoNota, "" );
            console.log(jsObj);
            $('#hasil_jview_del_tind_fotrpayment').text( JSON.stringify(jsObj.payment.dtjs) );
            $('#hasil_jview_del_tind_postindakan').text( JSON.stringify(jsObj.tindakan.dtjs) );
            $('#hasil_jview_del_tind_postindakandet').text( JSON.stringify(jsObj.tindakan_det.dtjs) );
          }

        
          
        }


      });

    }


   /***************     \page:it_support/tindakan_hapus    ****************/

   /***************     page:it_support/kamar_hapus    ****************/
       
    $('button[name=btnCari_kamar_hapus]').click(function(){
      $.ajax({
        async: false,
        url: baseUrl()+"ajaxreq/get_kamar_hapus",
        type:"POST",
        data  : { 
          //bill  : 'BL180719.0003'
          bill  : $('input[name=inp_kamar_hapus_bybill]').val()
        },
        success:function(data){
          let js = JSON.parse(data);

          $('table[name=tbl_kamar_hapus] tbody').children().remove();
          for(let i=0; i<js.dtjs.length; i++){
            let el = 
              '<tr data-id="'+i+'">'+
                '<td>'+i+'</td>'+
                '<td>'+js.dtjs[i].NoNota+'</td>'+
                '<td>'+js.dtjs[i].TglTrans+'</td>'+
                '<td>'+js.dtjs[i].BillingKeterangan+'</td>'+
                '<td><button>Hapus</button></td>'+
              '</tr>';

            $('table[name=tbl_kamar_hapus] tbody').append(el);
          }
        },
        error:function(jqXHR,textStatus,errorThrown){
          console.log("ERROR[get_kamar_hapus]: "+errorThrown);
        }
      });
    });
      

    // $('a[name=btn_kamar_hapus]').click(function() {
    //     if ( $(this).attr('aria-expanded') == "true" ) {
    //         console.log(1);
    //     } else {
    //         console.log(0);
    //         //$('table[name=tbl_kamar_hapus]').css('display','none');
    //     }
    // });

    $(document).on('click','table[name=tbl_kamar_hapus] tbody tr td button',function(){
      let get_idTR = $(this).parent().parent().data('id');
      let get_bill = $('table[name=tbl_kamar_hapus] tbody tr[data-id="'+get_idTR+'"] td:nth-child(2)').text();
      let get_tgl = $('table[name=tbl_kamar_hapus] tbody tr[data-id="'+get_idTR+'"] td:nth-child(3)').text();
      let get_billket = $('table[name=tbl_kamar_hapus] tbody tr[data-id="'+get_idTR+'"] td:nth-child(4)').text();
      console.log( get_tgl +' & '+get_billket );
    });

    /***************    \page:it_support/kamar_hapus    ****************/



    /***************    page:it_support/ganti_penanggung    ****************/
    if( open_site('it_support/ganti_penanggung') ){
      //load data penanggung_cm , lalu di masukkan ke select option
      let sel_penanggung_cm = gd_penanggung_cm();
      for(let i=0; i<sel_penanggung_cm.count; i++){
        $('select[name=sel_penanggung_cm]').append('<option value="'+sel_penanggung_cm.dtjs[i].Kode+'">'+sel_penanggung_cm.dtjs[i].Nama+'</option>');
      }


      // [SET DEFAULT SELECT OPTION >> SELECTED] = ikut pada deklarasi let
      $('select[name=sel_penanggung_cm] option[value="'+get_penanggung_cm_kode+'"]').attr('selected','selected');

      
      $('button[name=btnCari_bill_toPenanggung]').click(function(){
        let get_bill_toPenanggung = $('input[name=inp_bill_toPenanggung]').val();

        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/gd_penanggung_fotrdaftar/"+get_bill_toPenanggung,
          success:function(data){
            let js = JSON.parse(data);
            console.log(js);
            $('#hasil_jview_fotrdaftar').text(data);
            if(js[0].NoAnggota == ''){
              $('input[name=inp_asal_penanggung]').val('UMUM');
            }else{
              $('input[name=inp_asal_penanggung]').val(js[0].NoAnggota);
            }
            
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[gd_penanggung_fotrdaftar]: "+errorThrown);
          }
        });

        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/gd_penanggung_fotrbillingshare/"+get_bill_toPenanggung,
          success:function(data){
            let js = JSON.parse(data);
            console.log(js);
            $('#hasil_jview_fotrbillingshare').text(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[gd_penanggung_fotrbillingshare]: "+errorThrown);
          }
        });

        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/gd_penanggung_fotrpayment/"+get_bill_toPenanggung,
          success:function(data){
            let js = JSON.parse(data);
            console.log(js);
            $('#hasil_jview_fotrpayment').text(data);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[gd_penanggung_fotrpayment]: "+errorThrown);
          }
        });

      });

      $('button[name=btn_ganti_penanggung]').click(function(){
          let bill = $('input[name=inp_bill_toPenanggung]').val();
          let anggota = 'M';
          let penanggung_kode = $('select[name=sel_penanggung_cm]').val();
          let penanggung_nama = $('select[name=sel_penanggung_cm] option:selected').text();

          if(penanggung_kode == ''){
            anggota = 'U';
          }else{
            anggota = 'M';
          }
           
          console.log( bill +'_'+ anggota +'_'+ penanggung_kode +'_'+ penanggung_nama);

          $.ajax({
            async : false,
            url   : baseUrl()+"ajaxreq/update_penanggung",
            type  : "POST",
            data  : {
              bill    : bill,
              anggota : anggota,
              penanggung_kode : penanggung_kode,
              penanggung_nama : penanggung_nama
            },
            success:function(data){
              let js = JSON.parse(data);
              console.log(js);
              alert('Berhasil Ganti Penanggung.');
            },
            error:function(jqXHR,textStatus,errorThrown){
              console.log("ERROR[update_penanggung]: "+errorThrown);
              alert("ERROR[update_penanggung]: "+errorThrown);
            }
          });
      });

    }

    /***************    \page:it_support/ganti_penanggung    ****************/


    /***************     page:it_support/transfer_obat_tindakan    ****************/
    if( open_site('it_support/transfer_obat_tindakan') ){
      let noreff = '',
          bill_tujuan = '';
      let js_fotrdaftar;

      $("input[name=inp_noreff]").keypress(function (e) { //TEKAN ENTER
        // e.preventDefault();
        noreff = $('input[name=inp_noreff]').val();
        if (e.which == 13) {
          let js_tf = _ajax('GET', 'gd_transfer_obat', {NoNota : noreff});
          console.log( js_tf );
          $('input[name=inp_bill_asal]').val(js_tf[0].NoBill);
          $('#hasil_jview_asal').text(JSON.stringify(js_tf, null, 4));
          
        }

      });

      
      $("input[name=inp_bill_tujuan]").keypress(function (e) { //TEKAN ENTER
        // e.preventDefault();
        bill_tujuan = $(this).val();
        if (e.which == 13) {
          js_fotrdaftar = _ajax('GET', 'gd_bill_daftar_for_tf', {NoBill : bill_tujuan});
          console.log( js_fotrdaftar );
          $('#hasil_jview_fotrdaftar').text(JSON.stringify(js_fotrdaftar, null, 4));
          
        }

      });

      $("button[name=btn_buka_apsl]").click(function(e){
        e.preventDefault();
        noreff = $('input[name=inp_noreff]').val();
        console.log(noreff);
        let js_fotrdaftar = _ajax('POST', 'update_buka_apsl', {nobukti : noreff});

      });

      $("button[name=btn_transfer_obat]").click(function(e){
        e.preventDefault();
        // noreff = $('input[name=inp_noreff]').val();
        console.log(noreff+'_'+bill_tujuan);
        let jPost = {
          nobukti   : noreff,
          NoBilling : bill_tujuan,
          Nama      : js_fotrdaftar[0].Nama,
          Alamat    : js_fotrdaftar[0].Alamat
        }
        console.log(jPost);
        //let js_tf = _ajax('POST', 'update_transfer_apsl', jPost);

      });
    }
    /***************    \page:it_support/transfer_obat_tindakan    ****************/
    
    /***************    page:it_support/hrd/cek_pegawai_tdk_absen  ****/
    

    $('input[name=inp_tgl]').datepicker({
      // format: 'yyyy/mm/dd',
      format: 'yyyy-mm-dd',
      //todayHighlight: true,
      autoclose: true,
    });

    //$(document).on('click','button[name=btnCek_abslog]',function(){}
    $('button[name=btnCek_abslog]').click(function(){
      //alert('okee');
      // real format: mm/dd/yyyy
      let noreg = $('input[name=inp_noreg]').val();
      let t = $('input[name=inp_tgl]').val();
      let tgl = t.split('/')[2]+'-'+t.split('/')[0]+'-'+t.split('/')[1];
      $('#jview_hrd_abs_log').children().remove();

      let js = _ajax("GET", "cek_pegawai_tidak_absen/"+noreg+"/"+tgl, "");
      console.log(js);
      

      $('span[name=tgl_select]').text(tgl);
      $('span[name=reg_pegawai]').text(noreg);

      // js = JSON.parse(data);
      console.log(js.dtjs.length);
      for(let i=0; i<js.dtjs.length; i++){
        $('#jview_hrd_abs_log').append('<div>'+js.dtjs[i].id+'_'+js.dtjs[i].fddate+'</div>');
      }

      return 0;     

    });


    /***************   \page:it_support/hrd/cek_pegawai_tdk_absen  ****/





    /***************    page:it_support/data_pasien_by_alamat    ****************/
    if( open_site('it_support/data_pasien_by_alamat') ){
      $('button[name=btn_ld]').click(function(){
        //alert('okee');
        $.ajax({
          async: false,
          url: baseUrl()+"ajaxreq/n_px_by_alamat",
          type:"GET",
          data  : { 
            alamat    : $('input[name=in_alamat]').val(), //moment('2018/08/06','YYYY/MM/DD').format('YYYY-MM-DD')
            tgl_start : $('input[name=in_tgl_start]').val(),
            tgl_end   : $('input[name=in_tgl_end]').val()
          },
          success:function(data){
            let dt = JSON.parse(data);

            let new_dt = JSON.stringify( dt , null, 4); // untuk cetak di <pre> , supaya json viewernya bagus 

            console.log(dt);
            $('pre[name=val_js_all]').text(new_dt);
            
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[data_pasien_by_alamat]: "+errorThrown);
          }
        });
        
      });

      $('button[name=btn_dl_data_px_by_alamat_xls]').click(function(){
        let alamat  = $('input[name=in_alamat]').val();
        let tgl_start = $('input[name=in_tgl_start]').val();
        let tgl_end   = $('input[name=in_tgl_end]').val();
        download_data_px_by_alamat_xls(alamat, tgl_start, tgl_end);
      });
    }
    /***************   \page:it_support/data_pasien_by_alamat  ****/

    

  /***************   page:it_support/upload_data_billboard_auto  ****/

    if( open_site('it_support/upload_data_billboard_auto') ){

      let web = _ajax_web("GET", baseUrl()+"online/update_billboard_new" , "");
      console.log(web);

      if(web.response.res_bed_web == null){
        console.log('Update bed berhasil.');
        $('#lastUpload').text(web.response.time_upload);
      }else{
        alert('Update bed & jadwal dokter gagal.');
      }

      
      // =====
      // let durasi_menit = 1;
      // let durasi_detik = 25;

      let jam = 2;
      let menit = 0;
      let detik = 0;
      let total_detik = (jam*3600)+(menit*60)+detik; //satuan: detik
      // let total_detik = 300;

      let total_detik_v = total_detik;

      // let int_refresh_page = total_detik; //satuan: detik

      setInterval(function(){
        $('#detik').text(total_detik_v--);
      }, (1000) );

      // ======= REFRESH PAGE, untuk reload halaman dari db =======
      
      setInterval(function(){
        window.location.reload(true)
      }, (total_detik*1000) );
      // =======\REFRESH PAGE, untuk reload halaman dari db =======

      //=========

    }

  /***************   \page:it_support/upload_data_billboard_auto  ****/

    


  //*************************************************************************/
  //
  //                        \page:it_support
  //
  //*************************************************************************/


  //*************************************************************************/
  //*************************************************************************/
  //                        LTE TEMPLATE
  //*************************************************************************/
  //*************************************************************************/

      $('#btn_ld_bboard_bed').click(function(){
        // let data  = $('input[name=in_alamat]').val();
        alert('oke');
      });


  //*************************************************************************/
  //*************************************************************************/
  //                        \LTE TEMPLATE
  //*************************************************************************/
  //*************************************************************************/




    

});