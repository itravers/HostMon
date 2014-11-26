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
				<td class='install_value'><input class="adminUsername" type="text"></td>
			</tr>
			<tr>
				<td class='install_label'>Password</td>
				<td class='install_value'><input class="adminPassword" type="password"></td>
			</tr>
		</table>
		<button id="installButton" onclick="install();">Install</button>
	</div>
	<h3 id="installErrorOutput"> Make sure all settings are correct, then press "Install"</h3>
</body>
<script type='text/javascript' src="../js/jquery.tools.min.js"></script>
<script>

function install(){
	var dbAddress = $('.dbAddress').val();
	var dbName = $('.dbName').val();
	var dbUsername = $('.dbUser').val();
	var dbPassword = $('.dbPass').val();
	var adminUsername = $('.adminUsername').val();
	var adminPassword = $('.adminPassword').val();
	(function worker() { // Start a worker thread to grab the data so we don't freeze anything on our page.
		postData = {install:true};
		 // Send the request to the server.
		 alert("preping ajax");
		 $.ajax({
			type:"POST",
			data : postData,
			url: 'install-backend.php', 
			success: function(result,status,xhr) {
				//alert("success");
				var jsonData = JSON.parse(result);
				if(jsonData['success']=='true'){
					alert("success");
					$("#installErrorOutput").text("Installation was a success");
				}else{
					$("#installErrorOutput").text("Installation was not a success");
				}
			},
			complete: function(result) {
				// Schedule the next request when the current one's complete
				//alert("complete" + result);
				//setMenuItemDisplay(result);
				
			},
			error: function(xhr,status,error){
				$("#installErrorOutput").setText("Error With Install");
			}
		}); // End of ajax call.
	})(); //End of worker thread.
}
</script>
</html>
