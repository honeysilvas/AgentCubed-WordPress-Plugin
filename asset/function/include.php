<?php

	if ( ! defined( "ABSPATH" ) ) exit; // Exit if accessed directly
	
		// Check if we are in the admin dashboard.
			if ( is_admin() ){
				require_once( plugin_dir_path( __FILE__ ) . "../config/config.php" );	
				require_once( plugin_dir_path( __FILE__ ) . "admin/menu.php" );	// Show admin menu
				require_once( plugin_dir_path( __FILE__ ) . "admin/form.php" );
			}