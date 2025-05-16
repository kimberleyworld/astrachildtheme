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
?>

<div id="p5-stars"></div>

<style>
  #p5-stars {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 0;
    width: 100vw;
    height: 100vh;
    pointer-events: none;
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.min.js"></script>
<script>
let stars = [];

function setup() {
  let canvas = createCanvas(windowWidth, windowHeight);
  canvas.parent('p5-stars');
  noStroke();
}

function draw() {
  clear();
  for (let i = stars.length - 1; i >= 0; i--) {
    stars[i].update();
    stars[i].display();
    if (stars[i].isDead()) {
      stars.splice(i, 1);
    }
  }
}

function mouseMoved() {
  for (let i = 0; i < 3; i++) {
    stars.push(new Star(mouseX, mouseY));
  }
}

class Star {
  constructor(x, y) {
    this.x = x;
    this.y = y;
    this.life = 255;
    this.outerRadius = random(6, 10);
    this.innerRadius = this.outerRadius / 2.5;
    this.angle = random(TWO_PI);
    this.speed = random(0.2, 1.5);
  }

  update() {
    this.x += cos(this.angle) * this.speed;
    this.y += sin(this.angle) * this.speed;
    this.life -= 4;
  }

  display() {
    push();
    translate(this.x, this.y);
    fill(255, 255, 255, this.life);
    beginShape();
    let points = 5;
    for (let i = 0; i < points * 2; i++) {
      let angle = PI * i / points;
      let r = i % 2 === 0 ? this.outerRadius : this.innerRadius;
      let sx = cos(angle) * r;
      let sy = sin(angle) * r;
      vertex(sx, sy);
    }
    endShape(CLOSE);
    pop();
  }

  isDead() {
    return this.life <= 0;
  }
}
</script>

<?php get_footer('shop'); ?>
