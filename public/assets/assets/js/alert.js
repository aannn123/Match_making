window.setTimeout(function() {
    $(".alert-dismissible").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
}, 3500);
