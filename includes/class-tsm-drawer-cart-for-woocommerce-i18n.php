<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/christos-tsm
 * @since      1.0.0
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/includes
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Drawer_Cart_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tsm-drawer-cart-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
