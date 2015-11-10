<?php
class tester extends CI_Controller {

	function tester(){
		parent::__construct();
	}

	var $url = "http://localhost/bpkbonline/index.php/rocknroll";

	//ss
	// var $url = "http://180.250.16.227/bpkbonline/index.php/rocknroll";
	// http://180.250.16.227/bpkbonline/index.php/

var $user = "3PILAR";
var $pass = "rahasia.123321";
var $salt = "1234556678";
	function bpkb_login(){
		 
		
		/*
	v_user_name
v_password
v_id_alat
		*/
		// $data =  array(
		// 		"LoginInfo" => array ( 
		// 				"LoginName" => $this->user,
		// 				"Salt" =>  $this->salt,
		// 				"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
		// 		),
		// 		"username"=> "upie",
		// 		"password"=>  "upie",
		// 		"imei" => 	"PMJ001"	
		// 		);

		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param"=>array(
						"v_user_name"=> "upie",
						"v_password"=>  "upie",
						"v_id_alat" => 	"PMJ001")	
				);

		$data_json = json_encode($data);
		// echo $data_json; exit;
		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_login",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}


	function bpkb_add_operator(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_polda_id"=>"1",
						"v_polres_id"=>"17",
						"v_petugas_id"=>"alex",
						"v_nama"=>"66666",
						"v_nrp"=>"yyyyx",
						"v_pangkat"=>"yyxxx",
						"v_role_id"=>"ADMINISTRATOR",
						"v_password"=>"123"
				));
/*
 "v_polda_id":<string>,
						    "v_polres_id":<string>,
						    "v_petugas_id":<string>,
						    "v_nama":<string>,
						    "v_nrp":<string>,
						    "v_pangkat":<string>,
						    "v_role_id":<string>,
						    "v_password":<string>
*/
		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_add_operator",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}


function bpkb_edit_operator(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_polda_id"=>"1",
						"v_polres_id"=>"17",
						"v_petugas_id"=>"sssssss",
						"v_nama"=>"66666",
						"v_nrp"=>"yyyyx",
						"v_pangkat"=>"yyxxx",
						"v_role_id"=>"ADMINISTRATOR",
						"v_password"=>"123"
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_edit_operator",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}


function bpkb_detail_operator(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_administrator"=>"0",
						"v_op_id"=>"193"
						
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_detail_operator",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}



function bpkb_add_alat(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_polda_id" =>  "1",
						"v_polres_id" =>  "17",
						"v_id_alat" =>  "APPL1",
						"v_nama_alat" =>  "LAPTOP APPLE",
						"v_lokasi" =>  "POLDA JABAR",
						"v_bloked" =>  0
						
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_add_alat",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}



function bpkb_edit_alat(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_polda_id" =>  "17",
						"v_polres_id" =>  "1",
						"v_id_alat" =>  "APPL1",
						"v_nama_alat" =>  "LAPTOP APPLE",
						"v_lokasi" =>  "POLDA JABAR",
						"v_bloked" =>  0
						
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_edit_alat",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}



function bpkb_detail_alat(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"v_polda_id" =>  "17",
						"v_polres_id" =>  "1"
						
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"bpkb_detail_alat",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}

function add_m_group_hak_akses(){
		$data =  array(
				"LoginInfo" => array ( 
						"LoginName" => $this->user,
						"Salt" =>  $this->salt,
						"AuthHash" =>  md5( $this->user . "_".$this->salt. md5($this->pass) )   // algo   md5(user+md5(pass)) 
				),
				"Param" => array(
						"kode" =>  "REVIEWERX",
						"ket" =>  "ADMIN REVIEWER",
						"polda_id" =>  "17",
						"polres_id" =>  "1"
						
				));

		$data_json = json_encode($data);

		// echo "sebelum dikirim " . $data_json;
		$res = $this->execute_service2($this->url,"add_m_group_hak_akses",$data_json);

		// echo "<hr />"; 
		header('Content-type: text/xml');
		echo $res;

		 
	}

	




function execute_service2($url,$method,$json_data) {


	// echo $json_data; exit;

	// echo $json_data; exit;
	$req_url = $url."/".$method;
 	$ch = curl_init();

 	//print_r($json_data); exit;
	//set the url, number of POST vars, POST data


 	$post_data = array("data"=>$json_data);
	curl_setopt($ch,CURLOPT_URL, $req_url);
	//curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	// curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking
	//execute post
	$result = curl_exec($ch);


// $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT ); // request headers

// echo $headerSent; exit;

	// $obj  = json_decode($result);
	// $array = (array) $obj;
	// 
	curl_close($ch);
	// return $array;
	return $result;
}


}
?>