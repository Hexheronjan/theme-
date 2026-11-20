<?php
/**
 * Berita Theme Functions
 *
 * @package Berita
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/sorotan.php';
require_once get_template_directory() . '/inc/demo-importer.php';

/**
 * Theme Setup
 */
function berita_theme_setup() {
    // Add title tag support
    add_theme_support('title-tag');
    
    // Add post thumbnails support
    add_theme_support('post-thumbnails');
    
    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Add HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Add automatic feed links
    add_theme_support('automatic-feed-links');
    
    // Add post formats support
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
    ));
    
    // Add editor style
    add_editor_style('assets/css/main.css');
    
    // Load text domain
    load_theme_textdomain('berita', get_template_directory() . '/languages');

    // Register custom image sizes
    add_image_size('berita-hero', 800, 450, true);
    add_image_size('berita-card', 400, 250, true);
    add_image_size('berita-thumb-sm', 160, 110, true);
    add_image_size('berita-thumbnail', 150, 100, true);
}
add_action('after_setup_theme', 'berita_theme_setup');

/**
 * Register Navigation Menus
 */
function berita_register_menus() {
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu', 'berita'),
        'footer_menu'  => __('Footer Menu', 'berita'),
        'top_menu'     => __('Top Bar Menu', 'berita'),
    ));
}
add_action('init', 'berita_register_menus');

/**
 * Register Sidebars
 */
function berita_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'berita'),
        'id'            => 'sidebar-main',
        'description'   => __('Main sidebar for blog and archive pages', 'berita'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'berita'),
        'id'            => 'sidebar-footer-1',
        'description'   => __('Footer widget area 1', 'berita'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'berita'),
        'id'            => 'sidebar-footer-2',
        'description'   => __('Footer widget area 2', 'berita'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget 3', 'berita'),
        'id'            => 'sidebar-footer-3',
        'description'   => __('Footer widget area 3', 'berita'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'berita_register_sidebars');

/**
 * Enqueue Scripts and Styles
 */
function berita_enqueue_scripts() {
    // Main CSS
    wp_enqueue_style('berita-style', get_stylesheet_uri(), array(), '1.5.1');
    wp_enqueue_style('berita-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.5.1');
    
    // Main JavaScript
    wp_enqueue_script('berita-main-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.5.0', true);

    if (is_front_page()) {
        wp_localize_script('berita-main-script', 'beritaSorotanConfig', array(
            'slideDuration' => 5000,
            'i18n'          => array(
                'readArticle' => __('Baca artikel...', 'berita'),
                'close'       => __('Tutup sorotan', 'berita'),
                'prev'        => __('Sorotan sebelumnya', 'berita'),
                'next'        => __('Sorotan berikutnya', 'berita'),
            ),
        ));
    }
    
    // Comments reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'berita_enqueue_scripts');

/**
 * Excerpt Settings
 */
function berita_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'berita_excerpt_length');

function berita_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'berita_excerpt_more');

/**
 * Pagination
 */
function berita_pagination() {
    global $wp_query;
    $total = isset($wp_query->max_num_pages) ? (int)$wp_query->max_num_pages : 1;

    if ($total <= 1) {
        return;
    }

    echo '<div class="pagination">';
    echo paginate_links(array(
        'type'      => 'plain',
        'prev_text' => __('&laquo; Sebelumnya', 'berita'),
        'next_text' => __('Berikutnya &raquo;', 'berita'),
        'mid_size'  => 2,
        'end_size'  => 1,
    ));
    echo '</div>';
}

/**
 * Category Link Helper
 */
function berita_get_category_link($category_id) {
    $link = get_category_link($category_id);
    return is_wp_error($link) ? home_url('/') : $link;
}

/**
 * One-time reset of fake seeded view counts
 */
function berita_migrate_to_real_views() {
    if (get_option('berita_real_views_v1') === 'yes') {
        return;
    }

    global $wpdb;
    $wpdb->delete($wpdb->postmeta, array('meta_key' => 'post_views'));
    update_option('berita_real_views_v1', 'yes');
}
add_action('after_setup_theme', 'berita_migrate_to_real_views');

/**
 * Views Counter & Formatter (real counts only)
 */
function berita_get_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$post_id) {
        return '0';
    }

    $views = get_post_meta($post_id, 'post_views', true);
    $views = ($views === '' || $views === false) ? 0 : (int) $views;

    if ($views >= 1000) {
        return number_format($views / 1000, 1, '.', '') . 'k';
    }

    return (string) $views;
}

/**
 * Track single post views
 */
function berita_track_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!$post_id || !is_singular('post')) {
        return;
    }

    $views = (int) get_post_meta($post_id, 'post_views', true);
    update_post_meta($post_id, 'post_views', $views + 1);
}

/**
 * Estimated reading time
 */
function berita_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $post = get_post($post_id);
    if (!$post) {
        return '3 menit baca';
    }
    $words = str_word_count(strip_tags($post->post_content));
    $minutes = ceil($words / 200);
    if ($minutes < 1) {
        $minutes = 2;
    }
    return $minutes . ' menit baca';
}

/**
 * Safe Post Thumbnail Helper (Avoids broken images)
 */
function berita_display_post_thumbnail($size = 'berita-card', $extra_class = '', $return = false) {
    if (has_post_thumbnail()) {
        $html = get_the_post_thumbnail(get_the_ID(), $size, array(
            'class' => trim('berita-thumb-img ' . $extra_class),
            'alt'   => the_title_attribute(array('echo' => false)),
            'loading' => 'lazy',
        ));
    } else {
        // Beautiful SVG fallback thumbnail with matching aspect ratio
        $cats = get_the_category();
        $cat_name = !empty($cats) ? esc_html($cats[0]->name) : 'BERITA';
        
        $gradients = array(
            array('#1e3c72', '#2a5298'),
            array('#0f2027', '#203a43'),
            array('#2c3e50', '#3498db'),
            array('#141e30', '#243b55'),
            array('#16222a', '#3a6073'),
        );
        $grad_idx = abs(crc32(get_the_title())) % count($gradients);
        $c1 = $gradients[$grad_idx][0];
        $c2 = $gradients[$grad_idx][1];

        $html = '<div class="berita-placeholder-img ' . esc_attr($extra_class) . '" style="background: linear-gradient(135deg, ' . $c1 . ' 0%, ' . $c2 . ' 100%); width: 100%; height: 100%; min-height: 80px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ffffff; text-align: center; padding: 10px; box-sizing: border-box;">';
        $html .= '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.85; margin-bottom: 6px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>';
        $html .= '<span style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: rgba(230,0,18,0.9); padding: 2px 7px; border-radius: 3px;">' . $cat_name . '</span>';
        $html .= '</div>';
    }

    if ($return) {
        return $html;
    }
    echo $html;
}

/**
 * Category SVG Icons
 */
function berita_get_category_icon($slug) {
    $slug = sanitize_title($slug);
    switch ($slug) {
        case 'nasional':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16"/><path d="M4 22V6l8-4 8 4v16"/><path d="M12 2v20"/><path d="M8 10h.01"/><path d="M16 10h.01"/><path d="M8 14h.01"/><path d="M16 14h.01"/></svg>';
        case 'daerah':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>';
        case 'internasional':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>';
        case 'ekonomi':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><path d="M3 20h18"/><polyline points="4 11 10 5 15 10 20 5"/></svg>';
        case 'teknologi':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>';
        case 'olahraga':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><circle cx="12" cy="14" r="2"/></svg>';
        case 'otomotif':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="7" width="22" height="10" rx="2"/><circle cx="6.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/><path d="M5 7l2-4h10l2 4"/></svg>';
        case 'gaya-hidup':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
        case 'hiburan':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>';
        case 'pendidikan':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>';
        case 'video':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>';
        case 'foto':
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>';
        default:
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>';
    }
}

/**
 * Breadcrumb
 */
function berita_breadcrumb() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumb" aria-label="' . esc_attr__('Breadcrumb', 'berita') . '">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . __('Beranda', 'berita') . '</a>';
        
        if (is_category()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            single_cat_title();
        } elseif (is_single()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            $cats = get_the_category();
            if (!empty($cats)) {
                echo '<a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a>';
                echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            }
            echo '<span class="breadcrumb-current">' . wp_trim_words(get_the_title(), 8) . '</span>';
        } elseif (is_page()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            echo '<span class="breadcrumb-current">' . get_the_title() . '</span>';
        } elseif (is_search()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            echo '<span class="breadcrumb-current">' . __('Hasil Pencarian', 'berita') . '</span>';
        } elseif (is_404()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            echo '<span class="breadcrumb-current">' . __('404 Error', 'berita') . '</span>';
        } elseif (is_archive()) {
            echo ' <span class="breadcrumb-sep">&raquo;</span> ';
            echo '<span class="breadcrumb-current">' . get_the_archive_title() . '</span>';
        }
        
        echo '</nav>';
    }
}

/**
 * Social Share Buttons
 */
function berita_social_share() {
    $url = esc_url(get_permalink());
    $title = urlencode(get_the_title());
    
    echo '<div class="social-share">';
    echo '<span class="social-share-label">' . __('Bagikan:', 'berita') . '</span>';
    echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url) . '" target="_blank" rel="noopener noreferrer" class="share-btn share-facebook" aria-label="Facebook">';
    echo '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> Facebook';
    echo '</a>';
    echo '<a href="https://twitter.com/intent/tweet?url=' . urlencode($url) . '&text=' . $title . '" target="_blank" rel="noopener noreferrer" class="share-btn share-twitter" aria-label="X / Twitter">';
    echo '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> Twitter';
    echo '</a>';
    echo '<a href="https://wa.me/?text=' . $title . '%20' . urlencode($url) . '" target="_blank" rel="noopener noreferrer" class="share-btn share-whatsapp" aria-label="WhatsApp">';
    echo '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.9 11.9 0 0 0 12.04 0C5.43 0 .07 5.36.07 11.97c0 2.11.55 4.17 1.6 5.99L0 24l6.23-1.63a11.93 11.93 0 0 0 5.81 1.5h.01c6.61 0 11.97-5.36 11.97-11.97 0-3.2-1.25-6.21-3.5-8.42zM12.05 21.88h-.01a9.92 9.92 0 0 1-5.06-1.39l-.36-.21-3.76.99 1-3.66-.23-.38a9.9 9.9 0 0 1-1.52-5.26c0-5.48 4.46-9.94 9.95-9.94 2.65 0 5.15 1.03 7.03 2.91a9.88 9.88 0 0 1 2.91 7.03c0 5.49-4.46 9.94-9.93 9.94z"/></svg> WhatsApp';
    echo '</a>';
    echo '</div>';
}

/**
 * Setup default categories and pages to guarantee NO 404
 */
function berita_auto_setup_defaults() {
    if (get_option('berita_defaults_configured') === 'yes') {
        return;
    }

    // 1. Setup default categories
    $categories = array(
        'Nasional'      => 'Berita peristiwa, politik, dan kebijakan terkini nasional.',
        'Daerah'        => 'Kabar seputar pembangunan dan kejadian di berbagai pelosok daerah.',
        'Internasional' => 'Perkembangan politik, ekonomi, dan peristiwa global mancanegara.',
        'Ekonomi'       => 'Analisis pasar, bisnis, keuangan, dan industri.',
        'Olahraga'      => 'Kabar sepak bola, badminton, dan cabang olahraga dunia.',
        'Teknologi'     => 'Inovasi digital, gadget, kecerdasan buatan, dan sains.',
        'Otomotif'      => 'Review kendaraan, tren mobil, motor, dan mobilitas listrik.',
        'Gaya Hidup'    => 'Kesehatan, kuliner, tren fashion, dan pariwisata.',
        'Hiburan'       => 'Dunia film, musik, selebriti, dan seni kreatif.',
        'Pendidikan'    => 'Pembaruan kurikulum, kampus, beasiswa, dan edukasi anak.',
    );

    foreach ($categories as $cat_name => $cat_desc) {
        if (!term_exists($cat_name, 'category')) {
            wp_insert_term($cat_name, 'category', array(
                'slug'        => sanitize_title($cat_name),
                'description' => $cat_desc,
            ));
        }
    }

    // 2. Setup standard static pages
    $pages = array(
        'tentang-kami' => array(
            'title'   => 'Tentang Kami',
            'content' => '<p><strong>BERITA</strong> adalah portal media siber independen yang berkomitmen menghadirkan informasi yang akurat, berimbang, dan menginspirasi seluruh lapisan masyarakat.</p><h3>Visi Kami</h3><p>Menjadi rujukan informasi terdepan dan terpercaya di era digital dengan mengedepankan integritas jurnalisme dan verifikasi fakta.</p><h3>Misi Kami</h3><ul><li>Menyajikan berita secara cepat, tepat, dan mendalam.</li><li>Mengedukasi masyarakat melalui jurnalisme yang bertanggung jawab.</li><li>Mendorong kemajuan bangsa melalui keterbukaan informasi.</li></ul>',
        ),
        'redaksi' => array(
            'title'   => 'Susunan Redaksi',
            'content' => '<p>Berikut adalah susunan kepengurusan dan redaksi media <strong>BERITA</strong>:</p><h3>Manajemen & Redaksi</h3><p><strong>Pemimpin Umum:</strong> Budi Santoso, S.Sos.<br><strong>Pemimpin Redaksi:</strong> Ahmad Pratama, M.I.Kom.<br><strong>Redaktur Pelaksana:</strong> Dian Anggraini<br><strong>Koordinator Liputan:</strong> Rizky Ramadhan</p><h3>Dewan Penasehat:</h3><p>Prof. Dr. Hendra Gunawan<br>Siti Fatimah, S.H., LL.M.</p><h3>Alamat Kantor Redaksi:</h3><p>Gedung Graha Berita Mandiri Lantai 5<br>Jl. Sudirman No. 88, Jakarta Pusat, DKI Jakarta 10220<br>Telepon: (021) 555-0199<br>Email: redaksi@berita.test</p>',
        ),
        'pedoman-media' => array(
            'title'   => 'Pedoman Media Siber',
            'content' => '<p>Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB.</p><h3>Ruang Lingkup</h3><p>Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers.</p><h3>Verifikasi dan Keberimbangan Berita</h3><p>Setiap berita harus melalui proses verifikasi. Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama atau secepat-cepatnya pada kesempatan pertama untuk memenuhi prinsip akurasi dan keberimbangan.</p>',
        ),
        'iklan' => array(
            'title'   => 'Informasi Pemasangan Iklan',
            'content' => '<p>Jangkau jutaan pembaca setiap hari di seluruh Indonesia bersama media <strong>BERITA</strong>.</p><h3>Layanan Iklan Kami:</h3><ul><li><strong>Display Banner Ads:</strong> Leaderboard, Sidebar, In-Article, dan Sticky Bottom banner.</li><li><strong>Advertorial & Sponsored Content:</strong> Ulasan produk atau artikel profil brand yang terintegrasi secara natural.</li><li><strong>Social Media Campaign:</strong> Promosi multichannel di seluruh jejaring sosial media kami.</li></ul><h3>Hubungi Tim Sales:</h3><p>Email: iklan@berita.test<br>WhatsApp: 0812-3456-7890<br>Telepon: (021) 555-0198</p>',
        ),
        'kontak' => array(
            'title'   => 'Hubungi Kami',
            'content' => '<p>Silakan hubungi kami untuk pertanyaan, konfirmasi berita, undangan liputan, atau kerja sama bisnis.</p><p><strong>Alamat:</strong> Jl. Sudirman No. 88, Jakarta Pusat, Indonesia<br><strong>Email:</strong> info@berita.test<br><strong>Layanan Pelanggan:</strong> (021) 555-0199</p>',
        ),
        'kebijakan-privasi' => array(
            'title'   => 'Kebijakan Privasi',
            'content' => '<p>Kebijakan Privasi ini menjelaskan bagaimana <strong>BERITA</strong> mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat mengakses layanan situs kami.</p><p>Kami menghormati hak privasi setiap pengunjung dan tidak membagikan data pribadi Anda kepada pihak ketiga tanpa izin sah.</p>',
        ),
        'syarat-ketentuan' => array(
            'title'   => 'Syarat & Ketentuan',
            'content' => '<p>Dengan mengakses situs <strong>BERITA</strong>, Anda setuju untuk mematuhi seluruh syarat dan ketentuan penggunaan konten, komentar, dan layanan digital kami sesuai hukum yang berlaku di Republik Indonesia.</p>',
        ),
    );

    foreach ($pages as $slug => $page_data) {
        $existing = get_page_by_path($slug);
        if (!$existing) {
            wp_insert_post(array(
                'post_type'    => 'page',
                'post_name'    => $slug,
                'post_title'   => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status'  => 'publish',
            ));
        }
    }

    update_option('berita_defaults_configured', 'yes');
}
add_action('init', 'berita_auto_setup_defaults');

/**
 * 404 Prevention Fallback for Core Pages
 * If a required static route is requested, render graceful template even if DB was flushed
 */
function berita_template_redirect_fallback($template) {
    if (is_404()) {
        $request_uri = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';
        $parts = explode('?', $request_uri);
        $slug = trim($parts[0], '/');
        
        $known_pages = array(
            'redaksi'           => 'page-redaksi.php',
            'tentang-kami'      => 'page-tentang-kami.php',
            'pedoman-media'     => 'page-pedoman-media.php',
            'iklan'             => 'page-iklan.php',
            'kontak'            => 'page-kontak.php',
            'kebijakan-privasi' => 'page.php',
            'syarat-ketentuan'  => 'page.php',
            'video'             => 'archive.php',
            'foto'              => 'archive.php',
        );

        if (isset($known_pages[$slug])) {
            global $wp_query;
            $wp_query->is_404 = false;
            status_header(200);

            $custom_template = locate_template(array($known_pages[$slug], 'page.php', 'index.php'));
            if ($custom_template) {
                return $custom_template;
            }
        }
    }
    return $template;
}
add_filter('template_include', 'berita_template_redirect_fallback', 99);

/**
 * Video URL meta box
 */
function berita_add_video_meta_box() {
    add_meta_box(
        'berita_video_url',
        __('URL Video (YouTube / MP4)', 'berita'),
        'berita_video_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'berita_add_video_meta_box');

function berita_video_meta_box_callback($post) {
    wp_nonce_field('berita_save_video_url', 'berita_video_nonce');
    $video_url = get_post_meta($post->ID, 'berita_video_url', true);
    ?>
    <p>
        <label for="berita_video_url_field"><?php _e('Link YouTube atau file MP4:', 'berita'); ?></label>
        <input type="url" id="berita_video_url_field" name="berita_video_url" value="<?php echo esc_attr($video_url); ?>" style="width:100%;" placeholder="https://www.youtube.com/watch?v=...">
    </p>
    <p class="description"><?php _e('Video akan tampil di halaman artikel dan bagian Video Terpopuler.', 'berita'); ?></p>
    <?php
}

function berita_save_video_url($post_id) {
    if (!isset($_POST['berita_video_nonce']) || !wp_verify_nonce($_POST['berita_video_nonce'], 'berita_save_video_url')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['berita_video_url'])) {
        $url = esc_url_raw(trim(wp_unslash($_POST['berita_video_url'])));
        if ($url) {
            update_post_meta($post_id, 'berita_video_url', $url);
        } else {
            delete_post_meta($post_id, 'berita_video_url');
        }
    }
}
add_action('save_post', 'berita_save_video_url');

function berita_get_video_url($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return $post_id ? get_post_meta($post_id, 'berita_video_url', true) : '';
}

function berita_get_youtube_id($url) {
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches)) {
        return $matches[1];
    }
    return false;
}

function berita_render_video_embed($post_id = null, $class = '', $autoplay = false) {
    $url = berita_get_video_url($post_id);
    if (!$url) {
        return '';
    }

    $youtube_id = berita_get_youtube_id($url);
    if ($youtube_id) {
        $autoplay_param = $autoplay ? '&autoplay=1' : '';
        return sprintf(
            '<div class="berita-video-embed %s"><iframe src="https://www.youtube.com/embed/%s?rel=0%s" title="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe></div>',
            esc_attr($class),
            esc_attr($youtube_id),
            esc_attr($autoplay_param),
            esc_attr(get_the_title($post_id))
        );
    }

    if (preg_match('/\.(mp4|webm|ogg)(\?|$)/i', $url)) {
        $autoplay_attr = $autoplay ? ' autoplay' : '';
        return sprintf(
            '<div class="berita-video-embed %s"><video controls preload="metadata"%s src="%s"></video></div>',
            esc_attr($class),
            $autoplay_attr,
            esc_url($url)
        );
    }

    $embed = wp_oembed_get($url);
    if ($embed) {
        return '<div class="berita-video-embed ' . esc_attr($class) . '">' . $embed . '</div>';
    }

    return '';
}

/**
 * Customizer Settings
 */
function berita_customize_register($wp_customize) {
    $wp_customize->add_section('berita_header_banner', array(
        'title'    => __('Header Banner', 'berita'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('header_banner_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_banner_image', array(
        'label'    => __('Header Banner Image', 'berita'),
        'section'  => 'berita_header_banner',
        'settings' => 'header_banner_image',
    )));

    $wp_customize->add_setting('header_banner_url', array(
        'default'           => home_url('/iklan'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_banner_url', array(
        'label'    => __('Header Banner URL', 'berita'),
        'section'  => 'berita_header_banner',
        'settings' => 'header_banner_url',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'berita_customize_register');
