<?php

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly

		function agentcubed_get_facebook_lead( $leadgen_id ){
			$access_token = get_option( "facebook_access_token" );
			$facebook_data = agentcubed_fetch_lead( $leadgen_id, $access_token );
			
			if ( $facebook_data === false ){
				error_log( "Need to refresh access_token " );
				//$access_token = agentcubed_refresh_page_access_token();
				//$facebook_data = agentcubed_fetch_lead( $leadgen_id, $access_token );
				return false;
			} 
			
			$data = json_decode( $facebook_data, true );	
			return $data;
		}
		
		function agentcubed_fetch_lead( $leadgen_id, $access_token ){
			$url = "https://graph.facebook.com/v2.12/" . $leadgen_id . "?access_token=" . $access_token;
			$data = agentcubed_facebook_curl( $url );
			return $data;
		}