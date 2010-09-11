$(document).ready(function(){
    // gestion des boutons "+"
    console.log($("button[id^='addArbreProgramme']"));
    $("button[id^='addArbreProgramme']").click(function(){
        alert("huhu");
        if (($(this).hasClass('green')) && ($('#nbArbresToPlantLeft').attr('innerHTML') != "0")){
            // récupération id du programme
            id = $(this).attr('id').substr(18);
            if (id.substr(0, 1) == "a") id = id.substr(3);
            alert(id);
            // modification du nombre d'arbres à planter sur ce programme
            total = $("#nbArbresProgramme_"+id).attr('innerHTML');
            if ((total == null) || (total == "")) total = 0;
            $("#nbArbresProgramme_"+id).attr('innerHTML', parseInt(total) + 1);
            $("#nbArbresProgrammeHidden_"+id).attr('value', parseInt(total) + 1);

            // autorisation de suppression d'arbre si le programme avait 0 arbres avant le clic
            if (total == 0) {
                $("#removeArbreProgramme_"+id).removeClass("gray");
                $("#removeArbreProgramme_"+id).addClass("green");
                $("#removeArbreProgrammeMap_"+id).removeClass("gray");
                $("#removeArbreProgrammeMap_"+id).addClass("green");
            }

            // changement du total d'arbres restant à planter
            totalToPlant = parseInt($('#nbArbresToPlantLeft').attr('innerHTML'));
            $('#nbArbresToPlantLeft').attr('innerHTML', totalToPlant - 1);

            // si plus d'arbres à planter
            if ($('#nbArbresToPlantLeft').attr('innerHTML') == "0"){
                // passage de tout les boutons + en gris
                $("button[id^='addArbreProgramme']").removeClass("green");
                $("button[id^='addArbreProgramme']").addClass("gray");

                // passage du bouton de submit en vert
                $("#buttonArbresProgramme").removeClass("gray");
                $("#buttonArbresProgramme").addClass("green");
            }
        }
    });

    // gestion des boutons "-"
    $("button[id^='removeArbreProgramme']").click(function(){
        if ($(this).hasClass('green')) {
            id = $(this).attr('id').substr(21);
            if (id.substr(0, 1) == "a") id = id.substr(3);
            // modification du nombre d'arbres à planter sur ce programme
            total = parseInt($("#nbArbresProgramme_"+id).attr('innerHTML'));
            if (total - 1 == 0) $("#nbArbresProgramme_"+id).attr('innerHTML', "");
            else $("#nbArbresProgramme_"+id).attr('innerHTML', parseInt(total) - 1);
            $("#nbArbresProgrammeHidden_"+id).attr('value', parseInt(total) - 1);

            // suppression de l'autorisation de suppression d'arbre si le programme a 0 arbres après le clic
            if (total - 1 == 0) {
                $("#removeArbreProgramme_"+id).removeClass("green");
                $("#removeArbreProgramme_"+id).addClass("gray");
                $("#removeArbreProgrammeMap_"+id).removeClass("green");
                $("#removeArbreProgrammeMap_"+id).addClass("gray");
            }

            // changement du total d'arbres restant à planter
            totalToPlant = parseInt($('#nbArbresToPlantLeft').attr('innerHTML'));
            $('#nbArbresToPlantLeft').attr('innerHTML', totalToPlant + 1);

            // si à nouveau des arbres à planter
            if ($('#nbArbresToPlantLeft').attr('innerHTML') == "1"){
                // passage de tout les boutons + en vert
                $("button[id^='addArbreProgramme']").removeClass("gray");
                $("button[id^='addArbreProgramme']").addClass("green");

                // passage du bouton de submit en gris
                $("#buttonArbresProgramme").removeClass("green");
                $("#buttonArbresProgramme").addClass("gray");
            }
        }
    });

    // gestion du bouton de validation
    $("#buttonArbresProgramme").click(function(){
        if ($(this).hasClass('green')){
            $("#submitArbresProgramme").trigger('click');
        }
    });
});
