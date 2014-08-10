<?php
/* Renders the device page and delivers it to user */
error_reporting(-1);
	include_once("php/db.php");
	$loggedIn = true;
	$_GET['ip'] = "earlhart.com";
	$ip = $_GET['ip'];
	$deviceID = getDeviceID($ip);
	$deviceName = getDeviceName($deviceID);
	$notes = getNotes($deviceID);
	$page = buildPage($deviceID, $deviceName, $ip, $notes);
	printPage($page);
	
	
	
	function buildPage($deviceID, $deviceName, $ip, $notes){
		$page = "";
		$header = buildHeader($deviceName, $ip);
		$body = buildBody($deviceID, $deviceName, $ip, $notes);
		$footer = buildFooter();
		$page = $header.$body.$footer;
		return $page;
	}
	
	function buildHeader($deviceName, $ip){
		$returnVal = "
			<!DOCTYPE html>
			<html class='main_device'>
		  		<head>
			  		<title>".$deviceName." - ".$ip."</title>
			  		<link rel='stylesheet' type='text/css' href='css/gridster.css'>
			  		<link rel='stylesheet' type='text/css' href='css/styles.css'>  
		  		</head>";
		return $returnVal;
	}
	
	function buildBody($deviceID, $deviceName, $ip, $notes){
		$returnVal = "";
		$openTag = "<body>";
		$menu = buildMenu();
		$grid = buildGrid($deviceID, $deviceName, $ip, $notes);
		$scripts = buildScripts($ip);
		$closingTag = "</body>";
		$returnVal = $openTag.$menu.$grid.$scripts.$closingTag;
		return $returnVal;
	}
	
	function buildScripts($ip){
		$returnVal = "
		 <script type='text/javascript' src='js/jquery.tools.min.js'></script>
      <script type='text/javascript' src='js/jquery.gridster.min.js' charster='utf-8'></script>
      <script src='js/hostmonChart.js'></script>
      <script src='js/Chart.min.js'></script>
      <script type='text/javascript'>
	      var gridster;
		  var dragged = 0;
		  
		  var demoData = getMinuteDemoData();
	   		var mainDeviceChart = getMainDeviceChart('FiveMinuteLine', '#51bbff', demoData);
		  
		  $('#accordion').tabs(
			'#accordion div.pane',
			{tabs: 'h2', effect: 'slide', initialIndex: null}
		  );
		  
		   $('#accordion2').tabs(
			'#accordion2 div.pane',
			{tabs: 'h2', effect: 'slide', initialIndex: null}
		  );
		  
		   $('#accordion3').tabs(
			'#accordion3 div.pane',
			{tabs: 'h2', effect: 'slide', initialIndex: null}
		  );
		  
		  function setLineChart(name){
			 currentLineChart = name; 
			 quickUpdateGraph(); 
		  }
		  
		  function setPolarChart(name){
			  var c = document.getElementById(name);
			  currentPolarChart = name;
			  if(currentPolarChart == 'MinutePolar'){
				 polarChart = minPolarChart; 
			  }else if(currentPolarChart == 'HourPolar'){
				 polarChart = hourPolarChart; 
			  }else if(currentPolarChart == 'DayPolar'){
				  polarChart = dayPolarChart;
			  }
			  
			 // alert(name);
			  quickUpdateGraph();
		  }
		  
		  $( document ).ready(function() {
			console.log( 'ready!' );
			
			setupCharts('".$ip."');
			
			setTimeout('updateGraph()',10);

			

		});
		  
		  function loadDevice(id) {
			   if(!dragged){
					//alert('loadDevice ' + id);
				}
				
				 // RESET DRAGGED SINCE CLICK EVENT IS FIRED AFTER drag stop
				dragged = 0;
			
		}

          $(function() {
			  //make the menu clickable. Set it to open menu.
			  $('.menu').click(function() {
				$('nav').addClass('open');
				$('body').addClass('menu-open');
				return false;
				});
				
				//make menu close when document is clicked.
				$(document).click(function() {
				$('body').removeClass('menu-open');
				$('nav').removeClass('open');
				});
				
			  $('.scrollable').scrollable({ vertical: true, mousewheel: true });
			  
              gridtster = $('.device .gridster > ul').gridster({
                  widget_margins: [5, 5],
                  widget_base_dimensions: [95, 95],
                  min_cols: 10,
				  draggable: {
					start: function(event, ui) {
			
						dragged = 1;
						// DO SEOMETHING
					}
				}
				 
              }).data('gridster');
          });
		  
		  
		  
      </script>	";
      return $returnVal;
	}
	
	function buildGridOpening(){
		$returnVal = "
			<section class='device'>
				<div class='gridster'>
              		<ul class='gridlist'>";
		return $returnVal;	
	}
	
	function buildNameGrid($deviceName, $ip){
		$returnVal = "
			<li data-row='1' data-col='1' data-sizex='4' data-sizey='1' onclick='loadDevice('0');'>
			<h1>".$deviceName."</h1>
			<h2>".$ip."</h2></li>";	
		return $returnVal;
	}
	
	function buildMenuGrid(){
		$returnVal = "
			<li class='gridmenu' data-row='1' data-col='5' data-sizex='2' data-sizey='1'>
				<a class='menu' href='#'>
					<div class='bar'></div>
					<div class='bar'></div>
					<div class='bar'></div>
				</a>
			</li>";
		return $returnVal;	
	}
	
	function buildNotesOpening(){
		$returnVal = "
		<li data-row='1' data-col='7' data-sizex='4' data-sizey='3' id='actions'>    
				<!-- root element for scrollable -->
				<div class='scrollable vertical'>
					<!-- root element for the scrollable elements -->
					<div class='items' id='accordion3'>
						<!-- first element. contains three rows -->
						<div>";
		return $returnVal;	
	}
	
	function buildNotesClosing(){
		$returnVal = "
						</div>
					</div>
				</div>
				<img src='images/up-arrow.png' class='prev'></img>
				<img src='images/down-arrow.png' class='next'></img>
				<img class='plus' src='images/plus.png'></img>
		</li>";
		return $returnVal;	
	}
	
	function buildNoteItems($notes){
		$returnVal = "";
		$i = 0;
		$current = "";
		$display = "";
		foreach ($notes as $note){
			if($i == 0){
				$current = "current";	
				$display = "block";
			}else{
				$current = "";
				$display = "none";	
			}
			$returnVal = $returnVal."
				<h2 class='item ".$current."'>
					<div id='notenum'>".(1+$i)."</div>
					<div id='notename'>".$note['username']."</div>
					<div id='notedate'>".$note['date']."</div>
					<div id='notetime'>".$note['time']."</div>
					<img class='minus' src='images/minus.png'></img>
				</h2>
				<div class='pane' style='display:".$display."'>".$note['content']."</div>";	
			$i++;
		}
		
		return $returnVal;	
	}
	
	function buildNotesGrid($notes){
		$notesOpening = buildNotesOpening();
		$noteItems = buildNoteItems($notes);
		$noteClosing = buildNotesClosing();
		$returnVal = $notesOpening.$noteItems.$noteClosing;
		return $returnVal;
	}
	
	function buildLineChartGrid(){
		$returnVal = "
			<li data-row='2' data-col='1' data-sizex='6' data-sizey='5'>
				<div id='accordion'>
					<h2 class='current' onClick=\"setLineChart('FiveMinuteLine')\">5 Minutes / 15 Seconds</h2>
					<div class='pane' style='display:block'><canvas id='FiveMinuteLine' width='600px' height='425px'></div>
					<h2 onClick=\"setLineChart('HourLine')\">1 Hour / 5 Minutes</h2>
					<div class='pane'><canvas id='HourLine' width='600px' height='425px'></div>
					<h2 onClick=\"setLineChart('DayLine')\">1 Day / 1 Hour</h2>
					<div class='pane'><canvas id='DayLine' width='600px' height='425px'></div>
				</div>
			</li>";
		return $returnVal;	
	}
	
	function buildPolarChartGrid(){
		$returnVal = " 
			<li data-row='4' data-col='7' data-sizex='4' data-sizey='3'>
				<div id='accordion2'>
					<h2 class='current' onClick=\"setPolarChart('FiveMinutePolar')\">5 Minutes / 15 Seconds</h2>
					<div class='pane' style='display:block'><canvas id='FiveMinutePolar' width='440px' height='280px'></div>
					<h2 onClick=\"setPolarChart('HourPolar')\">1 Hour / 5 Minutes</h2>
					<div class='pane'><canvas id='HourPolar' width='430px' height='255px'></div>
					<h2 onClick=\"setPolarChart('DayPolar')\">1 Day / 1 Hour</h2>
					<div class='pane'><canvas id='DayPolar' width='420px' height='230px'></div>
				</div>
			</li> ";
		return $returnVal;	
	}
	
	function buildGridClosing(){
		$returnVal = "
					</ul>
				</div>
			</section>";
		return $returnVal;	
	}
	
	function buildGrid($deviceID, $deviceName, $ip, $notes){
		$returnVal = "";
		$gridOpening = buildGridOpening();
		$nameGrid = buildNameGrid($deviceName, $ip);
		$menuGrid = buildMenuGrid();
		$notesGrid = buildNotesGrid($notes);
		$lineChartGrid = buildLineChartGrid();
		$polarChartGrid = buildPolarChartGrid();
		$gridClosing = buildGridClosing();
		$returnVal = $gridOpening.$nameGrid.$menuGrid.$notesGrid.$lineChartGrid.$polarChartGrid.$gridClosing;
	 	return $returnVal;
	}
	
	function buildMenu(){
		$returnVal = "
			<nav class='left'>
				<ul>
					<li>
						<a href='#'>Home</a>
					</li>
					<li>
						<a href='#'>Options</a>
					</li>
					<li>
						<a href='#'>Logout</a>
					</li>
				</ul>
			</nav>";
		return $returnVal;
	}
	
	function buildFooter(){
		$returnVal = "
			</html>";
		return $returnVal;	
	}
	
	function printPage($page){
		echo $page;
	}
	
	function getDeviceID($ip){
		$con = openDB();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT id FROM `Devices` WHERE ip = '".$ip."'";
		$result = mysqli_query($con,$sql);
		$id = '';
		while($row = mysqli_fetch_array($result)) {
			$id = $row['id'];
		}
		return $id;	
	}
	
	function getDeviceName($deviceID){
		$con = openDB();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT name FROM `Devices` WHERE id = '".$deviceID."'";
		$result = mysqli_query($con,$sql);
		$name = '';
		while($row = mysqli_fetch_array($result)) {
			$name = $row['name'];
		}
		return $name;
	}
	
	function getUserName($id){
		$con = openDB();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT usr FROM `Users` WHERE id = '".$id."'";
		$result = mysqli_query($con,$sql);
		$name = '';
		while($row = mysqli_fetch_array($result)) {
			$name = $row['usr'];
		}
		return $name;
	}
	
	function getFormattedDate($timestamp){
		$returnVal = date("M d Y", ($timestamp/1000));
		//$returnVal = "June 9 1985";
		return $returnVal;	
		
	}
	
	function getFormattedTime($timestamp){
		$returnVal = date("g i A", ($timestamp/1000));
		return $returnVal;	
	}
	
	function getNotes($deviceID){
		
		$con = openDB();
		mysqli_select_db($con,"HostMon");
		$sql="SELECT * FROM `notes` WHERE deviceID = '".$deviceID."'";
		$result = mysqli_query($con,$sql);
		$returnArray = Array();
		while($row = mysqli_fetch_array($result)) {
			//$name = $row['name'];
			array_push($returnArray, $row);
		}
		//return $name;
		//echo print_r($returnArray);
		$notes = Array();
		foreach($returnArray as $item){
			$note = array("username" => getUserName($item['userID']), "date" => getFormattedDate($item['timestamp']), "time" => getFormattedTime($item['timestamp']), "content" => $item['content']);
			array_push($notes, $note);
		}
		
		
		
		//echo print_r($notes);
		return $notes;	
	}




?>