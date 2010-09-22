$(document).ready(function(){
	
	// fix ie submit form
	if($.browser.msie) {
		$('input:not(:submit)').keypress(function(e){
			if (e.keyCode == '13') {
				 e.preventDefault();
			 }
		});
	}
	
	// list modules sccrollable	
	$(".scrollableWrapper").each(function() {
		var self = $(this);
		$("ul.scrollable", self).scrollTo( 0 ); 
		var size = $("ul.scrollable", self).height();
		
		$("span.slideUp", self).click(function(){
			$("ul.scrollable", self).scrollTo(
				'-=' + size, 
				{speed:500, axis:'y', queued:true}
			);
		});
	
		$("span.slideDown", self).click(function(){
			$("ul:first", self).scrollTo(
				'+=' + size, 
				{speed:500, axis:'y', queued:true}
			);
		});
	});
	
});
