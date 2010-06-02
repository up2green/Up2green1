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