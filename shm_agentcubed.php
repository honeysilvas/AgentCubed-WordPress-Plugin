<?php 

	/*
		Plugin Name: AgentCubed Integration
		Plugin URI: http://silverhoneymedia.com
		Description:  Integrates AgentCubed with Contact Form 7 and Facebook Lead Ads Form, and can be extended to integrate with other APIs.
		Author: Honey Silvas
		Version: 0.0.2
		Author URI: http://silverhoneymedia.com
	*/

		require_once( plugin_dir_path( __FILE__ ) . "asset/api/agentcubed/agentcubed.php" );
		require_once( plugin_dir_path( __FILE__ ) . "asset/api/contactform7/contactform7.php" );
		require_once( plugin_dir_path( __FILE__ ) . "asset/api/facebook/facebook.php" );
		require_once( plugin_dir_path( __FILE__ ) . "asset/function/include.php" );