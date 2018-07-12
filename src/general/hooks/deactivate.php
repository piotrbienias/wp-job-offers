<?php


class JO_Deactivate {

    public static function deactivate_plugin() {
        JO_Deactivate::drop_tables();
    }

    public static function drop_tables() {
        global $wpdb;

        $job_offers_table = $wpdb->prefix . 'job_offers';
        $trades_table = $wpdb->prefix . 'trades';
        $employers_table = $wpdb->prefix . 'employers';
        $employees_table = $wpdb->prefix . 'employees';
        $employees_trades_table = $wpdb->prefix . 'employees_trades';

        $job_offers_query = "DROP TABLE IF EXISTS $job_offers_table";
        $trades_query = "DROP TABLE IF EXISTS $trades_table";
        $employers_query = "DROP TABLE IF EXISTS $employers_table";
        $employees_query = "DROP TABLE IF EXISTS $employees_table";
        $employees_trades_query = "DROP TABLE IF EXISTS $employees_trades_table";

        $wpdb->query( $job_offers_query );
        $wpdb->query( $trades_query );
        $wpdb->query( $employers_query );
        $wpdb->query( $employees_query );
        $wpdb->query( $employees_trades_query );
    }

}
register_deactivation_hook( JOB_OFFERS_MAIN_FILE_PATH, array( 'JO_Deactivate', 'deactivate_plugin') );