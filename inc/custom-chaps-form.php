<?php
/**
 * Custom Chaps Product Form
 *
 * This file contains the implementation of a WooCommerce product customization form
 * for a specific product. It allows users to select options like shape, style, materials,
 * colors, accessories, and more.
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
 * Custom Checkbox Group  
 * 
 * @param string $name    The name attribute for the checkbox group.
 * @param string $title   The legend/title for the fieldset.
 * @param array  $options The options to be rendered as checkboxes.
 * @param string $note    Optional note to display under the legend.
 * 
 * @return void
 */
function Custom_Checkbox_group($name, $title, $options, $note = '') 
{
    echo "<fieldset><legend><strong>$title</strong></legend>";
    echo $note ? "<p><em>$note</em></p>" : "";
    foreach ($options as $option) {
        $val = esc_attr($option);
        echo "<label><input type='checkbox' name='{$name}[]' value='$val'> $option</label><br>";
    }
    echo "</fieldset>";
}

// Then: your main form function
add_action('woocommerce_before_add_to_cart_button', 'custom_chaps_form');

/**
 * Create form for custom chaps
 * 
 * @return void
 */
function Custom_Chaps_form() 
{
    if (get_the_title() !== 'Custom Chaps') {
        return; 
    }
    ?>

    <div class="custom-chaps-form" style="margin-bottom:20px;">
        <h3>Let’s make a unique cheeky pair 🩷</h3>
        <p><strong>Tick your faves, and if there’s anything you’re dead set on, pop it in the comment box at the end!</strong></p>

        <fieldset>
            <legend><strong>SHAPE</strong></legend>
            <label><input type="radio" name="shape" value="Long WB" required> Long WB</label><br>
            <label><input type="radio" name="shape" value="Short WB"> Short WB</label>
        </fieldset>

        <fieldset>
            <legend><strong>STYLE</strong></legend>
            <label><input type="radio" name="style" value="Classic" required> Classic</label><br>
            <label><input type="radio" name="style" value="Two-toned"> Two-toned</label><br>
            <label><input type="radio" name="style" value="Luxe"> Luxe</label>
        </fieldset>

        <?php
        custom_checkbox_group(
            'materials', 
            'FAVE MATERIALS', 
            ['Denim', 'Velvet', 'Faux leather', 'PVC', 'Satin', 'Mesh', 'Lace', 'Cotton', 'Jersey', 'Tulle', 'Faux fur', 'Metallics', 'Sparkly', 'Sheer'], '📝 If there’s something here you really want your chaps to include, let me know in the box at the end!'
        );

        custom_checkbox_group(
            'colours', 'FAVE COLOURS', [
            'Black', 'White', 'Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Pink', 'Purple', 'Grey', 'Gold', 'Silver', 'Rainbow', 'Pastel', 'Neon', 'Earth tones'], 
            '📝 Not all materials come in every colour, but this helps me vibe with your taste.'
        );

        custom_checkbox_group(
            'accessories', 'FAVE ACCESSORIES', 
            ['Eyelets', 'Chains', 'Leather fringe', 'Frills', 'Ruffles', 'Pompom trim', 'Rhinestones', 'Studs', 'Grommets', 'Zips', 'Pockets',
            'Contrast stitching', 'Decorative straps', 'Buckles', 'Lace-up', 'Patchwork', 'Embroidery', 'Appliqué'], 
            '📝 Again, let me know if any of these are non-negotiables in the comment box!'
        );

        custom_checkbox_group(
            'vibes', 'VIBE CHECK', [
            'Camp', 'Sexy', 'Silly', 'Chic', 'Punk', 'Sporty', 'Witchy', 'Soft', 'Dramatic', 'Minimal', 'Maximal', 'Retro',
            'Futuristic', 'Festival', 'Rave', 'Fairy', 'Cowboy', 'Clowncore', 'Y2K', 'High-fashion', 'DIY']
        );
        ?>

        <p><label for="dream_moment"><strong>Where would you wear chaps?</strong><br>
        <textarea name="dream_moment" rows="3" placeholder="Festival? Drag brunch? Grocery run?" required></textarea></label></p>

        <p><label for="extra_notes"><strong>Anything else?</strong><br>
        <textarea name="extra_notes" rows="4" placeholder="A detail you have to include? A material you hate? A love letter to chaps in general?"></textarea></label></p>

    </div>

    <?php
}

add_filter('woocommerce_add_cart_item_data', 'save_chaps_form_data', 10, 2);

/**
 * Saves chaps form data to cart.
 * 
 * @param array $cart_item_data The cart item data.
 * @param int   $product_id     The product ID.
 * 
 * @return void
 */
function Save_Chaps_Form_data($cart_item_data, $product_id) 
{
    $fields = ['shape', 'style', 'materials', 'colours', 'accessories', 'vibes', 'dream_moment', 'extra_notes'];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = is_array($_POST[$field]) ? array_map('sanitize_text_field', $_POST[$field]) : sanitize_text_field($_POST[$field]);
            $cart_item_data[$field] = $value;
        }
    }

    return $cart_item_data;
}

/**
 * Display chaps custom data in cart
 * 
 * @param array $item_data The item data.
 * @param array $cart_item The cart item data.
 *
 * @return array
 */
function Display_Chaps_Data_In_cart($item_data, $cart_item) 
{
    foreach ($cart_item as $key => $value) {
        if (in_array($key, ['shape', 'style', 'materials', 'colours', 'accessories', 'vibes', 'dream_moment', 'extra_notes'])) {
            $label = ucwords(str_replace('_', ' ', $key));
            $formatted = is_array($value) ? implode(', ', $value) : $value;
            $item_data[] = ['key' => $label, 'value' => $formatted];
        }
    }
    return $item_data;
}

add_filter('woocommerce_get_item_data', 'Display_Chaps_Data_In_cart', 10, 2);

/**
 * Save chaps data to order.
 * 
 * @param array  $item_id       The item ID.
 * @param array  $values        The values from the cart item.
 * @param string $cart_item_key The cart item key.
 * 
 * @return void
 */
function Save_Chaps_Data_To_order($item_id, $values, $cart_item_key) 
{
    foreach ($values as $key => $value) {
        if (in_array($key, ['shape', 'style', 'materials', 'colours', 'accessories', 'vibes', 'dream_moment', 'extra_notes'])) {
            $formatted = is_array($value) ? implode(', ', $value) : $value;
            wc_add_order_item_meta($item_id, ucwords(str_replace('_', ' ', $key)), $formatted);
        }
    }
}
