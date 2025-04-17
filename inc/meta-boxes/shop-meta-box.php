<?php
/**
 * Register the meta box for the shop page.
 *
 * @category MetaBoxes
 * @package  AstraChildTheme
 * @author   Your Name <your.email@example.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://yourwebsite.com
 */
// Register meta box.
add_action('add_meta_boxes', 'Register_Custom_Shop_Meta_box');
/**     
 * Register the meta box for the shop page.
 * 
 * @return void
 */
function Register_Custom_Shop_Meta_box() 
{
    add_meta_box(
        'custom_shop_intro',
        'Shop Page Intro',
        'custom_shop_intro_callback',
        'page',
        'normal',
        'high'
    );
}

/**
 * Meta box display callback.
 * 
 * @param object $post The post object.
 * 
 * @return void
 */
function Custom_Shop_Intro_callback( $post ) 
{
    if (get_option('woocommerce_shop_page_id') != $post->ID) { 
        return;
    }

    $image_id = get_post_meta($post->ID, '_custom_shop_intro_image_id', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
    $intro_text = get_post_meta($post->ID, '_custom_shop_intro', true);

    wp_nonce_field('custom_shop_intro_nonce', 'custom_shop_intro_nonce_field');
    ?>
    
    <div style="margin-bottom: 20px;">
        <label for="custom_shop_intro_image"><strong>Intro Image</strong></label>
        <p>Leave blank if you don't want an image. No file size above 600kb to avoid slowing site.</p>
        <img id="custom-shop-intro-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; display: <?php echo $image_url ? 'block' : 'none'; ?>; margin-bottom: 10px;" />
        <input type="hidden" id="custom_shop_intro_image" name="custom_shop_intro_image" value="<?php echo esc_attr($image_id); ?>">
        <button type="button" class="button" id="custom-shop-intro-upload">Select Image</button>
        <button type="button" class="button" id="custom-shop-intro-remove" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;">Remove</button>
    </div>

    <label for="custom_shop_intro_field"><strong>Intro Text</strong></label><br>
    <textarea style="width:80%;height:150px;" name="custom_shop_intro_field"><?php echo esc_textarea($intro_text); ?></textarea>

    <script>
        jQuery(document).ready(function($) {
            let mediaUploader;

            $('#custom-shop-intro-upload').on('click', function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media({
                    title: 'Select or Upload Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#custom_shop_intro_image').val(attachment.id);
                    $('#custom-shop-intro-preview').attr('src', attachment.url).show();
                    $('#custom-shop-intro-remove').show();
                });

                mediaUploader.open();
            });

            $('#custom-shop-intro-remove').on('click', function() {
                $('#custom_shop_intro_image').val('');
                $('#custom-shop-intro-preview').hide();
                $(this).hide();
            });
        });
    </script>
    <?php
}
// Save meta box data.
add_action('save_post', 'Save_Custom_Shop_Intro_meta');
/**
 * Meta box display callback.
 * 
 * @param int $post_id The post ID.
 * 
 * @return void
 */
function Save_Custom_Shop_Intro_meta($post_id) 
{
    if (! isset($_POST['custom_shop_intro_nonce_field']) 
        || ! wp_verify_nonce($_POST['custom_shop_intro_nonce_field'], 'custom_shop_intro_nonce') 
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        || ! current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (isset($_POST['custom_shop_intro_field'])) {
        update_post_meta(
            $post_id,
            '_custom_shop_intro',
            sanitize_textarea_field($_POST['custom_shop_intro_field'])
        );
    }

    if (isset($_POST['custom_shop_intro_image'])) {
        update_post_meta(
            $post_id,
            '_custom_shop_intro_image_id',
            absint($_POST['custom_shop_intro_image'])
        );
    }
}
