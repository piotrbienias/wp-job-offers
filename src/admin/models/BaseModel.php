<?php

namespace JobOffers\Admin\Models;


class BaseModel {

    public static $primary_key = 'id';

    function __construct( $data ) {
        $this->map_data( $data );
    }

    public function map_data( $data ){
        foreach( $data as $key => $value ) {
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