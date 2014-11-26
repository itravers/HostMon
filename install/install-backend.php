<?php 
include_once("../php/db.php");
if(isset($_POST['install'])){
	$ajaxReturnVal = array();
	if(install_testDB()){
		recordDBSettings();
		if(setupAdminAccount()){
			if(configureFilePermissions()){
				$ajaxReturnVal['success'] = 'true';
				$ajaxReturnVal['errorMessage'] = 'Install A Success.';
			}else{
				$ajaxReturnVal['success'] = 'false';
				$ajaxReturnVal['errorMessage'] = 'Problem configuring file permissions.';
			}
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
	$result = false;
	$accountExists = false;
	$con = openDB();
	$dbOptions = getDBOptions();
	$adminUsername = mysqli_real_escape_string($con, $_POST['adminUsername']); // Discourage some hackers.
	mysqli_select_db($con, $dbOptions["DB"]);
	$sql = "SELECT * FROM `users` WHERE `users`.`admin_level` = '10' AND `users`.`usr` = '".$adminUsername."';";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)) {
		array_push($array_result, $row);
	}
	if(empty($array_result)){
		$result = false;
	}else{
		$result = true;
	}
	
	if(!$accountExists){
		// create account here
		$adminUsername = mysqli_real_escape_string($con, $_POST['adminUsername']); // Discourage some hackers.
		$adminPassword = mysqli_real_escape_string($con, $_POST['adminPassword']); // Discourage some hackers.
		$sql = "INSERT INTO `hostmon`.`users` (`usr`, `admin_level`, `pass`) VALUES ('".$adminUsername."', '10', '".$adminPassword."');";
		$result = mysqli_query($con,$sql);
	}else{
		$result = false;
	}
	return $result;
}

/** Will record the db settings into cfg/db.cfg */
function recordDBSettings(){
	$myfile = fopen("../cfg/db.cfg", "w") or die("Unable to open file!");
	$txt = "DB:".$_POST['dbName'].";\n";
	fwrite($myfile, $txt);
	
	$txt = "USER:".$_POST['dbUsername'].";\n";
	fwrite($myfile, $txt);
	
	$txt = "PASS:".$_POST['dbPassword'].";\n";
	fwrite($myfile, $txt);
	
	$txt = "IP:".$_POST['dbAddress'].";\n";
	fwrite($myfile, $txt);
	
	fclose($myfile);
}

/** Configurs the file permissions for the app, making sure web users can't access
 *  secure files. Web users shouldn't be able to read cfg file or install files.
 */
function configureFilePermissions(){
	$currentUser = get_current_user();
	$chmodSuccess;
	$chmodSuccess=chmod("../css/", 0755);
	$chmodSuccess=chmod("../images/", 0755);
	$chmodSuccess=chmod("../backend/", 0755);
	$chmodSuccess=chmod("../js/", 0755);
	$chmodSuccess=chmod("../php/", 0755);
	$chmodSuccess=chmod("../test/", 0440);
	$chmodSuccess=chmod("../cfg", 0400);
	$chmodSuccess=chmod("../install/", 0440); //shouldn't be available over the web anymore
	return true;
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