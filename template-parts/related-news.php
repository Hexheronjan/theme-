<?php
/**
 * Related News Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = get_the_category();
if ($categories) :
    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }

    $related_args = array(
        'posts_per_page'      => 4,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'post__not_in'        => array(get_the_ID()),
        'tax_query'           => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_ids,
            ),
        ),
        'ignore_sticky_posts' => 1,
    );
    $related_query = new WP_Query($related_args);

    if ($related_query->have_posts()) :
        ?>
        <section class="related-news-section" aria-label="<?php esc_attr_e('Berita Terkait', 'berita'); ?>">
            <div class="section-title-row">
                <h3 class="section-heading"><?php _e('Berita Terkait', 'berita'); ?></h3>
            </div>

            <div class="related-news-grid">
                <?php
                while ($related_query->have_posts()) : $related_query->the_post();
                    $cats = get_the_category();
                    $cat_name = !empty($cats) ? $cats[0]->name : __('Berita', 'berita');
                    ?>
                    <article class="related-news-card">
                        <div class="related-thumb-wrap">
                            <a href="<?php the_permalink(); ?>" tabindex="-1">
                                <?php berita_display_post_thumbnail('berita-thumb-sm'); ?>
                            </a>
                        </div>
                        <div class="related-content-wrap">
                            <span class="related-cat-label"><?php echo esc_html(strtoupper($cat_name)); ?></span>
                            <h4 class="related-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <span class="related-card-date">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <?php echo get_the_date(); ?>
                            </span>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php
    endif;
endif;
