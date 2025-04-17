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
