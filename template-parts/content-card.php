<?php
/**
 * Content Card Template Part
 * 
 * @package Berita
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-card compact'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('berita-thumbnail'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-content">
        <div class="post-meta">
            <span class="post-category">
                <?php the_category(', '); ?>
            </span>
            <span class="post-date">
                <?php echo get_the_date(); ?>
            </span>
        </div>

        <h3 class="post-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php if (function_exists('berita_get_views')) : ?>
            <span class="post-views">
                <?php echo berita_get_views(); ?> <?php _e('views', 'berita'); ?>
            </span>
        <?php endif; ?>
    </div>
</article>
