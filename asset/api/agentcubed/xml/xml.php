<?php 

if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly

function agentcubed_get_xml( $data ){
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<AgentCubedAPI xmlns="http://dataexchange.agentcubed.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
			<LoginCredentials>
				<ErrorNotificationEmail>' . $data[ "credential" ][ "agentcubed_notification_email" ] . '</ErrorNotificationEmail>
				<Username>' . $data[ "credential" ][ "agentcubed_username" ] . '</Username>
				<Password>' . $data[ "credential" ][ "agentcubed_password" ] . '</Password>
				<Group_WebLead_ID>' . $data[ "credential" ][ "agentcubed_group_weblead_id" ] . '</Group_WebLead_ID>
				<LeadSourceKey>' . $data[ "credential" ][ "agentcubed_lead_source_key" ] . '</LeadSourceKey>
			</LoginCredentials>
			<Leads>
				<Lead>
		           <LeadInformation>
						<TrackingKey01>' . $data[ "plan" ] . '</TrackingKey01>
						<AdditionalContent03>' . $data[ "plan" ] . '</AdditionalContent03>
						<LeadOrigin>' . $data[ "lead_origin" ] . '</LeadOrigin>
						<LeadGeneratedDateTime>' . $data[ "current_time" ] . '</LeadGeneratedDateTime>
					</LeadInformation>
					<LeadIndividuals>
						<Individual IndividualID="0">
							<DOB>' . $data[ "your_dfb" ] . '</DOB>
							<LastName>' . $data[ "your_last" ] . '</LastName>
							<FirstName>' . $data[ "your_name" ] . '</FirstName>
							<Email>' . $data[ "your_email" ] . '</Email>														<RelationType>Applicant</RelationType>';							
				if ( !empty ( $data[ "smoker" ] ) ){						
					$xml .= '<Smoker>' . $data[ "smoker" ] . '</Smoker>';
				}
	$xml .= '</Individual>
					</LeadIndividuals>
					<LeadOpportunities>
						<Opportunity>
							<InsuranceType>Health</InsuranceType>
						</Opportunity>
					</LeadOpportunities>					
					<LeadContactDetails>
						<PrimaryPhone>' . $data[ "your_phone" ] . '</PrimaryPhone>
						<Address>
							<ZipCode>' . $data[ "your_zipcode" ] . '</ZipCode>					
						</Address>
					</LeadContactDetails>
				</Lead>
			</Leads>
		</AgentCubedAPI>';
		
	return $xml;
}