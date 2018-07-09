<?php

namespace JobOffers\Admin\Pages;

use JobOffers\Admin\Forms;
use JobOffers\Admin\DAO\EmployerDAO;
use JobOffers\Admin\Tables\EmployerJobOffersTable;


class EmployerPage implements PageInterface {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'load_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

        $this->employer_form = new Forms\EmployerForm();
        $this->employer_password_form = new Forms\EmployerPasswordForm();
    }

    public function load_page() {
        $this->page_slug = add_submenu_page(
            null,
            __('Employer', 'job-offers'),
            __('Employer', 'job-offers'),
            'manage_options',
            'employer',
            array( $this, 'get_page_content' )
        );
    }

    public function load_scripts( $hook ) {
        $script_path = plugins_url( 'wp-job-offers/src/admin/static/js/employer-form.js', 'wp-job-offers.php' );
        wp_enqueue_script( 'employer-form-script', $script_path, array( 'jquery' ) );
        
        $employer_form_data = array(
            'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) )
        );
        wp_localize_script( 'employer-form-script', 'employer_form', $employer_form_data );
    }

    public function get_page_content() {
        $employer_id = isset( $_GET['id'] ) ? $_GET['id'] : null;
        $employer_dao = new EmployerDAO();

        $employer = $employer_dao->getEmployer( $employer_id );

        $page_title = $employer->get('id') ? __('Update employer', 'job-offers') : __('Create employer', 'job-offers');

        $back_url = admin_url( 'admin.php?page=employers' );
        $add_job_offer_url = admin_url( 'admin.php?page=job-offer&employer_id=' . $employer->get('id') );
        $job_offers_count = $employer_dao->countJobOffers( $employer_id );

        $this->employer_job_offers_table = new EmployerJobOffersTable();
        $this->employer_job_offers_table->set_employer_id( $employer->get('id') );
        $this->employer_job_offers_table->prepare_items();

        $this->employer_form->setEmployer( $employer );
        $this->employer_password_form->setEmployer( $employer );

        ?>
        <div class="wrap">
            <?php if ( $employer_id !== null && !$employer->get('id') ): ?>
                <div class="error notice">
                    <p><?php _e('Selected employer does not exist!', 'job-offers'); ?> <br /><a href="<?php echo $back_url; ?>"><?php _e('Back'); ?></a></p>
                </div>
            <?php else: ?>
                <h1 class="wp-heading-inline"><?php echo $page_title; ?></h1>
                
                <ul class="nav nav-tabs" role="tablist" id="employer-tabs" style="margin-top: 30px;">

                    <li class="nav-item">
                        <a class="nav-link active" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="true"><?php _e('Employer', 'job-offers'); ?></a>
                    </li>

                    <?php if ( $employer_id ): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="job-offers-tab" data-toggle="tab" href="#job-offers" role="tab" aria-controls="job-offers" aria-selected="false"><?php _e('Job offers', 'job-offers'); ?> (<?php echo $job_offers_count; ?>)</a>
                        </li>
                    <?php endif; ?>

                    <?php if ( $employer_id ): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false"><?php _e('Password', 'job-offers'); ?></a>
                        </li>
                    <?php endif; ?>

                </ul>
                

                <div class="tab-content" id="employer-tabs-content">

                    <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labeledby="form-tab">
                        <?php $this->employer_form->html(); ?>
                    </div>

                    <div class="tab-pane" id="job-offers" role="tabpanel" aria-labeledby="job-offers-tab">
                        <div style="margin-top: 30px;">
                            <a href="<?php echo $add_job_offer_url; ?>" class="page-title-action"><?php _e('Add new job offer', 'job-offers'); ?></a>
                        </div>
                        <?php $this->employer_job_offers_table->display(); ?>
                    </div>

                    <div class="tab-pane" id="password" role="tabpanel" aria-labeledby="password-tab">
                        <?php $this->employer_password_form->html(); ?>
                    </div>

                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function get_page_slug() {
        return $this->page_slug;
    }

}