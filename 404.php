<?php
/**
 * 404 Error Template
 * 
 * @package Berita
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <div class="error-404">
                    <div class="error-404-content">
                        <h1 class="error-404-title">404</h1>
                        <h2 class="error-404-subtitle"><?php _e('Halaman Tidak Ditemukan', 'berita'); ?></h2>
                        <p class="error-404-message">
                            <?php _e('Maaf, halaman yang Anda cari tidak ditemukan. Mungkin halaman telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.', 'berita'); ?>
                        </p>
                        
                        <div class="error-404-actions">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <?php _e('Kembali ke Beranda', 'berita'); ?>
                            </a>
                            
                            <div class="error-404-search">
                                <h3><?php _e('Cari Berita', 'berita'); ?></h3>
                                <?php get_search_form(); ?>
                            </div>
                        </div>

                        <div class="error-404-links">
                            <h3><?php _e('Atau Kunjungi', 'berita'); ?></h3>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Beranda', 'berita'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/tentang-kami')); ?>"><?php _e('Tentang Kami', 'berita'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/redaksi')); ?>"><?php _e('Redaksi', 'berita'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/kontak')); ?>"><?php _e('Kontak', 'berita'); ?></a></li>
                            </ul>
                        </div>

                        <div class="error-404-popular">
                            <h3><?php _e('Berita Terpopuler', 'berita'); ?></h3>
                            <?php
                            $popular_args = array(
                                'posts_per_page' => 5,
                                'orderby'        => 'comment_count',
                                'order'          => 'DESC',
                                'post_status'    => 'publish',
                            );
                            $popular_query = new WP_Query($popular_args);

                            if ($popular_query->have_posts()) :
                                echo '<ul class="popular-404-list">';
                                while ($popular_query->have_posts()) : $popular_query->the_post();
                                    ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </li>
                                    <?php
                                endwhile;
                                echo '</ul>';
                                wp_reset_postdata();
                            else :
                                ?>
                                <p><?php _e('Belum ada berita.', 'berita'); ?></p>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
