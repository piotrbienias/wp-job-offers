<?php

spl_autoload_register( 'job_offers_namespace_autoload' );

function job_offers_namespace_autoload( $class_name ) {

    if ( false === strpos( $class_name, 'JobOffers' ) ) {
        return;
    }

    $file_parts = explode('\\', $class_name);

    unset( $file_parts[0] );

    $namespace = '';
    for( $i = 1; $i < sizeof( $file_parts ) + 1; $i++ ) {

        $current = $file_parts[$i];

        if ( sizeof( $file_parts ) == $i ) {
            $file_name = "$current.php";
        } else {
            $namespace .= '/' . $current;
        }

    }

    $filepath = trailingslashit( dirname(__FILE__) . '/src' . $namespace );
    $filepath .= $file_name;

    if ( file_exists( $filepath ) ) {
        include_once( $filepath );
    } else {
        wp_die(
            esc_html( "File at $filepath does not exist / $namespace / $current / $class_name" )
        );
    }

}