<?php
/**
 * Template Name: Halaman Redaksi
 * Description: Template khusus untuk susunan redaksi Berita
 * 
 * @package Berita
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content page-redaksi-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                    <div class="page-header-banner">
                        <?php berita_breadcrumb(); ?>
                        <h1 class="static-page-title"><?php _e('Susunan Redaksi', 'berita'); ?></h1>
                        <p class="static-page-subtitle"><?php _e('Struktur Manajemen, Redaksi, dan Tim Jurnalistik Portal BERITA', 'berita'); ?></p>
                    </div>

                    <div class="redaksi-grid">
                        <div class="redaksi-section">
                            <h2 class="redaksi-section-title"><?php _e('Dewan Pembina & Penasihat', 'berita'); ?></h2>
                            <div class="redaksi-card-group">
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Ketua Dewan Penasihat', 'berita'); ?></span>
                                    <strong class="person-name">Prof. Dr. Hendra Gunawan, S.H., M.Hum.</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Anggota Dewan Pakar', 'berita'); ?></span>
                                    <strong class="person-name">Siti Fatimah, S.H., LL.M.</strong>
                                </div>
                            </div>
                        </div>

                        <div class="redaksi-section">
                            <h2 class="redaksi-section-title"><?php _e('Pimpinan & Manajemen', 'berita'); ?></h2>
                            <div class="redaksi-card-group">
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Pemimpin Umum / Direktur Utama', 'berita'); ?></span>
                                    <strong class="person-name">Budi Santoso, S.Sos., M.M.</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Pemimpin Redaksi / Penanggung Jawab', 'berita'); ?></span>
                                    <strong class="person-name">Ahmad Pratama, M.I.Kom.</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Wakil Pemimpin Redaksi', 'berita'); ?></span>
                                    <strong class="person-name">Dian Anggraini, S.I.Kom.</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Pelaksana', 'berita'); ?></span>
                                    <strong class="person-name">Rizky Ramadhan, S.Hum.</strong>
                                </div>
                            </div>
                        </div>

                        <div class="redaksi-section">
                            <h2 class="redaksi-section-title"><?php _e('Redaktur Bidang & Desk', 'berita'); ?></h2>
                            <div class="redaksi-card-group">
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Nasional & Politik', 'berita'); ?></span>
                                    <strong class="person-name">Bambang Wijaya</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Ekonomi & Bisnis', 'berita'); ?></span>
                                    <strong class="person-name">Ratna Kusuma Dewi</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Teknologi & Sains', 'berita'); ?></span>
                                    <strong class="person-name">Fajar Maulana</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Olahraga & Otomotif', 'berita'); ?></span>
                                    <strong class="person-name">Kevin Pratama</strong>
                                </div>
                                <div class="redaksi-person">
                                    <span class="person-role"><?php _e('Redaktur Gaya Hidup & Hiburan', 'berita'); ?></span>
                                    <strong class="person-name">Anisa Nuraini</strong>
                                </div>
                            </div>
                        </div>

                        <div class="redaksi-section">
                            <h2 class="redaksi-section-title"><?php _e('Informasi Kontak & Alamat Kantor', 'berita'); ?></h2>
                            <div class="redaksi-contact-box">
                                <div class="contact-item">
                                    <strong><?php _e('Alamat Redaksi:', 'berita'); ?></strong>
                                    <p>Gedung Graha Berita Mandiri Lantai 5, Jl. Jend. Sudirman Kav. 88, Jakarta Pusat, DKI Jakarta 10220</p>
                                </div>
                                <div class="contact-item">
                                    <strong><?php _e('Telepon Redaksi:', 'berita'); ?></strong>
                                    <p>(021) 555-0199 / (021) 555-0198</p>
                                </div>
                                <div class="contact-item">
                                    <strong><?php _e('Surat Elektronik (Email):', 'berita'); ?></strong>
                                    <p>redaksi@berita.test | info@berita.test</p>
                                </div>
                                <div class="contact-item">
                                    <strong><?php _e('Pengaduan Konten & Hak Jawab:', 'berita'); ?></strong>
                                    <p>pengaduan@berita.test</p>
                                </div>
                            </div>
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
