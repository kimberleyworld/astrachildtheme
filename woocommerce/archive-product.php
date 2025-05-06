<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @category WordPress_Theme
 * @package  WooCommerce\Templates
 * @author   Kimberley Dobney <username@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @version  8.6.0
 * @link     https://woocommerce.com/document/woocommerce-template-structure/
 * @see      https://woocommerce.com/document/template-structure/
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

$shop_id = wc_get_page_id('shop');
$intro = get_post_meta($shop_id, '_custom_shop_intro', true);
$image_id = get_post_meta($shop_id, '_custom_shop_intro_image_id', true);
$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';

if ($image_url || $intro) {
    echo '<div class="shop-intro">';
    if ($image_url) {
        echo '<img src="' . esc_url($image_url) . '" alt="" />';
    }
    if ($intro) {
        echo '<div class="shop-intro-text">' . wpautop(esc_html($intro)) . '</div>';
    }
    echo '</div>';
}

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action('woocommerce_shop_loop_header');

if (woocommerce_product_loop()) {
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
    do_action('woocommerce_before_shop_loop');
    woocommerce_product_loop_start();
    if (wc_get_loop_prop('total')) {
        while ( have_posts() ) {
            the_post();
            /**
              * Hook: woocommerce_shop_loop.
            */
            do_action('woocommerce_shop_loop');

            wc_get_template_part('content', 'product');
        }
    }

    woocommerce_product_loop_end();

    /**
     * Hook: woocommerce_after_shop_loop.
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action('woocommerce_after_shop_loop');
} else {
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
