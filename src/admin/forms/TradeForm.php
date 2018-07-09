<?php

namespace JobOffers\Admin\Forms;

use JobOffers\Admin\DAO\TradeDAO;


class TradeForm {

    public $trade = null;

    function __construct( $trade = null ) {
        $this->set_trade( $trade );

        $this->trade_dao = new TradeDAO();

        $this->form_action = 'save_trade';
        $this->form_nonce = wp_create_nonce( $this->form_action );

        add_action( 'wp_ajax_nopriv_save_trade', array( $this, 'save_trade' ) );
        add_action( 'wp_ajax_save_trade', array( $this, 'save_trade' ) );
    }

    public function set_trade( $trade ) {
        $this->trade = $trade;
    }

    public function html() {
        $action_url = esc_url( admin_url( 'admin-post.php' ) );

        ?>
        <div id="trade-form-0" class="alert alert-danger alert-dismissable fade show" role="alert">
            <?php _e('Error occurred while performing operation', 'job-offers'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="trade-form-1" class="alert alert-success alert-dismissable fade show" role="alert">
            <?php _e('Trade has been saved', 'job-offers'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form id="trade-form" methpd="POST" action="<?php echo $action_url; ?>" style="width: 50%; margin-top: 45px;">
            <input type="hidden" name="action" value="<?php echo $this->form_action; ?>" />
            <input type="hidden" name="trade_nonce" value="<?php echo $this->form_nonce; ?>" />
            <input type="hidden" name="id" value="<?php echo $this->trade->get('id'); ?>" />

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="name"><?php _e('Name', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="name" value="<?php echo $this->trade->get('name'); ?>" />
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary"><?php _e('Save changes', 'job-offers'); ?></button>
        </form>
        <?php
    }

    public function save_trade() {

        if ( isset( $_POST['trade_nonce'] ) && wp_verify_nonce( $_POST['trade_nonce'], $this->form_action ) ) {

            $result = false;
            unset( $_POST['action'] );
            unset( $_POST['trade_nonce'] );
            if ( isset( $_POST['id'] ) && $_POST['id'] != '' ) {
                $result = $this->trade_dao->updateTrade( $_POST['id'], $_POST );
            } else {
                $result = $this->trade_dao->createTrade( $_POST );
            }

            echo $result === false ? 0 : 1;
            
        } else {
            echo 0;
        }

        die();

    }

}