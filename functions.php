<?php
/**
 * Astrachildtheme Theme functions and definitions
 *
 * @category WordPress_Theme
 * @package  Astrachildtheme
 * @author   Kimberley Dobney <username@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @version  PHP 7.4
 * @link     https://developer.wordpress.org/themes/basics/theme-functions/
 * @since    1.0.0
 */
add_action('woocommerce_after_shop_loop_item', 'Add_Customise_Button_To_First_product', 15);
/**
 * Add a "Customise" button to the first product in the shop loop
 * 
 * @return void
 */
function Add_Customise_Button_To_First_product() 
{
    static $product_counter = 0;
    global $product;

    $product_counter++;

    if ($product_counter === 1 && $product->get_name() === 'Custom Chaps') {
        // Change the URL below to your customise page if needed
        echo '<a href="' . esc_url(get_permalink($product->get_id())) . '" class="button customise-button" style="margin-top:10px;" width="80px">Customise</a>';
    }
}
add_filter('render_block', 'Remove_Alignwide_From_Cart_block', 10, 2);
/**
 * Remove alignwide from cart block
 * 
 * @param string $block_content The block content.
 * @param array  $block         The block data.
 * 
 * @return void
 */
function Remove_Alignwide_From_Cart_block($block_content, $block) 
{
    if ($block['blockName'] === 'woocommerce/cart') {
        $block_content = str_replace('alignwide', '', $block_content);
    }
    return $block_content;
}
/**
 * Load all meta boxes
 */
$meta_boxes_dir = get_stylesheet_directory() . '/inc/meta-boxes/';

foreach ( glob($meta_boxes_dir . '*.php') as $filename ) {
    include $filename;
}

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRACHILDTHEME_VERSION', '1.0.0');

/**
 * Enqueue styles
 * 
 * @return void
 */
function Child_Enqueue_styles() 
{
    wp_enqueue_style('astrachildtheme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRACHILDTHEME_VERSION, 'all');

}

add_action('wp_enqueue_scripts', 'Child_Enqueue_styles', 15);

require_once get_stylesheet_directory() . '/inc/custom-chaps-form.php';
