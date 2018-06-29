<?php

namespace JobOffers\Admin\Models;

use JobOffers\Admin\DAO;


class JobOfferModel {

    private $id = null;

    private $employer_id;
    private $title;
    private $trade_id;
    private $price;
    private $description;
    private $requirements;
    private $what_we_offer;
    private $valid_until;

    function __construct( $data ) {
        if ( !is_array($data) ) {
            $data = [];
        }

        $this->map_job_offer( $data );
    }

    private function map_job_offer( $job_offer ) {
        foreach( $job_offer as $key => $value ) {
            $this->set($key, $value);
        }
    }

    public function getEmployer() {
        $employer_dao = new DAO\EmployerDAO();
        return $employer_dao->getEmployer( $this->get('employer_id') );
    }

    public function getTrade() {
        $trade_dao = new DAO\TradeDAO();
        return $trade_dao->getTrade( $this->get('trade_id') );
    }

    public function get( $key ) {
        return $this->$key;
    }

    public function set( $key, $value ) {
        $this->$key = $value;
    }

}