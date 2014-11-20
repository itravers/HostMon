<?php 
include_once("php/db.php");
session_start();
if(isset($_GET['logout'])){ // User is logging out.
	
		//session_unset();
		session_destroy();
	
}else if(isset($_POST['submit'])){
	if($_POST['submit']=='Login'){ // User is logging in to the application.
		$resp = Array(); // Used to send the response back to the user.
		if(!$_POST['username'] || !$_POST['password']){
			$resp[] = 'ALL THE FIELDS MUST BE FILLED IN';
		}
		// If reponse hasn't been handled yet.
		if(!count($resp)){
			// Make a MySQL Connection
			$con = openDB();
			$sql = "SELECT id,usr,admin_level FROM Users WHERE usr='{$_POST['username']}' AND pass='".md5($_POST['password'])."'";
			$row = queryDB($con, $sql);
	
			if($row['usr']){
				// If everything is OK login
				//echo "starting session";
				if(!isset($_SESSION)) session_start(); // Start the session. doesn't seem to work here.
				$_SESSION['admin_level'] = $row['admin_level'];
				//$_SESSION['remember'] = $_POST['remember'];
	
				//if admin_level is 0 it means user has not been approved by admin yet
				if($_SESSION['admin_level'] == 0){
					$resp[]='ACCOUNT HAS NOT BEEN APPROVED';
				}else{
					//login has worked
					$_SESSION['loggedIn']=true;
					$_SESSION['id'] = $row['id'];
					$_SESSION['usr']=$row['usr'];
					$resp[]='Success '.$row['usr']; //after success we will also return the username
				}
			}else{
				$resp[]='WRONG USERNAME/PASSWORD';
			}
		}
	} // end of if login
	$response = implode(",", $resp);
	echo $response;
}
 ?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script src="js/jquery.tools.min.js"></script>
</head>
<body class='main-body'>
	<div class='login-form'>
		<h1>Hostmon</h1>
    	<div class="input-wrapper">
            <div class="img-wrapper"><img src="images/username2.png" /></div>
            <input type="text" name="username" placeholder="username" id="username" class="pictureInput" />
        </div>
        
        <div class="input-wrapper">
            <div class="img-wrapper"><img src="images/password2.png" /></div>
            <input type="password" name="password" placeholder="password" id="password" class="pictureInput">
        </div>
        <input type="hidden" name="submit" value="Login">
        <!--<span>
            <input type="checkbox" name="remember" id="remember"><br>
            <label for="checkbox">remember</label>
        </span> -->
		<input type="submit" value="LOG IN" id="submit">
		<div id="error_msg"> <!-- The Error message will be displayed here. --></div>
	</div>

	<div class="ajax-spinner-bars"> <!-- The loading animation displayed on the submit button. -->
		<div class="bar-1"></div>
		<div class="bar-2"></div>
		<div class="bar-3"></div>
		<div class="bar-4"></div>
		<div class="bar-5"></div>
		<div class="bar-6"></div>
		<div class="bar-7"></div>
		<div class="bar-8"></div>
		<div class="bar-9"></div>
		<div class="bar-10"></div>
		<div class="bar-11"></div>
		<div class="bar-12"></div>
		<div class="bar-13"></div>
		<div class="bar-14"></div>
		<div class="bar-15"></div>
		<div class="bar-16"></div>
	</div>


<script type="text/javascript">
//alert("ready");
/** Event called when document is loaded. */
$(document).ready(function() {

	// Register an event listener on the submit id. 
	$("#submit").click(function(){
		//alert("posting");
		var buttontext = $("#submit").val();
		$("#submit").val("");
		$(".ajax-spinner-bars").show();
		$("#error_msg").fadeOut();
		username = $("#username").val(); 
		password = $("#password").val(); 
		remember = $("#remember").val();
		
		// Post to login-backend.php to see if this is a good login.
		$.post("login.php",{
			submit:"Login",
			username:username,
			password:password, // We may want to take and hash this value.
			remember:remember
    },
    function(data,status){ // Receiving data back from login-backend.php
		if(data.indexOf("Success") != -1){
			var pos = data.indexOf("Success");
			pos += 8; //account for the word success, and the space that will be after it.
			var userName = data.substring(pos);
			//will need to change this soon, using GET here is a bad idea.
			window.location.href = "grid.php?login=true"; 
		}else{
			$("#error_msg").text(data); 
			$("#error_msg").fadeIn();
			$(".ajax-spinner-bars").hide();
			$("#submit").val(buttontext);
		}
    }); //End function
	}); // Submit Listener

	// Check if JavaScript is enabled
	$('body').addClass('js');
 
	// Make the checkbox checked on load
	$('.login-form span').addClass('checked').children('input').attr('checked', true);

	// Click function
	$('.login-form span').on('click', function() {
		if($(this).children('input').attr('checked')) {
			$(this).children('input').attr('checked', false);
			$(this).removeClass('checked');
		}else{
			$(this).children('input').attr('checked', true);
			$(this).addClass('checked');
		}
	}); // End login-form span click listener.
});
</script>
</body>
</html>