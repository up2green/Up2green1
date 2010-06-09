$(document).ready(function(){
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
});
