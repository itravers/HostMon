<?php 
/**************************************************************
* Hostmon - menu-backend.php
* Author - Isaac Assegai
* This script is used by the menu ajax calls
* to query the database and return all configuration data.
* It is also used to set individual pieces of configuration
* data via the config set buttons on the front end.
**************************************************************/
include_once("db.php");
include_once("functions.php");
session_start(); //We'll end up needing to check for admin status.
if(isset($_POST['getConfigData'])){ // Front end wants ALL configuration data.
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql = "SELECT * FROM configuration";
	$result = mysqli_query($con,$sql);
	$config = array();
	$id = array();
	$row = array();;
	while($row = mysqli_fetch_array($result)) {
		foreach($row as  $key => $value){
			if(!((string)(int)$key == $key)){
				$id[$key] = $value;
			}
		}
		array_push($config, $id);
	}
}else if(isset($_POST['setConfigValue'])){
	
}
$jencodeddata = json_encode($config);
echo $jencodeddata;
?>