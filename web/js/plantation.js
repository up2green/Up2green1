$(document).ready(function(){
	
	$("ul:first", "#form_programme_plantation").scrollTo( 0 ); 
	size = 5 * $("ul:first > li", "#form_programme_plantation").height();
	
	$("#slideUp").click(function(){
		$("ul:first", "#form_programme_plantation").scrollTo(
			'-=' + size + 'px', 
			{speed:1000, axis:'y', queued:true}
		);
	});
	
	$("#slideDown").click(function(){
		$("ul:first", "#form_programme_plantation").scrollTo(
			'+=' + size + 'px', 
			{speed:1000, axis:'y', queued:true}
		);
	});
});
