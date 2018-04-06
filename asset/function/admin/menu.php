<?php
	/*
		Admin menu
	*/

	// Add menu to admin dashboard
		add_action( "admin_menu", "shm_agentcubed_menu" );

	// Add the menu item to admin dashboard.
		if ( !function_exists( "shm_agentcubed_menu" )){
			function shm_agentcubed_menu(){	
				add_menu_page( "AgentCubed Integration", "AgentCubed Integration", "manage_options", "shm_agentcubed_menu", "shm_agentcubed_page" );
			}
		}

	// Custom function
		if ( !function_exists( "shm_agentcubed_page" )){
			function shm_agentcubed_page(){ 
				agentcubed_form();
			}
		}