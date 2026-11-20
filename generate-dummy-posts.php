<?php
/**
 * Dummy Posts Generator for Berita Theme
 * 
 * Run this file ONCE to generate dummy posts, then DELETE it.
 * Access: http://theme.test:8080/wp-content/themes/berita/generate-dummy-posts.php
 * 
 * @package Berita
 */

// Prevent direct access outside WordPress context
if (!defined('ABSPATH')) {
    // If not in WordPress context, try to load WordPress
    $wp_load_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
    if (file_exists($wp_load_path)) {
        require_once($wp_load_path);
    } else {
        die('WordPress not found. Please run this from within WordPress or access via browser.');
    }
}

// Check if user is logged in as admin
if (!current_user_can('manage_options')) {
    wp_die('You need to be logged in as admin to run this script.');
}

// Dummy data
$dummy_posts = array(
    array(
        'title' => 'Presiden Tegaskan Komitmen Tingkatkan Kesejahteraan Rakyat',
        'category' => 'Nasional',
        'content' => 'Presiden Republik Indonesia dalam pidatonya menegaskan komitmen pemerintah untuk terus meningkatkan kesejahteraan rakyat. Berbagai program sosial dan ekonomi akan terus diperluas jangkauannya demi mencapai target kesejahteraan yang lebih merata di seluruh pelosok negeri.',
        'excerpt' => 'Presiden menegaskan komitmen pemerintah untuk terus meningkatkan kesejahteraan rakyat melalui berbagai program sosial dan ekonomi.',
    ),
    array(
        'title' => 'Harga Beras Stabil Pasca Panen Raya',
        'category' => 'Ekonomi',
        'content' => 'Harga beras di pasar nasional menunjukkan kestabilan pasca panen raya di beberapa sentra produksi. Kementerian Pertanian memastikan stok beras nasional dalam kondisi aman hingga beberapa bulan ke depan.',
        'excerpt' => 'Harga beras di pasar nasional menunjukkan kestabilan pasca panen raya di beberapa sentra produksi.',
    ),
    array(
        'title' => 'Timnas Indonesia Siap Hadapi Laga Persahabatan',
        'category' => 'Olahraga',
        'content' => 'Tim nasional sepak bola Indonesia telah siap menghadapi laga persahabatan internasional yang akan digelar bulan depan. Pelatih timnas menyatakan bahwa skuad Garuda dalam kondisi prima dan siap memberikan performa terbaik.',
        'excerpt' => 'Tim nasional sepak bola Indonesia siap menghadapi laga persahabatan internasional bulan depan.',
    ),
    array(
        'title' => 'Inovasi Teknologi Pertanian Modern di Jawa Timur',
        'category' => 'Teknologi',
        'content' => 'Petani di Jawa Timur mulai mengadopsi teknologi pertanian modern untuk meningkatkan produktivitas. Penggunaan drone untuk pemantauan lahan dan sistem irigasi otomatis terbukti efektif meningkatkan hasil panen.',
        'excerpt' => 'Petani di Jawa Timur mulai mengadopsi teknologi pertanian modern untuk meningkatkan produktivitas.',
    ),
    array(
        'title' => 'Festival Budaya Nusantara Kembali Digelar',
        'category' => 'Gaya Hidup',
        'content' => 'Festival Budaya Nusantara tahun ini kembali digelar dengan menampilkan berbagai pertunjukan seni tradisional dari seluruh Indonesia. Festival ini bertujuan untuk melestarikan budaya lokal dan memperkenalkannya kepada generasi muda.',
        'excerpt' => 'Festival Budaya Nusantara kembali digelar dengan menampilkan berbagai pertunjukan seni tradisional dari seluruh Indonesia.',
    ),
    array(
        'title' => 'Pembangunan Jalan Tol Trans Sumatera Terus Dikebut',
        'category' => 'Daerah',
        'content' => 'Pembangunan jalan tol Trans Sumatera terus dikebut penyelesaiannya. Ruas-ruas baru diharapkan dapat selesai tahun ini dan akan membuka akses ekonomi baru antar provinsi di Pulau Sumatera.',
        'excerpt' => 'Pembangunan jalan tol Trans Sumatera terus dikebut penyelesaiannya untuk membuka akses ekonomi baru.',
    ),
    array(
        'title' => 'Film Indonesia Masuk Nominasi Festival Film Internasional',
        'category' => 'Hiburan',
        'content' => 'Sebuah film produksi Indonesia berhasil masuk dalam nominasi festival film internasional bergengsi. Ini merupakan pencapaian penting bagi industri perfilman nasional yang terus berkembang.',
        'excerpt' => 'Film produksi Indonesia berhasil masuk dalam nominasi festival film internasional bergengsi.',
    ),
    array(
        'title' => 'Reformasi Pendidikan Vokasi Diperluas',
        'category' => 'Pendidikan',
        'content' => 'Kementerian Pendidikan memperluas program reformasi pendidikan vokasi ke berbagai daerah. Program ini bertujuan untuk mencetak tenaga kerja terampil yang siap menghadapi tantangan industri 4.0.',
        'excerpt' => 'Kementerian Pendidikan memperluas program reformasi pendidikan vokasi ke berbagai daerah.',
    ),
    array(
        'title' => 'Peluncuran Mobil Listrik Lokal Disambut Antusias',
        'category' => 'Otomotif',
        'content' => 'Peluncuran mobil listrik produksi lokal disambut antusias oleh masyarakat. Pemerintah memberikan berbagai insentif untuk mendorong penggunaan kendaraan ramah lingkungan.',
        'excerpt' => 'Peluncuran mobil listrik produksi lokal disambut antusias oleh masyarakat dengan dukungan insentif pemerintah.',
    ),
    array(
        'title' => 'Kerjasama Ekonomi Indonesia-ASEAN Diperkuat',
        'category' => 'Internasional',
        'content' => 'Indonesia memperkuat kerjasama ekonomi dengan negara-negara ASEAN dalam pertemuan tingkat menteri. Fokus kerjasama meliputi perdagangan, investasi, dan konektivitas regional.',
        'excerpt' => 'Indonesia memperkuat kerjasama ekonomi dengan negara-negara ASEAN dalam pertemuan tingkat menteri.',
    ),
    array(
        'title' => 'Startup Edukasi Indonesia Raih Pendanaan Seri B',
        'category' => 'Teknologi',
        'content' => 'Startup edukasi asal Indonesia berhasil meraih pendanaan seri B dari investor internasional. Pendanaan ini akan digunakan untuk ekspansi layanan ke berbagai negara Asia Tenggara.',
        'excerpt' => 'Startup edukasi asal Indonesia berhasil meraih pendanaan seri B dari investor internasional untuk ekspansi regional.',
    ),
    array(
        'title' => 'Pariwisata Bali Pulih Pasca Pandemi',
        'category' => 'Gaya Hidup',
        'content' => 'Sektor pariwisata Bali menunjukkan pemulihan yang signifikan pasca pandemi. Jumlah kunjungan wisatawan mancanegara terus meningkat dan memberikan dampak positif bagi ekonomi lokal.',
        'excerpt' => 'Sektor pariwisata Bali menunjukkan pemulihan yang signifikan dengan peningkatan kunjungan wisatawan mancanegara.',
    ),
);

// Categories to create
$categories = array(
    'Nasional',
    'Daerah', 
    'Internasional',
    'Ekonomi',
    'Olahraga',
    'Teknologi',
    'Otomotif',
    'Gaya Hidup',
    'Hiburan',
    'Pendidikan'
);

// Create categories first
foreach ($categories as $cat_name) {
    $cat = get_category_by_slug(sanitize_title($cat_name));
    if (!$cat) {
        $cat_id = wp_create_category($cat_name);
        echo "Created category: $cat_name (ID: $cat_id)<br>";
    } else {
        echo "Category already exists: $cat_name<br>";
    }
}

// Create posts
$created_count = 0;
foreach ($dummy_posts as $index => $post_data) {
    // Get category ID
    $cat = get_category_by_slug(sanitize_title($post_data['category']));
    $cat_id = $cat ? $cat->term_id : 1; // Default to uncategorized if not found
    
    // Check if post already exists
    $existing_post = get_page_by_title($post_data['title'], OBJECT, 'post');
    
    if (!$existing_post) {
        $post_id = wp_insert_post(array(
            'post_title'    => $post_data['title'],
            'post_content'  => $post_data['content'],
            'post_excerpt'  => $post_data['excerpt'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_category' => array($cat_id),
            'post_date'     => date('Y-m-d H:i:s', strtotime("-{$index} days")),
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            echo "Created post: {$post_data['title']} (ID: $post_id)<br>";
            $created_count++;
        } else {
            echo "Error creating post: {$post_data['title']}<br>";
        }
    } else {
        echo "Post already exists: {$post_data['title']}<br>";
    }
}

// Delete default "Hello World" post
$hello_world = get_page_by_title('Hello World!', OBJECT, 'post');
if ($hello_world) {
    wp_delete_post($hello_world->ID, true);
    echo "Deleted default 'Hello World!' post<br>";
}

echo "<br><strong>Process completed!</strong><br>";
echo "Created $created_count new posts.<br>";
echo "<br><strong>IMPORTANT:</strong> Delete this file (generate-dummy-posts.php) from your server after running it.<br>";
echo "<a href='" . home_url() . "'>View your site</a>";
