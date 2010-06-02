/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#more_results").click(function(){
        alert('click !');
        $.ajax({
            url: 'ajax/moreresults',
            type: 'post',
            dataType: "xml",
            data: {
                nb_items_affiche: $(".result").length,
                text_search: $('.hidden_text_search'),
                moteur_search: $(".hidden_moteur_search")
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Une erreur est survenue lors du chargement : "' + textStatus + '"');
            },
            success: function(xml) {
                alert('success !');
                $(xml).find('root').each(function(){
                    $(this).find('result').each(function(){
                        alert('found');
                        alert($(this).find('title').get(0).nodeValue);
                    })
                
                });
            }
        });
    });
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