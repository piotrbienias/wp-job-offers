<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Helpers\DAO;
use JobOffers\Admin\Models\TradeModel;



class TradeDAO extends DAO {

    function __construct() {
        parent::__construct( 'trades' );
    }

    public function getTrades() {
        $trades_db = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name
             ORDER BY id ASC",
            ARRAY_A
        );

        $trades = [];

        foreach( $trades_db as $trade ) {
            array_push( $trades, new TradeModel( $trade ) );
        }

        return $trades;
    }

    public function getTrade( $trade_id ) {
        $data = [];

        if ( $trade_id ) {
            $data = $this->wpdb->get_row(
                "SELECT * FROM $this->table_name WHERE id = $trade_id",
                ARRAY_A
            );
        }

        return new TradeModel( $data );
    }

    public function updateTrade( $id, $data ) {
        unset( $data['id'] );
        
        return $this->wpdb->update(
            $this->table_name,
            $data,
            array( 'id' => $id )
        );
    }

    public function createTrade( $data ) {
        return $this->wpdb->insert(
            $this->table_name,
            $data
        );
    }

    public function getJobOffersCount( $trade_id ) {
        $job_offers_count = $this->wpdb->get_var(
            "SELECT COUNT(id) FROM {$this->wpdb->prefix}job_offers
             WHERE trade_id = $trade_id"
        );

        return $job_offers_count;
    }

}