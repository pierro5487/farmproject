$( function() {
    //fonction d'affichage ou non de la navigation gauche
    var navigation= $('#navLeft');
    var button = $('#buttonNavLeft');

    button.on('click', function(event){
        navigation.toggleClass('showOnPhone');
    });

    //.................................................................................
    //fonction pour afficher qu'un seul bâtiment
    $('#building').change(function(){
        //$(this) fait référence à $('#builging')
        if($(this).val() == "*"){
            //si on sélectionne le tous, on affiche tous les bâtiments
            $('.listingBuilding').show();
        }else{
            //on cache tous les bâtiments
            $('.listingBuilding').hide();
            //on affiche le bâtiment selon la valeur de l'id qu'on sélectionne
            $('#b_'+ $('#building').val()).show();
        }
    });


    //.................................................................................
    //fonction pour afficher qu'un seul champ
    $('#field').change(function(){
        //$(this) fait référence à $('#field')
        if($(this).val() == "*"){
            //si on sélectionne le tous, on affiche tous les champs
            $('.listingField').show();
        }else{
            //on cache tous les champs
            $('.listingField').hide();
            //on affiche le champ selon la valeur de l'id qu'on sélectionne
            $('#f_'+ $('#field').val()).show();
        }
    });
});

