$(document).ready(function(){

	var menuWrapper = $("#menu-wrapper");
	
	//Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)
	$("ul.subnav", menuWrapper).parent().append("<span></span>"); 
	
	$("#menu > li").hover(function(e) {
		$(this).find("ul.subnav").stop(true, true).slideDown('fast');
	}, function(e){
		$(this).find("ul.subnav").slideUp('fast');
	});

});
