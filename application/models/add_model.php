<?php 
class add_model extends CI_Model {

 
function __construct(){
	parent::__construct();
}
 




function hari($tgl) {
		// format tanggal haru Y-m-d
		$tgl = str_replace("-", "/", $tgl);
		$tgl = strtotime($tgl);
		$hari = date("l",$tgl);
		$arr_hari = array("Sunday"=>"Minggu",
						   "Monday" => "Senin",
						   "Tuesday" => "Selasa",
						   "Wednesday" => "Rabu",
						   "Thursday"  => "Kamis",
						   "Friday" => "Jum'at",
						   "Saturday" => "Sabtu"	);

		return $arr_hari[$hari];
	}
	
function bulan($bulan) {
	$bulan = intval($bulan);
	$arr_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni",
					   "Juli","Agustus","September","Oktober","November","Desember");
	return $arr_bulan[$bulan];
}


function get_rekening($kode) {
	$this->db->where("kode",$kode);
	$data = $this->db->get("akun")->row();
	return $data->nama;
}


// function has_child($id) {
// 		$this->db->where("pid",$id);
// 		$res = $this->db->get("v_rapbdesa");
// 		if($res->num_rows() == 0 ) return false;
// 		else return true;
// 	}
 
function has_child($tbname,$id){	 
	$tahun = $this->session->userdata("tahun_anggaran");
	$id_desa = $this->session->userdata("id_desa");
	$sql = "SELECT * FROM $tbname WHERE 
				pid= '$id'

					
					and tahun = '$tahun'
					and id_desa = '$id_desa'
					";

	$jumlah = $this->db->query($sql)->num_rows();
	//echo $this->db->last_query() ."<br />";
	if($jumlah > 0 ) return true;
	else return false;
}


function has_child2($tb_name,$id) {
		$this->db->where("pid",$id);
		$res = $this->db->get("$tb_name");
		//echo "has chidl2 ". $this->db->last_query(). "<br />";
		if($res->num_rows() == 0 ) return false;
		else return true;
	}
 

	function jumlah2($tbname,$id) {
		$this->db->where("tahun",$this->session->userdata("tahun_anggaran"));
		$this->db->where("id",$id);
		$data = $this->db->get($tbname)->row();
		//echo $this->db->last_query();
		return $data->jumlah;
	}
 
function subtotal_($id,$tb_name,$kolom,$tahun,$id_desa) {
	// $sql="SELECT SUM($kolom) as $kolom FROM $tb_name WHERE has_child IS NULL 
	// 		AND tahun=$tahun AND id_desa='$id_desa'
	// 		AND  id LIKE '$id%';";
	// $data = $this->db->query($sql)->row();
	// return $data->total;

		//$tahun = $this->session->userdata("tahun_anggaran");
		$total=0;
		$sql="SELECT * FROM $tb_name where tahun = $tahun and id_desa='$id_desa' ";
		echo $sql;  
		//exit;
		// if($tb_name=="v_pembiayaan"){
		// 	echo $sql;
		// }


		$query = mysql_query($sql);
		if(mysql_num_rows($query)==0) {
			return 0;
		}

		while ( $row = mysql_fetch_assoc($query) )
		
		{
		
				$menu_array[$row['id']] = array(
										'kode' => $row['kode'],		
										'nama' => $row['nama'],
										'pid' => $row['pid'],
										'total' => $row['total'] 
										);
		
		}
		//print_r($menu_array);
		//exit;
		// echo "<pre>";
		// printf($menu_array); 
		// echo "</pre>";

		if(!function_exists('generate_menu')) {
		function generate_menu($parent,$menu_array=array(),&$out,$kolom)
			{
			global $total;
			
			//echo "<hr/> array dalam fungsi <pre>" ; print_r($menu_array); echo "</pre>";
				//  global $menu_array;
			//echo "array.. <pre>"; print_r($menu_array); echo "</pre>";
			
					$has_childs = false;
			
					//this prevents printing 'ul' if we don't have subcategories for this category
			
			
			
					//  global $menu_array;
			
			
					//use global array variable instead of a local variable to lower stack memory requierment
			
			
			
					foreach($menu_array as $key => $value)
			
					{
			
							if ($value['pid'] == $parent) 
			
							{       
			
									//if this is the first child print '<ul>'                       
			
									if ($has_childs === false)
			
									{
			
											//don't print '<ul>' multiple times                             
			
											$has_childs = true;
			
										//	echo '<ul>';
			
									}
			
									//echo '<li><a href="/category/' . $value['nama'] . '/">' . $value['nama'] . '</a>';
									//echo number_format($value['jumlah'],0,',','.')."<Br />";
									$out += $value[$kolom];
									//echo number_format($total,0,',','.')."<Br />";
									generate_menu($key,$menu_array,$out,$kolom);
			
									//call function again to generate nested list for subcategories belonging to this category
			
									//echo '</li>';
			
							}
			
					}
			
					//if ($has_childs === true) echo '</ul>';
			
			}
		}
			
			//print_r($menu_array);
			$out=0;
			generate_menu($id,$menu_array,$out,$kolom);
					
			// echo ($tbname=="v_pembiayaan")?"total $out":"";		
						
			return $out;	
}



function subtotal_lap($id,$tb_name,$kolom,$tahun,$id_desa) {
	// $sql="SELECT SUM($kolom) as $kolom FROM $tb_name WHERE has_child IS NULL 
	// 		AND tahun=$tahun AND id_desa='$id_desa'
	// 		AND  id LIKE '$id%';";
	// $data = $this->db->query($sql)->row();
	// return $data->total;

		//$tahun = $this->session->userdata("tahun_anggaran");
		$total=0;
		$query = mysql_query("SELECT * FROM $tb_name where tahun = $tahun and id_desa='$id_desa' ");

		while ( $row = mysql_fetch_assoc($query) )
		
		{
		
				$menu_array[$row['id']] = array(
										'kode' => $row['kode'],		
										'nama' => $row['nama'],
										'pid' => $row['pid'],
										'total' => $row['total'] ,
										't1' => $row['t1'], 
										't2' => $row['t2'] ,
										't3' => $row['t3'] ,
										't4' => $row['t4'],
										'jumlah' => $row['jumlah']  
										);
		
		}
		
		if(!function_exists('generate_menu')) {
		function generate_menu($parent,$menu_array=array(),&$out,$kolom)
			{
			global $total;
			
			//echo "<hr/> array dalam fungsi <pre>" ; print_r($menu_array); echo "</pre>";
				//  global $menu_array;
			//echo "array.. <pre>"; print_r($menu_array); echo "</pre>";
			
					$has_childs = false;
			
					//this prevents printing 'ul' if we don't have subcategories for this category
			
			
			
					//  global $menu_array;
			
			
					//use global array variable instead of a local variable to lower stack memory requierment
			
			
			
					foreach($menu_array as $key => $value)
			
					{
			
							if ($value['pid'] == $parent) 
			
							{       
			
									//if this is the first child print '<ul>'                       
			
									if ($has_childs === false)
			
									{
			
											//don't print '<ul>' multiple times                             
			
											$has_childs = true;
			
										//	echo '<ul>';
			
									}
			
									//echo '<li><a href="/category/' . $value['nama'] . '/">' . $value['nama'] . '</a>';
									//echo number_format($value['jumlah'],0,',','.')."<Br />";
									$out += $value[$kolom];
									//echo number_format($total,0,',','.')."<Br />";
									generate_menu($key,$menu_array,$out,$kolom);
			
									//call function again to generate nested list for subcategories belonging to this category
			
									//echo '</li>';
			
							}
			
					}
			
					//if ($has_childs === true) echo '</ul>';
			
			}
		}
			
			//print_r($menu_array);
			$out=0;
			generate_menu($id,$menu_array,$out,$kolom);
					
					
						
			return $out;	
}


// function subtotal_tw($id,$tb_name,$kolom,$tahun,$id_desa) {
// 	$sql="SELECT SUM($kolom) as $kolom FROM $tb_name WHERE has_child IS NULL 
// 			AND tahun=$tahun AND id_desa='$id_desa'
// 			AND  id LIKE '$id%';";
// 	$data = $this->db->query($sql)->row_array();
// 	return $data[$kolom];
// }

	function total_rapbdesa(){
		$total=0;
		$this->db->where("tahun",$this->session->userdata("tahun_anggaran"));
		$res = $this->db->get("v_rapbdesa");
		foreach($res->result() as $row) :
			if($this->has_child($row->id)==false){
				$total += $row->ubah_jumlah;
			}
		endforeach;
		return $total;
	}
	
	
	function nama_bulan($int){
		$arr= array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return $arr[$int];
	}
	function get_bulan($periode) {
		
		//show_array($periode);
		if($periode['periode']=="t1")  return 3;
		if($periode['periode']=="t2")  return 6;
		if($periode['periode']=="t3")  return 9;
		if($periode['periode']=="t4")  return 12;
		if($periode['periode']=="b") return $periode['bulan'];
	}
	
	
	
	////// jumlah pendapatan 
	
	function get_periode($arr) {
		$ret = array();
		$bulan = (int)$this->get_bulan($arr);
		//echo "bulan = $bulan <br />";
		$ret['bulan'] = $this->nama_bulan($bulan);
		$ret['tanggal'] = cal_days_in_month(CAL_GREGORIAN, $bulan, $this->session->userdata("tahun_anggaran") );
		$ret['periode'] = ($arr['periode'] == 'b')?"Bulan":"Triwulan";
		$ret['bulan_lalu'] =  $this->nama_bulan($bulan-1);
		$ret['tanggal_lalu'] = cal_days_in_month(CAL_GREGORIAN, ($bulan-1), $this->session->userdata("tahun_anggaran") );
		return $ret;
	}
	

	function get_belanja_rincian($id){
		$tahun = $this->tahun;
		$id_desa = $this->id_desa;
		$this->db->select('br.*,ap.nama,ap.singkatan')->from("belanja_rincian br")
		->join("belanja_detail bd", "bd.id_belanja_rincian = br.id_belanja_rincian")
		->join("belanja b","b.id = br.id and b.tahun = br.tahun and b.id_desa = br.id_desa ")
		->join("akun_pendapatan ap","br.id_akun_pendapatan = ap.id",'left');
		$this->db->where("br.id",$id);
		$this->db->where("br.tahun",$tahun);
		$this->db->where("br.id_desa",$id_desa);
		$this->db->group_by("br.id_belanja_rincian");
		$res = $this->db->get();
		return $res;		
	}
	
	function get_total_rincian($id_belanja_rincian) {
		$sql="SELECT SUM(total) total FROM belanja_detail
		WHERE id_belanja_rincian = '$id_belanja_rincian'";
		$res = $this->db->query($sql);
		$data = $res->row();
		return $data->total;
	}


function total_per_tahun($tbname, $id,$tahun,$col) {
	$this->db->where("id",$id);
	$this->db->where("tahun",$tahun);
	$this->db->where("id_desa",$this->id_desa);
	$res = $this->db->get("asset"); 
	if($res->num_rows() == 0 ){
		return 0;
	}
	else { 
		$data = $res->row_array();
		return $data[$col];
	} 
	

}


function jumlah_per_tahun($tbname, $id,$tahun,$col) {
	$this->db->where("id",$id);
	$this->db->where("tahun",$tahun);
	$this->db->where("id_desa",$this->id_desa);
	$res = $this->db->get($tbname); 

	if(!$res){
		//echo $this->db->last_query();
		$n=0;
	}

	 
	if($res->num_rows() == 0 ){
		return 0;
	}
	else { 
		$data = $res->row_array();
		return $data[$col];
	} 
	

}

function subtotal_sd($id,$kolom) {
 

		//$tahun = $this->session->userdata("tahun_anggaran");
		$total=0;
		$sql="SELECT * FROM tmp_realisasi_sd ";
		//echo $sql; 
		//exit;
		$query = mysql_query($sql);
		if(mysql_num_rows($query)==0) {
			return 0;
		}

		while ( $row = mysql_fetch_assoc($query) )
		
		{
		
				$menu_array[$row['id']] = array(
										'kode' => $row['kode'],		
										'nama' => $row['nama'],
										'pid' => $row['pid'],
										'total' => $row['total'],
										'sebelum' => $row['sebelum'] ,
										'sekarang' => $row['sekarang']  
										);
		
		}
		 

		if(!function_exists('generate_menu')) {
		function generate_menu($parent,$menu_array=array(),&$out,$kolom)
			{
			global $total;
			
			//echo "<hr/> array dalam fungsi <pre>" ; print_r($menu_array); echo "</pre>";
				//  global $menu_array;
			//echo "array.. <pre>"; print_r($menu_array); echo "</pre>";
			
					$has_childs = false;
			
					//this prevents printing 'ul' if we don't have subcategories for this category
			
			
			
					//  global $menu_array;
			
			
					//use global array variable instead of a local variable to lower stack memory requierment
			
			
			
					foreach($menu_array as $key => $value)
			
					{
			
							if ($value['pid'] == $parent) 
			
							{       
			
									//if this is the first child print '<ul>'                       
			
									if ($has_childs === false)
			
									{
			
											//don't print '<ul>' multiple times                             
			
											$has_childs = true;
			
										//	echo '<ul>';
			
									}
			
									//echo '<li><a href="/category/' . $value['nama'] . '/">' . $value['nama'] . '</a>';
									//echo number_format($value['jumlah'],0,',','.')."<Br />";
									$out += $value[$kolom];
									//echo number_format($total,0,',','.')."<Br />";
									generate_menu($key,$menu_array,$out,$kolom);
			
									//call function again to generate nested list for subcategories belonging to this category
			
									//echo '</li>';
			
							}
			
					}
			
					//if ($has_childs === true) echo '</ul>';
			
			}
		}
			
			//print_r($menu_array);
			$out=0;
			generate_menu($id,$menu_array,$out,$kolom);
					
					
						
			return $out;	
}


function get_total_by_id($tb_name,$colname,$id,$id_desa,$tahun){
	$this->db->where("tahun",$tahun);
	$this->db->where("id_desa",$id_desa);
	$this->db->where("id",$id);
	$res = $this->db->get($tb_name);
	if($res->num_rows() == 0){
		return 0;
	}
	else {
		$data = $res->row_array();
		return $data[$colname];
	}

}

	
}
?>