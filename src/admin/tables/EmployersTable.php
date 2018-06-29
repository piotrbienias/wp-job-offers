<?php

namespace JobOffers\Admin\Tables;

use JobOffers\Admin\DAO\EmployerDAO;



class EmployersTable extends \WP_List_Table {

    function __construct() {
        parent::__construct();

        $this->employer_dao = new EmployerDAO();
    }

    public function get_columns() {
        $columns = [
            'cb'                => '<input type="checkbox" />',
            'company_name'      => __('Company name', 'job-offers'),
            'company_city'      => __('City', 'job-offers'),
            'company_email'     => __('E-mail', 'job-offers'),
            'company_phone'     => __('Phone', 'job-offers'),
            'is_verified'       => __('Is verified?', 'job-offers'),
            'is_deleted'        => __('Is deleted?', 'job-offers')
        ];

        return $columns;
    }

    public function no_items() {
        _e('No employers found', 'job-offers');
    }

    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value"%s" />',
            $item->get('id')
        );
    }

    public function prepare_items() {
        $this->_column_headers = array( $this->get_columns() );
        $data = $this->fetch_table_data();

        $this->items = $data;
    }

    public function fetch_table_data() {
        $employer_dao = new EmployerDAO();
        return $employer_dao->getEmployers();
    }

    public function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'company_name':
                $path = 'admin.php?page=employer&id='. $item->get('id');
                $url = admin_url( $path );

                return "<a class='row-title' href='{$url}'>" . $item->get($column_name) . "</a>";
            case 'is_verified':
            case 'is_deleted':
                return $item->get($column_name) == 0 ? 'No' : 'Yes';
            default:
                return $item->get($column_name);
        }
    }

}