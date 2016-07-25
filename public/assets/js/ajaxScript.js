$(function(){

    // afficher le popup pas assez d'argent
    $(document).ready(function(){
        $('#errorMoney').hide();
    });

    /*------variable par default------*/
    var sectionGame = $('#content');
    var infoUser =$('#infoUser');
    var articleProduct = $('#listProducts');
    var harvest= $('#harvest');
    var chatDisplay=$('#chatDisplay');
    var sendMessage=$('#sendMessage');
    var articleCreations = $('#listCreations');
    var creations= $('#creations');
    var listingField=$('.listingField');
    var marketList=$('#marketList');
    /*---------script------------*/
    deleteAnimal();
    deleteProduct();
    refreshProducts();
    refreshCreations();
    buyAnimal();
    setInterval(refreshProducts,1000);
    /*setInterval(refreshChat(),1000);*/
    //on récupere l'url
    var url =$(location).attr('href');
    var testUrl = url.indexOf("field");
    //si on se trouve sur la page field alors on lance un raffraichissement
    if(testUrl!=(-1)){
        harvestFieldsEvent();
        setInterval(fieldRefresh,1000);
    }
    //si on se trouve sur la page market alors on lance un raffraichissement
    testUrl = url.indexOf("market");
    if(testUrl!=(-1)){
       setInterval(refreshMarket,1000);
    }

    /********************************************************************************/
    /*---------------------------functions------------------------------------------*/


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
                        refreshCreations();
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
                        refreshCreations();
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
            //dataType : 'json',
        success: function(message){
                message = JSON.parse(message);
                var buildingData = message.building;
                if(message.error == undefined) {
                    ///boucle pour pouvoir afficher les nouvelles valeurs de chaque li après upgrade
                    for (attr in buildingData) {
                        //on sélection chaque li en fonction de l'attribut et on inscrit la nouvelle valeur en html
                        //attr => correspond à un attribut de balise que tu veux sélectionner
                        //.html => permet de redéfinir le contenu d'une balise html
                        $('#b_' + $(this).attr('bid') + ' li.' + attr + ' span').html(buildingData[attr]);
                    }
                    // Refresh user money
                    $('#money').html(message.user.money + " PO");
                }else {
                    // Pas assez de tunes
                    $('#errorMoney').dialog();
                }
            },
            error: function(response) {
                console.log(response.responseText);
            }
        });
        tableBoard();
    });
    /*-------------evenement rafraichissement des donnees production---*/
    function refreshProducts() {
        refreshChat();
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

    /*---------------rafraichissement tchat----------------*/
    function refreshChat() {
        $.ajax({
            url : chatRefresh, // La ressource ciblée
            dataType : 'json',// Le type de données à recevoir, ici, du HTML.
            success : function(messages, statut){
                getAll(messages);
            },

            error : function(resultat, statut, erreur){
                chatDisplay.html('<p>erreur table</p>');
            }
        });
    }
    /*-----------affichage messages du chat----*/
    function getAll(message){
        chatDisplay.html('');
        for(var i = 0; i < message.length; i++){

            var messages = message[i];
            var pseudo = messages.login;
            var post = messages.message;

            var pseudoDOM = $('<div>'+pseudo+':</div>');
            var messagesDOM = $('<div>'+post+'</div>');
            chatDisplay.append(pseudoDOM)
                .append(messagesDOM)
                .append('<div class="clearfix"></div>')
        }
    }

    /*---------------------EVENEMENT envoi de message chat-------*/
    sendMessage.on('click',function(){
        /*var message=$('#chatBoard [name=message]');*/
        var message =$('#message').val();
        console.log(message);
        $.ajax({
            url : chatSendMessage,
            Type:'GET',
            data:'message='+message,
            success: function(){
                $('#message').val('');
                refreshChat();
            },
        });
    });
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
                                            refreshCreations();
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
                                            refreshCreations();
                                            $("#dialog").dialog('close'); // On ferme la boite de dialogue
                                            document.location.href="http://localhost/farmproject/public/field";
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
    /*---------------raffraichissement de la liste des champs------*/
    function fieldRefresh() {
        $.ajax({
            url: refreshFields, // La ressource ciblée
            type: 'GET',
            dataType: 'json',// Le type de données à recevoir, ici, du HTML.
            success: function (fields, statut) {
                for (i = 0; i < fields.length; i++) {
                    //je charge la nouvelle valeur du progress
                    $('#f_' + fields[i].id).find('progress').attr('value', fields[i].fieldValue);
                    //je teste si le champs peut etre récolté
                    if (fields[i].fieldValue >= 100) {
                        $('#f_' + fields[i].id).find('button').prop("disabled", false);
                        ;
                    }
                }
                harvestFieldsEvent();
            },

            error : function(resultat, statut, erreur){
              sectionGame.html('<p>erreur table</p>');
           }
       });
    }

    /*-------------evenement rafraichissement des donnees du marché---*/
    function refreshMarket() {
        $.ajax({
            url : market, // La ressource ciblée
            type : 'GET',
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(animalsList, statut){
                marketList.html(animalsList);
                var selectValue=$('#market_select').val();
                if(selectValue == "*"){
                    //si on sélectionne le tous, on affiche tous les animaux
                    $('.listing').show();
                }else{
                    //on cache tous les animaux
                    $('.listing').hide();
                    //on affiche l'animal selon la valeur de l'id qu'on sélectionne
                    $('article[specieName='+selectValue+']').show();
                }
                buyAnimal();

            },

            error : function(resultat, statut, erreur){
                marketList.html('<p>erreur table</p>');
            }
        });

    }
    /*--------------fonction récolter les cereals-------*/
    function harvestFieldsEvent(){
        $('.harvest').off();
        $('.harvest').on('click',function(){
            $.ajax({
                url: fieldHarvestRoute,
                type: 'GET',
                //va prendre dans tout les cas le this actuel comme this .improvement dans cette requête ajax
                context: this,
                data: {
                    //on cherche à avoir l'id d'un bâtiment précis au travers du bouton
                    id: $(this).parent().parent().attr('id')
                },
                success: function(idFieldDeleted){
                    //je supprime le champs récolté
                    $('#f_'+idFieldDeleted).remove();
                    //je supprime le champs récolté du select
                    $('option[value='+idFieldDeleted+']').remove();
                },
                error: function(response) {
                    console.log(response.responseText);
                }
            });
            tableBoard();

        });
    }

    /*---------------fonction achat marché-----------------*/
    function buyAnimal(){
        $('.buyAnimal').off();
        $('.buyAnimal').on('click',function(event){
            var idAnimal = $(event.target).attr("value");
            if(confirm('Etes-vous sur de vouloir acheter cet animal ?')){
                $.ajax({
                    url : ajaxBuyAnimal, // La ressource ciblée
                    type : 'GET',
                    dataType : 'html',
                    data : 'idAnimal=' + idAnimal,
                    success : function(statut){
                        refreshMarket();
                    },

                    error : function(resultat, statut, erreur){
                        sectionGame.html('<p>erreur product</p>');
                    }
                });
                tableBoard();
            }
        });
    }

});