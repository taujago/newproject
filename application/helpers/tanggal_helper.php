<?php

function ora_date($date){

	$mo = array(1=>"JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

	$tmp = explode("-", $date);

	$tgl = $tmp[0]."-".$mo[intval($tmp[1])]."-".$tmp[2];
	return $tgl;

}

function indo_date($date){

	$mo = array(1=>"JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
	$mo = array_flip($mo);
	$tmp = explode("-", $date);

	$tgl = $tmp[0]."-".$mo[$tmp[1]]."-".$tmp[2];
	return $tgl;

}


function tgl_indo($tgl){
	$tmp = explode("-", $tgl);
	$bln = intval($tmp[1]);

	$arr_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
		"November","Desember");
	$ret = $tmp[0]." ".strtoupper($arr_bln[$bln])." ".$tmp[2];
	return $ret;

}

function  show_array($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function rupiah($x)
 {
 	if($x==0) return "-";
 	else if($x<0) {
 		$x=abs($x);
 		return "(".number_format($x,2,',','.') .")"  ;
 	}
 	else {
 		return number_format($x,2,',','.') ;
 	}
 }


function spasi($kode){
	$s = "";
	for($i=0; $i<strlen($kode); $i++) {
		$s.="&nbsp;";
	}
	return $s."&nbsp;&nbsp;";
}

?>