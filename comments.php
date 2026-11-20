<?php
/**
 * Comments Template
 * 
 * @package Berita
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}
?>

<div class="comments-section">
    <h3 class="comments-title">
        <?php
        $comments_number = get_comments_number();
        if ('1' === $comments_number) {
            printf(
                _x('Komentar (%s)', 'comments title', 'berita'),
                number_format_i18n($comments_number)
            );
        } else {
            printf(
                _x('Komentar (%s)', 'comments title', 'berita'),
                number_format_i18n($comments_number)
            );
        }
        ?>
    </h3>

    <?php if (have_comments()) : ?>
        <div class="comments-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </div>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <div class="comments-pagination">
                <?php paginate_comments_links(); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Komentar ditutup.', 'berita'); ?></p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'         => __('Tinggalkan Komentar', 'berita'),
        'title_reply_to'      => __('Balas %s', 'berita'),
        'cancel_reply_link'   => __('Batal', 'berita'),
        'label_submit'        => __('Kirim Komentar', 'berita'),
        'submit_button'       => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . _x('Komentar', 'noun', 'berita') . '</label><textarea id="comment" name="comment" cols="45" rows="5" required></textarea></p>',
        'must_log_in'         => '<p class="must-log-in">' . sprintf(__('Anda harus <a href="%s">login</a> untuk berkomentar.', 'berita'), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
        'logged_in_as'        => '<p class="logged-in-as">' . sprintf(__('Login sebagai <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out dari akun ini">Log out?</a>', 'berita'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Alamat email Anda tidak akan dipublikasikan.', 'berita') . '</p>',
    ));
    ?>
</div>
