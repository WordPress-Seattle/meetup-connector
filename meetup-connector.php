<?php

/*
 * Plugin Name: Meetup Connector
 * Description: Connect user accounts to Meetup.com
 * Plugin URI: http://github.com/WordPress-Seattle/meetup-connector
 * Author Name: WordPress Seattle
 * Author URI: http://wpseattle.org/
 * Version: 0.1
 */

class Meetup_Connector {
    public static function start() {
		self::include_file( 'includes/profile.php' );
    }
	
	public static function include_file( $path ) {
		if ( !empty( $path ) ) {
			if ( '/' == $path[0] ) {
				include untrailingslashit( plugin_dir_path( __FILE__ ) ) . $path;
			} else {
				include trailingslashit( plugin_dir_path( __FILE__ ) ) . $path;
			}
		}
	}
}

Meetup_Connector::start();
