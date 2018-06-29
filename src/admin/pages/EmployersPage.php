<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Tables\EmployersTable;


class EmployersPage implements PageInterface {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            'job-offers',
            __('Employers', 'job-offers'),
            __('Employers', 'job-offers'),
            'manage_options',
            'employers',
            array( $this, 'get_page_content' )
        );
    }

    public function load_scripts( $hook ) {
        
    }

    public function get_page_content() {
        $employers_table = new EmployersTable();
        $employers_table->prepare_items();

        $add_new_url = admin_url( 'admin.php?page=employer' );

        ?>
        
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Employers', 'job-offers'); ?></h1>
            <a href="<?php echo $add_new_url; ?>" class="page-title-action"><?php _e('Add new', 'job-offers'); ?></a>
            <div id="poststuff">
                <form id="jo-employers" method="get">					
                    <?php $employers_table->display(); ?>					
                </form>
            </div>
        </div>
        <?php
    }

    public function get_page_slug() {
        return $this->page_slug;
    }

}