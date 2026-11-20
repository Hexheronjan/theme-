<?php
/**
 * Front Page Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="homepage-main-content">
    <div class="container">
        <!-- 1. Sorotan -->
        <?php get_template_part('template-parts/sorotan'); ?>

        <!-- 2. Breaking News -->
        <?php get_template_part('template-parts/breaking-news'); ?>

        <!-- 2. Hero News Section -->
        <?php get_template_part('template-parts/hero-news'); ?>

        <!-- 3. Popular Categories Section -->
        <section class="popular-cats-section">
            <div class="section-title-row">
                <h2 class="section-heading"><?php _e('Kategori Populer', 'berita'); ?></h2>
                <a href="<?php echo esc_url(home_url('/kategori/')); ?>" class="view-all-link">
                    <?php _e('Lihat Semua', 'berita'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>

            <div class="popular-cats-grid">
                <?php
                $popular_category_slugs = array(
                    'nasional'      => 'Nasional',
                    'daerah'        => 'Daerah',
                    'internasional' => 'Internasional',
                    'ekonomi'       => 'Ekonomi',
                    'teknologi'     => 'Teknologi',
                    'olahraga'      => 'Olahraga',
                    'otomotif'      => 'Otomotif',
                    'gaya-hidup'    => 'Gaya Hidup',
                    'hiburan'       => 'Hiburan',
                    'pendidikan'    => 'Pendidikan',
                );

                foreach ($popular_category_slugs as $c_slug => $c_name) {
                    $c_term = get_category_by_slug($c_slug);
                    $c_link = $c_term ? get_category_link($c_term->term_id) : home_url('/category/' . $c_slug . '/');
                    ?>
                    <a href="<?php echo esc_url($c_link); ?>" class="pop-cat-card">
                        <div class="pop-cat-icon">
                            <?php echo berita_get_category_icon($c_slug); ?>
                        </div>
                        <span class="pop-cat-label"><?php echo esc_html($c_name); ?></span>
                    </a>
                    <?php
                }
                ?>
            </div>
        </section>

        <!-- 4. Berita Terbaru with Real Tabs -->
        <section class="latest-news-block">
            <div class="section-title-row latest-header-row">
                <h2 class="section-heading"><?php _e('Berita Terbaru', 'berita'); ?></h2>
                <div class="latest-tabs" role="tablist">
                    <button type="button" class="tab-btn active" data-tab="tab-terbaru" role="tab" aria-selected="true"><?php _e('Terbaru', 'berita'); ?></button>
                    <button type="button" class="tab-btn" data-tab="tab-populer" role="tab" aria-selected="false"><?php _e('Populer', 'berita'); ?></button>
                    <button type="button" class="tab-btn" data-tab="tab-komentar" role="tab" aria-selected="false"><?php _e('Komentar', 'berita'); ?></button>
                </div>
            </div>

            <!-- Tab 1: Terbaru (Order by Date DESC) -->
            <div id="tab-terbaru" class="tab-pane active" role="tabpanel">
                <div class="latest-grid-2col">
                    <?php
                    $q_terbaru = new WP_Query(array(
                        'posts_per_page'      => 6,
                        'post_status'         => 'publish',
                        'orderby'             => 'date',
                        'order'               => 'DESC',
                        'ignore_sticky_posts' => 1,
                    ));
                    if ($q_terbaru->have_posts()) :
                        while ($q_terbaru->have_posts()) : $q_terbaru->the_post();
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                            $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
                            ?>
                            <article class="latest-card-row">
                                <div class="latest-card-thumb">
                                    <a href="<?php the_permalink(); ?>" tabindex="-1">
                                        <?php berita_display_post_thumbnail('berita-thumb-sm'); ?>
                                    </a>
                                </div>
                                <div class="latest-card-content">
                                    <div class="latest-card-cat">
                                        <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html(strtoupper($cat_name)); ?></a>
                                    </div>
                                    <h3 class="latest-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="latest-card-meta">
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            <?php echo berita_get_views(); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <p class="no-content-msg"><?php _e('Belum ada berita terbaru.', 'berita'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tab 2: Populer (Order by Views) -->
            <div id="tab-populer" class="tab-pane" role="tabpanel">
                <div class="latest-grid-2col">
                    <?php
                    $q_populer = new WP_Query(array(
                        'posts_per_page'      => 6,
                        'post_status'         => 'publish',
                        'meta_key'            => 'post_views',
                        'orderby'             => 'meta_value_num',
                        'order'               => 'DESC',
                        'ignore_sticky_posts' => 1,
                    ));
                    if ($q_populer->have_posts()) :
                        while ($q_populer->have_posts()) : $q_populer->the_post();
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                            $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
                            ?>
                            <article class="latest-card-row">
                                <div class="latest-card-thumb">
                                    <a href="<?php the_permalink(); ?>" tabindex="-1">
                                        <?php berita_display_post_thumbnail('berita-thumb-sm'); ?>
                                    </a>
                                </div>
                                <div class="latest-card-content">
                                    <div class="latest-card-cat">
                                        <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html(strtoupper($cat_name)); ?></a>
                                    </div>
                                    <h3 class="latest-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="latest-card-meta">
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            <?php echo berita_get_views(); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <p class="no-content-msg"><?php _e('Belum ada berita populer.', 'berita'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tab 3: Komentar (Order by Comment Count) -->
            <div id="tab-komentar" class="tab-pane" role="tabpanel">
                <div class="latest-grid-2col">
                    <?php
                    $q_komentar = new WP_Query(array(
                        'posts_per_page'      => 6,
                        'post_status'         => 'publish',
                        'orderby'             => 'comment_count',
                        'order'               => 'DESC',
                        'ignore_sticky_posts' => 1,
                    ));
                    if ($q_komentar->have_posts()) :
                        while ($q_komentar->have_posts()) : $q_komentar->the_post();
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                            $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/');
                            ?>
                            <article class="latest-card-row">
                                <div class="latest-card-thumb">
                                    <a href="<?php the_permalink(); ?>" tabindex="-1">
                                        <?php berita_display_post_thumbnail('berita-thumb-sm'); ?>
                                    </a>
                                </div>
                                <div class="latest-card-content">
                                    <div class="latest-card-cat">
                                        <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html(strtoupper($cat_name)); ?></a>
                                    </div>
                                    <h3 class="latest-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="latest-card-meta">
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        <span class="meta-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                            <?php comments_number('0 komentar', '1 komentar', '% komentar'); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <p class="no-content-msg"><?php _e('Belum ada komentar berita.', 'berita'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- 5. Middle Advertisement Banner -->
        <section class="middle-banner-section" aria-label="<?php esc_attr_e('Banner Promosi', 'berita'); ?>">
            <div class="middle-banner-box">
                <div class="middle-banner-skyline"></div>
                <div class="middle-banner-left">
                    <div class="middle-banner-brand">
                        <div class="brand-symbol">
                            <span class="symbol-red"></span>
                            <span class="symbol-blue"></span>
                        </div>
                        <span class="brand-name">BERITA</span>
                    </div>
                    <h3 class="middle-banner-title"><?php _e('Selalu Update, Selalu Terdepan', 'berita'); ?></h3>
                    <p class="middle-banner-subtitle"><?php _e('Dapatkan informasi terbaru dan terpercaya hanya di Berita.', 'berita'); ?></p>
                </div>

                <div class="middle-banner-right">
                    <div class="phone-mockup">
                        <div class="phone-mockup-screen">
                            <div class="phone-app-header">
                                <span class="phone-app-logo">BERITA</span>
                            </div>
                            <div class="phone-app-feed">
                                <div class="phone-feed-item"></div>
                                <div class="phone-feed-item"></div>
                                <div class="phone-feed-item"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. Video Terpopuler & Foto Pilihan (2 Columns) -->
        <section class="multimedia-section">
            <div class="multimedia-grid">
                <!-- Left: Video Terpopuler -->
                <div class="multimedia-col video-col">
                    <div class="section-title-row">
                        <h2 class="section-heading"><?php _e('Video Terpopuler', 'berita'); ?></h2>
                    </div>

                    <div class="video-section-content">
                        <?php
                        $video_posts_query = new WP_Query(array(
                            'posts_per_page'      => 5,
                            'post_status'         => 'publish',
                            'orderby'             => 'date',
                            'order'               => 'DESC',
                            'ignore_sticky_posts' => 1,
                            'meta_query'          => array(
                                array(
                                    'key'     => 'berita_video_url',
                                    'compare' => 'EXISTS',
                                ),
                            ),
                        ));

                        if ($video_posts_query->have_posts()) :
                            $v_posts = $video_posts_query->posts;
                            $main_video = isset($v_posts[0]) ? $v_posts[0] : null;
                            $ranked_videos = array_slice($v_posts, 1, 4);
                        ?>
                            <!-- Main Large Video Preview -->
                            <?php if ($main_video) : 
                                $post = $main_video;
                                setup_postdata($post);
                            ?>
                                <?php
                                $main_video_url = berita_get_video_url($post->ID);
                                $main_youtube_id = berita_get_youtube_id($main_video_url);
                                ?>
                                <div class="main-video-featured"<?php echo $main_video_url ? ' data-video-url="' . esc_attr($main_video_url) . '"' : ''; ?><?php echo $main_youtube_id ? ' data-youtube-id="' . esc_attr($main_youtube_id) . '"' : ''; ?>>
                                    <div class="main-video-stage">
                                        <?php if ($main_video_url) : ?>
                                            <button type="button" class="main-video-thumb-link berita-video-trigger" aria-label="<?php esc_attr_e('Putar video', 'berita'); ?>">
                                                <?php berita_display_post_thumbnail('berita-hero'); ?>
                                                <div class="video-play-overlay">
                                                    <div class="play-icon-circle">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="main-video-player" aria-hidden="true"></div>
                                        <?php else : ?>
                                            <a href="<?php the_permalink(); ?>" class="main-video-thumb-link">
                                                <?php berita_display_post_thumbnail('berita-hero'); ?>
                                                <div class="video-play-overlay">
                                                    <div class="play-icon-circle">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>

                            <!-- Ranked Video List 1 to 4 -->
                            <div class="ranked-video-list">
                                <?php
                                $rank = 0;
                                foreach ($ranked_videos as $r_post) :
                                    $rank++;
                                    $post = $r_post;
                                    setup_postdata($post);
                                ?>
                                    <div class="ranked-video-item">
                                        <div class="rank-number"><?php echo $rank; ?></div>
                                        <div class="rank-info">
                                            <h4 class="rank-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <span class="rank-views">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                <?php echo berita_get_views(); ?> views
                                            </span>
                                        </div>
                                    </div>
                                <?php 
                                endforeach;
                                wp_reset_postdata(); 
                                ?>
                            </div>
                        <?php else : ?>
                            <p class="no-content-msg"><?php _e('Belum ada video.', 'berita'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Foto Pilihan -->
                <div class="multimedia-col photo-col">
                    <div class="section-title-row">
                        <h2 class="section-heading"><?php _e('Foto Pilihan', 'berita'); ?></h2>
                    </div>

                    <div class="photo-gallery-grid">
                        <?php
                        $photo_query = new WP_Query(array(
                            'posts_per_page'      => 4,
                            'post_status'         => 'publish',
                            'orderby'             => 'date',
                            'order'               => 'DESC',
                            'offset'              => 2,
                            'ignore_sticky_posts' => 1,
                        ));

                        if ($photo_query->have_posts()) :
                            while ($photo_query->have_posts()) : $photo_query->the_post();
                                ?>
                                <article class="photo-card-item">
                                    <a href="<?php the_permalink(); ?>" class="photo-card-link">
                                        <div class="photo-thumb-wrap">
                                            <?php berita_display_post_thumbnail('berita-card'); ?>
                                            <div class="photo-zoom-overlay">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <p class="no-content-msg"><?php _e('Belum ada galeri foto.', 'berita'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. Berita per kategori: Nasional – Teknologi -->
        <?php get_template_part('template-parts/category-blocks'); ?>
    </div>
</div>

<?php
get_footer();
