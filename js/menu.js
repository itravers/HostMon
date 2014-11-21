/**
 * Used by the slide out menu
 */

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

/** Retrieves the several menu config settings
 *  from the backend through a ajax and php db call.
 *  populates the values in the menu.
 */
function setMenuConfigInfo(){ // Called by grid.php and device.php document ready.
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
	
	
}