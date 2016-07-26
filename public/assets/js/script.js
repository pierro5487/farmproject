$(document).ready( function() {
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

    //.................................................................................
    //fonction pour afficher qu'un seul animal
    $('#animal').change(function(){
        //$(this) fait référence à $('#animal')
        if($(this).val() == "*"){
            //si on sélectionne le tous, on affiche tous les animaux
            $('.listing').show();
        }else{
            //on cache tous les animaux
            $('.listing').hide();
            //on affiche l'animal selon la valeur de l'id qu'on sélectionne
            $('#a_'+ $('#animal').val()).show();
        }
    });

    //.................................................................................
    //fonction pour afficher qu'un seul produit
    $('#productSelect').change(function(){
        //$(this) fait référence à $('#productSelect')
        if($(this).val() == "*"){
            //si on sélectionne le tous, on affiche tous les produits
            $('.listing').show();
        }else{
            //on cache tous les produits
            $('.listing').hide();
            //on affiche le produit selon la valeur de l'id qu'on sélectionne
            $('#p_'+ $('#productSelect').val()).show();
        }
    });
    
    /*---------------------function -----------------------*/
    $('#market_select').change(function(){
        //$(this) fait référence à $('#animal')
        if($(this).val() == "*"){
            //si on sélectionne le tous, on affiche tous les animaux
            $('.listing').show();
        }else{
            //on cache tous les animaux
            $('.listing').hide();
            //on affiche l'animal selon la valeur de l'id qu'on sélectionne
            $('article[specieName='+$('#market_select').val()+']').show();
        }
    });
    // myTable = new Array(['building'], ['field']);
    //
    // for(i=0;i<myTable.length;i++){
    //     $('#'+myTable[i]+'').change(function(){
    //         //$(this) fait référence à $('#field')
    //         if($(this).val() == "*"){
    //             //si on sélectionne le tous, on affiche tous les champs
    //             $('.listing'+myTable[i]+'').show();
    //         }else{
    //             //on cache tous les champs
    //             $('.listing'+myTable[i]+'').hide();
    //             //on affiche le champ selon la valeur de l'id qu'on sélectionne
    //             $('#'+myTable[i].substring(0,1)+'_'+ $('#'+myTable[i]+'').val()).show();
    //         }
    //     });
    // }
});

