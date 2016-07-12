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
});
