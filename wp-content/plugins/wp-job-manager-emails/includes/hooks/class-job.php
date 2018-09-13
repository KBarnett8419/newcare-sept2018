<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class WP_Job_Manager_Emails_Hooks_Job
 *
 * @since 2.0.0
 *
 */
class WP_Job_Manager_Emails_Hooks_Job extends WP_Job_Manager_Emails_Hooks {

	/**
	 * @var string
	 */
	public $post_title   = '[job_title]';
	/**
	 * @var string
	 */
	public $post_content = '[job_description]';
	/**
	 * @var string
	 */
	public $submitted_by = '[company_name]';

	/**
	 * Job specific hooks
	 *
	 *
	 * @since 1.0.0
	 *
	 */
	function hooks(){

		// Handled in WP_Job_Manager_Emails_Hooks_PostStatus
		add_action( 'job_manager_check_for_expired_jobs', array( $this, 'check_soon_to_expire_listings' ), 11 );
		add_action( 'publish_job_listing', array( $this, 'publish_job_listing' ), 10, 2 );
	}

	/**
	 * Return Default Core Statuses (without filtering)
	 *
	 *
	 * @since 2.1.0
	 *
	 * @param bool $filtered
	 *
	 * @return array
	 */
	public function get_core_statuses( $filtered = false ) {

		$statuses = array(
			'draft'           => __( 'Draft', 'wp-job-manager-emails' ),
			'expired'         => __( 'Expired', 'wp-job-manager-emails' ),
			'preview'         => __( 'Preview', 'wp-job-manager-emails' ),
			'pending'         => __( 'Pending approval', 'wp-job-manager-emails' ),
			'pending_payment' => __( 'Pending payment', 'wp-job-manager-emails' ),
			'publish'         => __( 'Active', 'wp-job-manager-emails' ),
		);

		if ( $filtered ) {
			$statuses = apply_filters( 'job_listing_post_statuses', $statuses );
		}

		return $statuses;
	}

	/**
	 * publish_job_listing hook
	 *
	 *
	 * @since 2.0.5
	 *
	 * @param $id
	 * @param $post
	 */
	function publish_job_listing( $id, $post ) {

		$this->post_status_hook( 'publish', $post );
		$this->queued_featured_emails( $post );
	}

	/**
	 * Get Default Email Array Keys
	 *
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function get_default_email_keys() {
		return apply_filters( 'job_manager_emails_resume_default_email_keys',
		                      array( 'job_listing_soon_to_expire', 'preview_to_publish_job_listing', 'preview_to_pending_job_listing', 'pending_to_publish_job_listing' ) );
	}

	/**
	 * Initialize Resume Actions
	 *
	 *
	 * @since 1.0.0
	 *
	 */
	function init_actions() {

		$singular = $this->cpt()->get_singular();

		$this->actions = apply_filters( 'job_manager_emails_job_actions',
                array(
	                // Kept for backwards compatibility
                    'job_manager_job_submitted' => array(
                        'args'     => 1,
                        'label'    => sprintf( __( 'New %s Created/Submitted', 'wp-job-manager-emails' ), $singular ),
                        'callback' => 'new_job',
                        'priority' => 1,
                        'desc'     => sprintf( __( 'When a %s is Created/Submitted (DEPRECIATED)', 'wp-job-manager-emails' ), $singular ),
                        'ext_desc' => __( 'This email will ONLY be sent when the listing does NOT require payment OR approval!!! DEPRECIATED !!', 'wp-job-manager-emails' ),
                        'warning' => __( 'This hook will be removed in an upcoming release, you should use one of the new actions (based on your config) for sending this email!', 'wp-job-manager-emails' ),
                        'hook'     => TRUE,
                        'defaults' => array(
                            'to'           => '[admin_email]',
                            'post_content' => $this->job_manager_job_submitted_default_content(),
                            'subject'      => sprintf( __( 'New %s Submission, [job_title]', 'wp-job-manager-emails' ), $singular ),
                            'post_title'   => sprintf( __( 'New %s Submitted', 'wp-job-manager-emails' ), $singular ),
                        )
                    ),
                    'job_manager_job_featured' => array(
                        'args'     => 4,
                        'label'    => sprintf( __( '%s Featured', 'wp-job-manager-emails' ), $singular ),
                        'callback' => 'listing_featured',
                        'priority' => 11,
                        'desc'     => sprintf( __( 'When a %s is changed from un-featured, to featured.', 'wp-job-manager-emails' ), $singular ),
                        'ext_desc' => __( 'This email will be sent when a listing is set as a featured listing.', 'wp-job-manager-emails' ),
                        'hook'     => 'update_postmeta',
                        'defaults' => array(
                            'to'           => '[job_author_email]',
                            'post_content' => $this->featured_default_content( '[job_title]', '[view_job_url]' ),
                            'subject'      => sprintf( __( 'The listing "[job_title]" is now a featured listing', 'wp-job-manager-emails' ), $singular ),
                            'post_title'   => sprintf( __( '%s set as Featured', 'wp-job-manager-emails' ), $singular ),
                        ),
                        'inputs' => array(
	                        'featured_send_on_create' => array(
		                        'label'       => __( 'Send email on newly created listings', 'wp-job-manager-emails' ),
		                        'type'        => 'checkbox',
	                            'checkbox'    => 'slider',
	                            'help'        => __( 'When disabled, this email will only send when an active (published) listing is updated to featured listing.', 'wp-job-manager-emails' )
	                        ),
                        )
                    ),
                    'job_manager_job_unfeatured' => array(
                        'args'     => 4,
                        'label'    => sprintf( __( '%s Un-Featured', 'wp-job-manager-emails' ), $singular ),
                        'callback' => 'listing_unfeatured',
                        'priority' => 11,
                        'desc'     => sprintf( __( 'When a %s is changed from featured, to un-featured.', 'wp-job-manager-emails' ), $singular ),
                        'ext_desc' => __( 'This email will be sent when a listing is CHANGED from Featured to Un-Featured.', 'wp-job-manager-emails' ),
                        'hook'     => 'update_postmeta',
                        'defaults' => array(
                            'to'           => '[job_author_email]',
                            'post_content' => $this->unfeatured_default_content( '[job_title]' ),
                            'subject'      => sprintf( __( 'The %s "[job_title]" is no longer a featured listing.', 'wp-job-manager-emails' ), $singular ),
                            'post_title'   => sprintf( __( '%s set as Un-Featured', 'wp-job-manager-emails' ), $singular ),
                        )
                    ),
                )
		);

		return $this->actions;
	}

	/**
	 * New Job Submitted Callback
	 *
	 * This method is called whenever a new job is submitted on the frontend of the site.
	 *
	 * @since 1.0.0
	 *
	 * @param $job_id
	 */
	function new_job( $job_id ){

		$custom_emails = $this->cpt()->get_emails( 'job_manager_job_submitted' );
		$this->hook = 'job_manager_job_submitted';
		$this->cpt()->send_email( $custom_emails, $job_id );
	}

	/**
	 * Default Email Template Content for New Job Submitted Action
	 *
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function job_manager_job_submitted_default_content() {

		$singular = $this->cpt()->get_singular();

		$content = '';
		$content .= __( 'Hello', 'wp-job-manager-emails' ) . "\n" . "\n";
		$content .= sprintf( __( 'A new %1$s has just been submitted by *%2$s*.  The details are as follows:', 'wp-job-manager-emails' ), $singular, '[company_name]' ) . "\n" . "\n";
		$content .=  "[divider]" . "\n" . "[job_fields]" . "\n" . "[/divider]" . "\n" . "\n";
		$content .= "[job_description]" . "\n" . sprintf( __( 'The %s description is as follows:', 'wp-job-manager-emails' ), $singular ) . "\n" . "[/job_description]" . "\n" . "\n";
		$content .= sprintf( __( 'You can view this %1$s here: %2$s', 'wp-job-manager-emails' ), $singular , '[view_job_url]' ) . "\n";
		$content .= sprintf( __( 'You can view/edit this %1$s in the backend by clicking here: %2$s', 'wp-job-manager-emails' ), $singular, '[view_job_url_admin]' ) . "\n" . "\n";

		return $content;
	}

}