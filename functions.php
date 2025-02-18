<?php
if (!defined('ABSPATH')) exit;

// Theme Setup
function asapsystems_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'asapsystems'),
        'footer_products' => __('Footer Products', 'asapsystems'),
        'footer_company' => __('Footer Company', 'asapsystems'),
        'footer_support' => __('Footer Support', 'asapsystems')
    ));
}
add_action('after_setup_theme', 'asapsystems_setup');

// Enqueue scripts and styles
function asapsystems_scripts() {
    // Styles
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    wp_enqueue_style('asapsystems-style', get_stylesheet_uri());
    wp_enqueue_style('asapsystems-main', get_template_directory_uri() . '/assets/css/main.css');

    // Scripts
    wp_enqueue_script('asapsystems-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);

    // Localize script for AJAX
    wp_localize_script('asapsystems-main', 'asapsystemsAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('asapsystems-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'asapsystems_scripts');

// Custom Post Types
function asapsystems_register_post_types() {
    // Testimonials
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'asapsystems'),
            'singular_name' => __('Testimonial', 'asapsystems')
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail')
    ));

    // Videos
    register_post_type('video', array(
        'labels' => array(
            'name' => __('Videos', 'asapsystems'),
            'singular_name' => __('Video', 'asapsystems')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'thumbnail')
    ));

    // News
    register_post_type('news', array(
        'labels' => array(
            'name' => __('News', 'asapsystems'),
            'singular_name' => __('News', 'asapsystems')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title', 'editor', 'thumbnail')
    ));
}
add_action('init', 'asapsystems_register_post_types');

// Custom Meta Boxes
function asapsystems_add_meta_boxes() {
    // Testimonial meta
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'asapsystems'),
        'asapsystems_testimonial_meta_box',
        'testimonial',
        'normal',
        'high'
    );

    // Video meta
    add_meta_box(
        'video_details',
        __('Video Details', 'asapsystems'),
        'asapsystems_video_meta_box',
        'video',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'asapsystems_add_meta_boxes');

// Testimonial meta box callback
function asapsystems_testimonial_meta_box($post) {
    $client_position = get_post_meta($post->ID, '_client_position', true);
    $rating = get_post_meta($post->ID, '_rating', true);
    
    wp_nonce_field('asapsystems_testimonial_meta', 'testimonial_meta_nonce');
    ?>
    <p>
        <label for="client_position"><?php _e('Client Position', 'asapsystems'); ?></label>
        <input type="text" id="client_position" name="client_position" value="<?php echo esc_attr($client_position); ?>" class="widefat">
    </p>
    <p>
        <label for="rating"><?php _e('Rating (1-5)', 'asapsystems'); ?></label>
        <input type="number" id="rating" name="rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" class="widefat">
    </p>
    <?php
}

// Video meta box callback
function asapsystems_video_meta_box($post) {
    $video_url = get_post_meta($post->ID, '_video_url', true);
    $video_duration = get_post_meta($post->ID, '_video_duration', true);
    
    wp_nonce_field('asapsystems_video_meta', 'video_meta_nonce');
    ?>
    <p>
        <label for="video_url"><?php _e('Video URL', 'asapsystems'); ?></label>
        <input type="url" id="video_url" name="video_url" value="<?php echo esc_url($video_url); ?>" class="widefat">
    </p>
    <p>
        <label for="video_duration"><?php _e('Duration (e.g., 3:45)', 'asapsystems'); ?></label>
        <input type="text" id="video_duration" name="video_duration" value="<?php echo esc_attr($video_duration); ?>" class="widefat">
    </p>
    <?php
}

// Save meta box data
function asapsystems_save_meta_box_data($post_id) {
    // Save testimonial meta
    if (isset($_POST['testimonial_meta_nonce']) && wp_verify_nonce($_POST['testimonial_meta_nonce'], 'asapsystems_testimonial_meta')) {
        if (isset($_POST['client_position'])) {
            update_post_meta($post_id, '_client_position', sanitize_text_field($_POST['client_position']));
        }
        if (isset($_POST['rating'])) {
            update_post_meta($post_id, '_rating', intval($_POST['rating']));
        }
    }

    // Save video meta
    if (isset($_POST['video_meta_nonce']) && wp_verify_nonce($_POST['video_meta_nonce'], 'asapsystems_video_meta')) {
        if (isset($_POST['video_url'])) {
            update_post_meta($post_id, '_video_url', esc_url_raw($_POST['video_url']));
        }
        if (isset($_POST['video_duration'])) {
            update_post_meta($post_id, '_video_duration', sanitize_text_field($_POST['video_duration']));
        }
    }
}
add_action('save_post', 'asapsystems_save_meta_box_data');

// Contact Form AJAX Handler
function asapsystems_handle_contact_form() {
    check_ajax_referer('asapsystems-nonce', 'nonce');

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    $to = get_option('admin_email');
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $email_content = sprintf(
        'Name: %s<br>Email: %s<br>Phone: %s<br>Subject: %s<br>Message: %s',
        $name,
        $email,
        $phone,
        $subject,
        nl2br($message)
    );

    $sent = wp_mail($to, 'New Contact Form Submission', $email_content, $headers);

    wp_send_json(array(
        'success' => $sent,
        'message' => $sent ? 'Thank you! Your message has been sent successfully.' : 'Oops! Something went wrong. Please try again later.'
    ));
}
add_action('wp_ajax_asapsystems_contact_form', 'asapsystems_handle_contact_form');
add_action('wp_ajax_nopriv_asapsystems_contact_form', 'asapsystems_handle_contact_form');

// Theme Options
function asapsystems_theme_options() {
    add_menu_page(
        __('Theme Options', 'asapsystems'),
        __('Theme Options', 'asapsystems'),
        'manage_options',
        'asapsystems-options',
        'asapsystems_theme_options_page',
        'dashicons-admin-customizer'
    );
}
add_action('admin_menu', 'asapsystems_theme_options');

// Theme Options Page
function asapsystems_theme_options_page() {
    // Add theme options page content here
} 