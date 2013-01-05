<?php

function wtwp_echo_constants_table() {
	$all = get_defined_constants(TRUE); // categorized
	$all = $all['user']; // just what we can control
	echo("<table>\n");
	foreach($all as $name => $value) {
		$safe_name = esc_html($name);
		$safe_value = is_array($value) ? "!!array-" . count($value) : 
						is_object($value) ? "!!object-" .get_class($value) :
						is_resource($value) ? "!!resource-" . get_resource_type($value) :
						is_null($value) ? "!!null" :
						is_bool($value) ? "!!bool-" . ($value ? 'TRUE' : 'FALSE') :
						 esc_html($value);
		echo("<tr><td>$safe_name</td><td>$safe_value</td></tr>\n");
	}
	echo("</table>\n");
}

function wtwp_echo_globals_table() {
	echo("<table>\n");
	foreach($GLOBALS as $name => $value) {
		$safe_name = esc_html($name);
		$safe_value = is_array($value) ? "!!array-" . count($value) : 
						is_object($value) ? "!!object-" .get_class($value) :
						is_resource($value) ? "!!resource-" . get_resource_type($value) :
						is_null($value) ? "!!null" :
						is_bool($value) ? "!!bool-" . ($value ? 'TRUE' : 'FALSE') :
						 esc_html($value);
		echo("<tr><td>$safe_name</td><td>$safe_value</td></tr>\n");
	}
	echo("</table>\n");
}
	

function wtwp_add_dashboard_widgets() {
	wp_add_dashboard_widget('wtwp_table_of_constants', 'WTWP Table of Constants', 'wtwp_echo_constants_table');
	wp_add_dashboard_widget('wtwp_table_of_globals', 'WTWP Table of Globals', 'wtwp_echo_globals_table');
}

add_action('wp_dashboard_setup', 'wtwp_add_dashboard_widgets');
