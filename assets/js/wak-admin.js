jQuery(document).ready(function($) {

    /*$('#wak_generate_secret').submit(function() {
        $(this).ajaxSubmit({
            url: 'server.php',
            type: 'GET'
        });
    });*/

    $('#wak_generate_secret button').click(function() {
        var input = $(this).parent().find('input');

       $.ajax({
           url: ajax_object.ajax_url,
           type: 'GET',
           data: {action: 'wak_generate_secret'},
           success: function(data) {
               input.val(data);
           }
       });

        return false;
    });

});