<?php

namespace JobOffers\Admin\Helpers;


/**
 * Base Data Access Object class responsible for performing
 * database operations on given Model.
 */
class DAO {

    /**
     * DAO Constructor
     * 
     * @param $table_name Database table name on which operations will be performed
     * @param @model Application model being representation of database table
     */
    function __construct( $table_name, $model = null ) {
        global $wpdb;
        if ( !$model ) {
            $model = new \stdClass();
        }

        $this->table_name = $wpdb->prefix . $table_name;
        $this->wpdb = $wpdb;
        $this->model = $model;
    }

    /**
     * Add new row to specified database table
     * 
     * @param $data Array of data to be inserted in the database
     */
    public function create( $data ) {
        return $this->wpdb->insert(
            $this->table_name,
            $data
        );
    }

    /**
     * Update single row in specified database table
     * 
     * @param $id Primary key value of row to be updated
     * @param $data Array of data to be used when updating row
     */
    public function update( $id, $data ) {
        return $this->wpdb->update(
            $this->table_name,
            $data,
            array( $this->model::$primary_key, $id )
        );
    }

    /**
     * Returns all rows from specified database table in form of Application Models
     * 
     * @return Array<Model> Returns array of application model instances
     */
    public function get_all() {
        $db_data = $this->wpdb->get_results(
            "SELECT * FROM $this->table_name",
            ARRAY_A
        );

        $elements = [];
        foreach( $db_data as $single_object ) {
            array_push( $elements, new $this->model( $single_object ) );
        }

        return $elements;
    }

    /**
     * Returns single row from specified database table in form of Application Model
     * 
     * @param $id Primary key value of row to be returned
     * @return Model Returns single instance of application model
     */
    public function get_by_id( $id = null ) {
        $data = [];

        if ( $id ) {
            $data = $this->wpdb->get_row(
                "SELECT * FROM $this->table_name WHERE {$this->model::$primary_key} = $id",
                ARRAY_A
            );
        }

        return new $this->model( $data );
    }

}