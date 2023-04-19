<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/christos-tsm
 * @since      1.0.0
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/public
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Drawer_Cart_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('wp_ajax_tsm_drawer_cart_ajax_update', array($this, 'tsm_drawer_cart_ajax_update'));
		add_action('wp_ajax_nopriv_tsm_drawer_cart_ajax_update', array($this, 'tsm_drawer_cart_ajax_update'));
		add_action('wp_ajax_tsm_drawer_cart_ajax_update_quantity', array($this, 'tsm_drawer_cart_ajax_update_quantity'));
		add_action('wp_ajax_nopriv_tsm_drawer_cart_ajax_update_quantity', array($this, 'tsm_drawer_cart_ajax_update_quantity'));
	}

	public function tsm_drawer_cart_ajax_update() {
		ob_start();
		$this->tsm_drawer_cart_content();
		$output = ob_get_clean();
		wp_send_json($output);
	}

	public function tsm_drawer_cart_ajax_update_quantity() {
		$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
		$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

		if ($cart_item_key && $quantity >= 0) {
			WC()->cart->set_quantity($cart_item_key, $quantity);
		}

		$this->tsm_drawer_cart_ajax_update();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Drawer_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Drawer_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tsm-drawer-cart-for-woocommerce-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Drawer_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Drawer_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tsm-drawer-cart-for-woocommerce-public.js', array('jquery'), $this->version, true);
	}

	/**
	 * Frontend drawer cart
	 */
	public function tsm_drawer_cart_display() {
		include_once 'partials/tsm-drawer-cart-for-woocommerce-public-display.php';
	}

	/**
	 * Add inline styles inside <head>
	 */
	public function enqueue_inline_styles() {
		// Get the plugin options
		$options = get_option('tsm_drawer_cart_options');

		// Use the options to generate your custom CSS
		$custom_css = '
			.tsm-drawer-cart-floating-button {
				background-color: ' . esc_attr($options['background_color']) . ';
				color: ' . esc_attr($options['icon_color']) . ';
			}
		';

		// Inject the custom CSS into the head
		wp_add_inline_style($this->plugin_name, $custom_css);
	}
	public function tsm_drawer_cart_content() {
		if (WC()->cart->is_empty()) {
			echo '<p class="message message--empty">' . __('Your cart is empty.', 'tsm-drawer-cart-for-woocommerce') . '</p>';
		} else {
?>
			<div class="tsm-drawer-cart-products">
				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
				?>
						<div class="tsm-drawer-cart-product">
							<div class="tsm-drawer-cart-product__thumbnail">
								<?= $_product->get_image(); ?>
							</div>
							<div class="tsm-drawer-cart-product__info">
								<p><?= $_product->get_name(); ?></p>
								<p><?= WC()->cart->get_product_price($_product); ?></p>
							</div>
							<div class="tsm-drawer-cart-product__quantity">
								<span class="minus tsm-drawer-cart-product__qty-button">-</span>
								<?php
								echo woocommerce_quantity_input(array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $_product->get_name(),
								), $_product, false);
								?>
								<span class="plus tsm-drawer-cart-product__qty-button">+</span>
							</div>
						</div>
				<?php
					}
				}
				?>
			</div>
<?php
		}
	}
}
