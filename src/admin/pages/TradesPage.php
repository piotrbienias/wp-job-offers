<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Tables\TradesTable;


class TradesPage extends BasePage implements PageInterface {

    function __construct(){
        add_action( 'admin_menu', array( $this, 'load_page' ) );
    }

    public function load_page(){
        $this->page_slug = add_submenu_page(
            'job-offers',
            __('Trades', 'job-offers'),
            __('Trades', 'job-offers'),
            'manage_options',
            'trades',
            array( $this, 'get_page_content' )
        );
    }

    public function get_page_content(){
        $trades_table = new TradesTable();
        $trades_table->prepare_items();

        $add_new_url = admin_url( 'admin.php?page=trade' );

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Trades', 'job-offers'); ?></h1>
            <a href="<?php echo $add_new_url; ?>" class="page-title-action"><?php _e('Add new trade', 'job-offers'); ?></a>
            <div id="poststuff">
                <?php $trades_table->display(); ?>
            </div>
        </div>
        <?php
    }

    public function load_scripts( $hook ){

    }

}