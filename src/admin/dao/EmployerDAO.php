<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Helpers\DAO;
use JobOffers\Admin\Models\EmployerModel;
use JobOffers\Admin\Models\JobOfferModel;



class EmployerDAO extends DAO {

    function __construct() {
        parent::__construct('employers');
    }

    public function getEmployer( $id ) {
        $data = [];
        if ( $id ){
            $data = $this->wpdb->get_row(
                "SELECT * FROM $this->table_name WHERE id = $id",
                ARRAY_A
            );
        }

        return new EmployerModel( $data );
    }

    public function getEmployers() {
        $employers_db = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name",
            ARRAY_A
        );

        $employers = array();
        foreach( $employers_db as $single_employer ) {
            array_push( $employers, new EmployerModel( $single_employer ) );
        }

        return $employers;
    }

    public function getJobOffers( $id ) {
        $job_offers_db = [];

        if ( $id ) {
            $job_offers_db = $this->wpdb->get_results(
                "SELECT * FROM {$this->wpdb->prefix}job_offers
                 WHERE employer_id = $id",
                 ARRAY_A
            );
        }

        $job_offers = array();
        foreach( $job_offers_db as $job_offer ) {
            array_push( $job_offers, new JobOfferModel($job_offer) );
        }

        return $job_offers;
    }

    public function countJobOffers( $id ) {
        $job_offers_count = null;
        if ( $id ) {
            $job_offers_count = $this->wpdb->get_var(
                "SELECT COUNT(id) FROM {$this->wpdb->prefix}job_offers
                WHERE employer_id = $id"
            );
        }

        return $job_offers_count;
    }

    public function updateEmployer( $id, $data ) {
        return $this->wpdb->update(
            $this->table_name,
            $data,
            array( 'id' => $id )
        );
    }

    public function createEmployer( $data ) {
        return $this->wpdb->insert(
            $this->table_name,
            $data
        );
    }

    public function changePassword( $id, $password ) {
        if ( $id && $password && $id != '' && $password != '' ){
            return $this->wpdb->update(
                $this->table_name,
                array( 'password' => md5($password) ),
                array( 'id' => $id )
            );
        }

        return false;
    }

}