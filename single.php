<?php
/**
 * Single Post Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content single-page-layout">
    <div class="container">
        <div class="single-center-container">
            <main class="single-main-column">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content-single');
                endwhile;
                ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
