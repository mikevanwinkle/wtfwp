<?php

add_action('publish_post', 'wtwp_schedule_repurge', 1);
add_action('wtwp_repurge_post', 'wtwp_repurge_post', 1);

function wtwp_schedule_repurge($post_id) {
	$now = time();
	foreach(range(1, 3) as $minutes) {
		wp_schedule_single_event($now + 60 * $minutes, 'wtwp_repurge_post', array($post_id));
	}
}

function wtwp_repurge_post($post_id) {
	WpeCommon::purge_varnish_cache($post_id);
}
