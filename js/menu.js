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
	var hello = "hello";
	
}