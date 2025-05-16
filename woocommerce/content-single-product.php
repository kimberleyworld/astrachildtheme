<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 * 
 * @category WordPress_Theme
 * @package  WooCommerce\Templates
 * @author   Kimberley Dobney <username@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @version  9.4.0
 * @link     https://woocommerce.com/document/woocommerce-template-structure/
 * @see      https://woocommerce.com/document/template-structure/
 */

defined('ABSPATH') || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (! is_a($product, WC_Product::class) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');    
    /**
    * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    ?>
    <div class="product-image-container">
        <?php
        // Get the main image (product thumbnail)
        $main_image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'woocommerce_thumbnail');    
        // Get the hover image (second gallery image)
        $attachment_ids = $product->get_gallery_image_ids();
        $hover_image_id = isset($attachment_ids[0]) ? $attachment_ids[0] : '';
        $hover_image = $hover_image_id ? wp_get_attachment_image_src($hover_image_id, 'woocommerce_thumbnail') : '';    
        if ($main_image) :
            ?>
        <img class="main-image" src="<?php echo esc_url($main_image[0]); ?>" alt="<?php the_title(); ?>" />
            <?php if ($hover_image) : ?>
          <img class="hover-image" src="<?php echo esc_url($hover_image[0]); ?>" alt="<?php the_title(); ?>" />
            <?php endif; ?>
        <?php endif; ?>
</div>

<?php
/**
 * Hook: woocommerce_shop_loop_item_title.
 *
 * @hooked woocommerce_template_loop_product_title - 10
 */
do_action('woocommerce_shop_loop_item_title');

/**
 * Hook: woocommerce_after_shop_loop_item_title.
 *
 * @hooked woocommerce_template_loop_rating - 5
 * @hooked woocommerce_template_loop_price - 10
 */
do_action('woocommerce_after_shop_loop_item_title');

/**
 * Hook: woocommerce_after_shop_loop_item.
 *
 * @hooked woocommerce_template_loop_product_link_close - 5
 * @hooked woocommerce_template_loop_add_to_cart - 10
*/
do_action('woocommerce_after_shop_loop_item');
?>
</li>
