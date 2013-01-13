$(document).ready(function(){

    $("span.control").click(function(event) {
        var elem = $("#program-" + $(this).parent().data('program') + " span.count");
        elem.html(parseInt(elem.html()) + parseInt($(this).data('number')));
    });

});