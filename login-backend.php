<?php

	session_start();
	if($_POST['submit']=='Login'){
		
		if(!$_POST['username'] || !$_POST['password']){
			$resp[] = 'ALL THE FIELDS MUST BE FILLED IN';
		}
		
		if(!count($resp)){
			// Make a MySQL Connection
			mysql_connect("localhost", "HostMonUser", "Micheal1") or die(mysql_error());
			mysql_select_db("HostMon") or die(mysql_error());
			$_POST['username'] = mysql_real_escape_string($_POST['username']);
			$_POST['password'] = mysql_real_escape_string($_POST['password']);
			$_POST['remember'] = (int)$_POST['remember'];
	
			$query = "SELECT id,usr,admin_level FROM Users WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'";
			
			$result = mysql_query($query) or die(mysql_error());  
			$row = mysql_fetch_array( $result );
			
			if($row['usr']){
				// If everything is OK login
	
				$_SESSION['usr']=$row['usr'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['admin_level'] = $row['admin_level'];
				$_SESSION['remember'] = $_POST['remember'];
				
				//if admin_level is 0 it means user has not been approved by admin yet
				if($_SESSION['admin_level'] == 0){
					$resp[]='ACCOUNT HAS NOT BEEN APPROVED';
					
				}else{
					//login has worked
					$resp[]='Success';
				}
			}
			else{
				$resp[]='WRONG USERNAME/PASSWORD';
			}
		}
	}
	$response = implode(",", $resp);
	echo $response;
	
		
	
	
?>