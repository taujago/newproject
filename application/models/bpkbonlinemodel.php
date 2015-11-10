<?php 
class bpkbonlinemodel extends ORA_Model{

	function bpkbonlinemodel(){
		parent::__construct();
	}

	

	function query(){

		$sql="DELETE FROM TEST";
		$res = $this->db->query($sql);

		$sql="select bpkb_add_operator(
		'1',
		'17',
		'xxxxx',
		'xxxxx',
		'xxxx',
		'brigadir',
		'administrator',
		'1q2w3e4r'
		) as msg from dual";
		$res = $this->db->query($sql);
		echo " query ".$this->db->last_query();

		if($res){
			echo "berashiL";
			$datax = $res->row();
			echo "pesan " . $datax->MSG . "<br />";
		}
		else {
			echo "gagal";
		}
	}


function bpkb_add_operator($data){
		//$data = $this->data;

	$sql="select bpkb_add_operator(
		'$data->v_polda_id',
		'$data->v_polres_id',
		'$data->v_petugas_id',
		'$data->v_nama',
		'$data->v_nrp',
		'$data->v_pangkat',
		'$data->v_role_id',
		'$data->v_password'
		) as msg from dual";
	// echo "test..";

		$result = $this->call_function($sql);
		// show_array($result); 
		// exit;
		if($result['MSG'] <> 'error') { 
		$tmp = explode("#",$result['MSG']);
			if($tmp[0]=="00"){
				$ret = array("result"=>"true","message"=>$tmp[1],"message_err"=>"");
			}
			else {
				$ret = array("result"=>"false","message"=>"","message_err"=>$tmp[1]);
			}
		 }
		 else{

		 	$ret = array("result"=>"false","message"=>"","message_err"=>"Error DB");
		 }

		 return $ret;

	}
 




function bpkb_login($data){
		//$data = $this->data;

	$sql="select bpkb_login(
		'$data->v_user_name',
		'$data->v_password',
		'$data->v_id_alat'
		
		) as msg from dual";
// echo $sql; exit;
	// echo "test..";

		$result = $this->call_function($sql);
		// show_array($result); 
		// exit;
		if($result['MSG'] <> 'error') { 
		$tmp = explode("#",$result['MSG']);
			if($tmp[0]=="1"){
				$ret = array("result"=>"true","message"=>$tmp[1],"message_err"=>"");
			}
			else {
				$ret = array("result"=>"false","message"=>"","message_err"=>$tmp[1]);
			}
		 }
		 else{

		 	$ret = array("result"=>"false","message"=>"","message_err"=>"Error DB");
		 }

		 return $ret;

	}
 

function bpkb_edit_operator($data){
		//$data = $this->data;

	$sql="select bpkb_edit_operator(
		'$data->v_polda_id',
		'$data->v_polres_id',
		'$data->v_petugas_id',
		'$data->v_nama',
		'$data->v_nrp',
		'$data->v_pangkat',
		'$data->v_role_id',
		'$data->v_password'
		) as msg from dual";
	// echo "test..";

		$result = $this->call_function($sql);
		// show_array($result); 
		// exit;
		if($result['MSG'] <> 'error') { 
		$tmp = explode("#",$result['MSG']);
			if($tmp[0]=="00"){
				$ret = array("result"=>"true","message"=>$tmp[1],"message_err"=>"");
			}
			else {
				$ret = array("result"=>"false","message"=>"","message_err"=>$tmp[1]);
			}
		 }
		 else{

		 	$ret = array("result"=>"false","message"=>"","message_err"=>"Error DB");
		 }

		 return $ret;

	}


function bpkb_detail_operator($param){

	if($param->v_administrator == "0") {
		$this->db->where("OP_ID",$param->v_op_id);
	}
	$res = $this->db->get("T_OPERATOR");

	if($res->num_rows() == 0){
		$return = array("result"=>"false",
			  			"message"=>"","message_err"=>"DATA TIDAK DITEMUKAN");
	}
	else {
		// echo "jumlah baris " . $res->num_rows();
		$return = array("result"=>"true");
		foreach($res->result_array() as $row) : 
			$return['message'][] = $row;
		endforeach;
	}
	// show_array($return);
	return $return;

}


function bpkb_add_alat($param) {

	$arr_data['ID_ALAT']  = $param->v_id_alat;
	$arr_data['NAMA_ALAT']  = $param->v_nama_alat;
	$arr_data['LOKASI'] = $param->v_lokasi;
	$arr_data['BLOCKED']  = $param->v_bloked;
	$arr_data['POLDA_ID']  = $param->v_polda_id;
	$arr_data['POLRES_ID']   = $param->v_polres_id;

	$this->db->where("ID_ALAT",$param->v_id_alat);
	$jumlah  = $this->db->get("T_ALAT")->num_rows();
	if($jumlah==0) { // input baru 

		$res = $this->db->insert("T_ALAT",$arr_data);
		if($res){
			$result = array("result"=>"true","message"=>"DATA ALAT BERHASIL DISIMPAN");
		}
		else {
			$result = array("result"=>"false","message"=>"", "message_err"=>"DATA ALAT GAGAL DISIMPAN");
		}
	}
	else { 
	$result = array("result"=>"false","message"=>"", "message_err"=>"DATA ALAT SUDAH ADA");
	}
	return $result;
}




function bpkb_edit_alat($param) {

	$arr_data['ID_ALAT']  = $param->v_id_alat;
	$arr_data['NAMA_ALAT']  = $param->v_nama_alat;
	$arr_data['LOKASI'] = $param->v_lokasi;
	$arr_data['BLOCKED']  = $param->v_bloked;
	$arr_data['POLDA_ID']  = $param->v_polda_id;
	$arr_data['POLRES_ID']   = $param->v_polres_id;

	$this->db->where("ID_ALAT",$param->v_id_alat);
	$jumlah  = $this->db->get("T_ALAT")->num_rows();
	if($jumlah==1) { // input baru 

		$this->db->where("ID_ALAT",$param->v_id_alat);
		$res = $this->db->update("T_ALAT",$arr_data);
		if($res){
			$result = array("result"=>"true","message"=>"DATA ALAT BERHASIL DIUPDATE");
		}
		else {
			$result = array("result"=>"false","message"=>"", "message_err"=>"DATA ALAT GAGAL DIUPDATE");
		}
	}
	else { 
	$result = array("result"=>"false","message"=>"", "message_err"=>"DATA ALAT TIDAK DITEMUKAN");
	}
	return $result;
}



function bpkb_detail_alat($param){

	/*
	v_polda_id
v_polres_id
	*/
	$this->db->where("POLDA_ID",$param->v_polda_id);
	$this->db->where("POLRES_ID",$param->v_polres_id);
	
	$res = $this->db->get("T_ALAT");

	if($res->num_rows() == 0){
		$return = array("result"=>"false",
			  			"message"=>"","message_err"=>"DATA TIDAK DITEMUKAN");
	}
	else {
		// echo "jumlah baris " . $res->num_rows();
		$return = array("result"=>"true");
		foreach($res->result_array() as $row) : 
			$return['message'][] = $row;
		endforeach;
	}
	// show_array($return);
	return $return;

}

function bpkb_role_menu($param){
	$return = array();
	$this->db->select('KODE,KET')->from("M_GROUP_HAK_AKSES");
	$this->db->where("POLDA_ID",$param->v_polda_id);
	$this->db->where("POLRES_ID",$param->v_polres_id);
	$rs_role = $this->db->get();
	// echo $this->db->last_query();
	foreach($rs_role->result_array() as $row) : 
		$return['data_role'][] =  $row;
	endforeach;

	$this->db->select('KODE_SUB_GROUP,NAMA_SUB_GROUP,
	IS_PILIH,NAMA_GROUP,KODE_GROUP')
	->from("M_MENU_APLIKASI_BPKB");
	$this->db->order_by("KODE_GROUP,KODE_SUB_GROUP");
	$rs_menu = $this->db->get();
	foreach($rs_menu->result_array() as $row) : 
		$return['data_menu'][] =  $row;
	endforeach;

	return $return;

}

function add_m_group_hak_akses($param) {
	//kode,ket,polda_id,polres_id
	$arr['KODE'] = $param->kode;
	$arr['KET'] = $param->ket;
	$arr['POLDA_ID'] = $param->polda_id;
	$arr['POLRES_ID'] = $param->polres_id;

	$res = $this->db->insert("M_GROUP_HAK_AKSES",$arr);
	// echo $this->db->last_query();
	if($res){
		$return  = array("result"=>"true","message"=>"HAK AKSES BERHASIL DISIMPAN","message_err"=>"");
	}
	else {
		$return  = array("result"=>"false","message"=>"","message_err"=>"GAGAL SIMAPAN DATABASE ERROR");
	}
	return $return;

}


}
?>