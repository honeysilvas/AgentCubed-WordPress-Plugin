<?php

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly

	// Code based on example from AgentCubed API documentation at https://portal.agentcubed.com/webshares/_media/api%20documentation/AgentCubed%20DataExchange%20V2%20Sample.zip
		function agentcubed_submit_data( $data ){
			// Include files.
				require_once( plugin_dir_path( __FILE__ ) . "../../../asset/config/config.php" );	
				require_once( plugin_dir_path( __FILE__ ) . "../../../asset/api/agentcubed/xml/xml.php" );

			// Get login information for AgentCubed
				$data[ "credential" ] = agentcubed_get_config( $data );
			
			$client = new SoapClient( $data[ "credential" ][ "wsdl" ], array( 'trace' => true ) );	// Entity not defined error
			$xml = agentcubed_get_xml( $data );

			$xdoc = new DomDocument;
			$xmlschema = plugin_dir_path( __FILE__ ) . "../../../asset/api/agentcubed/xml/cubed.xsd";
			$xdoc->LoadXML($xml);
			
			if ( $xdoc->schemaValidate( $xmlschema ) ) {		
				$response = $client->AddLeadsUsingXMLString( array('xmlstring' => $xml) );
			
				// If not successful in pushing through API, send email instead so that lead can be manually added.
				if ( $response->AddLeadsUsingXMLStringResult->PortalServiceReturnDataList->StatusDescription == "Duplicate" ){
					echo "Duplicate lead.  Lead NOT successfully added to AgentCubed"; 
					error_log( "Duplicate lead.  Lead NOT successfully added to AgentCubed" ); 
				} elseif ( $response->AddLeadsUsingXMLStringResult->PortalServiceReturnDataList->StatusCode != 0 ){
					$message = "";
					foreach ( $data as $key => $value ){
						$message .= $key . ": " . $value . "<br />"; 
					}
					wp_mail( $data[ "credential" ][ "notification_email" ], "New Lead, not added successfully to AgentCubed", "This new lead was not added successfully to AgentCubed.  Please add this lead to AgentCubed manually.<br />" . $message . " " . $response->AddLeadsUsingXMLStringResult->PortalServiceReturnDataList->StatusDescription );
					error_log( "Lead NOT successfully added to AgentCubed" . $response->AddLeadsUsingXMLStringResult->PortalServiceReturnDataList->StatusDescription );
				} else {
					$message = "";
					foreach ( $data as $key => $value ){
						$message .= $key . ": " . $value . "<br />"; 
					}
					error_log( "Lead successfully added to AgentCubed" . $response->AddLeadsUsingXMLStringResult->PortalServiceReturnDataList->StatusDescription );
					wp_mail( $data[ "credential" ][ "notification_email" ], "New Lead, added successfully to AgentCubed", "This new lead was added successfully to AgentCubed. <br />" . $message );
				}
			} else {
				$message = "";
				foreach ( $data as $key => $value ){
					$message .= $key . ": " . $value . "<br />"; 
				}
				wp_mail( $data[ "credential" ][ "notification_email" ], "Error submitting lead: Not validating", "This new lead was NOT added successfully to AgentCubed. <br />" . $message );
				error_log( "Error submitting lead: Not validating" );
			}
		}
		
	// Set default values for fields so submission to API doesn't fail because of wrong format of data.
	function agentcubed_initialize_data( $data ){
		// Set empty values for unset fields.
			$field = array( "plan", "your_name", "your_last", "your_email", "your_phone", "your_zipcode", "your_dfb", "smoker", "lead_origin" );

			foreach ( $field as $key ){
				if ( !isset( $data[ $key ] ) ){
					$data[ $key ] = "";
				}
			}
			
			// Map data: for customization
			// specific to each contact form				
				$age = date( "Y" ) - $data[ "sender-age" ];
				$data[ "plan" ] = $data[ "plan-type" ];		
				$data[ "your_name" ] = $data[ "sender-name" ];
				$data[ "your_email" ] = $data[ "sender-email" ];
				$data[ "your_phone" ] = $data[ "sender-phone" ];
				$data[ "your_dfb" ] = $age . "-01-01";
				//$data[ "your_state" ] = $data[ "state" ];
				$data[ "smoker" ] = $data[ "smoker" ][0]; 
			
				if ( empty( $data[ "lead_origin" ] ) ){
					$data[ "lead_origin" ] = "Other";
				}

		return $data;
	}
	
	function agentcubed_sanitize_data( $data ){
		// Get current date and time
			if ( empty ( $data[ "current_time" ] ) ){
				$data[ "current_time" ] = date( "Y-m-d" ) . "T" . date( "H:i:s" );	// Format "2011-02-01T01:01:01";
			}
		
			// Format zipcode into 5 digits
			while ( strlen( $data[ "your_zipcode" ] ) < 5 ){
				$data[ "your_zipcode" ] = $data[ "your_zipcode" ] . "0";		
			}
		
			$data[ "your_phone" ] = str_replace( array( "+1", "(", ")", " ", "-" ), "", $data[ "your_phone" ] ); // remove characters from phone number	
			// Format phone number into 10 digits
				while ( strlen( $data[ "your_phone" ] ) < 10 ){
					$data[ "your_phone" ] = $data[ "your_phone" ] . "0";
				}
		
			// Default date of birth if empty
			if ( empty ( $data[ "your_dfb" ] ) ){
				$data[ "your_dfb" ] = "1970-01-01";
			}
			
			// Default email if empty
			if ( empty ( $data[ "your_email" ] ) ){
				$data[ "your_email" ] = $data[ "credential" ][ "notification_email" ];
			}
			
			// Default smoker if empty
			if ( empty ( $data[ "smoker" ] ) ){
				$data[ "smoker" ] = "No";
			}
			
		return $data;
	}