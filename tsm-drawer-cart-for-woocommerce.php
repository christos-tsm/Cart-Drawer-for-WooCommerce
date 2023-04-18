<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/christos-tsm
 * @since             1.0.0
 * @package           Tsm_Drawer_Cart_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       TSM Drawer Cart for WooCommerce
 * Plugin URI:        https://github.com/christos-tsm
 * Description:        This plugin allows store owners to create a fully customizable add-to-cart drawer, providing a seamless and user-friendly shopping experience. The drawer appears when a customer adds a product to their cart, displaying a summary of the items in the cart, along with the option to edit quantities, remove items, or proceed to checkout.
 * Version:           1.0.0
 * Author:            Christos Tsamis
 * Author URI:        https://github.com/christos-tsm
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tsm-drawer-cart-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TSM_DRAWER_CART_FOR_WOOCOMMERCE_VERSION', '1.1.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tsm-drawer-cart-for-woocommerce-activator.php
 */
function activate_tsm_drawer_cart_for_woocommerce() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-tsm-drawer-cart-for-woocommerce-activator.php';
	Tsm_Drawer_Cart_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tsm-drawer-cart-for-woocommerce-deactivator.php
 */
function deactivate_tsm_drawer_cart_for_woocommerce() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-tsm-drawer-cart-for-woocommerce-deactivator.php';
	Tsm_Drawer_Cart_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_tsm_drawer_cart_for_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_tsm_drawer_cart_for_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-tsm-drawer-cart-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tsm_drawer_cart_for_woocommerce() {

	$plugin = new Tsm_Drawer_Cart_For_Woocommerce();
	$plugin->run();
}
run_tsm_drawer_cart_for_woocommerce();
