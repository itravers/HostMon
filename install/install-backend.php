<?php 
include_once("../php/db.php");
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
	$returnVal = false;
	$con = mysqli_connect($_POST['dbAddress'], $_POST['dbUsername'], $_POST['dbPassword'], $_POST['dbName']);
	if (!$con) {
		$returnVal = false;
	}else{
		$returnVal = true;
	}
	return $returnVal;
}
?>