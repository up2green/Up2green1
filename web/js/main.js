var i = document.createElement('input');
jQuery.support.placeholder = 'placeholder' in i;

$(document).ready(function(){
	
	/* valeur par défaut dans les input type texte */
	if(!$.support.placeholder) {
		$("input[placeholder], textarea[placeholder]").live("focus.html5", function(){
			var $this = $(this);
			if($this.val() == $this.attr('placeholder') && !$this.data('filled')){
				$this.val("").data('filled', true);
			}
		}).live("blur.html5", function(){
			var $this = $(this);
			if($this.val() == ""){
				$this.val($this.attr('placeholder')).data('filled', false);
			}
		}).trigger("blur.html5").closest("form").bind("submit.html5", function(e) {
			if(!e.isDefaultPrevented()) {
				$("input[placeholder], textarea[placeholder]").die('blur.html5');
				$("input[placeholder], textarea[placeholder]",this).trigger('focus.html5');
			}
		});
	}
	
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
	$('a.disabled').click(function(e){e.preventDefault();});
	
	$('a[href="#"]').each(function(){
		$(this).css({
			color: "#ccc"
		}).click(function(){return false;});
	});
		
	if($.browser.msie && parseInt(jQuery.browser.version) <= 6)
	{
		$("body").html("<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'><div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display=\"none\"; return false;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg' style='border: none;' alt='Close this notice'/></a></div><div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'><div style='width: 75px; float: left;'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-warning.jpg' alt='Warning!'/></div><div style='width: 275px; float: left; font-family: Arial, sans-serif;'><div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>Vous utilisez un navigateur dépassé depuis plus de 9 ans!</div><div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>Pour une meilleure expérience web, prenez le temps de mettre votre navigateur à jour.</div></div><div style='width: 75px; float: left;'><a href='http://fr.www.mozilla.com/fr/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-firefox.jpg' style='border: none;' alt='Get Firefox 3.5'/></a></div><div style='width: 75px; float: left;'><a href='http://www.microsoft.com/downloads/details.aspx?FamilyID=341c2ad5-8c3d-4347-8c03-08cdecd8852b&DisplayLang=fr' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-ie8.jpg' style='border: none;' alt='Get Internet Explorer 8'/></a></div><div style='width: 73px; float: left;'><a href='http://www.apple.com/fr/safari/download/' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-safari.jpg' style='border: none;' alt='Get Safari 4'/></a></div><div style='float: left;'><a href='http://www.google.com/chrome?hl=fr' target='_blank'><img src='http://www.ie6nomore.com/files/theme/ie6nomore-chrome.jpg' style='border: none;' alt='Get Google Chrome'/></a></div></div></div>");
	}

	/* Language */
	var langForm = $("form#formLanguage");
	
	$("#language-wrapper").hover(function(e) {
		$(this).find(".flags-hidden").stop(true, true).slideDown('fast');
	}, function(e) {
		$(this).find(".flags-hidden").slideUp('fast');
	});

	$("ul:first img[lang]", langForm).click(function() {
		$('input:hidden[name=language]', langForm).val($(this).attr('lang'));
		langForm.submit();
	});

	/* tooltip */
	$("[title]").mbTooltip({
		opacity : .97,
		wait:50,
		cssClass:"corporate",
		timePerWord:70,
		hasArrow:false,
		hasShadow:false,
		imgPath:"/images/jquery.mb.tooltip/",
		ancor:"mouse",
		shadowColor:"black",
		mb_fade:0
    });

	$(document).enableTooltip();
	
});
