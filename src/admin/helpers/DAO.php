<?php

namespace JobOffers\Admin\Helpers;


class DAO {

    function __construct( $table_name ) {
        global $wpdb;

        $this->table_name = $wpdb->prefix . $table_name;
        $this->wpdb = $wpdb;
    }

    public function create( $data ) {
        return $this->wpdb->insert(
            $this->table_name,
            $data
        );
    }

}