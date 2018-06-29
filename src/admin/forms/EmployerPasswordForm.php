<?php

namespace JobOffers\Admin\Forms;

use JobOffers\Admin\DAO\EmployerDAO;


class EmployerPasswordForm {

    function __construct( $employer = null ) {
        $this->employer = $employer;

        $this->form_action = 'employer_change_password';
        $this->form_url = esc_url( admin_url( 'admin-ajax.php' ) );
        $this->form_nonce = wp_create_nonce( $this->form_action );

        add_action( 'wp_ajax_nopriv_employer_change_password', array( $this, 'employer_change_password' ) );
        add_action( 'wp_ajax_employer_change_password', array( $this, 'employer_change_password' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'load_form_scripts' ) );
    }

    public function setEmployer( $employer ) {
        $this->employer = $employer;
    }

    public function load_form_scripts( $hook ) {
        $form_js_url = plugins_url( 'job-offers/src/Admin/static/js/employer-password-form.js', 'job-offers.php' );

        wp_register_script( 'employer-password-form-js', $form_js_url, array( 'jquery' ) );

        $ajax_params = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'success_msg' => __('Password has been changed', 'job-offers')
        );

        wp_localize_script( 'employer-password-form-js', 'employer_password_form', $ajax_params );
        wp_enqueue_script( 'employer-password-form-js' );
    }

    public function html() {
        ?>
        <form id="employer-password-form" action="<?php echo $this->form_url; ?>" method="POST" style="margin-top: 30px; width: 50%;">
            <input type="hidden" name="employer_password_nonce" value="<?php echo $this->form_nonce; ?>" />
            <input type="hidden" name="action" value="<?php echo $this->form_action; ?>" />
            <input type="hidden" name="id" value="<?php echo $this->employer->get('id'); ?>" />

            <div class="form-group row">
                <label for="password" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Password', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control form-control-sm" />
                    <div class="invalid-feedback">
                        Password and it's confirmation must be the same!
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="confirm_password" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Confirm password', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="password" name="confirm_password" class="form-control form-control-sm" />
                    <div class="invalid-feedback">
                        Password and it's confirmation must be the same!
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm"><?php _e('Change password', 'job-offers'); ?></button>
        </form>
        <?php
    }

    public function employer_change_password() {
        
        if ( isset( $_POST['nonce'] ) && isset( $_POST['password'] ) && wp_verify_nonce( $_POST['nonce'], 'employer_change_password' ) ) {

            $employer_dao = new EmployerDAO();

            $result = $employer_dao->changePassword( $_POST['id'], $_POST['password'] );

            echo $result === false ? 0 : 1;

        } else {
            echo 0;
        }

        die();
    }

}

