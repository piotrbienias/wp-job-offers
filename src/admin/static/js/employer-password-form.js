jQuery(document).ready(function($) {

    $('#employer-password-form').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        var passwordInput = $('input[name="password"]');
        var confirmPasswordInput = $('input[name="confirm_password"]');
        var id = $('input[name="id"]').val();
        var nonce = $('input[name="employer_password_nonce"]').val();

        var password = passwordInput.val();
        var confirmPassword = confirmPasswordInput.val();

        var isFormValid = false;

        if ( password === '' || password !== confirmPassword ) {
            passwordInput.addClass('is-invalid');
            confirmPasswordInput.addClass('is-invalid');
        } else {
            passwordInput.removeClass('is-invalid');
            confirmPasswordInput.removeClass('is-invalid');
            isFormValid = true;
        }

        var successMessage = `
            <div class="alert alert-success alert-dismissable fade show" role="alert" style="margin-top: 30px;">
                ` + employer_password_form.success_msg + `
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        if ( isFormValid )  {
            $.ajax({
                url: employer_password_form.ajax_url,
                data: {
                    password: password,
                    action: 'employer_change_password',
                    id: id,
                    nonce: nonce
                },
                type: 'POST'
            }).success(function(response) {
                if (response === '1') {
                    $(successMessage).insertBefore(form);
                }
            }).fail(function(error) {
                console.log(error);
            });
        }

    });

});