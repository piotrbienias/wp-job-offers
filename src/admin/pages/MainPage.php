<?php

namespace JobOffers\Admin\Pages;


class MainPage implements PageInterface {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        $this->job_offers_page = new JobOffersPage();
        $this->job_offer_page = new JobOfferPage();

        $this->employers_page = new EmployersPage();
        $this->employer_page = new EmployerPage();

        $this->trades_page = new TradesPage();
        $this->trade_page = new TradePage();
    }

    public function load_page() {
        $this->page_slug = add_menu_page(
            __('Job offers', 'job-offers'),
            __('Job offers', 'job-offers'),
            'manage_options',
            'job-offers'
        );
    }

    public function load_scripts( $hook ) {
        $slugs = [
            $this->page_slug,
            $this->job_offers_page->get_page_slug(),
            $this->job_offer_page->get_page_slug(),
            $this->employers_page->get_page_slug(),
            $this->employer_page->get_page_slug(),
            $this->trades_page->get_page_slug(),
            $this->trade_page->get_page_slug()
        ];

        if ( in_array( $hook, $slugs ) ){
            wp_enqueue_style( 'admin-general-css', plugins_url( 'wp-job-offers/src/admin/static/css/general.css', 'wp-job-offers.php' ) );
            wp_enqueue_style( 'admin-bootstrap-css', plugins_url( 'wp-job-offers/src/admin/static/bootstrap/bootstrap.min.css', 'wp-job-offers.php' ) );

            wp_enqueue_script( 'admin-bootstrap-js', plugins_url( 'wp-job-offers/src/admin/static/bootstrap/bootstrap.min.js', 'wp-job-offers.php' ), array( 'jquery' ) );
        }
    }

    public function get_page_content(){}

    public function get_page_slug() {
        return $this->page_slug;
    }

}