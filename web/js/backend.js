$(document).ready(function(){

	var menuWrapper = $("#menu-wrapper");

	//Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)
	$("ul.subnav", menuWrapper).parent().append("<span></span>"); 
	
	$("#menu li").mouseenter(function() { //When trigger is clicked...

		$(this).find("ul.subnav").slideDown('fast').show();

		$(this).hover(function() {}, function(){
			$(this).find("ul.subnav").slideUp('slow');
		});

	}).hover(function() {
		$(this).addClass("subhover");
	}, function(){
		$(this).removeClass("subhover");
	});

});
