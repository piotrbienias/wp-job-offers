<?php
/*
Plugin Name: Job Offers
Plugin URI: https://www.guidestack.pl/
Description: Create employers, employees and job offers
Version: 1.0
Author: Piotr Bienias
Author URI: https://www.guidestack.pl/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: job-offers
Domain Path: /languages
*/

use JobOffers\Admin\Pages\MainPage;


define( 'JOB_OFFERS_MAIN_FILE_PATH', __FILE__ );

require_once( 'vendor/autoload.php' );


// load plugin textdomain and create options pages
function load_job_offers_textdomain() {
    load_plugin_textdomain( 'job-offers', FALSE, basename( dirname(__FILE__) ) . '/languages/' );
    new MainPage();
}
add_action( 'plugins_loaded', 'load_job_offers_textdomain' );


// activation hook
require_once( 'src/general/hooks/activate.php' );


// This deactivation hook should be moved to uninstall.php
// because we are deleting database tables in it
require_once( 'src/general/hooks/deactivate.php' );