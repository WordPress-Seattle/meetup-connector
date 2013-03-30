<?php

class Meetup_Connector_Profile {
	public static function start() {
		add_action( 'show_user_profile', array( __CLASS__, 'add_meetup_fields' ) );
		add_action( 'edit_user_profile', array( __CLASS__, 'add_meetup_fields' ) );
		
		add_action( 'show_user_profile_update', array( __CLASS__, 'save_meetup_fields' ) );
		add_action( 'edit_user_profile_update', array( __CLASS__, 'save_meetup_fields' ) );
	}
	
	public static function add_meetup_fields() {
		
	}
	
	public static function save_meetup_fields() {
		
	}
}

if ( is_admin() ) {
	Meetup_Connector_Profile::start();
}