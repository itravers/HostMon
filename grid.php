<!DOCTYPE html>
<?php  
/**************************************************************
* Hostmon - grid.php
* Author - Isaac Assegai
* This page allows the user to actively or passively monitor
* Several devices at one time. The user has the ability to 
* re-arrange the page and resize the interface to the different
* devices being monitored.
**************************************************************/
include_once("php/functions.php");
include_once("php/db.php");

$userName = "Guest";
$adminLevel;
$loggedIn = false;
if(!isset($_SESSION)) session_start();

//this is really a bad idea to check if we are logged in with a get variable, 
//can't seem to get the session variable to set in login-backend.php like i was planning
if(isset($_GET['login'])){ //if login has just logged us in
	if($_SESSION['loggedIn']){
		$userName = $_SESSION['usr'];
		$adminLevel = $_SESSION['admin_level'];
		$loggedIn = true;
	}
}else if(isset($_SESSION)){ //if we are already logged in but just updating the page.
	if($_SESSION['loggedIn']){
		$userName = $_SESSION['usr'];
		$adminLevel = $_SESSION['admin_level'];
		$loggedIn = true;
	}
}
$pageTitle = "Hostmon - ".$userName;
$devices = getActiveDevices($userName); // returns the initial active devices
$gridPositions = getGridPositions(count($devices)); // returns a 2d array with initial grid positions and sizes 
?>


<?php if($loggedIn):?>
<html class="main_grid">
<!-- Grid.html is currently having issues with event listeners. -->
	<head>
		<title><?php echo $pageTitle ?></title>
		<link rel="stylesheet" type="text/css" href="css/gridster.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
		<a class="menu" href="#">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</a>
		<!-- This is the Menu that is handled in Javascript -->
		<nav class="left">
			<ul>
				<li style="height: 90%; font-color="white";>
					<h4 title="The time, in milliseconds, that we are aiming to have each record updated in. This will have an effect on the number of threads running in backend."
					>Avg. Goal Time</h4>
					<input type="text" name="fname" style="display:inline;">
				</li>
        		<li style="height: 10%;"><a href="login.php?logout=true">Logout</a></li>
			</ul>
		</nav>
	</head>
	<body>
		<!-- This is the entire page, where the grid can roam. -->
		<section class="grid">
			<div class="gridster" id="frontGrid">
				<ul class='gridlist'>
					<!-- each grid is parsed from the devices array, each grid is placed using the gridPositions array. -->
					<?php for($i=0;$i<count($devices);$i++) : ?>
					<li href="device.php?ip=<?php echo $devices[$i]['ip'];?>"  id="first" rel="#overlay" 
							data-row="<?php echo $gridPositions[$i]['yp'] ?>" data-col="<?php echo $gridPositions[$i]['xp'] ?>"
							data-sizex="<?php echo $gridPositions[$i]['xs'] ?>" data-sizey="<?php echo $gridPositions[$i]['ys'] ?>" onclick="loadDevice('0');">
							
                    	<img src="images/up-arrow.png" class="grow"><img src="images/down-arrow.png" class="shrink">
                  		<div class="device_record" >
                        	<h1><?php echo $devices[$i]['name']; ?></h1>
							<h2><?php echo $devices[$i]['ip']; ?></h2>
							<h3>1ms</h3>
							<canvas id="<?php echo $devices[$i]['ip'];?>"></canvas>
							<canvas class="graph secondImage" id="<?php echo $devices[$i]['ip'];?>" 
								    style="display:<?php if($gridPositions[$i]['ys'] != 4){ echo 'none';}else{echo 'block';}?>;"></canvas>
							<div id="statusmark"></div>
						</div>
					</li>
					<?php endfor; ?>
					<!-- embedded php based on the following code
					<li href="device.php?ip=gmail.com" rel="#overlay" data-row="1" data-col="5" data-sizex="4" data-sizey="4" onclick="loadDevice('0');">
                    	<img src="images/up-arrow.png" class="grow"><img src="images/down-arrow.png" class="shrink">
						<div class="device_record">
                        	<h1>Gmail Service</h1>
							<h2>gmail.com</h2>
							<h3>1ms</h3>
							<canvas class="graph" id="gmail.com"></canvas><canvas class="graph secondImage" id="gmail.com"></canvas>
							<div id="statusmark"></div>
                        </div>
					</li> -->
					 <li data-row="7" data-col="12" data-sizex="1" data-sizey="1" id="newDeviceOpener">
                    	<div id="addNewDeviceImageContainer">
                    		<img src="images/plus.png" id="addNewDeviceImage">
                        </div>
					</li>
                   
				</ul>
			</div>
			<div class="close"></div>   
            
           <div id="newDeviceDialog" title="Monitor New Device">
			  <form id="newDeviceForm">
				<fieldset>
				  <input type="text" name="deviceName" id="deviceName" placeholder="Device Name" class="text ui-widget-content ui-corner-all">
				  <input type="text" name="deviceIP" id="deviceIP" placeholder="Device IP" class="text ui-widget-content ui-corner-all">
				  <input type="textarea" name="deviceNote" id="deviceNote" placeholder="Initial Note" class="textarea ui-widget-content ui-corner-all">
				  <!-- Allow form submission with keyboard without duplicating the dialog button -->
				  <!--<input type="submit" id="newDeviceSubmit">-->
				</fieldset>
			  </form>
			</div>
		</section>
     
		<!-- overlayed element -->
		<div class="apple_overlay" id="overlay">
        
		<!-- the external content is loaded inside this tag -->
		<div class="contentWrap"></div>
        
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/hostmonChart.js"></script>
<script type="text/javascript" src="js/jquery.gridster.min.js" charster="utf-8"></script>

<script type="text/javascript">
var gridster = 0;
var dragged = 0; // Used to keep the device.php overlay from loading when a grid is being dragged.
var gridGraphTimeOut; //Used to disable ajax updating of the page when device.php is overlayed.
	
//Initialize Gridster
gridster = $("#frontGrid > ul").gridster({
	widget_margins: [5, 5],
	widget_base_dimensions: [95, 95],
	min_cols: 8,
	draggable: {
		start: function(event, ui) {
			dragged = 1; //keeps overlay from loading while we are dragging.
		}
	} 
}).data('gridster');	

//Initialize and draw every canvas on the page.		
c = initializeCanvas("can1");
for(i = 0; i < c.length; i++){
	canvas = c[i];
	canvas.height = canvas.width/3;
    colorCanvas(canvas, "#51bbff");
    drawGraph(canvas);
}

// Separates a string in ajax. Probably Used for adding a new device?		
function getMessage(result){
	var message = result.substring(0, result.indexOf("|"));	
	return message;
}

// Separates a string in ajax. Probably Used for adding a new device?
function getDisplay(result){
	var display = result.substring(result.indexOf("|")+1, result.length);
	return display;	
}

//Sends an ajax call to the server to add a new device, then it displays it.	
function addNewDevice(newDeviceDialog){
	var deviceName = $("#deviceName").val();
	var deviceIP = $("#deviceIP").val();
	var deviceNote = $("#deviceNote").val();			
	//alert(deviceName + deviceIP + deviceNote);	
	var postData = {
		addNewDevice:'true',
		deviceName:deviceName,
		deviceIP:deviceIP,
		deviceNote:deviceNote};
	$.ajax({
		type:"POST",
		data : postData,
		url: 'php/grid-backend.php', 
		success: function(result,status,xhr) {
			var message = getMessage(result);
			var display = getDisplay(result);
			if(message.indexOf("DeviceExists") != -1){
				//$(".ui-dialog-title").html("holy crap")
				//alert();
			}
			var ps = getNewGridPositionAndSize(); //Finds where we are supposed to place the new grid.
			var widget = gridster.add_widget( display, ps[0], ps[1], ps[2], ps[3]); //adds a new grid to gridster
			widget = widget.get(0);
			var grow = $(widget).find(".grow");
			alert("message: " + message);
			alert("display: " + display);
		},
		complete: function(result,status,xhr) {
			//alert("complete: " + result);
		},
		error: function(xhr,status,error){
			alert("Error in addNewDevice ajax call: " + error);
		}
	});
	$( newDeviceDialog ).dialog( "close" ); //closes the add new device dialog.
}
		
// Finds the last grid position, and positions a device	at the position of the newDeviceOpener
function getNewGridPositionAndSize(){
	var sizeX = $("#newDeviceOpener").attr("data-sizex");
	var sizeY = $("#newDeviceOpener").attr("data-sizey");
	var posX = $("#newDeviceOpener").attr("data-col");
	var posY = $("#newDeviceOpener").attr("data-row");
	var returnVal = [sizeX, sizeY, posX, posY];
	return returnVal;
}

// Used to be used to load the device, now it only makes sure that when a device is loaded, drag resets. 
function loadDevice(id) {
	if(!dragged){
		//loading the device now happens when user clicks the li[rel]
		//this function only resets the dragged variable now.
	}	// RESET DRAGGED SINCE CLICK EVENT IS FIRED AFTER drag stop
	dragged = 0;
}
		
// Resizes a grid when the user clicks on a "grow button".
$('.grow').on('click', function(event) {
	event.stopImmediatePropagation(); // this stops the overlay from popping up.
	var grid = gridster;
	var widget = $(this).parent();
	var xSize = widget.attr("data-sizex");
	var ySize = widget.attr("data-sizey");
	
	// We need to figure out the size to grow to, based on the current grid size.
	var x = 0;
	var y = 0;
	if(xSize == 1 && ySize == 1){
		x = 2;
		y = 2;
	}else if(xSize == 2 && ySize == 2){
		x = 4;
		y = 2;	
	}else if(xSize == 4 && ySize == 2){
		x = 4;
		y = 4;
	}else{ // do nothing, we are as big as we get.
		x = xSize;
		y = ySize;	
	}
	
	var can = $(widget).children(".device_record").children("canvas");
	var data = updateGridGraphData(can, x, y); // Redraw the Canvas charts in this grid.		
	if(y == 4){ //If our grid is 4 rows high, we want to show the hourly graph as well.
		updateGridGraphData(can[1], x, y); // Get info from server and draw the hourly graph.
		$(can[1]).show(); //make sure it's visible
	}else{
		updateGridGraphData(can[1], x, y); //draw the hourly graph even if it's hidden in this case.
		$(can[1]).hide();	//make sure it's invisible
	}
	grid.resize_widget(widget, x, y, true); // Resizes the grid itself. May want to do this before redrawing the graphs.
}); // End of grow code.
	
// Resizes a grid widget whenever a user clicks it's "shrink button"	
$('.shrink').on('click', function(event) {
	event.stopImmediatePropagation(); // Stop the device.php page from popping up when shrink button is clicked.
    var grid = gridster;
	var widget = $(this).parent();
	var xSize = widget.attr("data-sizex");
	var ySize = widget.attr("data-sizey");
	
	//Figure out what size to shrink the widget to based on its current size.
	var x = 0;
	var y = 0;
	if(xSize == 1 && ySize == 1){ //we are as small as we get, keep this size.
		x = xSize;
		y = ySize;	
	}else if(xSize == 2 && ySize == 2){
		x = 1;
		y = 1;	
	}else if(xSize == 4 && ySize == 2){
		x = 2;
		y = 2;
	}else{ // do nothing, we are as big as we get.
		x = 4;
		y = 2;	
	} 
	
	// Get the graph on this widget and update it.
	var can = $(widget).children(".device_record").children("canvas");
	var data = updateGridGraphData(can, x, y); // Retrieve data from server and display on graph.
	if(y == 4){ // A widget with 4 rows should display the hourly graph as well as the minute one.
		updateGridGraphData(can[1], x, y); // Get info from server and draw the hourly graph.
		$(can[1]).show(); //make sure it's visible
	}else{
		$(can[1]).hide();	//make sure it's invisible
	}
	grid.resize_widget(widget, x, y, true); // Resize the widget itself. May want to put this before the drawing code above.
}); //End of Shrink event.

// Event Called when user opens a device. This load's and overlays the device.php page over grid.php.			  
$("li[rel]").overlay({
	top:top,
	mask: 'darkred',
	effect: 'apple',
	fixed: false,
	top: '1%',
	onBeforeLoad: function() {
		if(!dragged){
			$('.menu').fadeOut(); // The menu button should fade out on the main page and appear on the second page.
			clearTimeout(gridGraphTimeOut); // disable updating of the main page, when second page is open.
			var wrap = this.getOverlay().find(".contentWrap"); // grab wrapper element inside content
			console.log(wrap);
			wrap.load(this.getTrigger().attr("href")); // load the page specified in the trigger (the device clicked) to the overlay		
		}
	},
	onClose: function() {
		$('.menu').fadeIn(); // Fade the menu button back in when the overlay is closed.
		gridGraphTimeOut = setTimeout(updateGridGraphs, 5000); // Re-allow updating of main page when second page closes.
		
		// Are we re-initializing gridster here? Do we need to do this?
		gridster = $("#frontGrid > ul").gridster({
			widget_margins: [5, 5],
			widget_base_dimensions: [95, 95],
			min_cols: 8,
			draggable: {
				start: function(event, ui) {
					dragged = 1;
				}
			}
		}).data('gridster');	
	}// End onClose.
}); // End overlay Event.
		
// Contructs and adds a new device dialog to the screen.
$( "#newDeviceDialog" ).dialog({
	autoOpen: false,
	show: {
		effect: "blind",
		duration: 1000
	},
	hide: {
		effect: "explode",
		duration: 1000
	},
	buttons: [ { text: "Add Device", click: function() { addNewDevice(this); } } ]
}); //End of newDeviceDialog.

// Handles when a user clicks on the new Device Button.
$( "#newDeviceOpener" ).click( function(event) {
	//alert("newDeviceOpening");
	$( "#newDeviceDialog" ).dialog( "open" ); // Opens the new device dialog.
}); // End of newDeviceOpener click handler

// Event Handler when a user clicks on the menu. Opens the menu.
$('.menu').click(function() {
	$('nav').addClass('open');
	$('body').addClass('menu-open');
	return false;
});

$(".scrollable").scrollable({ vertical: true, mousewheel: true });

// Event Handler when a user clicks anywhere but the menu, when the menu is open. Closes the menu.
$(".grid").click(function() {
	
	$('body').removeClass('menu-open');
	$('nav').removeClass('open');
});	

// Event Handler called when document is first loaded. Intializes the update of the grid graphs.
$(document).ready(function() {
	setTimeout('updateGridGraphs()',10);
});			 

// Query the server and redraw a specific graphs data. 
function drawGridGraph(c, data, col, row){
	var array_data = String(data).split(" "); // Seperate the data into an array.
	var parent = $(c).parent(); // The Canvas' Parent
	var grandparent = $(parent).parent(); //The Canvas' Grandparent.
	var width = $(grandparent).width(); // We need the Grandparents dimensions to know the canvas' limits.
	var height = $(grandparent).height();
	var widthLimit = width;
	var heightLimit = height;
	// The problem is, we aren't checking if this is a 2nd image, it's taking
	// the value from the hour table.
	if(array_data[0] == "737"){
		var hello = "hello";
	} 
	if(!$(c).hasClass("secondImage")){ // we don't want to update color when hour graph is processed
		updateMSDisplay(c, array_data[0]); // Updates the Milli-seconds label in the widget.
		updateGridColor(c, array_data[0]); // Updates the grid's color based on the latest millisecond reading.
	}
	
	// Calculate the Graph/Canvas' limits from the widgets column and row sizes.
	if(col == 1 && row == 1){
		height = 150;
		heightLimit = 50;
		width = 150;
		widthLimit = 120;
	}else if(col == 2 && row == 2){
		height = 130;
		heightLimit = 130;
		width = 400;
		widthLimit = 400;
	}else if(col == 4 && row == 2){
		width = 400;
		widthLimit = 400;
		height = 130;
		heightLimit = 130;
	}else if(col == 4 && row == 4){
		width = 400;
		widthLimit = 400;
		height = 120;
		heightLimit = 120;
	}
	
	c.height = height; // Set the dimension of the graph to the calculated limits.
	c.width = width;
	
	var context = c.getContext('2d');
	var sections = widthLimit / array_data.length-1; // How many seconds the graph has is based on how much data we retrieve from server.
	context.beginPath(); // Begin drawing the graph to the canvas.
	if(arrayIsZero(array_data)){ // If array only has zero's in it, draw a single dead line, denoting a unreachable device.
		context.moveTo(0, heightLimit-0); // We do heightLimit-0 to reverse the up/down orientation of the graph.
		context.lineTo(sections * 22, heightLimit-0);
		context.strokeStyle = "#FF0000";
	}else{ // Ff array has data in it, draw that
		var newValue;
		for(var i = 0; i < array_data.length-1; i++){ // Loop through the data, drawing each line.
			newValue = map(array_data[i], Math.min.apply(Math, array_data), Math.max.apply(Math, array_data), 0, heightLimit);
			if(i == 0){ //First data point in the data set.
				context.moveTo(widthLimit-(sections * i), heightLimit-newValue);
			}else{
				context.lineTo(widthLimit-(sections * i), heightLimit-newValue);
			}	
		}
		context.strokeStyle = "#FFFFFF";
	}
	context.lineWidth = 2;
	context.stroke();	
}

// Updates the Millisecond display on a widget
function updateMSDisplay(canvas, newPing){
	var h3 = $(canvas).siblings("h3");
	$(h3).text(newPing+"ms")
	//alert($(h3).text(newPing));
}

/** Updates the grid's color based on the latest data received. */
function updateGridColor(canvas, newPing){
	var blueLimit = 700; // The limit below which the widget will display blue. We will later retrieve these values from a db.
	var yellowLimit = 2000; // The limit below which the widget will display yellow. Above this it will display red.
	var newClass; // The color we are adding to the widgets class.
	if(newPing == 0 || newPing > yellowLimit){
		newClass = 'red';
	}else if(newPing < blueLimit){
		newClass = '';
	}else if(newPing <= yellowLimit){
		newClass = 'yellow';
	}
	
	//Find the widget this canvas is in, and add the correct class to it, turning it the correct color.
	var grandParent = $(canvas).parent().parent();
	$(grandParent).removeClass("red");
	$(grandParent).removeClass("yellow");
	$(grandParent).addClass(newClass);
}

/** Returns true if every data value in the passed in array is 0, false if else. */
function arrayIsZero(a){
	var answer = true;
	for(var i = 0; i < a.length; i++){
		if(a[i] != 0){
			answer = false;
		}			
	}
	return answer;
}

/** Uses ajax to get our grid graph data from the server. */
function updateGridGraphData(canvas, x, y){
	var returnVal = "";
	returnVal = (function worker() { // Start a worker thread to grab the data so we don't freeze anything on our page.
		var currentIP = $(canvas).attr("id");
		var curClass = $(canvas).attr("class");
		var s_curClass = String(curClass);
		
		if(s_curClass.indexOf("secondImage") == -1){ //We don't need to get info for the hour graph, but the minute graph
			postData = {getGridGraphData:true,
						ip:currentIP,
						timeRange:"fiveMinute"};
		}else{ // We do need to get information from the hour graph.
			postData = {getGridGraphData:true,
						ip:currentIP,
						timeRange:"hour"};
		}
		 
		 // Send the request to the server.
		$.ajax({
			type:"POST",
			data : postData,
			url: 'php/grid-backend.php', 
			success: function(result,status,xhr) {
				drawGridGraph(canvas, result, x, y); // We received our data, go head and draw the appropriate graph.
			},
			complete: function(result) {
				// Schedule the next request when the current one's complete
				//alert("complete" + result);
			},
			error: function(xhr,status,error){
				alert("error" + error);
			}
		}); // End of ajax call.
	})(canvas, x, y); //End of worker thread.
} //End of updateGridGraphData

/** Updates all the graphs on page from info retrieved from the device-backend. */
function updateGridGraphs(){
	var canvases = $("canvas");
	for(var i = 0; i< canvases.size(); i++){ //Loop through every canvas on the page.
		var c = canvases.get(i);
		var parent = c.parentElement;
		var grandparent = parent.parentElement;
		var col = $(grandparent).attr("data-sizex");
		var row = $(grandparent).attr("data-sizey");
		var id = c.id;
		var isVisible = $(c).is(":visible"); //may need to change this line to something else checking if it's hidden.
		if(isVisible){ //If the device is visible, draw it.
			var gridData = updateGridGraphData(c, col, row);
			//drawGridGraph(c, gridData, col, row);
		}
	}
	clearTimeout(gridGraphTimeOut); // Remove the timer and re-add it. Why?
	gridGraphTimeOut = setTimeout(updateGridGraphs, 5000);
} 
</script>  
	</body>
</html>
<?php else: header("Location: login.php"); die();	?>
<?php endif;?>