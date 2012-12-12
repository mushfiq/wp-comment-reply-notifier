<?php

/*
  Plugin Name: Wp Comment Reply Notifier
  Plugin URI: http://mushfiq.com
  Description: A simple plugin that will email comment author about comment reply
  Author: Mushfiq
  Author URI: http://mushfiq.com
  Version: 0.0.1
  Text Domain: Email Notifier
  License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function email_author_of_comment($comment_id, $approved) {
    if ($approved) {
        $comment = get_comment($comment_id);
        if ($comment->comment_parent) {
            $parent_comment = get_comment($comment->comment_parent);
            try {
				$site_name = bloginfo('name');
                $headers = sprintf('From: '. $site_name .'Admin <%s>', get_option('admin_email'));
                wp_mail($parent_comment->comment_author_email, $site_name.' Reply', $comment->comment_content, $headers);
            } catch (Exception $e) {
                echo "Error Occured!" . $e->getMessage();
            }
        }
    }
}

add_action('comment_post', 'email_author_of_comment', 10, 2);
?>