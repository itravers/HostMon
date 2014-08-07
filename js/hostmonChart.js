/**
  * Module Responsible for Drawing our canvas graphs, on both the grid page and the device pages.
  * Author: Isaac Assegai
**/	

/** Functions Used for Graphing on the "Device" page.*/

/** Test Data */
function getMinuteDemoData(){
	var data = [
		[1407428139000,0],
		[1407428149000,25],
		[1407428159000,50],
		[1407428169000,75],
		[1407428179000,100],
		[1407428189000,12],
		[1407428199000,75],
		[1407428209000,175],
		[1407428219000,200],
		[1407428229000,111],
		[1407428239000,135],
		[1407428249000,80],
		[1407428259000,75],
		[1407428269000,325],
		[1407428279000,300],
		[1407428289000,375],
		[1407428299000,400],
		[1407428309000,200],
		[1407428319000,170],
		[1407428329000,600],
		[1407428339000,660],
		[1407428349000,620],
		[1407428359000,550],
		[1407428369000,570],
		[1407428379000,60],
		[1407428389000,62],
		[1407428399000,65],
		[1407428409000,67],
		[1407428419000,70],
		[1407428429000,55],
		[1407428439000,35],
		[1407428449000,25],
		[1407428459000,0],
	];
	return data;
}

/** Test Data */
function getMinuteDemoData2(){
	var data = [
		[1407428189000,12],
		[1407428199000,75],
		[1407428209000,175],
		[1407428219000,200],
		[1407428229000,111],
		[1407428239000,135],
		[1407428249000,80],
		[1407428259000,75],
		[1407428269000,325],
		[1407428279000,300],
		[1407428289000,375],
		[1407428299000,400],
		[1407428309000,200],
		[1407428319000,170],
		[1407428329000,600],
		[1407428339000,660],
		[1407428349000,620],
		[1407428359000,550],
		[1407428369000,570],
		[1407428379000,60],
		[1407428389000,62],
		[1407428399000,65],
		[1407428409000,67],
		[1407428419000,70],
		[1407428429000,55],
		[1407428439000,35],
		[1407428449000,25],
		[1407428459000,300],
		[1407428469000,325],
		[1407428479000,400],
		[1407428489000,425],
		[1407428499000,325],
		[1407428509000,400],
	];
	return data;
}

/** Draws the data to the chart using the specified color, then returns a reference to the chart.*/ 
function getMainDeviceChart(name, color, data){
	var c = document.getElementById(name);
	clearCanvas(c);
	drawLabels(c, color, data);
	drawBackgroundGrid(c, color);
	drawData(c, color, data);		
	return c;
}

/** Clears the Canvas */
function clearCanvas(c){
	var ctx = c.getContext("2d");
	ctx.clearRect(0, 0, c.width, c.height);	
}

/** Draws the Data to the chart as lines. */
function drawData(c, color, data){
	//we'll need the min, max latency and time to calculate positions
	var minMaxLatency = getMinMaxLatency(data);
	var minMaxTime = getMinMaxTime(data);
	//we only loop to the second last element. The last line will include the last element.
	for(i =0; i < data.length-1; i++){
		//get the points for this line by translating data to pixels.
		var p1 = translateToPixels(data[i], c, minMaxTime, minMaxLatency);
		var p2 = translateToPixels(data[i+1], c, minMaxTime, minMaxLatency);
		drawLine(c, p1[0], p1[1], p2[0], p2[1], 3, "#ffffff");			
	} 
}

/** Translate a (time, latency) point to a (x, y) pixel*/ 
function translateToPixels(point, c, minMaxTime, minMaxLatency){
	//first we get the width and height of every section of the grid.
	var gridWidth = (c.width/25); 
	var gridHeight = c.height/20;
	//then we set the min and max of the area we want to draw data into.
	//this excludes the area where labels are located.
	var widthMinMax = [(gridWidth*2)+7, (gridWidth*24)+7];
		//we swap heightMinMax to reverse the graph so lower latencies will be lower on the screen.
	var heightMinMax = [gridHeight*17-10, gridHeight*1-10];
	//then we get the x and y point to translate to by mapping our data to our new parameters.
	var tarX = map(point[0], minMaxTime[0], minMaxTime[1], widthMinMax[0], widthMinMax[1]);
	var tarY = map(point[1], minMaxLatency[0], minMaxLatency[1], heightMinMax[0], heightMinMax[1]);	
	//pack the answer into its own array and return.
	var target = [tarX, tarY];	
	return target;
} 
	 
/** translate x from its old range to its new position in the new range */	 
function map(x, in_min, in_max, out_min, out_max){
	return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}
	
/** Draw All Labels for both Axis of Graph. */
function drawLabels(c, color, data){
	labelColor = "#ffffff";
	drawYName(c, labelColor, "LATENCY");
	drawYLabels(c, labelColor, data);
	drawXName(c, labelColor, "TIME");
	drawXLabels(c, labelColor, data);
}
	
/** Draw the background grid.*/
function drawBackgroundGrid(c, color){		
	var gridColor = "#4eb5f7";
	//Decides grid width & height based on how many sections we have in both.
	var gridWidth = c.width/25;
	var gridHeight = c.height/20;
	//draw x horizontal lines.
	for(i = 0; i < 17; i++){
		//we want to draw bottom to top instead of top to bottom, so we subtract the i from total
		j = 17-i;
		drawLine(c, 45, (gridHeight*j)-(gridHeight/2),
		gridWidth*24+7, (gridHeight*j)-(gridHeight/2), 1, gridColor);
	}
	
	//draw Vertical Grid 23 lines
	for(i = 0; i < 23; i++){
		if(i == 10 | i ==11){
			y2 = (gridHeight*17)-10; //make room for the "TIME" label
		}else{
			y2 = (gridHeight*17);	//normal bottom of the line.
		}
		drawLine(c, 55+(gridWidth*i), y2,
					55+(gridWidth*i), (gridHeight*j)-(gridHeight/2), 
					1, gridColor);
	}
}

/* Position and Draw the "Time" label */	
function drawXName(c, color, name){
	var gridHeight = c.height/20;
	var ctx = c.getContext("2d");
	ctx.font = "14px Raavi";
	ctx.fillStyle = color;
	ctx.lineWidth = 1;
	ctx.strokeStyle = color;
	ctx.strokeText(name,(c.width/2)-10,(gridHeight*18)-10);
}

/** Position & Draw An appropriate range of times based on the data.*/	
function drawXLabels(c, color, data){
	// calculate the space between every label based on how many sections are in the grid.
	var gridWidth = c.width/25;
	var ctx = c.getContext("2d");;
	var minMaxTime = getMinMaxTime(data);
	//calculate an average time between each label. Based on the fact there are 23 labels
	var timeGap = (minMaxTime[1] - minMaxTime[0])/23;
	ctx.strokeStyle = color;
	ctx.translate(c.width / 2, c.height / 2);
	ctx.rotate(-Math.PI / 2);
	ctx.translate(-c.width / 2, -c.height / 2);
	ctx.fillStyle = color;
	ctx.font = "12px Raavi";
	//draw 23 labels
	for(i = 0; i < 23; i++){
		j = 23-i;
		thisTime = minMaxTime[0] + (i * timeGap);
		time = new Date(thisTime+i*1000);
		timeDisplay = time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
		ctx.fillText(timeDisplay,90,(gridWidth*i)-30);
	}
	//we do this to rotate the labels, coordinates get translated because of this.
	ctx.translate(c.width / 2, c.height / 2);
	ctx.rotate(Math.PI / 2);
	ctx.translate(-c.width / 2, -c.height / 2);	
	}

/** Draw the Latency Labels. */
function drawYLabels(c, color, data){
	//calculate the difference in height based on 20 total sections
	var gridHeight = c.height/20;
	var ctx = c.getContext("2d");
	ctx.font = "12px Raavi";
	ctx.fillStyle = color;
	ctx.lineWidth = 1;
	ctx.strokeStyle = color;
	//draw 17 labels
	for(i = 0; i < 17; i++){
		j = 17-i;
		ctx.strokeText((50*i),21,((gridHeight*j)));
	}	
}	

/** Returns an array containing the earliest and latest time of the data. */
function getMinMaxTime(data){
	if(data.length >= 1){
		var minTime = data[0][0];
		var maxTime = data[0][0];
	}
	for(i = 0; i < data.length; i++){
		//find the higher numbers.
		if(data[i][0] > maxTime){
			maxTime = data[i][0];
		}
		//look for lower numbers.
		if(data[i][0] < minTime){
			minTime = data[i][0];	
		}
	}
	var minMaxTime = [minTime, maxTime];
	return minMaxTime;
}

/** Returns an array with the minimum and maximum latency in the data.*/
function getMinMaxLatency(data){ 
	if(data.length >= 1){
		var minLatency = data[0][1];
		var maxLatency = data[0][1];	
	}
	
	for(i = 0; i < data.length; i++){
		//look for higher numbers
		if(data[i][1] > maxLatency){
			maxLatency = data[i][1];	
		}
		//look for lower numbers
		if(data[i][1] < minLatency){
			minLatency = data[i][1];	
		}
	}
	var minMaxLatency = [minLatency, maxLatency];
	return minMaxLatency;
}
	
/** Draw and position the "Latency" label. */
function drawYName(c, color, labelName){
	var ctx = c.getContext("2d");
	ctx.lineWidth = 1;
	ctx.strokeStyle = color;
	ctx.translate(c.width / 2, c.height / 2);
	ctx.rotate(-Math.PI / 2);
	ctx.translate(-c.width / 2, -c.height / 2);
	ctx.fillStyle = color;
	ctx.font = "14px Raavi";
	ctx.strokeText(labelName,c.height/2+80,-75);
	ctx.translate(c.width / 2, c.height / 2);
	ctx.rotate(Math.PI / 2);
	ctx.translate(-c.width / 2, -c.height / 2);	
}
	
	
	
/** Functions Used for Graphing on the "Grid" page.*/	

	function initializeCanvas(name){
		var c = document.getElementsByClassName(name);
		return c;
	}
	
	function colorCanvas(canvas, color){
		var ctx = canvas.getContext("2d");
		ctx.fillStyle = color;
		ctx.fillRect(0,0,c.width,c.height);
	}
	
	function drawGraph(canvas){
		var numPoints = 14;
		var widthSections = numPoints + 2;
		var heightSections = 115;
		
		//widthMultiplier & //heightMultipler
		var w = canvas.width/widthSections; 
		var h = canvas.height/heightSections;
		
		drawLine(canvas, w*1, h*100, w*2, h*20);
		drawLine(canvas, w*2, h*20, w*3, h*1);
		drawLine(canvas, w*3, h*1, w*4, h*20);
		drawLine(canvas, w*4, h*20, w*5, h*30);
		drawLine(canvas, w*5, h*30, w*6, h*35);
		drawLine(canvas, w*6, h*35, w*7, h*25);
		drawLine(canvas, w*7, h*25, w*8, h*50);
		drawLine(canvas, w*8, h*50, w*9, h*40);
		drawLine(canvas, w*9, h*40, w*10, h*45);
		drawLine(canvas, w*10, h*45, w*11, h*80);
		drawLine(canvas, w*11, h*80, w*12, h*90);
		drawLine(canvas, w*12, h*90, w*13, h*95);
		drawLine(canvas, w*13, h*95, w*14, h*75);
		
		drawPoint(canvas, w*1, h*100, "#ffffff");
		drawPoint(canvas, w*2, h*20, "#ffffff");
		drawPoint(canvas, w*3, h*1, "#ff0000");
		drawPoint(canvas, w*4, h*20, "#ffffff");
		drawPoint(canvas, w*5, h*30, "#ffffff");
		drawPoint(canvas, w*6, h*35, "#ffffff");
		drawPoint(canvas, w*7, h*25, "#ffffff");
		drawPoint(canvas, w*8, h*50, "#ffffff");
		drawPoint(canvas, w*9, h*40, "#ffffff");
		drawPoint(canvas, w*10, h*45, "#ffffff");
		drawPoint(canvas, w*11, h*80, "#ffffff");
		drawPoint(canvas, w*12, h*90, "#ffffff");
		drawPoint(canvas, w*13, h*95, "#ffffff");
		drawPoint(canvas, w*14, h*75, "#ffffff");
	}
	
	function drawLine(canvas, x1, y1, x2, y2, lineWidth, color){
		y1+=6;
		y2+=6;
		var context = canvas.getContext('2d');
		context.beginPath();
		context.moveTo(x1, y1);
		context.lineTo(x2, y2);
		context.lineWidth = lineWidth;
		// set line color
		context.strokeStyle = color;
		context.stroke();	
	}
	
	function drawPoint(canvas, xPoint, yPoint, color){
		  yPoint += 6;
		  var context = canvas.getContext('2d');
		  var radius = canvas.width/100;
		  context.beginPath();
		  context.arc(xPoint, yPoint, radius, 0, 2 * Math.PI, false);
		  context.fillStyle = color;
		  context.fill();
		  context.lineWidth = 5;
		  context.strokeStyle = color;
		  context.stroke();
	}