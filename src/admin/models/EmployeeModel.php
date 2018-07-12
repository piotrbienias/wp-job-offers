<?php

namespace JobOffers\Admin\Models;

use JobOffers\Admin\DAO\EmployeeDAO;


class EmployeeModel extends BaseModel {

    protected $id = null;

    protected $name;
    protected $last_name;
    protected $email;
    protected $phone;

    protected $is_verified;
    protected $is_deleted;

    public function get_trades() {
        $employee_dao = new EmployeeDAO('employees', EmployeeModel::class);
        return $employee_dao->get_employee_trades( $this->get('id') );
    }

}