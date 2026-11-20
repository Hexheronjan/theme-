<?php
/**
 * Sorotan Stories Template Part
 *
 * @package Berita
 * @since 1.4.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$sorotan_groups = berita_get_sorotan_groups_data();

if (empty($sorotan_groups)) {
    return;
}
?>

<section class="sorotan-section" aria-label="<?php esc_attr_e('Sorotan', 'berita'); ?>">
    <div class="sorotan-scroll">
        <?php foreach ($sorotan_groups as $index => $group) :
            $initial = function_exists('mb_substr') ? mb_substr($group['label'], 0, 1) : substr($group['label'], 0, 1);
            ?>
            <button type="button" class="sorotan-item" data-sorotan-group="<?php echo (int) $index; ?>" aria-label="<?php echo esc_attr($group['label']); ?>">
                <span class="sorotan-item-ring">
                    <span class="sorotan-item-inner">
                        <?php if (!empty($group['thumb'])) : ?>
                            <img src="<?php echo esc_url($group['thumb']); ?>" alt="<?php echo esc_attr($group['label']); ?>" loading="lazy">
                        <?php else : ?>
                            <span class="sorotan-item-fallback"><?php echo esc_html($initial); ?></span>
                        <?php endif; ?>
                    </span>
                </span>
                <span class="sorotan-item-label"><?php echo esc_html($group['label']); ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</section>

<script type="application/json" id="berita-sorotan-data"><?php echo wp_json_encode($sorotan_groups); ?></script>

<div class="sorotan-viewer" id="sorotan-viewer" hidden aria-hidden="true">
    <div class="sorotan-viewer-backdrop" data-sorotan-close></div>

    <div class="sorotan-viewer-layout">
        <button type="button" class="sorotan-nav sorotan-nav-prev" aria-label="<?php esc_attr_e('Grup sebelumnya', 'berita'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <div class="sorotan-story-card" role="dialog" aria-modal="true" aria-labelledby="sorotan-story-title">
            <div class="sorotan-progress" id="sorotan-progress"></div>

            <div class="sorotan-story-header">
                <div class="sorotan-story-brand">
                    <span class="sorotan-story-avatar" id="sorotan-story-avatar"></span>
                    <div>
                        <strong id="sorotan-story-group"></strong>
                        <span id="sorotan-story-time"></span>
                    </div>
                </div>
                <button type="button" class="sorotan-story-close" data-sorotan-close aria-label="<?php esc_attr_e('Tutup', 'berita'); ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="sorotan-story-media" id="sorotan-story-media">
                <div class="sorotan-story-media-overlay"></div>
                <h3 class="sorotan-story-title" id="sorotan-story-title"></h3>
            </div>

            <div class="sorotan-story-body">
                <p id="sorotan-story-excerpt"></p>
            </div>

            <a href="#" class="sorotan-story-cta" id="sorotan-story-cta" target="_blank" rel="noopener noreferrer">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <?php esc_html_e('Baca artikel...', 'berita'); ?>
            </a>

            <button type="button" class="sorotan-story-tap sorotan-story-tap-prev" aria-label="<?php esc_attr_e('Slide sebelumnya', 'berita'); ?>"></button>
            <button type="button" class="sorotan-story-tap sorotan-story-tap-next" aria-label="<?php esc_attr_e('Slide berikutnya', 'berita'); ?>"></button>
        </div>

        <button type="button" class="sorotan-nav sorotan-nav-next" aria-label="<?php esc_attr_e('Grup berikutnya', 'berita'); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        <div class="sorotan-preview-rail" id="sorotan-preview-rail" aria-hidden="true"></div>
    </div>
</div>
