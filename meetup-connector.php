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

    const MEETUP_AUTH_URL = 'https://secure.meetup.com/oauth2/authorize';

    const CONNECTION_CODE_KEY = 'meetup-connector-code';

    const AUTH_NONCE_KEY = 'meetup-connector-user-auth-%d';
    const AUTH_RETURN_KEY = 'meetup-connector-auth-return';

    public static function start() {
        Meetup_Connector_Settings::start();
        add_action( 'show_user_profile', array( __CLASS__, 'meetup_connect_link' ) );
        add_action( 'edit_user_profile', array( __CLASS__, 'meetup_connect_link' ) );
    }

    public static function meetup_connect_link( $user ) {
        $settings = Meetup_Connector_Settings::get_settings();
        $errors = array();

        if ( isset( $_REQUEST[self::AUTH_RETURN_KEY] ) && isset( $_REQUEST['code']) ) {
            if ( wp_verify_nonce( $_GET['_wpnonce'], sprintf( self::AUTH_NONCE_KEY, get_current_user_id() ) ) ) {
                $code = $_REQUEST['code'];
                update_user_meta( $user->ID, self::CONNECTION_CODE_KEY, $code );
            } else {
                $errors[] = __( 'Are you sure you want to do that? Please try again' );
            }

        }

        echo '<h3>' . __( 'Meetup Connector' ) . '</h3>';
        echo '<p>' . __( 'Connect to your Meetup.com account' ). '</p>';

        foreach ( $errors as $error ) {
            echo '<p>' . $error . '</p>';
        }

        $connection_code = get_user_meta( $user->ID, self::CONNECTION_CODE_KEY, true );
        if ( $connection_code ) {
            echo '<p>' . __( 'You are already connected!' ) . '</a>';
        } else {
            $return_url = wp_nonce_url( add_query_arg(self::AUTH_RETURN_KEY, '1', admin_url( 'profile.php' ) ), sprintf( self::AUTH_NONCE_KEY, get_current_user_id() ) );
            $auth_url =  add_query_arg( array(
                'response_type' => 'code',
                'client_id' => $settings['client-id'],
                'redirect_uri' => urlencode( $return_url )
            ), Meetup_Connector::MEETUP_AUTH_URL );
            echo '<p><a href="' . esc_url( $auth_url ) . '">' . __( 'Connect' ) . '</a>';
        }
    }

    public static function include_file( $rel_path ) {
        include dirname( __FILE__ ) . '/' . $rel_path;
    }

    public static function load_view( $view, $scope = array() ) {
        extract( $scope );
        include ( dirname( __FILE__ ) . '/views/' . $view );
    }
}

Meetup_Connector::include_file( 'includes/settings.php' );

Meetup_Connector::start();