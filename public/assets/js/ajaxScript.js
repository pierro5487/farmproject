$(function(){


    /*-------------evenement vente d'animaux sur la page animaux.php---*/
    var sectionGame = $('#content');
    var deleteAnimalButton = $('.deleteAnimal');
    deleteAnimalButton.on('click',function(event){
        var idAnimal=1;
        $.ajax({
            url : ajaxAnimalRefresh, // La ressource ciblée
            type : 'GET',
            data : 'animal=' + idAnimal,
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(code_html, statut){
                sectionGame.hide().html(code_html).fadeIn();
            },

            error : function(resultat, statut, erreur){
                sectionGame.html('<p>erreur</p>');
            }
        });
    });
    //.................................................................................
    //fonction pour améliorer les bâtiments
    $('.improvement').click(function(){
        $.ajax({
            url: ajaxBuildingUpgrade,
            type: 'POST',
            //va prendre dans tout les cas le this actuel comme this .improvement dans cette requête ajax
            context: this,
            data: {
                //on cherche à avoir l'id d'un bâtiment précis au travers du bouton
                id: $(this).attr('bid')
            },
            dataType : 'json',
        success: function(message){
                var data = message;
               ///boucle pour pouvoir afficher les nouvelles valeurs de chaque li après upgrade
                for(attr in data){
                    //on sélection chaque li en fonction de l'attribut et on inscrit la nouvelle valeur en html
                    //attr => correspond à un attribut de balise que tu veux sélectionner
                    //.html => permet de redéfinir le contenu d'une balise html
                    $('#b_'+ $(this).attr('bid') + ' li.'+attr +' span').html(data[attr]);
                }
            },
            error:function(resultat, statut, erreur){
                $('#content').html('<p>'+resultat+statut+erreur+'</p>');
            }
        });
    });
});