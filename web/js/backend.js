$(document).ready(function(){

  var menuWrapper = $("#menu-wrapper");
	
  //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)
  $("ul.subnav", menuWrapper).parent().append("<span></span>"); 
	
  $("#menu > li").hover(function(e) {
    $(this).find("ul.subnav").stop(true, true).slideDown('fast');
  }, function(e){
    $(this).find("ul.subnav").slideUp('fast');
  });

  // Translation tabs
  var transWrapper = $("#sf_fieldset_translation");
  var translationChoice = $('<ul id="translationChoice"></ul>');
  var translationKey = 0;

  $(".sf_admin_form_row", transWrapper).each(function(){
    var $this = $(this);
    var id = 'translationTab'+translationKey;
    var label = $this.find('label:first');
    var item = $('<li><a href="#'+id+'"></a></li>');
    item.find('a').append(label);

    $this.attr('id', id);
    $this.find('div.content:first').css('padding-left', 0);

    translationChoice.append(item);
    translationKey++;
  });

  transWrapper.children("h2:first").after(translationChoice);
  transWrapper.tabs();

});
