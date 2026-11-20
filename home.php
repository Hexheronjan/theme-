<?php
/**
 * Home Template
 * Redirects to front-page.php
 * 
 * @package Berita
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include front-page.php
include(get_template_directory() . '/front-page.php');
