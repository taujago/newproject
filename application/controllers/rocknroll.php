<?php
class rocknroll extends CI_Controller {
function rocknroll(){
		//header("Content-type: text/xml");
		parent::__construct();
		$this->load->helper("tanggal");

		$this->load->library("xml");
		$this->load->model("bpkbonlinemodel","bm");
		$this->load->model("oramodel");

		$data = json_decode($this->input->post('data'));
		$this->data = $data;
		//show_array($data);

		$login = $this->auth($data);
		if($login['Result']=="false"){
			$ret = array("Result"=>"false","msg"=>"Authentikasi Gagal");
			
		//$xml = Array2XML::createXML("Login",$ret);
		$xml = $this->xml->createXML("SignIn",$ret);
		header('Content-type: text/xml');
		echo $xml->saveXML();

			//echo json_encode($ret);
			exit;
		}


	}

var $data;

	function auth($data){
			// rahasia.123321
	//$data = json_decode($this->input->post('data'));

	//echo "<pre>"; print_r($data); echo "</pre>";


	$this->db->where("USER_ID",$data->LoginInfo->LoginName);
	$data_login = $this->db->get("SERVICE_AUTH")->row();
	// show_array($data_login);

	if(count($data_login) == 0){
		$ret = array("Result"=>"false","msg"=>"User tidak dikenal");
	}
	else {
		if( md5($data_login->USER_ID. "_". $data->LoginInfo->Salt . $data_login->USER_PASSWORD ) == $data->LoginInfo->AuthHash  ) {
			$ret = array("Result"=>"true");
		}
		else {
			$ret = array("Result"=>"false","msg"=>"Password salah");
		}
	}

	return $ret;

	//show_array($ret);

 	
	}

	function bpkb_loginx(){
		$data =  $this->data->Param;
	
		$sql="SELECT * FROM T_OPERATOR WHERE OP_LOGIN = '$data->v_user_name' AND OP_AUTHHASH = (SELECT bpkb_histupie('$data->v_user_name','$data->v_password') FROM DUAL)";
	 	
	 	$rsUser = $this->db->query($sql);
	 	// echo $this->db->last_query(); 
	 	if($rsUser->num_rows() == 0 ) {
	 		$return = array("result"=>"false","message"=>"","message_err"=>"USER TIDAK DITEMUKAN");
	 		// echo "gagal";
	 	}
	 	else { // login sukses
	 		// echo "berhasil";
	 		$data_user = $rsUser->row();

	 		// show_array($data_user); 

	 		$this->db->where("ID_ALAT",$data->v_id_alat);
	 		$rsDevice = $this->db->get("T_ALAT");
	 		 // echo $this->db->last_query(); 
	 		if($rsDevice->num_rows() == 0){
	 			$return = array("result"=>"false","message"=>"","message_err"=>"ALAT TIDAK DITEMUKAN");
	 		}
	 		else { // alat sudah teregister
	 			$this->db->select('KODE,KODE_GROUP,KODE_SUB_GROUP,KET')
	 			->from('M_GROUP_SUB_MENU_APLIKASI');
	 			$this->db->where("KODE",$data_user->LEVEL_AKSES);
	 			$rsAkses = $this->db->get();

	 			$data_device = $rsDevice->row();


	 			$this->db->select('AWALAN_TNKB,SERI_BPKB,KODE_WIL_BPKB,AKHIRAN_NOREG,
	 				TEMPAT_KELUAR_BPKB,BPKB_DIKELUARKAN_OLEH,PNBPR2,PNBPR4')
	 			->from('T_CONFIG')
	 			->where('POLDA_ID',$data_device->POLDA_ID)
	 			->where("POLRES_ID",$data_device->POLRES_ID);
	 			$rsConfig = $this->db->get();
	 			$data_config = $rsConfig->row();


	 			$this->db->select(' SIGN_TYPE,SIGN_JAB,SIGN_NAMA,SIGN_PANGKATNRP')
	 			->from('T_SIGNATURE')
	 			->where("ISAKTIF",1)
	 			->where('POLDA_ID',$data_device->POLDA_ID)
	 			->where("POLRES_ID",$data_device->POLRES_ID);
	 			$rsSignature = $this->db->get();

	 			$data_auth['ID_USER'] 		= $data_user->OP_ID;// $rsUser->_array[0]['OP_ID'];
                $data_auth['NAMA_USER']    	= $data_user->OP_NAMA;//$rsUser->_array[0]['OP_NAMA'];
                $data_auth['LOKASI']    		= $data_device->LOKASI; //$rsDevice->_array[0]['LOKASI'];
                $data_auth['TGL_LOGIN']    	= date('d-m-Y H:i:s');
                $data_auth['LEVEL_AKSES'] 	= $data_user->LEVEL_AKSES;// $rsUser->_array[0]['LEVEL_AKSES'];
                $data_auth['BLOCKED'] 		= $data_user->BLOCKED;//$rsUser->_array[0]['BLOCKED'];
                $data_auth['JABATAN'] 		= $data_user->OP_PANGKAT;// $rsUser->_array[0]['OP_PANGKAT'];
                $data_auth['NRP'] 		 	= $data_user->OP_NRP; //$rsUser->_array[0]['OP_NRP'];
                $data_auth['POLDA_ID']    	= $data_device->POLDA_ID; // $rsDevice->_array[0]['POLDA_ID'];
                $data_auth['POLRES_ID']    	= $data_device->POLRES_ID; //$rsDevice->_array[0]['POLRES_ID'];
                $data_auth['AWAL_TNKB']    	= $data_config->AWALAN_TNKB; // $rsConfig->_array[0]['AWALAN_TNKB'];
                $data_auth['SERI_BPKB']   	=  $data_config->SERI_BPKB; // $rsConfig->_array[0]['SERI_BPKB'];
                $data_auth['KODE_WIL_BPKB']    = $data_config->KODE_WIL_BPKB; // $rsConfig->_array[0]['KODE_WIL_BPKB'];
                $data_auth['AKHIRAN_NOREG']    = $data_config->AKHIRAN_NOREG; // $rsConfig->_array[0]['AKHIRAN_NOREG']; 
                $data_auth['TEMPAT_KELUAR_BPKB']    = $data_config->TEMPAT_KELUAR_BPKB; // $rsConfig->_array[0]['TEMPAT_KELUAR_BPKB']; 
                $data_auth['BPKB_DIKELUARKAN_OLEH']    = $data_config->BPKB_DIKELUARKAN_OLEH; // $rsConfig->_array[0]['BPKB_DIKELUARKAN_OLEH']; 
                $data_auth['PNBPR2']    = $data_config->PNBPR2; // $rsConfig->_array[0]['PNBPR2'];
                $data_auth['PNBPR4']    = $data_config->PNBPR4; // $rsConfig->_array[0]['PNBPR4'];
                
                $result['result'] = 'true';
                $result['data'] = $data_auth;

                foreach($rsAkses->result() as $y) : 
                                $result['GROUP_MENU']['menu'][] = (array) $y;
                endforeach;



                foreach($rsSignature->result() as $a => $b) : 
                                $result['SIGN_DATA']['sign'][] = (array) $b;
                endforeach;

                // $sql="select k,ket from m_group_hak_akses where polda_id=:polda and polres_id=:polres order by kode";
                
                $this->db->select('KODE,KET')
                ->from("M_GROUP_HAK_AKSES")
                ->where("POLDA_ID",$data_device->POLDA_ID)
                ->where("POLRES_ID",$data_device->POLRES_ID);
                $this->db->order_by("KODE");
                $rs = $this->db->get();
                // echo $this->db->last_query();
                foreach($rs->result_array() as $role) : 
                	$result['bpkb_role']['role'] = $role;
                endforeach;

// select kode_sub_group,nama_sub_group,is_pilih,nama_group,kode_group from m_menu_aplikasi_bpkb order by kode_group,kode_sub_group;

                 $this->db->select('KODE_SUB_GROUP,NAMA_SUB_GROUP,IS_PILIH,NAMA_GROUP,KODE_GROUP')
                ->from("M_MENU_APLIKASI_BPKB");
                // ->where("POLDA_ID",$data_device->POLDA_ID)
                // ->where("POLRES_ID",$data_device->POLRES_ID);
                $this->db->order_by("KODE_GROUP,KODE_SUB_GROUP");
                $rs = $this->db->get();
                // echo $this->db->last_query();
                foreach($rs->result_array() as $role) : 
                	$result['menu']['data_menu'] = $role;
                endforeach;
//


                // show_array($result);

				$xml = $this->xml->createXML("SignIn",$result);
				header('Content-type: text/xml');
				echo $xml->saveXML();

				// echo "cocok mas";
	 		}
	 	}
	}

// function bpkb_add_operatorx(){
// 	$result = $this->bm->query();
// 	// $result = $this->bm->bpkb_add_operator($this->data);
// 	$xml = $this->xml->createXML("bpkb_add_operator",$result);
// 	header('Content-type: text/xml');
// 	echo $xml->saveXML();


// }


function bpkb_login(){
	$result = $this->bm->bpkb_login($this->data->Param);
	$xml = $this->xml->createXML("bpkb_login",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();
}

function bpkb_add_operator(){
	
	$result = $this->bm->bpkb_add_operator($this->data->Param);
	$xml = $this->xml->createXML("bpkb_add_operator",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();


}


function bpkb_edit_operator(){
	
	$result = $this->bm->bpkb_edit_operator($this->data->Param);
	$xml = $this->xml->createXML("bpkb_edit_operator",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();


}



function bpkb_detail_operator(){
	
	$result = $this->bm->bpkb_detail_operator($this->data->Param);
	$xml = $this->xml->createXML("bpkb_detail_operator",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();


}


function bpkb_add_alat(){
	
	$result = $this->bm->bpkb_add_alat($this->data->Param);
	$xml = $this->xml->createXML("bpkb_add_alat",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();

}

function bpkb_edit_alat(){
	
	$result = $this->bm->bpkb_edit_alat($this->data->Param);
	$xml = $this->xml->createXML("bpkb_edit_alat",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();

}



function bpkb_detail_alat(){
	
	$result = $this->bm->bpkb_detail_alat($this->data->Param);
	$xml = $this->xml->createXML("bpkb_detail_alat",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();

}


function bpkb_role_menu(){
	$result = $this->bm->bpkb_role_menu($this->data->Param);
	$xml = $this->xml->createXML("bpkb_role_menu",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();
}

function add_m_group_hak_akses(){
	$result = $this->bm->add_m_group_hak_akses($this->data->Param);
	$xml = $this->xml->createXML("add_m_group_hak_akses",$result);
	header('Content-type: text/xml');
	echo $xml->saveXML();
}

}


?>