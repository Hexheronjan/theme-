<?php
/**
 * Template Name: Halaman Informasi Iklan
 * Description: Template khusus untuk info tarif dan penawaran iklan Berita
 * 
 * @package Berita
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content page-iklan-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                    <div class="page-header-banner">
                        <?php berita_breadcrumb(); ?>
                        <h1 class="static-page-title"><?php _e('Pasang Iklan Anda di Sini', 'berita'); ?></h1>
                        <p class="static-page-subtitle"><?php _e('Jangkau Jutaan Pembaca Potensial dan Pengambil Keputusan Setiap Hari', 'berita'); ?></p>
                    </div>

                    <div class="iklan-stats-banner">
                        <div class="stat-card">
                            <span class="stat-num">5.2M+</span>
                            <span class="stat-desc"><?php _e('Kunjungan Bulanan (Pageviews)', 'berita'); ?></span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-num">1.8M+</span>
                            <span class="stat-desc"><?php _e('Pembaca Aktif (Unique Visitors)', 'berita'); ?></span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-num">82%</span>
                            <span class="stat-desc"><?php _e('Akses Pembaca Mobile Digital', 'berita'); ?></span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-num">34</span>
                            <span class="stat-desc"><?php _e('Provinsi Jangkauan Seluruh Indonesia', 'berita'); ?></span>
                        </div>
                    </div>

                    <div class="iklan-packages-grid">
                        <div class="package-card">
                            <div class="package-header">
                                <h3><?php _e('Display Banner Header', 'berita'); ?></h3>
                                <span class="badge-tag"><?php _e('High Visibility', 'berita'); ?></span>
                            </div>
                            <p class="package-desc"><?php _e('Posisi terbaik di bagian atas halaman (Header Leaderboard 728x90) terlihat langsung saat pertama kali halaman dimuat.', 'berita'); ?></p>
                            <ul class="package-features">
                                <li>Tampil di Homepage & Seluruh Halaman Artikel</li>
                                <li>Responsive Desktop & Mobile Friendly</li>
                                <li>Laporan Impresi & CTR Mingguan</li>
                            </ul>
                        </div>

                        <div class="package-card featured">
                            <div class="package-header">
                                <h3><?php _e('Advertorial & Native Article', 'berita'); ?></h3>
                                <span class="badge-tag red"><?php _e('Paling Populer', 'berita'); ?></span>
                            </div>
                            <p class="package-desc"><?php _e('Artikel ulasan khusus profil brand, peluncuran produk, event, atau siaran pers (press release) yang ditulis oleh tim jurnalis berpengalaman.', 'berita'); ?></p>
                            <ul class="package-features">
                                <li>Permanen & Diindeks Google News / Search</li>
                                <li>Termasuk 1 DoFollow Link & 3 Foto HD</li>
                                <li>Dipromosikan di Breaking News & Medsos</li>
                            </ul>
                        </div>

                        <div class="package-card">
                            <div class="package-header">
                                <h3><?php _e('Middle Banner & In-Article', 'berita'); ?></h3>
                                <span class="badge-tag"><?php _e('High Engagement', 'berita'); ?></span>
                            </div>
                            <p class="package-desc"><?php _e('Banner promosi di tengah beranda portal dan di dalam paragraf isi artikel saat pembaca sedang aktif menyimak.', 'berita'); ?></p>
                            <ul class="package-features">
                                <li>Tingkat keterbacaan (Viewability) di atas 75%</li>
                                <li>Dukungan Banner Gambar Animasi / Statis</li>
                                <li>Targeting Kategori Sesuai Niche Bisnis</li>
                            </ul>
                        </div>
                    </div>

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php if (get_the_content()) : ?>
                            <div class="page-body-content mt-4">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; endif; ?>
                </article>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
