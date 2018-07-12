<?php

namespace JobOffers\Admin\Forms;

use JobOffers\Admin\DAO\EmployeeDAO;
use JobOffers\Admin\DAO\TradeDAO;


class EmployeeForm {

    function __construct() {
        $this->employee_dao = new EmployeeDAO();
        $this->trade_dao = new TradeDAO();

        $this->form_action = 'save_employee';
        $this->form_nonce = wp_create_nonce( $this->form_action );

        $this->get_all_trades();
    }

    public function set_employee( $employee ) {
        $this->employee = $employee;
    }

    private function get_all_trades() {
        $this->trades = $this->trade_dao->getTrades();
    }

    public function html() {
        $action_url = admin_url( 'admin-post.php' );

        $is_verified_checked = $this->employee->get('is_verified') ? 'checked' : '';
        $is_deleted_checked = $this->employee->get('is_deleted') ? 'checked' : '';

        $employee_trades = $this->employee->get_trades();
        $employee_trades_ids = array_map( create_function( '$t', 'return $t->get("id");' ), $employee_trades );

        ?>

        <form method="POST" action="<?php echo $action_url; ?>" id="employee-form" style="width: 50%; margin-top: 45px;">
            <input type="hidden" name="employee_nonce" value="<?php echo $this->form_nonce; ?>" />
            <input type="hidden" name="action" value="<?php echo $this->form_action; ?>" />
            <input type="hidden" name="id" value="<?php echo $this->employee->get('id'); ?>" />

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="name"><?php _e('First name', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="name" value="<?php echo $this->employee->get('name'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="last_name"><?php _e('Last name', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="last_name" value="<?php echo $this->employee->get('last_name'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="email"><?php _e('E-mail', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="email" value="<?php echo $this->employee->get('email'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="phone"><?php _e('Phone', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input required type="text" class="form-control form-control-sm" name="phone" value="<?php echo $this->employee->get('phone'); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="trades"><?php _e('Trades', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <select multiple class="form-control form-control-sm" name="trades">
                        <?php foreach( $this->trades as $trade ): ?>
                            <?php $selected = in_array( $trade->get('id'), $employee_trades_ids ) ? 'selected' : ''; ?>
                            <option value="<?php echo $trade->get('id'); ?>" <?php echo $selected; ?>><?php echo $trade->get('name'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="is_verified"><?php _e('Is verified?', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="checkbox" class="form-control form-control-sm" name="is_verified" <?php echo $is_verified_checked; ?> />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label col-form-label-sm" for="is_deleted"><?php _e('Is deleted?', 'job-offers'); ?></label>
                <div class="col-sm-8">
                    <input type="checkbox" class="form-control form-control-sm" name="is_deleted" <?php echo $is_deleted_checked; ?> />
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary"><?php _e('Save changes', 'job-offers'); ?></button>
        </form>

        <?php
    }

}