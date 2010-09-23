$(document).ready(function(){
	
	// Ajout d'accesseur pour la lib google
	$.fn.extend({
		moveToMarker: function(lat, lng){
			
			// on ferme les autres info bulles
			var zIndex = $(".gmap-info-bulle").parent().parent().parent().parent().css("z-index");
			$("div", $(".gmap-info-bulle").parent().parent().parent().parent().parent().parent()).each(function() {
				if($(this).css("z-index") == zIndex) {
					$(this).remove();
				}
			});
			
			// on centre la map
			var marker = new google.maps.LatLng(lat, lng);
			map.setCenter(marker);
			
			// on attend que la pop in s'ouvre et on applique la fonction
			setTimeout('$.fn.refreshInfoBulles()',700);
			
		},
		
		refreshInfoBulles: function(){
			$(".gmap-info-bulle").each(function() {
				if($("button.addTree", this).length) {
					var idProgramme = $("button.addTree", this).attr('programme');
					if($("button.addTree[programme='"+idProgramme+"']", $("form[name='plant']")).hasClass('green')) {
						$("button.addTree", this).removeClass('grey').addClass('green');
					}
				}
				if($("button.removeTree", this).length) {
					var idProgramme = $("button.removeTree", this).attr('programme');
					if($("button.removeTree[programme='"+idProgramme+"']", $("form[name='plant']")).hasClass('green')) {
						$("button.removeTree", this).removeClass('grey').addClass('green');
					}
				}
			});
		}
	});

	var hiddenTotalLeft = $('input:hidden[name="nbArbresToPlantLeft"]');
	var totalMax = parseInt($('input:hidden[name="nbTreeMax"]').val());
	
	// gestion de la plantation
	$("button.addTree, button.removeTree").live("click", function(e){
		
		e.preventDefault();
		
		var idProgramme = $(this).attr('programme');
		var hiddenProgrammeTotal = $('input:hidden[name="nbArbresProgrammeHidden_'+idProgramme+'"]');
		var totalProgramme = parseInt(hiddenProgrammeTotal.val());
		var totalLeft = parseInt(hiddenTotalLeft.val());
		
		if($(this).hasClass('addTree')) {
			if(totalLeft == 0) {
				return;
			}
			var newTotalProgramme = totalProgramme + 1;
			var newTotalLeft = totalLeft - 1;
		}
		else {
			if(totalLeft == totalMax || totalProgramme == 0) {
				return;
			}
			var newTotalProgramme = totalProgramme - 1;
			var newTotalLeft = totalLeft + 1;
		}
				
		// changement du total d'arbres à planter
		$('.nbArbresToPlantLeft').html(newTotalLeft);
		hiddenTotalLeft.val(newTotalLeft);
		
		$("button.addTree")
			.removeClass((newTotalLeft > 0) ? 'gray' : 'green')
			.addClass((newTotalLeft > 0) ? 'green' : 'gray');
		
		$('input:submit[name="submitArbresProgramme"]')
			.removeClass((newTotalLeft > 0) ? 'green' : 'gray')
			.addClass((newTotalLeft > 0) ? 'gray' : 'green');
		
		// modification du nombre d'arbres à planter sur ce programme
		hiddenProgrammeTotal.val(newTotalProgramme);
		$('.nbTree[programme="'+idProgramme+'"]').html("("+newTotalProgramme+")");
		
		$('.removeTree[programme="'+idProgramme+'"]')
			.removeClass((newTotalProgramme > 0) ? 'gray' : 'green')
			.addClass((newTotalProgramme > 0) ? 'green' : 'gray');
				
	});
	
	//~ // mode de visualisation de la gMap
	$("input[type=radio][name='gMapMode']", $("#gmapWrapper")).live("change", function(e){
		var mode = $(this).val();
		
		if(mode != '') {
			for(x in gMapModes) {
				if(gMapModes[x].name == mode) {
					for(programme in gMapModes[x].values) {
						
						var nbTree = gMapModes[x].values[programme];
						var div = $('div[title="'+programme+'"]', '#map');
						
						if(div.position() != null) {
							div.parent().find('span.nbTreeMap[title="'+programme+'"]').remove();
							var zIndex =  parseInt(div.css('z-index')) + 1;
							var left = (div.position().left + 13) + 'px';
							var top = (div.position().top + 12) + 'px';
							
							div.parent().append('<span title="'+programme+'" style="z-index:'+zIndex+';left:'+left+';top:'+top+';" class="nbTreeMap">'+nbTree+'</span>');
						}
					}
					
					
				}
			}
		}		
	});
	
	setTimeout(function(){$("input:checked[type=radio][name='gMapMode']").trigger("change");},400);
	
	
});
