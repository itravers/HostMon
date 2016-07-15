<?php 
//echo getcwd();

include_once("../php/db.php");
include_once("../php/functions.php");

error_reporting(0);


/*
$_POST['install'] = true;
$_POST['type'] = 'user';
$_POST['dbName'] = 'hostmon';
$_POST['dbAddress'] = '127.0.0.1';
$_POST['dbUsername'] = 'HostMonUser2';
$_POST['dbPassword'] = 'Micheal1';
$_POST['adminUsername'] = 'qwer';
$_POST['adminPassword'] = '962012d09b8170d912f0669f6d7d9d07';
*/

/*
$_POST['adminUsername'] = 'root';
$_POST['adminPassword'] = 'testpass';
$_POST['checkAdminDB'] = true;
*/


$_POST['install'] = true;
$_POST['type'] = 'admin';
$_POST['SQLadminUsername'] = 'root';
$_POST['SQLadminPassword'] = 'Micheal1123581';
$_POST['SQLaddress'] = '127.0.0.1';
$_POST['adminDBName'] = 'Hostmon2';
$_POST['adminUsername'] = 'qwer';
$_POST['adminPassword'] = '962012d09b8170d912f0669f6d7d9d07';


if(isset($_POST['checkAdminDB'])){
	$ajaxReturnVal = array();
	$errorNum = install_testAdminDB();
        $errorMsg = getMySQLErrorMessageFromNum($errorNum);

        //echo ":".$errorNum.":";
        if($errorNum == 0 || $errorNum == 1){
                $ajaxReturnVal['success'] = true;
        }else{
                $ajaxReturnVal['success'] = false;
        }

        $ajaxReturnVal['errorType'] = getMySQLErrorTypeFromNum($errorNum);
        $ajaxReturnVal['errorMessage'] = $errorMsg;
	$ajaxReturnVal['errorNum'] = $errorNum;
        $ajaxReturnVal = json_encode($ajaxReturnVal);

        echo $ajaxReturnVal;

}else if(isset($_POST['checkDB'])){
	$ajaxReturnVal = array();
	$errorNum = install_testDB();
	$errorMsg = getMySQLErrorMessageFromNum($errorNum);
	
	//echo ":".$errorNum.":";
	if($errorNum == 0){
		$ajaxReturnVal['success'] = true;
	}else{
		$ajaxReturnVal['success'] = false;
	}

	$ajaxReturnVal['errorType'] = getMySQLErrorTypeFromNum($errorNum);
	$ajaxReturnVal['errorMessage'] = $errorMsg;
	$ajaxReturnVal = json_encode($ajaxReturnVal);

	echo $ajaxReturnVal;
}else if(isset($_POST['install'])){
	/**
	  * Checks if we are doing an admin or user install
	  * If it is a user install we are assuming that a
	  * DB and DB user with appropriate permissions
	  * have already been created. In this case we will:
	  * 1. Save the settings to connect to the db in db.cfg
	  * 2. Setup the initial hostmon admin account in the db.
	  * 3. Configure File Permissions.
	  * 4. Notify the DB that install is complete. Allowing
	  *    the app to be used.
	  * IF type = admin is chosen then we will:
	  * 1. Create a DB with the Given Name
	  * 2. Create a new DB user with all permissions on the DB.
	  * 3. Populate DB tables using new DB user.
	  * 4. Then we must do everything in the usermod 1-4.
	  */	
	$ajaxReturnVal = array();

	//Code executed for admin mode, before user mode.
	if($_POST['type'] == 'admin'){
		//echo "admin Mode";
		$address = $_POST['SQLaddress'];
		$dbName = $_POST['adminDBName'];
		$sqlAdmin = $_POST['SQLadminUsername'];
		$sqlPass = $_POST['SQLadminPassword'];

		$errorNum = install_testAdminDB($address, $sqlAdmin, $sqlPass);
		//echo " testAdminDB: ".$errorNum;

		if($errorNum == 1){//DB is creatable with these creds.
			$errorNum = createNewDB($address, $dbName, $sqlAdmin, $sqlPass);
			//echo " createdNewDB: ".$errorNum;
			$newUsername = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
			$newPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
			$errorNum = createNewSQLUser($address, $dbName, $newUsername, $newPass, $sqlAdmin, $sqlPass);
			echo "error: ".$errorNum;
			
			$errorNum = givePrivilegesToSQLUser($address, $dbName, $newUsername, $newPass, $sqlAdmin, $sqlPass);

			//We don't set ajax return values here, because it will fall through
			//and be set in the user part.
		}else{
			$ajaxReturnVal['success'] = 'false';
			$ajaxReturnVal['errorMessage'] = 'Could not Create New DB.';
		}
	}
/*
	//Code executed for both admin and user mode
	$errorNum = install_testDB();
	$errorMsg = getMySQLErrorMessageFromNum($errorNum);
	if($errorNum == 0){//if there is no problem.
		recordDBSettings();
		if(setupAdminAccount()){
			error_log("admin Account Is SETUP");
			if(configureFilePermissions()){
				setDBInstalled();
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
		$ajaxReturnVal['errorMessage'] = $errorMsg;
	}
*/

	$ajaxReturnVal = json_encode($ajaxReturnVal);
	echo $ajaxReturnVal;


}

/** Tells the db that installation has completed. */
function setDBInstalled(){
	$con = openDB();
	$sql = "UPDATE `configuration` SET `value` = '1' WHERE `configuration`.`name` = 'installed';";
	$result = mysqli_query($con,$sql);
}

/** 
  * setupAdminAccount(): Returns an SQL Result
  * Uses: $_POST['adminUsername'] and $_POST['adminPassword']
  * Checks the DB to see if referenced username already exists
  * if it doesn't it creates a hostmon user with admin level 10
  * using the referenced username and password.
  */
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
        $ajaxReturnVal['errorMessage'] = "Unable to open cfg/db.cfg, problem with permission?";
        $ajaxReturnVal = json_encode($ajaxReturnVal);

	$myfile = fopen("../cfg/db.cfg", "w") or die($ajaxReturnVal);
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
	error_log("configureFilePermissions() 1");
	$currentUser = get_current_user();
	//echo "current user is: ".$currentUser;
	//chown('../install/*', 'asterisk');
	//chgrp('../install/*', 'root');

	/*
	$chmodSuccess;
	$chmodSuccess=chmod("../alarms/", 0777);
	$chmodSuccess=chmod("../css/", 0755);
	$chmodSuccess=chmod("../images/", 0755);
	$chmodSuccess=chmod("../backend/", 0755);
	$chmodSuccess=chmod("../js/", 0755);
	$chmodSuccess=chmod("../php/", 0755);
	$chmodSuccess=chmod("../test/", 0440);
	$chmodSuccess=chmod("../cfg", 0600);
	*/

	error_log("configureFilePermissions() 2");
	chchange("../alarms/", 0770, 'asterisk');
	error_log("configureFilePermissions() 3");
	chchange("../css/", 0540, 'asterisk');
	error_log("configureFilePermissions() 4");
	chchange("../images/", 0540, 'asterisk');
	error_log("configureFilePermissions() 5");
	chchange("../backend/", 0540, 'asterisk');
	error_log("configureFilePermissions() 6");
	chchange("../js/", 0540, 'asterisk');
	error_log("configureFilePermissions() 7");
	chchange("../php/", 0540, 'asterisk');
	error_log("configureFilePermissions() 8");
	chchange("../cfg/", 0500, 'asterisk');
	error_log("configureFilePermissions() 9");

	chmod_r("../install/", 0000);
	//chown_r("../install/", 'asterisk');
	error_log("configureFilePermissions() ending");
	return true;
}

/**
  * void chchange(String $path, OCT $val, String $name);
  * Input: A Path or File Name, and a username, and
  * an octal value representing permissions.
  * This will recursively chmod, chown and chgrp
  * every file and folder under this path.
  */
function chchange($path, $val, $name){
	chmod_r($path, $val);
	chown_r($path, $name);
	chgrp_r($path, $name);
}

/**
  * void chgrp_r(String $path, String $name);
  * Input: A Path or File Name, and a username
  * from the OS to make its group own that file.
  */
function chgrp_r($path, $name){
	$dir = new DirectoryIterator($path);
	foreach($dir as $item){
		chgrp($item->getPathname(), $name);
		if($item->isDir() && !$item->isDot()){
			chgrp_r($item->getPathname(), $name);
		}
	}
}

/**
  * void chown_r(String $path, String $name);
  * Input: A path or file name and a username
  * from the OS to make own that file.
  */
function chown_r($path, $name){
	$dir = new DirectoryIterator($path);
	foreach($dir as $item){
		chown($item->getPathname(), $name);
		if($item->isDir() && !$item->isDot()){
			chown_r($item->getPathname(), $name);
		}
	}
}

/**
  * void chmod_r(String $path, OCT $val);
  * Input: A Path Name, or Filename, and 
  * an octal value representing unix file permissions.
  * chmods a file, or a directory and
  * ALL files under that directory.
  */
function chmod_r($path, $val) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        chmod($item->getPathname(), $val);
        if ($item->isDir() && !$item->isDot()) {
            chmod_r($item->getPathname(), $val);
        }
    }
}

/** Tests if the db is installed and available with the supplied credentials.
  * if it works it returns 0, if it fails it returns the errornumber. */
function install_testDB(){
	//echo "install_testDB(): ".$_POST['dbAddress']." ".$_POST['dbUsername']." ".$_POST['dbPassword']." ".$_POST['dbName'];
/** checks to see if the admin account is already set up, otherwise sets it up. */
	$con = mysqli_connect($_POST['dbAddress'], $_POST['dbUsername'], $_POST['dbPassword'], $_POST['dbName']);
	if (!$con) {
		//echo "failed";
		$returnVal = false;
	}else{
		//echo "didn'tfail";
		$returnVal = true;
	}
	$errorNum = 0;
	if(mysqli_connect_errno()) $errorNum = mysqli_connect_errno();

	//echo "errorNum: ".$errorNum;	
	return $errorNum;
}

function install_testAdminDB($address, $sqlAdmin, $sqlPass){
	$errorNum = 0;
        $con = new mysqli($address, $sqlAdmin, $sqlPass);
	if (!$con) {
                $errorNum = 666;
        }else{
		$result = mysqli_query($con, 'CREATE DATABASE hostmonTest');
		if(!$result){
			//failed to creaate db
			//echo "failed to create db";
			$errorNum = 666;
		}else{
			//echo "created db";
			$errorNum = 1;
			mysqli_query($con, 'DROP DATABASE hostmonTest');
		}
       }

        if(mysqli_connect_errno()) $errorNum = mysqli_connect_errno();

        //echo "errorNum: ".$errorNum;
        return $errorNum;
}

function givePrivilegesToSQLUser($address, $dbName, $user, $pass, $sqlAdmin, $sqlPass){
	 $errorNum = 0;
        $con = new mysqli($address, $sqlAdmin, $sqlPass);
        if(!$con){
                $errorNum = false;
        }else{
              $sql = "GRANT ALL PRIVILEGES ON ".$dbName." TO '".$user."'@'localhost'";
              $result = mysqli_query($con, $sql);
              echo 'result2: '.$sql;
                if(!$result){
                        //failed to creaate db
                        //echo "failed to create db";
                        $errorNum = 666;
                }else{
                        //echo "created db";
                        $errorNum = 1;
                }

        }
        if(mysqli_connect_errno()) $errorNum = mysqli_connect_errno();
        return $errorNum;

}

function createNewSQLUser($address, $dbName, $user, $pass, $sqlAdmin, $sqlPass){
	 echo " creating new sql user: ".$address." ".$user." ".$pass;
        $errorNum = 0;
        $con = new mysqli($address, $sqlAdmin, $sqlPass);
        if(!$con){
                $errorNum = false;
        }else{
		$sql = "CREATE USER '".$user."'@'localhost' IDENTIFIED BY '".$pass."'";
                $result = mysqli_query($con, $sql);
		echo 'result1: '.$result;
//		$sql = "GRANT ALL PRIVILEGES ON ".$dbName." TO '".$user."'@'localhost'";
  //              $result = mysqli_query($con, $sql);
//		echo 'result2: '.$sql;
                if(!$result){
                        //failed to creaate db
                        //echo "failed to create db";
                        $errorNum = 666;
                }else{
                        //echo "created db";
                        $errorNum = 1;
                }

        }
        if(mysqli_connect_errno()) $errorNum = mysqli_connect_errno();
        return $errorNum;

}

function createNewDB($address, $dbName, $sqlAdmin, $sqlPass){
	$errorNum = 0;
	$con = new mysqli($address, $sqlAdmin, $sqlPass);
	if(!$con){
		$errorNum = 666;
	}else{
		$result = mysqli_query($con, 'CREATE DATABASE '.$dbName);
                if(!$result){
                        //failed to creaate db
                        //echo "failed to create db";
                        $errorNum = 666;
                }else{
                        //echo "created db";
                        $errorNum = 1;
                }
	
	}
        if(mysqli_connect_errno()) $errorNum = mysqli_connect_errno();
	return $errorNum;	
}
?>
