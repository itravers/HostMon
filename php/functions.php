<?php
/**************************************************************
* Hostmon - functions.php
* Author - Isaac Assegai
* Supplies functions that are used by several scripts.
**************************************************************/
/** Builds the opening tags for the notes grid section. */
function buildNotesOpening(){
	$returnVal = "
		<li data-row='1' data-col='7' data-sizex='4' data-sizey='3' id='actions'>    
			<!-- root element for scrollable -->
			<div class='scrollable vertical'>
				<!-- root element for the scrollable elements -->
				<div class='items' id='accordion3'>
					<!-- first element. contains three rows -->";
	return $returnVal;	
}

/** Builds the closing tags for the notes grid section. */
function buildNotesClosing(){
	$returnVal = "
				</div>
			</div>
			<img src='images/up-arrow.png' class='prev'></img>
			<img src='images/down-arrow.png' class='next'></img>
			<img class='plus' src='images/plus.png'></img>
		</li>";
	return $returnVal;	
}

/** Builds the individual note items, only 3 per individual div to keep scrolling working. */
function buildNoteItems($notes){
	$returnVal = "";
	$i = 0;
	$current = "";
	$display = "";
	$divHeader = "<div>";
	$divFooter = "</div>";
	$returnVal = $returnVal.$divHeader;
	$j = count($notes);
	foreach (array_reverse($notes) as $note){
		if($i == 0){ // decides which note is the currently displaying one.
			$current = "current";	
			$display = "block";
		}else{
			$current = "";
			$display = "none";	
		}
		if($i % 3 == 0 && $i != 0){//insert a div seperator every 3 notes, but not on the first one.
			$divMedium = "</div><div>";
		}else{
			$divMedium = "";
		}
		$returnVal = $returnVal."
			<h2 class='item ".$current."'>
				<div id='notenum'>".($j)."</div>
				<div id='notename'>".$note['username']."</div>
				<div id='notedate'>".$note['date']."</div>
				<div id='notetime'>".$note['time']."</div>
				<img class='minus' src='images/minus.png'></img>
			</h2>
			<div class='pane' style='display:".$display."'>".$note['content']."</div>
			<div style='display:none'>".$note['timestamp']."</div>".$divMedium;	
		$i++;
		$j--;
	}
	$returnVal = $returnVal.$divFooter;
	return $returnVal;	
}

/** Fetches the Device ID from the database, uses the ip. */
function getDeviceID($ip){
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql="SELECT id FROM `Devices` WHERE ip = '".$ip."'";
	$result = mysqli_query($con,$sql);
	$id = '';
	while($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
	}
	return $id;	
}

/** Query's the database for the devices name, using the ID. */
function getDeviceName($deviceID){
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql="SELECT name FROM `Devices` WHERE id = '".$deviceID."'";
	$result = mysqli_query($con,$sql);
	$name = '';
	while($row = mysqli_fetch_array($result)) {
		$name = $row['name'];
	}
	return $name;
}

/** Query's the database for a users name, from their ID. */
function getUserName($id){
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql="SELECT usr FROM `Users` WHERE id = '".$id."'";
	$result = mysqli_query($con,$sql);
	$name = '';
	while($row = mysqli_fetch_array($result)) {
		$name = $row['usr'];
	}
	return $name;
}

/** Returns a formatted date, based on a timestamp in millis. */
function getFormattedDate($timestamp){
	$returnVal = date("M d Y", ($timestamp/1000));
	return $returnVal;	
}
	
/** Returns a formatted time, based on a timestamp in millis. */
function getFormattedTime($timestamp){
	$returnVal = date("g i A", ($timestamp/1000));
	return $returnVal;	
}

/** Build the Notes section grid. */
function buildNotesGrid($notes){
	$notesOpening = buildNotesOpening();
	$noteItems = buildNoteItems($notes);
	$noteClosing = buildNotesClosing();
	$returnVal = $notesOpening.$noteItems.$noteClosing;
	return $returnVal;
}

/** Returns an Array of notes from the DB, based on deviceID. */
function getNotes($deviceID){
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql="SELECT * FROM `notes` WHERE deviceID = '".$deviceID."'";
	$result = mysqli_query($con,$sql);
	$returnArray = Array();
	while($row = mysqli_fetch_array($result)) {
		array_push($returnArray, $row);
	}
	$notes = Array();
	foreach($returnArray as $item){
		$note = array("username" => getUserName($item['userID']), 
					  "date" => getFormattedDate($item['timestamp']), 
					  "time" => getFormattedTime($item['timestamp']), 
					  "timestamp" => $item['timestamp'],
					  "content" => $item['content']);
		array_push($notes, $note);
	}
	return $notes;	
}

/* Will Return an array of active devices for the specified username. */
function getActiveDevices($username){
	$con = openDB();
	mysqli_select_db($con,"HostMon");
	$sql="SELECT * FROM `active_devices`";
	$result = mysqli_query($con,$sql);
	$activeDeviceNumbers = Array(); // a 2d array where the first d is different devices, and the 2nd d has the number at 0
	$activeDevices = Array();
	while($row = mysqli_fetch_array($result)) {
		array_push($activeDeviceNumbers, $row);
	}
	
	for($i = 0; $i < count($activeDeviceNumbers); $i++){  //go through each active device number, build an activeDevice array with the name and ip
		$sql="SELECT * FROM `devices` WHERE id = '".$activeDeviceNumbers[$i][0]."'";
		$result = mysqli_query($con,$sql);
		$dev = Array();
		while($row = mysqli_fetch_array($result)) {
			array_push($dev, $row);
		}
		//echo " ".$dev[$i]["name"]." ";
		//echo print_r($dev)." <br><br>";
		//add items here
		if(!empty($dev)){
			$array = array( // will represent a device in grid.php
				"name" => $dev[0]["name"],
				"ip" => $dev[0]["ip"]
			);
		array_push($activeDevices, $array); // push this device to the list of active Devices.
		}
		
	}
	return $activeDevices;
}

/* gets the correct array of grid positions, based on how many grids there are. */
function getGridPositions($numGrids){
	$gridPositions = Array();
	if($numGrids <= 6){
		array_push($gridPositions, array("yp" => 1,"xp" => 1,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 1,"xp" => 5,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 9,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 1,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 5,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 9,"xs" => 4,"ys" => 2));
	}else if($numGrids <= 11){
		array_push($gridPositions, array("yp" => 1,"xp" => 1,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 5,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 1,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 10,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 1,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 5,"xp" => 5,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 9,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 7,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 5,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 7,"xs" => 4,"ys" => 2));
	}else if($numGrids <= 20){
		array_push($gridPositions, array("yp" => 1,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 5,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 1,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 11,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 3,"xp" => 11,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 5,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 5,"xp" => 11,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 5,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 7,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 11,"xs" => 2,"ys" => 2));
	}else if($numGrids <= 41 || $numGrids >= 41){
		array_push($gridPositions, array("yp" => 1,"xp" => 1,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 3,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 5,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 1,"xp" => 9,"xs" => 2,"ys" => 2));
		array_push($gridPositions, array("yp" => 1,"xp" => 11,"xs" => 2,"ys" =>2));
		array_push($gridPositions, array("yp" => 3,"xp" => 1,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 2,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 3,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 4,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 9,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 10,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 11,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 3,"xp" => 12,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 1,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 2,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 3,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 4,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 9,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 10,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 11,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 4,"xp" => 12,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 1,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 2,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 3,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 4,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 5,"xs" => 4,"ys" => 4));
		array_push($gridPositions, array("yp" => 5,"xp" => 9,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 10,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 11,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 5,"xp" => 12,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 1,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 2,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 3,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 4,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 9,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 10,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 11,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 6,"xp" => 12,"xs" => 1,"ys" => 1));
		array_push($gridPositions, array("yp" => 7,"xp" => 1,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 5,"xs" => 4,"ys" => 2));
		array_push($gridPositions, array("yp" => 7,"xp" => 9,"xs" => 4,"ys" => 2));
	}
	return $gridPositions;
}
?>