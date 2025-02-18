    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section company-info">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                }
                ?>
                <p class="company-description"><?php echo esc_html(get_theme_mod('footer_description', 'Leading provider of inventory management and asset tracking solutions for businesses worldwide.')); ?></p>
                <div class="contact-info">
                    <?php
                    $phone = get_theme_mod('footer_phone', '1-800-ASAPSYSTEMS');
                    $email = get_theme_mod('footer_email', 'info@asapsystems.com');
                    $address = get_theme_mod('footer_address', '2121 South El Camino Real, San Mateo, CA 94403');
                    ?>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span><?php echo esc_html($phone); ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><?php echo esc_html($email); ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo esc_html($address); ?></span>
                    </div>
                </div>
            </div>

            <div class="footer-section quick-links">
                <h3><?php echo esc_html__('Quick Links', 'asapsystems'); ?></h3>
                <div class="links-grid">
                    <div class="links-column">
                        <h4><?php echo esc_html__('Products', 'asapsystems'); ?></h4>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_products',
                            'container' => false,
                            'fallback_cb' => false
                        ));
                        ?>
                    </div>
                    <div class="links-column">
                        <h4><?php echo esc_html__('Company', 'asapsystems'); ?></h4>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_company',
                            'container' => false,
                            'fallback_cb' => false
                        ));
                        ?>
                    </div>
                    <div class="links-column">
                        <h4><?php echo esc_html__('Support', 'asapsystems'); ?></h4>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer_support',
                            'container' => false,
                            'fallback_cb' => false
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="footer-section newsletter">
                <h3><?php echo esc_html__('Stay Updated', 'asapsystems'); ?></h3>
                <p><?php echo esc_html__('Subscribe to our newsletter for the latest updates and industry insights.', 'asapsystems'); ?></p>
                <form class="newsletter-form" id="newsletterForm">
                    <?php wp_nonce_field('newsletter_subscription', 'newsletter_nonce'); ?>
                    <div class="input-group">
                        <input type="email" placeholder="<?php echo esc_attr__('Enter your email', 'asapsystems'); ?>" required>
                        <button type="submit" class="btn btn-primary"><?php echo esc_html__('Subscribe', 'asapsystems'); ?></button>
                    </div>
                </form>
                <div class="social-links">
                    <?php
                    $social_links = array(
                        'facebook' => get_theme_mod('social_facebook'),
                        'twitter' => get_theme_mod('social_twitter'),
                        'linkedin' => get_theme_mod('social_linkedin'),
                        'youtube' => get_theme_mod('social_youtube'),
                        'instagram' => get_theme_mod('social_instagram')
                    );

                    foreach ($social_links as $platform => $url) {
                        if ($url) {
                            echo '<a href="' . esc_url($url) . '" title="' . esc_attr(ucfirst($platform)) . '" target="_blank" rel="noopener noreferrer">';
                            echo '<i class="fab fa-' . esc_attr($platform) . '"></i>';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php echo esc_html__('All rights reserved.', 'asapsystems'); ?></p>
                </div>
                <div class="legal-links">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_legal',
                        'container' => false,
                        'fallback_cb' => false,
                        'depth' => 1
                    ));
                    ?>
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html> 