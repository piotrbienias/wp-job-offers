<?php

namespace JobOffers\Admin\DAO;

use JobOffers\Admin\Helpers\JO_DAO;
use JobOffers\Admin\Models\JO_JobOfferModel;



class JO_JobOfferDAO extends JO_DAO {

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

        return new JO_JobOfferModel( $data );
    }

    public function getJobOffers() {
        $job_offers_db = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name",
            ARRAY_A
        );

        $job_offers = [];

        foreach( $job_offers_db as $job_offer ) {
            array_push( $job_offers, new JO_JobOfferModel( $job_offer ) );
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