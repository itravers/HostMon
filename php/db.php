<?php


			
			
			
function openDB(){
	// Make a MySQL Connection
	$dbOptions = getDBOptions();
	//mysql_connect($dbOptions["IP"], $dbOptions["USER"], $dbOptions["PASS"]) or die(mysql_error());
	//mysql_select_db($dbOptions["DB"]) or die(mysql_error());
	
	$con = mysqli_connect($dbOptions["IP"], $dbOptions["USER"], $dbOptions["PASS"], $dbOptions["DB"]);
		if (!$con) {
		  die('Could not connect: ' . mysqli_error($con));
		}
	mysqli_select_db($con,"HostMon");
	return $con;
}

function queryDB($con, $sql){
	mysqli_select_db($con,"HostMon");
			$result = mysqli_query($con,$sql);
			$row = mysqli_fetch_array($result);
			return $row;
}

function getDBOptions(){
	$dbOptions = array();
	$lines = file('../cfg/db.cfg');
	foreach ($lines as $line_num => $line) {
		if (strpos($line, 'DB:') !== FALSE){
			$end = strpos($line, ';');
			$start = strpos($line, ':')+1;
			$length = $end - $start;
			$dbName = substr($line, $start, $length);
			$dbOptions["DB"] = $dbName;
		}else if (strpos($line, 'USER:') !== FALSE){
			$end = strpos($line, ';');
			$start = strpos($line, ':')+1;
			$length = $end - $start;
			$user = substr($line, $start, $length);
			$dbOptions["USER"] = $user;
		}else if (strpos($line, 'PASS:') !== FALSE){
			$end = strpos($line, ';');
			$start = strpos($line, ':')+1;
			$length = $end - $start;
			$pass = substr($line, $start, $length);
			$dbOptions["PASS"] = $pass;
		}else if (strpos($line, 'IP:') !== FALSE){
			$end = strpos($line, ';');
			$start = strpos($line, ':')+1;
			$length = $end - $start;
			$ip = substr($line, $start, $length);
			$dbOptions["IP"] = $ip;
		}else{
			//any other lines including blanks will be skipped
		}
	}
	return $dbOptions;
}
?>