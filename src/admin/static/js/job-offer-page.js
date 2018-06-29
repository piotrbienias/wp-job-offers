jQuery(document).ready(function($) {

    $('#job-offer-form').submit(function(e) {
        e.preventDefault();

        var ajaxData = $(this).serialize();

        $.ajax({
            url: job_offer_params.ajax_url,
            data: ajaxData,
            type: 'POST'
        }).done(function(response) {
            console.log(response);
            var selector = response === '1' ? 'success' : 'danger';
            $('#job-offer-form-' + selector).css('display', 'block');
        }).fail(function(error) {
            console.log(error);
        });

        return false;
    });

});