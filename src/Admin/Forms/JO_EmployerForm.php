<?php

namespace JobOffers\Admin\Forms;

use JobOffers\Admin\DAO\JO_EmployerDAO;


class JO_EmployerForm {

    function __construct( $employer = null) {
        $this->employer = $employer;

        $this->form_action = 'save_employer';
        $this->form_nonce = wp_create_nonce( $this->form_action );

        add_action( 'wp_ajax_nopriv_save_employer', array( $this, 'save_employer' ) );
        add_action( 'wp_ajax_save_employer', array( $this, 'save_employer' ) );
    }

    public function setEmployer( $employer ) {
        $this->employer = $employer;
    }

    public function html() {
        $action_url = esc_url( admin_url( 'admin-post.php' ) );
        $is_verified_checked = $this->employer->get('is_verified') ? 'checked' : '';
        $is_deleted_checked = $this->employer->get('is_deleted') ? 'checked': '';
        
        ?>
        <form id="employer-form" method="POST" action="<?php echo $action_url; ?>" style="width: 50%; margin-top: 45px;">
            <input type="hidden" name="action" value="<?php echo $this->form_action; ?>" />
            <input type="hidden" name="employer_nonce" value="<?php echo $this->form_nonce; ?>" />
            <input type="hidden" name="id" value="<?php echo $this->employer->get('id'); ?>" />

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_name"><?php _e('Company name', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_name" value="<?php echo $this->employer->get('company_name'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_street"><?php _e('Street', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_street" value="<?php echo $this->employer->get('company_street'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_street_number"><?php _e('Street number', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_street_number" value="<?php echo $this->employer->get('company_street_number'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_postal_code"><?php _e('Postal code', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_postal_code" value="<?php echo $this->employer->get('company_postal_code'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_city"><?php _e('City', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_city" value="<?php echo $this->employer->get('company_city'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_email"><?php _e('E-mail', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_email" value="<?php echo $this->employer->get('company_email'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="company_phone"><?php _e('Phone', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="company_phone" value="<?php echo $this->employer->get('company_phone'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="is_verified"><?php _e('Is verified?', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="checkbox" name="is_verified" class="form-check-input" <?php echo $is_verified_checked; ?>>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="is_deleted"><?php _e('Is deleted?', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="checkbox" name="is_deleted" class="form-check-input" <?php echo $is_deleted_checked; ?>>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary"><?php _e('Save changes', 'job-offers'); ?></button>
        </form>
        <?php
    }

    public static function handle_update( $id, $data ) {
        $employer_dao = new JO_EmployerDAO();
        return $employer_dao->updateEmployer( $id, $data );
    }

    public static function handle_create( $data ) {
        $employer_dao = new JO_EmployerDAO();
        return $employer_dao->createEmployer( $data );
    }

    public function save_employer() {
        
        if ( isset( $_POST['employer_nonce'] ) && wp_verify_nonce( $_POST['employer_nonce'], 'save_employer' ) ) {

            unset( $_POST['action'] );
            unset( $_POST['employer_nonce'] );
            if ( isset( $_POST['id'] ) && $_POST['id'] != '' ) {
                $result = self::handle_update( $_POST['id'], $_POST );
            } else {
                $result = self::handle_create( $_POST );
            }

            echo $result === false ? 'danger' : 'success';
        } else {
            echo 'danger';
        }
    
        die();
    }

}