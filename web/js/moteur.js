$(function() {

	var txtReadMore = $("#searchMore").html();
	var IMG = '1';
	var WEB = '2';
	var NEWS = '3';
	var SHOP = '4';
	
    $("#searchMore").click(function(){

		var mode = $('#hidden_moteur_search', '#searchForm').val();
		var nb_pub = $(".pub-result .result").length;
		var nb_affiliate = $(".shop-result .result").length;
		
		$("#searchMore").html('<img src="/images/icons/16x16/ajax-loader.gif" alt="Loading" />');
		
        $.ajax({
            url: 'ajax/moreresults',
            type: 'post',
            dataType: "xml",
            data: {
                'nb_items_affiche': (mode == SHOP) ? $(".result").length : ($(".result").length - nb_pub - nb_affiliate),
                'nb_pub': nb_pub,
                'nb_affiliate': nb_affiliate,
                'text_search': $('#hidden_text_search', '#searchForm').val(),
                'moteur_search': $('#hidden_moteur_search', '#searchForm').val()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$("#searchMore").html(txtReadMore);
            },
            success: function(xml) {
				var firstPub = true;

				$(xml).find('root').each(function(){
					var root = $(this);
					var html = '';
//					var tooltipPub = $('.pub-result:first .result:first span.tooltip-content:first');

					// ajout des affiliates
					if($(this).find('affiliateResult').length) {
						$('#searchResults > .more-result').before('<div class="shop-result"></div>');
					}

					$(this).find('affiliateResult').each(function(){
						
						html = '<div class="result hidden">';
						html += '<table>';
						html += '<tr>';

						if ($(this).find('logo').text().length) {
							html += '<td class="affiliate-logo">'+$(this).find('logo').text()+'</td>';
						}
						
						html += '<td class="affiliate-content">'+$(this).find('content').text()+'</td>';
						html += '<td class="affiliate-gains">'+$(this).find('tooltip').text().replace("\\", "")+'</td>';
						html += '</tr>';
						html += '</table>';
						html += '</div>';

						$('#searchResults .shop-result:last').append(html);
					});

					if($(this).find('pubResult').length) {
						$('#searchResults > .more-result').before('<div class="pub-result"></div>');
					}
					// ajout des liens sponsorisés
					$(this).find('pubResult').each(function(){
						html = '';
						html += '<div class="result hidden">';
						html += '<h3 class="tooltip"><a target="_blank" href="'+$(this).find('url').text()+'">';
						html += $(this).find('title').text();
						html += '</a></h3>';
						if($(this).find('description').text() != '') {
							html += '<p class="content">';
							html += $(this).find('description').text();
							html += '</p>';
						}
						html += '<h4 class="tooltip">'+$(this).find('source').text()+'</h4>';
						html += '</div>';

						$('#searchResults .pub-result:last').append($(html));
						
					});
					
					switch(mode) {
						case IMG :
							if($(this).find('result').length) {
								$('#searchResults > .more-result').before('<div class="img-result"></div>');
							}
							$(this).find('result').each(function(){
								html = '<div class="result hidden">';
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += '<img src="'+$(this).find('thumbnail').text()+'" />';
								html += '</a>';
								if($(this).find('content').text() != '') {
									html += '<p class="content">';
									html += $(this).find('content').text();
									html += '</p>';
								}
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += $(this).find('displayUrl').text();
								html += '</a>';
								html += ' <span class="filename">';
								html += '['+$(this).find('title').text()+']';
								html += '</span>';
								html += '</div>';	
								$('#searchResults .img-result:last').append(html);
							});
							break;
						
						case WEB :
							if($(this).find('result').length) {
								$('#searchResults > .more-result').before('<div class="web-result"></div>');
							}
							$(this).find('result').each(function(){
								html = '<div class="result hidden">';
								
								html += '<h3>';
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += $(this).find('title').text();
								html += '</a>';
								html += '</h3>';
								
								if($(this).find('content').text() != '') {
									html += '<p class="content">';
									html += $(this).find('content').text();
									html += '</p>';
								}
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += $(this).find('displayUrl').text();
								html += '</a>';
								
								html += '</div>';	
								$('#searchResults .web-result:last').append(html);
							});
							break;
						
						case NEWS :
							if($(this).find('result').length) {
								$('#searchResults > .more-result').before('<div class="news-result"></div>');
							}
							$(this).find('result').each(function(){
								var html = '<div class="result hidden">';
								
								html += '<h3>';
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += $(this).find('title').text();
								html += '</a>';
								html += '</h3>';
								
								if($(this).find('content').text() != '') {
									html += '<p class="content">';
									html += $(this).find('content').text();
									html += '</p>';
								}
								
								html += '<h4>Source : ';
								html += '<a target="_blank" href="'+$(this).find('sourceUrl').text()+'">';
								html += $(this).find('source').text();
								html += '</a>';
								html += '<span class="filename">';
								html += '[le '+$(this).find('date').text()+' à '+$(this).find('time').text()+']';
								html += '</span>';
								html += '</h4>';
								
								html += '</div>';
								$('#searchResults .news-result:last').append(html);
							});
							break;

						case SHOP :
							if($(this).find('result').length) {
								$('#searchResults > .more-result').before('<div class="shop-result"></div>');
							}
							$(this).find('result').each(function(){
								var html = '<div class="result hidden">';

								html += '<table>';
								html += '<tr>';

								if($(this).find('logo').text() != '') {
									html += '<td class="affiliate-logo">';
									html += $(this).find('logo').text();
									html += '</td>';
								}

								html += '<td class="affiliate-content">';
								html += $(this).find('html').text();
								html += '</td>';

								html += '<td class="affiliate-gains">';
								html += '<h3>Gains :</h3>';
								html += '<p>'+$(this).find('gains').text()+'</p>';
								html += '</td>';

								html += '</tr>';
								html += '</table>';
								html += '</div>';

								$('#searchResults .shop-result:last').append(html);
							});
							break;
					}

					if($(this).find('result').length || $(this).find('affiliateResult').length || $(this).find('pubResult').length) {
						$('#searchResults > .more-result').before('<div class="clear"></div>');
					}

					$('div.result.hidden', $('#searchResults')).fadeIn('slow', function() {
						$("body").scrollTo( 'max', {axis:'y'} );
					}).removeClass('hidden');

					$("#searchMore").html(txtReadMore);
				});
            }
        });
        
    });

	$(".pub-result .result a").live('mousedown', function(e) {
		if(e.button > 1){
			return false;
		}
		
		$.ajax({
            url: 'ajax/clicPub',
            type: 'post',
            dataType: "xml",
            data: {
				url: $(this).attr('href')
			},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            },
            success: function(xml) {
				if($(xml).find('result').length) {
					var result = $(xml).find('result');
					$.gritter.add({
						title: result.find('messageTitle').text(),
						class_name: result.find('messageType').text(),
						image: result.find('messageImage').text(),
						text: result.find('message').text()
					});
				}
			}
		});
		
		return true;
	});
    
    $(".filtres > span[searchMode]", "#searchForm").each(function(){
		$(this).bind('click', {mode: $(this).attr('searchMode')}, changeMoteur)
	});

});


function changeMoteur(event){

	var valeur = event.data.mode;
	var ongletActif = $(".filtres > span[searchMode].active", "#searchForm");
	var ongletCible = $(".filtres > span[searchMode="+valeur+"]", "#searchForm");

	// désactivation de l'ancien onglet
	if(ongletActif.is('.green')) {
		ongletActif.removeClass('green').addClass('gray');
	}
	else if(ongletActif.is('.orange')) {
		ongletActif.removeClass('orange').addClass('orange-gray');
	}
	ongletActif.removeClass('active');

	// activation de l'ancien onglet
	if(ongletCible.is('.gray')) {
		ongletCible.removeClass('gray').addClass('green');
	}
	else if(ongletCible.is('.orange-gray')) {
		ongletCible.removeClass('orange-gray').addClass('orange');
	}
	ongletCible.addClass('active');

    $("#hidden_moteur_search").val(valeur);
	
    if ($("#recherche_text").val() != "") {
		$("#searchForm").submit();
	}

}
