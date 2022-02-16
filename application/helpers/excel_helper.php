<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function exe_xls($query=null, $set=null, $filename=null) {
	$CI =& get_instance();

	$header = [];
	$column = [];
	$width = [];
	for($i=0; $i<count($set); $i++){
		array_push($header, $set[$i]["header"]);
		array_push($column, $set[$i]["column"]);
		array_push($width, $set[$i]["width"]);
	}

	// TAMBAHAN BARU:2020.08.10. Setelah ganti nama library dari excel_generator ke my_excel
	$CI->load->library('my_excel'); 
	
	$CI->my_excel->set_query($query);
	$CI->my_excel->set_header($header);
	$CI->my_excel->set_column($column);
	$CI->my_excel->set_width($width);
	$CI->my_excel->exportTo2007($filename);
}


function setting_excel_table($filename=null,  $data=null) { //filename = controller name => on ajaxreq
	switch ($filename) {
		case 'download_xls_laporan_px_ri':

			$set = [
				[
						"header" => "Nobill",
						"column" => "nobill",
						"width"  => 16,
				],[
						"header" => "NORM",
						"column" => "norm",
						"width"  => 10,
				],[
						"header" => "Nama Pasien",
						"column" => "Nama",
						"width"  => 25,
				],[
						"header" => "SEP",
						"column" => "sep",
						"width"  => 20,
				],[
						"header" => "Tarif RS",
						"column" => "tarif_rs_now",
						"width"  => 12,
				],[
						"header" => "Tarif INA",
						"column" => "tarif_ina_terpilih",
						"width"  => 12,
				],[
						"header" => "SELISIH INA-RS",
						"column" => "selisih_ina_rs",
						"width"  => 12,
				],[
						"header" => "Status Tarif",
						"column" => "status_tarif",
						"width"  => 12,
				],[
						"header" => "FlagBill",
						"column" => "FlagBillKet",
						"width"  => 8,
				],[
						"header" => "Status Bill",
						"column" => "status_bill",
						"width"  => 10,
				],[
						"header" => "Bed",
						"column" => "Kodebed",
						"width"  => 6,
				],[
						"header" => "Lantai",
						"column" => "KodeLantai",
						"width"  => 6,
				],[
						"header" => "Ruang",
						"column" => "nama_ruang",
						"width"  => 12,
				],[
						"header" => "DPJP",
						"column" => "dpjp",
						"width"  => 8,
				],[
						"header" => "Status Kelas",
						"column" => "st_kelas",
						"width"  => 12,
				],[
						"header" => "Kelas",
						"column" => "kelas",
						"width"  => 6,
				],[
						"header" => "upgrade_class_los",
						"column" => "upgrade_class_los",
						"width"  => 16,
				],[
						"header" => "hakkelas",
						"column" => "hakkelas",
						"width"  => 8,
				],[
						"header" => "icu_ind",
						"column" => "icu_ind",
						"width"  => 8,
				],[
						"header" => "icu_los",
						"column" => "icu_los",
						"width"  => 8,
				],[
						"header" => "ventil_hour",
						"column" => "ventil_hour",
						"width"  => 8,
				],[
						"header" => "carapulang",
						"column" => "carapulang",
						"width"  => 8,
				],
			];
			break;


		case 'LAPORAN_DOKTER_PENDAPATAN':
			$set = [
				[
						"header" => "Tanggal",
						"column" => "Tgl",
						"width"  => 14,
				],[
						"header" => "Nobill",
						"column" => "NoBill",
						"width"  => 17,
				],[
						"header" => "NoBukti",
						"column" => "NoBukti",
						"width"  => 17,
				],[
						"header" => "Kode Dokter",
						"column" => "Kode",
						"width"  => 10,
				],[
						"header" => "Nama Dokter",
						"column" => "Dokter",
						"width"  => 25,
				],[
						"header" => "Tindakan",
						"column" => "Tindakan",
						"width"  => 25,
				],[
						"header" => "Bruto",
						"column" => "bruto",
						"width"  => 10,
				],[
						"header" => "PPH",
						"column" => "pph",
						"width"  => 7,
				],[
						"header" => "Netto",
						"column" => "netto",
						"width"  => 10,
				],[
						"header" => "Nama Pasien",
						"column" => "NamaPasien",
						"width"  => 25,
				],[
						"header" => "Penanggung",
						"column" => "Penanggung",
						"width"  => 20,
				],[
						"header" => "Kelas",
						"column" => "Kelas",
						"width"  => 20,
				],
			];
			break;

		case 'LAPORAN_DOKTER_BHP':
			$set = [
				[
						"header" => "Tanggal",
						"column" => "Date",
						"width"  => 14,
				],[
						"header" => "Nobill",
						"column" => "NoBill",
						"width"  => 17,
				],[
						"header" => "NoBukti",
						"column" => "NoReff",
						"width"  => 17,
				],[
						"header" => "Kode Dokter",
						"column" => "pelaksana",
						"width"  => 10,
				],[
						"header" => "Nama Dokter",
						"column" => "pelaksanaket",
						"width"  => 25,
				],[
						"header" => "Kode Tindakan",
						"column" => "KodeTindakan",
						"width"  => 10,
				],[
						"header" => "Ket Tindakan",
						"column" => "kettindakan",
						"width"  => 25,
				],[
						"header" => "Total Tarif",
						"column" => "TotalTarif",
						"width"  => 15,
				],[
						"header" => "Nama Pasien",
						"column" => "Nama",
						"width"  => 25,
				],[
						"header" => "Penanggung",
						"column" => "Penanggung",
						"width"  => 20,
				],[
						"header" => "Ruang",
						"column" => "Ruang",
						"width"  => 20,
				],
			];
			break;

		case 'laporan_statistik_rs':
			$set = [
				[
						"header" => "Nama Kelas",
						"column" => "kls_mor",
						"width"  => 24,
				],[
						"header" => "TT",
						"column" => "TT",
						"width"  => 7,
				],[
						"header" => "HP",
						"column" => "HP",
						"width"  => 7,
				],[
						"header" => "LD",
						"column" => "LD",
						"width"  => 7,
				],[
						"header" => "KHM",
						"column" => "KHM",
						"width"  => 7,
				],[
						"header" => "dead<48",
						"column" => "dead<48",
						"width"  => 10,
				],[
						"header" => "dead>=48",
						"column" => "dead>=48",
						"width"  => 10,
				],[
						"header" => "dead",
						"column" => "dead",
						"width"  => 10,
				],[
						"header" => "hidup",
						"column" => "hidup",
						"width"  => 7,
				],[
						"header" => "BOR",
						"column" => "BOR",
						"width"  => 7,
				],[
						"header" => "LOS",
						"column" => "LOS",
						"width"  => 7,
				],[
						"header" => "TOI",
						"column" => "TOI",
						"width"  => 7,
				],[
						"header" => "BTO",
						"column" => "BTO",
						"width"  => 7,
				],[
						"header" => "GDR",
						"column" => "GDR",
						"width"  => 7,
				],[
						"header" => "NDR",
						"column" => "NDR",
						"width"  => 7,
				],
			];
			break;


		case 'laporan_sukubangsa_kosong':
			$set = [
				[
						"header" => "Status Daftar",
						"column" => "StatusDaftar",
						"width"  => 15,
				],[
						"header" => "NoBill",
						"column" => "NoBill",
						"width"  => 20,
				],[
						"header" => "NoRM",
						"column" => "NoRM",
						"width"  => 10,
				],[
						"header" => "Nama",
						"column" => "Nama",
						"width"  => 20,
				],[
						"header" => "TanggalMasuk",
						"column" => "TanggalMasuk",
						"width"  => 15,
				],[
						"header" => "TanggalKeluar",
						"column" => "TanggalKeluar",
						"width"  => 15,
				],[
						"header" => "User",
						"column" => "User",
						"width"  => 10,
				],[
						"header" => "Date",
						"column" => "Date",
						"width"  => 15,
				],
			];
			break;
				
		
			
		case 'laporan_rekap_irs':
			
			$set = [
				[
						"header" => "NO",
						"column" => "NO",
						"width"  => 5,
				],[
						"header" => "DIVISI",
						"column" => "DIVISI",
						"width"  => 20,
				],[
						"header" => "IRS",
						"column" => "IRS",
						"width"  => 10,
				],[
						"header" => "INDIKATOR",
						"column" => "INDIKATOR",
						"width"  => 25,
				],[
						"header" => "TOTAL",
						"column" => "TOTAL",
						"width"  => 8,
				]
				// ,[
				// 		"header" => 1,
				// 		"column" => 1,
				// 		"width"  => 7,
				// ],[
				// 		"header" => 2,
				// 		"column" => 2,
				// 		"width"  => 7,
				// ]
			];

			// $max = 22; // iki ndak error
			$max = count($set) + $data;
			for ($i=1; $i <= $data; $i++) { 
				$set_loop = [
					"header" => $i,
					"column" => $i,
					"width"  => 7,
				];
				array_push($set, $set_loop);
			}

			

			break;

		case 'laporan_tarif_rj':
			$set = [
				[
						"header" => "NoBill",
						"column" => "NoBill",
						"width"  => 20,
				],[
						"header" => "nosep",
						"column" => "nosep",
						"width"  => 25,
				],[
						"header" => "NoRM",
						"column" => "NoRM",
						"width"  => 10,
				],[
						"header" => "Nama",
						"column" => "Nama",
						"width"  => 20,
				],[
						"header" => "totalINA",
						"column" => "totalINA",
						"width"  => 15,
				],[
						"header" => "status",
						"column" => "status",
						"width"  => 10,
				],[
						"header" => "Penanggung",
						"column" => "NoAnggota",
						"width"  => 15,
				],[
						"header" => "Status Daftar",
						"column" => "StatusDaftar",
						"width"  => 15,
				],[
						"header" => "Status Billing",
						"column" => "FlagBill",
						"width"  => 15,
				],
			];
			break;


			//karena memakai double case bersamaan, maka harus setting RJ dan RI.
			// kalau RJ saja, RI akan error. Begitu sebaliknya.
		case 'lap_ricx_selisih_trf_rs_ina_grp_sp_det':
		case 'lap_selisih_trf_rs_ina_grp_sp_det':
			$set = [
				[
						"header" => "KODE DOKTER",
						"column" => "Dokter",
						"width"  => 8,
				],[
						"header" => "NAMA DOKTER",
						"column" => "namadokter",
						"width"  => 25,
				],[
						"header" => "NOBILL",
						"column" => "nobill",
						"width"  => 16,
				],[
						"header" => "NOSEP",
						"column" => "nosep",
						"width"  => 23,
				],[
						"header" => "NORM",
						"column" => "norm",
						"width"  => 8,
				],[
						"header" => "NAMA PASIEN",
						"column" => "nama",
						"width"  => 15,
				],[
						"header" => "PENANGGUNG",
						"column" => "NoAnggota",
						"width"  => 8,
				],[
						"header" => "TGL MASUK",
						"column" => "tanggalmasuk",
						"width"  => 12,
				],[
						"header" => "TGL KELUAR",
						"column" => "tanggalkeluar",
						"width"  => 12,
				],[
						"header" => "STATUS DAFTAR",
						"column" => "StatusDaftar",
						"width"  => 8,
				],[
					"header" => "TOTAL INA",
					"column" => "total_ina",
					"width"  => 12,
				],[
					"header" => "TOTAL INA VERIF",
					"column" => "total_ina_verif",
					"width"  => 18,
				],[
					"header" => "TOTAL RS",
					"column" => "total_rs",
					"width"  => 12,
				],[
					"header" => "SELISIH (INA VRF-RS)",
					"column" => "selisihInaRs",
					"width"  => 20,
				// ], // aslinya STOP sini


				],
				[ "header" => "igd",
					"column" => "igd",
					"width"  => 8,
				],
				[ "header" => "fis",
					"column" => "fis",
					"width"  => 8,
				],
				[ "header" => "lab",
					"column" => "lab",
					"width"  => 8,
				],
				[ "header" => "rad",
					"column" => "rad",
					"width"  => 8,
				],
				[ "header" => "OK",
					"column" => "OK",
					"width"  => 8,
				],
				[ "header" => "ICU",
					"column" => "ICU",
					"width"  => 8,
				],
				[ "header" => "apt",
					"column" => "apt",
					"width"  => 8,
				],
				[ "header" => "chargebed",
					"column" => "chargebed",
					"width"  => 8,
				],
				[ "header" => "ml",
					"column" => "ml",
					"width"  => 8,
				],
			];

			// $val = [
			// 	"filename" => "lap_selisih_trf_sp",
			// 	"set" 		 => $set,
			// ];
			// return $val;
			break;

			
		case 'lap_insiden':
			$set = [
				[
					"header" => "JENIS",
					"column" => "jns",
					"width"  => 8,
				],[
					"header" => "NOBILL",
					"column" => "nobill",
					"width"  => 16,
				],[
						"header" => "TGL. MASUK",
						"column" => "TanggalMasuk",
						"width"  => 12,
				],[
						"header" => "NORM",
						"column" => "NoRM",
						"width"  => 8,
				],[
						"header" => "NAMA",
						"column" => "Nama",
						"width"  => 25,
				],[
						"header" => "JENIS ASUHAN",
						"column" => "jnsAsuh",
						"width"  => 5,
				],[
						"header" => "WAKTU INSIDEN",
						"column" => "datetime",
						"width"  => 20,
				],[
						"header" => "GRADE",
						"column" => "grade",
						"width"  => 7,
				],[
						"header" => "BIRU",
						"column" => "B",
						"width"  => 5,
				],[
						"header" => "HIJAU",
						"column" => "H",
						"width"  => 5,
				],[
						"header" => "KUNING",
						"column" => "K",
						"width"  => 5,
				],[
						"header" => "MERAH",
						"column" => "M",
						"width"  => 5,
				],[
						"header" => "JENIS INSIDEN",
						"column" => "jnsInsiden",
						"width"  => 8,
				],[
						"header" => "ASURANSI",
						"column" => "asuransi",
						"width"  => 8,
				],[
						"header" => "INSIDEN",
						"column" => "insiden",
						"width"  => 25,
				],[
						"header" => "KRONOLOGIS INSIDEN",
						"column" => "kronologis",
						"width"  => 25,
				],[
						"header" => "PEMBERI LAPORAN",
						"column" => "pelapor",
						"width"  => 14,
				],[
						"header" => "LOKASI KEJADIAN",
						"column" => "lokasiKejadian",
						"width"  => 18,
				],[
						"header" => "LOKASI INSIDEN",
						"column" => "lokasiInsidenKet",
						"width"  => 18,
				],[
						"header" => "UNIT PENYEBAB",
						"column" => "unitPenyebab",
						"width"  => 15,
				],[
						"header" => "DAMPAK",
						"column" => "dampak",
						"width"  => 12,
				],[
						"header" => "TINDAKAN STLH KEJADIAN",
						"column" => "tdknStlhKejadian",
						"width"  => 15,
				],[
						"header" => "ANALISA RCA",
						"column" => "analisaRCA",
						"width"  => 20,
				],
			];
			break;


		case 'dl_xls_lap_kunjungan_rj_tiap_klinik':
			$set = [
				[
					"header" => "KLINIK",
					"column" => "lokasiket",
					"width"  => 28,
				],[
					"header" => "JUMLAH",
					"column" => "jml_px_all",
					"width"  => 8,
				],
			];
			break;
			
			
		case 'jadwal_pegawai_by_th_bln':
			$set = [
				[
					"header" => "NIP",
					"column" => "NIP",
					"width"  => 8,
				],[
					"header" => "NAMA",
					"column" => "NAMA",
					"width"  => 25,
				],[
					"header" => "BAGIAN",
					"column" => "BAGIAN",
					"width"  => 8,
				],[
					"header" => "DINAS",
					"column" => "DINAS",
					"width"  => 12,
				],[
					"header" => "TANGGAL",
					"column" => "TANGGAL",
					"width"  => 8,
				],[
					"header" => "date",
					"column" => "date",
					"width"  => 16,
				],
			];
			break;

		
		case 'detail_rekap_obat_range_date':
			$set = [
				[
						"header" => "NO BILLING",
						"column" => "nobilling",
						"width"  => 16,
				],[
						"header" => "SEP",
						"column" => "nosep",
						"width"  => 26,
				],[
						"header" => "NOBUKTI",
						"column" => "nobukti",
						"width"  => 20,
				],[
						"header" => "NAMA",
						"column" => "nama",
						"width"  => 20,
				],[
						"header" => "GTOT",
						"column" => "SUM_GTOT",
						"width"  => 12,
				],[
						"header" => "VERIF",
						"column" => "verif",
						"width"  => 12,
				],[
						"header" => "SELISIH(BPJS-RS)",
						"column" => "SELISIH",
						"width"  => 12,
				],
			];
			break;
		
		
		case 'lap_eklaim':
			$set = [
				[
						"header" => "NO BILLING",
						"column" => "NoBill",
						"width"  => 16,
				],[
						"header" => "SEP",
						"column" => "nosep",
						"width"  => 26,
				],[
						"header" => "STATUS DAFTAR",
						"column" => "StatusDaftar",
						"width"  => 10,
				],[
						"header" => "NORM",
						"column" => "NoRM",
						"width"  => 15,
				],[
						"header" => "NAMA",
						"column" => "Nama",
						"width"  => 20,
				],[
						"header" => "TGL MRS",
						"column" => "tglMRS",
						"width"  => 12,
				],[
						"header" => "ANAMNESA",
						"column" => "Anamnesa",
						"width"  => 18,
				],[
						"header" => "FISIK",
						"column" => "fisik",
						"width"  => 18,
				],[
						"header" => "TERAPI",
						"column" => "Terapi",
						"width"  => 18,
				],[
						"header" => "KODE PENANGGUNG",
						"column" => "PerusahaanPenanggung",
						"width"  => 10,
				],
			];
			break;
		case 'list_rehab_by_rangedate':			
			$set = [
				[
						"header" => "NORM",
						"column" => "norm",
						"width"  => 8,
				],[
						"header" => "NOKA",
						"column" => "noka",
						"width"  => 16,
				],[
						"header" => "ID SIKLUS",
						"column" => "idasesmen",
						"width"  => 8,
				],[
						"header" => "URUT",
						"column" => "urut",
						"width"  => 8,
				],[
						"header" => "NO BILLING",
						"column" => "nobill",
						"width"  => 16,
				],[
						"header" => "SEP",
						"column" => "nosep",
						"width"  => 24,
				],[
						"header" => "NAMA",
						"column" => "Nama",
						"width"  => 20,
				],[
						"header" => "TGL MASUK",
						"column" => "TanggalMasuk",
						"width"  => 12,
				],
			];

			$li = [ "tglPelayanan",	"anamnesa", "fisik", "penunjang",
			"dxPrimer", "dxSekunder", "tatalaksanaKFR", "anjuran", 
			"dokter", "dokterPerujuk", "namadokter", "namadokterperujuk", "tglRujukan", "frekuensi", 
			"siklus", "goal", "goalTgl", "goalHasil", "ket", "tindakLanjut", "user", ];

			for ($i=0; $i < count($li); $i++) { 
				$set[] = [
						"header" => $li[$i],
						"column" => $li[$i],
						"width"  => 20,
				];
			}
			break;

		
		
		default:
			# code...
			break;
	}
			
	return $set;
}
	

?>