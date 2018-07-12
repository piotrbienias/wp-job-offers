<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Tables\EmployeesTable;


class EmployeesPage extends BasePage {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            'job-offers',
            __('Employees', 'job-offers'),
            __('Employees', 'job-offers'),
            'manage_options',
            'employees',
            array( $this, 'get_page_content' )
        );
    }

    public function get_page_content() {
        $employees_table = new EmployeesTable();
        $employees_table->prepare_items();

        $add_new_url = admin_url( 'admin.php?page=employee' );

        ?>

        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Employees', 'job-offers'); ?></h1>
            <a href="<?php echo $add_new_url; ?>" class="page-title-action"><?php _e('Add new employee', 'job-offers'); ?></a>
            <div id="poststuff">
                <form id="jo-employers" method="get">					
                    <?php $employees_table->display(); ?>					
                </form>
            </div>
        </div>

        <?php
    }

}