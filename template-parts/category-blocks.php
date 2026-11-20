<?php
/**
 * Homepage category news blocks (Nasional – Teknologi)
 *
 * @package Berita
 * @since 1.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$category_blocks = array(
    array(
        'slug'   => 'nasional',
        'title'  => __('Nasional', 'berita'),
        'count'  => 4,
        'layout' => 'featured-left',
    ),
    array(
        'slug'   => 'daerah',
        'title'  => __('Daerah', 'berita'),
        'count'  => 3,
        'layout' => 'cards-row',
    ),
    array(
        'slug'   => 'internasional',
        'title'  => __('Internasional', 'berita'),
        'count'  => 4,
        'layout' => 'featured-top',
    ),
    array(
        'slug'   => 'ekonomi',
        'title'  => __('Ekonomi', 'berita'),
        'count'  => 3,
        'layout' => 'list-vertical',
    ),
    array(
        'slug'   => 'teknologi',
        'title'  => __('Teknologi', 'berita'),
        'count'  => 4,
        'layout' => 'grid-2x2',
    ),
);

if (!function_exists('berita_render_cat_block_meta')) {
    function berita_render_cat_block_meta() {
        ?>
        <div class="cat-block-meta">
            <span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo esc_html(get_the_date()); ?>
            </span>
            <span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <?php echo esc_html(berita_get_views()); ?>
            </span>
        </div>
        <?php
    }
}
?>

<div class="category-news-blocks">
    <?php foreach ($category_blocks as $block) :
        $term = get_category_by_slug($block['slug']);
        $cat_link = $term ? get_category_link($term->term_id) : home_url('/category/' . $block['slug'] . '/');

        $q = new WP_Query(array(
            'posts_per_page'      => (int) $block['count'],
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'category_name'       => $block['slug'],
        ));

        if (!$q->have_posts()) {
            continue;
        }

        $posts = $q->posts;
        $layout = $block['layout'];
        ?>
        <section class="cat-news-block cat-news-<?php echo esc_attr($layout); ?>" aria-labelledby="cat-block-<?php echo esc_attr($block['slug']); ?>">
            <div class="section-title-row">
                <h2 class="section-heading" id="cat-block-<?php echo esc_attr($block['slug']); ?>">
                    <?php echo esc_html($block['title']); ?>
                </h2>
                <a href="<?php echo esc_url($cat_link); ?>" class="view-all-link">
                    <?php _e('Lihat Semua', 'berita'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>

            <?php if ($layout === 'featured-left') :
                $main = $posts[0];
                $rest = array_slice($posts, 1);
                ?>
                <div class="cat-block-split">
                    <?php
                    $post = $main;
                    setup_postdata($post);
                    ?>
                    <article class="cat-block-featured">
                        <a href="<?php the_permalink(); ?>" class="cat-block-featured-thumb" tabindex="-1">
                            <?php berita_display_post_thumbnail('berita-hero'); ?>
                        </a>
                        <h3 class="cat-block-featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="cat-block-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
                        <?php berita_render_cat_block_meta(); ?>
                    </article>
                    <div class="cat-block-side-list">
                        <?php foreach ($rest as $side_post) :
                            $post = $side_post;
                            setup_postdata($post);
                            ?>
                            <article class="cat-block-row">
                                <a href="<?php the_permalink(); ?>" class="cat-block-row-thumb" tabindex="-1">
                                    <?php berita_display_post_thumbnail('berita-thumb-sm'); ?>
                                </a>
                                <div>
                                    <h3 class="cat-block-row-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php berita_render_cat_block_meta(); ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($layout === 'cards-row') : ?>
                <div class="cat-block-cards-row">
                    <?php foreach ($posts as $card_post) :
                        $post = $card_post;
                        setup_postdata($post);
                        ?>
                        <article class="cat-block-vcard">
                            <a href="<?php the_permalink(); ?>" class="cat-block-vcard-thumb" tabindex="-1">
                                <?php berita_display_post_thumbnail('berita-card'); ?>
                            </a>
                            <h3 class="cat-block-vcard-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php berita_render_cat_block_meta(); ?>
                        </article>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($layout === 'featured-top') :
                $main = $posts[0];
                $rest = array_slice($posts, 1);
                $post = $main;
                setup_postdata($post);
                ?>
                <article class="cat-block-wide">
                    <a href="<?php the_permalink(); ?>" class="cat-block-wide-thumb" tabindex="-1">
                        <?php berita_display_post_thumbnail('berita-hero'); ?>
                    </a>
                    <div class="cat-block-wide-body">
                        <h3 class="cat-block-featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="cat-block-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
                        <?php berita_render_cat_block_meta(); ?>
                    </div>
                </article>
                <div class="cat-block-cards-row cat-block-cards-row-sm">
                    <?php foreach ($rest as $card_post) :
                        $post = $card_post;
                        setup_postdata($post);
                        ?>
                        <article class="cat-block-vcard">
                            <a href="<?php the_permalink(); ?>" class="cat-block-vcard-thumb" tabindex="-1">
                                <?php berita_display_post_thumbnail('berita-card'); ?>
                            </a>
                            <h3 class="cat-block-vcard-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php berita_render_cat_block_meta(); ?>
                        </article>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($layout === 'list-vertical') : ?>
                <div class="cat-block-stack">
                    <?php foreach ($posts as $list_post) :
                        $post = $list_post;
                        setup_postdata($post);
                        ?>
                        <article class="cat-block-row cat-block-row-lg">
                            <a href="<?php the_permalink(); ?>" class="cat-block-row-thumb" tabindex="-1">
                                <?php berita_display_post_thumbnail('berita-card'); ?>
                            </a>
                            <div>
                                <h3 class="cat-block-row-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="cat-block-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                                <?php berita_render_cat_block_meta(); ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>
                <div class="cat-block-grid">
                    <?php foreach ($posts as $grid_post) :
                        $post = $grid_post;
                        setup_postdata($post);
                        ?>
                        <article class="cat-block-vcard">
                            <a href="<?php the_permalink(); ?>" class="cat-block-vcard-thumb" tabindex="-1">
                                <?php berita_display_post_thumbnail('berita-card'); ?>
                            </a>
                            <h3 class="cat-block-vcard-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php berita_render_cat_block_meta(); ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
        wp_reset_postdata();
    endforeach; ?>
</div>
