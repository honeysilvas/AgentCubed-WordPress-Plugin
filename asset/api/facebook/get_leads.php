<?php 
	
	require_once( "../../../../../../wp-load.php" ); // Load WordPress on this page

	$lead_form = "<LEAD_FORM_ID>"; 	// Agent leads form
	$access_token = get_option( "facebook_access_token" );
	
	$id = "<ID>";
	$url = "https://graph.facebook.com/v2.12/" . $id . "/leads?access_token=" . $access_token;
	$curl_output = agentcubed_facebook_curl( $url );
	
	$leads = array();
	$leads = json_decode( $curl_output, true ); // dev

	foreach ( $leads[ "data" ] as $lead ){
		$data = array();
		$data[ "lead" ] = $lead;	
		$data = agentcubed_facebook( $data ); // Submit data.
		echo "<p>"; 
	}