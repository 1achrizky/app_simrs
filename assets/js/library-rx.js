  
  function _SYSTEM(_datestop){
    // let _datestop = "2020-03-15"; /// RELOAD TERUS DI LOGIN
    // let _datestop = "2022-02-30";
    let datenow = moment().format('YYYY-MM-DD');

    let _SYS = false;
    if(datenow >= _datestop){
      _SYS = true;
    }

    if(_SYS){
      $.redirect(baseUrl()+'user_xlink/logout');
      $('body').removeAttr('data-baseurl');
    }
  }

  _SYSTEM("2022-02-30");

  function baseUrl(){
    // let getUrl = window.location;
    // let path_index_tot = 4;
    // let path_tot = '';

    // for(let i=1; i<=path_index_tot; i++){
    //   path_tot += getUrl.pathname.split('/')[i] + "/";
    // }
    // return getUrl.protocol + "//" + getUrl.host + "/" + path_tot;

    return $('body').data('baseurl');
  }


  

  let _ADDR = null;

  function open_site(address=null){
    if(window.location.protocol + "//" + window.location.host + window.location.pathname == baseUrl()+address){
      _ADDR = address;
      // console.log(_ADDR);
      return true;
    }else{
      return false;
    }
  }

  // function get_address(){
  //   return ADDR;
  // }

  // let fullpath = window.location.href; 
  // console.log(fullpath);

  function _user_logged_in(){
    return $('body').data('user_logged_in');
  }

  function reload(){
    window.location.reload(true);
  }




  function hitungUmurPart(birthDay, birthMonth, birthYear) {
	    var currentDate = new Date();
	    var currentYear = currentDate.getFullYear();
	    //var currentMonth = currentDate.getMonth();
	    var currentMonth = (currentDate.getMonth())+1;//karena januari nilainya 0
	    var currentDay = currentDate.getDate(); 
	    var calculatedAge = currentYear - birthYear;
	    if(calculatedAge>0){
	    	if (currentMonth < birthMonth) {
		        calculatedAge--;
		    }else{
		    	if(currentDay < birthDay){
		    		calculatedAge--;
		    	}
		    }
	    }
	    return calculatedAge;
	}
	
	function hitungUmur(dateLahir){
		let res = dateLahir.split("-");
		let tglLahir = res[2];
		let blnLahir = res[1];
		let thnLahir = res[0];
		return hitungUmurPart(tglLahir, blnLahir, thnLahir);
	}







  //*************************************************************************/
  //                           LIBRARY_BPJS
  //*************************************************************************/

 
	function gd_peserta_by_noka(noKartu){
    let x;
    $.ajax({
      async : false,
      // url   : baseUrl()+'ajaxreq/peserta_cari_get',
      url   : baseUrl()+'ajax_bpjs11/peserta_cari_get',
      type  : "GET",
      data  : { 
        noKartu : noKartu,
        tglSep  : moment().format('YYYY-MM-DD')
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/peserta_cari_get]: "+errorThrown);
      }
    });
    return x;
  }

  function get_data_sep(nosep){
    let data_sep_json_str;
    $.ajax({
      async : false,
      // url   : baseUrl()+'ajaxreq/sep_cari_bpjs',
      url   : baseUrl()+'ajax_bpjs11/sep_cari_bpjs',
      type  : "GET",
      data  : { 
        nosep : nosep
      },
      success:function(data){ //{string}
        data_sep_json_str = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/sep_cari_bpjs]: "+errorThrown);
      }
    });
    return data_sep_json_str;
  }


  function get_data_rujukan(noRujukan){
    let data_rujukan_json_str;
    $.ajax({
      async : false,
      // url   : baseUrl()+"ajaxreq/rujukan",
      url   : baseUrl()+"ajax_bpjs11/rujukan",
      type  : "GET",
      data  : { 
        noRujukan  : noRujukan
      },
      success:function(data){ //{string}
        data_rujukan_json_str = JSON.parse( data );
        //alert(data_rujukan_json_str);
        rujukan_jsObj = data_rujukan_json_str;

      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_data_rujukan]: "+errorThrown);
      }
    });

    return data_rujukan_json_str;
  }

  function get_data_rujukan_by_noka(noka){
    let data_rujukan_json_str;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajax_bpjs11/get_data_rujukan_by_noka",
      type  : "GET",
      data  : { 
        noka  : noka
      },
      success:function(data){ //{string}
        data_rujukan_json_str = JSON.parse( data );
        //alert(data_rujukan_json_str);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_data_rujukan_by_noka]: "+errorThrown);
      }
    });

    return data_rujukan_json_str;
  }

  function gd_rujukan_multi_by_noka(noka){
    let data_rujukan_json_str;
    $.ajax({
      async : false,
      // url   : baseUrl()+"ajaxreq/rujukan_multirecord",
      url   : baseUrl()+"ajax_bpjs11/rujukan_multirecord",
      type  : "GET",
      data  : { 
        noka  : noka
      },
      success:function(data){ //{string}
        data_rujukan_json_str = JSON.parse( data );
        //alert(data_rujukan_json_str);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_data_rujukan_by_noka]: "+errorThrown);
      }
    });

    return data_rujukan_json_str;
  }

  function get_noka_by_noRujukan(noRujukan){
  	return get_data_rujukan(noRujukan).response.rujukan.peserta.noKartu;
  	//return rujukan_jsObj.response.rujukan.peserta.noKartu;
  	//return rujukan_jsObj;
  }

  function get_statusKode_by_noRujukan(noRujukan){ // "keterangan": "AKTIF","kode": "0"
  	return get_data_rujukan(noRujukan).response.rujukan.peserta.statusPeserta.kode;
  }

  function get_statusKet_by_noRujukan(noRujukan){ // "keterangan": "AKTIF","kode": "0"
  	return get_data_rujukan(noRujukan).response.rujukan.peserta.statusPeserta.keterangan;
  }

  function get_tglKunjungan_by_noRujukan(noRujukan){
    return get_data_rujukan(noRujukan).response.rujukan.tglKunjungan;
  }

  //============== NDAK DIPAKE, BISA DIHAPUS =================
  // function get_hitungBulanRujukan_by_noRujukan(noRujukan){ 
  // 	//ambil tglKunjungan dari BRIDGING, efek: LEBIH LAMA
  //   let a = moment( moment().format('YYYY-MM-DD') );
		// let b = moment( get_tglKunjungan_by_noRujukan(noRujukan) );
		// let diffInMs = a.diff(b); // 86400000 milliseconds
		// //var diffInDays = a.diff(b, 'days'); // 1 day
		// let diffInMonths = a.diff(b, 'months'); // 1 day
		// // console.log(diffInDays);

  //   return diffInMonths;
  // }

  function get_hitungBulanRujukan_by_tglKunjungan(tglKunjungan){ 
  	//ambil tglKunjungan dari var yg sudah didapat dari BRIDGING, efek: LEBIH CEPAT
    let a = moment( moment().format('YYYY-MM-DD') );
		let b = moment( tglKunjungan );
		let diffInMs = a.diff(b); // 86400000 milliseconds
		//var diffInDays = a.diff(b, 'days'); // 1 day
		let diffInMonths = a.diff(b, 'months'); // 1 day
		// console.log(diffInDays);

    return diffInMonths;
  }

  //function st_Rujukan1Bln(tglKunjungan){ }
  function st_Rujukan3Bln(tglKunjungan){ 
  	//ambil tglKunjungan dari var yg sudah didapat dari BRIDGING, efek: LEBIH CEPAT
    let a = moment( moment().format('YYYY-MM-DD') );
		let b = moment( tglKunjungan );
		//let diffInMs = a.diff(b); // 86400000 milliseconds
		//let diffInDays = a.diff(b, 'days'); // 1 day
		let diffInMonths = a.diff(b, 'months'); // 1 day
		// console.log(diffInDays);
		if(diffInMonths <= 3){
			return 'AKTIF';
		}else{
			return 'HABIS';
		}
    
  }

  // function st_Rujukan3Bln(tglDaftar_SKDP){ 
  // 	//ambil tglKunjungan dari var yg sudah didapat dari BRIDGING, efek: LEBIH CEPAT
  //   let a = moment( moment().format('YYYY-MM-DD') );
		// let b = moment( tglDaftar_SKDP );
		// //let diffInMs = a.diff(b); // 86400000 milliseconds
		// //let diffInDays = a.diff(b, 'days'); // 1 day
		// let diffInMonths = a.diff(b, 'months'); // 1 day
		// // console.log(diffInDays);
		// if(diffInMonths <= 3){
		// 	return 'AKTIF';
		// }else{
		// 	return 'HABIS';
		// }
    
  // }





  function encrypt_post_sep_cetak(noka){
  	let data_olah;

  	let js = get_data_sep( noka );
    let js_rujukan = get_data_rujukan_by_noka( js.response.peserta.noKartu );

      if(js.metaData.code == '200'){
        //alert(js.response.peserta.nama);
        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/encrypt_post_sep_cetak",
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
          	data_olah = data;
          },
          error:function(jqXHR,textStatus,errorThrown){
            alert("Error SEP Cari By Noka: "+errorThrown);
          }
        });
      }else{
        alert('Pencarian SEP tidak berhasil. [message]='+js.metaData.message);
      }

      return data_olah;

  }

  
  

  function sep_create_by_noka(jpost){
    let x;
    $.ajax({
      async: false,
      // url  : baseUrl()+"ajaxreq/sep_create_bpjs",
      url  : baseUrl()+"ajax_bpjs11/sep_create_bpjs",
      type : "POST",
      data : jpost,
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajax_bpjs11/sep_create_bpjs]: "+errorThrown);
      }
    });
    return x;
  }

  function ref_diagnosa(diagnosa){
    let x;
    $.ajax({
      async: false,
      url  : baseUrl()+"ajax_bpjs11/ref_diagnosa",
      type : "GET",
      data : {
        diagnosa : diagnosa
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajax_bpjs11/ref_diagnosa]: "+errorThrown);
      }
    });
    return x;
  }


  
  //*************************************************************************/
  //                           \LIBRARY_BPJS
  //*************************************************************************/


  //*************************************************************************/
  //                           LIBRARY_RSCM
  //*************************************************************************/

  function get_data_pasien_rscm(noka){
    //alert(baseUrl()+"ajaxreq/get_norm_by_noka");
    let xxx;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/gd_pasien_rscm",
      type  : "POST",
      data  : { 
        noka  : noka
      },
      success:function(data){ //{string}
        xxx = JSON.parse( data );
        //alert(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_data_rujukan_by_noka]: "+errorThrown);
      }
    });
    return xxx;
  }

  function gd_pasien_rscm_GET(noka){
    //alert(baseUrl()+"ajaxreq/get_norm_by_noka");
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/gd_pasien_rscm_GET",
      type  : "GET",
      data  : { 
        noka  : noka
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/gd_pasien_rscm_GET]: "+errorThrown);
      }
    });
    return x;
  }

  function gd_pasien_rscm_by_norm(norm){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/gd_pasien_rscm_by_norm",
      type  : "POST",
      data  : { 
        norm  : norm
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[ajaxreq/gd_pasien_rscm_by_norm]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_pasien_rscm_by_bill(nobill){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+'ajaxreq/gd_pasien_rscm_by_bill',
      type  : "GET",
      data  : { 
        nobill  : '"'+nobill+'"'
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = 'ERROR[ajaxreq/gd_pasien_rscm_by_bill]: '+errorThrown;
      }
    });
    return x;
  }

  function gd_pasien_rscm_by_bill_lokasi(nobill,lokasi){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+'ajaxreq/gd_pasien_rscm_by_bill_lokasi',
      type  : "GET",
      data  : { 
        nobill : '"'+nobill+'"',
        lokasi : lokasi
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = 'ERROR[ajaxreq/gd_pasien_rscm_by_bill_lokasi]: '+errorThrown;
      }
    });
    return x;
  }

  function get_norm_rscm(noka){
    let xxx;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/get_norm_by_noka",
      type  : "POST",
      data  : { 
        noka  : noka
      },
      success:function(data){ //{string}
        xxx = JSON.parse( data );
        //alert(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_data_rujukan_by_noka]: "+errorThrown);
      }
    });
    return xxx;
  }

  function gd_rujukan_rscm(noRujukan){
    let obj;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/gd_rujukan_rscm",
      type  : "POST",
      data  : { 
        noRujukan  : noRujukan
      },
      success:function(data){ //{string}
        obj = JSON.parse( data );
        //alert(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/gd_rujukan_rscm]: "+errorThrown);
      }
    });
    return obj;
  }

  // function gd_rujukan_skdp_rscm(noRujukan){//ada where (flax_exp=3bln)
  //   let obj;
  //   $.ajax({
  //     async : false,
  //     url   : baseUrl()+"ajaxreq/gd_rujukan_skdp_rscm",
  //     type  : "POST",
  //     data  : { 
  //       noRujukan  : noRujukan
  //     },
  //     success:function(data){ //{string}
  //       obj = JSON.parse( data );
  //       //alert(data);
  //     },
  //     error:function(jqXHR,textStatus,errorThrown){
  //       console.log("ERROR[ajaxreq/gd_rujukan_skdp_rscm]: "+errorThrown);
  //     }
  //   });
  //   return obj;
  // }

  //{daftarmandiri/admin}
  function show_dataHTML_scan_noka_daftarrj(js){
      $('#asalRujukan_bpjs').val(1); //default
      $('input[name=pasienRscm_norm]').val(js.get_norm_cm);
      $('span[name=pasienRscm_nama]').text(js.get_nama_cm);
      $('span[name=pasienRscm_tglLahir]').text(js.get_tglLahir);
      $('span[name=pasienRscm_umur]').text(js.get_umur_cm);
      $('span[name=pasienRscm_jk]').text(js.get_sex_cm);
      $('span[name=pasienRscm_alamat]').text(js.get_alamat_cm);
      $('input[name=ket_fo]').val(js.get_ket_fo);

      $('input[name=klinikTujuan]').val( js.klinikTujuan );

      $('span[name=noka]').text(js.get_noka);
      $('span[name=norujukan]').text(js.get_norujukan);
      $('span[name=poli_bpjs]').text(js.get_poliNama_bpjs);

      $('input[name=diagkey_bpjs]').val(js.get_diagAwal);

      $('select[name=sel_diag_bpjs]').children().remove();

      if(js.get_diagAwal != ''){
        let jsObj_diag = ref_diagnosa(js.get_diagAwal).response.diagnosa;
        console.log(jsObj_diag);

        for(let i=0; i<jsObj_diag.length; i++){
          $('select[name=sel_diag_bpjs]').append('<option value="'+jsObj_diag[i].kode+'">'+jsObj_diag[i].nama+'</option>');
        }
      }
      
  }
  

  function update_suku_bangsa(NoRM=null, Sukubangsa=null){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/update_suku_bangsa",
      type  : "POST",
      data  : { 
        NoRM        : NoRM,
        Sukubangsa  : Sukubangsa
      },
      success:function(data){ //{string}
        x = JSON.parse( data );
        //alert(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/update_suku_bangsa]: "+errorThrown);
      }
    });
    return x;
  }

  function get_bill_terakhir(){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/get_bill_terakhir",
      type  : "POST",
      success:function(data){ //{string}
        x = JSON.parse( data )[0].bill_akhir;      
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_bill_terakhir]: "+errorThrown);
      }
    });
    return x;
  }

  
  function buat_bill_baru(){
  	let id = parseInt(get_bill_terakhir())+1;
  	let digit = "0000"; //untuk memberitahu sistem kalau ini 4 digit
  	let id_tot = digit.substring(0, digit.length - id.toString().length) + id;

  	let bill_baru = 'BL' +moment().format('YYMMDD')+'.'+ id_tot;

    let bill_baru_4d = id_tot;
    let data = {
      bill_baru : bill_baru,
      bill_baru_4d : bill_baru_4d
    };
  	return data;
  }

  //cara baru create bill dari php compiler di:: ajaxreq/new_bill_by_php()
  function new_bill_by_php(){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/new_bill_by_php",
      success:function(data){ //{string}
        x = JSON.parse( data );     
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/new_bill_by_php]: "+errorThrown);
      }
    });
    return x;
  }

  function delete_billing(nobill){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/delete_billing",
      type:"POST",
      data  : {
        nobill  : nobill
      },
      success:function(data){
        x = JSON.parse(data);
        console.log('Hapus Billing('+bill+') = BERHASIL');
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[delete_billing]: "+errorThrown;
      }
    });
    return x;
  }
  

  function get_antrian_klinik(kode_lokasi){ //GET NO.ANTRIAN TERAKHIR KALI(belum di +1)
    //alert($('input[name=kode_lokasi]').val());
    //if(kode_lokasi != ''){
      let x;
      $.ajax({
        async : false,
        url   : baseUrl()+"ajaxreq/get_antrian_klinik?kode_lokasi="+kode_lokasi,
        type  : "GET",
        success:function(data){ //{string}
          x = JSON.parse( data )[0].no_antrian_klinik;      
        },
        error:function(jqXHR,textStatus,errorThrown){
          console.log("ERROR[ajaxreq/get_antrian_klinik]: "+errorThrown);
        }
      });
      return x;
    // }else{
    //   console.log('kode lokasi kosong...')
    // }
      
  }

  function buat_antrian_klinik_baru(kode_lokasi){ //FULL DIGIT
    let id = parseInt(get_antrian_klinik(kode_lokasi))+1;
    let digit = "000"; //untuk memberitahu sistem kalau ini 3 digit
    let id_tot = digit.substring(0, digit.length - id.toString().length) + id;
    return moment().format('YYMMDD')+ id_tot;
  }

  function ready_antrian_klinik_3digit(digit3){ //digit3 BELUM di +1. FX ini untuk MENAMBAH 1
    let id = parseInt(digit3)+1;
    let digit = "000"; //untuk memberitahu sistem kalau ini 3 digit
    let id_tot = digit.substring(0, digit.length - id.toString().length) + id;
    return id_tot; //001
  }

  function ready_antrian_klinik_full(digit3){ //digit3 SUDAH di +1
    return moment().format('YYMMDD')+ digit3;
  }


  function gd_skdp(NoRM){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_skdp",
      type:"POST",
      data: {
        NoRM : NoRM
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_skdp]: "+errorThrown;
      }
    });
    return x;
  }


  // function gd_booking(tgl){
  //   let x;
  //   $.ajax({
  //     async: false,
  //     url: baseUrl()+"ajaxreq/gd_booking",
  //     type:"GET",
  //     data: { 
  //       tgl : tgl
  //     },
  //     success:function(data){
  //       x = JSON.parse(data);
  //     },
  //     error:function(jqXHR,textStatus,errorThrown){
  //       x = "ERROR[gd_booking]: "+errorThrown;
  //     }
  //   });
  //   return x;
  // }

  function gd_booking_by_datetime(date, time){ //get data 1 pasien berdasarkan idnya time yg di klik PILIH 
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_booking_by_datetime",
      type:"POST",
      data: { 
        date : date,
        time : time
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_booking_by_datetime]: "+errorThrown;
      }
    });
    return x;
  }

  function delete_booking_by_date(date){ 
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/delete_booking_by_date",
      type:"POST",
      data: { 
        date : date
      },
      success:function(data){
        x = JSON.parse(data);
        x = 'Hapus Booking berhasil.';
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[delete_booking_by_date]: "+errorThrown;
      }
    });
    return x;
  }


  function download_booking_xls(tgl){
    window.open(baseUrl()+'ajaxreq/download_booking_xls?tgl='+tgl);
  }

  function download_data_px_by_alamat_xls( alamat, tgl_start,tgl_end){
    let url_get = 'alamat='+alamat+'&tgl_start='+tgl_start+'&tgl_end='+tgl_end;
    window.open(baseUrl()+'ajaxreq/download_data_px_by_alamat_xls?'+url_get);
  }
  


  function gd_pasienrj_by_date(tgl){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_pasienrj_by_date",
      type:"GET",
      data: { 
        tgl : tgl
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_pasienrj_by_date]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_logpendaftaranrj_by_date(tgl){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_logpendaftaranrj_by_date",
      type:"GET",
      data: { 
        tgl : tgl
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_logpendaftaranrj_by_date]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_logpendaftaranrj_by_id(id){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_logpendaftaranrj_by_id",
      type:"GET",
      data: { 
        id : id
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_logpendaftaranrj_by_id]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_instansi_cm(kd_instansi_bpjs, nama_instansi_bpjs){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_instansi_cm",
      type:"GET",
      data: { 
        kode : kd_instansi_bpjs,
        nama : nama_instansi_bpjs
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_instansi_cm]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_instansi_cm_all(){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_instansi_cm_all",
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_instansi_cm_all]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_penanggung_cm(penanggung=null){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_penanggung_cm",
      type:"GET",
      data: { 
        penanggung : penanggung
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_penanggung_cm]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_cara_masuk_cm(){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_cara_masuk_cm",
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_cara_masuk_cm]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_rujukan_dari_db_cm(){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_rujukan_dari_db_cm",
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_rujukan_dari_db_cm]: "+errorThrown;
      }
    });
    return x;
  }


  function get_st_bill_rm_by_norm(norm){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/get_st_bill_rm_by_norm",
      type:"GET",
      data: { 
        norm : norm
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_st_bill_rm_by_norm]: "+errorThrown;
      }
    });
    return x;
  }

  function get_st_px_mrs_by_norm(norm){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/get_st_px_mrs_by_norm",
      type:"GET",
      data: { 
        norm : norm
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_st_px_mrs_by_norm]: "+errorThrown;
      }
    });
    return x;
  }

  function gd_st_px_baru_lama_by_norm(norm){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/gd_st_px_baru_lama_by_norm",
      type:"GET",
      data: { 
        norm : norm
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[gd_st_px_baru_lama_by_norm]: "+errorThrown;
      }
    });
    return x;
  }




 

      //*********************************/
      //             JADOK
      //*********************************/
  function get_jadok_today(fl_klinik,spesialis){
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_jadok_today",
      type:"POST",
      data: { 
        fl_klinik : fl_klinik,
        spesialis : spesialis 
      },
      success:function(data){
        //console.log(data); //JSON JADWAL DOKTER
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_jadok_today]: "+errorThrown;
      }
    });
    return x;
  }

  function get_jadok_by_idhari(fl_klinik,spesialis,id_hari){ //id_hari= senin:1
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_jadok_by_idhari",
      type:"POST",
      data: { 
        fl_klinik : fl_klinik,
        spesialis : spesialis,
        id_hari   : id_hari
      },
      success:function(data){
        //console.log(data); //JSON JADWAL DOKTER
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_jadok_today]: "+errorThrown;
      }
    });
    return x;
  }

  /* <GET SEMUA JADWAL SPESIALIS YANG SUDAH DIPILIH USER>  */
  function get_jadok_by_namaspesialis(klinik_ket){
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_jadok_by_namaspesialis",
      type:"POST",
      data: { 
        spesialis : klinik_ket 
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[ajaxreq/get_jadok_by_namaspesialis]: "+errorThrown;
      }
    });
    return x;

  }


  function cari_namadokter_by_kddokter(kddokter){
    let x;
    $.ajax({
      async: false,
      url: baseUrl()+"ajaxreq/cari_namadokter_by_kddokter",
      type:"GET",
      data: { 
        kddokter : kddokter 
      },
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[ajaxreq/cari_namadokter_by_kddokter]: "+errorThrown;
      }
    });
    return x;

  }


  function get_jadok_all(){
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_jadok_all",
      success:function(data){
        let js = JSON.parse(data).dtjs;
        let len = js.length;
        let hr = [0,0,0,0,0,0,0]; // senin = array[1]
        let dt_hr1 = [], dt_hr2 = [], dt_hr3 = [],
            dt_hr4 = [], dt_hr5 = [], dt_hr6 = [];

        for(let i=0; i<len; i++){
          if(js[i].hariId == 1){
            hr[1]++;
            dt_hr1.push( js[i] );
          }else if(js[i].hariId == 2){
            hr[2]++;
            dt_hr2.push( js[i] );
          }else if(js[i].hariId == 3){
            hr[3]++;
            dt_hr3.push( js[i] );
          }else if(js[i].hariId == 4){
            hr[4]++;
            dt_hr4.push( js[i] );
          }else if(js[i].hariId == 5){
            hr[5]++;
            dt_hr5.push( js[i] );
          }else if(js[i].hariId == 6){
            hr[6]++;
            dt_hr6.push( js[i] );
          }
        }


        x = {
          len: len,
          hr: [
            {
              dt_hr : dt_hr1,
              cnt : hr[1]
            },{
              dt_hr : dt_hr2,
              cnt : hr[2]
            },{
              dt_hr : dt_hr3,
              cnt : hr[3]
            },{
              dt_hr : dt_hr4,
              cnt : hr[4]
            },{
              dt_hr : dt_hr5,
              cnt : hr[5]
            },{
              dt_hr : dt_hr6,
              cnt : hr[6]
            }
          ]
        };




      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_jadok_all]: "+errorThrown;
      }
    });
    return x;
  }



      //*********************************/
      //            \JADOK
      //*********************************/

      //*********************************/
      //             KLINIK
      //*********************************/
  function get_klinik(){
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_klinik",
      type:"POST",
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_klinik]: "+errorThrown;
      }
    });
    return x;
  }

  function get_klinik_by_ket(ket){
    let x;
    $.ajax({
      async: false,
      url : baseUrl()+"ajaxreq/get_klinik_by_ket",
      type:"GET",
      data: {ket : ket},
      success:function(data){
        x = JSON.parse(data);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR[get_klinik_by_ket]: "+errorThrown;
      }
    });
    return x;
  }

  
  function get_klinik_ket(kdpoli_dari_bpjs=null){
    let x;
    if(kdpoli_dari_bpjs==''){
      x = [{
        Keterangan  : "",
        Kode        : "",
        kdpoli_bpjs : "",
        kdpoli_rs   : ""
      }];
    }else{
      $.ajax({
        async: false,
        url : baseUrl()+"ajaxreq/get_klinik_ket",
        type:"POST",
        data: { 
          kdpoli_dari_bpjs : kdpoli_dari_bpjs 
        },
        success:function(data){
          x = JSON.parse(data);
        },
        error:function(jqXHR,textStatus,errorThrown){
          x = "ERROR[get_klinik_ket]: "+errorThrown;
        }
      });
    }

    return x;
  }

  // function waktu_pelayanan_klinik( waktu_start=null, durasi_total=null, format=null){
  //   // return moment().add('minutes', durasi_total).format('HH:mm:ss');
  //    // let tambah_menit = moment('07:00:00','HH:mm:ss').add('minutes', 30).format('HH:mm:ss');
  //    return moment(waktu_start,'HH:mm:ss').add('minutes', durasi_total).format(format);
  // }

  function waktu_pelayanan_klinik( waktu_start=null, antrian3dgt=null, durasi_lokasi=null, format=null){
    // return moment().add('minutes', durasi_total).format('HH:mm:ss');
     // let tambah_menit = moment('07:00:00','HH:mm:ss').add('minutes', 30).format('HH:mm:ss');

    let int_noantri_3dgt_redy = parseInt(antrian3dgt);
    let durasi_total = durasi_lokasi*int_noantri_3dgt_redy;
    return moment(waktu_start,'HH:mm:ss').add('minutes', durasi_total).format(format);
  }

      //*********************************/
      //             \KLINIK
      //*********************************/

      //************* PRINT REGISTRASI RJ ************/
      
      function cetak_nomor_antrian(jpost){
        $.ajax({
          async: false,
          url : baseUrl()+"ajaxreq/cetak_nomor_antrian",
          type: "POST",
          data: jpost,
          success: function(data, textStatus, jqXHR){
              console.log('cetak_nomor_antrian[Alamat::'+data+'] '+'Data Sudah Dicetak Ke Printer.');
          }
        });
      }

      
      function cetak_sep_langsung(jpost){
        $.ajax({
          async: false,
          url : baseUrl()+"ajaxreq/cetak_sep_langsung",
          type: "POST",
          data: jpost,
          success: function(data, textStatus, jqXHR){
              console.log('cetak_sep_langsung[data::'+data+'] '+'Data Sudah Dicetak Ke Printer.');
          }
        });
      }

      function cetak_resume_sep(jpost){
        $.ajax({
            async : false,
            url   : baseUrl()+"ajaxreq/encrypt_post_cetak",
            type  : "POST",
            data  : jpost,
            success:function(data){ 
              $("#div_frame").children().remove();        
              let src = baseUrl()+"ajaxreq/tes_cetak_enc?filename=sep_resume_cetak&js="+data;
              $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
              window.frames['frame'].print();

              window.frames['frame'].onafterprint = function(){
                $("#div_frame").children().remove();
                //alert("Printing completed...");
                /////window.location = baseUrl()+"vclaim/tes_cetak";
              };
            },
            error:function(jqXHR,textStatus,errorThrown){
              alert("Error[encrypt_post_cetak]: "+errorThrown);
            }
          });
      }
      
      

      // NEW: 2019-12-16
      // example:print tracerri
      function popup_print(filename=null, jpost=null){
        let data = btoa( JSON.stringify(jpost) );
        // console.log(data);

        $("#div_frame").children().remove();
        let src = baseUrl()+"ajaxreq/popup_print?filename="+filename+"&js="+data;
        $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
        window.frames['frame'].print();

        window.frames['frame'].onafterprint = function(){
          $("#div_frame").children().remove();
          //alert("Printing completed...");
          /////window.location = baseUrl()+"vclaim/tes_cetak";
        };

      }
      
      
      //2020.03.31
      function popup_print_main(filename=null, jpost=null){
        let data = btoa( JSON.stringify(jpost) );
        // console.log(data);

        $("#div_frame").children().remove();
        let src = baseUrl()+"main/popup_print?filename="+filename+"&js="+data;
        $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
        window.frames['frame'].print();

        window.frames['frame'].onafterprint = function(){
          $("#div_frame").children().remove();
          //alert("Printing completed...");
          /////window.location = baseUrl()+"vclaim/tes_cetak";
        };

      }



      //2020.11.25
    function popup_print_main_dbload(filename=null, jpost=null, pages=null){
      let data = btoa( JSON.stringify(jpost) );
      // console.log(data);

      $("#div_frame").children().remove();
      let src = baseUrl()+"main/popup_print_dbload?filename="+filename+"&pages="+pages+"&js="+data;
      $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
      window.frames['frame'].print();

      window.frames['frame'].onafterprint = function(){
        $("#div_frame").children().remove();
        //alert("Printing completed...");
        /////window.location = baseUrl()+"vclaim/tes_cetak";
      };

    }


    function iframeform(url){
        var object = this;
        object.time = new Date().getTime();
        object.form = $('<form action="'+url+'" target="iframe'+object.time+'" method="post" style="display:none;" id="form'+object.time+'" name="form'+object.time+'"></form>');

        object.addParameter = function(parameter,value){
            $("<input type='hidden' />")
            .attr("name", parameter)
            .attr("value", value)
            .appendTo(object.form);
        };

        object.send = function(){
            var iframe = $('<iframe data-time="'+object.time+'" style="display:none;" id="iframe'+object.time+'"></iframe>');
            $( "body" ).append(iframe); 
            $( "body" ).append(object.form);
            object.form.submit();
            iframe.load(function(){  $('#form'+$(this).data('time')).remove();  $(this).remove();   });
        };

        // object.print = function(){
        //   var iframe = $('<iframe data-time="'+object.time+'" style="display:block;" name="frame"></iframe>');
        //     // $( "#div_frame" ).append(iframe); 
        //     $( "body" ).append(object.form);
        //     object.form.submit = function(){
              
        //       $( "#div_frame" ).append(iframe); 
        //       window.frames['frame'].print();
        //       return false;
        //     };
        // };
    }
      
      
      

      

      //NEW ON : 20190528
      function print_preview(filename=null, jpost=null){
        $.ajax({
            async : false,
            url   : baseUrl()+"ajaxreq/encrypt_post_cetak",
            type  : "POST",
            data  : jpost,
            success:function(data){ 
              $("#div_frame").children().remove();        
              let src = baseUrl()+"ajaxreq/tes_cetak_enc?filename="+filename+"&js="+data;
              $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
              window.frames['frame'].print();

              window.frames['frame'].onafterprint = function(){
                $("#div_frame").children().remove();
                //alert("Printing completed...");
                /////window.location = baseUrl()+"vclaim/tes_cetak";
              };
            },
            error:function(jqXHR,textStatus,errorThrown){
              alert("Error[encrypt_post_cetak]: "+errorThrown);
            }
          });
      }


      function cetak_resume_sep_pdf(jpost){
        $.ajax({
            async : false,
            url   : baseUrl()+"ajaxreq/cetak_resume_sep_pdf",
            type  : "POST",
            data  : jpost,
            success:function(data){ 
              alert('Berhasil export pdf.');
              //location.href = baseUrl()+'resume_sep.pdf';
              //let url = baseUrl()+'resume_sep.pdf';
              //window.open(url,'_blank');
              //openInNewTab(url);
              window.open(baseUrl()+'resume_sep.pdf', '_blank');
            },
            error:function(jqXHR,textStatus,errorThrown){
              alert("Error[cetak_resume_sep_pdf]: "+errorThrown);
            }
          });
      }

      

      function cetak_skdp(jpost){
        $.ajax({
          async : false,
          url   : baseUrl()+"ajaxreq/encrypt_post_cetak",
          type  : "POST",
          data  : jpost,
          success:function(data){  
            $('#div_frame').children().remove();       
            let src = baseUrl()+"ajaxreq/tes_cetak_enc?filename=cetak_form_skdp&js="+data;
            $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
            window.frames['frame'].print();

            window.frames['frame'].onafterprint = function(){
              $("#div_frame").children().remove();
            };

          },
          error:function(jqXHR,textStatus,errorThrown){
            alert("Error[btn_cetak_skdp]: "+errorThrown);
          }
        });
      }






      //*************\PRINT REGISTRASI RJ ************/


      //*********************************/
      //       daftarmandiri/daftaronline
      //*********************************/
      function send_form_daftar_online_CURL_TX(jPost){
        let x;
        $.ajax({
          async   : false,
          url     : baseUrl()+"ajaxreq/send_form_daftar_online_CURL_TX",
          // dataType: "JSON",
          type    : "POST",
          data    : jPost,
          success:function(data){
            // console.log(data);
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            // x = "ERROR[update_bed_WS_WEB_TX]: "+errorThrown;
            console.log("ERROR[send_form_daftar_online_CURL_TX]: "+errorThrown);
          }
        });
        return x;
      }


      function select_reset(name){
        $('select[name='+name+']').children().remove();
        let el = '<option value="" selected="selected">- Pilih opsi -</option>';
        $('select[name='+name+']').append(el);
      }

      function sel_push_sp_all_1hari(js_jadok_hr){
        let x = [];
        for(let i=0; i<js_jadok_hr.length; i++){
          //jika spesialis tidak ada di array sp_all_1hari[], masukkan data spesialis
          if($.inArray( js_jadok_hr[i].Spesialis, x ) < 0 ){ 
            x.push(js_jadok_hr[i].Spesialis);
          }
        }
        return x;
      }    
      
      function sel_append_sp_all_1hari(sp_all_1hari){
        select_reset('sel_spesialis');
        for(let i=0; i<sp_all_1hari.length; i++){
          let el = '<option value="'+sp_all_1hari[i]+'">'+sp_all_1hari[i]+'</option>';
          $('select[name=sel_spesialis]').append(el);
        }
      }

      
      function sel_append_dokter_all_1hari(js_jadok_hr){
        select_reset('sel_dokter');
        for(let i=0; i<js_jadok_hr.length; i++){
          let el = '<option value="'+js_jadok_hr[i].Nama+'">'+js_jadok_hr[i].Nama+'</option>';
          $('select[name=sel_dokter]').append(el);
        }
      }

      function create_tbl_jadok_harian( js_jadok_hr, get_tgl_jadok ){
        $('table[name=tbl_jadok_harian] tbody').children().remove();
          for(let i=0; i<js_jadok_hr.length; i++){
            let el = 
              '<tr>'+
                '<td name="">'+(i+1)+'</td>'+
                '<td name="">'+js_jadok_hr[i].Spesialis+'</td>'+
                '<td name="">'+js_jadok_hr[i].Nama+'</td>'+
                '<td name="">'+js_jadok_hr[i].jamMasuk+' - '+js_jadok_hr[i].jamPulang+'</td>'+
                // '<td name="NamaDokter" data-KodeDokter="'+js.dtjs[i].KodeDokter+'" data-kd_dpjp_bpjs="'+js.dtjs[i].kd_dpjp_bpjs+'">'+js.dtjs[i].NamaDokter+'</td>'+
              '</tr>';

            $('table[name=tbl_jadok_harian] tbody').append(el);
            $('span[name=tgl_jadok]').text('(Tanggal: '+get_tgl_jadok+')');
          }
      }


      function dokter_all_1sp_1hr_fx(js_jadok_hr, spesialis=null){
        let dokter_all_1sp_1hr = [];
        select_reset('sel_dokter');
        // $('select[name=sel_dokter]').children().remove();
        // console.log(js_jadok_hr);
        if(spesialis == 'all' || spesialis == ''){
          // alert('all');
          for(let i=0; i<js_jadok_hr.length; i++){
            dokter_all_1sp_1hr.push(js_jadok_hr[i]);
            let el = '<option value="'+js_jadok_hr[i].Nama+'">'+js_jadok_hr[i].Nama+'</option>';
            $('select[name=sel_dokter]').append(el);
          }
        }else{
          for(let i=0; i<js_jadok_hr.length; i++){
            if(js_jadok_hr[i].Spesialis == spesialis ){ 
              dokter_all_1sp_1hr.push(js_jadok_hr[i]);
              let el = '<option value="'+js_jadok_hr[i].Nama+'">'+js_jadok_hr[i].Nama+'</option>';
              $('select[name=sel_dokter]').append(el);
            }
          }        
        }        
        // return dokter_all_1sp_1hr;
        console.log(dokter_all_1sp_1hr);      
      }

      function sp_selected_all_data(js_jadok_hr, namaDokter){
        let sp_selected_all_data = '';
        //select_reset('sel_spesialis');

        if(namaDokter == 'all' || namaDokter== ''){
          for(let i=0; i<js_jadok_hr.length; i++){
            sp_selected_all_data = js_jadok_hr[i];
          }
        }else{
          for(let i=0; i<js_jadok_hr.length; i++){
            if(js_jadok_hr[i].Nama == namaDokter ){ 
              sp_selected_all_data = js_jadok_hr[i];
            }
          }
        }
        return sp_selected_all_data;
        // console.log(sp_selected_all_data);
      }

      // NOT USE, BISA DIHAPUS : tgl 20181231
      // function select_booking_count(jPost){
      //   let x;
      //   $.ajax({
      //     async : false,
      //     url   : baseUrl()+'ajaxreq/select_booking_count',
      //     type  : "GET",
      //     data  : jPost,
      //     success:function(data){ //{string}
      //       x = JSON.parse( data );
      //     },
      //     error:function(jqXHR,textStatus,errorThrown){
      //       console.log("ERROR[ajaxreq/select_booking_count]: "+errorThrown);
      //     }
      //   });
      //   return x;
      // }



      //*********************************/
      //       \daftarmandiri/daftaronline
      //*********************************/

      //*********************************/
      //       \bo/laporan_indikator_mutu
      //*********************************/

      function select_lapIndikatorMutu_all_by_bln_thn(){ // ???
        let x;
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_lapIndikatorMutu_all_by_bln_thn',
          type  : "GET",
          data  : jPost,
          success:function(data){ //{string}
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_lapIndikatorMutu_all_by_bln_thn]: "+errorThrown);
          }
        });
        return x;
      }

      function select_nd_indikator_by_bln_thn(jPost){
        let x;
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_nd_indikator_by_bln_thn',
          type  : "GET",
          data  : jPost,
          success:function(data){ //{string}
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_nd_indikator_by_bln_thn]: "+errorThrown);
          }
        });
        return x;
      }

      function create_tbl_mutu_mst( js ){
        $('div[name=tbl_mutu_mst]').children().remove();

        let el_new_tbl = 
        '<table class="table table-bordered table-striped" name="tbl_mutu_mst">'+
          '<thead>'+
            '<tr>'+
              '<th>No.</th>'+
              '<th>Jenis Pelayanan</th>'+
              '<th>Indikator</th>'+
              '<th>Standar</th>'+
              '<th style="width:50px;">N</th>'+
              '<th>D</th>'+
              '<th>Nilai(N/D)</th>'+
              '<th style="width:150px;">Aksi</th>'+
            '</tr>'+
          '</thead>'+
          '<tbody></tbody>'+
        '</table>';
        $('div[name=tbl_mutu_mst]').append(el_new_tbl);


        for(let i=0; i<js.length; i++){
          let el = 
            '<tr data-id="'+js[i].id+'">'+
              '<td name="">'+(i+1)+'</td>'+
              '<td name="pelayanan">'+js[i].pelayanan+'</td>'+
              '<td name="indikator">'+js[i].indikator+'</td>'+
              '<td name="standar">'+js[i].standar+'</td>'+
              '<td name=""><input name="N" type="number" style="width:50px;" /></td>'+
              '<td name=""><input name="D" type="number" style="width:50px;" /></td>'+
              '<td name="nilai"></td>'+
              '<td name="aksi" class="btn-group" role="group">'+
                '<button name="btn_list_upload" class="btn btn-info" title="Upload">'+
                  '<i class="fa fa-arrow-circle-right"></i>'+
                '</button>'+
                '<button name="btn_list_edit" class="btn btn-warning" title="Edit">'+
                  '<i class="fa fa-edit"></i>'+
                '</button>'+
                '<button name="btn_list_hapus" class="btn btn-danger" title="Hapus">'+
                  '<i class="fa fa-trash"></i>'+
                '</button>'+
              '</td>'+
            '</tr>';

          $('table[name=tbl_mutu_mst] tbody').append(el);
        }
        // $('table[name=tbl_mutu_mst]').DataTable(); // iki krg stabil
      }

      function insert_nd_indikator( jPost ){
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/insert_nd_indikator',
          type  : "POST",
          data  : jPost,
          success:function(data){ //{string}
            let x = JSON.parse( data );
            console.log(x);
            // alert(x.message);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/insert_nd_indikator]: "+errorThrown);
          }
        });
      }

      function select_nd_indikator_by_id( jPost ){ // ada validasi: select, insert, dan update
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_nd_indikator_by_id',
          type  : "POST",
          data  : jPost,
          success:function(data){ //{string}
            let x = JSON.parse( data );
            console.log(x);
            alert(x.message);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_nd_indikator_by_id]: "+errorThrown);
          }
        });
      }

      function update_indikator( jPost ){
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/update_indikator',
          type  : "POST",
          data  : jPost,
          success:function(data){ //{string}
            let x = JSON.parse( data );
            console.log(x);
            // alert(x.message);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/update_indikator]: "+errorThrown);
          }
        });
      }

      function delete_indikator( jPost ){
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/delete_indikator',
          type  : "POST",
          data  : jPost,
          success:function(data){ //{string}
            let x = JSON.parse( data );
            console.log(x);
            // alert(x.message);
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/delete_indikator]: "+errorThrown);
          }
        });
      }

      //*********************************/
      //       \bo/laporan_indikator_mutu
      //*********************************/


      //*********************************/
      //        bo/dashboard
      //*********************************/
      function select_kunjungan_allpenanggung_by_bln_th( jPost ){
        let x;
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_kunjungan_allpenanggung_by_bln_th',
          type  : "GET",
          data  : jPost,
          success:function(data){ //{string}
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_kunjungan_allpenanggung_by_bln_th]: "+errorThrown);
          }
        });
        return x;
      }

      function select_kunjungan_group_penanggung_bln_by_th( tahun ){
        let x;
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_kunjungan_group_penanggung_bln_by_th',
          type  : "GET",
          data  : { tahun : tahun },
          success:function(data){ //{string}
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_kunjungan_group_penanggung_bln_by_th]: "+errorThrown);
          }
        });
        return x;
      }
      

      function select_kunjungan_tiapLokasi_by_lokasi_th( tahun, lokasi ){
        let x;
        $.ajax({
          async : false,
          url   : baseUrl()+'ajaxreq/select_kunjungan_tiapLokasi_by_lokasi_th',
          type  : "GET",
          data  : { 
            tahun : tahun,
            lokasi: lokasi
          },
          success:function(data){ //{string}
            x = JSON.parse( data );
          },
          error:function(jqXHR,textStatus,errorThrown){
            console.log("ERROR[ajaxreq/select_kunjungan_tiapLokasi_by_lokasi_th]: "+errorThrown);
          }
        });
        return x;
      }

      
      //*********************************/
      //       \bo/dashboard
      //*********************************/



      //*********************************/
      //        bo/menu/receptionist/laporan/laporan-daftaronline-web
      //*********************************/

    function ld_tbl_laporan_daftaronline_web_by_date(dt){
      $('div[name=tbl_laporan_daftaronline_web]').children().remove();

      let el_new_tbl = 
      '<table class="table table-bordered" name="tbl_laporan_daftaronline_web">'+
        '<thead>'+
          '<tr>'+
            '<td>No.</td> <td>Opsi</td> <td>Date</td> <td>Time</td>'+
            '<td>NoRM</td> <td>Tgl.Lahir</td> <td>NOKA/NIK</td> <td>Penanggung</td>'+
            '<td>Dokter</td> <td>Klinik</td>'+
          '</tr>'+
        '</thead>'+
        '<tbody></tbody>'+
      '</table>';
      $('div[name=tbl_laporan_daftaronline_web]').append(el_new_tbl);


      //$('table[name=tbl_pasien_daftarrj] tbody').children().remove();
      for(let i=0; i<dt.length; i++){

        let el = 
          '<tr data-norm="'+dt[i].norm+'" data-date="'+dt[i].date+'">'+
            '<td>'+(i+1)+'</td>'+
            '<td><button class="btn btn-danger" name="btn_del_daftaronline_web" style="padding:0px 5px;">Hapus</button></td>'+
            '<td name="date">'+dt[i].date+'</td>'+
            '<td name="time">'+dt[i].time+'</td>'+
            '<td name="norm">'+dt[i].norm+'</td>'+
            '<td>'+dt[i].tgllahir+'</td>'+
            '<td>'+dt[i].noanggota+'</td>'+
            '<td>'+dt[i].penanggungket+'</td>'+
            '<td>'+dt[i].dokterket+'</td>'+
            '<td>'+dt[i].lokasiket+'</td>'+
          '</tr>';
        $('table[name=tbl_laporan_daftaronline_web] tbody').append(el);
      }
      $('table[name=tbl_laporan_daftaronline_web]').DataTable();
      
    }

      //*********************************/
      //       \bo/menu/receptionist/laporan/laporan-daftaronline-web
      //*********************************/




      //*********************************/
      //        bo/menu/it/user/user-akses
      //*********************************/
   

      //*********************************/
      //       \bo/menu/it/user/user-akses
      //*********************************/




      //*********************************/
      //             fungsi xlink
      //*********************************/
      function kategori_usia(usia_th){
        let kategori='BAYI';
        if(usia_th <= 1){
          kategori = "BAYI";
        }else if(usia_th >1 && usia_th <= 14){
          kategori = "ANAK";
        }else if(usia_th >14 && usia_th <= 21){
          kategori = "REMAJA";
        }else if(usia_th >21 && usia_th <= 50){
          kategori = "DEWASA";
        }else{
          kategori = "MANULA";
        }
        return kategori;
      }

      //*********************************/
      //             \fungsi xlink
      //*********************************/


      //*********************************/
      //              casemix
      //*********************************/
      function pembanding_status_tarif(key,variabel){ //key=ina , variabel=rs
        let status_tarif = 'HIJAU',
            label_css = 'success';
        let batas_50 = parseFloat(0.5*key); //50%
        let batas_100 = parseFloat(key); //100%
        // log([totalTarifRs, tarif_inacbg, batas_50]);
        log([variabel, key, batas_50]);

        if(variabel<batas_50){
          status_tarif = 'HIJAU';
          label_css = 'success';
        }else if(variabel>=batas_50 && variabel<batas_100){
          status_tarif = 'KUNING';
          label_css = 'warning';
        }else if(variabel>=batas_100){
          // if(key==0 || key=='' || key==null){ // tarif_ina belum terisi
          //   status_tarif = 'HIJAU';
          //   label_css = 'success';
          // }else{
            status_tarif = 'MERAH';
            label_css = 'danger';
          // }
          
        }

        let val = {
          status_tarif : status_tarif,
          label_css    : label_css,
        }

        return val;
      }


    function ld_tbl_laporan_px_ri_by_date(dt){
      // let jsObj_pasienrj = gd_pasienrj_by_date(tglDaftarrj);
      // console.log(jsObj_pasienrj);

      $('div[name=tbl_laporan_px_ri]').children().remove();

      let el_new_tbl = 
      '<table class="table table-bordered" name="tbl_laporan_px_ri">'+
        '<thead>'+
          '<tr>'+
            '<td>No.</td> <td>Opsi</td> <td>Billing</td>'+
            '<td>NoRM</td> <td>Nama</td> <td>Lantai</td> <td>Ruang</td>'+
            '<td>Dx Pilih</td><td>Tarif RS</td> <td>Tarif INA</td>'+
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
            '<td><span class="label label-'+dt[i].label_css+'" >'+dt[i].status_tarif+'</span></td>'+
            '<td>'+dt[i].status_bill+'</td>'+

          '</tr>';
        $('table[name=tbl_laporan_px_ri] tbody').append(el);
      }
      $('table[name=tbl_laporan_px_ri]').DataTable({"scrollX": true});
      
    }

      //*********************************/
      //             \casemix
      //*********************************/



  //*************************************************************************/
  //                           \LIBRARY_RSCM
  //*************************************************************************/



  //*************************************************************************/
  //                           LIBRARY_SOFTWARE
  //*************************************************************************/

  function log(data){
    console.log(data);
  }


  function download_excel(url, data){
    window.open(baseUrl()+'ajaxreq/download_booking_xls?tgl='+tgl);
    // window.open(baseUrl()+'ajaxreq/download_booking_xls?tgl='+tgl);
  }

  function DISABLE_RIGHT_CLICK(){
    $(document).bind("contextmenu",function(e){
      // alert("OKEE");
      return false;
    });
  }
  

  function _ajax(type, name, data){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/"+name,
      type  : type,
      data  : data,
      success:function(result){
        x = JSON.parse(result);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR["+name+"]: "+errorThrown;
      }
    });
    return x;
  }

  function _ajax_web(type, url, data=null){
    let x;
    $.ajax({
      async : false,
      url   : url,
      type  : type,
      data  : data,
      success:function(result){
        x = JSON.parse(result);
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR["+name+"]: "+errorThrown;
      }
    });
    return x;
  }

  function _ajax_type(type, dataType, url, data){
    let x;
    $.ajax({
      async : false,
      url   : url,
      type  : type,
      dataType : dataType,
      data  : data,
      success:function(result){
        x = result;
      },
      error:function(jqXHR,textStatus,errorThrown){
        x = "ERROR["+name+"]: "+errorThrown;
      }
    });
    return x;
  }

  function _ajax_bpjs(type, name, data){
    let x;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajax_bpjs11/"+name,
      type  : type,
      data  : data,
      success:function(result){
        x = JSON.parse(result);
        // console.log(x);
        // if(x.metadata.code == 201){
        //   console.log(x);
        //   alert(x.metadata.message);
        //   return false;
        // }
      },
      error:function(jqXHR,textStatus,errorThrown){
        // x = "ERROR["+name+"]: "+errorThrown;
        x = {
          status  : "ERROR",
          name    : name,
          message : errorThrown,
        };
      }
    });
    return x;
  }






  // function _format_insert(table=null, arr_update=null){
  //   let jInsert = {
  //       table     : table,
  //       arr_update: arr_update
  //     };
  //   return jInsert;
  // }

  function _db_insert(table=null, arr_data=null){
    let js = {
        table     : table,
        arr_data  : arr_data
      };
    log(js);
    return _ajax("POST", "insert", js);
  }

  function _db_update(where=null, table=null, arr_data=null){
    let js = {
      where : where,
      table : table,
      arr_data : arr_data
    };
    log(js);
    return _ajax("POST","update", js);
  }

  function _db_select(where=null, table=null){
    let js = {
      where : where,
      table : table
    };
    log(js);
    return _ajax("POST","select", js);
  }




  //>>PINDAH_KE_LIBRARY
  function create_modal(mdl=null){
    let mdl_sample = {
      id    : 'modal_bed',
      bodyId: 'el_modal2',
      size  : 'lg',
      title : 'Daftar Kode Bed',
      table :  '', //HARUSNYA pakai elemen tabel(variabel js): el_tbl,
    };

    let el_all = '<div class="modal fade" id="'+mdl.id+'" role="dialog">'+
        '<div class="modal-dialog modal-'+mdl.size+'">'+
          '<div class="modal-content">'+
            '<div class="modal-header" style="padding:3px 15px;">'+
              '<button class="close" data-dismiss="modal">&times;</button>'+
              '<h4 class="modal-title">'+mdl.title+'</h4>'+
            '</div>'+
            '<div class="modal-body" id="mdl_body">'+
              // '<div class="container" style="margin:0px auto;">'+
              //   '<div class="row">'+
              //     '<div class="col-md-12">'+
                    mdl.table+
              //     '</div>'+
              //   '</div>'+
              // '</div>'+

            '</div>'+
            '<div class="modal-footer">'+
              '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>';
      return el_all;
  }

  // PINDAH_LIB , MOVE_LIB
  function create_table_return(tbl=null, data=null){
    let tbl_sample = {
      id : 'tbl_mdl_bedri',
      headers : [
        ['KodeBed', 'Kode Bed'], ['KeteranganBed','Keterangan'], ['Ruang','Ruang'], 
        ['Kelas','Kelas'], ['Status','Status','style="text-align:center;"'], 
        ['Tarif_Include','Tarif Include', 'style="text-align:right;"','numeral']
      ],
      data : data,
      button : {
        color : 'success',
        head : 'OPSI',
        label : 'PILIH',
      },
    };

    let thead='', thead_field='', 
        tbody='', btn_head='';

    for (let h = 0; h < tbl.headers.length; h++) {        
      thead_field += '<th style="text-align:center;">'+tbl.headers[h][1]+'</th>';          
    }
    
    // LOOP tiap baris data json
    for (let i = 0; i < tbl.data.length; i++) {
      let el_row_fields = '';
      let btn_el='';

      // CREATE HEADER
      for (let ih = 0; ih < tbl.headers.length; ih++) {
        let el_row_field = '';
        switch (tbl.headers[ih][3]) {              
          case 'numeral':
            el_row_field = numeral(tbl.data[i][tbl.headers[ih][0]]).format('0,0');
            break;
        
          default:
            el_row_field = tbl.data[i][tbl.headers[ih][0]];
            break;
        }

        let td_attr = '';
        if(tbl.headers[ih][2]!=null){
          td_attr = tbl.headers[ih][2];
        }            
        el_row_fields += '<td '+td_attr+'>'+el_row_field+'</td>';
        
      }
      //\CREATE HEADER

      if(tbl.button != null){
        btn_head = '<th style="text-align:center;">'+tbl.button.head+'</th>';      
        btn_el = '<td><button class="btn btn-'+tbl.button.color+'" data-id="'+i+'">'+tbl.button.label+'</button></td>';
      }else{
        btn_head = '';
        btn_el = '';
      }
      tbody += '<tr>'+btn_el+el_row_fields+'</tr>';          
    }

    let el_tbl = 
      '<table id="'+tbl.id+'" class="table table-bordered table-striped">'+
        '<thead><tr>'+btn_head+thead_field+'</tr></thead>'+
        '<tbody>'+tbody+'</tbody>'+        
      '</table>';
    return el_tbl;
  }



  // YANG BARU, PAKAI INI
  // function create_table_return2(tbl=null){ // PAKAI INI SEBENARNYA BISA< HANYA SAJA data{} dipakai di menu2 lain(terlanjur, supaya tidak error)
  function create_table_return2(tbl=null, data=null){
    let tbl_sample = {
      id : 'tbl_mdl_bedri',
      headers : [
        ['KodeBed', 'Kode Bed'], ['KeteranganBed','Keterangan'], ['Ruang','Ruang'], 
        ['Kelas','Kelas'], ['Status','Status','style="text-align:center;"'], 
        ['Tarif_Include','Tarif Include', 'style="text-align:right;"','numeral']
      ],
      data : data,
      button : {
        color : 'success',
        head : 'OPSI',
        label : 'PILIH',
      },
    };

    let thead='', thead_field='', 
        tbody='', btn_head='';

    for (let h = 0; h < tbl.headers.length; h++) {        
      thead_field += '<th style="text-align:center;">'+tbl.headers[h][1]+'</th>';          
    }
    
    // LOOP tiap baris data json
    for (let i = 0; i < tbl.data.length; i++) {
      let el_row_fields = '';
      let btn_el='';

      // CREATE HEADER
      for (let ih = 0; ih < tbl.headers.length; ih++) {
        let el_row_field = '';

        let chk = '';
        switch (tbl.headers[ih][3]) {              
          case 'numeral':
            el_row_field = numeral(tbl.data[i][tbl.headers[ih][0]]).format('0,0');
            break;

          case 'checkbox':
            // el_row_field = '<input type="checkbox" value="'+tbl.data[i][tbl.headers[ih][0]]+'"> '+ tbl.data[i][tbl.headers[ih][0]];
            
            if(tbl.data[i][tbl.headers[ih][0]] == ''){ chk = '';
            }else{ chk = 'checked'; }

            el_row_field = '<input class="cbox" type="checkbox" data-id="'+i+'" '+chk+'> ';
            break;
          
          case 'checkbox_disabled':
            // el_row_field = '<input type="checkbox" value="'+tbl.data[i][tbl.headers[ih][0]]+'"> '+ tbl.data[i][tbl.headers[ih][0]];
            
            if(tbl.data[i][tbl.headers[ih][0]] == ''){ chk = '';
            }else{ chk = 'checked'; }

            el_row_field = '<input class="cbox" type="checkbox" data-id="'+i+'" '+chk+' disabled> ';
            break;
          
          case 'button':
            let sub_btn = tbl.headers[ih][4];
            el_row_field = '<button class="btn btn-'+sub_btn.color+' '+sub_btn.trigger+'" data-id="'+i+'">'+sub_btn.label+'</button>';
            break;
          
          case 'sub':
            let dtt = tbl.data[i];
            for (let s = 0; s < tbl.headers[ih][0].length; s++) {
              dtt = dtt[ tbl.headers[ih][0][s] ];
              console.log(dtt);
            }
            // ['poliRujukan','nama'] => ['poliRujukan']['nama']
            // el_row_field = tbl.headers[ih][0].length;

            // el_row_field = tbl.data[i][ tbl.headers[ih][0][0] ][ tbl.headers[ih][0][1] ]; // BISA
            el_row_field = dtt;
            break;
        
          default:
            el_row_field = tbl.data[i][tbl.headers[ih][0]];
            break;
        }

        let td_attr = '';
        if(tbl.headers[ih][2]!=null){
          td_attr = tbl.headers[ih][2];
        }            
        el_row_fields += '<td '+td_attr+'>'+el_row_field+'</td>';
        
      }
      //\CREATE HEADER

      if(tbl.button != null){
        btn_head = '<th style="text-align:center;">'+tbl.button.head+'</th>';
        btn_el = '<td style="text-align:center;"><button class="btn btn-xs btn-'+tbl.button.color+' btn_ok" data-id="'+i+'">'+tbl.button.label+'</button></td>';
      }else{
        btn_head = '';
        btn_el = '';
      }


      tbody += '<tr data-sort="'+i+'">'+btn_el+el_row_fields+'</tr>';          
    }

    let el_tbl = 
      '<table id="'+tbl.id+'" class="table table-xs table-bordered table-striped">'+
        '<thead><tr>'+btn_head+thead_field+'</tr></thead>'+
        '<tbody>'+tbody+'</tbody>'+        
      '</table>';
    return el_tbl;
  }


  // BARU 2021.07.19 = MENU NUMPAD KEYBOARD CONSOLEBOX
  function popup_numpad(){
    let val_kb_fx = '';
    let in_foc = '';
    let in_foc_name = '';
    let el_numpad = 
      '<div class="row">'+
        '<div class="col-md-12">'+
          '<div class="box" style="border: 0px;">'+
            '<div class="box-header" style="text-align: center;">'+
              // '<h3 class="box-title" style="font-size:20pt;">Tombol Masukan</h3>'+
              '<input type="text" name="inMdl_val_kb" style="font-size:30px; width:250px; text-align:center;">'+
            '</div>'+
            '<div class="box-body">'+
              '<style>'+
              '.keypad { width: 250px; border: 1px solid black; text-align:center; margin:0px auto;}'+
              '.keypad>div>button{ margin:10px; width:60px; height:60px; font-size:35px; line-height: 0.61em; vertical-align: middle; }'+
              '</style>'+
                              
              '<div class="keypad">'+
                '<div>'+
                  '<button class="btn btn-info">1</button>'+
                  '<button class="btn btn-info">2</button>'+
                  '<button class="btn btn-info">3</button>'+
                '</div>'+
                '<div>'+
                  '<button class="btn btn-info">4</button>'+
                  '<button class="btn btn-info">5</button>'+
                  '<button class="btn btn-info">6</button>'+
                '</div>'+
                '<div>'+
                  '<button class="btn btn-info">7</button>'+
                  '<button class="btn btn-info">8</button>'+
                  '<button class="btn btn-info">9</button>'+
                '</div>'+
                '<div>'+
                  '<button class="btn btn-info"><</button>'+
                  '<button class="btn btn-info">0</button>'+
                  '<button class="btn btn-info">C</button>'+
                '</div>'+
              '</div>'+
              


            '</div>'+
          '</div>'+
        '</div>'+
      '</div>';

    let mdl = {
      id    : 'modal_kb',
      bodyId: 'el_modal2',
      size  : 'sm',
      title : 'Tombol Masukan',
      table : el_numpad,
    };

    console.log(mdl);
    let el = create_modal(mdl);
    $('#modal_numpad').append(el);

    $('.modal-header').remove();
    // $('.modal-body').find('.col-md-12').css({"margin-bottom":"0px"});
    $('.modal-body').css({"padding-bottom":"0px"});
    $('.modal-footer').css({"padding-top":"0px"});


    // $(document).on('show.bs.modal','#modal_kb', function () {
    // $(document).on('show','#modal_kb', function () {
    $('#modal_kb').on('shown.bs.modal', function () {
      $('input[name=inMdl_val_kb]').val('');
      $('input[name=inMdl_val_kb]').focus();
      in_foc = $('input:focus');
      console.log(in_foc);
      in_foc_name = in_foc[0].name
      console.log(in_foc_name);
    }).modal('show');


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
      // console.log(_this, _this[0], _this[0].text());
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
            // console.log(ky);
          break;
      }

      val_kb_fx = val;
      console.log(val, val_kb_fx, in_foc_name);
      
      console.log(in_foc);
      $('input[name="'+in_foc_name+'"]').val(val);
      // $('input[name="'+in_foc_name+'"]').keyup(); // ?? ANTISIPASI ERROR
    });
    console.log(val, val_kb_fx);
    // return val;
    // return val_kb_fx;
  }
  


  function progress_daftar(val,lbl){
    $('#progress_daftar_lbl').text(lbl);
    $('#progress_daftar_val').text(val+'%').attr('style','width:'+val+'%');
  }

  function progress_bar(name, val, lbl){
    $(name+' .lbl').text(lbl);
    $(name+' .val').text(val+'%').attr('style','width:'+val+'%');
  }

  function select_change_by_selected(name,value){
    $('select[name="'+name+'"] option').removeAttr('selected');
    $('select[name="'+name+'"] option[value="'+value+'"]').attr('selected','selected');
    $('select[name="'+name+'"]').prop("selectedIndex", $('select[name="'+name+'"]').prop('selectedIndex') ).change();
  }


	function set_default_formDaftar_admin(){
		$('input[name=noRujukan]').val(''); 
		
		$('input[name=pasienRscm_norm]').val('');
    $('span[name=pasienRscm_nama]').text('-');
    $('span[name=pasienRscm_tglLahir]').text('-');
    $('span[name=pasienRscm_umur]').text('-');
    $('span[name=pasienRscm_jk]').text('-');
    $('span[name=pasienRscm_alamat]').text('-');

    $('span[name=noka]').text('-');
    $('span[name=norujukan]').text('-');
    $('span[name=poli_bpjs]').text('-');
	}


	function get_err_code(err_code){
		let obj;
    $.ajax({
      async : false,
      url   : baseUrl()+"ajaxreq/get_err_code",
      type  : "GET",
      data  : { 
        err_code  : err_code
      },
      success:function(data){ //{string}
        obj = JSON.parse( data );
        set_default_formDaftar_admin();
      },
      error:function(jqXHR,textStatus,errorThrown){
        console.log("ERROR[ajaxreq/get_err_code]: "+errorThrown);
      }
    });
    return obj;
	}







  function getRandomInt( min, max ) {
         return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
    }
    
  function generateProductKey() {
    var tokens = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
      chars = 5,
      segments = 6,
      keyString = "";
      
    for( var i = 0; i < segments; i++ ) {
      var segment = "";
      
      for( var j = 0; j < chars; j++ ) {
          var k = getRandomInt( 0, 35 );
        segment += tokens[ k ];
      }
      
      keyString += segment;
      
      if( i < ( segments - 1 ) ) {
        keyString += "-";
      }
    }
    
    return keyString;

  }

  function sort_bubble(){
      let data = [15,12,0,45,8], i, n, step, temp;
      n = data.length;

      
      for(step=0;step<n-1;++step){
        for(i=0;i<n-step-1;++i){
          if(data[i]>data[i+1]){  /* To sort in descending order, change > to < in this line. */
              temp=data[i];
              data[i]=data[i+1];
              data[i+1]=temp;
          }
        }
      }
      console.log("[data awal]: "+JSON.stringify(data));
      console.log("[BUBBLE SORT] ");
      console.log("Urutan terendah: ");
      for(i=0;i<n;++i)
           console.log(data[i]);
      return 0;
  }


  
  function sorte(points=null) {
    points = [40, 100, 1, 5, 25, 10];
    console.log(points);
    return points.sort(function(a, b){return a - b});
  }

  // let v = sorte(points);
  // console.log(v); // asc
  // console.log(v.reverse()); //desc




  
  // INI LIBRARY TABLE APPS ALL
  function create_tbl(table_name, thead_list){
    $('div[name='+table_name+']').children().remove();

    let td_list = '';
    for(let i=0; i<thead_list.length; i++){
      td_list += '<th>'+thead_list[i]+'</th>';
    }

    let el_new_tbl = 
    '<table class="table table-bordered" name="'+table_name+'">'+
      '<thead>'+
        '<tr>'+td_list+'</tr>'+
      '</thead>'+
      '<tbody></tbody>'+
      // '<tfoot></tfoot>'+ // ini TAMBAHAN, kalo ERROR>> HAPUS
    '</table>';
    $('div[name='+table_name+']').append(el_new_tbl);
  }



  

  //================  GRAFIK =====================

  function amchart_pie(datajs){ // 3D grafik pie
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("chartdiv", am4charts.PieChart3D);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.legend = new am4charts.Legend();

    // chart.data = [
    //   {
    //     country: "Lithuania",
    //     litres: 501.9
    //   },
    //   {
    //     country: "Czech Republic",
    //     litres: 301.9
    //   },
    //   {
    //     country: "Ireland",
    //     litres: 201.1
    //   }
    // ];

    
    chart.data = datajs;

    var series = chart.series.push(new am4charts.PieSeries3D());
    // series.dataFields.value = "litres";
    // series.dataFields.category = "country";
    series.dataFields.value = "total_kunjungan";
    series.dataFields.category = "total_kunjungan";
  }



  function var_my_color(obj_name){
    // start dari warna terang
    let colors = [
          '#9AFE2E', '#FE2E2E', '#FE642E', '#FE9A2E', '#FACC2E', 
          '#F7FE2E', '#C8FE2E', '#64FE2E', '#2EFE2E', '#2EFE64', 
          '#2EFE9A', '#2EFEC8', '#2EFEF7', '#2ECCFA', '#2E9AFE', 
          '#2E64FE', '#2E2EFE', '#642EFE', '#9A2EFE', '#CC2EFA', 
          '#FE2EF7', '#FE2EC8', '#FE2E9A', '#FE2E64', '#A4A4A4',

          '#DF0101', '#DF0101', '#DF7401', '#DBA901', '#D7DF01',
          '#A5DF00', '#74DF00', '#3ADF00', '#01DF01', '#01DF3A',
          '#01DF74', '#01DFA5', '#01DFD7', '#01A9DB', '#0174DF',
          '#013ADF', '#0101DF', '#3A01DF', '#7401DF', '#A901DB',
          '#DF01D7', '#DF01A5', '#DF0174', '#DF013A', '#6E6E6E'

        ];

    let color_use = [];

    switch(obj_name){
      case 'grf_donat_kunjungan_poli' :
      case 'grf_donat_kunjungan_poli_legend' :
          for(let i=0; i<colors.length; i+=2){
            color_use.push(colors[i]);
          }
        break;

      case 'grf_bar_kunjungan_klinik_1hari' :
      case 'grf_bar_kunjungan_klinik_1hari_legend' :
          for(let i=0; i<colors.length; i+=2){
            color_use.push(colors[i]);
          }
        break;

      default :
          for(let i=0; i<colors.length; i+=2){
            color_use.push(colors[i]);
          }
        break;
    }
            

    return color_use;
  }


  function chartjs_pie(datajs, element_name, value, label){
    // div[name=grf_donat_kunjungan_poli]
    $('div[name='+element_name+']').children().remove();
    let el_canvas = '<canvas class="pieChart" style="height:250px"></canvas>'; 
    $('div[name='+element_name+']').append(el_canvas);
    
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.

    // let my_color = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de' ];
    // hexa color dibawah ini referensi di: https://html-color-codes.info/
    let my_color = var_my_color(element_name);

    // transform datajs dari saya ke format json chartjs template
    let data_chartjs = [];
    for(let i=0; i<datajs.length; i++){
      let xxjs = {
          value    : datajs[i][value],
          color    : my_color[i],
          highlight: my_color[i],
          label    : datajs[i][label]
        };
      data_chartjs.push(xxjs);
    }


    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    let pieChartCanvas = $('div[name='+element_name+'] .pieChart').get(0).getContext('2d');
    let pieChart       = new Chart(pieChartCanvas);
    // var PieData        = [
    //   {
    //     value    : 700,
    //     color    : '#f56954',
    //     highlight: '#f56954',
    //     label    : 'Chrome'
    //   },
    //   {
    //     value    : 500,
    //     color    : '#00a65a',
    //     highlight: '#00a65a',
    //     label    : 'IE'
    //   }
    // ];

    let PieData = data_chartjs;

    let pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);


    // buat legend
    chartjs_pie_label(
          datajs, element_name+'_legend', 
          value, label
        );
  }
  

  function chartjs_pie_label(datajs, element_name, value, label){
    $('div[name='+element_name+']').children().remove();
    let my_color = var_my_color(element_name);

    // $(element).append('<div class="row"></div>'); 

    let divide = 2,
        sisa   = 1;
    let loop_start  = '',
        loop_end    = '',
        max_loop_list = '',
        last_max_loop_list = '';

    let bilangan = '';
    if(datajs.length%2 == sisa){
      bilangan = 'GANJIL';
      // max_loop_list = parseInt(datajs.length/divide)+1;
      max_loop_list = (datajs.length+1)/divide;
      last_max_loop_list = max_loop_list-sisa;
    }else{
      bilangan = 'GENAP';
      // max_loop_list = parseInt(datajs.length/divide);
      max_loop_list = datajs.length/divide;
    }

    console.log([bilangan, max_loop_list]);


    for(let j=0; j<divide; j++){
      let el_col = '<div class="col-md-6" id="col_'+j+'"></div>';
      $('div[name='+element_name+']').append(el_col); 

      loop_start = j*max_loop_list;
      // for(let i=0; i<max_loop_list; i++){
      if(j == (divide-1)){ // LAST LOOP
        if(bilangan == 'GANJIL'){
          // loop_end = (j+1)*last_max_loop_list;
          loop_end = (j*max_loop_list)+last_max_loop_list;
        }else{
          loop_end = (j+1)*max_loop_list;
        }
      }else{
        loop_end = (j+1)*max_loop_list;
      }

      // for(let i=j*max_loop_list; i<(j+1)*(max_loop_list); i++){
      for(let i=loop_start; i<loop_end; i++){          
        console.log(i+'_'+datajs[i][label]);
        let el = 
            '<div>'+
              '<i class="fa fa-circle" style="color:'+my_color[i]+'"></i> &emsp;'+
              '<span id="label">'+datajs[i][label]+' ('+datajs[i][value]+')</span>'+
              // '<span id="label">'+i+'_'+j+'_'+datajs[i][label]+'</span>'+
            '</div>';
        // $('#col_'+j).append(el);         
        $('div[name='+element_name+']>#col_'+j).append(el);
      }

      console.log('_');

    }

  } 



  function chartjs_line(element_name, data, objLine){
    $('div[name='+element_name+']').children().remove();
    let el_canvas = '<canvas class="lineChart" style="height:250px"></canvas>'; 
    $('div[name='+element_name+']').append(el_canvas);
    // let data = [
    //   [65, 59, 80, 81, 56, 55, 40, 60],
    //   [28, 48, 40, 19, 86, 27, 90, 57],
    //   [45, 59, 48, 60, 55, 15, 65, 78],
    //   [30, 40, 75, 55, 70, 35, 45, 75]
    // ];
    console.log(data);


    let lineColors = [
      '#FE642E', 'rgba(60,141,188,0.9)', 
      '#12b882', '#c2294f', '#a32497', '#bd7728'];

    // let objLine = ['Electronics','Digital Goods','Books','Foods'];
    let xlabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
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
    var lineChartCanvas = $('div[name='+element_name+'] .lineChart').get(0).getContext('2d')
    var lineChart       = new Chart(lineChartCanvas)

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


    // buat legend
    let el;
    $('ul[name='+element_name+'_legend]').children().remove();
    for (let i=0; i<datasets.length; i++){
      el = 
        '<li>'+
          '<i class="fa fa-circle" style="color:'+lineColors[i]+';"></i>'+
          '<span id="label">'+objLine[i]+'</span>'+
        '</li>';
      // $('#myLblLegend_lineChart').append(el);
      $('ul[name='+element_name+'_legend]').append(el);
    }
  }  


  // function chartjs_bar(element_name, data, objLine){
  function chartjs_bar(element_name, data){
    $('div[name='+element_name+']').children().remove();
    let el_canvas = '<canvas class="barChart" style="height:250px"></canvas>'; 
    $('div[name='+element_name+']').append(el_canvas);

    //-------------
    //- BAR CHART -
    //-------------
    // let labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    // let datasets = [
    //     {
    //       label               : 'Electronics',
    //       fillColor           : 'rgba(210, 214, 222, 1)',
    //       strokeColor         : 'rgba(210, 214, 222, 1)',
    //       pointColor          : 'rgba(210, 214, 222, 1)',
    //       pointStrokeColor    : '#c1c7d1',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(220,220,220,1)',
    //       data                : [65, 59, 80, 81, 56, 55, 40]
    //     },
    //     {
    //       label               : 'Digital Goods',
    //       fillColor           : 'rgba(60,141,188,0.9)',
    //       strokeColor         : 'rgba(60,141,188,0.8)',
    //       pointColor          : '#3b8bba',
    //       pointStrokeColor    : 'rgba(60,141,188,1)',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgba(60,141,188,1)',
    //       data                : [28, 48, 40, 19, 86, 27, 90]
    //     }
    //   ];

    // let areaChartData = {
    //   labels  : labels,
    //   datasets: datasets
    // };

    // let areaChartData = data;

    var barChartCanvas                   = $('div[name='+element_name+'] .barChart').get(0).getContext('2d');
    var barChart                         = new Chart(barChartCanvas);
    // var barChartData                     = areaChartData;
    var barChartData                     = data;
    // barChartData.datasets[1].fillColor   = '#00a65a';
    // barChartData.datasets[1].strokeColor = '#00a65a';
    // barChartData.datasets[1].pointColor  = '#00a65a';
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
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
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  }
  //================ \GRAFIK =====================

  //================  DATE =====================
  function maxday_of_month(th_bln=null) { // $th_bln = '2019-04';
    let fulldate = th_bln+'-01'; // syarat tanggal harus 01
    // $plusBln = date('Y-m-d', strtotime("+1 months", strtotime($fulldate)));
    // $val   = date('Y-m-d', strtotime('-1 days', strtotime($plusBln)));
    let plusBln = moment(fulldate).add('months', 1).format('YYYY-MM-DD');
    let val   = moment(plusBln).add('days', -1).format('YYYY-MM-DD');
    return val;
  }

  function bulan_indo(id){
    let bulan = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
    return bulan[id-1];
  }

  function sdate(digit){ //change 1 to '01'
    if(digit<10){
      digit = "0"+digit;
    }
    return digit;
  }

  function month_now_yesterday(get_tgl=null){ //$get_tgl= '2019-04-01'
    // let date = new DateTime(get_tgl);
    // let year = (int) date->format('Y');
    let year = parseInt(moment(get_tgl).format('YYYY'));
    // let month_now = (int) date->format('m');
    let month_now = parseInt( moment(get_tgl).format('MM') );
    let month_yesteday = month_now-1;
    let year_yesteday = '';

    if(month_yesteday == 0){
      month_yesteday = 12;
      year_yesteday = year-1;
    }else{
      year_yesteday = year;
    }

    // console.log(month_now);
    // console.log(sdate(month_now));
    let val = {
      "now" : {      
        "month_lbl" : sdate(month_now),
        "month" : month_now,
        "bulan_indo" : bulan_indo(month_now),
        "year"  : year,
        "startday" : year+"-"+sdate(month_now)+"-01",
        "endday" : maxday_of_month( year+"-"+sdate(month_now) ),
        "maxday" : moment(maxday_of_month( year+"-"+sdate(month_now) )).format("DD"),
        // "maxday" => explode('-', maxday_of_month( year."-".sdate(month_now) ) )[2] ,
      },
      "yesterday" : {
        "month_lbl" : sdate(month_yesteday),
        "month" : month_yesteday,
        "bulan_indo" : bulan_indo(month_yesteday),
        "year"  : year_yesteday,
        "startday" : year+"-"+sdate(month_yesteday)+"-01",
        "endday" : maxday_of_month( year_yesteday+"-"+sdate(month_yesteday) ),
        "maxday" : moment(maxday_of_month( year_yesteday+"-"+sdate(month_yesteday) )).format("DD"),
        // "maxday" => explode('-', maxday_of_month( $year_yesteday."-".sdate($month_yesteday) ) )[2] ,
      }
    };

    return val;
  }
  //================ \DATE =====================

  //================ STATISTIC_HOSPITAL =====================

              
  // LOS ( Length Of Stay ) = Rata-2 lama dirawat | (3-12) Hari

  function BOR(HP=null, TT=null, T=null){
    // BOR ( Bed Occupancy Rate ) = Rata-2 TT ditempati | (75-85)%
    // BOR = (Jumlah hari perawatan rumah sakit / (Jumlah tempat tidur x Jumlah hari dalam satu periode)) X 100%
    // BOR = (Jumlah HP / (Jumlah TT x Periode)) X 100%

    //((Jumlah TT X Periode) – HP) / Jumlah KHM
    let val = (parseInt(HP)/(parseInt(TT)*T) )*100;
    return val.toFixed(2);
  }

  function LOS(LD=null, KHM=null){
    // AVLOS (Average Length of Stay) = Rata-rata lamanya pasien  | (6-9)hari
    // AVLOS = Jumlah lama dirawat / Jumlah pasien keluar (hidup + mati)
    // AVLOS = Jumlah LD / Jumlah KHM
    let val = parseInt(LD)/parseInt(KHM);
    return val.toFixed(2);
  }

  function TOI(KHM=null, TT=null, T=null, HP=null){
    // TOI ( Turn Over Interval ) = Selang waktu TT terpakai lagi  | (1-3) Hari
    // TOI = ((Jumlah tempat tidur X Periode) – Hari perawatan) / Jumlah pasien keluar (hidup + mati)
    // TOI = ((Jumlah TT X Periode) – HP) / Jumlah KHM

    //((Jumlah TT X Periode) – HP) / Jumlah KHM
    let val = ( (parseInt(TT)*T)-parseInt(HP) )/parseInt(KHM);
    return val.toFixed(2);
  }

  function BTO(KHM=null, TT=null){        
    // BTO ( Bed Turn Over ) = Frek pemakaian TT | (35-45) Pasien
    // BTO = Jumlah pasien keluar (hidup + mati) / Jumlah tempat tidur
    // BTO = Jumlah KHM / Jumlah TT
    let val = parseInt(KHM)/parseInt(TT);
    return val.toFixed(2);
  }

  function GDR(KHM=null, dead=null){ 
    // GDR : <45 per mil        
    // GDR = ( Jumlah pasien mati seluruhnya / Jumlah pasien keluar (hidup + mati)) X 1000 permil
    // GDR = ( Jumlah MATI / Jumlah KHM) X 1000 permil
    let val = (parseInt(dead)/parseInt(KHM))*1000;
    return val.toFixed(2);
  }

  function NDR(KHM=null, dead_lebih48=null){     
    // NDR = (Jumlah pasien mati > 48 jam / Jumlah pasien keluar (hidup + mati)) X 1000 permil
    // NDR = (Jumlah 'dead>=48' / Jumlah KHM) X 1000 permil      
    let val = (parseInt(dead_lebih48)/parseInt(KHM))*1000;
    return val.toFixed(2);
  }
  
  //================\STATISTIC_HOSPITAL =====================
  
    
  
  function blob_json(data, filename, linkname, id_element){
    //ADD this element to html:: <div id="json"></div>
    //EX:: blob_json(cleanScript, "backup", "Download backup", "json");
    var jsonse = JSON.stringify(data);
    var blob = new Blob([jsonse], {type: "application/json"});
    var url  = URL.createObjectURL(blob);
    
    var a = document.createElement('a');
    a.href        = url;
    a.download    = filename+".json";
    a.textContent = linkname+".json";
    
    document.getElementById(id_element).appendChild(a);
  }


  
  // 2021.03.05
  function submitForm(idForm=null, url=null){
    var data = $(idForm).serialize();

    let js_submit = _ajax_web("POST", url, data );
    return js_submit;

    // console.log(js);
    // return false;

    // $.ajax({
    //     type : 'POST',
    //     url  : url,
    //     data : data,
    //     success :  function(data){
    //         $(".display").html(data);
    //     }
    // });
  }

  
  // 2021.03.05
  // TERBARU POPUP PRINT PAKE INI. SIMPLE
  function popup_print_url(url=null){
    // let data = btoa( JSON.stringify(jpost) );
    // console.log(data);

    $("#div_frame").children().remove();
    let src = baseUrl()+"main/file_template/popup_print/"+url;
    $('#div_frame').append('<iframe name="frame" src="'+src+'" style="display:none;"></iframe>');
    window.frames['frame'].print();

    window.frames['frame'].onafterprint = function(){
      $("#div_frame").children().remove();
      //alert("Printing completed...");
      /////window.location = baseUrl()+"vclaim/tes_cetak";
    };

  }

	//*************************************************************************/
  //                           \LIBRARY_SOFTWARE
  //*************************************************************************/







  //*************************************************************************/
  //		                           NOTE
  //*************************************************************************/

  //CONTOH JSON, javascript array variable
function greeting (obj) {
    alert('Hello ' + obj.first + ' ' + obj.last);
}
var nameObject = {
    first: 'Joe',
    last: 'Schmoe'
};

//greeting(nameObject);  // Hello Joe Schmoe



  function get_umur_bulan(tglLahir){ 
    let a = moment( moment().format('YYYY-MM-DD') );
    let b = moment( tglLahir );
    let diffInMonths = a.diff(b, 'months') % 12;

    return diffInMonths;
  }

  function get_umur_fx(tglLahir,param){ 
    let a = moment( moment().format('YYYY-MM-DD') );
    let b = moment( tglLahir );
    //let diffInDays = a.diff(b, 'days');
    //let dur = moment.duration(a.diff(b, 'days'));
    let dur = moment.duration(a.diff(b));
    //return dur;
    //return dur.get('years') +'&'+ dur.get('months') +'&'+ dur.get('days');
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
  
  function get_umur_fx_new(tglLahir=null){ 
    let a = moment( moment().format('YYYY-MM-DD') );
    let b = moment( tglLahir );
    //let diffInDays = a.diff(b, 'days');
    //let dur = moment.duration(a.diff(b, 'days'));
    let dur = moment.duration(a.diff(b));

    let val = {
      tahun : dur.get('years'),
      bulan : dur.get('months'),
      hari  : dur.get('days'),
      duration: dur,
    };

    return val;
  }





// var a = moment([2007, 11, 29]);
// var b = moment([2007, 0, 28]);
// var diffInMs = a.diff(b); // 86400000 milliseconds
// var diffInDays = a.diff(b, 'days'); // 1 day

// var a = moment('2018-04-29');
// var b = moment('2018-01-28');
// var diffInMs = a.diff(b); // 86400000 milliseconds
// //var diffInDays = a.diff(b, 'days'); // 1 day
// var diffInMonths = a.diff(b, 'months'); // 1 day
// console.log(diffInDays);



  //*************************************************************************/
  //		                           \NOTE
  //*************************************************************************/