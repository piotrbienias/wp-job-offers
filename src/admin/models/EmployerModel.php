<?php

namespace JobOffers\Admin\Models;


class EmployerModel {

    private $id = null;

    private $company_name;
    private $company_street;
    private $company_street_number;
    private $company_postal_code;
    private $company_city;
    private $company_email;
    private $company_phone;

    private $invoice_street;
    private $invoice_street_number;
    private $invoice_postal_code;
    private $invoice_city;
    private $invoice_vat;

    private $is_verified;
    private $is_deleted;

    private $password;

    function __construct( $data ) {
        global $wpdb;

        $this->map_employer( $data );
    }

    private function map_employer( $employer ) {
        foreach( $employer as $key => $value ) {
            $this->$key = $value;
        }
    }

    public function get( $key ) {
        return $this->$key;
    }

    public function set( $key, $value ) {
        $this->$key = $value;
    }

}