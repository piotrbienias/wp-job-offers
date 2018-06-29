<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Tables\JobOffersTable;


class JobOffersPage implements PageInterface {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            'job-offers',
            __('Job offers', 'job-offers'),
            __('Job offers', 'job-offers'),
            'manage_options',
            'job-offers',
            array( $this, 'get_page_content' )
        );
    }

    public function get_page_content() {
        $job_offers_table = new JobOffersTable();
        $job_offers_table->prepare_items();

        $add_new_url = admin_url( 'admin.php?page=job-offer' );

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Job offers', 'job-offers'); ?></h1>
            <a href="<?php echo $add_new_url; ?>" class="page-title-action"><?php _e('Add new job offer', 'job-offers'); ?></a>
            <div id="poststuff">
                <?php $job_offers_table->display(); ?>
            </div>
        </div>
        <?php
    }

    public function load_scripts( $hook ) {
        
    }

    public function get_page_slug() {
        return $this->page_slug;
    }

}