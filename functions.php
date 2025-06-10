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
require_once get_stylesheet_directory() . '/inc/custom-chaps-form.php';
/**
 * Render a story section with optional image
 * 
 * @return void
 */
function Enqueue_Custom_Chaps_script() 
{
    if (is_product() && get_post_field('post_name', get_the_ID()) == 'custom-chaps') {
        wp_enqueue_script(
            'custom-chaps-js',
            get_stylesheet_directory_uri() . '/js/custom-chaps.js',
            [],
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'Enqueue_Custom_Chaps_script');
/**
 * Render a story section with optional image
 * 
 * @param string $section_id The ID of the section.
 * @param string $text       The text to display in the section.
 * @param string $image_url  The URL of the image to display (optional).
 * 
 * @return void
 */
function Render_Story_section($section_id, $text, $image_url = '') 
{
    echo '<div class="snap-section story-section" id="' . esc_attr($section_id) . '">';
    echo '<p>' . esc_html($text) . '</p>';
    
    if (!empty($image_url)) {
        echo '<div class="story-image">';
        echo '<div class="image-frame-wrapper">';
        echo '<img src="' . esc_url($image_url) . '" alt="Story Image">';
        echo '<div class="custom-frame">';
        echo '<span class="frame-line top"></span>';
        echo '<span class="frame-line right"></span>';
        echo '<span class="frame-line bottom"></span>';
        echo '<span class="frame-line left"></span>';
        echo '</div>';
        echo '</div>'; // image-frame-wrapper
        echo '</div>'; // story-image
    }

    echo '</div>'; // story-section
}
add_action('woocommerce_after_shop_loop_item', 'Add_Customise_Button_To_First_product', 15);
/**
 * Add a "Customise" button and deposit note to the first product in the shop loop
 * 
 * @return void
 */
function Add_Customise_Button_To_First_product() 
{
    static $product_counter = 0;
    global $product;

    $product_counter++;

    if ($product_counter === 1 && $product->get_name() === 'Custom Chaps') {
        // Add a note about the deposit and pricing
        echo '<a href="' . esc_url(get_permalink($product->get_id())) . '" class="button customise-button">Customise</a>';
        echo '<span class="customise-note" style="margin-top:4px; font-size: 0.8rem; color: #666;">£50 refundable deposit – final price will be confirmed after quote.</span>';
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
