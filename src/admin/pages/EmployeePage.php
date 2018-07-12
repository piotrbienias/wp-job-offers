<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\DAO\EmployeeDAO;
use JobOffers\Admin\Forms\EmployeeForm;


class EmployeePage extends BasePage {

    function __construct() {
        parent::__construct();

        $this->employee_dao = new EmployeeDAO();
        $this->employee_form = new EmployeeForm();
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            null,
            'Pracownik',
            'Pracownik',
            'manage_options',
            'employee',
            array( $this, 'get_page_content' )
        );
    }

    public function get_page_content() {
        $employee_id = isset( $_GET['id'] ) ? $_GET['id'] : null;

        $employee = $this->employee_dao->get_by_id( $employee_id );
        $this->employee_form->set_employee( $employee );
        
        echo $this->employee_form->html();
    }

}