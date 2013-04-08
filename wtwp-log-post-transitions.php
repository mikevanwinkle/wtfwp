<?php

function wtf_debug_tps($ns, $os, $post) {
	$bigtrace = debug_backtrace();
	$trace = array(); // manually construct trace w/o args for older php 5.3 compat
	foreach($bigtrace as $frame) {
		$trace[] = array($frame['file'], $frame['line'], $frame['function']);
	}
	error_log("WTWP - POST TRANSITION - $post->ID from [$os] to [$ns] at " . print_r($trace,1));
}

add_action('transition_post_status', 'wtf_debug_tps', 0, 3);
?>
