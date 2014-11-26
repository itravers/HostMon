<?php 
include_once("../php/db.php");
if(isset($_POST['install'])){
	$ajaxReturnVal = array();
	if(install_testDB()){
		recordDBSettings();
		if(setupAdminAccount()){
			$ajaxReturnVal['success'] = 'true';
			$ajaxReturnVal['errorMessage'] = 'Install A Success.';
		}else{
			$ajaxReturnVal['success'] = 'false';
			$ajaxReturnVal['errorMessage'] = 'Problem Setting up Admin Account.';
		}
	}else{
		$ajaxReturnVal['success'] = 'false';
		$ajaxReturnVal['errorMessage'] = 'Failed to Connect to db with those settings.';
	}
	$ajaxReturnVal = json_encode($ajaxReturnVal);
	echo $ajaxReturnVal;
}

/** checks to see if the admin account is already set up, otherwise sets it up. */
function setupAdminAccount(){
	$con = openDB();
	$dbOptions = getDBOptions();
	mysqli_select_db($con, $dbOptions["DB"]);
	$sql = "SELECT * FROM `users` WHERE `users`.`admin_level` = '10';";
	$result2 = mysqli_query($con,$sql);
}

/** Will record the db settings into cfg/db.cfg */
function recordDBSettings(){
	
}

/** Tests if the db is installed and available with the supplied credentials. */
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