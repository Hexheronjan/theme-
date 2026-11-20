<?php
/**
 * Template Name: Halaman Tentang Kami
 * Description: Template khusus untuk halaman Tentang Kami Berita
 * 
 * @package Berita
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content page-tentang-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                    <div class="page-header-banner">
                        <?php berita_breadcrumb(); ?>
                        <h1 class="static-page-title"><?php _e('Tentang Kami', 'berita'); ?></h1>
                        <p class="static-page-subtitle"><?php _e('Mengabarkan Fakta, Menginspirasi Negeri', 'berita'); ?></p>
                    </div>

                    <div class="static-page-body">
                        <div class="about-hero-quote">
                            <p>"Kami mendedikasikan diri untuk menyajikan jurnalisme yang jujur, cepat, akurat, dan mencerdaskan kehidupan bangsa di tengah gelombang arus informasi digital."</p>
                        </div>

                        <div class="about-grid">
                            <div class="about-card">
                                <h3><?php _e('Siapa Kami?', 'berita'); ?></h3>
                                <p><strong>BERITA</strong> didirikan sebagai portal berita multimedia digital independen yang menjunjung tinggi kode etik jurnalistik dan standar verifikasi fakta yang ketat. Kami berfokus pada peliputan berita aktual seputar isu nasional, daerah, internasional, ekonomi, teknologi, olahraga, dan gaya hidup.</p>
                            </div>

                            <div class="about-card">
                                <h3><?php _e('Visi Kami', 'berita'); ?></h3>
                                <p>Menjadi pilar informasi digital terdepan di Indonesia yang dipercaya oleh publik, menjembatani aspirasi masyarakat, serta menjadi katalisator bagi kemajuan sosial, ekonomi, dan peradaban bangsa.</p>
                            </div>

                            <div class="about-card">
                                <h3><?php _e('Misi Kami', 'berita'); ?></h3>
                                <ul>
                                    <li>Menyajikan berita dan informasi dengan kecepatan, ketepatan, dan keberimbangan berprinsip cover both sides.</li>
                                    <li>Menjaga integritas jurnalistik bebas dari intervensi kelompok kepentingan apa pun.</li>
                                    <li>Memanfaatkan inovasi teknologi multimedia untuk pengalaman membaca berita terbaik di berbagai perangkat.</li>
                                </ul>
                            </div>

                            <div class="about-card">
                                <h3><?php _e('Nilai Inti', 'berita'); ?></h3>
                                <p>Integritas, Kecepatan, Akurasi Fakta, Keberimbangan, Empati Kemanusiaan, dan Inovasi Berkelanjutan.</p>
                            </div>
                        </div>

                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php if (get_the_content()) : ?>
                                <div class="page-body-content mt-4">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; endif; ?>
                    </div>
                </article>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
