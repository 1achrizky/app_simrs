$(function (){
	// console.log('OK web');

  // let jpost_cetak_noantrian = {
  //   url 		  : _ADDR,
  //   button_id : $(this).attr("id"),
  //   billing    : exe.response.xrec.data.data_utama.billing,
  //   no_antrian : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.generate.antri["3d"],// noantrian_ready_3digit,
  //   tglrujukan : get_tglRujukan, // get_tglKunjungan,
  //   nama   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.data.Nama, // $('span[name=pasienRscm_nama]').text(),
  //   dpjp   : exe.response.xrec.data.data_paket.jpost_insert_reg_cm.dataPost.rs.dokter.nama,//$('input[name=cari_jadok]').val(),
  //   nosep  : get_nosep_temp
  // };

	if( open_site('daftarmandiri/px_cetak_antrian_book') ){
    console.log('daftarmandiri/px_cetak_antrian_book');

    // let j = _ajax_web("GET", baseUrl()+"daftarmandiri/antrian_book/000541/2021-11-25/33", '');
    // console.log(j);
    
    let li_klinik = _ajax_web("GET", baseUrl()+"daftarmandiri/get_klinik_bpjs", '');
    console.log(li_klinik);
    
    let opts = '';
    for (let i = 0; i < li_klinik.length; i++) {
      opts += '<option value="'+li_klinik[i].lokasi+'" data-arr="'+i+'">'+li_klinik[i].lokasiket+'</option>';        
    }
    $('#selKlinik').append(opts);
    
    let j = null;
    $('#getKlinik').click(function(){
      norm = $('#norm').val();
      tgl = $('#tgl').val();
      j = _ajax_web("GET", baseUrl()+"daftarmandiri/antrian_book_multiklinik/"+'/'+norm+'/'+tgl, '');
      console.log(j);

      // $('#selKlinik').children().remove();
      let opts = '';
      for (let i = 0; i < j.length; i++) {
        opts += '<option value="'+j[i].lokasi+'" data-arr="'+i+'">'+j[i].lokasiket+'</option>';        
      }
      $('#selKlinik').append(opts);
    });


    // 000541
    let jpost_cetak_noantrian = null;
    $('#btn_cetak_antrian_skdp').click(function(){
      // let id = $('#selKlinik').data('arr');
      // console.log(id);

      let klinik = $('#selKlinik').val();
      console.log(klinik);
      norm = $('#norm').val();
      tgl = $('#tgl').val();
      j = _ajax_web("GET", baseUrl()+"daftarmandiri/antrian_book/"+'/'+norm+'/'+tgl+'/'+klinik, '');
      console.log(j);

      j = j[0];
      // return false;

      let _ADDR = 'daftarmandiri/px_cetak_antrian';
      jpost_cetak_noantrian = {
        url 		  : _ADDR,
        button_id : $(this).attr("id"),
        billing    : j.norm,
        no_antrian : j.norequest,
        tglrujukan : '', //
        nama   : j.nama,
        dpjp   : j.dokterket,
        nosep  : '',
      };
      console.log({jpost_cetak_noantrian: jpost_cetak_noantrian});

      wsprinter = _ajax_web("POST", baseUrl()+"print_termal/wsprinter_send/termal_nomor_antrian_new", jpost_cetak_noantrian);
      console.log(wsprinter);

    });
    

    
    
  }

	// if( open_site('web/index.php?r=bpjs2/caripeserta') ){
	// 	$('#btnCariPx').click(function(){
	// 		console.log($('#inNoka').val());

	// 		let url = 'http://192.168.1.68/rscm/simrsnew/web/index.php?r=bpjs2/peserta&noKartu='+$('#inNoka').val();
	// 		let res = _ajax('GET', url, '');
	// 		console.log(res);
	// 		let js_str = JSON.stringify(res, null, 4);
	// 		$('#val').val(js_str);
	// 	});
	// }





  //===========================[ FUNCTION ]===================================
  function prettyJson(js){
    return JSON.stringify(js, null, 4);
  }
  
  function addSelectOption(selector, data, value, label){
    $(selector).children().remove();
    // if(data.length >1) // if <1, tanpa OPSI PILIH
      $(selector).append('<option value="">-pilih-</option>'); 
        
    for (let i = 0; i < data.length; i++) {
      let opt = '<option value="'+data[i][value]+'">'+data[i][label]+'</option>';
      $(selector).append(opt);
    }
  }
  
  function addSelectOptionKlinik(selector, data, value, label){
    $(selector).children().remove();
    // if(data.length >1) // if <1, tanpa OPSI PILIH
      $(selector).append('<option value="">-pilih-</option>'); 
    // else loadDokter(data[0][value]);
    // // console.log(['tes',data[0][value] ]);
    
    for (let i = 0; i < data.length; i++) {
      let opt = '<option value="'+data[i][value]+'">'+data[i][label]+'</option>';
      $(selector).append(opt);
    }
  }

  
  $('form').on('keyup keypress', function(e) {
    // DISABLE MALFUNCTION PRESS ENTER BUTTON
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });

  function formAddInputHidden(form, parameter, value){
    $("<input type='hidden' />")
      .attr("name", parameter)
      .attr("value", value)
      .appendTo($(form));
  }
  
  function toAutocomplete(dt, keyvar){
    let rli = [];
    for (let i = 0; i < dt.length; i++) {
      rli.push(dt[i][keyvar]);
    }
    return rli;
  }

  function inArrayAutocompleteSelected(key, array_autocomplete, array_master){
    // get index array dari "array autocomplete", kemudian dicari di "master array(ex: array ws_multirujukan)"
    // array_autocomplete : array dari autocomplete
    // array_master : array dari master array
    let x = array_master[$.inArray(key, array_autocomplete)];
    return x;
  }

  function keycodeCheck(e, key){
    // GAK BISA
    // let key = [37,38,39,40,8];
    let code = (e.keyCode ? e.keyCode : e.which);
    if($.inArray(code, key) !== -1){
      console.log(code, $.inArray(code, key) )
      e.preventDefault();
      return false;
    } 
    // else return true;
  }

  function keycodeCheckReturn(e){
    // GAK BISA
    let code = (e.keyCode ? e.keyCode : e.which);
    console.log(code);
    switch (code) {
      case 40: //down key
      case 38: //up key
      case 37: //left key
      case 39: //right key
      case 8: //backspace
      //add more cases for special buttons
        return;
    }
  }


  // function notifLabel( code=null, message=null, type=null){
  //   if(type == null) type = (code==200)? 'success' : 'danger';
    
  //   let html = 
  //     '<div style="margin:2px 0px;">'+
  //       '<span name="'+code+'" class="alert alert-'+type+'" style="padding:0px 5px;">'+message+'</span>'+
  //     '</div>';

  //   let notif = {
  //     code  	 : code,
  //     message  : message,
  //     html  	 : html,
  //   };
  //   return notif;
  // }

  // function loadNotifLabel(notif){
  //   $('#notifLabel').children().remove();
  //   for (let i = 0; i < notif.length; i++) $('#notifLabel').append(notif[i].html);
  // }

  
  function notifLabelHtml( code=null, message=null, alertType=null, keyName=null){
    if(alertType == null) alertType = (code==200)? 'success' : 'danger';
    keyName = (keyName==null)? '' : keyName;
    
    let html = 
      '<div style="margin:2px 0px;">'+
        '<span name="'+keyName+'" data-code="'+code+'" class="alert alert-'+alertType+'" style="padding:0px 5px;">'+message+'</span>'+
      '</div>';
    return html;
  }

  function loadNotifLabelHtml(notifs){
    $('#notifLabel').children().remove();
    for (let i = 0; i < notifs.length; i++) $('#notifLabel').append( 
      notifLabelHtml(notifs[i].code, notifs[i].message, notifs[i].alertType, notifs[i].keyName) 
    );
  }

  

  function DataTable_AdjustColumn(idModal){
    $(document).on('shown.bs.modal',idModal, function () {
      console.log('shw');
      $($.fn.dataTable.tables(true)).DataTable()
         .columns.adjust();
    });
  }


  function loadDokter(kdLokasi=null){
    // let jnsPelayanan = 2; //Jenis Pelayanan (1. Rawat Inap, 2. Rawat Jalan)
    rDokter = _ajax_web('GET', baseUrl()+'wsbpjs2/refDokterDpjp/'+kdLokasi, '');
    console.log(rDokter);
    if(rDokter.metaData.code!=200){ alert(rDokter.metaData.message); return false; }
    else rDokter = rDokter.response;

    rDokterNama = toAutocomplete(rDokter.list, 'nama');
    console.log(rDokterNama);
    $('input[name=dpjpLayan_bpjs]').autocomplete({ source: rDokterNama });
    $('input[name=dpjp_bpjs]').autocomplete({ source: rDokterNama });

    //tambahan
    let val = {
      source : {
        refDokterDpjp : rDokter,
        Autocomplete  : rDokterNama,
        rDokterKode   : toAutocomplete(rDokter.list, 'kode'),
      }
    };
    return val;
  }

  //===========================[\FUNCTION ]===================================



	// if( open_site('bo/menu/it/uat/create-sep') ){
	if( open_site('wsbpjs2/uat/create-sep') ){
    let notif = [];
    let px = null;
    let mRjk = null;
    let mRjk_selected = null;


    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    // // tes
    // // let _this= '0002038123146';
    // let _this= '0002065613501';
    // let url = 'Rujukan/List/Peserta/'+_this;
    // let mRjk = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
    // console.log(mRjk);
    // console.log(mRjk.rujukan);
    // //\tes
    

    let ld_laka_first = 0;
    $('select[name=lakaLantas]').on('change', function(e){
      let _this = $(this).val();
      console.log(_this);
      if(_this == '') $('.laka').hide();
      else{ $('.laka').show(); ld_laka_first++; } 

      if(ld_laka_first==1){
        let ld_first_laka = _ajax_web('GET', baseUrl()+'wsbpjs2/ld_first_laka', '');
        console.log(ld_first_laka);
    
        addSelectOption('select[name=kdPropinsi]', ld_first_laka.lokasiLaka.propinsi, 'kode', 'nama');
        addSelectOption('select[name=kdKabupaten]', ld_first_laka.lokasiLaka.kabupaten, 'kode', 'nama');
        addSelectOption('select[name=kdKecamatan]', ld_first_laka.lokasiLaka.kecamatan, 'kode', 'nama');
      }      
    });    


    //========================== MODAL AMBIL BOOKING ===========================
    let jsBook = [];
    $('#btn_ambil_booking').click(function(){      
      let tgl = moment( moment().subtract(1, 'day') ).format('YYYY-MM-DD'); //YESTERDAY !!!!!!!
      // let tgl = moment( moment().subtract(0, 'day') ).format('YYYY-MM-DD'); //TODAY !!!!!!!
      //let tgl = moment().format('YYYY-MM-DD'); //TODAY, IKI TES, sebenere yesterday
      
      jsBook = _ajax("GET", "db/m_daftarmandiri/gd_booking/"+tgl, "" );
      jsBook = jsBook.dtjs;
      console.log(jsBook);

      let tbl = {
        id : 'tbl_mdl_book',
        headers : [
          ['nama','Nama'],  
          ['noanggota','NOKA','style="text-align:center;"'],  
          ['norequest','NOREQ','style="text-align:center;"'],
          ['time','TIME','style="text-align:center;"'],
          ['dokterket','DOKTER'],  
          ['lokasiket','SPESIALIS','style="text-align:center;"'],  
          ['penanggungket','PENANGGUNG'],
        ],
        data : jsBook,
        button : { color:'success', head:'OPSI', label:'PILIH',},
      };
  
      let mdl = {
        id    : 'modal_book',
        bodyId: 'el_modal2',
        size  : 'lg',
        title : 'Daftar Tabel Booking',
        table : create_table_return2(tbl),
      };

      let el = create_modal(mdl);
      $('#modal_mst_book').append(el); // HARUS ADA DI HTML file
      $('#'+tbl.id).DataTable({ "scrollX": true });        
      $('#'+mdl.id).modal('show');
    });

    $(document).on('click','#tbl_mdl_book tbody tr td .btn_ok', function(e){
      e.preventDefault();
      console.log($(this).data('id'));

      book_ok = jsBook[$(this).data('id')];
      console.log(book_ok);
      let r = book_ok;

      $('input[name=FL_ambil_px_book]').val('1');
      $('input[name=book_date]').val(r.date);
      $('input[name=book_time]').val(r.time);

      $('input[name=noka]').val(r.noanggota);
      $('input[name=noka]').focus();

      $('input[name=nama_bpjs]').val(r.nama);
      $('input[name=norm_bpjs]').val(r.norm);

      // $('input[name=noRujukan]').val(r.noKunjungan);
      // $('input[name=asalPpk]').val(r.provPerujuk.nama);
      // $('input[name=asalPpkKode]').val(r.provPerujuk.kode);

      // $('input[name=dxkey]').val(r.diagnosa.kode);
      // addSelectOption('select[name=dx]', [r.diagnosa], 'kode', 'nama');
      
      $('input[name=klinikkey]').val(r.kdpoli_bpjs);
      // addSelectOptionKlinik('select[name=klinik]', [r.poliRujukan], 'kode', 'nama');

      // // loadDokter(r.poliRujukan.kode);
      lDokter = loadDokter(r.kdpoli_bpjs);
      console.log(lDokter); // ini ada isi rDokterNama
      rDokter = lDokter.source.refDokterDpjp;
      console.log(rDokter);

      rDokterNama = lDokter.source.Autocomplete;
      console.log(rDokterNama);

      // auto select dokter yang sudah dipilih di booking
      console.log('KODE DOKTER BPJS=', r.kd_dpjp_bpjs);
      
      // get dokter by KODE DOKTER BPJS
      getDokterLayan = inArrayAutocompleteSelected(r.kd_dpjp_bpjs, lDokter.source.rDokterKode, rDokter.list);
      console.log(getDokterLayan);
      $('input[name=dpjpKode_bpjs]').val(getDokterLayan.kode); //type HIDDEN
      $('input[name=dpjp_bpjs]').val(getDokterLayan.nama);
      $('input[name=dpjpLayanKode_bpjs]').val(getDokterLayan.kode); //type HIDDEN
      $('input[name=dpjpLayan_bpjs]').val(getDokterLayan.nama);

      $('#tbl_mdl_book').DataTable().destroy(); // DISABLE
      $('#modal_book').modal('hide');
    });

        
    //==========================\MODAL AMBIL BOOKING ===========================


    // $("input[name=noka]").val('0002065613501');
    $("input[name=noka]").focus();

    $("input[name=noka]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      // let _this = '0002065613501';
      if (e.which == 13) {
        console.log(_this);

        // let url = baseUrl()+'wsbpjs2/peserta/'+_this;
        // url?url=Rujukan/List/Peserta/0002038123146

        // let url = 'Rujukan/List/Peserta/'+_this;
        R = _ajax_web('GET', baseUrl()+'wsbpjs2/cariPesertaFilter/'+_this, '');
        console.log(R);

        notif = R.notifLabel;
        // notif.push( notifLabel(mRjk.metaData.code, '('+mRjk.metaData.code+') '+mRjk.metaData.message ) );
        loadNotifLabelHtml(notif);

        if(R.peserta.metaData.code!=200) return false; 

        px = R.peserta.response.peserta;
        console.log(px);

        // SHOW data PESERTA
        $('input[name=nik_bpjs]').val(px.nik);
        $('input[name=nama_bpjs]').val(px.nama);
        $('input[name=tgllahir_bpjs]').val(px.tglLahir);
        $('input[name=kelas_bpjs]').val(px.hakKelas.keterangan);
        // $('input[name=asalPpk]').val();
        $('input[name=jns_peserta]').val(px.jenisPeserta.keterangan);
        $('input[name=norm_bpjs]').val(px.mr.noMR);
        $('input[name=telp_bpjs]').val(px.mr.noTelepon);
        $('input[name=prolanis]').val(px.informasi.prolanisPRB);

                
        if(R.mRjk.metaData.code!=200) return false;
        else mRjk = R.mRjk.response;        
        console.log(mRjk);

        let tbl = {
          id : 'tbl_mdl_mRjk',
          headers : [
            ['noKunjungan','No.Rujukan','style="text-align:center;"'],  
            ['tglKunjungan','Tgl.Rujukan','style="text-align:center;"'],  
            [ ['checkRjk','shortMsg'],'Status Rujukan','style="text-align:center;"', 'sub'],
            [ ['poliRujukan','nama'],'Spesialis','style="text-align:center;"', 'sub'],
          ],
          data : mRjk.rujukan,
          button : {
            color : 'success',
            head : 'OPSI',
            label : 'PILIH',
          },
        };
         
        let el_tbl = create_table_return2(tbl, mRjk.rujukan); 
        // console.log(el_tbl);
    
        let mdl = {
          id    : 'modal_mRjk',
          bodyId: 'el_modal2',
          size  : 'lg',
          title : 'Daftar Multi Rujukan',
          table : el_tbl,
        };
        let el = create_modal(mdl);
        $('#modal_mst_mRjk').append(el);
        $('#tbl_mdl_mRjk').DataTable({ "scrollX": true });        
        $('#modal_mRjk').modal('show');
        
      }
    });


    $("input[name=nik_bpjs]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);
        R = _ajax_web('GET', baseUrl()+'wsbpjs2/peserta_by_nik/'+_this, '');
        console.log(R);
        if(R.metaData.code=='200'){
          $('input[name=noka]').val(R.response.peserta.noKartu);
          $('input[name=nama_bpjs]').val(R.response.peserta.nama);
          $('input[name=tgllahir_bpjs]').val(R.response.peserta.tglLahir);
          $('input[name=noka]').focus();
        }else alert(R.metaData.message);        
        return false;
      }
    });
    
    $("input[name=noRujukan]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);
        R = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:'Rujukan/'+_this});
        console.log(R);
        if(R.metaData.code=='200'){
          $('input[name=noka]').val(R.response.rujukan.peserta.noKartu);
          $('input[name=nama_bpjs]').val(R.response.rujukan.peserta.nama);
          $('input[name=tgllahir_bpjs]').val(R.response.rujukan.peserta.tglLahir);
          $('input[name=tglRujukan]').val(R.response.rujukan.tglKunjungan);
          
        }else alert(R.metaData.message);        
        return false;
      }
    });

    
    let rDokter = null;
    // PILIH 1 OK dari MULTIRUJUKAN
    $(document).on('click','#tbl_mdl_mRjk tbody tr td .btn_ok', function(e){
      e.preventDefault();
      console.log($(this).data('id'));

      mRjk_selected = mRjk.rujukan[$(this).data('id')];
      console.log(mRjk_selected);      
      let r = mRjk_selected; 

           
      $('input[name=tglRujukan]').val(r.tglKunjungan);
      $('input[name=noRujukan]').val(r.noKunjungan);
      $('input[name=asalPpk]').val(r.provPerujuk.nama);
      $('input[name=asalPpkKode]').val(r.provPerujuk.kode);

      $('input[name=dxkey]').val(r.diagnosa.kode);
      addSelectOption('select[name=dx]', [r.diagnosa], 'kode', 'nama');
      
      $('input[name=klinikkey]').val(r.poliRujukan.kode);
      addSelectOptionKlinik('select[name=klinik]', [r.poliRujukan], 'kode', 'nama');

      // // cari list dokter, dg klinik yang sesuai rujukan
      // let jnsPelayanan = 2; //Jenis Pelayanan (1. Rawat Inap, 2. Rawat Jalan)
      // let url = 'referensi/dokter/pelayanan/'+jnsPelayanan+'/tglPelayanan/'+moment().format('YYYY-MM-DD')+'/Spesialis/'+r.poliRujukan.kode;
      // rDokter = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
      // console.log(rDokter);
      // if(rDokter.metaData.code!=200){ alert(rDokter.metaData.message); return false; }
      // else rDokter = rDokter.response;

      // rDokterNama = toAutocomplete(rDokter.list, 'nama');
      // console.log(rDokterNama);
      // $('input[name=dpjpLayan_bpjs]').autocomplete({ source: rDokterNama });
      // // cari list dokter, dg klinik yang sesuai rujukan


      // loadDokter(r.poliRujukan.kode);
      lDokter = loadDokter(r.poliRujukan.kode);
      console.log(lDokter);
      rDokter = lDokter.source.refDokterDpjp;


      $('#tbl_mdl_mRjk').DataTable().destroy(); // DISABLE
      $('#modal_mRjk').modal('hide');
    });


    
    $("input[name=klinikkey]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);

        let url = 'referensi/poli/'+_this;
        let r = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
        console.log(r);
        if(r.metaData.code!=200){ alert(r.metaData.message); return false; }
        else r = r.response;

        if(r==null){ alert("Data tidak ditemukan."); return false; }

        addSelectOptionKlinik('select[name=klinik]', r.poli, 'kode', 'nama');
        $("select[name=klinik]").focus();
      }
    });

    $('select[name=klinik]').on('change', function(e){
      let _this = $(this).val();
      console.log(_this);
      if(_this == 'MAT') $('.katarak').show();
      else $('.katarak').hide();

      if(_this == 'IGD') _this = 'UMUM';

      lDokter = loadDokter(_this);
      console.log(lDokter);
      rDokter = lDokter.source.refDokterDpjp;

      $('input[name=dpjp_bpjs]').focus();
    });

    

    $('input[name=dpjp_bpjs]').autocomplete({
      select: function( event, ui ) {
        getDokterLayan = inArrayAutocompleteSelected(ui.item.value, rDokterNama, rDokter.list);
        console.log(getDokterLayan, ui.item.value);
        $('input[name=dpjpKode_bpjs]').val(getDokterLayan.kode); //type HIDDEN
      }
    });
    
    $('input[name=dpjpLayan_bpjs]').autocomplete({
      select: function( event, ui ) {
        // console.log(ui, ui.item);
        // get_arrid_dokterLayanNama = $.inArray(ui.item.value, rDokterNama);
        // console.log(get_arrid_dokterLayanNama);
        // getDokterLayan = rDokter.list[get_arrid_dokterLayanNama];
        // console.log(getDokterLayan);
        // $('input[name=dpjpLayanKode_bpjs]').val(getDokterLayan.kode);
        
        getDokterLayan = inArrayAutocompleteSelected(ui.item.value, rDokterNama, rDokter.list);
        console.log(getDokterLayan);
        $('input[name=dpjpLayanKode_bpjs]').val(getDokterLayan.kode); //type HIDDEN
      }
    });


    DataTable_AdjustColumn('#modal_mRjk');

    $(document).on('hide.bs.modal','#modal_mRjk', function () {
      $('#tbl_mdl_mRjk').DataTable().destroy();
      console.log('modal hide');
    });



    
    
    // $("input[name=asalPPK_bpjs]").keyup(function (e) {
    //   let _this = $(this).val();
    //   // $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
    //   let jenis = 1;
    //   console.log(_this, _this.length, _this.slice(-1), /^[a-z0-9]+$/i , _this.slice(-1).match(/^[a-z0-9]+$/i) );

    //   if(_this.length>2 ){
    //     let url = baseUrl()+'wsbpjs2/refFaskes/'+_this+'/'+jenis;
		// 		let r = _ajax_web('GET', url, '');
		// 		console.log(r.faskes);
    //   }

    //   // // /^[a-z0-9]+$/i
    //   // if(_this.length>2 && _this.slice(-1)== /^[a-z0-9]+$/i ){
    //   //   let url = baseUrl()+'wsbpjs2/refFaskes/'+_this+'/'+jenis;
		// 	// 	let r = _ajax_web('GET', url, '');
		// 	// 	console.log(r.faskes);
    //   // }

    // });
    


    

    
    let rFaskesNama = [];
    let rFaskes = null;
    let getFaskes = null;
    $('input[name=asalPpk]').autocomplete({ source: [], minLength: 3 });    
    $('input[name=asalPpk]').autocomplete("disable");

    $("input[name=asalPpk]").on( "keyup", function( e ) {
      // if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
      // if ( $( this ).autocomplete( "instance" ).menu.active ) {
      let _this = $(this).val();
      // console.log(_this);

      // //key check
      let code = (e.keyCode ? e.keyCode : e.which);
      if($.inArray(code, [37,38,39,40,8,13]) !== -1) return false;

      if(_this.length>3 ){        
        let jenis = 1;
        let url = baseUrl()+'wsbpjs2/refFaskes/'+_this+'/'+jenis;
        let r = _ajax_web('GET', url, '');
        if(r.metaData.code!=200){ alert(r.metaData.message); return false; }
        else r = r.response;

        rFaskes = r.faskes;
        console.log(rFaskes);
        rFaskesNama = toAutocomplete(rFaskes, 'nama');
        console.log(rFaskesNama);

        $(this).autocomplete("enable");
        $(this).autocomplete("option", "source", rFaskesNama );
        $(this).autocomplete("search", _this);
      }

    });

    $('input[name=asalPpk]').autocomplete({
      select: function( event, ui ) {
        console.log(ui, ui.item);       
        
        getFaskes = inArrayAutocompleteSelected(ui.item.value, rFaskesNama, rFaskes);
        console.log(getFaskes);
        $('input[name=asalPpkKode]').val(getFaskes.kode);
      }
    });
    


    $("input[name=dxkey]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);

        let url = 'referensi/diagnosa/'+_this;
        let r = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
        console.log(r);
        if(r.metaData.code!=200){ alert(r.metaData.message); return false; }
        else r = r.response;

        addSelectOption('select[name=dx]', r.diagnosa, 'kode', 'nama');
      }
    });
    

    function encryptLazy(json=null){
      return LZString.compressToBase64(JSON.stringify(json));
    }
       
    // $(document).on('click', "form[name=frmCreateSep] input:submit[value='Create SEP']", function(e){
    $(document).on('click', "form[name=frmCreateSep] input:submit[name='createSep']", function(e){
      e.preventDefault();      

      wsfull_pre = {
        mRjk_selected : mRjk_selected,
        px : px, // peserta bpjs
      };

      let frm = 'form[name=frmCreateSep]';
      let serial = null;
      
      formAddInputHidden(frm, "wsfullEnc", encryptLazy(wsfull_pre));

      serial = $(frm).serialize();
      console.log(serial);

      let url  = $(frm).attr('action')+'createSep'; console.log(url);
      let js = _ajax_web("POST", url, serial );
      console.log(js);

      sep_res = js.response.sep_res;

      if(sep_res.metaData.code!=200) alert(sep_res.metaData.message); 
      else{
        alert(sep_res.metaData.message);
        $('input[name=nosep]').val(sep_res.response.sep.noSep);
        // reload();
        formAddInputHidden(frm, "wsResEnc_createSep", encryptLazy(js));
        formAddInputHidden(frm, "nosep_inhide", sep_res.response.sep.noSep);
        serial = $(frm).serialize();
        console.log( serial );

        // AJAX CREATE BILLING
        js2 = _ajax_web("POST", $(frm).attr('action')+'daftar_pasien_klik_bpjs', serial );
        console.log(js2);
        return false;

          // CEK BILL yg BARENG di klik itu DOBEL/tidak
          // >> BILLING KOSONG, SEP JADI <<???
          
          // ENTRY TINDAKAN BILLING. KHUSUS PX BPJS
          // let _FL_insert_tindakan = true;

          // // SP_129 = dr. Prima // dokter yg tanpa auto entry tindakan          
          let _FL_insert_tindakan = ( dokter_plh.kode_dok == 'SP_129')? false : true;

          if(_FL_insert_tindakan){
            if(penanggung_plh.bpjs){
              console.log("ENTRY TINDAKAN BILLING");
              // IGD/RJ >> StatusDaftar:RJ/UG
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

          $('input[name=get_bill_siap_pakai]').val(bill_response);
          $('input[name=get_nosep_temp]').val(get_nosep_temp);

          $('#btn_daftar').hide();         

      }      

      return false;
    });

    
    // $(document).on("click", ":submit", function(e){
    // $(document).on("click", "form[name=frmCreateSep] input:submit", function(e){
    // $(document).on("click", "form[name=frmCreateSep] input:submit[value=UPDATE]", function(e){
    $(document).on('click', "form[name=frmCreateSep] input:submit[name='updateSep']", function(e){
      e.preventDefault();
      // console.log('SUBMIT_UPDATE'); return false;
      
      // let submitVal  = $(this).val();
      // console.log(submitVal);
      // if(submitVal=='') return false;
      
      let frm = 'form[name=frmCreateSep]';
      let serial = $(frm).serialize();
      console.log(serial);

      let bs = LZString.compressToBase64(JSON.stringify(mRjk_selected));
      console.log(bs);
      $('input[name=wsbpjs]').val(bs);
      //--\LZ
        
        let url  = $(frm).attr('action')+'updateSep';
        console.log(url);

        let js = _ajax_web("POST", url, serial );
        console.log(js);

        if(js.metaData.code==200){
          alert(js.metaData.message);
        }else alert(js.metaData.message);

      return false;
    });
    
    $('#btnSepDelete').click(function(e){
      e.preventDefault();
      let nosep = $('input[name=nosep]').val();
      let r = _ajax_web('GET', baseUrl()+'wsbpjs2/deleteSep/'+nosep);
      console.log(r);

      // if(r.metaData.code!=200){
        alert('('+r.metaData.code+') '+r.metaData.message);
        return false;
      // }
      // return false;
    });
    
    
    let rHisto = [];
    let rHisto_selected= null;
    $('#btnLdHisto').click(function(e){
      e.preventDefault();
      let nokaHisto = $('input[name=nokaHisto]').val();
      let url = baseUrl()+'wsbpjs2/historiPelayanan/'+nokaHisto+'/'+$('input[name=tglAwal_Histo]').val()+'/'+$('input[name=tglAkhir_Histo]').val();
      let r = _ajax_web('GET', url, '');
      console.log(r);

      // ldTblHisto
      rHisto = r.response.newHistori; // HANYA PPK: CITRA MEDIKA // PAKAI INI YA
      // rHisto = r.response.histori;
      console.log(rHisto);
      let tbl = {
        id : 'tblResultHisto',
        headers : [
          ['tglSep','Tgl SEP','style="text-align:center;"'],  
          ['noSep','No.SEP','style="text-align:center;"'],  
          ['poli','Poli','style="text-align:center;"'],  
          ['ppkPelayanan','PPK','style="text-align:left;"'],
          ['noRujukan','No.Rujukan','style="text-align:center;"'],
          // [ ['checkRjk','shortMsg'],'Status Rujukan','style="text-align:center;"', 'sub'],
          // [ ['poliRujukan','nama'],'Spesialis','style="text-align:center;"', 'sub'],
        ],
        data : rHisto,
        button : {
          color : 'success',
          head : 'OPSI',
          label : 'PILIH',
        },
      };
       
      let el_tbl = create_table_return2(tbl, rHisto); 
      $('#tblResultHisto').DataTable().destroy();
      $('#tblMainHisto').children().remove();
      $('#tblMainHisto').append(el_tbl);
      $('#tblResultHisto').DataTable({ "scrollX": true });   
      // $('#modal_mRjk').modal('show');   

    });

    // PILIH 1 OK dari HISTO    
    $(document).on('click','#tblResultHisto tbody tr td .btn_ok', function(e){
      e.preventDefault();
      console.log($(this).data('id'));

      rHisto_selected = rHisto[$(this).data('id')];
      console.log(rHisto_selected);

      $('input[name=noSEPKontrol]').val(rHisto_selected.noSep);
      // $('input[name=tglRencanaKontrol]').val(rHisto_selected.);
      $('input[name=poliKontrolKey]').val(rHisto_selected.poli);
      $('input[name=noRujukanKontrol]').val(rHisto_selected.noRujukan);
    });


    $("input[name=poliKontrolKey]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);

        let url = 'referensi/poli/'+_this;
        let r = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
        console.log(r);
        if(r.metaData.code!=200){ alert(r.metaData.message); return false; }
        else r = r.response;

        if(r==null){ alert("Data tidak ditemukan."); return false; }

        addSelectOptionKlinik('select[name=poliKontrol]', r.poli, 'kode', 'nama');
        $("select[name=poliKontrol]").focus();
      }
    });

    $('select[name=poliKontrol]').on('change', function(e){
      let _this = $(this).val();
      console.log(_this);
      // if(_this == 'MAT') $('.katarak').show();
      // else $('.katarak').hide();

      let ldDokter = loadDokter(_this);
      console.log(ldDokter);

      addSelectOption('select[name=kodeDokterKontrol]', ldDokter.source.refDokterDpjp.list, 'kode', 'nama');
      $("select[name=kodeDokterKontrol]").focus();
      
      // $('input[name=dpjp_bpjs]').focus();
    });


    $(document).on('click', "form[name=frmSuratKontrol] input:submit[value='CREATE SURAT KONTROL']", function(e){
      e.preventDefault();      
      // console.log('SUBMIT_CREATE SEP'); return false;
      
      let frm = 'form[name=frmSuratKontrol]';
      let serial = $(frm).serialize();
      console.log(serial);

        let url  = $(frm).attr('action')+'insertRencanaKontrol';
        console.log(url);
        // return false;

        let js = _ajax_web("POST", url, serial );
        console.log(js);

        if(js.metaData.code==200){
          $('input[name=noSuratKontrolRes]').val(js.response.noSuratKontrol);
          alert(js.metaData.message);
          // reload();
        }else alert(js.metaData.message);       

        return false;
    });
    
    function formAjaxPost(formName=null, action=null, mode=null){
      let frm = 'form[name='+formName+']';
      let serial = $(frm).serialize();
      console.log(serial);
      // return false;

      let url  = $(frm).attr('action')+action;
      // console.log(url);
      // return false;

      let js = _ajax_web("POST", url, serial );
      // console.log(js);

      if(mode==null) return js;
      else if(mode=='alert'){
        if(js.metaData.code==200){
          $('input[name=noSuratKontrolRes]').val(js.response.noSuratKontrol);
          alert(js.metaData.message);
        }else alert(js.metaData.message);       

        // return false;
        return js;
      }
    }


    $(document).on('click', "form[name=frmSuratKontrol] input:submit[name='updateSuratKontrol']", function(e){
      e.preventDefault();
      // console.log('SUBMIT_CREATE SEP'); return false;
      
      let frm = 'form[name=frmSuratKontrol]';
      let serial = $(frm).serialize();
      console.log(serial);

      // return false;

        let url  = $(frm).attr('action')+'updateRencanaKontrol';
        console.log(url);
        // return false;

        let js = _ajax_web("POST", url, serial );
        console.log(js);

        if(js.metaData.code==200){
          $('input[name=noSuratKontrolRes]').val(js.response.noSuratKontrol);
          alert(js.metaData.message);
          // reload();
        }else alert(js.metaData.message);       

        return false;
    });

    $(document).on('click', "form[name=frmSuratKontrol] input:submit[name='hapusSuratKontrol']", function(e){
      e.preventDefault();
      let frmAjaxPost = formAjaxPost('frmSuratKontrol', 'hapusRencanaKontrol', 'alert');
      console.log(frmAjaxPost);
    });

   
    
    $('#btnSepCari').click(function(e){
      e.preventDefault();
      let nosep = $('input[name=nosep]').val();
      let url = 'SEP/'+nosep;
      let r = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
      console.log(r);

      if(r.metaData.code!=200){
        alert('('+r.metaData.code+') '+r.metaData.message);
        return false;
      }

      // SHOW data PESERTA
      px = r.response.peserta;
      $('input[name=nama_bpjs]').val(px.nama);
      $('input[name=tgllahir_bpjs]').val(px.tglLahir);
      $('input[name=kelas_bpjs]').val(px.hakKelas);
      $('input[name=jns_peserta]').val(px.jenisPeserta);
      $('input[name=norm_bpjs]').val(px.noMR);
      // $('input[name=telp_bpjs]').val(px.telp_bpjs);

      $('input[name=noRujukan]').val(r.response.noRujukan);
      $('input[name=dpjpLayan_bpjs]').val(r.response.dpjp.nmDPJP);

      $('input[name=dxkey]').val(r.response.diagnosa);
      $('select[name=dx]').children().remove();
      $('select[name=dx]').append('<option value="">'+r.response.diagnosa+'</option>');
      
      $('input[name=klinikkey]').val(r.response.poli);
      $('select[name=klinik]').children().remove();
      $('select[name=klinik]').append('<option value="">'+r.response.poli+'</option>');

    });


    
    // ==================
    var availableTags = [
      "Perl",
      "PHP",
      "Python",
      "Ruby"
    ];
    $('input#mainSearchBox').autocomplete({
      source: availableTags,
      minLength: 0
    });
    
    $('#mainSearchBox').autocomplete("disable");
    
    $('#mainSearchBox').keyup(function(e) {    
      var code = (e.keyCode ? e.keyCode : e.which);
      switch (code) {
        case 40: //down key
        case 38: //up key
        //add more cases for special buttons
          return;
      }
    
      var value = $('#mainSearchBox').val();
      console.log(value);
      var last = value.substr(value.length - 1);
      console.log(last);
      if (last == "*") {
        var valToSearch = value.substr(0, value.length - 1);
        console.log(valToSearch);
        $('#mainSearchBox').autocomplete("enable");
        $( "#mainSearchBox" ).autocomplete( "option", "source", [ "c++", "coldfusion", "javascript", "asp" ] );
        $('#mainSearchBox').autocomplete("search", valToSearch);
      } else {
        $('#mainSearchBox').autocomplete("disable");
      }
    });
    // ==================
    
	}


  if( open_site('wsbpjs2/uat/pengajuan-sep') ){
    $("input[name=noKartu]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);
        R = _ajax_web('GET', baseUrl()+'wsbpjs2/peserta/'+_this, '');
        console.log(R);
        if(R.metaData.code=='200'){
          // $('input[name=noka]').val(R.response.peserta.noKartu);
          $('input[name=nama]').val(R.response.peserta.nama);
          // $('input[name=tgllahir_bpjs]').val(R.response.peserta.tglLahir);
          // $('input[name=noka]').focus();
        }else alert(R.metaData.message);        
        return false;
      }
    });


    // $('form[name=frmPengajuanSep]').submit(function(e){
    //   e.preventDefault();
    //   // $('input[name=wsbpjs]').val(bs);

    //   let data = $(this).serialize();
    //   let url  = $(this).attr('action');
    //   let submt  = $('input[name=action]').val();
    //   console.log([data, url, submt]);
    //   console.log($(this));
    //   console.log(
    //     $(this).context.activeElement.name,
    //    $(this).context.activeElement.value
    //   );
    // });
    
    
    $(document).on("click", ":submit", function(e){
      e.preventDefault();
      // $('input[name=wsbpjs]').val(bs);

      let data = $('form[name=frmPengajuanSep]').serialize();
      let submiit  = $(this).val();
      let url  = $('form[name=frmPengajuanSep]').attr('action')+submiit;
      console.log([data, url, submiit]);
      
      let js = _ajax_web("POST", url, data );
      console.log(js);

      return false;  

      if(js.metaData.code==200){
        alert(js.metaData.message);
        $('input[name=nosep]').val(js.response.sep.noSep);
        // reload();
      }else{
        // alert('Tidak Berhasil Entry. Ulangi proses.');
        alert(js.metaData.message);
      }

      return false;      
    });
  }

  if( open_site('wsbpjs2/uat/sep/update-tgl-plg') ){
    $('.datepicker').datepicker({
      autoclose : true,
      format    : 'yyyy-mm-dd'
    });

    $("input[name=nosep]").keypress(function (e) { //TEKAN ENTER
      let _this = $(this).val();
      if (e.which == 13) {
        console.log(_this);
        R = _ajax_web('GET', baseUrl()+'wsbpjs2/SEP/'+_this, '');
        console.log(R);
        if(R.metaData.code=='200'){
          $('input[name=tglSepV]').val(R.response.tglSep);
          $('input[name=tglSep]').val(R.response.tglSep);
          $('input[name=nama]').val(R.response.peserta.nama);
          $('input[name=statusKecelakaanV]').val(R.response.kdStatusKecelakaan +' - '+ R.response.nmstatusKecelakaan);
          $('input[name=kdStatusKecelakaan]').val(R.response.kdStatusKecelakaan);
          
        }else alert(R.metaData.message);        
        return false;
      }
    });

    $(document).on('click', "form[name=frmUpdateTglPlg] input:submit[name='updateTglPlg']", function(e){
      e.preventDefault();      
      // console.log('SUBMIT_CREATE SEP'); return false;
      
      let frm = 'form[name=frmUpdateTglPlg]';
      let serial = $(frm).serialize();
      console.log(serial);

      // return false;

        let url  = $(frm).attr('action')+'updateTglPulang';
        console.log(url);
        // return false;

        let js = _ajax_web("POST", url, serial );
        console.log(js);

        if(js.metaData.code==200){
          // $('input[name=noSuratKontrolRes]').val(js.response.noSuratKontrol);
          alert(js.metaData.message);
          // reload();
        }else alert(js.metaData.message);

        return false;
    });
  }

  if( open_site('wsbpjs2/uat/ws-test') ){
    $('#btn_run_ws_bpjs').click(function(e){
      e.preventDefault();
      let url = $('#param').val();
      let js = _ajax_web('GET', baseUrl()+'wsbpjs2/url', {url:url});
      console.log(js);
      
      // js_str = JSON.stringify(js, null, 4);
      js_str = prettyJson(js);
      $('#result').val(js_str);
    });
    
    
    $('ol li').click(function(e){
      e.preventDefault();
      let lbl = $(this).text();
      console.log(lbl);
      $('#param').val(lbl);
    });


    $('#btn_run_ws_bpjs_post').click(function(e){
      e.preventDefault();
      let url = $('#param').val();
      let param = $('#param_post').val();
      // let js = _ajax_bpjs("GET", "peserta_cari_get", {noKartu: get_noka, tglSep:tgl});
      let js = _ajax_web("POST", baseUrl()+"ajax_bpjs11/url/POST/"+url,param);
      // ajax_bpjs11/url/GET/
      console.log(js);
      
      js_str = JSON.stringify(js, null, 4);
      $('#result').val(js_str);
    });
  }


});