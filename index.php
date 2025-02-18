<?php get_header(); ?>

<main class="main-content">
    <?php if (have_posts()) : ?>
        <div class="posts-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('post-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="post-content">
                        <header class="post-header">
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="post-meta">
                                <span class="post-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span class="post-categories">
                                        <i class="fas fa-folder"></i>
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="post-footer">
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php _e('Read More', 'asapsystems'); ?>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </footer>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php
        the_posts_pagination(array(
            'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'asapsystems'),
            'next_text' => __('Next', 'asapsystems') . ' <i class="fas fa-chevron-right"></i>',
            'screen_reader_text' => __('Posts navigation', 'asapsystems')
        ));
        ?>

    <?php else : ?>
        <div class="no-posts">
            <h2><?php _e('No Posts Found', 'asapsystems'); ?></h2>
            <p><?php _e('Sorry, no posts matched your criteria.', 'asapsystems'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?> 