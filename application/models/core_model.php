<?php
class core_model extends CI_Model {

var $profil;
	function core_model(){
		parent::__construct();
		// $this->tahun = $this->session->userdata("tahun");
		// $this->tahun = $this->session->userdata("id_desa");
	}
 


function arr_level1(){
	$arr = array();
	     
		$res = $this->db->get("v_akun_level1");
		foreach ($res->result() as $row) {
			# code...
			$arr[$row->id] = $row->nama;
		}
		return $arr;
}

var $arr_pajak = array(
			'ppn'=>array('nama'=>'PPN 10%','nilai'=>10),
			'pph21'=>array('nama'=>'PPH Pasal 21','nilai'=>array(18,15,6,5,3,2.5)),
			'pph22'=>array('nama'=>'PPH Pasal 22','nilai'=>array(3,1.5)),
			'pph23'=>array('nama'=>'PPH Pasal 23','nilai'=>array(2,4)),
			// 'pphsewa'=>array('nama'=>'PPH Sewa 10%','nilai'=>10),
			'pajakdaerah'=>array('nama'=>'Pajak Daerah 10%','nilai'=>10)
							   );


function arr_aparatur() {
	$arr = array();
	$this->db->order_by("jabatan");
	$res = $this->db->get("tim_bos");
	foreach($res->result() as $row ) : 
		$arr[$row->id] = "$row->jabatan  -  $row->nama";
	endforeach;
	return $arr;
}


	function arr_satuan(){
/*		$arr= array(
			"Unit"=>"Unit",
			"Buah"=>"Buah",
			"Bungkus" =>"Bungkus",
			"Meter" => "Meter",
			"Rim" => "Rim",
			"Sak" => "Sak",
			"Bulan" => "Bulan",
			"Hari" => "Hari"
			);
		//sort($arr);
		return $arr;*/
		$this->db->order_by("satuan");
			$res = $this->db->get("satuan");
			$arr = array();
			foreach ($res->result() as $row) {
			 
				$arr[$row->satuan] = $row->satuan;
			}
			return $arr;
	}
	
function arr_tiger_provinsi(){
	$arr=array();
	 
	$this->db->order_by("provinsi");
	$res = $this->db->get("tiger_provinsi");
	foreach($res->result() as $row) :
		$arr[$row->id]  = $row->provinsi;
	endforeach;
	return $arr;
}


function akun_tree($tbname,$id='x') {



$sql ="select * from  $tbname order by kode1, kode2, kode3,kode4,kode5";
 
//echo $sql;
$res  = mysql_query($sql);
$items = array();
$x=0;
while($data = mysql_fetch_object($res)) {
 	$items[$x] = (object) array('id' => $data->id, "pid"=>$data->pid,
 		"text"=>$data->kode." ".$data->nama);
 	$x++;
}

//echo "<pre>"; print_r($items); echo "</pre>";
 
$children = array();

foreach($items as $item)  
    $children[$item->pid][] = $item;
foreach($items as $item) if (isset($children[$item->id]))
    $item->children = $children[$item->id];

//echo "<pre>"; print_r($children); echo "</pre>";
$tree = $children[0];

//print_r($tree);
return $tree;
 

}
 


function akun_tree2($tbname,$id='x') {



$sql ="select * from  $tbname order by kode1, kode2, kode3,kode4,kode5";
 
//echo $sql;
$res  = mysql_query($sql);
$items = array();
$x=0;
while($data = mysql_fetch_object($res)) {
 	$items[$x] = (object) array('id' => $data->id, "pid"=>$data->pid,
 		"text"=>$data->alias.".  ".$data->nama);
 	$x++;
}

//echo "<pre>"; print_r($items); echo "</pre>";
 
$children = array();

foreach($items as $item)  
    $children[$item->pid][] = $item;
foreach($items as $item) if (isset($children[$item->id]))
    $item->children = $children[$item->id];

//echo "<pre>"; print_r($children); echo "</pre>";
$tree = $children[0];

//print_r($tree);
return $tree;
 

}



function romawi($angka){
	$arr = array(1=>"I","II","III","IV","V","VI","VII","VIII","IX","X");
	return $arr[$angka];
}

function arr_bulan(){
	return array(1=>"Januari","Februari","Maret","April","Mei","Juni",
		 	 						  "Juli","Agustus","September","Oktober","November","Desember");

}

function add_arr_head($arr,$index,$str) {
	$res[$index] = $str;
	foreach($arr as $x => $y) : 
	$res[$x] = $y;
	endforeach;
	return $res;
}

function arr_tipe_user(){
	$arr = array("17"=>"Administrator","Terdaftar");
	return $arr;
}

function arr_transaksi(){
	$arr = array(
		"Setoran Tunai"		=>"Setoran Tunai",
		"Penarikan Tunai"	=>"Penarikan Tunai",
		"Pajak" 			=>"Pajak",
		"Biaya-biaya"		=> "Biaya-biaya",
		"Denda"				=> "Denda"
		);
	return $arr;
}

function arr_kode_bank(){
	$arr = array(
		//"x" => " Pilih jenis transaksi ",
		"m" => "Buku Bank Masuk   (BBM)",
		"k" => "Buku Bank Keluar (BBK)  "
		);
	return $arr;
}

function arr_kode_kas(){
	$arr = array(
		//"x" => " Pilih jenis transaksi ",
		"m" => "Buku Kas Masuk (BKM)",
		"k" => "Buku Kas Keluar (BKK)  "
		);
	return $arr;
}


function arr_kelas() {
 
 $this->db->select("*")->from('kategori')
 ->where("id_kategori between 1 and 11",null,false);
$res = $this->db->get();
$arr = array();
foreach ($res->result() as $row) {
 
	$arr[$row->id_kategori] = $row->nama;
}
return $arr;

}
 

 
function arr_jk(){
	$arr= array("Laki-Laki"=>"Laki-Laki","Perempuan"=>"Perempuan");
			 
	 
	return $arr;

}

function arr_golongan() {
	$arr = array(
		"I A" 	=>"I A",
		"I B" 	=>"I B",
		"I C"	=>"I C",
		"I D"	=>"I D",

		"II A" 	=>"II A",
		"II B" 	=>"II B",
		"II C"	=>"II C",
		"II D"	=>"II D",

		"III A" 	=>"III A",
		"III B" 	=>"III B",
		"III C"	=>"III C",
		"III D"	=>"III D",

		"IV A" 	=>"IV A",
		"IV B" 	=>"IV B",
		"IV C"	=>"IV C",
		"IV D"	=>"IV D"
		);
	return $arr;
}

function arr_grup(){
	$arr = array(0=>"Penerimaan",23=>"Pengeluaran");
	return $arr;
}

 

function get_profil(){
	$data = $this->db->get("sekolah")->row();
	$this->profil = $data;

	$this->db->where("id_pengaturan","1");
	$setting = $this->db->get("pengaturan")->row();
	$this->profil->tahun_anggaran = $setting->nilai;
	return $this->profil;
}

 
function periode($periode,$arr) {
	$arr_bulan = $this->arr_bulan();
	$this->get_profil();
  /*  echo "<pre>";
	var_dump($arr_bulan);
	var_dump($periode);
	var_dump($arr);
	echo "</pre>";*/
	//$arr['bulan'] = 1;
	//$arr['bulan'] = empty($arr['bulan'])?$arr['bulan']:"1";
	
	//echo $arr['bulan'];
	$arr = array(	 
		"t1" => "Januari ".$this->profil->tahun_anggaran." - Maret ".$this->profil->tahun_anggaran ." ( Triwulan I) ",
		"t2" => "April ".$this->profil->tahun_anggaran." - Juni ".$this->profil->tahun_anggaran ." ( Triwulan II) ",
		"t3" => "Juli ".$this->profil->tahun_anggaran." - September ".$this->profil->tahun_anggaran ." ( Triwulan III) ",
		"t4" => "Oktober ".$this->profil->tahun_anggaran." - Desember ".$this->profil->tahun_anggaran ." ( Triwulan IV) "
		, 		"b" => "Bulan ".$arr_bulan[$arr['bulan']]. " ".$this->profil->tahun_anggaran 
		);
	/*var_dump($arr_bulan);
	echo "bulan " .$arr_bulan[1]."------<br />";
	echo "periode $periode";*/
	return $arr[$periode];
}

 

function aparatur(){
	$result = new stdClass();
	$sql="SELECT * FROM tim_bos 
	WHERE jabatan = 'Kepala Desa' ";
	$data = $this->db->query($sql)->row();
	$result->kepala_desa_nama = $data->nama;
	$result->kepala_desa_nip = $data->nip;
	$result->kepala_desa_pangkat = $data->pangkat;
	$result->kepala_desa_jabatan = $data->jabatan;
	$result->kepala_desa_alamat = $data->alamat;
	
	$sql="SELECT * FROM tim_bos 
	WHERE jabatan = 'Sekretaris Desa' ";
	$data = $this->db->query($sql)->row();

	$result->sekdes_nama = $data->nama;
	$result->sekdes_nip = $data->nip;
	$result->sekdes_jabatan = $data->jabatan;
	

	$sql="SELECT * FROM tim_bos 
	WHERE jabatan = 'Bendahara' ";
	$data = $this->db->query($sql)->row();
	$result->bendahara = $data->nama;
	$result->bendahara_nip = $data->nip;

	$sql="SELECT * FROM tim_bos 
	WHERE jabatan = 'SEKRETARIS DESA' ";
	$data = $this->db->query($sql)->row();
	$result->sekretaris_nama = $data->nama;
	$result->sekretaris_alamat = $data->nip; 


	return $result;


	//OR jabatan=''"
}


function data_desa(){
	$this->db->select('*')->from("setting_desa sd")->
	join('lokasi l','l.id_desa=sd.id_desa');
	$this->db->where("sd.id_desa",$this->id_desa);

	$res = $this->db->get();
	$this->desa = $res->row();
	return $this->desa;

}

/// terbilang.. 
function terbilang($angka) {
    // pastikan kita hanya berususan dengan tipe data numeric
    $angka = (float)$angka;
     
    // array bilangan
    // sepuluh dan sebelas merupakan special karena awalan 'se'
    $bilangan = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
    );
     
    // pencocokan dimulai dari satuan angka terkecil
    if ($angka < 12) {
        // mapping angka ke index array $bilangan
        return $bilangan[$angka];
    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'tujuh'
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
        return sprintf('seratus %s', $this->terbilang($angka - 100));
    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif terbilang(250)
        return trim(sprintf('seribu %s', $this->terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR
        // @#$%^ WT*
         
        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
    } else {
        return 'Wow...';
    }
}


function update_parent($tbname,$kode){
	$this->db->where("id",$kode);
	$data = $this->db->get("$tbname")->row();
	//echo $this->db->last_query();
	$this->db->where("id",$data->pid);
	$this->db->update($tbname,array("has_child"=>1));
}


// function data_desa(){
// 	 $sql="SELECT * FROM lokasi l
// 	JOIN setting_desa sd ON l.id_desa = sd.id_desa ";
// 	$data = $this->query($sql)->limit(1)->row();
// 	return $data;
// }


function perdes(){
	$tahun = $tahun=$this->session->userdata("tahun_anggaran");
	$this->db->where("tahun",$this->tahun);
	$this->db->where("id_desa",$this->id_desa);
	$data = $this->db->get("perdes")->row();
	return $data;
}

function perdes_perubahan(){
	$tahun = $tahun=$this->session->userdata("tahun_anggaran");
	$this->db->where("tahun",$this->tahun);
	$this->db->where("id_desa",$this->id_desa);
	$data = $this->db->get("perdes_perubahan")->row();
	return $data;
}



function get_pid($str,$n){
	$kode ="";
	//$str  = "1_2_3_4";
	$tmp = explode("_", $str);
	///$jumlah = count($tmp) -1 ; 
	//echo "<br /> jumlah $jumlah <br />";
	for($i=0; $i<=$n; $i++) {
		
		if($i==($n) ) 
		{
				$kode .= $tmp[$i];
		}
		else 
	  
		 $kode .= $tmp[$i]."_";

	}
	return $kode;

}


function get_id_kegiatan($id){
	// $tmp = explode("_", $id);
	// return $tmp[0]."_".$tmp[1]."_".$tmp[2];
	return substr($id, 2);
}





function periode_to_bulan($periode,$bulan) {
	if($periode=="x"){
		return false;
		exit;
	}

	if($periode == "y" ) {
		return null;
	}
	$array = array("t1"=>1,
					"t2"=>4,
					"t3"=>7,
					"t4"=>10,
					"s1"=>1,
					"s2"=>7);
	if($periode=="b") {
		return array("awal"=>"b","akhir"=>$bulan);
	}
	else if($periode=="s1" or $periode=="s2") {
		return array("awal"=>$array[$periode], "akhir"=> $array[$periode] +5 );
	}
	else {
		return array("awal"=>$array[$periode], "akhir"=> $array[$periode] +2 );
	}

}



function nama_periode($periode,$bulan){

	
	$array = array("t1"=>"TRIWULAN I (Satu) ",
					"t2"=>"TRIWULAN II (Dua) ",
					"t3"=>"TRIWULAN III (Tiga) ",
					"t4"=>"TRIWULAN IV (Empat) ",
					"s1"=>"SEMESTER PERTAMA  ",
					"s2"=>"SEMESTER AKHIR",
					"y"=>""

					);
	if($periode=="b") { 
		$x= $this->arr_bulan();
		return strtoupper("BULAN ".$x[$bulan]);
	}
	else {
		return $array[$periode];
	}
}



function nama_periode_bulan($periode,$bulan){
	$array = array("t1"=>"JANUARI - MARET",
					"t2"=>"APRIL - JUNI",
					"t3"=>"JULI - SEPTEMBER",
					"t4"=>"OKTOBER - DESEMBER ");
	if($periode=="b") { 
		$x= $this->arr_bulan();
		return strtoupper("BULAN ".$x[$bulan]);
	}
	else {
		return $array[$periode];
	}
}

 

function tanggal_periode($periode,$bulan){

	if($periode=="y") {
		return "31 DESEMBER ".$this->session->userdata("tahun_anggaran");
	}

	$tahun  = $this->tahun;
	$id_desa  = $this->id_desa;
	
	$y = $this->periode_to_bulan($periode,$bulan);
	//print_r($y);
	extract($y);



	$xx = $this->arr_bulan();


	$d = new DateTime("$tahun-$akhir-1"); 
	$tanggal =  $d->format( 't' );

	$bulan = $xx[$akhir];


	$arr = $this->arr_bulan();

	// $sql="SELECT MAX(tanggal_bayar) tanggal FROM t_buku_kas 
	// 	WHERE MONTH(tanggal) BETWEEN $awal AND $akhir AND YEAR(tanggal) = $tahun";

	$this->db->select('MAX(tanggal) tanggal')->from('buku_kas');
	($awal=="b")?$this->db->where("month(tanggal) <= $akhir",null,false) 
		: $this->db->where("MONTH(tanggal) <= $akhir",null,false)
	->where("YEAR(tanggal) = $tahun",null,false);
	$this->db->where("id_desa",$id_desa);
		
	$res = $this->db->get();
	// echo $this->db->last_query();
	// exit;
	//echo $this->db->last_query(); 
	$xx = $res->row();	
	$tgl = explode("-", $xx->tanggal);

	if(count($tgl)<> 3) {
		return false;
	} 
	else { 
	return $tgl[2]." ". strtoupper($arr[intval($tgl[1])]) . " ".$tgl[0]  ;
	}

}

function tanggal_periode_sebelum($periode,$bulan) {

	$tahun  = $this->session->userdata("tahun_anggaran");

	if($periode == "t1" or ($periode=="b" and $bulan == 1) ) {
		return "31 desember ". $tahun -1;
	}
	else {

		$arr=array("t2"=>"t1",
				   "t3"=>"t2",
				   "t4"=>"t3");
		if($periode=="b"){
			$sebelum="b";
		}
		else { 
		$sebelum = $arr[$periode];
		}
		return $this->tanggal_periode($sebelum,$bulan);
	}
}


function get_belanja_detail($id){
	$this->db->where("tahun",$this->tahun);
	$this->db->where("id_desa",$this->id_desa);
	$this->db->where("id",$id);
	$res = $this->db->get("perubahan_belanja");
	$data = $res->row();
	return $data;
}

function get_verifikatur(){
	$this->db->order_by("no_urut");
	$this->db->where("id_desa",$this->id_desa);
	$res = $this->db->get("verifikatur");
	return $res;
}


}

 


?>