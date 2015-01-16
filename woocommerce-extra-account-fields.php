<?php

/**
 * Plugin Name:       Woocommerce Extra Fields Registration
 * Description:       Add extra fields in woocommerce registration page, they is many supported fields to add like text, textarea, dropdown and radio fields
 * Version:           1.0.0
 * Author:            Osama Ahmed Attia
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-account-extra-fields
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Check if woocommerce plugin is active
 */
add_action( 'admin_init', 'os_check_current_woocommerce' );

function os_check_current_woocommerce () {
    if( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if( is_plugin_active( plugin_basename( __FILE__ ) ) ) {

            deactivate_plugins( plugin_basename( __FILE__ ) );
            function my_admin_notice () {
                ?>
                <div class="error">
                    <p><?php echo 'Please activate first woocommerce plugin !' ?></p>
                </div>
                <?php
            }

            add_action( 'admin_notices', 'my_admin_notice' );

            if( isset( $_GET[ 'activate' ] ) ) {
                unset( $_GET[ 'activate' ] );
            }

        }
    }
}

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-extra-account-fields.php';

/**
 * Begins execution of the plugin.
 */
function os_run_woocommerce_extra_account_fields () {

    $woocommerce_extra_account_fields = 'woocommerce-extra-account-fields';
    $version = '1.0.0';
    $plugin = new woocommerce_extra_account_fields($woocommerce_extra_account_fields, $version);
    $plugin->run();

}

os_run_woocommerce_extra_account_fields();
