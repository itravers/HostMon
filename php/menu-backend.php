<?php 
include_once("db.php");
include_once("functions.php");
session_start();
$_POST['getConfigData'] = true;
if(isset($_POST['getConfigData'])){
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
}
$jencodeddata = json_encode($config);
echo $jencodeddata;
?>