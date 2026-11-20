<?php
/**
 * Breaking News Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$breaking_args = array(
    'posts_per_page'      => 6,
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => 1,
);
$breaking_query = new WP_Query($breaking_args);
?>

<div class="breaking-news-section">
    <div class="container">
        <div class="breaking-news-container">
            <div class="breaking-news-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span><?php _e('BREAKING NEWS', 'berita'); ?></span>
            </div>
            
            <div class="breaking-news-track-wrapper">
                <div class="breaking-news-slider">
                    <?php
                    if ($breaking_query->have_posts()) :
                        $b_idx = 0;
                        while ($breaking_query->have_posts()) : $breaking_query->the_post();
                            $b_idx++;
                            ?>
                            <div class="breaking-news-slide <?php echo $b_idx === 1 ? 'active' : ''; ?>">
                                <a href="<?php the_permalink(); ?>" class="breaking-news-link">
                                    <span class="breaking-news-title"><?php the_title(); ?></span>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="breaking-news-slide active">
                            <span class="breaking-news-title"><?php _e('Pemerintah Siapkan Insentif Baru untuk Dorong Pertumbuhan Ekonomi Nasional', 'berita'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="breaking-news-controls">
                <button type="button" class="breaking-news-prev" aria-label="<?php esc_attr_e('Berita Sebelumnya', 'berita'); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button type="button" class="breaking-news-next" aria-label="<?php esc_attr_e('Berita Selanjutnya', 'berita'); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
