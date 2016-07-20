$(function(){

    /*------variable par default------*/
    var sectionGame = $('#content');
    var infoUser =$('#infoUser');
    var articleProduct = $('#listProducts');
    var harvest= $('#harvest');
    var chatDisplay=$('#chatDisplay');
    var sendMessage=$('#sendMessage');
    /*---------script------------*/
    deleteAnimal();
    deleteProduct();
    refreshProducts();
    var interval=setInterval(refreshProducts,1000);
    setInterval(refreshChat(),1000);


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
            if(confirm('etes vous sur de vouloir vendre ce stock?')){
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
                console.log(code_html);
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
        tableBoard();
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
});