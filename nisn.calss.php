<?php
if ( !function_exists( 'get_nisndata' ) ){
	function get_nisndata($nisn){
		$nisn_val = urlencode($nisn); //encode NISN ke format URL
		$str = "?nisn=".$nisn_val; //string $_GET yang akan dikirim

		// inisialisasi CURL
		$data = curl_init();
		// setting CURL
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, NISN_URL.$str);
		// menjalankan CURL untuk membaca isi file
		$hasil = curl_exec($data);
		curl_close($data);

		$split0 = extract_unit($hasil,'Info Siswa','Info Sekolah'); //mengambil teks diantara kata Info Siswa dan Info Sekolah
		$split0 = strip_tags($split0); //hilangkan tag HTML dari hasil pengambilan tadi

		$nama = extract_unit($split0,'Nama',' Jenis Kelamin'); //ambil nama
		$nisn = extract_unit($split0,'NISN',' Nama'); //ambil NISN
		$jenis_kelamin = extract_unit($split0,'Jenis Kelamin',' Tingkat'); //ambil jenis kelamin siswa
		$tingkat = extract_unit($split0,'Tingkat',' &nbsp;'); //ambil tingkat

		$split1 = extract_unit($hasil,'Info Sekolah','Tentang Data Siswa'); //ambil teks diantara kata Info Sekolah dan Tentang Data Siswa
		$split1 = strip_tags($split1); //hilangkan tag HTML

		$npsn = extract_unit($split1,'NPSN',' Nama');
		$nama_sekolah = extract_unit($split1,'Nama',' Jenjang');
		$jenjang = extract_unit($split1,'Jenjang',' Status');
		$status = extract_unit($split1,'Status',' ');
		 //bangun array hasil
		$hasil = array('nama' => $nama,
					'nisn' => $nisn,
					'jenis_kelamin' => $jenis_kelamin,
					'tingkat' => $tingkat,
					'npsn' => $npsn,
					'nama_sekolah' => $nama_sekolah,
					'jenjang' => $jenjang,
					'status' => $status
				);
		return $hasil;

	}
}

if ( !function_exists( 'extract_unit' ) ){
	function extract_unit($string, $start, $end)	{
		$pos = stripos($string, $start);
		$str = substr($string, $pos);
		$str_two = substr($str, strlen($start));
		$second_pos = stripos($str_two, $end);
		$str_three = substr($str_two, 0, $second_pos);
		$unit = trim($str_three); // remove whitespaces
		return $unit;
	}
}