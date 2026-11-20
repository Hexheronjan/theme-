<?php
/**
 * Demo Data Importer for Portal Berita Theme
 *
 * Automatically seeds posts, featured images, categories, sorotan,
 * pages, and menus when the theme is activated on client sites.
 *
 * @package Berita
 * @since 1.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Demo Importer Function
 *
 * @param bool $force Force re-import even if already imported.
 * @return array Results summary.
 */
function berita_import_demo_data($force = false) {
    if (!$force && get_option('berita_demo_data_imported') === 'yes') {
        $published = wp_count_posts('post')->publish;
        if ($published > 1) {
            return array('status' => 'skipped', 'message' => 'Demo data already imported.');
        }
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $results = array(
        'categories' => 0,
        'posts'      => 0,
        'sorotan'    => 0,
        'images'     => 0,
        'pages'      => 0,
    );

    // 1. Setup Default Categories
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
            $results['categories']++;
        }
    }

    // 2. Setup Static Pages
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

    foreach ($pages as $slug => $pdata) {
        $existing = get_page_by_path($slug);
        if (!$existing) {
            wp_insert_post(array(
                'post_type'    => 'page',
                'post_name'    => $slug,
                'post_title'   => $pdata['title'],
                'post_content' => $pdata['content'],
                'post_status'  => 'publish',
            ));
            $results['pages']++;
        }
    }

    // 3. Load Demo Data JSON
    $json_file = get_template_directory() . '/inc/demo-data.json';
    if (!file_exists($json_file)) {
        return array('status' => 'error', 'message' => 'demo-data.json not found');
    }
    $demo_data = json_decode(file_get_contents($json_file), true);
    if (!is_array($demo_data)) {
        return array('status' => 'error', 'message' => 'Invalid demo-data.json');
    }

    // 4. Import Demo Images to Media Library
    $demo_images_dir = get_template_directory() . '/assets/demo-images';
    $upload_dir = wp_upload_dir();
    $attachment_map = array();

    $images_to_import = array();
    if (!empty($demo_data['posts'])) {
        foreach ($demo_data['posts'] as $p) {
            if (!empty($p['thumb_file'])) {
                $images_to_import[$p['thumb_file']] = true;
            }
        }
    }
    if (!empty($demo_data['sorotan'])) {
        foreach ($demo_data['sorotan'] as $s) {
            if (!empty($s['thumb_file'])) {
                $images_to_import[$s['thumb_file']] = true;
            }
        }
    }

    foreach (array_keys($images_to_import) as $filename) {
        // Check if attachment with this filename already exists
        $existing_att = get_posts(array(
            'post_type'   => 'attachment',
            'meta_key'    => '_wp_attached_file',
            'meta_value'  => $filename,
            'meta_compare'=> 'LIKE',
            'numberposts' => 1,
        ));

        if (!empty($existing_att)) {
            $attachment_map[$filename] = $existing_att[0]->ID;
            continue;
        }

        $source_img = $demo_images_dir . '/' . $filename;
        if (!file_exists($source_img)) {
            continue;
        }

        // Copy image into uploads directory
        $dest_filename = wp_unique_filename($upload_dir['path'], $filename);
        $dest_filepath = $upload_dir['path'] . '/' . $dest_filename;

        if (@copy($source_img, $dest_filepath)) {
            $filetype = wp_check_filetype($dest_filename, null);
            $attachment_data = array(
                'guid'           => $upload_dir['url'] . '/' . $dest_filename,
                'post_mime_type' => $filetype['type'],
                'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
                'post_content'   => '',
                'post_status'    => 'inherit',
            );

            $attach_id = wp_insert_attachment($attachment_data, $dest_filepath);
            if ($attach_id && !is_wp_error($attach_id)) {
                $attach_meta = wp_generate_attachment_metadata($attach_id, $dest_filepath);
                wp_update_attachment_metadata($attach_id, $attach_meta);
                $attachment_map[$filename] = $attach_id;
                $results['images']++;
            }
        }
    }

    // 5. Import Posts
    if (!empty($demo_data['posts'])) {
        foreach ($demo_data['posts'] as $post_entry) {
            $existing_post = get_page_by_title($post_entry['title'], OBJECT, 'post');
            if ($existing_post) {
                // If force mode, update thumbnail if missing
                if ($force && !has_post_thumbnail($existing_post->ID) && !empty($post_entry['thumb_file']) && isset($attachment_map[$post_entry['thumb_file']])) {
                    set_post_thumbnail($existing_post->ID, $attachment_map[$post_entry['thumb_file']]);
                }
                continue;
            }

            // Map category names to IDs
            $cat_ids = array();
            if (!empty($post_entry['categories'])) {
                foreach ($post_entry['categories'] as $cname) {
                    $term = get_category_by_slug(sanitize_title($cname));
                    if (!$term) {
                        $new_cat = wp_insert_term($cname, 'category', array('slug' => sanitize_title($cname)));
                        if (!is_wp_error($new_cat)) {
                            $cat_ids[] = $new_cat['term_id'];
                        }
                    } else {
                        $cat_ids[] = $term->term_id;
                    }
                }
            }

            $new_post_id = wp_insert_post(array(
                'post_title'    => $post_entry['title'],
                'post_content'  => $post_entry['content'],
                'post_excerpt'  => $post_entry['excerpt'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_date'     => !empty($post_entry['date']) ? $post_entry['date'] : current_time('mysql'),
                'post_category' => $cat_ids,
                'tags_input'    => !empty($post_entry['tags']) ? $post_entry['tags'] : array(),
            ));

            if ($new_post_id && !is_wp_error($new_post_id)) {
                if (!empty($post_entry['thumb_file']) && isset($attachment_map[$post_entry['thumb_file']])) {
                    set_post_thumbnail($new_post_id, $attachment_map[$post_entry['thumb_file']]);
                }
                $results['posts']++;
            }
        }
    }

    // 6. Import Sorotan CPT
    if (!empty($demo_data['sorotan'])) {
        foreach ($demo_data['sorotan'] as $s_entry) {
            $existing_s = get_page_by_title($s_entry['title'], OBJECT, 'berita_sorotan');
            if ($existing_s) {
                continue;
            }

            $s_id = wp_insert_post(array(
                'post_title'   => $s_entry['title'],
                'post_content' => $s_entry['content'],
                'post_excerpt' => $s_entry['excerpt'],
                'post_status'  => 'publish',
                'post_type'    => 'berita_sorotan',
                'post_date'    => !empty($s_entry['date']) ? $s_entry['date'] : current_time('mysql'),
            ));

            if ($s_id && !is_wp_error($s_id)) {
                if (!empty($s_entry['groups'])) {
                    wp_set_object_terms($s_id, $s_entry['groups'], 'sorotan_grup');
                }
                if (!empty($s_entry['thumb_file']) && isset($attachment_map[$s_entry['thumb_file']])) {
                    set_post_thumbnail($s_id, $attachment_map[$s_entry['thumb_file']]);
                }
                $results['sorotan']++;
            }
        }
    }

    // 7. Delete default "Hello World!" post if present
    $hello_world = get_page_by_title('Hello World!', OBJECT, 'post');
    if (!$hello_world) {
        $hello_world = get_page_by_title('Halo dunia!', OBJECT, 'post');
    }
    if ($hello_world) {
        wp_delete_post($hello_world->ID, true);
    }

    // 8. Auto Create & Assign Navigation Menus if none assigned
    $locations = get_nav_menu_locations();
    if (empty($locations['primary_menu'])) {
        $primary_menu_name = 'Menu Utama Portal';
        $primary_menu = wp_get_nav_menu_object($primary_menu_name);
        if (!$primary_menu) {
            $menu_id = wp_create_nav_menu($primary_menu_name);
            if (!is_wp_error($menu_id)) {
                // Add home link
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'  => 'Beranda',
                    'menu-item-url'    => home_url('/'),
                    'menu-item-status' => 'publish',
                    'menu-item-type'   => 'custom',
                ));

                // Add Category links
                $cats_to_add = array('Nasional', 'Daerah', 'Internasional', 'Ekonomi', 'Olahraga', 'Teknologi', 'Otomotif');
                foreach ($cats_to_add as $c_name) {
                    $term = get_category_by_slug(sanitize_title($c_name));
                    if ($term) {
                        wp_update_nav_menu_item($menu_id, 0, array(
                            'menu-item-title'     => $c_name,
                            'menu-item-object'    => 'category',
                            'menu-item-object-id' => $term->term_id,
                            'menu-item-type'      => 'taxonomy',
                            'menu-item-status'    => 'publish',
                        ));
                    }
                }
                $locations['primary_menu'] = $menu_id;
            }
        } else {
            $locations['primary_menu'] = $primary_menu->term_id;
        }
    }

    if (empty($locations['top_menu'])) {
        $top_menu_name = 'Menu Atas';
        $top_menu = wp_get_nav_menu_object($top_menu_name);
        if (!$top_menu) {
            $t_menu_id = wp_create_nav_menu($top_menu_name);
            if (!is_wp_error($t_menu_id)) {
                $top_pages = array('tentang-kami' => 'Tentang Kami', 'redaksi' => 'Redaksi', 'pedoman-media' => 'Pedoman Media', 'iklan' => 'Iklan');
                foreach ($top_pages as $slug => $label) {
                    $page = get_page_by_path($slug);
                    if ($page) {
                        wp_update_nav_menu_item($t_menu_id, 0, array(
                            'menu-item-title'     => $label,
                            'menu-item-object'    => 'page',
                            'menu-item-object-id' => $page->ID,
                            'menu-item-type'      => 'post_type',
                            'menu-item-status'    => 'publish',
                        ));
                    }
                }
                $locations['top_menu'] = $t_menu_id;
            }
        } else {
            $locations['top_menu'] = $top_menu->term_id;
        }
    }

    set_theme_mod('nav_menu_locations', $locations);

    update_option('berita_demo_data_imported', 'yes');

    return array(
        'status'  => 'success',
        'message' => 'Demo data imported successfully!',
        'details' => $results,
    );
}

/**
 * Trigger Auto-Import on Theme Switch / Activation
 */
function berita_auto_import_on_activation() {
    // Only run if not already imported or if posts are empty
    $imported = get_option('berita_demo_data_imported');
    if ($imported !== 'yes') {
        berita_import_demo_data(false);
    }
}
add_action('after_switch_theme', 'berita_auto_import_on_activation');

/**
 * Register Admin Menu Page: Tampilan > Impor Data Demo
 */
function berita_register_demo_importer_menu() {
    add_theme_page(
        __('Impor Data Demo', 'berita'),
        __('Impor Data Demo', 'berita'),
        'manage_options',
        'berita-demo-import',
        'berita_render_demo_importer_page'
    );
}
add_action('admin_menu', 'berita_register_demo_importer_menu');

/**
 * Render Admin Page
 */
function berita_render_demo_importer_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Anda tidak memiliki akses ke halaman ini.', 'berita'));
    }

    $message = '';
    $status_type = 'info';

    if (isset($_POST['berita_do_import']) && check_admin_referer('berita_import_demo_nonce')) {
        $res = berita_import_demo_data(true);
        if ($res['status'] === 'success') {
            $status_type = 'success';
            $d = $res['details'];
            $message = sprintf(
                __('Berhasil mengimpor konten demo! Ditambahkan: %d artikel berita, %d gambar thumbnail, %d sorotan, %d kategori, %d halaman.', 'berita'),
                $d['posts'],
                $d['images'],
                $d['sorotan'],
                $d['categories'],
                $d['pages']
            );
        } else {
            $status_type = 'error';
            $message = esc_html($res['message']);
        }
    }

    $is_imported = get_option('berita_demo_data_imported') === 'yes';
    $post_count = wp_count_posts('post')->publish;
    ?>
    <div class="wrap" style="max-width: 850px;">
        <h1><?php _e('Impor Konten Demo - Portal Berita', 'berita'); ?></h1>
        <hr>

        <?php if (!empty($message)) : ?>
            <div class="notice notice-<?php echo esc_attr($status_type); ?> is-dismissible">
                <p><strong><?php echo esc_html($message); ?></strong></p>
            </div>
        <?php endif; ?>

        <div style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 24px; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h2 style="margin-top: 0; display: flex; align-items: center; gap: 8px;">
                <span class="dashicons dashicons-download" style="font-size: 28px; width: 28px; height: 28px; color: #1a3a5f;"></span>
                <?php _e('Paket Demo Konten Bawaan Tema', 'berita'); ?>
            </h2>
            <p style="font-size: 14px; color: #555; line-height: 1.6;">
                <?php _e('Fitur ini akan secara otomatis mengisi website Anda dengan seluruh konten demo berita seperti di situs demo (artikel, gambar thumbnail unggulan, kategori, menu navigasi, dan data sorotan). Sangat cocok digunakan untuk website baru agar langsung siap pakai.', 'berita'); ?>
            </p>

            <div style="background: #f9f9f9; border-left: 4px solid #1a3a5f; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; font-weight: 600;">
                    <?php _e('Status Konten Saat Ini:', 'berita'); ?>
                    <span style="color: <?php echo $is_imported ? '#46b450' : '#e63946'; ?>;">
                        <?php echo $is_imported ? __('Data Demo Sudah Terpasang', 'berita') : __('Belum Dipasang', 'berita'); ?>
                    </span>
                    (Total <?php echo intval($post_count); ?> artikel berita aktif)
                </p>
            </div>

            <div style="margin: 20px 0;">
                <h3 style="font-size: 15px;"><?php _e('Konten yang akan diimpor:', 'berita'); ?></h3>
                <ul style="list-style: disc; padding-left: 20px; color: #444; line-height: 1.8;">
                    <li><strong>26 Artikel Berita Lengkap:</strong> Nasional, Daerah (Ponorogo, dll.), Internasional, Ekonomi, Olahraga, Teknologi, Otomotif, dll.</li>
                    <li><strong>17 Berkas Gambar Asli:</strong> Diimpor ke Media Library dan dipasang sebagai <em>Featured Image</em> artikel.</li>
                    <li><strong>5 Data Sorotan / Stories:</strong> Lengkap dengan grup taksonomi.</li>
                    <li><strong>10 Kategori Berita & 7 Halaman Statis:</strong> Tentang Kami, Redaksi, Pedoman Media, Iklan, Kontak, Privasi, Syarat.</li>
                    <li><strong>Menu Navigasi Otomatis:</strong> Terhubung langsung ke kategori dan halaman.</li>
                </ul>
            </div>

            <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin mengimpor konten demo? Konten akan otomatis dimasukkan ke website Anda.');">
                <?php wp_nonce_field('berita_import_demo_nonce'); ?>
                <input type="hidden" name="berita_do_import" value="1">
                <button type="submit" class="button button-primary button-hero" style="background: #1a3a5f; border-color: #0d2137;">
                    <?php echo $is_imported ? __('Impor Ulang Data Demo', 'berita') : __('Pasang & Impor Data Demo Sekarang', 'berita'); ?>
                </button>
            </form>
        </div>
    </div>
    <?php
}
