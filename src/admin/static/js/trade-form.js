jQuery(document).ready(function($) {

    $('#trade-form').submit(function(e) {
        e.preventDefault();

        var data = $(this).serialize();

        $.ajax({
            url: trade_form.ajax_url,
            data: data,
            type: 'POST'
        }).success(function(response) {
            $('#trade-form-' + response).css('display', 'block');
        }).fail(function(error) {
            console.log(error);
        });

    })

})