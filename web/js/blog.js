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
//      $('div.diapo.selected').fadeOut().removeClass('selected').next('div.diapo').fadeIn().addClass('selected');
      $('div.diapo.selected').fadeOut(500, function() {
        $(this).removeClass('selected').next('div.diapo').fadeIn().addClass('selected');}
      );
    }
  });




  // Chargement des éléments précédents / suivants en AJAX
  $('a.loadFromUri').click(function() {
    // On applique la classe toUpdate au div blocObjects contenant le lien de manière à pouvoir le mettre à jour une fois la requête terminée
    $(this).parents('div.blocContent').children('div.blocObjects').addClass('toUpdate');
    // Récupération des éléments voulus en AJAX
    $.ajax({
      url: $(this).attr('href'),
      success: function(data) {
        $('div.blocObjects.toUpdate').fadeOut().empty().append(data).fadeIn();
        // Mise à jour des boutons de navigations précédents / suivants
        $('a.prevResults', $('div.blocObjects.toUpdate').parent('div.blocContent')).attr('href', $('div.blocObjects.toUpdate > span.prevResultsUrl').text());
        $('a.nextResults', $('div.blocObjects.toUpdate').parent('div.blocContent')).attr('href', $('div.blocObjects.toUpdate > span.nextResultsUrl').text());
      },
      complete: function(XMLHttpRequest, textStatus) {
        // Suppression de la classe 'toUpdate'
        $('div.blocObjects.toUpdate').removeClass('toUpdate');
      }
    });
    return false;
  });
});