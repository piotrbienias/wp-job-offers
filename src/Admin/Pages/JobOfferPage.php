<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\DAO\JO_JobOfferDAO;
use JobOffers\Admin\Forms\JobOfferForm;


class JobOfferPage extends BasePage implements PageInterface  {

    function __construct() {
        parent::__construct();

        $this->job_offer_form = new JobOfferForm();

        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        add_action( 'wp_ajax_nopriv_save_job_offer', array( $this, 'save_job_offer' ) );
        add_action( 'wp_ajax_save_job_offer', array( $this, 'save_job_offer' ) );
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            null,
            __('Job offer', 'job-offers'),
            __('Job offer', 'job-offers'),
            'manage_options',
            'job-offer',
            array( $this, 'get_page_content' )
        );
    }

    public function get_page_content() {
        $job_offer_id = isset( $_GET['id'] ) ? $_GET['id'] : null;

        $job_offer_dao = new JO_JobOfferDAO();
        $job_offer = $job_offer_dao->getJobOffer( $job_offer_id );

        $this->job_offer_form->set_job_offer( $job_offer );

        $page_title = $job_offer_id ? __('Update job offer', 'job-offers') : __('Create new job offer', 'job-offers');

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php echo $page_title; ?></h1>
            <?php $this->job_offer_form->html(); ?>
        </div>
        <?php
    }

    public function load_scripts( $hook ) {
        if ( $hook == $this->page_slug ) {
            $plugins_url_js = plugins_url( 'job-offers/src/Admin/static/js/job-offer-page.js', 'job-offers.php' );
            $plugins_url_css = plugins_url( 'job-offers/src/Admin/static/css/job-offer-page.css', 'job-offers.php' );

            $job_offer_params = array(
                'ajax_url'  => esc_url( admin_url( 'admin-ajax.php' ) )
            );

            wp_enqueue_style( 'job-offer-page-style', $plugins_url_css );

            wp_register_script( 'job-offer-page-script', $plugins_url_js, array( 'jquery' ));
            wp_localize_script( 'job-offer-page-script', 'job_offer_params', $job_offer_params );

            wp_enqueue_script( 'job-offer-page-script' );
        }
    }

    public function save_job_offer() {

        if ( isset( $_POST['job_offer_nonce'] ) && wp_verify_nonce( $_POST['job_offer_nonce'], 'save_job_offer' ) ) {

            unset( $_POST['job_offer_nonce'] );
            unset( $_POST['action'] );
            if ( isset( $_POST['id'] ) && $_POST['id'] != '' ) {
                $result = JobOfferForm::handle_update( $_POST['id'], $_POST );
            } else {
                $result = JobOfferForm::handle_create( $_POST );
            }

            echo $result === false ? 0 : 1;
            
        } else {
            echo 0;
        }

        die();

    }

}