	function initializeCanvas(){
		var c = document.getElementsByClassName("can1");
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
	
	function drawLine(canvas, x1, y1, x2, y2){
		y1+=6;
		y2+=6;
		var context = canvas.getContext('2d');
		context.beginPath();
		context.moveTo(x1, y1);
		context.lineTo(x2, y2);
		context.lineWidth = 3;
	
		// set line color
		context.strokeStyle = '#ffffff';
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