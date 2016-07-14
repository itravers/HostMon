<?php 
	include_once("../php/db.php");
	include_once("../php/functions.php");
	//if(isInstalledAlready()){ // forward user to login.php
	//	header("Location: ../login.php"); die();
	//}else{
		$mysql = 'false';
		$php = phpversion();
		$apache = substr(apache_get_version(), 7, 5);
		//pacheVersion = substr($apache,
		$ext = get_loaded_extensions();
		for($i = 0; $i < count($ext); $i++){
			if($ext[$i] == 'mysqli')$mysql = 'true';
		}

		$mysqlVersion = getMySQLVersion();
		

			//setup labels based on prereqs
		$phpLabel = getPhpLabelFromVersion($php);
		$phpText = getPhpTextFromVersion($php);
		$mySQLText = getMySQLTextFromVersion($mysqlVersion);
		$mySQLLabel = getMySQLLabelFromVersion($mysqlVersion);
		$apacheText = getApacheTextFromVersion($apache);
		$apacheLabel = getApacheLabelFromVersion($apache);
	//}
	


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
				<td class='install_value' id=<?php echo $phpLabel?>><?php echo $phpText?></td>
			</tr>
			<tr>
				<td class='install_label'>MySQLi Installed</td>
				<td class='install_value' id=<?php echo $mySQLLabel ?>><?php echo $mySQLText?></td>
			</tr>
			<tr>
				<td class='install_label'>Apache Version</td>
				<td class='install_value' id=<?php echo $apacheLabel ?>><?php echo $apacheText ?></td>
			</tr>
		</table>
		<br>
		<form>
		<input type="radio" class="installRadio radioLeft" name="admin" id="adminRadio" onclick="clickAdmin();"><label for="adminRadio">Use Admin Credentials</label>
		<label for="noAdminRadio" class="radioRight">User DB Credentials</label><input checked onclick="clickNoAdmin();" type="radio" class="installRadio" name="noAdmin" id="noAdminRadio">
		</form>
		<div class="db_yes_admin">
                <table class='install_table'>
                <caption>MySQL Admin Settings</caption>
			<p class="db_instruction">Input Admin Settings and your Database will be automatically installed.</p>
                        <tr>
                                <td class='install_label'>Admin Username</td>
                                <td class='install_value'><input class="adminUsername installInput" type="text">
                                <div class="error installError hidden" id="adminUsernameError">Error: This address is not valid.</div>
                                </td>
                        </tr>
                        <tr>
                                <td class='install_label'>Admin Password</td>
                                <td class='install_value'><input class="adminPassword installInput" type="text">
                                <div class="error installError hidden" id="adminPasswordError">Error: This DB Name is not Valid.</div>
                                </td>
                        </tr>
                </table>
                </div>

	
		<div class="db_no_admin">
		<table class='install_table'>
		<caption>MySQL DB Settings</caption>
			<p class="db_instruction">Your Database should already exist, input credentials to connect.</p>
			<tr>
				<td class='install_label'>Address</td>
				<td class='install_value'><input class="dbAddress installInput" type="text">
				<div class="error installError hidden" id="addressError">Error: This address is not valid.</div>
				</td>
			</tr>
			<tr>
				<td class='install_label'>DB Name</td>
				<td class='install_value'><input class="dbName installInput" type="text">
				<div class="error installError hidden" id="nameError">Error: This DB Name is not Valid.</div>
				</td>
			</tr>
			<tr>
				<td class='install_label'>DB User</td>
				<td class='install_value'><input class="dbUser installInput" type="text">
				<div class="error installError hidden" id="userError">Error: This DB Username is not valid.</div>
				</td>
			</tr>
			<tr>
				<td class='install_label'>DB User's Password</td>
				<td class='install_value'><input class="dbPass installInput" type="text">
				<div class="error installError hidden" id="passwordError">Error: This DB Password is not valid.</div>
				</td>
			</tr>
		</table>
		</div>
		<button id="installButton" onclick="checkDB();">Check</button>
		<br>
		<table class='install_table'>
		<caption>New Admin Settings</caption>
			<tr>
				<td class='install_label'>Admin Username</td>
				<td class='install_value'><input class="adminUsername installInput" type="text">
			</tr>
			<tr>
				<td class='install_label'>Password</td>
				<td class='install_value'><input class="adminPassword installInput" type="password"></td>
			</tr>
		</table>
		<button id="installButton" onclick="install();">Install</button>
	</div>
	<h3 id="installErrorOutput"> Make sure all settings are correct, then press "Install"</h3>
</body>

<script type='text/javascript' src="../js/jquery.tools.min.js"></script>
<script src="../js/jquery.md5.js"></script>
<script>
var useAdminCreds = false;

/**
  * Gets called when user clicks "use Admin Creds" radio button
  * Makes:
  * 1. db creds section disappear
  * 2. Makes user DB creds radio button uncheck
  * 3. Admin Creds section Appears.
  * 4. Checks admin creds radio button.
  */
function clickAdmin(){
	$('.db_no_admin').hide();
	$('#noAdminRadio').prop('checked', false);
	$('.db_yes_admin').show();
	$('#adminRadio').prop('checked', true);
	useAdminCreds = true;
}

/**
  * Called when you clicks no Admin Section radio button
  * Makes:
  * 1. admin creds section disappear
  * 2. db creds section appear
  * 3. admin radio button uncheck
  * 4. db creds radio button checked.
  */
function clickNoAdmin(){
	$('.db_yes_admin').hide();
	$('.db_no_admin').show();
	$('#noAdminRadio').prop('checked', true);
	$('#adminRadio').prop('checked', false);
	useAdminCreds = false;
}

/** Grabs the info filled in about Mysql Settings
  * Sends that info to the server to see if we
  * Correctly log into Mysql with those settings.
  */
function checkDB(){

	if(!useAdminCreds){//decides wheather to verify using root creds, or db creds.
		var dbAddress = $('.dbAddress').val();
		var dbName = $('.dbName').val();
        	var dbUsername = $('.dbUser').val();
        	var dbPassword = $('.dbPass').val();

		//Here we make the Ajax Call to the backend
			postData = {checkDB:true,
					dbName:dbName,
					dbAddress:dbAddress,
					dbUsername:dbUsername,	
					dbPassword:dbPassword};
	}else{
		var adminUsername = $('.adminUsername').val();
                var adminPassword = $('.adminPassword').val();

                //Here we make the Ajax Call to the backend
                        postData = {checkAdminDB:true,
                                        adminUsername:adminUsername,
                                        adminPassword:adminPassword};
	}

	(function worker() {	
		$.ajax({
                        type:"POST",
                        data : postData,
                        url: 'install-backend.php',
                        success: function(result,status,xhr) {
                                var jsonData = JSON.parse(result);
				var errorType = jsonData['errorType'];
				var errorNum = jsonData['errorNum'];
				if(errorNum == 1045 && useAdminCreds)errorType = 'adminUsernameError';
                                if(jsonData['success']){
					$('#'+errorType).removeClass('hidden');
					$('#'+errorType).addClass('green');
                                        $('#'+errorType).text("No Error: "+jsonData['errorMessage']);
                                }else{
                                        $('#'+errorType).text("Error: " + jsonData['errorMessage']);
					$('#'+errorType).removeClass('hidden');
					
                                }
                        },
                        complete: function(result) {
                                // Schedule the next request when the current one's complete
                                //alert("complete" + result);
                                //setMenuItemDisplay(result);

                        },
                        error: function(xhr,status,error){
                                $("#addressError").setText("Error2: " + JSON.stringify(error));
                        }
                }); // End of ajax call.


	})();
}

function install(){
	var dbAddress = $('.dbAddress').val();
	var dbName = $('.dbName').val();
	var dbUsername = $('.dbUser').val();
	var dbPassword = $('.dbPass').val();
	var adminUsername = $('.adminUsername').val();
	var adminPassword = $('.adminPassword').val();
	adminPassword = $.md5(adminPassword);
	(function worker() { // Start a worker thread to grab the data so we don't freeze anything on our page.
		postData = {install:true,
					dbName:dbName,
					dbAddress:dbAddress,
					dbUsername:dbUsername,
					dbPassword:dbPassword,
					adminUsername:adminUsername,
					adminPassword:adminPassword};
		 // Send the request to the server.
		 //alert("preping ajax");
		 $.ajax({
			type:"POST",
			data : postData,
			url: 'install-backend.php', 
			success: function(result,status,xhr) {
				//alert("success");
				var jsonData = JSON.parse(result);
				if(jsonData['success']=='true'){
					//alert("success");
					$("#installErrorOutput").text(jsonData['errorMessage']);
					window.location.href = "../login.php"; 
				}else{
					$("#installErrorOutput").text(jsonData['errorMessage']);
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
