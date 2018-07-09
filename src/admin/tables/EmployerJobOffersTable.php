<?php

namespace JobOffers\Admin\Tables;

use JobOffers\Admin\DAO\EmployerDAO;


class EmployerJobOffersTable extends JobOffersTable {

    public $employer_id = null;

    public function set_employer_id( $employer_id ) {
        $this->employer_id = $employer_id;
    }

    public function fetch_data() {
        if ( isset( $this->employer_id ) && $this->employer_id > 0 ) {
            $employer_dao = new EmployerDAO();
            return $employer_dao->getJobOffers( $this->employer_id );
        }

        return [];
    }

}