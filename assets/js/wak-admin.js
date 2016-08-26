jQuery(document).ready(function($) {

    $('#wak_generate_secret').submit(function() {
        var form = $(this);

        $.ajax({
            type: "POST",
            url: 'options.php',
            data: $(this).serialize(), // serializes the form's elements.
            success: function (data) {
                form.find()
            }
        });

        return false;
    });

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