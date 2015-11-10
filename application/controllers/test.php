<?php
class test extends CI_Controller {
	function test(){
		parent::__construct(); 
	}

	function index(){
		$this->load->view("tester_view");
	}


	function exectest(){
		$data = $this->input->post();
		$res = $this->execute_service2($data['url'],$data['method'],$data['param']);

		
		if($data['format'] == 'xml') { 
		header('Content-type: text/xml');
		}
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