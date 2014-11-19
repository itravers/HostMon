<?php
/**************************************************************
* Hostmon - login-backend.php
* Author - Isaac Assegai
* This script is utilized by login.php to handle logging into
* the application.
**************************************************************/
include_once("functions.php");
include_once("db.php");
	
session_start();
if($_POST['submit']=='Login'){ // User is logging in to the application. 
	$resp = Array(); // Used to send the response back to the user.
	if(!$_POST['username'] || !$_POST['password']){
		$resp[] = 'ALL THE FIELDS MUST BE FILLED IN';
	}
	// If reponse hasn't been handled yet. 
	if(!count($resp)){
		// Make a MySQL Connection
		$con = openDB();
		$sql = "SELECT id,usr,admin_level FROM Users WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'";
		$row = queryDB($con, $sql);

		if($row['usr']){
			// If everything is OK login
			//echo "starting session";
			if(!isset($_SESSION)) session_start(); // Start the session. doesn't seem to work here.
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['admin_level'] = $row['admin_level'];
			//$_SESSION['remember'] = $_POST['remember'];
	
			//if admin_level is 0 it means user has not been approved by admin yet
			if($_SESSION['admin_level'] == 0){
				$resp[]='ACCOUNT HAS NOT BEEN APPROVED';
			}else{
				//login has worked
				$resp[]='Success '.$row['usr']; //after success we will also return the username
			}
		}else{
			$resp[]='WRONG USERNAME/PASSWORD';
		}
	}
} // end of if login
$response = implode(",", $resp);
echo $response;	
?>