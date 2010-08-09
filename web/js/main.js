$(document).ready(function(){
	/* valeur par défaut dans les input type texte */
	$("input[type=text]").each(function(){
		if($(this).attr('title').length)
		{
			$(this).focus(function(){
				if($(this).val() == $(this).attr('title')){
					$(this).val("");
				}
			});
			$(this).blur(function(){
				if($(this).val() == ""){
					$(this).val($(this).attr('title'));
				}
			});
		}
	});
	/* panel footer "en savoir plus" */
	$("#footer_wrapper").hover(
		function(e){
			$(".content_wrapper", this).stop(true, true).slideToggle("slow");
		},
		function(e){
			$(".content_wrapper", this).stop(true, true).slideToggle("slow");
		}
	);
	/* désactivation des lien mort */
	$('a[href="#"]').each(function(){
		$(this).css({
			color: "#ccc"
		}).click(function(){return false;});
	});
});
