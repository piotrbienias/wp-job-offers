<?php

namespace JobOffers\Admin\Pages;


class BasePage implements PageInterface {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
    }

    public function load_page() {}

    public function get_page_content() {}

    public function load_scripts( $hook ) {}

    public function get_page_slug() {
        return $this->page_slug;
    }

}