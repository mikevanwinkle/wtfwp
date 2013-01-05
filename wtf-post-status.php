<?php

function wtf_debug_tps($ns, $os, $post) {
	error_log("WTF-DEBUG - TRANSITION - $post->ID from $os to $ns");
	error_log("WTF-DEBUG - TRACE - " . print_r(debug_backtrace(FALSE),1));
}

add_action('transition_post_status', 'wtf_debug_tps', 0, 3);
?>
