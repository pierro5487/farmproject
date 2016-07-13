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
});