<?php
/**
 * Page Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content general-page-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                        <div class="page-header-banner">
                            <?php berita_breadcrumb(); ?>
                            <h1 class="static-page-title">
                                <?php the_title(); ?>
                            </h1>
                        </div>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="page-featured-media">
                                <?php the_post_thumbnail('berita-hero'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="static-page-body page-body-content">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">',
                            'after'  => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        ));
                        ?>
                    </article>
                <?php endwhile; ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
