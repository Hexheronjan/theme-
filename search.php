<?php
/**
 * Search Results Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content category-archive-layout">
    <div class="container">
        <div class="archive-header-card search-results-banner">
            <?php berita_breadcrumb(); ?>
            <h1 class="archive-main-title">
                <?php
                printf(
                    __('Hasil Pencarian untuk: "%s"', 'berita'),
                    '<span>' . esc_html(get_search_query()) . '</span>'
                );
                ?>
            </h1>
            <p class="archive-cat-description">
                <?php
                global $wp_query;
                $found_posts = $wp_query->found_posts;
                printf(
                    _n('Ditemukan %d artikel yang relevan', 'Ditemukan %d artikel yang relevan', $found_posts, 'berita'),
                    $found_posts
                );
                ?>
            </p>
        </div>

        <div class="archive-content-block">
            <?php if (have_posts()) : ?>
                <div class="archive-posts-grid">
                    <?php while (have_posts()) : the_post(); 
                        $cats = get_the_category();
                        $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-card'); ?>>
                            <div class="archive-thumb-box">
                                <a href="<?php the_permalink(); ?>" tabindex="-1">
                                    <?php berita_display_post_thumbnail('berita-card'); ?>
                                </a>
                            </div>

                            <div class="archive-card-body">
                                <div class="archive-card-cat">
                                    <span><?php echo esc_html(strtoupper($cat_name)); ?></span>
                                </div>

                                <h2 class="archive-card-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="archive-card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                                </div>

                                <div class="archive-card-meta">
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
                    <?php endwhile; ?>
                </div>

                <div class="pagination-wrapper">
                    <?php berita_pagination(); ?>
                </div>

            <?php else : ?>
                <div class="empty-archive-box">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <h2><?php _e('Tidak Ada Hasil yang Cocok', 'berita'); ?></h2>
                    <p><?php printf(__('Maaf, tidak ditemukan berita dengan kata kunci "%s". Silakan coba kata kunci lain.', 'berita'), esc_html(get_search_query())); ?></p>
                    <div style="max-width: 500px; margin: 20px auto 0;">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
