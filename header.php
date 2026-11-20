<?php
/**
 * Header Template
 * 
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <span class="current-date">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?php echo wp_date('l, j F Y'); ?>
            </span>
            <span class="top-bar-divider">•</span>
            <span class="weather-widget">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                28°C Jakarta
            </span>
        </div>
        <div class="top-bar-right">
            <nav class="top-nav" aria-label="<?php esc_attr_e('Menu Atas', 'berita'); ?>">
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/tentang-kami/')); ?>"><?php _e('Tentang Kami', 'berita'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/redaksi/')); ?>"><?php _e('Redaksi', 'berita'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/pedoman-media/')); ?>"><?php _e('Pedoman Media', 'berita'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/iklan/')); ?>"><?php _e('Iklan', 'berita'); ?></a></li>
                </ul>
            </nav>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19.1c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.43zM9.75 15.02V8.48l5.75 3.27-5.75 3.27z"/></svg>
                </a>
                <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 3 15.68a6.34 6.34 0 0 0 10.86 4.47 6.27 6.27 0 0 0 1.94-4.54V8.41a8.28 8.28 0 0 0 4.79 1.5V6.69z"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo-wrap" rel="home">
                        <div class="brand-symbol">
                            <span class="symbol-red"></span>
                            <span class="symbol-blue"></span>
                        </div>
                        <div class="brand-text">
                            <span class="brand-name">BERITA</span>
                            <span class="brand-tagline"><?php _e('Mengabarkan Fakta, Menginspirasi Negeri', 'berita'); ?></span>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <div class="header-banner">
                <?php
                $custom_banner_image = get_theme_mod('header_banner_image');
                $custom_banner_url = get_theme_mod('header_banner_url', home_url('/iklan/'));
                if ($custom_banner_image) :
                ?>
                    <a href="<?php echo esc_url($custom_banner_url); ?>" class="header-banner-link" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url($custom_banner_image); ?>" alt="<?php esc_attr_e('Banner Promosi', 'berita'); ?>">
                    </a>
                <?php else : ?>
                    <div class="promo-header-banner">
                        <div class="promo-banner-backdrop"></div>
                        <div class="promo-banner-content">
                            <div class="promo-banner-text">
                                <strong class="promo-title"><?php _e('Pasang Iklan Anda di Sini', 'berita'); ?></strong>
                                <span class="promo-sub"><?php _e('Jangkau jutaan pembaca setiap hari', 'berita'); ?></span>
                            </div>
                            <a href="<?php echo esc_url(home_url('/iklan/')); ?>" class="promo-btn">
                                <?php _e('Hubungi Kami', 'berita'); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<!-- Main Navigation Bar -->
<nav class="main-nav" aria-label="<?php esc_attr_e('Navigasi Utama', 'berita'); ?>">
    <div class="container">
        <div class="nav-wrapper">
            <button class="hamburger" aria-label="<?php esc_attr_e('Buka Menu Navigasi', 'berita'); ?>" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu">
                <li class="menu-item <?php echo is_front_page() ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Beranda', 'berita'); ?></a>
                </li>
                <?php
                $primary_cats = array(
                    'Nasional', 'Daerah', 'Internasional', 'Ekonomi',
                    'Olahraga', 'Teknologi', 'Otomotif', 'Gaya Hidup',
                    'Hiburan', 'Pendidikan'
                );
                foreach ($primary_cats as $cat_title) {
                    $slug = sanitize_title($cat_title);
                    $term = get_category_by_slug($slug);
                    $link = $term ? get_category_link($term->term_id) : home_url('/category/' . $slug . '/');
                    $is_active = (is_category($slug) || (is_category() && get_queried_object() && get_queried_object()->slug === $slug));
                    ?>
                    <li class="menu-item <?php echo $is_active ? 'current-menu-item' : ''; ?>">
                        <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($cat_title); ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>

            <div class="nav-search">
                <button class="search-toggle" aria-label="<?php esc_attr_e('Buka Pencarian', 'berita'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Pencarian Berita', 'berita'); ?>">
    <div class="container">
        <div class="search-form-wrapper">
            <button class="search-close" aria-label="<?php esc_attr_e('Tutup Pencarian', 'berita'); ?>">&times;</button>
            <div class="search-overlay-inner">
                <h3 class="search-overlay-title"><?php _e('Cari Berita & Informasi', 'berita'); ?></h3>
                <?php get_search_form(); ?>
                <div class="quick-search-tags">
                    <span><?php _e('Pencarian Populer:', 'berita'); ?></span>
                    <a href="<?php echo esc_url(home_url('/?s=Presiden')); ?>">Presiden</a>
                    <a href="<?php echo esc_url(home_url('/?s=IKN')); ?>">IKN</a>
                    <a href="<?php echo esc_url(home_url('/?s=Ekonomi')); ?>">Ekonomi</a>
                    <a href="<?php echo esc_url(home_url('/?s=Timnas')); ?>">Timnas</a>
                </div>
            </div>
        </div>
    </div>
</div>
