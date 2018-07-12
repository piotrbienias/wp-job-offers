<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Models\TradeModel;
use JobOffers\Admin\Models\EmployeeModel;
use JobOffers\Admin\Helpers\DAO;


class EmployeeDAO extends DAO {

    function __construct() {
        parent::__construct('employees', EmployeeModel::class);
    }

    public function get_employee_trades( $employee_id ) {
        $db_data = $this->wpdb->get_results(
            "SELECT trades.id, trades.name FROM wp_trades AS trades
             LEFT JOIN wp_employees_trades AS employee_trades
             ON trades.id = employee_trades.trade_id
             WHERE employee_trades.employee_id = $employee_id",
             ARRAY_A
        );

        $trades = [];
        foreach( $db_data as $trade ) {
            array_push( $trades, new TradeModel( $trade ) );
        }

        return $trades;
    }

}