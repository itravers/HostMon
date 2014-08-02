<!DOCTYPE html">
<head>
<title>Untitled Document</title>

 <style>
    /* use a semi-transparent image for the overlay */
  #overlay {
    background-image:url(images/transparent.png);
    color:#efefef;
    height:1100px;
  }
  /* container for external content. uses vertical scrollbar, if needed */
  div.contentWrap {
    height:1100px;
    overflow-y:auto;
  }
  
   .popup
{
   position: fixed;
   width: 100%;
   opacity: 0.9;
   top:0px;
   min-height:200px;
   height:100%;
   z-index: 100;
   background: #FFFFFF;
   font-size: 20px;
   text-align: center;
   display:none;
}
#login_form
{
 position:absolute;
 width:200px;
 top:100px;
 left:45%;
 background-color:#DDD;
 padding:10px;
 border:1px solid #AAA;
 display:none;
 z-index:101;
 -moz-border-radius: 10px;
 -moz-box-shadow: 0 0 10px #aaa;
 -webkit-border-radius: 10px;
 -webkit-box-shadow: 0 0 10px #aaa;
}
  </style>
 
</head>

<body>
<?php session_start(); ?>
<div id="profile">
<?php if(isset($_SESSION['user_name'])){?>
 <a href='logout.php' id='logout'>Logout</a>
 <?php }else {?>
  <a id="login_a" href="#">login</a>
   <?php } ?>
</div>

<div id="login_form">
 <div class="err" id="add_err"></div>
 <form action="login.php">
  <label>User Name:</label>
  <input type="text" id="user_name" name="user_name" />
  <label>Password:</label>
  <input type="password" id="password" name="password" />
  <label></label><br/>
  <input type="submit" id="login" value="Login" />
  <input type="button" id="cancel_hide" value="Cancel" />
 </form>
 </div>
 <div id="shadow" class="popup"></div>
 
</body>
</html>