<?php
/**
 * Meta boxes for the Story page.
 *
 * @category MetaBoxes
 * @package  AstraChildTheme
 * @author   Your Name <your.email@example.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://yourwebsite.com
 */

add_action('add_meta_boxes', 'Register_Story_Meta_boxes');
/**
 * Register the meta box for the Story page.
 *
 * @return void
 */
function Register_Story_Meta_boxes() 
{
    add_meta_box(
        'story_page_meta',
        'Story Page Content',
        'Render_Story_Meta_box',
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
function Render_Story_Meta_box( $post ) 
{
    // Only show on "Story" page
    if (strtolower(get_the_title($post)) !== 'story') {
        return;
    }

    // Get saved values
    $video_id = get_post_meta($post->ID, '_story_video_id', true);
    $section_1 = get_post_meta($post->ID, '_story_section_1', true);
    $section_2 = get_post_meta($post->ID, '_story_section_2', true);
    $section_3 = get_post_meta($post->ID, '_story_section_3', true);
    $section_4 = get_post_meta($post->ID, '_story_section_4', true);



    wp_nonce_field('save_story_meta_box', 'story_meta_nonce');
    ?>

    <p>
    <label for="story_video_id"><strong>YouTube Video ID:</strong></label><br>
    <input type="text" name="story_video_id" id="story_video_id" value="<?php echo esc_attr($video_id); ?>" style="width:100%;" />
    <small>Enter the 11-character YouTube video ID (e.g., <code>dQw4w9WgXcQ</code>).</small>
</p>

    <?php for ( $i = 1; $i <= 4; $i++ ) : 
        $value = ${"section_$i"};
        ?>
        <p>
            <label for="story_section_<?php echo $i; ?>"><strong>Section <?php echo $i; ?> Text:</strong></label><br>
            <textarea name="story_section_<?php echo $i; ?>" id="story_section_<?php echo $i; ?>" rows="4" style="width:100%;"><?php echo esc_textarea($value); ?></textarea>
        </p>
    <?php endfor; ?>

    <?php
}

add_action('save_post', 'Save_Story_Meta_boxes');
/**
 * Meta box display callback.
 * 
 * @param int $post_id The post ID.
 * 
 * @return void
 */
function Save_Story_Meta_boxes( $post_id ) 
{
    // Security checks
    if (! isset($_POST['story_meta_nonce']) || ! wp_verify_nonce($_POST['story_meta_nonce'], 'save_story_meta_box') ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { 
        return;
    }
    if (! current_user_can('edit_post', $post_id)) { 
        return;
    }

     // Save video ID (validate it)
    if (isset($_POST['story_video_id'])) {
        $video_id = sanitize_text_field($_POST['story_video_id']);

        // Validate YouTube video ID (must be 11 characters and alphanumeric)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $video_id)) {
            update_post_meta($post_id, '_story_video_id', $video_id);
        } else {
            // If the ID is invalid, set a default or remove the meta (optional)
            delete_post_meta($post_id, '_story_video_id');
        }
    }

    // Save each section
    for ( $i = 1; $i <= 4; $i++ ) {
        if (isset($_POST[ "story_section_$i" ])) {
            update_post_meta($post_id, "_story_section_$i", sanitize_textarea_field($_POST[ "story_section_$i" ]));
        }
    }
}
