<?php
/**
 * Template Name: Halaman Pedoman Media Siber
 * Description: Pedoman Pemberitaan Media Siber Berita
 * 
 * @package Berita
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="main-content page-pedoman-wrapper">
    <div class="container">
        <div class="content-wrapper">
            <main class="main-column full-width">
                <article id="post-<?php the_ID(); ?>" <?php post_class('static-page-card'); ?>>
                    <div class="page-header-banner">
                        <?php berita_breadcrumb(); ?>
                        <h1 class="static-page-title"><?php _e('Pedoman Pemberitaan Media Siber', 'berita'); ?></h1>
                        <p class="static-page-subtitle"><?php _e('Standar Jurnalistik dan Kepatuhan Etika Dewan Pers', 'berita'); ?></p>
                    </div>

                    <div class="pedoman-content static-page-body">
                        <div class="pedoman-point">
                            <h3>1. Ruang Lingkup</h3>
                            <p>Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers. Isi Buatan Pengguna (User Generated Content) adalah segala isi yang dibuat dan atau dipublikasikan oleh pengguna media siber.</p>
                        </div>

                        <div class="pedoman-point">
                            <h3>2. Verifikasi dan Keberimbangan Berita</h3>
                            <p>Setiap berita harus melalui proses verifikasi. Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama atau secepat-cepatnya pada kesempatan pertama untuk memenuhi prinsip akurasi dan keberimbangan.</p>
                        </div>

                        <div class="pedoman-point">
                            <h3>3. Isi Buatan Pengguna (User Generated Content)</h3>
                            <p>Media siber wajib mencantumkan syarat dan ketentuan mengenai Isi Buatan Pengguna yang tidak bertentangan dengan Undang-Undang No. 40 Tahun 1999 tentang Pers dan Kode Etik Jurnalistik. Media siber wajib menyediakan mekanisme ralat dan pencabutan atas komentar atau konten kiriman publik yang melanggar hukum.</p>
                        </div>

                        <div class="pedoman-point">
                            <h3>4. Ralat, Koreksi, dan Hak Jawab</h3>
                            <p>Ralat, koreksi, dan hak jawab mengacu pada Undang-Undang Pers, Kode Etik Jurnalistik, dan Pedoman Hak Jawab yang ditetapkan Dewan Pers. Media siber wajib menautkan ralat atau hak jawab pada berita terkait secara transparan.</p>
                        </div>

                        <div class="pedoman-point">
                            <h3>5. Pencabutan Berita</h3>
                            <p>Berita yang sudah dipublikasikan tidak dapat dicabut karena alasan penyensoran dari pihak luar redaksi, kecuali terkait masalah SARA, kesusilaan, masa depan anak, pengalaman traumatik korban atau pertimbangan khusus lain yang ditetapkan Dewan Pers.</p>
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
