<?php

namespace JobOffers\Admin\Forms;

use JobOffers\Admin\DAO\JO_EmployerDAO;
use JobOffers\Admin\DAO\JO_TradeDAO;
use JobOffers\Admin\DAO\JO_JobOfferDAO;


class JobOfferForm {

    function __construct() {
        $this->form_action = 'save_job_offer';
        $this->form_nonce = wp_create_nonce( $this->form_action );
    }

    public function set_job_offer( $job_offer ) {
        $this->job_offer = $job_offer;
    }

    private function get_employers() {
        $employer_dao = new JO_EmployerDAO();
        $this->employers = $employer_dao->getEmployers();
    }

    private function get_trades() {
        $trade_dao = new JO_TradeDAO();
        $this->trades = $trade_dao->getTrades();
    }

    private function get_employers_select_html() {
        $this->get_employers();

        $html = '<select name="employer_id" class="custom-select-sm">';
        $current_employer = $this->job_offer->get('employer_id');

        foreach( $this->employers as $employer ) {
            $text = 'ID: ' . $employer->get('id') . ' - ' . $employer->get('company_name');
            $selected = $employer->get('id') == $current_employer ? 'selected="selected"' : '';
            $html .= '<option '.$selected.' value="'.$employer->get('id').'">'.$text.'</option>';
        }

        $html .= '</select>';

        return $html;
    }

    private function get_trades_select_html() {
        $this->get_trades();

        $html = '<select name="trade_id" class="custom-select-sm">';
        $current_trade = $this->job_offer->get('trade_id');

        foreach( $this->trades as $trade ) {
            $selected = $trade->get('id') == $current_trade ? 'selected="selected"' : '';
            $html .= '<option '.$selected.' value="'.$trade->get('id').'">'.$trade->get('name').'</option>';
        }

        $html .= '</select>';
        return $html;
    }

    public function html() {
        $action_url = admin_url( 'admin-ajax.php' );
        ?>

        <div id="job-offer-form-danger" class="alert alert-danger alert-dismissable fade show" role="alert">
            <?php _e('Error occurred while performing operation', 'job-offers'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="job-offer-form-success" class="alert alert-success alert-dismissable fade show" role="alert">
            <?php _e('Job offer has been saved', 'job-offers'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form id="job-offer-form" action="<?php echo esc_url( $action_url ); ?>" method="POST" style="width: 50%; margin-top: 30px;">

            <input type="hidden" name="job_offer_nonce" value="<?php echo $this->form_nonce; ?>" />
            <input type="hidden" name="action" value="<?php echo $this->form_action; ?>" />
            <input type="hidden" name="id" value="<?php echo $this->job_offer->get('id'); ?>" />

            <div class="form-group row">
                <label for="title" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Offer title', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" name="title" class="form-control form-control-sm" value="<?php echo $this->job_offer->get('title'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label for="company_id" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Employer', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <?php echo $this->get_employers_select_html(); ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="trade_id" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Trade', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <?php echo $this->get_trades_select_html(); ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Price range', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" name="price" class="form-control form-control-sm" value="<?php echo $this->job_offer->get('price'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Job description', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <textarea rows="3" name="description" class="form-control form-control-sm"><?php echo $this->job_offer->get('description'); ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="requirements" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('Requirements', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <textarea rows="3" name="requirements" class="form-control form-control-sm"><?php echo $this->job_offer->get('requirements'); ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="what_we_offer" class="col-sm-4 col-form-label col-form-label-sm"><?php _e('What we offer', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <textarea rows="3" name="what_we_offer" class="form-control form-control-sm"><?php echo $this->job_offer->get('what_we_offer'); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary"><?php _e('Save changes', 'job-offers'); ?></button>
        </form>
        <?php
    }

    public static function handle_update( $id, $data ) {
        unset( $data['id'] );
        $job_offer_dao = new JO_JobOfferDAO();
        return $job_offer_dao->updateJobOffer( $id, $data );
    }

    public static function handle_create( $data ) {
        $job_offer_dao = new JO_JobOfferDAO();
        return $job_offer_dao->createJobOffer( $data );
    }

}