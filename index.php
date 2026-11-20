<?php
/**
 * Main Index Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column">
                <?php if (have_posts()) : ?>
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-content">
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    <div class="post-meta">
                                        <span class="post-date"><?php echo get_the_date(); ?></span>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <p>Belum ada berita.</p>
                <?php endif; ?>
            </main>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
