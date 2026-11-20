<?php
/**
 * Content Single Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

berita_track_post_views();
$cats = get_the_category();
$cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
$cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-article-card'); ?>>
    <header class="single-article-header">
        <?php berita_breadcrumb(); ?>

        <div class="single-cat-badge-wrap">
            <a href="<?php echo esc_url($cat_link); ?>" class="cat-pill cat-pill-red">
                <?php echo esc_html(strtoupper($cat_name)); ?>
            </a>
        </div>

        <h1 class="single-article-title">
            <?php the_title(); ?>
        </h1>

        <div class="single-meta-strip">
            <div class="meta-author-wrap">
                <span class="meta-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 36); ?>
                </span>
                <span class="meta-author-name">
                    <?php _e('Oleh', 'berita'); ?> <strong><?php the_author(); ?></strong>
                </span>
            </div>

            <div class="meta-details-wrap">
                <span class="meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo get_the_date('l, j F Y H:i'); ?> WIB
                </span>
                <span class="meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <?php echo berita_get_views(); ?> views
                </span>
                <span class="meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 10"/></svg>
                    <?php echo berita_get_reading_time(); ?>
                </span>
            </div>
        </div>

        <div class="single-top-share">
            <?php berita_social_share(); ?>
        </div>
    </header>

    <div class="single-featured-media">
        <?php if (berita_get_video_url()) : ?>
            <?php echo berita_render_video_embed(get_the_ID(), 'single-video-player'); ?>
        <?php else : ?>
            <?php berita_display_post_thumbnail('berita-hero', 'single-hero-img'); ?>
            <?php
            $thumb_id = get_post_thumbnail_id();
            if ($thumb_id && get_post($thumb_id)->post_excerpt) : ?>
                <figcaption class="featured-caption">
                    <?php echo esc_html(get_post($thumb_id)->post_excerpt); ?>
                </figcaption>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="single-entry-content">
        <?php the_content(); ?>
    </div>

    <footer class="single-article-footer">
        <?php if (has_tag()) : ?>
            <div class="single-tags-wrap">
                <span class="tags-label">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    <?php _e('Topik Terkait:', 'berita'); ?>
                </span>
                <div class="tags-list">
                    <?php the_tags('', '', ''); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="single-bottom-share">
            <?php berita_social_share(); ?>
        </div>

        <!-- Post Navigation Prev/Next -->
        <nav class="single-post-navigation" aria-label="<?php esc_attr_e('Navigasi Artikel', 'berita'); ?>">
            <div class="nav-links">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <?php if (!empty($prev_post)) : ?>
                    <div class="nav-previous">
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="nav-post-link">
                            <span class="nav-subtitle">&laquo; <?php _e('Artikel Sebelumnya', 'berita'); ?></span>
                            <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($next_post)) : ?>
                    <div class="nav-next">
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="nav-post-link">
                            <span class="nav-subtitle"><?php _e('Artikel Berikutnya', 'berita'); ?> &raquo;</span>
                            <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </footer>

    <!-- Related News -->
    <?php get_template_part('template-parts/related-news'); ?>

    <!-- Comments -->
    <?php
    if (comments_open() || get_comments_number()) :
        comments_template('/comments.php');
    endif;
    ?>
</article>
