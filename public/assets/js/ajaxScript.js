$(function(){

    /*------variable par default------*/
    var sectionGame = $('#content');
    var infoUser =$('#infoUser');
    var articleProduct = $('#listProducts');
    var harvest= $('#harvest');
    var articleCreations = $('#listCreations');
    var creations= $('#creations');
    /*---------script------------*/
    deleteAnimal();
    deleteProduct();
    refreshProducts();
    refreshCreations();
    var interval=setInterval(refreshProducts,1000);
    getHarvest();
    /*-------------evenement vente d'animaux sur la page animaux.php---*/

    function deleteAnimal(){
        var deleteAnimalButton = $('.deleteAnimal');
        deleteAnimalButton.on('click',function(event){
            var idAnimal = $(event.target).attr("value");
            if(confirm('etes vous sur de vouloir vendre cette animal?')){
                $.ajax({
                    url : ajaxAnimalRefresh, // La ressource ciblée
                    type : 'GET',
                    data : 'animal=' + idAnimal,
                    dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                    success : function(code_html, statut){
                        sectionGame.html(code_html);
                        deleteAnimal();
                    },

                    error : function(resultat, statut, erreur){
                        sectionGame.html('<p>erreur</p>');
                    }
                });
                tableBoard();
            }
        });
    }

    /*-------------evenement vente de production animal sur la page produit.php---*/

    function deleteProduct(){
        var deleteAnimalButton = $('.deleteProduct');
        deleteAnimalButton.on('click',function(event){
            var idProduct = $(event.target).attr("value");
            if(confirm('Etes-vous sur de vouloir vendre ce stock ?')){
                $.ajax({
                    url : ajaxProductsRefresh, // La ressource ciblée
                    type : 'GET',
                    data : 'product=' + idProduct,
                    dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                    success : function(code_html, statut){
                        sectionGame.html(code_html);
                        deleteProduct();
                    },

                    error : function(resultat, statut, erreur){
                        sectionGame.html('<p>erreur product</p>');
                    }
                });
                tableBoard();
            }
        });
    }
    /*-------------evenement rafraichissement des donnees utilsateur---*/
    function tableBoard() {
        $.ajax({
            url : tableBoardRefresh, // La ressource ciblée
            type : 'GET',
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(code_html, statut){
                infoUser.html(code_html);
            },

            error : function(resultat, statut, erreur){
                sectionGame.html('<p>erreur table</p>');
            }
        });
    }

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
    /*-------------evenement rafraichissement des donnees production---*/
    function refreshProducts() {
        $.ajax({
            url : productsRefresh, // La ressource ciblée
            type : 'GET',
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(code_html, statut){
                articleProduct.html(code_html);
            },

            error : function(resultat, statut, erreur){
                sectionGame.html('<p>erreur table</p>');
            }
        });
    }
    /*-------------evenement recolter---*/
    function getHarvest(){
        harvest.on('click',function(event){
            $.ajax({
                url : harvestRoute, // La ressource ciblée
                type : 'GET',
                dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                success : function(code_html, statut){
                    articleProduct.html(code_html);
                },

                error : function(resultat, statut, erreur){
                    sectionGame.html('<p>erreur table</p>');
                }
            });
        });
    }
    /*-------------evenement rafraichissement des creations---*/
    function refreshCreations() {

            $.ajax({
                url : creationsRefresh, // La ressource ciblée
                type : 'GET',
                dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                success : function(code_html, statut){
                    articleCreations.html(code_html);

                    // Définition de la boite de dialogue
                    $( "#dialog" ).dialog({
                        maxWidth:600,
                        maxHeight: 250,
                        width: 600,
                        height: 250,
                        modal: true,
                        autoOpen: false,
                        show: {
                            //Effet de fondu à l'ouverture
                            effect: "fade",
                            // Durée de l'action
                            duration: 500
                        },
                        hide: {
                            // Effet de fondu à la fermeture
                            effect: "fade",
                            // Durée de l'action
                            duration: 800
                        }
                    });

                    $('.creations').on('click', function () {
                        // Ajax: ouverture popup au click sur +
                        $.ajax({
                            url: creationsPopup, // La ressource ciblée
                            type: 'GET',
                            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                            data: {
                                // On récupère l'id correspondant au click sur l'event
                                idCreation: $(this).attr('data-creationId'),
                                idCreation2: $(this).attr('data-creationId2')
                            },
                            success: function(response) {
                                // On renvoi la réponse en html
                                $('#dialog').html(response);
                                // On ouvre le popup
                                $("#dialog").dialog('open');

                                var addBuildingButton = $('.addBuilding');
                                addBuildingButton.on('click',function(event){
                                    $.ajax({
                                        url : ajaxBuildingAdd, // La ressource ciblée
                                        type : 'GET',
                                        dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                                        data: 'idCreation=' + typeBuildingid, // On récupère la variable php en JS
                                        success : function(response){
                                            $("#dialog").dialog('close'); // On ferme la boite de dialogue
                                        },
                                        error : function(resultat, statut, erreur){
                                            // En cas d'erreur, on le note
                                            sectionGame.html('<p>erreur building</p>');
                                        }
                                    });
                                    // On affiche les PO correspondants
                                    tableBoard();
                                });
                            }
                        });
                    });
                    $('.creations2').on('click', function () {
                        // Ajax: ouverture popup au click sur +
                        $.ajax({
                            url: creationsPopup2, // La ressource ciblée
                            type: 'GET',
                            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                            data: {
                                // On récupère l'id correspondant au click sur l'event
                                idCreation: $(this).attr('data-creationId'),
                                idCreation2: $(this).attr('data-creationId2')
                            },
                            success: function(response) {
                                // On renvoi la réponse en html
                                $('#dialog').html(response);
                                // On ouvre le popup
                                $("#dialog").dialog('open');

                                var addFieldButton = $('.addField');
                                addFieldButton.on('click',function(event){
                                    $.ajax({
                                        url : ajaxFieldAdd, // La ressource ciblée
                                        type : 'GET',
                                        dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                                        data: 'idCreation2=' + typeFieldid, // On récupère la variable php en JS
                                        success : function(response){
                                            $("#dialog").dialog('close'); // On ferme la boite de dialogue
                                        },
                                        error : function(resultat, statut, erreur){
                                            // En cas d'erreur, on le note
                                            sectionGame.html('<p>erreur Field</p>');
                                        }
                                    });
                                    // On affiche les PO correspondants
                                    tableBoard();
                                });
                            },
                            error : function(resultat, statut, erreur){
                                // En cas d'erreur, on le note
                                sectionGame.html('<p>erreur Field</p>');
                            }
                        });
                        // On affiche les PO correspondants
                        tableBoard();
                    });

                },
                error : function(resultat, statut, erreur){
                    sectionGame.html('<p>erreur table</p>');
                }
            });
            // On affiche les PO correspondants
            tableBoard();
    }
});