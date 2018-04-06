<?php

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly

	// Get data
		function agentcubed_get_contactform7_data(){
			// Use WPCF7_Submission object's get_posted_data() method to get it. 
			$submission = WPCF7_Submission::get_instance();
			
			if ( $submission ) {
				$data = $submission->get_posted_data();
				$data[ "submission_id" ] = $submission->id;

				// Format values.
					$data = agentcubed_format_contactform7_data( $data );
					return $data; 
			} 
				
			return false;
		}
		
	// Format data
		function agentcubed_format_contactform7_data( $data ){			
			$data = agentcubed_initialize_data( $data );
			$data = agentcubed_sanitize_data( $data );			
			return $data;
		}
	
	// Hook for Contact Form 7, triggered by submission of Contact Form 7 form
	// Gets submitted information from Contact Form 7.
		function agentcubed_contactform7_hook( $submission ) {
			error_log( "Triggering contact form hook..." );
			$data = agentcubed_get_contactform7_data();

			if ( $data ){
				agentcubed_submit_data( $data ); 
			}
		}

	// Hook into Contact Form 7's before send mail action.
		add_action( "wpcf7_before_send_mail", "agentcubed_contactform7_hook" );