jQuery(function($) {
    $.material.init();
});

//Performance Comercial
jQuery(function($) {
    
    //Handling the consultors boxes
    $('#add').click(function() {  
        return !$('select[name="consultores-base"] option:selected').remove().appendTo('select[name="consultores[]"]');  
    });  
    $('#remove').click(function() {  
        return !$('select[name="consultores[]"] option:selected').remove().appendTo('select[name="consultores-base"]');  
    });

    //Handling the actions
    $('._action').click(function(e){
        e.preventDefault();
        var action = $(this).attr('id');
        $('input[name="_action"]').val(action);

        if(!$('select[name="consultores[]"]').val()){
            $('#err-consultores').addClass('active-error');
            return false;
        }

        $('#frm-consultor').submit();
            
    });

});