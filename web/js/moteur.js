$(function() {

	var txtReadMore = $("#searchMore").html();
	var IMG = '1';
	var WEB = '2';
	var NEWS = '3';
	var SHOP = '4';
	
    $("#searchMore").click(function(){
		
		$("#searchMore").html('<img src="/images/icons/16x16/ajax-loader.gif" alt="Loading" />');
		
        $.ajax({
            url: 'ajax/moreresults',
            type: 'post',
            dataType: "xml",
            data: {
                nb_items_affiche: $(".result").length,
                text_search: $('#hidden_text_search', '#searchForm').val(),
                moteur_search: $('#hidden_moteur_search', '#searchForm').val()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$("#searchMore").html(txtReadMore);
            },
            success: function(xml) {
				var mode = $('#hidden_moteur_search', '#searchForm').val();
				$(xml).find('root').each(function(){
					switch(mode) {
						case IMG : 
							$(this).find('result').each(function(){
								var html = '<div class="result hidden">';
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
								$('#searchResults').append(html);
							});
							break;
						
						case WEB :
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
								html += '<a target="_blank" href="'+$(this).find('clickUrl').text()+'">';
								html += $(this).find('displayUrl').text();
								html += '</a>';
								
								html += '</div>';	
								$('#searchResults').append(html);
							});
							break;
						
						case NEWS :
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
								$('#searchResults').append(html);
							});
							break;

						case SHOP :
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

								$('#searchResults').append(html);
							});
							break;
					}
					                    
					$('div.result.hidden', $('#searchResults')).fadeIn('slow', function() {
						$("body").scrollTo( 'max', { axis:'y' } );
					}).removeClass('hidden');

					$("#searchMore").html(txtReadMore);
				});
            }
        });
        
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
