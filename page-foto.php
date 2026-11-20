<?php
/**
 * Foto gallery archive
 *
 * @package Berita
 * @since 1.5.2
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$foto_query = new WP_Query(array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 12,
    'paged'               => $paged,
    'ignore_sticky_posts' => 1,
    'meta_query'          => array(
        array(
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
));
?>

<div class="main-content category-archive-layout">
    <div class="container">
        <div class="archive-header-card">
            <?php berita_breadcrumb(); ?>
            <div class="archive-title-flex">
                <div class="archive-title-text">
                    <h1 class="archive-main-title"><?php _e('Foto', 'berita'); ?></h1>
                    <div class="archive-cat-description">
                        <?php _e('Galeri foto pilihan dari liputan terbaru.', 'berita'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="archive-content-block">
            <?php if ($foto_query->have_posts()) : ?>
                <div class="foto-archive-grid">
                    <?php while ($foto_query->have_posts()) : $foto_query->the_post();
                        $cats = get_the_category();
                        $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('foto-archive-card'); ?>>
                            <a href="<?php the_permalink(); ?>" class="foto-archive-link">
                                <div class="foto-archive-thumb">
                                    <?php berita_display_post_thumbnail('berita-card'); ?>
                                    <span class="foto-archive-zoom">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                    </span>
                                </div>
                                <div class="foto-archive-body">
                                    <span class="archive-card-cat"><?php echo esc_html(strtoupper($cat_name)); ?></span>
                                    <h2 class="foto-archive-title"><?php the_title(); ?></h2>
                                    <div class="archive-card-meta">
                                        <span class="meta-item"><?php echo esc_html(get_the_date()); ?></span>
                                        <span class="meta-item"><?php echo esc_html(berita_get_views()); ?> views</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination-wrapper">
                    <?php
                    echo paginate_links(array(
                        'total'     => (int) $foto_query->max_num_pages,
                        'current'   => $paged,
                        'type'      => 'plain',
                        'prev_text' => __('&laquo; Sebelumnya', 'berita'),
                        'next_text' => __('Berikutnya &raquo;', 'berita'),
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div class="empty-archive-box">
                    <h2><?php _e('Belum Ada Foto', 'berita'); ?></h2>
                    <p><?php _e('Belum ada artikel dengan gambar unggulan. Upload Gambar Unggulan pada pos, lalu foto akan tampil di sini.', 'berita'); ?></p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php _e('Kembali ke Beranda', 'berita'); ?></a>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>

<?php
get_footer();
