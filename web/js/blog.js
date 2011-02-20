$(document).ready(function(){

  // On masque les programmes du header
  $('div.diapo').not(':first').hide();
  $('div.diapo:first').addClass('selected');

  $('.diaporama a.prevDiapo').click(function() {
    if($('div.diapo.selected').prev('div.diapo').length > 0) {
      $('div.diapo.selected').fadeOut(500, function() {
        $(this).removeClass('selected').prev('div.diapo').fadeIn().addClass('selected');
      });
    }
  });

  $('.diaporama a.nextDiapo').click(function() {
    if($('div.diapo.selected').next('div.diapo').length > 0) {
      $('div.diapo.selected').fadeOut(500, function() {
        $(this).removeClass('selected').next('div.diapo').fadeIn().addClass('selected');}
      );
    }
  });

  // Chargement des éléments précédents / suivants en AJAX
  $('a.loadFromUri').click(function() {
    var self = $(this);
    if(!(self.attr("disabled") == "disabled"))
    {
			self.attr("disabled", "disabled");
			var content = self.parents('div.blocContent');
			var objects = content.children('div.blocObjects')
			// Récupération des éléments voulus en AJAX
			$.ajax({
				url: $(this).attr('href'),
				success: function(data) {
					if(data != '')
						objects.fadeOut(500, function(){
							$(this).empty().append(data).fadeIn(500, function(){
								// Mise à jour des boutons de navigations précédents / suivants
								$('a.prevResults', content).attr('href', $('span.prevResultsUrl', objects).text());
								$('a.nextResults', content).attr('href', $('span.nextResultsUrl', objects).text());
								self.removeAttr("disabled");
							});
						});
					else
						self.removeAttr("disabled");
				}
			});
			
		}
    return false;
  });
  
	// Gestion du menu social
	$('#menu_social').hover(function(){
		$('.sousMenu', '#menu_social').stop(true, true).slideDown('fast');
	}, function(){
		$('.sousMenu', '#menu_social').stop(true, true).slideUp('fast');
	});
  
  	// Gestion du menu principal
 	$('li', '#main-menu').hover(function(){
  		$(this).find('.module').stop(false, true).show();
	}, function(){
  		$(this).find('.module').stop(false, true).hide();
	});

});
