<?php

require_once(dirname(__FILE__) . '/../tables.php');


class JO_Activate {

    public static function activate_plugin() {
        JO_Activate::create_tables();
    }

    public static function create_tables() {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        JO_Activate::create_employers_table();
        JO_Activate::create_employees_table();
        JO_Activate::create_trades_table();
        JO_Activate::create_job_offers_table();
    }

    private static function create_employers_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'employers';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = JO_DatabaseTablesSQL::get_employers_table();
        $sql = str_replace('*table_name*', $table_name, $sql);
        $sql = str_replace('*charset_collate*', $charset_collate, $sql);

        dbDelta( $sql );
    }

    private static function create_employees_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'employees';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = JO_DatabaseTablesSQL::get_employees_table();
        $sql = str_replace('*table_name*', $table_name, $sql);
        $sql = str_replace('*charset_collate*', $charset_collate, $sql);

        dbDelta( $sql );
    }

    private static function create_trades_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'trades';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = JO_DatabaseTablesSQL::get_trades_table();
        $sql = str_replace('*table_name*', $table_name, $sql);
        $sql = str_replace('*charset_collate*', $charset_collate, $sql);

        dbDelta( $sql );
    }

    private static function create_job_offers_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'job_offers';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = JO_DatabaseTablesSQL::get_job_offers_table();
        $sql = str_replace('*table_name*', $table_name, $sql);
        $sql = str_replace('*charset_collate*', $charset_collate, $sql);

        dbDelta( $sql );
    }

}
register_activation_hook( JOB_OFFERS_MAIN_FILE_PATH, array( 'JO_Activate', 'activate_plugin' ) );