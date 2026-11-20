<?php
/**
 * Hero News Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_args = array(
    'posts_per_page'      => 4,
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => 1,
);
$hero_query = new WP_Query($hero_args);

if ($hero_query->have_posts()) :
    $hero_posts = $hero_query->posts;
    $main_post = isset($hero_posts[0]) ? $hero_posts[0] : null;
    $secondary_posts = array_slice($hero_posts, 1, 3);
?>
<section class="hero-news-section" aria-label="<?php esc_attr_e('Berita Utama', 'berita'); ?>">
    <div class="hero-grid-layout">
        <!-- Main Featured Article (Left) -->
        <?php if ($main_post) : 
            $post = $main_post;
            setup_postdata($post);
            $cats = get_the_category();
            $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
            $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
        ?>
            <div class="hero-main-card">
                <article class="hero-featured-article">
                    <div class="hero-img-wrapper">
                        <a href="<?php the_permalink(); ?>" class="hero-img-link" tabindex="-1">
                            <?php berita_display_post_thumbnail('berita-hero', 'hero-bg-image'); ?>
                        </a>
                        <div class="hero-gradient-overlay"></div>
                    </div>

                    <div class="hero-overlay-content">
                        <div class="hero-badge-row">
                            <a href="<?php echo esc_url($cat_link); ?>" class="cat-pill cat-pill-red">
                                <?php echo esc_html(strtoupper($cat_name)); ?>
                            </a>
                        </div>

                        <h2 class="hero-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <div class="hero-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                        </div>

                        <div class="hero-meta-row">
                            <div class="hero-meta-left">
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <?php echo get_the_date(); ?>
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

                            <a href="<?php the_permalink(); ?>" class="hero-read-arrow" aria-label="<?php esc_attr_e('Baca Berita', 'berita'); ?>">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        <!-- Secondary Articles Stack (Right) -->
        <div class="hero-side-stack">
            <?php
            foreach ($secondary_posts as $sec_post) :
                $post = $sec_post;
                setup_postdata($post);
                $cats = get_the_category();
                $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
            ?>
                <article class="hero-side-card">
                    <div class="hero-side-thumb">
                        <a href="<?php the_permalink(); ?>" class="thumb-link" tabindex="-1">
                            <?php berita_display_post_thumbnail('berita-card'); ?>
                        </a>
                    </div>
                    <div class="hero-side-info">
                        <div class="hero-side-badge-row">
                            <a href="<?php echo esc_url($cat_link); ?>" class="cat-pill cat-pill-blue">
                                <?php echo esc_html(strtoupper($cat_name)); ?>
                            </a>
                        </div>
                        <h3 class="hero-side-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="hero-side-meta">
                            <span class="meta-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="meta-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <?php echo berita_get_views(); ?>
                            </span>
                        </div>
                    </div>
                </article>
            <?php 
            endforeach;
            wp_reset_postdata(); 
            ?>
        </div>
    </div>
</section>
<?php endif; ?>
