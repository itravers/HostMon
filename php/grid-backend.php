<?php
error_reporting(-1);
	include_once("functions.php");
	include_once("db.php");
	$postResult = "";
	//$postResult = $_POST;
	
	//deviceName
	if(isset($_POST['addNewDevice'])){
		//$postResult = $postResult.$_POST['addNewDevice'];
		/*first we check the db to see if a device of this ip has already been added
		  if it has, then we pull the info for that device from the db,
		  		   , then we make sure the device is in/added to the active devices list in db.
				   , then we create a render of that device and send it to the frontend.
		  if it has not been added, then create a new device record with the ip, name, and initial note.
		  			, then we make sure the new device is in active devices list in db.
					, then we create a render of that device and send it to the frontend.
		*/
		//$ip = $_POST['deviceIP'];
		//$name = $_POST['deviceName'];
		//$note = $_POST['deviceNote'];
		
		$ip = "chicosystems.com";
		$name = "Chico Systems";
		$note = "This is chico systems.";
		
		
		if(deviceExists($ip)){
			
			$postResult = " DeviceExists |";
			$id = getDeviceID($ip);
			makeDeviceActive($id);
			$postResult = $postResult.renderDevice($id);
		}else{
			$postResult = " AddedDevice | display";
			$id = getDeviceID($ip);
			makeDeviceActive($id);
			$postResult = $postResult.renderDevice($id);
		}
	}else if(isset($_POST['getGridGraphData'])){
		$ip = $_POST['ip'];
	    $timeRange = $_POST['timeRange'];
		$data = getTenAveragePointsInTimeRange($timeRange);
		$postResult = $data;
	}
	
	//gets the last $timeRange of pings from the database
	//gives us 10 even spaced averages.
	function getTenAveragePointsInTimeRange($timeRange){
		$averagePoints = "";
		if($timeRange == "fiveMinute"){
			$averagePoints = "100 100 200 200 400 300 400 400 500 500";
		}else if($timeRange == "hour"){
			$averagePoints = "1000 90 800 70 600 50 400 30 200 10";
		}
		return $averagePoints;
	}
	
	function makeDeviceActive($id){
		
	}
	
	function renderDevice($id){
		$returnVal ='	
		<li href="device.php?ip=plesk.com" rel="#overlay" data-row="5" data-col="8" data-sizex="1" data-sizey="1" onclick="loadDevice(\'0\');">
        	<img src="images/up-arrow.png" class="grow"><img src="images/down-arrow.png" class="shrink">
			<div class="device_record">
                <h1>Plesk</h1><h2>plesk.com</h2><h3>1ms</h3><canvas class="can1"></canvas><div id="statusmark"></div>
			</div>
		</li>';	
		return $returnVal;
	}
	
	function deviceExists($ip){
		return false;	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	echo $postResult;
	//echo print_r($_POST);
?>