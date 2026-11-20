<?php
/**
 * Template Name: Halaman Kontak
 * Description: Template halaman kontak Berita
 * 
 * @package Berita
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content page-kontak-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                    <div class="page-header-banner">
                        <?php berita_breadcrumb(); ?>
                        <h1 class="static-page-title"><?php _e('Hubungi Kami', 'berita'); ?></h1>
                        <p class="static-page-subtitle"><?php _e('Sampaikan Masukan, Pertanyaan, Liputan, atau Kerjasama', 'berita'); ?></p>
                    </div>

                    <div class="kontak-layout-grid">
                        <div class="kontak-info-column">
                            <div class="kontak-info-card">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div class="info-text">
                                    <h3><?php _e('Kantor Pusat Redaksi', 'berita'); ?></h3>
                                    <p>Gedung Graha Berita Mandiri Lantai 5, Jl. Jend. Sudirman Kav. 88, Jakarta Pusat, DKI Jakarta 10220</p>
                                </div>
                            </div>

                            <div class="kontak-info-card">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div class="info-text">
                                    <h3><?php _e('Telepon & Layanan Hotline', 'berita'); ?></h3>
                                    <p>Telepon: (021) 555-0199<br>WhatsApp Redaksi: 0811-2233-4455</p>
                                </div>
                            </div>

                            <div class="kontak-info-card">
                                <div class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <div class="info-text">
                                    <h3><?php _e('Email Resmi', 'berita'); ?></h3>
                                    <p>Umum: info@berita.test<br>Redaksi: redaksi@berita.test<br>Iklan: iklan@berita.test</p>
                                </div>
                            </div>
                        </div>

                        <div class="kontak-form-column">
                            <div class="kontak-form-card">
                                <h3><?php _e('Kirim Pesan / Siaran Pers', 'berita'); ?></h3>
                                <form class="kontak-form" onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah kami terima.');">
                                    <div class="form-group">
                                        <label for="contact-name"><?php _e('Nama Lengkap *', 'berita'); ?></label>
                                        <input type="text" id="contact-name" class="form-control" required placeholder="Masukkan nama Anda">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-email"><?php _e('Alamat Email *', 'berita'); ?></label>
                                        <input type="email" id="contact-email" class="form-control" required placeholder="nama@email.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-subject"><?php _e('Subjek / Keperluan *', 'berita'); ?></label>
                                        <select id="contact-subject" class="form-control" required>
                                            <option value="liputan"><?php _e('Permohonan Liputan / Press Release', 'berita'); ?></option>
                                            <option value="iklan"><?php _e('Kerjasama Iklan & Promosi', 'berita'); ?></option>
                                            <option value="hak-jawab"><?php _e('Hak Jawab & Koreksi Berita', 'berita'); ?></option>
                                            <option value="lainnya"><?php _e('Lain-lain', 'berita'); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-msg"><?php _e('Pesan atau Keterangan *', 'berita'); ?></label>
                                        <textarea id="contact-msg" class="form-control" rows="5" required placeholder="Tuliskan pesan Anda secara rinci..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary submit-btn"><?php _e('Kirim Pesan', 'berita'); ?></button>
                                </form>
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
