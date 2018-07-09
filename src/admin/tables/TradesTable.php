<?php

namespace JobOffers\Admin\Tables;

use JobOffers\Admin\DAO\TradeDAO;


class TradesTable extends \WP_List_Table {

    public $trade_dao = null;

    function __construct() {
        parent::__construct();

        $this->trade_dao = new TradeDAO();
    }

    public function get_table_classes() {
        $table_classes = parent::get_table_classes();
        array_push( $table_classes, 'narrow-id' );

        return $table_classes;
    }

    public function get_columns() {
        return [
            'id'                => 'ID',
            'name'              => __('Name', 'job-offers'),
            'job_offers_count'  => __('Job offers count', 'job-offers')
        ];
    }

    public function prepare_items() {
        $this->_column_headers = array( $this->get_columns() );
        $this->items = $this->fetch_data();
    }

    private function fetch_data() {
        return $this->trade_dao->getTrades();
    }

    public function no_items() {
        _e('No trades found', 'job-offers');
    }

    public function column_default( $item, $column_name ) {

        switch( $column_name ) {
            case 'name':
                $url = admin_url( 'admin.php?page=trade&id=' . $item->get('id') );
                $html = '<strong><a href="' . $url . '">' . $item->get('name') . '</a></strong>';
                return $html;
            case 'job_offers_count':
                return $this->trade_dao->getJobOffersCount( $item->get('id') );
            default:
                return $item->get( $column_name );
        }

    }

}