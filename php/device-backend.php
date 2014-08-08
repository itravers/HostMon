<?php
	include_once("functions.php");
	include_once("db.php");
	
	
	if($_POST['FiveMinLine']){
		//echo("FiveMinLine: ".$_POST['FiveMinLine']);
		$con = openDB();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT time, latency FROM `minute` WHERE ip = 'chicosystems.com'";
		$result = mysqli_query($con,$sql);
		
		while($row = mysqli_fetch_array($result)) {
			echo "".$row['time'].":".$row['latency']." ";
		}
	}else{
		//echo(print_r($_POST));
	}
	
	?>