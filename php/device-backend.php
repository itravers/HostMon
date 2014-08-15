<?php
	include_once("functions.php");
	include_once("db.php");
	$postResult = "";
	//$SESSION['userID'] = 1;
	$con = openDB(); //we know we are going to be querying from the db even if nothing was posted.
	//decide which line graph should be displayed and pull the appropriate data from db
	if($_POST['LineChart']){
		$table = '';
		if($_POST['LineChart']=="FiveMinuteLine"){
			$table = "minute";
		}else if($_POST['LineChart']=="HourLine"){
			$table = "hour";
		}else if($_POST['LineChart']=="DayLine"){
			$table = "day";
		}else if($_POST['LineChart']=="WeekLine"){
			$table = "week";
		}else if($_POST['LineChart']=="YearLine"){
			$table = "year";
		}
		mysqli_select_db($con,"HostMon");
		$sql="SELECT time, latency FROM `".$table."` WHERE ip = '".$_POST['ip']."'";
		$result = mysqli_query($con,$sql);
		
		while($row = mysqli_fetch_array($result)) {
			$postResult = $postResult."".$row['time'].":".$row['latency']." ";
		}
	}
	//decide which polor graph to use, pull the data from db and append to results
	if($_POST['PolarChart']){
		$table = '';
		if($_POST['PolarChart']=="FiveMinutePolar"){
			$table = "minute";
		}else if($_POST['PolarChart']=="HourPolar"){
			$table = "hour";
		}else if($_POST['PolarChart']=="DayPolar"){
			$table = "day";
		}else if($_POST['PolarChart']=="WeekPolar"){
			$table = "week";
		}else if($_POST['PolarChart']=="YearPolar"){
			$table = "year";
		}
		$latencyList = Array(); //the structure we are reading latency results to.
		mysqli_select_db($con,"HostMon");
		$sql="SELECT latency FROM `".$table."` WHERE ip = '".$_POST['ip']."'";
		$result2 = mysqli_query($con,$sql);
		//Record the latency results to the latency list.
		while($row2 = mysqli_fetch_array($result2)) {
			array_push($latencyList, $row2['latency']);
		}
		//we need to know the min and max of items in the list.
		$minimum = min($latencyList);
		$maximum = max($latencyList);
		$range = $maximum - $minimum; //the range of items in the list
		$num = count($latencyList); // the number of items in the list.
		$itemLimit = $range / 5; // The number of items in the polar chart.
		//calculate the limit for each item in the polar chart.
		$item1Limit = $minimum+$itemLimit;
		$item2Limit = $minimum+$itemLimit*2;
		$item3Limit = $minimum+$itemLimit*3;
		$item4Limit = $minimum+$itemLimit*4;
		$item5Limit = $minimum+$itemLimit*5;
		$item1Array = Array();
		$item2Array = Array();
		$item3Array = Array();
		$item4Array = Array();
		$item5Array = Array();
		
		//push each item to it's respective section of the polar chart.
		for($i = 0; $i < $num; $i++){
			if($latencyList[$i] <= $item1Limit){
				array_push($item1Array, $latencyList[$i]);
			}else if($latencyList[$i] <= $item2Limit){
				array_push($item2Array, $latencyList[$i]);
			}else if($latencyList[$i] <= $item3Limit){
				array_push($item3Array, $latencyList[$i]);
			}else if($latencyList[$i] <= $item4Limit){
				array_push($item4Array, $latencyList[$i]);
			}else if($latencyList[$i] <= $item5Limit){
				array_push($item5Array, $latencyList[$i]);
			}
		}
		
		//Build the result of the page to return to the front end for parsing.
		$postResult = $postResult."-".$item1Limit.":".count($item1Array)." ".
		$item2Limit.":".count($item2Array)." ". 
		$item3Limit.":".count($item3Array)." ".
		$item4Limit.":".count($item4Array)." ".
		$item5Limit.":".count($item5Array);
	}
	
	/* If SubmitNote has been posted, we want to get the note info from the post, submit a new note to
	 * The database. Then we want to read and parse the notes into a new note section that jquery
	 * will replace on the frontend. */
	// $_POST['SubmitNote'] = true;
	// $_POST['deviceID'] = 12;
	// $_POST['time'] = '1409619912000';
	// $_POST['noteName'] = 'itravers';
	// $_POST['noteContent'] = 'this is the content';
	 
	 
	if($_POST['SubmitNote']){
		$deviceID = $_POST['deviceID'];
		$time = $_POST['time'];
		$noteName = $_POST['noteName'];
		$noteContent = $_POST['noteContent'];
		$userID = 1;
		//mysqli_real_escape_string
		$sanitizedContent = mysqli_real_escape_string($con, $noteContent);
		//submit note to database
		$resultList = Array(); //the structure we are reading latency results to.
		mysqli_select_db($con,"HostMon");
		$sql="INSERT INTO `HostMon`.`notes` (`id` ,`deviceID` ,`userID` ,`timestamp` ,`content`) VALUES (NULL , '".$deviceID."', '".$userID."', '".$time."', '".$sanitizedContent."');";
		$result2 = mysqli_query($con,$sql);
		//Record the latency results to the latency list.
		
	    $notes = getNotes($deviceID); //db query get array of notes from device id.
		$postResult = buildNotesGrid($notes);
		//$postResult = "test";
		
	}
	echo $postResult; //sends result to front end.
?>