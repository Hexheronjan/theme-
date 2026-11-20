<?php
/**
 * Sorotan Stories (CPT, Groups, 24h expiry)
 *
 * @package Berita
 * @since 1.4.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BERITA_SOROTAN_HOURS', 24);

/**
 * Register Sorotan CPT & Grup taxonomy
 */
function berita_register_sorotan_cpt() {
    register_post_type('berita_sorotan', array(
        'labels' => array(
            'name'               => __('Sorotan', 'berita'),
            'singular_name'      => __('Sorotan', 'berita'),
            'add_new'            => __('Tambah Sorotan', 'berita'),
            'add_new_item'       => __('Tambah Sorotan Baru', 'berita'),
            'edit_item'          => __('Edit Sorotan', 'berita'),
            'new_item'           => __('Sorotan Baru', 'berita'),
            'view_item'          => __('Lihat Sorotan', 'berita'),
            'search_items'       => __('Cari Sorotan', 'berita'),
            'not_found'          => __('Belum ada sorotan.', 'berita'),
            'not_found_in_trash' => __('Tidak ada sorotan di sampah.', 'berita'),
            'menu_name'          => __('Sorotan', 'berita'),
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-images-alt2',
        'menu_position'       => 26,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'         => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_in_rest'        => true,
    ));

    register_taxonomy('sorotan_grup', 'berita_sorotan', array(
        'labels' => array(
            'name'          => __('Grup Sorotan', 'berita'),
            'singular_name' => __('Grup Sorotan', 'berita'),
            'add_new_item'  => __('Tambah Grup Baru', 'berita'),
            'search_items'  => __('Cari Grup', 'berita'),
            'all_items'     => __('Semua Grup', 'berita'),
            'menu_name'     => __('Grup Sorotan', 'berita'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => false,
    ));
}
add_action('init', 'berita_register_sorotan_cpt');

/**
 * Default grup sorotan
 */
function berita_setup_sorotan_groups() {
    if (get_option('berita_sorotan_groups_v1') === 'yes') {
        return;
    }

    $groups = array(
        'Sorotan Siang',
        'Polling',
        'Bisnis',
        'News',
        'Otomotif',
        'Woman',
        'Tekno & Sains',
        'Bola & Sports',
        'Entertainment',
    );

    foreach ($groups as $name) {
        if (!term_exists($name, 'sorotan_grup')) {
            wp_insert_term($name, 'sorotan_grup', array(
                'slug' => sanitize_title($name),
            ));
        }
    }

    update_option('berita_sorotan_groups_v1', 'yes');
}
add_action('init', 'berita_setup_sorotan_groups', 20);

/**
 * Meta box: link artikel
 */
function berita_sorotan_meta_boxes() {
    add_meta_box(
        'berita_sorotan_link',
        __('Link Artikel', 'berita'),
        'berita_sorotan_link_callback',
        'berita_sorotan',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'berita_sorotan_meta_boxes');

function berita_sorotan_link_callback($post) {
    wp_nonce_field('berita_save_sorotan_link', 'berita_sorotan_link_nonce');
    $link = get_post_meta($post->ID, 'sorotan_artikel_link', true);
    ?>
    <p>
        <label for="sorotan_artikel_link"><?php _e('URL artikel lengkap (tombol Baca artikel):', 'berita'); ?></label>
        <input type="url" id="sorotan_artikel_link" name="sorotan_artikel_link" value="<?php echo esc_attr($link); ?>" style="width:100%;" placeholder="https://...">
    </p>
    <p class="description">
        <?php
        printf(
            esc_html__('Sorotan otomatis hilang setelah %d jam sejak diterbitkan.', 'berita'),
            berita_get_sorotan_expiry_hours()
        );
        ?>
    </p>
    <?php
}

function berita_save_sorotan_link($post_id) {
    if (!isset($_POST['berita_sorotan_link_nonce']) || !wp_verify_nonce($_POST['berita_sorotan_link_nonce'], 'berita_save_sorotan_link')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['sorotan_artikel_link'])) {
        $link = esc_url_raw(trim(wp_unslash($_POST['sorotan_artikel_link'])));
        if ($link) {
            update_post_meta($post_id, 'sorotan_artikel_link', $link);
        } else {
            delete_post_meta($post_id, 'sorotan_artikel_link');
        }
    }
}
add_action('save_post_berita_sorotan', 'berita_save_sorotan_link');

/**
 * Admin notice helper on sorotan list
 */
function berita_sorotan_admin_notice() {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'berita_sorotan') {
        return;
    }
    ?>
    <div class="notice notice-info">
        <p>
            <?php
            printf(
                esc_html__('Setiap sorotan aktif selama %1$d jam. Pilih %2$sGrup Sorotan%3$s, upload gambar unggulan, isi ringkasan, lalu link artikel.', 'berita'),
                berita_get_sorotan_expiry_hours(),
                '<strong>',
                '</strong>'
            );
            ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'berita_sorotan_admin_notice');

function berita_get_sorotan_expiry_hours() {
    return (int) apply_filters('berita_sorotan_expiry_hours', BERITA_SOROTAN_HOURS);
}

function berita_get_sorotan_date_query() {
    return array(
        array(
            'after'     => berita_get_sorotan_expiry_hours() . ' hours ago',
            'inclusive' => true,
            'column'    => 'post_date_gmt',
        ),
    );
}

function berita_sorotan_time_ago($post_id) {
    $time = get_post_time('U', true, $post_id);
    $diff = current_time('timestamp', true) - $time;

    if ($diff < 60) {
        return __('Baru saja', 'berita');
    }
    if ($diff < 3600) {
        $mins = (int) floor($diff / 60);
        return sprintf(_n('%d menit lalu', '%d menit lalu', $mins, 'berita'), $mins);
    }
    if ($diff < 86400) {
        $hours = (int) floor($diff / 3600);
        return sprintf(_n('%d jam lalu', '%d jam lalu', $hours, 'berita'), $hours);
    }

    return human_time_diff($time, current_time('timestamp', true)) . ' ' . __('lalu', 'berita');
}

function berita_get_sorotan_stories_by_grup($term_id) {
    $query = new WP_Query(array(
        'post_type'      => 'berita_sorotan',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => array(
            array(
                'taxonomy' => 'sorotan_grup',
                'field'    => 'term_id',
                'terms'    => (int) $term_id,
            ),
        ),
        'date_query'     => berita_get_sorotan_date_query(),
    ));

    $stories = array();

    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $link = get_post_meta($id, 'sorotan_artikel_link', true);
        if (!$link) {
            $link = get_permalink($id);
        }

        $stories[] = array(
            'id'      => $id,
            'title'   => get_the_title(),
            'excerpt' => wp_trim_words(get_the_excerpt(), 28),
            'image'   => get_the_post_thumbnail_url($id, 'berita-hero') ?: '',
            'link'    => esc_url($link),
            'timeAgo' => berita_sorotan_time_ago($id),
        );
    }

    wp_reset_postdata();

    return $stories;
}

function berita_get_sorotan_groups_data() {
    $terms = get_terms(array(
        'taxonomy'   => 'sorotan_grup',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ));

    if (is_wp_error($terms)) {
        return array();
    }

    $groups = array();

    foreach ($terms as $term) {
        $stories = berita_get_sorotan_stories_by_grup($term->term_id);
        if (empty($stories)) {
            continue;
        }

        $groups[] = array(
            'id'      => (int) $term->term_id,
            'slug'    => $term->slug,
            'label'   => $term->name,
            'thumb'   => !empty($stories[0]['image']) ? $stories[0]['image'] : '',
            'stories' => $stories,
        );
    }

    return $groups;
}
