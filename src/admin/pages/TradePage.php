<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Forms\TradeForm;
use JobOffers\Admin\DAO\TradeDAO;


class TradePage extends BasePage implements PageInterface {

    function __construct() {
        parent::__construct();

        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        $this->trade_form = new TradeForm();
        $this->trade_dao = new TradeDAO();
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            null,
            __('Trade', 'job-offers'),
            __('Trade', 'job-offers'),
            'manage_options',
            'trade',
            array( $this, 'get_page_content' )
        );
    }

    public function load_scripts( $hook ) {
        $trade_form_js = plugins_url( 'wp-job-offers/src/admin/static/js/trade-form.js', 'wp-job-offers.php' );
        $trade_page_css = plugins_url( 'wp-job-offers/src/admin/static/css/trade-page.css', 'wp-job-offers.php' );

        wp_enqueue_script( 'trade-form-script', $trade_form_js, array( 'jquery' ) );
        wp_localize_script( 'trade-form-script', 'trade_form', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

        wp_enqueue_style( 'trade-page-style', $trade_page_css );
    }

    public function get_page_content() {
        $trade_id = isset( $_GET['id'] ) ? $_GET['id'] : null;
        $page_title = isset( $trade_id ) ? __('Edit trade', 'job-offers') : __('Add new trade', 'job-offers');

        $trade = $this->trade_dao->getTrade( $trade_id );

        $this->trade_form->set_trade( $trade );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php echo $page_title; ?></h1>
            <?php $this->trade_form->html(); ?>
        </div>
        <?php
    }

}