<?php
	include_once("functions.php");
	include_once("db.php");
	$postResult = "";
	$con = openDB();
	
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
	}else{
		//echo(print_r($_POST));
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
		$latencyList = Array();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT latency FROM `".$table."` WHERE ip = '".$_POST['ip']."'";
		$result2 = mysqli_query($con,$sql);
		
		while($row2 = mysqli_fetch_array($result2)) {
			//$postResult = "".$row['time'].":".$row['latency']." ";
			array_push($latencyList, $row2['latency']);
		}
		//echo print_r($latencyList);
		$minimum = min($latencyList);
		$maximum = max($latencyList);
		$range = $maximum - $minimum;
		$num = count($latencyList);
		$itemLimit = $range / 5;
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
		/*
		echo print_r($item1Array);
		echo '<br><br>';
		echo print_r($item2Array);
		echo '<br><br>';
		echo print_r($item3Array);
		echo '<br><br>';
		echo print_r($item4Array);
		echo '<br><br>';
		echo print_r($item5Array);
		echo '<br><br>';
		echo 'range: '.$range;
		echo '<br><br>';
		echo 'item1limit: '.$item1Limit;
		echo '<br><br>';
		echo 'item2limit: '.$item2Limit;
		echo '<br><br>';
		echo 'item3limit: '.$item3Limit;
		echo '<br><br>';
		echo 'item4limit: '.$item4Limit;
		echo '<br><br>';
		echo 'item5limit: '.$item5Limit;
		*/
		
		$postResult = $postResult."-".$item1Limit.":".count($item1Array)." ".
		$item2Limit.":".count($item2Array)." ". 
		$item3Limit.":".count($item3Array)." ".
		$item4Limit.":".count($item4Array)." ".
		$item5Limit.":".count($item5Array);
		
		
		
	}
	
	echo $postResult;
	
	?>