<?php 
include_once("../php/db.php");
$_POST['install'] = 'true';
if(isset($_POST['install'])){
	$ajaxReturnVal = array();
	if(install_testDB()){
		$ajaxReturnVal['success'] = 'true';
	}else{
		$ajaxReturnVal['success'] = 'false';
	}
	$ajaxReturnVal = json_encode($ajaxReturnVal);
	echo $ajaxReturnVal;
}

function install_testDB(){
	return true;
}
?>