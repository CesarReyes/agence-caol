jQuery(function($) {
    $.material.init();
});

//Performance Comercial
jQuery(function($) {
    
    //Handling the actions
    $('._action').click(function(e){
        e.preventDefault();
        var action = $(this).attr('id');
        $('input[name="_action"]').val(action);

        var fields = $('input[name="consultores[]').serializeArray(); 

        if(fields.length === 0){
            $('#err-consultores').addClass('active-error');
            return false;
        }

        $('#frm-consultor').submit();
            
    });

});