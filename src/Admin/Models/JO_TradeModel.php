<?php

namespace JobOffers\Admin\Models;


class JO_TradeModel {

    private $id = null;
    private $name;

    function __construct( $data ) {
        if ( ! is_array( $data ) ) {
            $data = [];
        }
     
        $this->map_trade( $data );
    }

    private function map_trade( $trade ) {
        foreach( $trade as $key => $value ) {
            $this->set( $key, $value );
        }
    }

    public function get( $key ) {
        return $this->$key;
    }

    public function set( $key, $value ) {
        $this->$key = $value;
    }

}