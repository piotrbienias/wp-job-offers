<?php

namespace JobOffers\Admin\Tables;

use JobOffers\Admin\DAO\JobOfferDAO;


class JobOffersTable extends \WP_List_Table {

    public function prepare_items() {
        $this->_column_headers = array( $this->get_columns() );
        $this->items = $this->fetch_data();
    }

    public function get_columns() {
        $columns = [
            'cb'            => '<input type="checkbox" />',
            'title'         => __('Offer title', 'job-offers'),
            'employer'      => __('Employer', 'job-offers'),
            'trade'         => __('Trade', 'job-offers'),
            'valid_until'   => __('Valid until', 'job-offers')
        ];

        return $columns;
    }

    private function fetch_data() {
        $job_offer_dao = new JobOfferDAO();
        return $job_offer_dao->getJobOffers();
    }

    public function no_items() {
        _e('No job offers found', 'job-offers');
    }

    public function column_default( $item, $column_name ) {

        switch ($column_name) {
            case 'title':
                $url = admin_url( 'admin.php?page=job-offer&id=' . $item->get('id') );
                return '<a class="row-title" href="' . $url . '">' . $item->get('title') . '</a>';
            case 'trade':
                return $item->getTrade()->get('name');
            case 'employer':
                return $item->getEmployer()->get('company_name');
            default:
                return $item->get( $column_name );
        }
        
    }

}