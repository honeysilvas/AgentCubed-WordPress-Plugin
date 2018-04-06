<?php
	// Calling Facebook Graph API using CURL
	
	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly	
		
		function agentcubed_facebook_curl( $url ){
			$data = file_get_contents( $url );		
			if ( $data === false ){
				return false;
			}
			return $data;
		}