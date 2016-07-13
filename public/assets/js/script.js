$( function() {

    //apparition de la navigation au click
    $("#buttonNavLeft").on('click', function (event){
        var navigation= $('#navLeft');
        var button = $("#buttonNavLeft");
        if(navigation.css('display')!='block'){
            navigation.css({'display':'block'});
            button.css({'background-image': 'url("assets/img/fleche1.jpg")'});
        }else{
            navigation.css({'display':'none'});
            //changement de l'image
            button.css({'background-image': 'url("assets/img/fleche2.jpg")'})
        }
    });
});var Chat = (function(){

    var self = {}; // stockage
    var private = {};

    // interval
    private.interval = function(){
        setInterval(function(){ self.getMessages(  $('#room').val() ); }, 3000);
    };

    // displayMessage
    private.displayMessage = function(results){
        // je vide la liste des messages
        $('#messagesList').empty();

        // pour chacun des messages , j'affiche une div.message
        for(i=0;i<results.length;i++){
            var element = results[i];
            var message = $('<div class="message"></div>');
            var nickname = $('<div class="nickname">'+element.nickname+': </div>');
            var content = $('<div class="content">&nbsp;'+element.content+'</div>');
            var date = $('<div class="date">'+element.record_hour+'</div>');
            message.append( date, nickname, content)
            $('#messagesList').append( message );
        }
        $('#messagesList').animate({ scrollTop: $('#messagesList').prop("scrollHeight") - $('#messagesList').height() }, 0);
    };

    // getMessages
    self.getMessages = function(room){
        if( !room || room =='' || room == undefined ){
            room = "webforce3";
        }
        $.ajax({url: self.url, data: {room: room}, type: 'GET', success: private.displayMessage});
    };

    // postMessage
    self.postMessage = function(room, nickname, message){

        // appel ajax
        $.ajax({
            url: self.url,
            type: 'POST',
            data: {room: room, nickname: nickname, content: message},
            success: function(result){
                self.getMessages(room);
            }
        });
    };

    // init chat
    self.init = function(url){
        self.url = url;
        private.interval();
    };

    return self;
})();

$(function(){

    Chat.init( 'http://front.rocks/api/messages.php' );

    $('#messageForm').on('submit', function(event){

        // blocage de l'event
        event.preventDefault();

        // récupération des données
        var nickname = $('#nickname').val();
        var message = $('#message').val();
        var room = $('#room').val();

        // post
        Chat.postMessage(room, nickname, message);
    });

});


