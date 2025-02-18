<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="animate-title"><?php echo esc_html(get_theme_mod('hero_title', 'Inventory System, Asset Tracking & All-In-One Solution')); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('hero_subtitle', 'The Ultimate Practical Systems Powerful, Reliable, and Signing')); ?></p>
                <div class="hero-features">
                    <?php
                    $features = get_theme_mod('hero_features', array(
                        'Real-time Tracking',
                        'Cloud-based Solution',
                        '24/7 Support'
                    ));
                    foreach ($features as $feature) : ?>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo esc_html($feature); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="hero-cta">
                    <a href="<?php echo esc_url(get_theme_mod('hero_cta_primary_url', '#')); ?>" class="btn btn-primary btn-large">
                        <span><?php echo esc_html(get_theme_mod('hero_cta_primary_text', 'Get Started')); ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('hero_cta_secondary_url', '#')); ?>" class="btn btn-secondary btn-large">
                        <i class="fas fa-play"></i>
                        <span><?php echo esc_html(get_theme_mod('hero_cta_secondary_text', 'Watch Demo')); ?></span>
                    </a>
                </div>
                <div class="hero-stats">
                    <?php
                    $stats = array(
                        array(
                            'number' => get_theme_mod('hero_stat_1_number', '10K+'),
                            'label' => get_theme_mod('hero_stat_1_label', 'Active Users')
                        ),
                        array(
                            'number' => get_theme_mod('hero_stat_2_number', '98%'),
                            'label' => get_theme_mod('hero_stat_2_label', 'Satisfaction Rate')
                        ),
                        array(
                            'number' => get_theme_mod('hero_stat_3_number', '24/7'),
                            'label' => get_theme_mod('hero_stat_3_label', 'Customer Support')
                        )
                    );
                    foreach ($stats as $stat) : ?>
                        <div class="stat-item">
                            <span class="stat-number"><?php echo esc_html($stat['number']); ?></span>
                            <span class="stat-label"><?php echo esc_html($stat['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="image-wrapper">
                <?php
                $hero_image = get_theme_mod('hero_image', get_template_directory_uri() . '/assets/images/hero-image.jpg');
                ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(get_theme_mod('hero_image_alt', 'Inventory Management Professional')); ?>">
                <div class="floating-card card-1">
                    <i class="fas fa-chart-line"></i>
                    <span><?php echo esc_html(get_theme_mod('hero_card_1_text', 'Real-time Analytics')); ?></span>
                </div>
                <div class="floating-card card-2">
                    <i class="fas fa-shield-alt"></i>
                    <span><?php echo esc_html(get_theme_mod('hero_card_2_text', 'Secure System')); ?></span>
                </div>
                <div class="floating-card card-3">
                    <i class="fas fa-sync"></i>
                    <span><?php echo esc_html(get_theme_mod('hero_card_3_text', 'Auto Sync')); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products" id="products">
    <h2 class="section-title"><?php echo esc_html(get_theme_mod('products_title', 'Our Products')); ?></h2>
    <div class="products-grid">
        <?php
        $products = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => 3
        ));

        if ($products->have_posts()) :
            while ($products->have_posts()) : $products->the_post();
                ?>
                <div class="product-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail(); ?>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<!-- System Process -->
<section class="system-process">
    <h2 class="section-title"><?php echo esc_html(get_theme_mod('process_title', 'Full System Process')); ?></h2>
    <div class="process-diagram">
        <?php
        $process_steps = get_theme_mod('process_steps', array(
            array(
                'icon' => 'fas fa-barcode',
                'title' => 'Barcode Scanning'
            ),
            array(
                'icon' => 'fas fa-database',
                'title' => 'Data Processing'
            ),
            array(
                'icon' => 'fas fa-chart-line',
                'title' => 'Real-time Analytics'
            ),
            array(
                'icon' => 'fas fa-cloud',
                'title' => 'Cloud Storage'
            )
        ));

        foreach ($process_steps as $step) : ?>
            <div class="process-step">
                <div class="icon"><i class="<?php echo esc_attr($step['icon']); ?>"></i></div>
                <h4><?php echo esc_html($step['title']); ?></h4>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="testimonials-container">
        <h2 class="section-title"><?php echo esc_html(get_theme_mod('testimonials_title', 'What Our Clients Say')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html(get_theme_mod('testimonials_subtitle', 'Trusted by thousands of businesses worldwide')); ?></p>

        <div class="testimonials-wrapper">
            <button class="slider-btn prev-btn" aria-label="Previous testimonial">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="testimonials-slider">
                <?php
                $testimonials = new WP_Query(array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => -1
                ));

                if ($testimonials->have_posts()) :
                    while ($testimonials->have_posts()) : $testimonials->the_post();
                        $client_position = get_post_meta(get_the_ID(), '_client_position', true);
                        $rating = get_post_meta(get_the_ID(), '_rating', true);
                        ?>
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <div class="client-avatar">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    <?php else : ?>
                                        <i class="fas fa-user-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="client-info">
                                    <h3><?php the_title(); ?></h3>
                                    <p class="client-position"><?php echo esc_html($client_position); ?></p>
                                </div>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star<?php echo $i <= $rating ? '' : '-half-alt'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="testimonial-content">
                                <i class="fas fa-quote-left quote-icon"></i>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <button class="slider-btn next-btn" aria-label="Next testimonial">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="slider-dots">
            <?php
            if ($testimonials->have_posts()) :
                for ($i = 0; $i < $testimonials->post_count; $i++) :
                    ?>
                    <span class="dot<?php echo $i === 0 ? ' active' : ''; ?>"></span>
                    <?php
                endfor;
            endif;
            ?>
        </div>

        <div class="testimonials-cta">
            <p><?php echo esc_html(get_theme_mod('testimonials_cta_text', 'Join thousands of satisfied customers worldwide')); ?></p>
            <a href="<?php echo esc_url(get_theme_mod('testimonials_cta_url', '#')); ?>" class="btn btn-primary btn-large">
                <?php echo esc_html(get_theme_mod('testimonials_cta_button', 'Get Started Free')); ?>
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="contact-container">
        <div class="contact-header">
            <h2 class="section-title"><?php echo esc_html(get_theme_mod('contact_title', 'Get in Touch')); ?></h2>
            <p class="section-subtitle"><?php echo esc_html(get_theme_mod('contact_subtitle', 'Have questions? We\'d love to hear from you.')); ?></p>
        </div>

        <div class="contact-wrapper">
            <div class="contact-info-cards">
                <?php
                $contact_cards = array(
                    array(
                        'icon' => 'fas fa-phone-alt',
                        'title' => 'Call Us',
                        'content' => array(
                            get_theme_mod('contact_phone', '1-800-ASAPSYSTEMS'),
                            get_theme_mod('contact_hours', 'Monday - Friday, 9am - 6pm PST')
                        )
                    ),
                    array(
                        'icon' => 'fas fa-envelope',
                        'title' => 'Email Us',
                        'content' => array(
                            get_theme_mod('contact_email', 'info@asapsystems.com'),
                            get_theme_mod('contact_response', 'We\'ll respond within 24 hours')
                        )
                    ),
                    array(
                        'icon' => 'fas fa-map-marker-alt',
                        'title' => 'Visit Us',
                        'content' => array(
                            get_theme_mod('contact_address_1', '2121 South El Camino Real'),
                            get_theme_mod('contact_address_2', 'San Mateo, CA 94403')
                        )
                    )
                );

                foreach ($contact_cards as $card) : ?>
                    <div class="info-card">
                        <div class="icon">
                            <i class="<?php echo esc_attr($card['icon']); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <?php foreach ($card['content'] as $line) : ?>
                            <p><?php echo esc_html($line); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="contact-form-wrapper">
                <form class="contact-form" id="contactForm">
                    <?php wp_nonce_field('asapsystems_contact_form', 'contact_nonce'); ?>
                    <div class="form-header">
                        <h3><?php echo esc_html(get_theme_mod('contact_form_title', 'Send us a Message')); ?></h3>
                        <p><?php echo esc_html(get_theme_mod('contact_form_subtitle', 'Fill out the form below and we\'ll get back to you shortly.')); ?></p>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name"><?php _e('Full Name', 'asapsystems'); ?></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name" placeholder="<?php esc_attr_e('Enter your full name', 'asapsystems'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email"><?php _e('Email Address', 'asapsystems'); ?></label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="<?php esc_attr_e('Enter your email', 'asapsystems'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone"><?php _e('Phone Number', 'asapsystems'); ?></label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="tel" id="phone" name="phone" placeholder="<?php esc_attr_e('Enter your phone number', 'asapsystems'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject"><?php _e('Subject', 'asapsystems'); ?></label>
                            <div class="input-wrapper">
                                <i class="fas fa-tag"></i>
                                <select id="subject" name="subject" required>
                                    <option value="" disabled selected><?php _e('Select a subject', 'asapsystems'); ?></option>
                                    <option value="general"><?php _e('General Inquiry', 'asapsystems'); ?></option>
                                    <option value="support"><?php _e('Technical Support', 'asapsystems'); ?></option>
                                    <option value="sales"><?php _e('Sales', 'asapsystems'); ?></option>
                                    <option value="partnership"><?php _e('Partnership', 'asapsystems'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message"><?php _e('Message', 'asapsystems'); ?></label>
                        <div class="input-wrapper">
                            <i class="fas fa-comment-alt"></i>
                            <textarea id="message" name="message" placeholder="<?php esc_attr_e('Type your message here...', 'asapsystems'); ?>" required></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary submit-btn">
                            <span><?php _e('Send Message', 'asapsystems'); ?></span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>