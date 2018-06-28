jQuery(document).ready(function($) {

    $('#employer-form').submit(function(e) {
        e.preventDefault();

        var ajaxDataArray = $(this).serializeArray();
        var ajaxData = {};

        for(var i = 0; i < ajaxDataArray.length; i++){
            var singleData = ajaxDataArray[i];
            ajaxData[singleData['name']] = singleData['value'];
        }

        ajaxData['is_verified'] = ajaxData['is_verified'] ? 1 : 0;
        ajaxData['is_deleted'] = ajaxData['is_deleted'] ? 1 : 0;


        var form = $(this);
        var responseAlert = `
            <div class="alert alert-*alert-class*" alert-dismissable fade show" role="alert" style="margin-top: 30px;">
                *message*
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        $.ajax({
            url: employer_form.ajax_url,
            type: 'POST',
            data: ajaxData
        }).done(function(response) {
            console.log(response);

            responseAlert = responseAlert.replace('*alert-class*', response)
            if (response === 'success') {
                responseAlert = responseAlert.replace('*message*', 'Employer has been saved');
            } else {
                responseAlert = responseAlert.replace('*message*', 'Error while performing the operation');
            }
            
            $(responseAlert.toString()).insertBefore(form);
        }).error(function(jqXHR, textStatus, error) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(error);
        });
    });

});