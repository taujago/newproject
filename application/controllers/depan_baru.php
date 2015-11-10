<?php
class depan_baru extends master_controller  {
	function depan_baru(){
		parent::__construct();
		// echo "pilihan ".$this->session->userdata("pilihan"); exit;
	}
	
	
	function index(){
		$this->set_subtitle("DASHBOARD");
		$this->set_title("DASHBOARD");
		$this->set_content("WELCOME");
		$this->render_baru();
	}

	function get_account_by_pid() {
			$str = "";
			$tbname = $_POST['tbname'];
			$id_field = "id";
			$pid = $_POST['pid'];
			$this->db->where("pid",$pid);
			$this->db->order_by("kode1,kode2,kode3,kode4,kode5");
			$res = $this->db->get($tbname);
			//echo $this->db->last_query();
 			$str .="<option value=x>-Pilih Rekening -</option>\n";
			foreach($res->result_array() as $row) : 
				$str .="<option value=$row[$id_field]>". $row['kode']. " ". $row['nama']."</option> \n";
			endforeach;
			echo $str;
		}
}
?>