<?php
	// Need to hide all errors because nothing else can be printed to screen or returned except Facebook verification token
		error_reporting( 0 );
		ini_set( "display_errors", 0);

	require_once( "../../../../../../wp-load.php" ); // Load WordPress on this page

	// https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration
	// Test at https://developers.facebook.com/tools/lead-ads-testing

		$challenge = $_REQUEST[ "hub_challenge" ];
		$verify_token = $_REQUEST[ "hub_verify_token" ];
	
		if ( $verify_token === get_option( "agentcubed_facebook_verify_token" ) ){  	// default was "abc123"	
			echo $challenge;
		}

		$data = array();
		$data[ "meta" ] = json_decode( file_get_contents('php://input'), true ); // dev
		
		if ( $data[ "meta" ] ){
			$data[ "leadgen_id" ] = $data[ "meta" ][ "entry" ][0][ "changes" ][0][ "value" ][ "leadgen_id" ];
			
			if ( !empty( $data[ "leadgen_id" ]  ) ){
				require_once( plugin_dir_path( __FILE__ ) . "../../../asset/api/facebook/curl.php" );
				$data[ "lead" ] = agentcubed_get_facebook_lead( $data[ "leadgen_id" ] );		
				if ( $data[ "lead" ] !== false ){
					$data = agentcubed_facebook( $data ); // Submit data.
				} 
			} else {
				error_log( "No leadgen id passed." );
			} 
		}
		
		/*// Write payload contents into a text file for reference (for troubleshooting only)
			$file = fopen( "testleads.txt", "a" ) or die( "Unable to open file!!!" );
			echo fwrite( $file, json_encode( $input ));
			fclose( $file );
		*/