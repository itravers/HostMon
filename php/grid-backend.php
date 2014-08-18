<?php
	include_once("functions.php");
	include_once("db.php");
	$postResult = "";
	$postResult = $_POST;
	
	//deviceName
	if($_POST['addNewDevice']){
		//$postResult = $postResult.$_POST['addNewDevice'];
		/*first we check the db to see if a device of this ip has already been added
		  if it has, then we pull the info for that device from the db,
		  		   , then we make sure the device is in/added to the active devices list in db.
				   , then we create a render of that device and send it to the frontend.
		  if it has not been added, then create a new device record with the ip, name, and initial note.
		  			, then we make sure the new device is in active devices list in db.
					, then we create a render of that device and send it to the frontend.
		*/
		$ip = $_POST['deviceIP'];
		$name = $_POST['deviceName'];
		$note = $_POST['deviceNote'];
		
		if(deviceExists($ip)){
			$postResult = " DeviceExists | display";
		}else{
			$postResult = " AddedDevice | display";
		}
	}
	
	function deviceExists($ip){
		return false;	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	echo $postResult;

?>