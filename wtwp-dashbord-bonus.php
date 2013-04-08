<?php

function wtwp_ajax_ping() {
	echo("PONG");
	die(); // mandatory :/
}

add_action('wp_ajax_wtwp_ping', 'wtwp_ajax_ping');

function wtwp_echo_array_table($vals) {
	echo("<table>\n");
	foreach($vals as $name => $value) {
		$safe_name = esc_html($name);
		$safe_value = is_array($value) ? "!!array-" . count($value) : 
						is_object($value) ? "!!object-" .get_class($value) :
						is_null($value) ? "!!null" :
						is_bool($value) ? "!!bool-" . ($value ? 'TRUE' : 'FALSE') :
						 esc_html($value);
		echo("<tr><td>$safe_name</td><td>$safe_value</td></tr>\n");
	}
	echo("</table>\n");
}

function wtwp_echo_constants_table() {
	$all = get_defined_constants(TRUE); // categorized
	$all = $all['user']; // just what we can control
	wtwp_echo_array_table($all);
}

function wtwp_echo_globals_table() {
	wtwp_echo_array_table($GLOBALS);
}

function wtwp_echo_subsystem_status() {
	$name = 'wtwp-dummy-transient';
	$value = 'wtwp-dummy-value';
	$status = array();
	$status['transient-set'] = set_transient($name, $value);
	$status['transient-get'] = get_transient($name) == $value;
	$status['transient-delete'] = delete_transient($name);
	$status['option-set'] = update_option($name, $value);
	$status['option-get'] = get_option($name) == $value;
	$status['option-delete'] = delete_option($name);

	foreach($status as &$v) {
		$v = $v ? 'OK' : 'FAIL';
	}

	wtwp_echo_array_table($status);
	echo("admin ajax is <span id='wtwp-ajax-ping'>FAILING</span>");
	echo("<script>
		jQuery(document).ready(function($){
			$.post(ajaxurl, {action: 'wtwp_ping'}, function(response) {
				if(response == 'PONG') {
					$('#wtwp-ajax-ping').text('OK');
				} else {
					alert(response);
				}
			});
		});
	      </script>");
}

function wtwp_add_dashboard_widgets() {
	wp_add_dashboard_widget('wtwp_table_of_status', 'WTWP Subsystem Status', 'wtwp_echo_subsystem_status');
	wp_add_dashboard_widget('wtwp_table_of_constants', 'WTWP Table of Constants', 'wtwp_echo_constants_table');
	wp_add_dashboard_widget('wtwp_table_of_globals', 'WTWP Table of Globals', 'wtwp_echo_globals_table');
}

add_action('wp_dashboard_setup', 'wtwp_add_dashboard_widgets');
