<?php
/**
 * Popular News Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="popular-news-widget">
    <h3 class="widget-title"><?php _e('Berita Terpopuler', 'berita'); ?></h3>
    <div class="popular-news-list">
        <?php
        $popular_args = array(
            'posts_per_page' => 5,
            'orderby'        => 'comment_count',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        );
        $popular_query = new WP_Query($popular_args);

        if ($popular_query->have_posts()) :
            $count = 1;
            while ($popular_query->have_posts()) : $popular_query->the_post();
                ?>
                <div class="popular-news-item">
                    <span class="popular-number"><?php echo sprintf('%02d', $count); ?></span>
                    <div class="popular-news-content">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="popular-news-thumb">
                                <?php the_post_thumbnail('berita-thumbnail'); ?>
                            </a>
                        <?php endif; ?>
                        <h4 class="popular-news-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <div class="popular-news-meta">
                            <span class="popular-news-category">
                                <?php the_category(', '); ?>
                            </span>
                            <span class="popular-news-date">
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <p><?php _e('Belum ada berita.', 'berita'); ?></p>
            <?php
        endif;
        ?>
    </div>
</div>
