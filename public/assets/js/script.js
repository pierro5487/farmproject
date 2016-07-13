$( function() {

    var navigation= $('#navLeft');
    var button = $('#buttonNavLeft');

    button.on('click', function(event){
        navigation.toggleClass('showOnPhone');
    });

});



