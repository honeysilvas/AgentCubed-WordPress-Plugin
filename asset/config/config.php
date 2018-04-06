<?php 

// Configuration Details.

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly
	
		function agentcubed_get_option(){
			$option = array(
					"agentcubed_username",
					"agentcubed_password",
					"agentcubed_group_weblead_id",
					"agentcubed_notification_email",
					"agentcubed_lead_source_key",				
					"agentcubed_production_url",
					"agentcubed_production_wsdl",
					"agentcubed_testing_url",
					"agentcubed_testing_wsdl",
					"agentcubed_mode",
				);
			$option = apply_filters( "agentcubed_option", $option );
			return $option;
		}

	// Get configuration from database
		function agentcubed_get_config( $data ){
			$options = agentcubed_get_option();
			
			foreach ( $options as $option ){
				if ( empty( $data[ "credential" ][ $option ] ) ){
					$credential[ $option ] = get_option( $option );
				} else {
					$credential[ $option ] = $data[ "credential" ][ $option ];
				}
			}
			
			if ( get_option( "agentcubed_mode" ) == "testing" ){ 	// Testing or production			
				$credential[ "url" ] = get_option( "agentcubed_testing_url" );
				$credential[ "wsdl" ] = get_option( "agentcubed_testing_wsdl" );
			} else {
				$credential[ "url" ] = get_option( "agentcubed_production_url" );
				$credential[ "wsdl" ] = get_option( "agentcubed_production_wsdl" );
			}
			return $credential;
		}
	
	// Set defaults 
		function agentcubed_set_credential( $data = "" ){
			// Hardcoded credentials	// TODO: save and get these from database
				$data[ "agentcubed_username" ] = "agentcubed_username"; 
				$data[ "agentcubed_password" ] = "agentcubed_password"; 
				$data[ "agentcubed_group_weblead_id" ] = "000000"; 
				$data[ "agentcubed_notification_email" ] = "<your_email@gmail.com>"; 
				$data[ "agentcubed_lead_source_key" ] = "00000000-0000-0000-0000-000000000000"; 
				$data[ "agentcubed_facebook_verify_token" ] = "aaaaaaaaaaaa"; 	
				$data[ "agentcubed_facebook_lead_source_key" ] = "00000000-0000-0000-0000-000000000000"; 
				$data[ "facebook_access_token" ] = "facebook_access_token"; 
				$data[ "agentcubed_mode" ] = "production";			
			
			// Set defaults
				if ( empty( $data[ "agentcubed_production_url" ] ) ){
					$data[ "agentcubed_production_url" ] = "https://dataexchange.agentcubed.com/PortalService/PortalService.asmx";
				}
				if ( empty( $data[ "agentcubed_production_wsdl" ] ) ){
					$data[ "agentcubed_production_wsdl" ] = "https://dataexchange.agentcubed.com/PortalService/PortalService.asmx?wsdl";
				}
				if ( empty( $data[ "agentcubed_testing_url" ] ) ){
					$data[ "agentcubed_testing_url" ] = "https://test.agentcubed.com/DataExchangeV2/PortalService/PortalService.asmx";
				}
				if ( empty( $data[ "agentcubed_testing_wsdl" ] ) ){
					$data[ "agentcubed_testing_wsdl" ] = "https://test.agentcubed.com/DataExchangeV2/PortalService/PortalService.asmx?wsdl";
				}
				if ( empty( $data[ "agentcubed_mode" ] ) ){
					$data[ "agentcubed_mode" ] = "testing";
				}
			
			$options = agentcubed_get_option();
			
			foreach ( $options as $option ){
				update_option( $option, $data[ $option ] );
			}
		}
	
	// TODO: Initialize on plugin activate
		agentcubed_set_credential();