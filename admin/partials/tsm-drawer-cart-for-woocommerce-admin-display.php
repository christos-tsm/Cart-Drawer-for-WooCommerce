<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/christos-tsm
 * @since      1.0.0
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/admin/partials
 */
?>

<?php /** This file should primarily consist of HTML with a little bit of PHP. */ ?>
<?php
if (!current_user_can('manage_options')) {
    return;
}
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
        settings_fields('tsm-drawer-cart-for-woocommerce');
        do_settings_sections('tsm-drawer-cart-for-woocommerce');
        submit_button(__('Save Settings', 'tsm-drawer-cart-for-woocommerce'));
        ?>
    </form>
</div>