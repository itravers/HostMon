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
     
   <div id="error_msg">
</div>

</div>

<div class="ajax-spinner-bars">
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

 

</body>
<script>


$(document).ready(function() {
	
	$("#submit").click(function(){
		
		var buttontext = $("#submit").val();
		$("#submit").val("");
		$(".ajax-spinner-bars").show();
		$("#error_msg").fadeOut();
		username = $("#username").val(); 
		password = $("#password").val(); 
		remember = $("#remember").val();
    $.post("php/login-backend.php",
    {
	  submit:"Login",
      username:username,
	  password:password,
	  remember:remember
    },
    function(data,status){
     // alert("Data: " + data + "\nStatus: " + status);
	  //var pos = status.search("Success");
	  if(data.indexOf("Success") != -1){
		// alert("Data: " + data + "\nStatus: " + status); 
		 window.location.href = "grid.php?login=true&userName=itravers"; 
	  }else{
		 //  alert("Data: " + data + "\nStatus: " + status); 
		$("#error_msg").text(data); 
		$("#error_msg").fadeIn();
		 $(".ajax-spinner-bars").hide();
		 $("#submit").val(buttontext);
	  }
	 
    });
  });
 
    // Check if JavaScript is enabled
    $('body').addClass('js');
 
    // Make the checkbox checked on load
    $('.login-form span').addClass('checked').children('input').attr('checked', true);
 
    // Click function
    $('.login-form span').on('click', function() {
 
        if ($(this).children('input').attr('checked')) {
            $(this).children('input').attr('checked', false);
            $(this).removeClass('checked');
        }
 
        else {
            $(this).children('input').attr('checked', true);
            $(this).addClass('checked');
        }
 
    });
 
});
</script>