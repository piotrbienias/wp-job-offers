<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Helpers\JO_DAO;
use JobOffers\Admin\Models\JO_TradeModel;



class JO_TradeDAO extends JO_DAO {

    function __construct() {
        parent::__construct( 'trades' );
    }

    public function getTrades() {
        $trades_db = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name",
            ARRAY_A
        );

        $trades = [];

        foreach( $trades_db as $trade ) {
            array_push( $trades, new JO_TradeModel( $trade ) );
        }

        return $trades;
    }

    public function getTrade( $trade_id ) {
        $trade_db = $this->wpdb->get_row(
            "SELECT * FROM $this->table_name WHERE id = $trade_id",
            ARRAY_A
        );

        return new JO_TradeModel( $trade_db );
    }

}