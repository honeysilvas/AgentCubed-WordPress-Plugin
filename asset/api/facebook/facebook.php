<?php

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly
	
		// Include files
			require_once( plugin_dir_path( __FILE__ ) . "../../../asset/api/facebook/curl.php" );
			require_once( plugin_dir_path( __FILE__ ) . "../../../asset/api/facebook/lead.php" );
	
		// Integrate with Facebook Lead Ads Form
		
		function agentcubed_map_facebook_data( $data ){		
			foreach ( $data[ "lead" ][ "field_data" ] as $key => $value ){
				$value[ "values" ][0] = str_replace( array( "<", ">" ), "", $value[ "values" ][0] );
				
				if ( $value[ "name" ] == "plan_option_of_interest" ){
					$data[ "plan" ] = $value[ "values" ][0];					
				} elseif ( $value[ "name" ] == "first_name" || $value[ "name" ] == "full_name" ){
					$data[ "your_name" ] = $value[ "values" ][0];
				} elseif ( $value[ "name" ] == "last_name" ){
					$data[ "your_last" ] = $value[ "values" ][0];	
				} elseif ( $value[ "name" ] == "zip_code" && $value[ "values" ][0] != "test lead: dummy data for zip_code" ){
					$data[ "your_zipcode" ] = $value[ "values" ][0];
				} elseif ( $value[ "name" ] == "phone_number" && $value[ "values" ][0] != "test lead: dummy data for phone_number" ){
					$data[ "your_phone" ] = $value[ "values" ][0];
				} elseif ( $value[ "name" ] == "email" ){
					$data[ "your_email" ] = $value[ "values" ][0];
				} elseif ( $value[ "name" ] == "date_of_birth" && $value[ "values" ][0] != "test lead: dummy data for date_of_birth" ){
					//$data[ "your_dfb" ] = $value[ "values" ][0];	// Facebook format: "04/16/1964" to "1970-01-01"
					$data[ "your_dfb" ] = DateTime::createFromFormat( 'm/d/Y', $value[ "values" ][0] );
					$data[ "your_dfb" ] = $data[ "your_dfb" ]->format( 'Y-m-d' );
				}
			}
			
			$data[ "lead_origin" ] = "Facebook " . $data[ "meta" ][ "entry" ][0][ "changes" ][0][ "value" ][0][ "ad_id" ] . " " .  $data[ "meta" ][ "entry" ][0][ "changes" ][0][ "value" ][0][ "adgroup_id" ];	
					//echo $data[ "value" ][ "form_id" ];
			$data[ "credential" ][ "agentcubed_lead_source_key" ] = get_option( "agentcubed_facebook_lead_source_key" ); 
			
			if ( isset( $data[ "lead" ][ "created_time" ] ) ){
				$data[ "current_time" ] = substr( $data[ "lead" ][ "created_time" ], 0, 19 );
				
			} else {
				$data[ "current_time" ] = $data[ "meta" ][ "entry" ][0][ "changes" ][0][ "value" ][ "created_time" ];
				$data[ "current_time" ] = date( "Y-m-d", $data[ "current_time" ] ) . "T" . date( "H:i:s", $data[ "current_time" ] ); // Format "2011-02-01T01:01:01"; 	// Facebook: int 1520432377
			}
			return $data;
		}
		
		function agentcubed_facebook( $data ){
			$data = agentcubed_initialize_data( $data );
			$data = agentcubed_map_facebook_data( $data );
			$data = agentcubed_sanitize_data( $data );
			agentcubed_submit_data( $data );
		}
		
		function agentcubed_format_facebook_data( $data ){
			return $data;
		}
		
		function agentcubed_facebook_additional_fields( $credential ){ ?>
			<tr>
				<th colspan="2"><h2>Facebook Settings</h2></th>										
			</tr>
			<tr>
				<th scope="row"><label>AgentCubed Facebook Verify Token</label></th>
				<td><input name="agentcubed_facebook_verify_token" type="text" value="<?php echo $credential[ "agentcubed_facebook_verify_token" ]; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label>AgentCubed Facebook Lead Source Key</label></th>
				<td><input name="agentcubed_facebook_lead_source_key" size="50" type="text" value="<?php echo $credential[ "agentcubed_facebook_lead_source_key" ]; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label>Facebook Access Token</label></th>
				<td><input name="facebook_access_token" size="50" type="text" value="<?php echo $credential[ "facebook_access_token" ]; ?>" /></td>
			</tr>
		<?php }
		
		add_action( "agentcubed_additional_fields", "agentcubed_facebook_additional_fields" );
		
		function agentcubed_facebook_option( $option ){
			$option[] = "agentcubed_facebook_verify_token";
			$option[] = "agentcubed_facebook_lead_source_key";
			$option[] = "facebook_access_token";
			return $option;
		}

		add_filter( "agentcubed_option", "agentcubed_facebook_option" );