/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() { 
    $("#searchMore").click(function(){
		var txtReadMore = $("#searchMore").html();
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
                $(xml).find('root').each(function(){
                    $(this).find('result').each(function(){
						var html = '<div class="result hidden">';
						html += '<a href="'+$(this).find('clickUrl').text()+'">';
						html += '<img src="'+$(this).find('thumbnail').text()+'" />';
						html += '</a>';
						if($(this).find('content').text() != '') {
							html += '<p class="content">';
							html += $(this).find('content').text();
							html += '</p>';
						}
						html += '<a href="'+$(this).find('clickUrl').text()+'">';
						html += $(this).find('displayUrl').text();
						html += '</a>';
						
						html += '<span class="filename">';
						html += '['+$(this).find('title').text()+']';
						html += '</span>';
						html += '</div>';
												
						$('#searchResults').append(html);
						
						
                    });
                    
                    $('div.result.hidden p.content, div.result.hidden a', $('#searchResults')).textOverflow(null, true);
                    setTimeout(function() {
						$('div.result.hidden', $('#searchResults')).fadeIn('slow', function() {
							$("body").scrollTo( 'max', { duration:500, axis:'y' } );
						}).removeClass('hidden');
					},200);
                    
					$("#searchMore").html(txtReadMore);
                });
            }
        });
        
    });
    
    $('div.img-result p.content, div.img-result a', '#body').textOverflow(null, true);
});


function changeMoteur(valeur){
    $("#hidden_moteur_search").attr("value", valeur);
    $(".onglet_recherches").each(function(){
        $(this).removeClass("onglet_selected");
        if ($(this).attr('id') == "recherches"+valeur) $(this).addClass("onglet_selected");
    });
    $(".onglet_left").each(function(){
        $(this).removeClass("onglet_selected");
        if ($(this).attr('id') == "left"+valeur) $(this).addClass("onglet_selected");
    });
    $(".onglet_middle").each(function(){
        $(this).removeClass("onglet_selected");
        if ($(this).attr('id') == "middle"+valeur) $(this).addClass("onglet_selected");
    });
    $(".onglet_right").each(function(){
        $(this).removeClass("onglet_selected");
        if ($(this).attr('id') == "right"+valeur) $(this).addClass("onglet_selected");
    });
    if ($("#recherche_text").attr('value') != "") document.recherche.submit();
}
