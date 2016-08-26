jQuery(document).ready(function($) {

    $('#wak_generate_secret').submit(function() {
        var form = $(this);

        form.find('.form-status').html('<div class="spinner is-active" style="float:none;width:auto;height:auto;padding:0 0 10px 30px;background-position:0 0;">Loading...</div>').fadeIn();

        $.ajax({
            type: "POST",
            url: 'options.php',
            data: $(this).serialize(), // serializes the form's elements.
            success: function (data) {
                form.find();

                form.find('.form-status').html('<span style="color:green;padding: 5px 0 0 15px;">Done!</span>');
                setTimeout(function() {
                    form.find('.form-status').fadeOut();
                }, 1000);
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