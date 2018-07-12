<?php

namespace JobOffers\Admin\Tables;

use JobOffers\Admin\DAO\EmployeeDAO;


class EmployeesTable extends \WP_List_Table {

    public $employee_dao = null;

    function __construct() {
        parent::__construct();

        $this->employee_dao = new EmployeeDAO();
    }

    public function get_table_classes() {
        $table_classes = parent::get_table_classes();
        array_push( $table_classes, 'narrow-id' );

        return $table_classes;
    }

    public function get_columns() {
        return [
            'id'        => 'ID',
            'name'      => __('First and last name', 'job-offers'),
            'email'     => __('E-mail', 'job-offers'),
            'phone'     => __('Phone', 'job-offers')
        ];
    }

    public function prepare_items() {
        $this->_column_headers = array( $this->get_columns() );
        $this->items = $this->fetch_data();
    }

    public function fetch_data() {
        return $this->employee_dao->get_all();
    }

    public function no_items() {
        _e('No employees found', 'job-offers');
    }

    public function column_default( $item, $column_name ) {

        switch( $column_name ) {
            case 'name':
                $url = admin_url( 'admin.php?page=employee&id=' . $item->get('id') );
                $html = '<strong><a href="' . $url . '">' . $item->get('name') . ' ' . $item->get('last_name') . '</a></strong>';
                return $html;
            default:
                return $item->get( $column_name );
        }

    }

}