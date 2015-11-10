<?php
class master_controller extends CI_Controller {

var $pilihan; 
	function master_controller() {
		parent::__construct();  

		if($this->session->userdata('login') == false ) {
			redirect('login/');
		} 
		
	 
		// sleep(1);
		$this->tahun = $this->session->userdata("tahun");
		$this->id_desa = $this->session->userdata("id_desa");

		
	}

	function set_content($str) {
		$this->content['content'] = $str;
	}
	
	function set_title($str) {
		$this->content['title'] = $str;
	}
	
	function set_subtitle($str) {
		$this->content['subtitle'] = $str;
	}
	
	function render(){
		$arr = array();		 
		$this->load->view("template",$this->content );
		
	}


	function render_baru(){
		$arr = array();		 
		$this->load->view("template_baru",$this->content );
		
	}
//$this->format(array("arr_kolom"=>$arr_kolom,"bold"=>true,"baris"=>$i,"align"=>"center"));
 

function get_arr_leasing(){
		// get data leasing
		$ret = array();
		$data['method']='get_data_leasing';
		$url = service_url($data);
		
		$xml = file_get_contents($url);
		$arr = xml_to_array($xml);
		foreach($arr['message']['leasing'] as $row ) : 
			$ret[$row['leasing_id']] = $row['leasing_nama'];
		endforeach;
		//show_array($ret);
		return $ret;
	}

function get_arr_level(){
	$arr=array(1=>"Level 1","Level 2","Level 3");
	return $arr;
}


function get_detail($vTB_NAME,$vKEY,$vVALUE) { 
		$service_data['method'] = 'get_detail';
		$service_data['debug'] = 1;
		$service_data['vTB_NAME'] = $vTB_NAME;
		$service_data['vKEY'] = $vKEY;
		$service_data['vVALUE'] = $vVALUE;
		$url = service_url($service_data);
		 
		$xml = file_get_contents($url);
		$arr = xml_to_array($xml);
		return $arr;
}


function add_arr_head($arr,$index,$value) {

	$ret[$index] = $value;

	foreach($arr as $x => $y):
		$ret[$x] = $y;
	endforeach;

	return $ret;

}

function arr_dropdown($vTable, $vINDEX, $vVALUE, $vORDERBY){
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
                $ret = array();
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

 }


// function arr_dropdown($vTable, $vINDEX, $vVALUE, $vORDERBY){
// 		$ret = array();
// 		$service['method']='arr_dropdown';
// 		$service['debug']='1';
// 		$service['vTable']=$vTable;
// 		$service['vINDEX']=$vINDEX;
// 		$service['vVALUE']=$vVALUE;
// 		$service['vORDERBY']=$vORDERBY;
// 		$url = service_url($service);
// 		$xml = file_get_contents($url);
// 		$arr = xml_to_array($xml);
// 		foreach($arr['message']['leasing'] as $data) : 
// 		//show_array($data);
// 			if(!is_array($data[$vVALUE])) { 
// 			$ret[$data[$vINDEX]] = $data[$vVALUE];
// 			}
// 		endforeach;
// 		return $ret;
		 
// 	}


function execute_service($url,$method,$json_data) {
	$req_url = $url."/".$method;
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $req_url);
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	//execute post
	$result = curl_exec($ch);

	$obj  = json_decode($result);
	$array = (array) $obj;

	curl_close($ch);
	return $array;
}


function validasi($daft_id) {

			$userdata = $this->session->userdata("userdata");



			$this->db->where("daft_id",$daft_id);
			$data_daft = $this->db->get("t_pendaftaran")->row();	 
			 
			$no_rangka =  $data_daft->no_rangka;

			$this->db->where("id_polda",$data_daft->id_polda);
			$data_polda = $this->db->get("m_polda")->row();

			// $this->db->where("id_polda",$this->session->userdata("id_polda"));
			// $this->db->where("leasing_id",$userdata['leasing_id']);
			// $aut_data = $this->db->get("polda_leasing")->row();

			$aut_data = $this->get_auth_data();

			$data_service = array("LoginInfo"=>array(
							"LoginName" => $aut_data->service_user,
							"Salt"		=> $aut_data->service_salt,
							"AuthHash" 	=> md5($aut_data->service_salt . md5($aut_data->service_user.$aut_data->service_pass))
							),
							"NoRangkaList"=>
							array(0=>$no_rangka)
							);
			$json_data = json_encode($data_service);
			// echo "<pre>";
			// echo $json_data;
			// echo "</pre>";
			// exit;

			$ret_service = $this->execute_service($data_polda->url,"RanRuGetBlokirEntryByNoKa",$json_data);
			//show_array($ret_service);
			return $ret_service;

}


function error_msg($kode_error) {
    $arr = array(1=>"RECORD SUDAH ADA",
        "BPKB SUDAH DIBLOKIR",
        "BPKB DENGAN NOMOR RANGKA TERSEBUT SUDAH DITERBITKAN");
    return $arr[$kode_error];
}

function error_msg_lama($kode_error) {
    $arr = array(1=>"BPKB TIDAK DITEMUKAN",
        "SUDAH DIVERIFIKASI",
        "SUDAH DIBLOKIR");
    return $arr[$kode_error];
}

function tanggal($str){

	return  substr($str,0, 4)."-".substr($str,4, 2)."-".substr($str,6, 2);

}

function tanggal2_tahun($str){

	return  (substr($str,0, 4) + 2)."-".substr($str,4, 2)."-".substr($str,6, 2);

}




function get_auth_data() {
	$userdata = $this->session->userdata("userdata");
	$leasing_id = $userdata['leasing_id'];
	$id_polda = $this->session->userdata("id_polda");

	$this->db->where("id_polda",$id_polda);
	$this->db->where("leasing_id",$leasing_id);
	$data = $this->db->get("polda_leasing")->row();
	return $data;
}


function arr_permohonan(){
	$ret = array("x"=>"- SEMUA JENIS - ",
		"B"=>"BARU",
		"L"=>"LAMA");
	return $ret;
}


}

?>
