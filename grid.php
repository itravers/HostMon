<!DOCTYPE html>
<?php  
	/**************************************************************
	 * Hostmon - grid.php
	 * Author - Isaac Assegai
	 * This page allows the user to actively or passively monitor
	 * Several devices at one time. The user has the ability to 
	 * re-arrange the page and resize the interface to the different
	 * devices being monitored.
	 */
	include_once("php/functions.php");
	include_once("php/db.php");
	
	$userName;
	
	//this is really a bad idea to check if we are logged in with a get variable, 
	//can't seem to get the session variable to set in login-backend.php like i was planning
	if(isset($_GET['login'])){
		$userName = $_GET['userName'];
		session_start();
		$_SESSION = $userName;
		//echo "logged in";
	}else if(isset($_SESSION)){
		$userName = $_SESSION['userName'];
		//echo "logged in";
	}else{
		$userName = "NOT LOGGED IN";
	}
	
	
	$pageTitle = "Hostmon - ".$userName;
	$devices = getActiveDevices($userName); // returns the initial active devices
	$gridPositions = getGridPositions(count($devices)); // returns a 2d array with initial grid positions and sizes 
?>

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
				<li><a href="#">Home</a></li>
				<li><a href="#">Options</a></li>
        		<li><a href="login.php?logout=true">Logout</a></li>
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
        
<script src="js/jquery.tools.min.js"></script>
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
		
		 
		  
		c = initializeCanvas("can1");
		for(i = 0; i < c.length; i++){
			canvas = c[i];
			canvas.height = canvas.width/3;
            colorCanvas(canvas, "#51bbff");
            drawGraph(canvas);
		}
		
		function getMessage(result){
			var message = result.substring(0, result.indexOf("|"));	
			return message;
		}
		
		function getDisplay(result){
			var display = result.substring(result.indexOf("|")+1, result.length);
			return display;	
		}
		
		function addNewDevice(newDeviceDialog){
			var deviceName = $("#deviceName").val();
			var deviceIP = $("#deviceIP").val();
			var deviceNote = $("#deviceNote").val();
			
			//alert(deviceName + deviceIP + deviceNote);	
			
			var postData = {addNewDevice:'true',
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
				var ps = getNewGridPositionAndSize();
				var widget = gridster.add_widget( display, ps[0], ps[1], ps[2], ps[3]);
				widget = widget.get(0);
				var grow = $(widget).find(".grow");
				alert("message: " + message);
				alert("display: " + display);
			},
			complete: function(result,status,xhr) {
				//alert("complete: " + result);
			},
			error: function(xhr,status,error){
				alert("error: " + error);
			}
		});
			
			
			$( newDeviceDialog ).dialog( "close" ); 
			
		}
		
		function getNewGridPositionAndSize(){
			//finds the last grid position, and positions a device	at the position of the newDeviceOpener
			var sizeX = $("#newDeviceOpener").attr("data-sizex");
			var sizeY = $("#newDeviceOpener").attr("data-sizey");
			var posX = $("#newDeviceOpener").attr("data-col");
			var posY = $("#newDeviceOpener").attr("data-row");
			var returnVal = [sizeX, sizeY, posX, posY];
			return returnVal;
		}
		  
		function loadDevice(id) {
			if(!dragged){
				//loading the device now happens when user clicks the li[rel]
				//this function only resets the dragged variable now.
			}	// RESET DRAGGED SINCE CLICK EVENT IS FIRED AFTER drag stop
			dragged = 0;
		}
		
		
	
		$('.grow').on('click', function(event) {
			//alert("grow");
			event.stopImmediatePropagation(); // this stops the overlay from popping up.
			var grid = gridster;
			var widget = $(this).parent();
			var xSize = widget.attr("data-sizex");
			var ySize = widget.attr("data-sizey");
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
			var data = updateGridGraphData(can, x, y);
			//drawGridGraph(can[0], data, x, y);
			
			
			if(y == 4){ //second graph should be visible
				updateGridGraphData(can[1], x, y);
				$(can[1]).show(); //make sure it's visible
			}else{
			updateGridGraphData(can[1], x, y);
				$(can[1]).hide();	//make sure it's invisible
			}
			grid.resize_widget(widget, x, y, true);
		});
			  
		$('.shrink').on('click', function(event) {
			event.stopImmediatePropagation(); 
            var grid = gridster;
			var widget = $(this).parent();
			var xSize = widget.attr("data-sizex");
			var ySize = widget.attr("data-sizey");
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
			var can = $(widget).children(".device_record").children("canvas");
			var data = updateGridGraphData(can, x, y);
			//drawGridGraph(can[0], data, x, y);
			if(y == 4){ //second graph should be visible
				//drawGridGraph(can[1], data, x, y); //draw it
				$(can[1]).show(); //make sure it's visible
			}else{
				$(can[1]).hide();	//make sure it's invisible
			}
			grid.resize_widget(widget, x, y, true);
      	 });
			  
		$("li[rel]").overlay({
			top:top,
			mask: 'darkred',
			effect: 'apple',
			fixed: false,
			top: '1%',
			onBeforeLoad: function() {
				if(!dragged){
					$('.menu').fadeOut();
					clearTimeout(gridGraphTimeOut); // disable updating of the main page, when second page is open.
					// grab wrapper element inside content
					var wrap = this.getOverlay().find(".contentWrap");
					console.log(wrap);
					// load the page specified in the trigger
					wrap.load(this.getTrigger().attr("href"));
					
				}
			},
			onClose: function() {
				$('.menu').fadeIn();
				gridGraphTimeOut = setTimeout(updateGridGraphs, 5000); //reallow updating of main page when second page closes
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
				
			}
		});
		
		//add new device dialogue.
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
			  
			});
		 
			$( "#newDeviceOpener" ).click( function(event) {
				//alert("newDeviceOpening");
			  $( "#newDeviceDialog" ).dialog( "open" );
			}); 

		$('.menu').click(function() {
			$('nav').addClass('open');
			$('body').addClass('menu-open');
			return false;
		});
		
		$(document).click(function() {
			$('body').removeClass('menu-open');
			$('nav').removeClass('open');
		});	
		
		$(document).ready(function() {
			setTimeout('updateGridGraphs()',10);
		});		
//	});	 

function drawGridGraph(c, data, col, row){
	var array_data = String(data).split(" ");
	var parent = $(c).parent();
	var grandparent = $(parent).parent();
	var width = $(grandparent).width();
	var height = $(grandparent).height();
	var widthLimit = width;
	var heightLimit = height;
	
	updateMSDisplay(c, array_data[0]);
	updateGridColor(c, array_data[0]);
	
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
	
	c.height = height;
	c.width = width;
	
	var context = c.getContext('2d');
	var sections = widthLimit / array_data.length-1;
	context.beginPath();
	if(arrayIsZero(array_data)){ // if array only has zero's in it, draw a single dead line
		//alert("drawing zero line")
		context.moveTo(0, heightLimit-0);
		context.lineTo(sections * 22, heightLimit-0);
		context.strokeStyle = "#FF0000";
	}else{ // if array has data in it, draw that
		var newValue;
		for(var i = 0; i < array_data.length-1; i++){
			newValue = map(array_data[i], Math.min.apply(Math, array_data), Math.max.apply(Math, array_data), 0, heightLimit);
			if(i == 0){
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

//updates the ms display on a grid
function updateMSDisplay(canvas, newPing){
	var h3 = $(canvas).siblings("h3");
	$(h3).text(newPing+"ms")
	//alert($(h3).text(newPing));
}

function updateGridColor(canvas, newPing){
	var blueLimit = 700;
	var yellowLimit = 2000;
	var newClass;
	if(newPing == 0 || newPing > yellowLimit){
		newClass = 'red';
	}else if(newPing < blueLimit){
		newClass = '';
	}else if(newPing <= yellowLimit){
		newClass = 'yellow';
	}
	var grandParent = $(canvas).parent().parent();
	$(grandParent).removeClass("red");
	$(grandParent).removeClass("yellow");
	$(grandParent).addClass(newClass);
	//alert($(grandParent).attr("class"));
}

function arrayIsZero(a){
	var answer = true;
	for(var i = 0; i < a.length; i++){
		if(a[i] != 0){
			answer = false;
			//alert('a['+i+'] = '+a[i]+' : '+answer);
		}			
	}
	
	return answer;
}


/** Uses ajax to get our grid graph data from the server. */
function updateGridGraphData(canvas, x, y){
	var returnVal = "";
	returnVal = (function worker() {
		var currentIP = $(canvas).attr("id");
		var curClass = $(canvas).attr("class");
		//if(curClass == undefined)//return 0;
		//alert("curClass" +curClass);
		var s_curClass = String(curClass);
		//alert(s_curClass);
		if(s_curClass.indexOf("secondImage") == -1){
			postData = {getGridGraphData:true,
						ip:currentIP,
						timeRange:"fiveMinute"};
		}else{
			postData = {getGridGraphData:true,
						ip:currentIP,
						timeRange:"hour"};
		}
		 
		$.ajax({
			type:"POST",
			data : postData,
			url: 'php/grid-backend.php', 
			success: function(result,status,xhr) {
				//alert("result" + result);
				drawGridGraph(canvas, result, x, y);
			},
			complete: function(result) {
				// Schedule the next request when the current one's complete
				//alert("complete" + result);
			},
			error: function(xhr,status,error){
				alert("error" + error);
			}
		});
	})(canvas, x, y);
}

/** Updates the line graph and polar chart from info retrieved from the device-backend. */
function updateGridGraphs(){
	var canvases = $("canvas");
	for(var i = 0; i< canvases.size(); i++){
		var c = canvases.get(i);
		var parent = c.parentElement;
		var grandparent = parent.parentElement;
		var col = $(grandparent).attr("data-sizex");
		var row = $(grandparent).attr("data-sizey");
		var id = c.id;
		var isVisible = $(c).is(":visible")
		if(isVisible){
			var gridData = updateGridGraphData(c, col, row);
			//drawGridGraph(c, gridData, col, row);
		}
	}
	clearTimeout(gridGraphTimeOut);
	gridGraphTimeOut = setTimeout(updateGridGraphs, 5000);
} 
</script>  
	</body>
</html>
