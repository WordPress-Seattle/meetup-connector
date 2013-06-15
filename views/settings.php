<div class="wrap">
    <h2><?php _e( 'Meetup Connector Settings' ); ?></h2>
    <form method="post" action="">
        <?php wp_nonce_field(Meetup_Connector_Settings::SETTINGS_NONCE_KEY); ?>
        <p><?php _e( 'Configure your Meetup Connector settings' ); ?></p>
        <p><?php printf( __( 'You need a Meetup client ID which you can create <a href="%s">here</a>' ), 'http://www.meetup.com/meetup_api/oauth_consumers/create/'); ?></p>
        <table class="form-table permalink-structure">
            <tr>
                <th><label for="client-id"><?php _e( 'Client Id' ); ?></label></th>
                <td><input type="text" name="client-id" id="client-id" class="regular-text" value="<?php echo esc_attr( $settings['client-id'] ); ?>" /></td>
            </tr>
        </table>
        <p><input class="button button-primary" type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes' ); ?>" /></p>
    </form>
</div>

