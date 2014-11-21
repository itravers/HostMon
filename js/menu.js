/**
 * Used by the slide out menu
 */
var menuTimeout; // Will control if we are updating menu or not.
clearTimeout(gridGraphTimeOut); // Remove the timer and re-add it. Why?
gridGraphTimeOut = setTimeout(updateGridGraphs, 5000);

// Event Handler when a user clicks on the menu. Opens the menu.
$('.menu').click(function() {
	$('nav').addClass('open');
	$('body').addClass('menu-open');
	return false;
});

//Event Handler when a user clicks anywhere but the menu, when the menu is open. Closes the menu.
$(".grid").click(function() {
	
	$('body').removeClass('menu-open');
	$('nav').removeClass('open');
});	

/** Sets the menu's specific menu items, parses with json. */
function setMenuData(data){
	var jsonData = JSON.parse(data);
	for(var i = 0; i < jsonData.length; i++){
		var nameSelector = jsonData[i].name;
		var name = $(' '+nameSelector);
		var value = $(' '+jsonData[i].value);
		var description = $(' '+jsonData[i].description);
		$('.'+nameSelector).val(value.selector);
	}	
}

/** Retrieves the several menu config settings
 *  from the backend through a ajax and php db call.
 *  populates the values in the menu.
 */
function setMenuConfigInfo(){ // Called by grid.php and device.php document ready.
	(function worker() { // Start a worker thread to grab the data so we don't freeze anything on our page.
		postData = {getConfigData:true};
		 // Send the request to the server.
		$.ajax({
			type:"POST",
			data : postData,
			url: 'php/menu-backend.php', 
			success: function(result,status,xhr) {
				setMenuData(result);
			},
			complete: function(result) {
				// Schedule the next request when the current one's complete
				//alert("complete" + result);
			},
			error: function(xhr,status,error){
				alert("error" + error);
			}
		}); // End of ajax call.
	})(); //End of worker thread.
	/*
	var list = $(".config_list");
	var children = $(list).children();
	var averageGoalTime = $('.averageGoalTime');
	var startingThreads = $('.startingThreads');
	var maxThreads = $('.maxThreads');
	var threadRemovalCoefficient = $('.threadRemovalCoefficient');
	var threadAddCoefficient = $('.threadAddCoefficient');
	var runPerThreadCheck = $('.runPerThreadCheck');
	var numPingRunsBeforeDBRecord = $('.numPingRunsBeforeDBRecord');
	var minuteRecordAgeLimit = $('.minuteRecordAgeLimit');
	var hourRecordAgeLimit = $('.hourRecordAgeLimit');
	var dayRecordAgeLimit = $('.dayRecordAgeLimit');
	var weekRecordAgeLimit = $('.weekRecordAgeLimit');
	var newestPingMinutes = $('.newestPingMinutes');
	var newestPingHours = $('.newestPingHours');
	var newestPingDays = $('.newestPingDays');
	var newestPingWeeks = $('.newestPingWeeks');
	
	$(averageGoalTime).val("10");
	$(startingThreads).val("10");
	$(maxThreads).val("10");
	$(threadRemovalCoefficient).val("10");
	$(threadAddCoefficient).val("10");
	$(runPerThreadCheck).val("10");
	$(numPingRunsBeforeDBRecord).val("10");
	$(minuteRecordAgeLimit).val("10");
	$(hourRecordAgeLimit).val("10");
	$(dayRecordAgeLimit).val("10");
	$(weekRecordAgeLimit).val("10");
	$(newestPingMinutes).val("10");
	$(newestPingHours).val("10");
	$(newestPingDays).val("10");
	$(newestPingWeeks).val("10");
	*/
	
}