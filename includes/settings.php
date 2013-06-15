<?php

class Meetup_Connector_Settings {

    const SETTINGS_KEY = 'meetup_connector_settings';
    const SETTINGS_NONCE_KEY = 'meetup-connector-settings-nonce';

    const SETTINGS_PAGE_SLUG = 'meetup-connector-settings';

    public static function start() {
        add_action( 'admin_menu', array( __CLASS__, 'register_menu' ) );
    }

    public static function register_menu() {
        add_options_page( __( 'Meetup Connector Settings'), __( 'Meetup Connector' ), 'manage_options', self::SETTINGS_PAGE_SLUG, array( __CLASS__, 'display_settings' ) );
    }

    public static function display_settings() {

        $settings = self::get_settings();

        if ( !empty( $_POST ) ) {
            check_admin_referer(self::SETTINGS_NONCE_KEY);

            $settings['client-id'] = isset( $_POST['client-id'] ) ? $_POST['client-id'] : '';


            self::save_settings( $settings );
        }

        Meetup_Connector::load_view( 'settings.php', array( 'settings' => $settings ) );
    }

    public static function save_settings( $settings ) {
        update_option( self::SETTINGS_KEY, $settings );
    }

    public static function get_default_settings() {
        return array(
            'client-id' => '',
        );
    }

    public static function get_settings() {
        return get_option( self::SETTINGS_KEY, self::get_default_settings() );
    }
}