<?php 
$mysql = 'false';
$php = phpversion();
$apache = substr(apache_get_version(), 0, 10);
$ext = get_loaded_extensions();
for($i = 0; $i < count($ext); $i++){
	if($ext[$i] == 'mysqli')$mysql = 'true';
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/styles.css">
<script src="js/jquery.tools.min.js"></script>
</head>
<body class='main-body'>
	<h1>Hostmon Installation</h1>
	<div class='install'>
		<table class='install_table'>
		<caption>Dependencies</caption>
			<tr>
				<td class='install_label'>PHP Version</td>
				<td class='install_value' id='install_red'><?php echo $php?></td>
			</tr>
			<tr>
				<td class='install_label'>MySQLi Installed</td>
				<td class='install_value' id='install_green'><?php echo $mysql?></td>
			</tr>
			<tr>
				<td class='install_label'>Apache Version</td>
				<td class='install_value' id='install_green'><?php echo $apache?></td>
			</tr>
		</table>
		<br>
		<table class='install_table'>
		<caption>MySQL Settings</caption>
			<tr>
				<td class='install_label'>Address</td>
				<td class='install_value'><input class="dbAddress" type="text"></td>
			</tr>
			<tr>
				<td class='install_label'>DB Name</td>
				<td class='install_value'><input class="dbName" type="text"></td>
			</tr>
			<tr>
				<td class='install_label'>DB User</td>
				<td class='install_value'><input class="dbUser" type="text"></td>
			</tr>
			<tr>
				<td class='install_label'>DB User's Password</td>
				<td class='install_value'><input class="dbPass" type="text"></td>
			</tr>
		</table>
		<br>
		<table class='install_table'>
		<caption>Admin Settings</caption>
			<tr>
				<td class='install_label'>Admin Username</td>
				<td class='install_value'><input class="dbAddress" type="text"></td>
			</tr>
			<tr>
				<td class='install_label'>Password</td>
				<td class='install_value'><input class="dbName" type="password"></td>
			</tr>
		</table>
	</div>
</body>
</html>
