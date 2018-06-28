<?php

namespace JobOffers\Admin\Pages;

interface PageInterface {

    function __construct();

    public function load_page();

    public function get_page_content();

    public function load_scripts( $hook );

    public function get_page_slug();

}