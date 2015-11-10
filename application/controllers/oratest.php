<?php 
class oratest extends CI_Controller {
	function oratest(){
		parent::__construct();
		$this->load->model("nttmodel","nm");
	}



	function index(){
		$res = $this->db->get("T_USER_BLOKIR");
		foreach($res->result() as $row) : 
		echo "<pre>";	print_r($row); echo "</pre>";
		endforeach;
	}


	function ntt(){
		$res = $this->db->get("SERVICE_AUTH");
		// echo "<pre>";	print_r($data ); echo "</pre>";
		foreach($res->result() as $row) : 
		echo "<pre>";	print_r($row); echo "</pre>";
		endforeach;
	}


	function live(){
		$data = $this->nm->bpkb_detail_mon_live();
		echo "<pre>";
		print_r($data); 
		echo "</pre>";
	}


}
?>