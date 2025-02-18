<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header class="header">
    <nav class="nav-container">
        <div class="logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
            }
            ?>
        </div>

        <div class="nav-links">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav-menu',
                'walker' => new ASAP_Menu_Walker()
            ));
            ?>
        </div>

        <div class="nav-buttons">
            <?php 
            $phone_number = get_theme_mod('header_phone', '1-800-ASAPSYSTEMS');
            $cta_text = get_theme_mod('header_cta_text', 'Get Started');
            $cta_url = get_theme_mod('header_cta_url', '#');
            ?>
            <a href="tel:<?php echo esc_attr(str_replace('-', '', $phone_number)); ?>" class="phone-number">
                <i class="fas fa-phone"></i>
                <?php echo esc_html($phone_number); ?>
            </a>
            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary"><?php echo esc_html($cta_text); ?></a>
        </div>

        <button class="mobile-menu-btn" aria-label="Toggle mobile menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</header> 