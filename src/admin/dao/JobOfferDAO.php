<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Helpers\DAO;
use JobOffers\Admin\Models\JobOfferModel;



class JobOfferDAO extends DAO {

    function __construct() {
        parent::__construct('job_offers');
    }

    public function getJobOffer( $job_offer_id ) {
        $data = [];
        if ( $job_offer_id ) {
            $data = $this->wpdb->get_row(
                "SELECT * FROM $this->table_name WHERE id = $job_offer_id",
                ARRAY_A
            );
        }

        return new JobOfferModel( $data );
    }

    public function getJobOffers() {
        $job_offers_db = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name",
            ARRAY_A
        );

        $job_offers = [];

        foreach( $job_offers_db as $job_offer ) {
            array_push( $job_offers, new JobOfferModel( $job_offer ) );
        }

        return $job_offers;
    }

    public function updateJobOffer( $id, $data ) {
        return $this->wpdb->update(
            $this->table_name,
            $data,
            array( 'id' => $id )
        );
    }

    public function createJobOffer( $data ) {
        return $this->wpdb->insert(
            $this->table_name,
            $data
        );
    }

}