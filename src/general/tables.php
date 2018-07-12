<?php

class JO_DatabaseTablesSQL {

    public static function get_employers_table() {

        return "CREATE TABLE *table_name* (
            id INT(9) NOT NULL AUTO_INCREMENT,
            company_name VARCHAR(256) NOT NULL,
            company_street VARCHAR(256) NOT NULL,
            company_street_number VARCHAR(16) NOT NULL,
            company_postal_code VARCHAR(16) NOT NULL,
            company_city VARCHAR(128) NOT NULL,
            company_email VARCHAR(256) NOT NULL,
            company_phone VARCHAR(64),
            password VARCHAR(1024) NOT NULL,
            invoice_street VARCHAR(256),
            invoice_street_number VARCHAR(64),
            invoice_postal_code VARCHAR(16),
            invoice_city VARCHAR(128),
            invoice_vat VARCHAR(128),
            is_verified BOOLEAN NOT NULL DEFAULT 0,
            is_deleted BOOLEAN NOT NULL DEFAULT 0,
            PRIMARY KEY (id)
        ) *charset_collate*;";

    }

    public static function get_employees_table() {

        return "CREATE TABLE *table_name* (
            id INT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(256) NOT NULL,
            last_name VARCHAR(256) NOT NULL,
            phone VARCHAR(256),
            email VARCHAR(256) NOT NULL,
            password VARCHAR(1024) NOT NULL,
            is_verified BOOLEAN NOT NULL DEFAULT 0,
            is_deleted BOOLEAN NOT NULL DEFAULT 0,
            PRIMARY KEY(id),
            UNIQUE(email)
        ) *charset_collate*;";

    }

    public static function get_trades_table() {

        return "CREATE TABLE *table_name* (
            id INT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(128) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (name)
        ) *charset_collate*;";

    }

    public static function get_employees_trades_table() {

        global $wpdb;

        return "CREATE TABLE *table_name* (
            employee_id INT(9) NOT NULL,
            trade_id INT(9) NOT NULL,
            PRIMARY KEY(employee_id, trade_id),
            FOREIGN KEY (employee_id) REFERENCES {$wpdb->prefix}employees(id),
            FOREIGN KEY (trade_id) REFERENCES {$wpdb->prefix}trades(id)
        ) *charset_collate*;";
        
    }

    public static function get_job_offers_table() {

        global $wpdb;

        return "CREATE TABLE *table_name* (
            id INT(9) NOT NULL AUTO_INCREMENT,
            employer_id INT(9) NOT NULL,
            title VARCHAR(256) NOT NULL,
            trade_id INT(9) NOT NULL,
            price VARCHAR(128) NOT NULL,
            description TEXT,
            requirements TEXT,
            what_we_offer TEXT,
            valid_until DATE NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (employer_id) REFERENCES {$wpdb->prefix}employers(id),
            FOREIGN KEY (trade_id) REFERENCES {$wpdb->prefix}trades(id)
        ) *charset_collate*;";

    }

}