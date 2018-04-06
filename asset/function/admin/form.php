<?php 

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly

	function agentcubed_form(){ 	
		if ( isset( $_POST[ "submit" ] ) && $_POST[ "submit" ] == "Save Changes" ){
			$options = agentcubed_get_option();
			$options = apply_filters( "agentcubed_option", $options );

			foreach ( $options as $option ){
				$data[ $option ] =  sanitize_text_field( $_POST[ $option ] );
			}
			agentcubed_set_credential( $data );
		}
		$credential	= agentcubed_get_config();	
	?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="">
				<table class="form-table">
					<tbody>
						<tr>
							<th colspan="2">
								<h2>AgentCubed</h2>
							</th>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Username</label></th>
							<td><input name="agentcubed_username" type="text" value="<?php echo $credential[ "agentcubed_username" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Password</label></th>
							<td><input name="agentcubed_password" type="password" value="<?php echo $credential[ "agentcubed_password" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Group Weblead ID</label></th>
							<td><input name="agentcubed_group_weblead_id" type="text" value="<?php echo $credential[ "agentcubed_group_weblead_id" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Notification Email</label></th>
							<td><input name="agentcubed_notification_email" size="50" type="email" value="<?php echo $credential[ "agentcubed_notification_email" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Lead Source Key</label></th>
							<td><input name="agentcubed_lead_source_key" size="50" type="text" value="<?php echo $credential[ "agentcubed_lead_source_key" ]; ?>" /></td>
						</tr>
						<tr>
							<th colspan="2">
								<h2>Advanced AgentCubed Settings</h2>
								Leave blank to use default settings
							</th>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Mode</label></th>
							<td><input name="agentcubed_mode" type="text" value="<?php echo $credential[ "agentcubed_mode" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed URL</label></th>
							<td><input name="agentcubed_production_url" size="100" type="text" value="<?php echo $credential[ "agentcubed_production_url" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>WSDL</label></th>
							<td><input name="agentcubed_production_wsdl" size="100" type="text" value="<?php echo $credential[ "agentcubed_production_wsdl" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>AgentCubed Testing URL</label></th>
							<td><input name="agentcubed_testing_url" size="100" type="text" value="<?php echo $credential[ "agentcubed_testing_url" ]; ?>" /></td>
						</tr>
						<tr>
							<th scope="row"><label>Testing WSDL</label></th>
							<td><input name="agentcubed_testing_wsdl" size="100" type="text" value="<?php echo $credential[ "agentcubed_testing_wsdl" ]; ?>" /></td>
						</tr>
						<?php
							do_action( "agentcubed_additional_fields", $credential );
						?>
						<tr>
							<td>
								<?php
									wp_nonce_field( "agentcubed-settings-save", "agentcubed-custom-message" );
									submit_button();
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</tr>
		<?php 
	}