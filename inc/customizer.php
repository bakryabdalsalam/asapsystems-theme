<?php
function asapsystems_customize_register($wp_customize) {
    // Header Section
    $wp_customize->add_section('asapsystems_header', array(
        'title' => __('Header Settings', 'asapsystems'),
        'priority' => 30
    ));

    // Header Phone
    $wp_customize->add_setting('header_phone', array(
        'default' => '1-800-ASAPSYSTEMS',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('header_phone', array(
        'label' => __('Header Phone Number', 'asapsystems'),
        'section' => 'asapsystems_header',
        'type' => 'text'
    ));

    // Header CTA
    $wp_customize->add_setting('header_cta_text', array(
        'default' => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('header_cta_text', array(
        'label' => __('CTA Button Text', 'asapsystems'),
        'section' => 'asapsystems_header',
        'type' => 'text'
    ));

    $wp_customize->add_setting('header_cta_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('header_cta_url', array(
        'label' => __('CTA Button URL', 'asapsystems'),
        'section' => 'asapsystems_header',
        'type' => 'url'
    ));

    // Hero Section
    $wp_customize->add_section('asapsystems_hero', array(
        'title' => __('Hero Section', 'asapsystems'),
        'priority' => 31
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Inventory System, Asset Tracking & All-In-One Solution',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'asapsystems'),
        'section' => 'asapsystems_hero',
        'type' => 'text'
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'The Ultimate Practical Systems Powerful, Reliable, and Signing',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'asapsystems'),
        'section' => 'asapsystems_hero',
        'type' => 'text'
    ));

    // Hero Features
    $wp_customize->add_setting('hero_features', array(
        'default' => array(
            'Real-time Tracking',
            'Cloud-based Solution',
            '24/7 Support'
        ),
        'sanitize_callback' => 'asapsystems_sanitize_array'
    ));

    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hero_features',
        array(
            'label' => __('Hero Features (one per line)', 'asapsystems'),
            'section' => 'asapsystems_hero',
            'type' => 'textarea'
        )
    ));

    // Hero CTAs
    $wp_customize->add_setting('hero_cta_primary_text', array(
        'default' => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('hero_cta_primary_text', array(
        'label' => __('Primary CTA Text', 'asapsystems'),
        'section' => 'asapsystems_hero',
        'type' => 'text'
    ));

    $wp_customize->add_setting('hero_cta_primary_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('hero_cta_primary_url', array(
        'label' => __('Primary CTA URL', 'asapsystems'),
        'section' => 'asapsystems_hero',
        'type' => 'url'
    ));

    // Footer Section
    $wp_customize->add_section('asapsystems_footer', array(
        'title' => __('Footer Settings', 'asapsystems'),
        'priority' => 90
    ));

    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default' => 'Leading provider of inventory management and asset tracking solutions for businesses worldwide.',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('footer_description', array(
        'label' => __('Footer Description', 'asapsystems'),
        'section' => 'asapsystems_footer',
        'type' => 'textarea'
    ));

    // Footer Contact Info
    $wp_customize->add_setting('footer_phone', array(
        'default' => '1-800-ASAPSYSTEMS',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('footer_phone', array(
        'label' => __('Footer Phone', 'asapsystems'),
        'section' => 'asapsystems_footer',
        'type' => 'text'
    ));

    $wp_customize->add_setting('footer_email', array(
        'default' => 'info@asapsystems.com',
        'sanitize_callback' => 'sanitize_email'
    ));

    $wp_customize->add_control('footer_email', array(
        'label' => __('Footer Email', 'asapsystems'),
        'section' => 'asapsystems_footer',
        'type' => 'email'
    ));

    $wp_customize->add_setting('footer_address', array(
        'default' => '2121 South El Camino Real, San Mateo, CA 94403',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('footer_address', array(
        'label' => __('Footer Address', 'asapsystems'),
        'section' => 'asapsystems_footer',
        'type' => 'textarea'
    ));

    // Social Links
    $social_platforms = array(
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube',
        'instagram' => 'Instagram'
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('social_' . $platform, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control('social_' . $platform, array(
            'label' => sprintf(__('%s URL', 'asapsystems'), $label),
            'section' => 'asapsystems_footer',
            'type' => 'url'
        ));
    }
}
add_action('customize_register', 'asapsystems_customize_register');

// Sanitization Functions
function asapsystems_sanitize_array($input) {
    if (!is_array($input)) {
        $input = explode("\n", $input);
    }
    return array_map('sanitize_text_field', $input);
}

// Get theme mod with default
function asapsystems_get_theme_mod($setting, $default = '') {
    $value = get_theme_mod($setting, $default);
    return $value ? $value : $default;
}