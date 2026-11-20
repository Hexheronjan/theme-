<?php
/**
 * Archive Template
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
        <div class="archive-header-card">
            <?php berita_breadcrumb(); ?>
            <div class="archive-title-flex">
                <div class="archive-title-text">
                    <h1 class="archive-main-title">
                        <?php
                        if (is_day()) {
                            printf(__('Arsip Berita: %s', 'berita'), get_the_date());
                        } elseif (is_month()) {
                            printf(__('Arsip Berita: %s', 'berita'), get_the_date('F Y'));
                        } elseif (is_year()) {
                            printf(__('Arsip Berita: %s', 'berita'), get_the_date('Y'));
                        } elseif (is_author()) {
                            printf(__('Penulis: %s', 'berita'), get_the_author());
                        } elseif (is_tag()) {
                            printf(__('Topik: %s', 'berita'), single_tag_title('', false));
                        } else {
                            the_archive_title();
                        }
                        ?>
                    </h1>
                    <?php if (get_the_archive_description()) : ?>
                        <div class="archive-cat-description">
                            <?php echo get_the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
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
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <h2><?php _e('Belum Ada Berita', 'berita'); ?></h2>
                    <p><?php _e('Belum ada artikel yang tersedia di arsip ini.', 'berita'); ?></p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php _e('Kembali ke Beranda', 'berita'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
